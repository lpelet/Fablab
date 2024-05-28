<?php

require_once("config_sql.php");

function open_database() { 

    global $db;

    try {
        $db = new PDO('mysql:host=' . DB_HOST . ';dbname='. DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
      }
      
}

function close_database()
{
    global $db;

    $db = null;
}
