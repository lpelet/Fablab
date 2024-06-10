#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "MQTTClient.h"
#include <mysql/mysql.h>
#include <time.h>

#define ADDRESS     "tcp://163.5.143.216:8883"
#define CLIENTID    "ExampleClient"
#define TOPIC       "portes/porte_entree"
#define TOPIC_DEBUG      "portes/porte_entree_debug"
#define TOPIC_MACHINE "machines/imprimante_3D_1"
#define QOS         1
#define TIMEOUT     3000L

void delivered(void *context, MQTTClient_deliveryToken dt);
int msgarrvd(void *context, char *topicName, int topicLen, MQTTClient_message *message);
void connlost(void *context, char *cause);
void connect_db();
void disconnect_db();
bool check_uid_and_reservation(MYSQL *conn, const char *uid, char *duration);

MYSQL *conn;

void delivered(void *context, MQTTClient_deliveryToken dt) {
    printf("Message with token value %d delivery confirmed\n", dt);
}

int msgarrvd(void *context, char *topicName, int topicLen, MQTTClient_message *message) {
    char* payloadptr = message->payload;
    char reservationDuration[16] = {0};  // Holds the reservation duration

    printf("\n\n     topic: %s\n", topicName);
    printf("   message: %s\n", payloadptr);

    MQTTClient client = (MQTTClient)context;
    MQTTClient_message pubmsg = MQTTClient_message_initializer;
    MQTTClient_deliveryToken token;

    if (check_uid_and_reservation(conn, payloadptr, reservationDuration)) {
        pubmsg.payload = "oui";
        pubmsg.payloadlen = strlen(pubmsg.payload);
        MQTTClient_publishMessage(client, TOPIC_DEBUG, &pubmsg, &token);
        MQTTClient_waitForCompletion(client, token, TIMEOUT);

        // Send the machine data if the reservation is valid
        char machineMsg[256];
        snprintf(machineMsg, sizeof(machineMsg), "{\n\"status\": \"on\",\n\"temps\": \"%s\"\n}", reservationDuration);
        pubmsg.payload = machineMsg;
        pubmsg.payloadlen = strlen(machineMsg);
        MQTTClient_publishMessage(client, TOPIC_MACHINE, &pubmsg, &token);
        MQTTClient_waitForCompletion(client, token, TIMEOUT);
    } else {
        pubmsg.payload = "non";
        pubmsg.payloadlen = strlen(pubmsg.payload);
        MQTTClient_publishMessage(client, TOPIC_DEBUG, &pubmsg, &token);
        MQTTClient_waitForCompletion(client, token, TIMEOUT);
    }

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

bool check_uid_and_reservation(MYSQL *conn, const char *uid, char *duration) {
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
        perror("Error opening file");
        return false;
    }

    time(&now);
    timeinfo = localtime(&now);
    strftime(dateTime, sizeof(dateTime), "%Y-%m-%d %H:%M:%S", timeinfo);

    snprintf(query, sizeof(query), 
        "SELECT U.ID_Utilisateur, U.Prenom, U.Nom, U.Email, U.uid_rfid, R.DateHeureDebut, R.DateHeureFin "
        "FROM Utilisateurs U JOIN Reservations R ON U.ID_Utilisateur = R.ID_Utilisateur "
        "WHERE U.uid_rfid='%s' AND '%s' BETWEEN R.DateHeureDebut AND R.DateHeureFin", uid, dateTime);

    if (mysql_query(conn, query)) {
        fprintf(stderr, "Query Error: %s\n", mysql_error(conn));
        fclose(file);
        return false;
    }

    res = mysql_store_result(conn);
    if (res == NULL) {
        fprintf(stderr, "Result retrieval error: %s\n", mysql_error(conn));
        fclose(file);
        return false;
    }

    if (mysql_num_rows(res) > 0) {
        reservationValid = true;
        while ((row = mysql_fetch_row(res))) {
            fprintf(file, "Date: %s - ID_Utilisateur: %s, Prenom: %s, Nom: %s, Email: %s, Uid: %s, Heure de début: %s, Heure de fin: %s\n", 
                    dateTime, row[0], row[1], row[2], row[3], row[4], row[5], row[6]);
            printf("Date: %s - ID_Utilisateur: %s, Prenom: %s, Nom: %s, Email: %s, Uid: %s, Heure de début: %s, Heure de fin: %s\n", 
                   dateTime, row[0], row[1], row[2], row[3], row[4], row[5], row[6]);

            // Convert times and calculate duration
            struct tm start_tm, end_tm;
            strptime(row[5], "%Y-%m-%d %H:%M:%S", &start_tm);
            strptime(row[6], "%Y-%m-%d %H:%M:%S", &end_tm);
            time_t start_time = mktime(&start_tm);
            time_t end_time = mktime(&end_tm);
            int seconds = difftime(end_time, start_time);
            sprintf(duration, "%02d:%02d:%02d", abs(seconds) / 3600, (abs(seconds) % 3600) / 60, abs(seconds) % 60);
        }
    } else {
        fprintf(file, "Date: %s - Aucune réservation valide trouvée pour l'UID %s\n", dateTime, uid);
        printf("Date: %s - Aucune réservation valide trouvée pour l'UID %s\n", dateTime, uid);
        sprintf(duration, "00:00:01");  // Set default minimal duration
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
