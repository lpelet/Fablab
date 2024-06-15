<?php

define("SQL_RESERVATIONS_INDEX", "
    SELECT 
        r.ID_Reservation,
        r.id_machine,
        r.DateHeureDebut,
        r.DateHeureFin,
        m.nom
    FROM Reservations r
    JOIN machines m 
        ON r.id_machine = m.id_machine
    WHERE 
        r.StatutReservation = 'Confirmée'
    
");

define("SQL_RESERVATIONS_ADD", "
        INSERT INTO Reservations
        (ID_Utilisateur, id_machine, DateHeureDebut, DateHeureFin, StatutReservation)
        VALUES (:id_utilisateur, :id_machine, :date_debut, :date_fin, :status_reservation);
");

define("SQL_RESERVATIONS_DELETE", "
    DELETE FROM Reservations
    WHERE ID_Reservation = :id_reservation;
");

define("SQL_RESERVATIONS_UPDATE", "
    UPDATE Reservations SET
    DateHeureDebut = :date_debut,
    DateHeureFin = :date_fin
    WHERE ID_Reservation = :id;
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
    $stmt->bindParam(':id_machine', $reservation['id_machine'], PDO::PARAM_INT);
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

// Fonction pour modifier une réservation
function reservations_modif($reservation)
{
    global $db;

//    $dateHeureFinMySQL = date('Y-m-d H:i:s', strtotime($reservation['date_fin']));
//    $dateHeureDebutMySQL = date('Y-m-d H:i:s', strtotime($reservation['date_debut']));
    $dateHeureFinMySQL = $reservation['date_fin'];
    $dateHeureDebutMySQL = $reservation['date_debut'];

    $sql = "UPDATE Reservations
            SET DateHeuredebut = '$dateHeureDebutMySQL',
                DateHeureFin = '$dateHeureFinMySQL'
            WHERE ID_Reservation = " . $reservation['id_reservation'];

    print($sql);

    $stmt = $db->prepare($sql);

    $statut_requete = $stmt->execute();

    return $statut_requete;
}

/*
define("SQL_RESERVATIONS_UPDATE", "
    UPDATE Reservations SET
    DateHeureDebut = :date_debut,
    DateHeureFin = :date_fin
    WHERE ID_Reservation = :id;
");
*/


function reservations_modification($reservation)
{
    global $db;

    $dateHeureDebutMySQL = date('Y-m-d H:i:s', strtotime($reservation['date_debut']));
    $dateHeureFinMySQL = date('Y-m-d H:i:s', strtotime($reservation['date_fin']));

    $stmt = $db->prepare(SQL_RESERVATIONS_UPDATE);
    $stmt->bindParam(':id', $reservation['id_reservation'], PDO::PARAM_INT);
    $stmt->bindParam(':date_debut', $dateHeureDebutMySQL, PDO::PARAM_STR);
    $stmt->bindParam(':date_fin', $dateHeureFinMySQL, PDO::PARAM_STR);

    $statut_requete = $stmt->execute();

    return $statut_requete;    
}
    
