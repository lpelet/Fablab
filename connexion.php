<?php

require_once ("php/sql/database.php");
require_once ("php/modele/session_modele.php");
require_once ("php/view/generic_connexion_view.php");
require_once ("php/view/connexion_view.php");
require_once ("php/modele/utilisateur_modele.php");

$db = null;
open_database();

$titre_page = "FABLAB - Connexion";

if(check_login() == 1){
    header("Location: index.php");
}else{
    print_r(html_generic($titre_page, html_connexion()));
}



close_database();

?>