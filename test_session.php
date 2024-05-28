<?php

require_once ("php/sql/database.php");
require_once ("php/modele/session_modele.php");

$db = null;
open_database();

$titre_page = "FABLAB - Connexion";



echo check_admin();
echo "<br>";
echo check_login();

$data_user = user_info();

echo "<br> id : ". $data_user['id'];
echo "<br> nom : ".$data_user['nom'];
echo "<br> prenom : ".$data_user['prenom'];
echo "<br> role : ".$data_user['role'];


echo "<br><br>  save path : ". session_save_path();
echo "<br><br>  login check : ". check_login();
echo "<br><br>  admin check : ". check_admin();


close_database();

?>