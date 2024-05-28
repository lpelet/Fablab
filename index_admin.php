<?php

require_once("php/sql/database.php");
require_once("php/modele/session_modele.php");

require_once("php/view/generic_admin_view.php");

$db = null;
open_database();

$titre_page = "FABLAB - Panneau d'administrateur";

$data = [];
$data['menu1_actif'] = " active";
$data['menu2_actif'] = "";
$data['menu3_actif'] = "";
$data['menu4_actif'] = "";


if(check_login() && check_admin()){

    print_r(html_generic_admin($titre_page , "", $data));
    close_database();

}else{
    header("Location: connexion.php");
}


?>