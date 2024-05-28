<?php

require_once ("php/modele/session_modele.php");
require_once("php/modele/session_modele.php");
require_once("php/view/index_view.php");
require_once("php/view/generic_view.php");

$db = null;

if(check_login()){

    print_r(html_generic("Accueil", html_accueil()));
    close_database();

}else{
    header("Location: connexion.php");
}


?>