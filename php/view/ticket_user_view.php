<?php

function html_ticket_user()
{

    $html = <<<END

       <!-- Table Start -->
       <div class="container-fluid pt-4 px-4">
          <div class="row g-4">
             <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Demande d'aide ou déclaration de panne</h6>
                <form action="/php/modele/form_insert_ticket.php" method="POST">
                   <div class="row mb-3">
                      <label for="email" class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-10">
                         <input type="email" class="form-control" id="email" name="email">
                      </div>
                   </div>
                   <div class="row mb-3">
                      <label for="titre" class="col-sm-2 col-form-label">Titre de la demande</label>
                      <div class="col-sm-10">
                         <input class="form-control" id="titre" name="titre">
                      </div>
                   </div>
                   <div class="row mb-3">
                      <label for="description" class="col-sm-2 col-form-label">Description</label>
                      <div class="col-sm-10">
                         <textarea class="form-control" id="description" name="description"></textarea>
                      </div>
                   </div>
                   <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
             </div>
          </div>
       </div>
END;

    return $html;
}