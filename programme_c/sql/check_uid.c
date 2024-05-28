#include <mysql/mysql.h>
#include <stdio.h>
#include <stdlib.h>
#include <time.h>  // Inclure la bibliothèque de gestion du temps

void check_uid(MYSQL *conn, const char *uid) {
    char query[256];
    MYSQL_RES *res;
    MYSQL_ROW row;
    FILE *file;
    char dateTime[64];  // Pour stocker la date et l'heure formatées
    time_t now;
    struct tm *timeinfo;

    // Ouvrir un fichier pour l'écriture
    file = fopen("log_file_uid.txt", "a");
    if (file == NULL) {
        perror("Erreur lors de l'ouverture du fichier");
        return;
    }

    // Obtenir le temps courant et le formater
    time(&now);
    timeinfo = localtime(&now);
    strftime(dateTime, sizeof(dateTime), "%d-%m-%Y %H:%M:%S", timeinfo);

    // Construire la requête SQL pour trouver l'utilisateur par uid_rfid
    snprintf(query, sizeof(query), "SELECT ID_Utilisateur, Prenom, Nom, Email, uid_rfid FROM Utilisateurs WHERE uid_rfid='%s'", uid);

    // Exécuter la requête
    if (mysql_query(conn, query)) {
        fprintf(stderr, "Erreur de requête: %s\n", mysql_error(conn));
        fclose(file);
        return;
    }

    // Récupérer le résultat de la requête
    res = mysql_store_result(conn);
    if (res == NULL) {
        fprintf(stderr, "Erreur de récupération du résultat: %s\n", mysql_error(conn));
        fclose(file);
        return;
    }

    // Vérifier si le résultat est vide (UID non trouvé)
    if (mysql_num_rows(res) == 0) {
        fprintf(file, "Date: %s - Aucun utilisateur trouvé avec l'UID %s\n", dateTime, uid);
        printf("Date: %s - Aucun utilisateur trouvé avec l'UID %s\n", dateTime, uid);
    } else {
        // Afficher et écrire les informations de l'utilisateur dans le fichier
        while ((row = mysql_fetch_row(res))) {
            fprintf(file, "Date: %s - ID_Utilisateur: %s, Prenom: %s, Nom: %s, Email: %s, Uid: %s\n", dateTime, row[0], row[1], row[2], row[3], row[4]);
            printf("Date: %s - ID_Utilisateur: %s, Prenom: %s, Nom: %s, Email: %s, Uid: %s\n", dateTime, row[0], row[1], row[2], row[3], row[4]);
        }
    }

    // Libérer la mémoire utilisée par le résultat et fermer le fichier
    mysql_free_result(res);
    fclose(file);
}

int main() {
    MYSQL *conn;
    char *server = "localhost";
    char *user = "fablab";
    char *password = "fablab";
    char *database = "fablab";

    // Initialiser la connexion
    conn = mysql_init(NULL);

    // Connecter à la base de données
    if (!mysql_real_connect(conn, server, user, password, database, 0, NULL, 0)) {
        fprintf(stderr, "%s\n", mysql_error(conn));
        exit(1);
    }

    // Appeler la fonction pour obtenir les informations de l'utilisateur
    check_uid(conn, "132");

    // Fermer la connexion
    mysql_close(conn);

    return 0;
}
