<?php

require_once("php/sql/database.php");
require_once("php/modele/session_modele.php");// Ajouter

require_once("php/view/ticket_user_view.php");
require_once("php/view/generic_view.php"); // changer pour generic page
require_once("php/modele/form_insert_ticket.php");



$db = null;
open_database();

$titre_page = "FABLAB - Demande d'aide";

$data = [];
$data['menu1_actif'] = "";
$data['menu2_actif'] = "";
$data['menu3_actif'] = "";
$data['menu4_actif'] = "";
$data['menu5_actif'] = "";
$data['menu6_actif'] = "active";

if(check_login()){

    print_r(html_generic($titre_page ,html_ticket_user(),"",$data));
    close_database();

}else{
    header("Location: connexion.php");
}


?>