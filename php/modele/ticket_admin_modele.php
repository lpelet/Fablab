<?php

define("SQL_TICKET_SELECT_STATUT", "SELECT * FROM ticket WHERE `status` = :status_ticket");

function ticket_select_status($status)
{
    global $db;

    $stmt = $db->prepare(SQL_TICKET_SELECT_STATUT);
    $stmt->bindParam(':status_ticket', $status, PDO::PARAM_STR);

    $stmt->execute();
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $resultats;
}