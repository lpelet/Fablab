<?php

define("SQL_USER", "SELECT * FROM Utilisateurs WHERE `Role` = :type_role");


function user_table($type_role)
{
    global $db;

    $stmt = $db->prepare(SQL_USER);
    $stmt->bindParam(':type_role', $type_role,PDO::PARAM_STR);

    $stmt->execute();
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $resultats;
}
