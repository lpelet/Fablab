<?php

try {
    $db = new PDO('mysql:host=localhost;dbname=fablab', 'fablab', 'fablab');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

function ticket_insert($value_email, $value_titre, $value_description)
{
    global $db;

    $data = [
        'email' => $value_email,
        'titre' => $value_titre,
        'description' => $value_description,
        'date_ouverture' => date("d-m-Y"),
        'status' => "En cours"
    ];

    $stmt = $db->prepare("INSERT INTO ticket (email, titre, description, date_ouverture, status) VALUES (:email, :titre, :description, :date_ouverture, :status)");
    $stmt->execute($data);

    header("Location: ticket_user.php");
}

// Appel de la fonction avec les données POST
if (isset($_POST['email'], $_POST['titre'], $_POST['description'])) {
    ticket_insert($_POST['email'], $_POST['titre'], $_POST['description']);
}
?>
