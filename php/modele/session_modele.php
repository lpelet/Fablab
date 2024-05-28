<?php

session_start(); 

function check_admin(){

    $resultat = -1;

    if($_SESSION['user_role'] == "Administrateur"){
        $resultat = 1;
    } else {
        $resultat = 0;
    }

    return $resultat;

}

function check_login(){

    $resultat = -1;

    if($_SESSION['user_id'] != ""){
        $resultat = 1;
    } else {
        $resultat = 0;
    }
    
    return $resultat;

}

function user_info(){

    $data = [];

    $data['id'] = $_SESSION['user_id'];
    $data['nom'] = $_SESSION['user_nom'];
    $data['prenom'] = $_SESSION['user_prenom'];
    $data['role'] = $_SESSION['user_role'];;

    return $data;
}


    
?>