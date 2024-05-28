<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("php/sql/database.php");
require_once("php/modele/session_modele.php");

require_once("php/view/generic_admin_view.php"); 
require_once("php/view/gestion_utilisateur.php");

require_once("php/modele/gestion_utilisateur.php");


$db = null;
open_database();

$titre_page = "FABLAB - Gestion des utilisateurs";

$data = [];
$data['menu1_actif'] = "";
$data['menu2_actif'] = "";
$data['menu3_actif'] = "";
$data['menu4_actif'] = " active";


if(check_login() && check_admin()){

    print_r(html_generic_admin($titre_page ,html_gestion_utlisateur(user_table("Etudiant")), $data ));
    close_database();

}else{
    header("Location: connexion.php");
}



?>