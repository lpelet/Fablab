<?php

require_once("/var/www/php/sql/database.php");
require_once("/var/www/php/modele/reservations_modele.php");

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
    $val = array();
    $val["result"] = "hello wordl";
    echo json_encode( $aRequest, JSON_PRETTY_PRINT );
    //exit(0);
}

//print_r($reservations);
close_database();


function getPost()
{
    /*
    if(!empty($_POST)) {
        // when using application/x-www-form-urlencoded or multipart/form-data as the HTTP Content-Type in the request
        // NOTE: if this is the case and $_POST is empty, check the variables_order in php.ini! - it must contain the letter P
        return $_POST;
    }*/

    // when using application/json as the HTTP Content-Type in the request 
    $post = json_decode(file_get_contents('php://input'), true);
    if(json_last_error() == JSON_ERROR_NONE) {
        return $post;
    }

    return [];
}
/*
    {
        "title": "Meeting",
        "start": "2024-04-19T10:30:00+00:00",
        "end": "2024-04-19T12:30:00+00:00"
    },

*/

