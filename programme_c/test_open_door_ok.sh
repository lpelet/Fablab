#!/bin/bash

# Adresse et port du broker MQTT
BROKER_ADDRESS="163.5.143.216"
BROKER_PORT="8883"

# Détails de connexion MQTT (ajoutez des options de sécurité selon les besoins, comme les certificats TLS)
MQTT_TOPIC_UID="portes/porte_entree/uid_rfid"
MQTT_TOPIC_STATUS="portes/porte_entree/statut"
MQTT_CLIENT_ID="bash_publisher"
BADGES_OK='	77A53F40'

# Boucle infinie pour envoyer le message toutes les 5 secondes
while true
do
    mosquitto_pub -h $BROKER_ADDRESS -p $BROKER_PORT -t $MQTT_TOPIC_UID -m "{uid_rfid : $BADGES_OK}" -i $MQTT_CLIENT_ID
    sleep 15
done
