#include <mysql/mysql.h>
#include <stdio.h>
#include <stdlib.h>

void updateStatut(MYSQL *conn, int idEquipement, const char *nouveauStatut) {
    char query[256];
    // Préparation de la requête SQL
    snprintf(query, sizeof(query), "UPDATE Equipements SET statut='%s' WHERE ID_Equipement=%d", nouveauStatut, idEquipement);
    
    // Exécution de la requête UPDATE
    if (mysql_query(conn, query)) {
        fprintf(stderr, "%s\n", mysql_error(conn));
        exit(1);
    }
    
    printf("Statut de l'équipement ID %d mis à jour en '%s'.\n", idEquipement, nouveauStatut);
}

int main() {
    MYSQL *conn;
    char *server = "localhost";
    char *user = "fablab";
    char *password = "fablab"; // Modifiez selon votre configuration
    char *database = "fablab";

    conn = mysql_init(NULL);

    // Connexion à la base de données
    if (!mysql_real_connect(conn, server, user, password, database, 0, NULL, 0)) {
        fprintf(stderr, "%s\n", mysql_error(conn));
        exit(1);
    }

    // Appel de la fonction de mise à jour
    updateStatut(conn, 2, "on");

    // Fermeture de la connexion
    mysql_close(conn);

    return 0;
}
