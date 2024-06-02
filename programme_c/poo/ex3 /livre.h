#include "iostream"

class livre {

    private : 
        std::string titre;
        std::string auteur;
        int annee_publication;
        bool est_emprunte;

    public :

        livre(std::string titre, std::string auteur, int annee_publication);
        bool emprunter();
        bool retourner();

        bool est_emprunter();
        void afficher();
};
