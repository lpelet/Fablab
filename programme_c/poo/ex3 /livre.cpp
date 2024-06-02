#include "iostream"
#include "string"

#include "livre.h"

livre::livre(std::string titre, std::string auteur, int annee_publication){

    this->titre = titre;
    this->auteur = auteur;
    this-> annee_publication = annee_publication;
    this-> est_emprunte = false;


}

bool livre::emprunter(){
    
    this->est_emprunte = true;

    return this->est_emprunte;

}

bool livre::retourner(){
    
    this->est_emprunte = false;

    return this->est_emprunte;

}

void livre::afficher(){

    std::cout << "Livre : " << this->titre << ", Auteur : " << this->auteur << ", annne : " << this->annee_publication << ", emprunter : " << this->est_emprunte << "\n";

}

bool livre::est_emprunter(){

    return this->est_emprunte;

};