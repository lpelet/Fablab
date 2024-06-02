#include "string"

class compte{

    private :

        double montant;
        std::string titulaire;

    public : 

        compte(std::string titulaire, double montant);
        void deposer(double montant);
        void retirer(double montant);
        double obtenir_solde();
        

};