<?php

function html_connexion()
{

    $html = <<<END

<!-- Sign In Start -->
<div class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <form class="bg-light rounded p-4 p-sm-5 my-4 mx-3" action="/php/modele/utilisateur_modele.php" method="post">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <h3>Connexion</h3>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control" id="floatingInputEmail" placeholder="name@example.com" required>
                    <label for="floatingInputEmail">Email</label>
                </div>
                <div class="form-floating mb-4">
                    <input type="password" name="mdp" class="form-control" id="floatingPassword" placeholder="Password" required>
                    <label for="floatingPassword">Mot De Passe</label>
                </div>
                <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Connexion</button>
                <p class="text-center mb-0">Vous n'avez pas de compte ? <a href="inscription.php">Inscription</a></p>
            </form>
        </div>
    </div>
</div>
<!-- Sign In End -->
END;

    return $html;
}

function html_connexion_fail()
{

    $html = <<<END

    <!-- Sign In Start -->
    <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <h3>Identifiant incorrect</h3>
                    </div>
    
                    <button onclick="window.location.href='connexion.php';" class="btn btn-primary py-3 w-100 mb-4">Connexion</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Sign In End -->
    
END;

    return $html;
}

function html_deconnexion()
{

    $html = <<<END

    <!-- Sign In Start -->
    <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <h3>Vous êtes déconnecté(e)</h3>
                    </div>
    
                    <button onclick="window.location.href='connexion.php';" class="btn btn-primary py-3 w-100 mb-4">Connexion</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Sign In End -->
    
END;

    return $html;
}
?>