<?php

function html_connexion()
{

    $html = <<<END

    <!-- Sign Up Start -->
    <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <h3>Inscription</h3>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingText" placeholder="Paul">
                        <label for="floatingText">Nom</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingText" placeholder="Du pont">
                        <label for="floatingText">Prénom</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">Email</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                        <label for="floatingPassword">Mot de Passe</label>
                    </div>
  
                    <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Inscription</button>

                    <p class="text-center mb-0">Se connecter ? <a href="connexion.php">Connexion</a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Sign Up End -->
    
END;

    return $html;
}

?>