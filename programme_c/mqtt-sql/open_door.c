#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>
#include "MQTTClient.h"
#include <mysql/mysql.h>

#define ADDRESS     "tcp://163.5.143.216:8883"
#define CLIENTID    "ExampleClientSub"
#define TOPIC       "portes/porte_entree/uid"
#define QOS         1
#define TIMEOUT     10000L

MYSQL *conn;

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

bool check_uid(MYSQL *conn, const char *uid) {
    char query[256];
    MYSQL_RES *res;
    MYSQL_ROW row;
    FILE *file;
    char dateTime[64];
    time_t now;
    struct tm *timeinfo;
    bool uidFound = false;

    file = fopen("log_file_uid.txt", "a");
    if (file == NULL) {
        perror("Erreur lors de l'ouverture du fichier");
        return uidFound;
    }

    time(&now);
    timeinfo = localtime(&now);
    strftime(dateTime, sizeof(dateTime), "%d-%m-%Y %H:%M:%S", timeinfo);

    snprintf(query, sizeof(query), "SELECT ID_Utilisateur, Prenom, Nom, Email, uid_rfid FROM Utilisateurs WHERE uid_rfid='%s'", uid);
    if (mysql_query(conn, query)) {
        fprintf(stderr, "Erreur de requête: %s\n", mysql_error(conn));
        fclose(file);
        return uidFound;
    }

    res = mysql_store_result(conn);
    if (res == NULL) {
        fprintf(stderr, "Erreur de récupération du résultat: %s\n", mysql_error(conn));
        fclose(file);
        return uidFound;
    }

    if (mysql_num_rows(res) > 0) {
        uidFound = true;
        while ((row = mysql_fetch_row(res))) {
            fprintf(file, "Date: %s - ID_Utilisateur: %s, Prenom: %s, Nom: %s, Email: %s, Uid: %s\n", dateTime, row[0], row[1], row[2], row[3], row[4]);
            printf("Date: %s - ID_Utilisateur: %s, Prenom: %s, Nom: %s, Email: %s, Uid: %s\n", dateTime, row[0], row[1], row[2], row[3], row[4]);
        }
    } else {
        fprintf(file, "Date: %s - Aucun utilisateur trouvé avec l'UID %s\n", dateTime, uid);
        printf("Date: %s - Aucun utilisateur trouvé avec l'UID %s\n", dateTime, uid);
    }

    mysql_free_result(res);
    fclose(file);
    return uidFound;
}


volatile MQTTClient_deliveryToken deliveredtoken;

void delivered(void *context, MQTTClient_deliveryToken dt) {
    printf("Message with token value %d delivery confirmed\n", dt);
    deliveredtoken = dt;
}

void send_message(const char *payload, const char *topic) {
    MQTTClient client;
    MQTTClient_message pubmsg = MQTTClient_message_initializer;
    MQTTClient_deliveryToken token;

    MQTTClient_create(&client, ADDRESS, CLIENTID, MQTTCLIENT_PERSISTENCE_NONE, NULL);
    pubmsg.payload = (void*) payload;
    pubmsg.payloadlen = strlen(payload);
    pubmsg.qos = QOS;
    pubmsg.retained = 0;

    MQTTClient_publishMessage(client, topic, &pubmsg, &token);
    MQTTClient_waitForCompletion(client, token, TIMEOUT);
    MQTTClient_disconnect(client, 10000);
    MQTTClient_destroy(&client);
}

int msgarrvd(void *context, char *topicName, int topicLen, MQTTClient_message *message) {
    char *uid = strndup((char*)message->payload, message->payloadlen);
    printf("Message arrived with UID: %s\n", uid);
    
    if (check_uid(conn, uid)) {
        send_message("on", "portes/porte_entree/ventouse_status");
        printf("\non");
    }
    
    free(uid);
    MQTTClient_freeMessage(&message);
    MQTTClient_free(topicName);
    return 1;
}


void connlost(void *context, char *cause) {
    printf("\nConnection lost\n");
    printf("     cause: %s\n", cause);
}


int main(int argc, char* argv[]) {
    connect_db();

    MQTTClient client;
    MQTTClient_connectOptions conn_opts = MQTTClient_connectOptions_initializer;
    int rc;

    MQTTClient_create(&client, ADDRESS, CLIENTID, MQTTCLIENT_PERSISTENCE_NONE, NULL);
    conn_opts.keepAliveInterval = 20;
    conn_opts.cleansession = 1;

    MQTTClient_setCallbacks(client, NULL, connlost, msgarrvd, delivered);

    if ((rc = MQTTClient_connect(client, &conn_opts)) != MQTTCLIENT_SUCCESS) {
        printf("Failed to connect, return code %d\n", rc);
        exit(EXIT_FAILURE);
    }

    printf("Subscribing to topic %s for client %s using QoS%d\n\n", TOPIC, CLIENTID, QOS);
    MQTTClient_subscribe(client, TOPIC, QOS);

    getchar();

    MQTTClient_disconnect(client, 10000);
    MQTTClient_destroy(&client);

    disconnect_db();

    return 0;
}
