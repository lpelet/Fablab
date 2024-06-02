#include "iostream"
#include "string"

#include "livre.h"
#include "utilisateur.h"

int main(){

    livre txt1("titre1","auteur1",1995);

    txt1.afficher();

    txt1.emprunter();

    txt1.afficher();

}