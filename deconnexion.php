<?php

require_once ("php/sql/database.php");
require_once ("php/modele/session_modele.php");

require_once ("php/view/generic_connexion_view.php");
require_once ("php/view/connexion_view.php");
;
$db = null;
open_database();

$titre_page = "FABLAB - déconnexion";

if(check_login() == 1){
    session_destroy();
    print_r(html_generic($titre_page, html_deconnexion()));
}else{

    header("Location: index.php");
}

close_database();

?>