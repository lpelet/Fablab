<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("php/sql/database.php");
require_once("php/modele/session_modele.php");

require_once("php/view/ticket_admin_view.php");
require_once("php/view/generic_admin_view.php"); 
require_once("php/modele/ticket_admin_modele.php");


$db = null;
open_database();

$titre_page = "FABLAB - Ticket";

$data = [];
$data['menu1_actif'] = "";
$data['menu2_actif'] = "";
$data['menu3_actif'] = " active";
$data['menu4_actif'] = "";


if(check_login() && check_admin()){

    print_r(html_generic_admin($titre_page ,html_ticket_admin(ticket_select_status("En cours")), $data ));
    close_database();

}else{
    header("Location: connexion.php");
}



?>