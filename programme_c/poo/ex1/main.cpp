#include "iostream"
#include "string"

#include "compte.h"

int main(){

    compte compte_louna("Louna", 1000);
    std::cout << "Le solde est : " << compte_louna.obtenir_solde() << " euros\n";

    compte_louna.retirer(100);
    std::cout << "Le solde est : " << compte_louna.obtenir_solde() << " euros\n";
    

}