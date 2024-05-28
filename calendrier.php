<?php
require_once("php/sql/database.php");
require_once("php/view/generic_view.php");
require_once("php/view/planning_view.php");
require_once("php/modele/session_modele.php");

$db = null;
open_database();
//
close_database();

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


if(check_login()){

    echo html_generic($titre_page, html_planning([]),  $script_calendrier, $data);

}else{
    header("Location: connexion.php");
}

?>