<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Aucune connexion a la base de données

function ticket_insert($value_email, $value_titre, $value_description)
{
    global $db;

    $data = [

        'email' => $value_email,
        'titre' => $value_titre,
        'description' => $value_description,
        'date_ouverture' => date("Y-m-d"),
        'status' => "En cours"
    ];

    $stmt = $db->prepare("INSERT INTO ticket (email, titre, description, date_ouverture, status) VALUES (:email, :titre, :description, :date_ouverture, :status)");
    $stmt->execute($data);


    echo "Demande enregistrée avec succès!";
}

ticket_insert($_POST['email'], $_POST['titre'], $_POST['description']);

?>

