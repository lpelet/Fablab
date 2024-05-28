<?php
define("SQL_CLOSE_TICKET", "UPDATE `ticket` SET `status` = 'Cloturé' WHERE `id` = :ticketId");

try {
    $db = new PDO('mysql:host=localhost;dbname=fablab', 'fablab', 'fablab');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ticket_id'])) {
    $ticketId = $_POST['ticket_id'];

    $stmt = $db->prepare(SQL_CLOSE_TICKET);
    $stmt->bindParam(':ticketId', $ticketId, PDO::PARAM_STR);

    $stmt->execute();

    // No need to fetch data after an UPDATE statement
    header("Location: /ticket_admin.php");
    exit;  // Ensure the script stops here
}
?>
