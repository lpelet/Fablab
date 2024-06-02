#include "iostream"
#include "vector"

#include "livre.h"
#include "utilisateur.h"

utilisateur::utilisateur(std::string nom, std::string prenom, int numero_utilisateur){

    this->nom = nom;
    this->prenom = prenom;
    this->numero_utilisateur = numero_utilisateur;

}

void utilisateur::emprunter_livre(livre& livre){

    if(!livre.est_emprunter()){
        livre.emprunter();
    }else{
        std::cout << "Le livre est déja emprunter\n";
    }
    

}

void utilisateur::retrouner_livre(livre& livre){
    
    livre.retourner();

}