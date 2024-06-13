<?php

require_once("/var/www/php/sql/database.php");
require_once("/var/www/php/modele/reservations_modele.php");
require_once("/var/www/getPost.php");

$db = null;

open_database();
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $reservations = reservations_index("2020-01-01", "2100-12-31");
    $reservation_liste = [];
    foreach ($reservations as $reservation) {
        $r = [
            "id" => $reservation['ID_Reservation'],
            "title" => $reservation['nom'],
            "start" => $reservation['DateHeureDebut'],
            "end" => $reservation['DateHeureFin']
        ];
        $reservation_liste[] = $r;
    }
    
    
    echo json_encode( $reservation_liste, JSON_PRETTY_PRINT );
} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    //print_r($_POST);
    $aRequest = getPost();
    if ( $aRequest['type'] == "delete" ) {
        $statut = reservations_delete($aRequest['id']);
        $val = array();
        $val["statut"] = $statut ? 1: 0;
        echo json_encode( $val, JSON_PRETTY_PRINT );
        }
}

close_database();


/*
    {
        "title": "Meeting",
        "start": "2024-04-19T10:30:00+00:00",
        "end": "2024-04-19T12:30:00+00:00"
    },

*/

?>