#include "compte.h"

#include "iostream"
#include "string"

compte::compte(std::string titulaire, double montant){

    this->titulaire = titulaire;
    this->montant = montant;

}

void compte::deposer(double montant){

    this->montant = compte::montant + montant;

}

void compte::retirer(double montant){

    this->montant = compte::montant - montant;

}

double compte::obtenir_solde(){

    return this->montant;

}