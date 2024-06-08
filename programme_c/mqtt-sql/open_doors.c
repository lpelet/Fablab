#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "MQTTClient.h"

#define ADDRESS     "tcp://163.5.143.216:8883"
#define CLIENTID    "ExampleClient"
#define TOPIC       "ecoute"
#define PAYLOAD     "oui"
#define QOS         1
#define TIMEOUT     10000L

void delivered(void *context, MQTTClient_deliveryToken dt) {
    printf("Message with token value %d delivery confirmed\n", dt);
}

int msgarrvd(void *context, char *topicName, int topicLen, MQTTClient_message *message) {
    char* payloadptr;

    printf("Message arrived\n");
    printf("     topic: %s\n", topicName);
    printf("   message: ");

    payloadptr = message->payload;
    if (strcmp(payloadptr, "1") == 0) {
        // Envoyer le message "oui" sur le topic "envoie"
        MQTTClient client = (MQTTClient)context;
        MQTTClient_message pubmsg = MQTTClient_message_initializer;
        pubmsg.payload = PAYLOAD;
        pubmsg.payloadlen = strlen(PAYLOAD);
        pubmsg.qos = QOS;
        pubmsg.retained = 0;
        MQTTClient_deliveryToken token;
        MQTTClient_publishMessage(client, "envoie", &pubmsg, &token);
        printf("Waiting for up to %ld seconds for publication of %s\n"
               "on topic %s for client with ClientID: %s\n",
               TIMEOUT/1000, PAYLOAD, "envoie", CLIENTID);
        MQTTClient_waitForCompletion(client, token, TIMEOUT);
        printf("Message 'oui' sent\n");
    } else {
        printf("%s\n", payloadptr);
    }

    MQTTClient_freeMessage(&message);
    MQTTClient_free(topicName);
    return 1;
}

void connlost(void *context, char *cause) {
    printf("\nConnection lost\n");
    printf("     cause: %s\n", cause);
}

int main(int argc, char* argv[]) {
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
           "Press Q<Enter> to quit\n", TOPIC, CLIENTID, QOS);
    MQTTClient_subscribe(client, TOPIC, QOS);

    // Attendre l'input utilisateur pour terminer
    do {
        char c = getchar();
        if (c == 'Q' || c == 'q') break;
    } while(1);

    MQTTClient_disconnect(client, 10000);
    MQTTClient_destroy(&client);
    return rc;
}
