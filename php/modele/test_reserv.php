<?php
require_once("/var/www/fablab/php/sql/database.php");
require_once("/var/www/fablab/php/modele/reservations_modele.php");

$db = null;
open_database();

$reservation['id_reservation'] = 13;
$reservation['date_debut'] = '2024-05-30T13:40:00.000Z';
$reservation['date_fin'] = '2024-05-30T14:00:00.000Z';

$data['modif'] = reservations_modification($reservation);
