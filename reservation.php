<?php
require_once("php/sql/database.php");
require_once("php/view/generic_view.php");
require_once("php/view/reservation_view.php");
require_once("php/modele/reservations_modele.php");
require_once("php/modele/session_modele.php");// Ajouter

//$db = fablab;
open_database();

//if($_SERVER["REQUEST_METHOD"] == "POST") {
    //Récupérer et échapper les données
//    $date = real_escape_string($_POST['date']);
//    $equipements = real_escape_string($_POST['nom']);

    //Préparer et exécuter la requête d'insertion
//    $sql = "INSERT INTO Equipements ('date', nom) VALUES ('$nom', '$nom')";
//}

$titre_page = "FABLAB - Réservation";

$data = [];
$data['menu1_actif'] = "";
$data['menu2_actif'] = " active";
$data['menu3_actif'] = "";
$data['menu4_actif'] = "";
$data['menu5_actif'] = "";
$data['menu6_actif'] = "";

if(check_login()){
    $data['flag_reservation_add'] = null;
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $reservation['id_utilisateur'] = $_SESSION['user_id'];
        $reservation['id_equipement'] = $_POST['Equipements'];
        $reservation['date_debut'] = $_POST['dateDebut'];
        $reservation['date_fin'] = $_POST['dateFin'];
        $reservation['status_reservation'] = "Confirmée";
    
        $data['flag_reservation_add'] = reservations_add($reservation);
    }
    echo html_generic($titre_page, html_reservation($data));

}else{
    header("Location: connexion.php");
}

close_database();
