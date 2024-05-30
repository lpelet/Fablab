<?php

define("SQL_RESERVATIONS_INDEX", "
    SELECT 
        r.ID_Reservation,
        r.ID_Equipement,
        r.DateHeureDebut,
        r.DateHeureFin,
        e.nom
    FROM `Reservations` r
    JOIN Equipements e 
        ON r.ID_Equipement = e.ID_Equipement
    WHERE 
        r.StatutReservation = 'Confirmée'
    
");

define("SQL_RESERVATIONS_ADD", "
    INSERT INTO Reservations
    (ID_Utilisateur, ID_Equipement, DateHeureDebut, DateHeureFin, StatutReservation)
    VALUES (:id_utilisateur, :id_equipement, :date_debut, :date_fin, :status_reservation);
");

define("SQL_RESERVATIONS_DELETE", "
    DELETE FROM Reservations
    WHERE ID_Reservation = :id_reservation;
");

function reservations_index($date_debut, $date_fin)
{
    global $db;

    $stmt = $db->prepare(SQL_RESERVATIONS_INDEX);
    //$stmt->bindParam(':type_mac', $type_machine, PDO::PARAM_STR);

    $stmt->execute();
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $resultats;
}

function reservations_add($reservation)
{
    global $db;

    $stmt = $db->prepare(SQL_RESERVATIONS_ADD);
    $stmt->bindParam(':id_utilisateur', $reservation['id_utilisateur'], PDO::PARAM_INT);
    $stmt->bindParam(':id_equipement', $reservation['id_equipement'], PDO::PARAM_INT);
    $stmt->bindParam(':date_debut', $reservation['date_debut'], PDO::PARAM_STR);
    $stmt->bindParam(':date_fin', $reservation['date_fin'], PDO::PARAM_STR);
    $stmt->bindParam(':status_reservation', $reservation['status_reservation'], PDO::PARAM_STR);

    $statut_requete = $stmt->execute();

    return $statut_requete;    
}

function reservations_delete($id)
{
    global $db;

    $stmt = $db->prepare(SQL_RESERVATIONS_DELETE);
    $stmt->bindParam(':id_reservation', $id, PDO::PARAM_INT);

    $statut_requete = $stmt->execute();

    return $statut_requete;    
}