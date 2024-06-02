#include "produit.h"

#include "iostream"
#include "string"

produit::produit(std::string nom, int quantite, double prix){

    this->nom = nom;
    this->quantite = quantite;
    this->prix = prix;
    
}

void produit::afficher(){

    std::cout << "Le produit : " << this->nom << ", quantité : "<< this->quantite << ", prix : " << this->prix <<" € \n";
}

void produit::ajouter(int quantite){

    this->quantite += quantite;

}

void produit::retirer(int quantite){

    this->quantite -= quantite;

}