<?php

require_once("../php/sql/database.php");
require_once("../php/modele/reservations_modele.php");

$db = null;

open_database();

$reservations = reservations_index("2024-03-15", "2024-03-20");
print_r($reservations);

close_database();