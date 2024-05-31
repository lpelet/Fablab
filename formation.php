<?php
require_once("php/view/generic_view.php");
require_once("php/view/formation_view.php");
require_once("php/modele/session_modele.php");
require_once("php/sql/database.php");

$titre_page = "FABLAB - Forum";

$data = [];
$data['menu1_actif'] = "";
$data['menu2_actif'] = " active";
$data['menu3_actif'] = "";
$data['menu4_actif'] = "";
$data['menu5_actif'] = "";
$data['menu6_actif'] = "";

if (check_login()) {
    echo html_generic($titre_page, html_chat(), "", $data);
} else {
    header("Location: connexion.php");
}
?>
