<?php

require_once("php/sql/database.php");
require_once("php/view/generic_connexion_view.php");
require_once("php/view/inscription_view.php");

$db = null;
open_database();

$titre_page = "FABLAB - Inscription";

print_r(html_generic($titre_page , html_connexion()));
close_database();

?>