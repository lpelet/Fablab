<?php
session_start();
require 'database_connection.php'; // Assurez-vous que ce fichier contient la connexion à votre BDD

if (!empty($_POST['message']) && isset($_SESSION['user_id'])) {
    $message = strip_tags($_POST['message']); // Nettoyage basique contre les attaques XSS
    $user_id = $_SESSION['user_id']; // Assurez-vous que l'utilisateur est connecté

    $stmt = $pdo->prepare("INSERT INTO messages (user_id, message) VALUES (?, ?)");
    $stmt->execute([$user_id, $message]);
}
?>
