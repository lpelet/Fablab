#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <mysql/mysql.h>
#include "MQTTClient.h"

#define ADDRESS     "tcp://163.5.143.216:8883"
#define CLIENTID    "ExampleClientSub"
#define TOPIC       "/imprimante_1/"
#define QOS         1
#define TIMEOUT     10000L

volatile MQTTClient_deliveryToken deliveredtoken;

void delivered(void *context, MQTTClient_deliveryToken dt) {
    printf("Message with token value %d delivery confirmed\n", dt);
    deliveredtoken = dt;
}

int msgarrvd(void *context, char *topicName, int topicLen, MQTTClient_message *message) {
    printf("Message arrived\n");
    printf("     topic: %s\n", topicName);
    printf("   message: %.*s\n", message->payloadlen, (char*)message->payload);
    MQTTClient_freeMessage(&message);
    MQTTClient_free(topicName);
    return 1;
}

void connlost(void *context, char *cause) {
    printf("\nConnection lost\n");
    printf("     cause: %s\n", cause);
}

//sql

void updateStatut(MYSQL *conn, int idEquipement, const char *nouveauStatut) {
    char query[256];
    // Préparation de la requête SQL
    snprintf(query, sizeof(query), "UPDATE Equipements SET statut='%s' WHERE ID_Equipement=%d", nouveauStatut, idEquipement);
    
    // Exécution de la requête UPDATE
    if (mysql_query(conn, query)) {
        fprintf(stderr, "%s\n", mysql_error(conn));
        exit(1);
    }
    
    printf("Statut de l'équipement ID %d mis à jour en '%s'.\n", idEquipement, nouveauStatut);
}


int main(int argc, char* argv[]) {
    MQTTClient client;
    MQTTClient_connectOptions conn_opts = MQTTClient_connectOptions_initializer;
    int rc;
    int ch;

    MYSQL *conn;
    char *server = "localhost";
    char *user = "fablab";
    char *password = "fablab"; // Modifiez selon votre configuration
    char *database = "fablab";

    conn = mysql_init(NULL);

    // Connexion à la base de données
    if (!mysql_real_connect(conn, server, user, password, database, 0, NULL, 0)) {
        fprintf(stderr, "%s\n", mysql_error(conn));
        exit(1);
    }

    MQTTClient_create(&client, ADDRESS, CLIENTID,
        MQTTCLIENT_PERSISTENCE_NONE, NULL);
    conn_opts.keepAliveInterval = 20;
    conn_opts.cleansession = 1;

    MQTTClient_setCallbacks(client, NULL, connlost, msgarrvd, delivered);

    if ((rc = MQTTClient_connect(client, &conn_opts)) != MQTTCLIENT_SUCCESS) {
        printf("Failed to connect, return code %d\n", rc);
        exit(EXIT_FAILURE);
    }

    printf("Subscribing to topic %s for client %s using QoS%d\n\n", TOPIC, CLIENTID, QOS);
    MQTTClient_subscribe(client, TOPIC, QOS);

    // Appel de la fonction de mise à jour
    updateStatut(conn, 2, "on");

    do {
        ch = getchar();
    } while(ch!='Q' && ch != 'q');

    MQTTClient_disconnect(client, 10000);
    MQTTClient_destroy(&client);

    // Fermeture de la connexion
    mysql_close(conn);

    return 0;
}
