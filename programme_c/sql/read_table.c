#include <mysql/mysql.h>
#include <stdio.h>
#include <stdlib.h>

int main() {
    MYSQL *conn;
    MYSQL_RES *res;
    MYSQL_ROW row;

    // Paramètres de connexion à la base de données
    char *server = "localhost";
    char *user = "fablab";
    char *password = "fablab"; /* set me first */
    char *database = "fablab";

    // Initialiser la connexion
    conn = mysql_init(NULL);

    // Connecter à la base de données
    if (!mysql_real_connect(conn, server, user, password, database, 0, NULL, 0)) {
        fprintf(stderr, "%s\n", mysql_error(conn));
        exit(1);
    }

    // Envoyer une requête SQL
    if (mysql_query(conn, "SELECT * FROM ticket")) {
        fprintf(stderr, "%s\n", mysql_error(conn));
        exit(1);
    }

    res = mysql_use_result(conn);

    // Afficher les résultats de la requête
    printf("Résultats de MySQL :\n");
    while ((row = mysql_fetch_row(res)) != NULL)
        printf("%s \n", row[1]);
    mysql_free_result(res);
    mysql_close(conn);

    printf("Connexion terminée.\n");
    return 0;
}
