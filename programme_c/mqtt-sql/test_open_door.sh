#!/bin/bash

# Adresse et port du broker MQTT
BROKER_ADDRESS="163.5.143.216"
BROKER_PORT="8883"

# Détails de connexion MQTT (ajoutez des options de sécurité selon les besoins, comme les certificats TLS)
MQTT_TOPIC="portes/porte_entree"
MQTT_CLIENT_ID="bash_publisher"
BADGES_MAUVAIS='123456789'
BADGES_OK='218B365F'

# Boucle infinie pour envoyer le message toutes les 5 secondes
while true
do
    mosquitto_pub -h $BROKER_ADDRESS -p $BROKER_PORT -t $MQTT_TOPIC -m "{uid : $BADGES_MAUVAIS, status_ventouse : "OFF"}" -i $MQTT_CLIENT_ID
    sleep 5
    mosquitto_pub -h $BROKER_ADDRESS -p $BROKER_PORT -t $MQTT_TOPIC -m "{uid : $BADGES_OK, status_ventouse : "OFF"}" -i $MQTT_CLIENT_ID
    sleep 5
done
