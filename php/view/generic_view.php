<?php

require_once ("php/modele/session_modele.php");

function html_generic($title, $contenu,  $script_calendrier  = "", $data = [])
{

    if ( !isset($data['menu1_actif']) && !isset($data['menu2_actif']) && !isset($data['menu3_actif']) && !isset($data['menu4_actif']) && !isset($data['menu5_actif']) && !isset($data['menu6_actif'])) {
        $data['menu1_actif'] = " active";
        $data['menu2_actif'] = "";
        $data['menu3_actif'] = "";
        $data['menu4_actif'] = "";
        $data['menu5_actif'] = "";
        $data['menu6_actif'] = "";
    }  
    $menu1_actif = $data['menu1_actif'];
    $menu2_actif = $data['menu2_actif'];
    $menu3_actif = $data['menu3_actif'];
    $menu4_actif = $data['menu4_actif'];
    $menu5_actif = $data['menu5_actif'];
    $menu6_actif = $data['menu6_actif'];

    $data_user = user_info();

    $user_nom = $data_user["nom"];
    $user_prenom = $data_user["prenom"];
    $user_role = $data_user["role"];

    $nav_item_admin = null;
    
    if($user_role == "Administrateur"){
        $nav_item_admin = "<a href='index_admin.php' class='nav-item nav-link'><i class='fa fa-keyboard me-2'></i>Admin</a>" ;
    }

    $html = <<<END
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>$title</title>
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
        <link href="../../css/bootstrap.min.css" rel="stylesheet">
    
        <!-- Template Stylesheet -->
        <link href="../../css/style.css" rel="stylesheet">
        $script_calendrier
    </head>
    <body>
        <div class="container-xxl position-relative bg-white d-flex p-0">
            <!-- Spinner Start -->
            <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <!-- Spinner End -->
    
            <!-- Sidebar Start -->
            <div class="sidebar pe-4 pb-3">
                <nav class="navbar bg-light navbar-light">
                    <a href="index.php" class="navbar-brand mx-4 mb-3">
                        <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>FABLAB</h3>
                    </a>
                    <div class="d-flex align-items-center ms-4 mb-4">
                        <div class="position-relative">
                            <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                            <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0">$user_nom  $user_prenom</h6>
                            <span>$user_role</span>
                        </div>
                    </div>
                    <div class="navbar-nav w-100">
                        <a href="index.php" class="nav-item nav-link $menu1_actif"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                        <div class="nav-item dropdown $menu2_actif">
                            <a href="#" class="nav-link dropdown-toggle $menu3_actif" data-bs-toggle="dropdown"><i class="bi bi-calendar-week"></i>Calendrier</a>
                            <div class="dropdown-menu bg-transparent border-0">
                                <a href="calendrier.php" class="dropdown-item ">Planning</a>
                                <a href="reservation.php" class="dropdown-item">Réservation</a>
                            </div>
                        </div>
                        <a href="forum.php" class="nav-item nav-link $menu4_actif"><i class="fa fa-th me-2"></i>Forum</a>
                        <a href="form.html" class="nav-item nav-link $menu5_actif"><i class="fa fa-keyboard me-2"></i>Formation</a>
                        <a href="ticket_user.php" class="nav-item nav-link $menu6_actif"><i class="fa fa-keyboard me-2"></i>Support</a>
                        $nav_item_admin
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Pages</a>
                            <div class="dropdown-menu bg-transparent border-0">
                                <a href="signin.html" class="dropdown-item">Sign In</a>
                                <a href="signup.html" class="dropdown-item">Sign Up</a>
                                <a href="404.html" class="dropdown-item">404 Error</a>
                                <a href="blank.html" class="dropdown-item">Blank Page</a>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <!-- Sidebar End -->
    
            <!-- Content Start -->
            <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control border-0" type="search" placeholder="Search">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Message</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all message</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notification</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Profile updated</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">New user added</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Password changed</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all notifications</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex">$user_prenom</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">Mon Profil</a>
                            <a href="#" class="dropdown-item">Paramètre</a>
                            <a href="deconnexion.php" class="dropdown-item">Déconnexion</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->
            $contenu
            </div>
            <!-- Content End -->
    
            <!-- Back to Top -->
            <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
        </div>
    
        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../../lib/chart/chart.min.js"></script>
        <script src="../../lib/easing/easing.min.js"></script>
        <script src="../../lib/waypoints/waypoints.min.js"></script>
        <script src="../../lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="../../lib/tempusdominus/js/moment.min.js"></script>
        <script src="../../lib/tempusdominus/js/moment-timezone.min.js"></script>
        <script src="../../lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    
        <!-- Template Javascript -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $("#chat-form").submit(function(event){
        event.preventDefault();
        var message = $("#chat-message").val();
        $.post("save_message.php", {message: message}, function(){
            $("#chat-message").val('');
            loadMessages();
        });
    });

    function loadMessages(){
        $("#chat-box").load("load_messages.php");
    }

    setInterval(loadMessages, 3000); // Rafraîchit les messages toutes les 3 secondes
    loadMessages(); // Chargez les messages initiaux
});
</script>

        <script src="../../js/main.js"></script>
        $script_calendrier
    </body>
    </html>
END;

    return $html;
}

?>