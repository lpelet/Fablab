<?php
session_start();
require 'database_connection.php'; // Assurez-vous que ce fichier contient la connexion à votre BDD

$stmt = $pdo->query("SELECT message FROM messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($messages as $message) {
    echo "<div>" . htmlspecialchars($message['message']) . "</div>";
}
?>
