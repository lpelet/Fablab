<?php
session_start();

try {
    $db = new PDO('mysql:host=localhost;dbname=fablab', 'fablab', 'fablab');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
function inscription()
{


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Assign variables
        $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
        $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        // Optionally, you can do something with these variables like store them in a database or perform validation

        // For now, just echo them
        echo "Nom: $nom<br>";
        echo "Prénom: $prenom<br>";
        echo "Email: $email<br>";
        echo "Mot de Passe: $password<br>";
        die();

    }
}

function connexion()
{
    global $db;

    // Récupération des valeurs du formulaire
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    // Vérification si les champs email et mot de passe ne sont pas vides
    if(!empty($email) && !empty($mdp)) {
        // Préparation de la requête pour trouver l'utilisateur par email
        // Utilisation de requêtes préparées pour éviter les injections SQL
        $stmt = $db->prepare("SELECT ID_Utilisateur, Nom, Prenom, Role, MotDePasse, StatutCertification FROM Utilisateurs WHERE Email = ?");
        $stmt->bindParam(1, $email); // Liaison du paramètre
        $stmt->execute();

        // Récupération des résultats
        $user = $stmt->fetch(PDO::FETCH_ASSOC); // Utilisation de fetch pour récupérer le premier enregistrement

        if ($user) {
            // Comparaison directe du mot de passe
            if ($mdp === $user['MotDePasse']) {
                // Authentification réussie
                $_SESSION['user_id'] = $user['ID_Utilisateur'];
                $_SESSION['user_nom'] = $user['Nom'];
                $_SESSION['user_prenom'] = $user['Prenom'];
                $_SESSION['user_role'] = $user['Role'];
                $_SESSION['certif'] = $user['StatutCertification'];

                // Redirection vers la page d'accueil sécurisée
                header("Location: /index.php");
                exit;
            } 
        } else {
            header("Location: ../../connexion_fail.php");
        }
    }
}


connexion();
$db = null;
?>