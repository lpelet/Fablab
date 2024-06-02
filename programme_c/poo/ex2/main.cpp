#include "iostream"
#include "string"

#include "produit.h"

int main(){
    
    produit savon("savon", 2, 5);
    savon.afficher();
    savon.ajouter(5);
    savon.afficher();
    

}