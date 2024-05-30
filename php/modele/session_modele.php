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
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != ""){
        return 1;
    } else {
        return 0;
    }

    return $resultat;
}

function user_info(){
    $data = [];
    $data['id'] = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'N/A';
    $data['nom'] = isset($_SESSION['user_nom']) ? $_SESSION['user_nom'] : 'N/A';
    $data['prenom'] = isset($_SESSION['user_prenom']) ? $_SESSION['user_prenom'] : 'N/A';
    $data['role'] = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'N/A';

    return $data;
}

    
?>