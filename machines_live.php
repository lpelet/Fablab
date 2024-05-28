<?php

require_once("php/sql/database.php");
require_once("php/modele/session_modele.php");

require_once("php/modele/machines_modele.php");
require_once("php/view/machine_live_view.php");
require_once("php/view/generic_admin_view.php");

$db = null;
open_database();

$machines_3d = machines_select_type('imprimante_3d');

$machines_laser = machines_select_type('decoupe_laser');

$titre_page = "FABLAB - Admin panel";

$data = [];
$data['menu1_actif'] = "";
$data['menu2_actif'] = " active";
$data['menu3_actif'] = "";
$data['menu4_actif'] = "";

if(check_login() && check_admin()){

    print_r(html_generic_admin($titre_page ,html_machines($machines_3d, $machines_laser), $data ));
    close_database();

}else{
    header("Location: connexion.php");
}

