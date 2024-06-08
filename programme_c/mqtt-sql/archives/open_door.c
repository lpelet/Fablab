#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "MQTTClient.h"
#include <mysql/mysql.h>
#include <time.h>

#define ADDRESS     "tcp://163.5.143.216:8883"
#define CLIENTID    "ExampleClient"
#define TOPIC       "portes/porte_entree"
#define TOPIC_PUB      "portes/porte_entree_reponse"
#define QOS         1
#define TIMEOUT     3000L

// Déclarations de toutes les fonctions utilisées
void delivered(void *context, MQTTClient_deliveryToken dt);
int msgarrvd(void *context, char *topicName, int topicLen, MQTTClient_message *message);
void connlost(void *context, char *cause);
void connect_db();
void disconnect_db();
bool check_uid_and_reservation(MYSQL *conn, const char *uid); // Prototype de la fonction check_uid

MYSQL *conn;

void delivered(void *context, MQTTClient_deliveryToken dt) {
    printf("Message with token value %d delivery confirmed\n", dt);
}

int msgarrvd(void *context, char *topicName, int topicLen, MQTTClient_message *message) {
    char* payloadptr = message->payload;
    printf("\n\n     topic: %s\n", topicName);
    printf("   message: %s\n", payloadptr);

    MQTTClient client = (MQTTClient)context;
    MQTTClient_message pubmsg = MQTTClient_message_initializer;
    MQTTClient_deliveryToken token;

    if (check_uid_and_reservation(conn, payloadptr)) {
        // Si l'UID correspond à une réservation valide, envoyer "oui"
        pubmsg.payload = "oui"; // PAYLOAD est défini à "oui"
    } else {
        // Sinon, envoyer "non"
        pubmsg.payload = "non";
    }
    pubmsg.payloadlen = strlen(pubmsg.payload);
    pubmsg.qos = QOS;
    pubmsg.retained = 0;

    MQTTClient_publishMessage(client, TOPIC_PUB, &pubmsg, &token); // Assurez-vous que TOPIC_PUB est défini correctement
    MQTTClient_waitForCompletion(client, token, TIMEOUT);

    MQTTClient_freeMessage(&message);
    MQTTClient_free(topicName);
    return 1;
}


void connlost(void *context, char *cause) {
    printf("\nConnection lost\n");
    printf("     cause: %s\n", cause);
}

void connect_db() {
    char *server = "localhost";
    char *user = "fablab";
    char *password = "fablab";
    char *database = "fablab";

    conn = mysql_init(NULL);
    if (!mysql_real_connect(conn, server, user, password, database, 0, NULL, 0)) {
        fprintf(stderr, "Connection failed: %s\n", mysql_error(conn));
        exit(1);
    }
}

void disconnect_db() {
    mysql_close(conn);
}

bool check_uid_and_reservation(MYSQL *conn, const char *uid) {
    char query[512];
    MYSQL_RES *res;
    MYSQL_ROW row;
    FILE *file;
    char dateTime[64];
    time_t now;
    struct tm *timeinfo;
    bool reservationValid = false;

    file = fopen("log_file_uid.txt", "a");
    if (file == NULL) {
        perror("Erreur lors de l'ouverture du fichier");
        return reservationValid;
    }

    time(&now);
    timeinfo = localtime(&now);
    strftime(dateTime, sizeof(dateTime), "%Y-%m-%d %H:%M:%S", timeinfo);

    // Joindre les tables Utilisateurs et Reservations et filtrer par uid_rfid et l'heure actuelle
    snprintf(query, sizeof(query), 
        "SELECT U.ID_Utilisateur, U.Prenom, U.Nom, U.Email, U.uid_rfid, R.DateHeureDebut, R.DateHeureFin "
        "FROM Utilisateurs U JOIN Reservations R ON U.ID_Utilisateur = R.ID_Utilisateur "
        "WHERE U.uid_rfid='%s' AND '%s' BETWEEN R.DateHeureDebut AND R.DateHeureFin", uid, dateTime);

    if (mysql_query(conn, query)) {
        fprintf(stderr, "Erreur de requête: %s\n", mysql_error(conn));
        fclose(file);
        return reservationValid;
    }

    res = mysql_store_result(conn);
    if (res == NULL) {
        fprintf(stderr, "Erreur de récupération du résultat: %s\n", mysql_error(conn));
        fclose(file);
        return reservationValid;
    }

    if (mysql_num_rows(res) > 0) {
        reservationValid = true;
        while ((row = mysql_fetch_row(res))) {
            fprintf(file, "Date: %s - ID_Utilisateur: %s, Prenom: %s, Nom: %s, Email: %s, Uid: %s, Heure de début: %s, Heure de fin: %s\n", 
                    dateTime, row[0], row[1], row[2], row[3], row[4], row[5], row[6]);
            printf("Date: %s - ID_Utilisateur: %s, Prenom: %s, Nom: %s, Email: %s, Uid: %s, Heure de début: %s, Heure de fin: %s\n", 
                   dateTime, row[0], row[1], row[2], row[3], row[4], row[5], row[6]);
        }
    } else {
        fprintf(file, "Date: %s - Aucune réservation valide trouvée pour l'UID %s\n", dateTime, uid);
        printf("Date: %s - Aucune réservation valide trouvée pour l'UID %s\n", dateTime, uid);
    }

    mysql_free_result(res);
    fclose(file);
    return reservationValid;
}


int main(int argc, char* argv[]) {
    connect_db();

    MQTTClient client;
    MQTTClient_connectOptions conn_opts = MQTTClient_connectOptions_initializer;
    int rc;

    MQTTClient_create(&client, ADDRESS, CLIENTID,
        MQTTCLIENT_PERSISTENCE_NONE, NULL);
    conn_opts.keepAliveInterval = 20;
    conn_opts.cleansession = 1;

    MQTTClient_setCallbacks(client, client, connlost, msgarrvd, delivered);

    if ((rc = MQTTClient_connect(client, &conn_opts)) != MQTTCLIENT_SUCCESS) {
        printf("Failed to connect, return code %d\n", rc);
        exit(EXIT_FAILURE);
    }

    printf("Subscribing to topic %s for client %s using QoS%d\n"
           "Press Q<Enter) to quit\n", TOPIC, CLIENTID, QOS);
    MQTTClient_subscribe(client, TOPIC, QOS);

    // Attendre l'input utilisateur pour terminer
    do {
        char c = getchar();
        if (c == 'Q' || c == 'q') break;
    } while(1);

    MQTTClient_disconnect(client, 10000);
    MQTTClient_destroy(&client);
    disconnect_db();
    return 0;
}
