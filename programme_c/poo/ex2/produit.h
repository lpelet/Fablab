#include "string"

class produit {

    private:
        std::string nom;
        int quantite;
        double prix;

    public:
        produit(std::string nom, int quantite, double prix);
        void ajouter(int nombre);
        void retirer(int nombre);
        void afficher();
};