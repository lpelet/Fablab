<?php
require_once("php/sql/database.php");
require_once("php/view/generic_view.php");
require_once("php/view/planning_view.php");
require_once("php/modele/session_modele.php");
require_once("php/modele/reservations_modele.php");
require_once("/var/www/fablab/getPost.php");


$db = null;
open_database();


$titre_page = "FABLAB - Planning";

$data = [];
$data['menu1_actif'] = "";
$data['menu2_actif'] = " active";
$data['menu3_actif'] = "";
$data['menu4_actif'] = "";
$data['menu5_actif'] = "";
$data['menu6_actif'] = "";

$time_now = time();
$script_calendrier  = '
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/calendrier.js?v='.$time_now.'"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>';

if (check_login()) {
    $data['modif'] = null;
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $aRequest = getPost();
        
        $reservation['id_reservation'] = $aRequest['id'];
        $reservation['date_debut'] = $aRequest['start'];
        $reservation['date_fin'] = $aRequest['end'];

//        $data['modif'] = reservations_modif($reservation);
        $data['modif'] = reservations_modification($reservation);

        // Préparer et retourner la réponse
        $data = array();
        $data['status'] ='OK';
        print(json_encode($data, JSON_PRETTY_PRINT));

        exit(0);
    }

    // Afficher la page si l'utilisateur est connecté et si la méthode n'est pas PUT
    echo html_generic($titre_page, html_planning([]), $script_calendrier, $data);
} else {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: connexion.php");
}

close_database();
