<?php

define("SQL_MACHINES_SELECT_TYPE", "SELECT * FROM machines WHERE `type` = :type_mac");


function machines_select_type($type_machine)
{
    global $db;

    $stmt = $db->prepare(SQL_MACHINES_SELECT_TYPE);
    $stmt->bindParam(':type_mac', $type_machine, PDO::PARAM_STR);

    $stmt->execute();
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $resultats;
}
