<?php
session_start();

// Initialisation d'un message d'erreur vide
$erreur = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Connexion à la BDD
    $db = new mysqli('localhost', 'fablab', 'fablab', 'fablab');

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Récupération des valeurs du formulaire
    $email = $_POST['email']; // Modifiez pour correspondre au nom de champ dans le formulaire HTML
    $mdp = $_POST['mdp']; // Modifiez pour correspondre au nom de champ dans le formulaire HTML

    $stmt = $db->prepare("SELECT ID_Utilisateur, MotDePasse FROM Utilisateurs WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifie si l'utilisateur existe
    if ($user = $result->fetch_assoc()) {

        // À remplacer par une vérification de mot de passe haché si nécessaire
        if ($mdp === $user['MotDePasse']) {

            // Authentification réussie 
            $_SESSION['user_id'] = $user['ID_Utilisateur'];

            // Redirection vers accueil.php
            header("Location: ../index.html");
            exit;
        } else {
            $erreur = "Mot de passe incorrect !";
        }
    } else {
        $erreur = "Utilisateur non trouvé !";
    }

    // Fermeture de la connexion à la BDD
    $stmt->close();
    $db->close();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>FABLAB - Connexion</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="background">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


<!-- Sign In Start -->
<div class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <form class="bg-light rounded p-4 p-sm-5 my-4 mx-3" method="post">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <h3>Connexion</h3>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                    <label for="floatingInput">Email</label>
                </div>
                <div class="form-floating mb-4">
                    <input type="password" name="mdp" class="form-control" id="floatingPassword" placeholder="Password" required>
                    <label for="floatingPassword">Mot De Passe</label>
                </div>
                <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Connexion</button>
                <p class="text-center mb-0">Vous n'avez pas de compte ? <a href="signup.html">Inscription</a></p>
            </form>
        </div>
    </div>
</div>
<!-- Sign In End -->

    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>