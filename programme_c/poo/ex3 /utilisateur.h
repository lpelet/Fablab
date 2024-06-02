#include "iostream"
#include "vector"

class utilisateur{

    private :
        std::string nom;
        std::string prenom;
        int numero_utilisateur;

    public :
        utilisateur(std::string nom, std::string prenom, int numero_utilisateur);
        void emprunter_livre(livre& livre);
        void retrouner_livre(livre& livre);
        

};