<?php
// SQL statement to update the uid_rfid of a user
define("SQL_UPDATE_UID_RFID", "UPDATE `Utilisateurs` SET `uid_rfid` = :uidRfid WHERE `ID_Utilisateur` = :userId");

try {
    // Database connection setup
    $db = new PDO('mysql:host=localhost;dbname=fablab', 'fablab', 'fablab');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_utilisateur']) && isset($_POST['uid_rfid'])) {
    $userId = $_POST['id_utilisateur'];
    $uidRfid = $_POST['uid_rfid'];

    // Prepare the SQL statement
    $stmt = $db->prepare(SQL_UPDATE_UID_RFID);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':uidRfid', $uidRfid, PDO::PARAM_STR);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to the user management page or display a success message
        header("Location: /gestion_utilisateur.php?success=1");
        exit;
    } else {
        // Optionally handle the error more gracefully
        die("Erreur lors de la mise à jour de l'UID RFID.");
    }
}
?>
