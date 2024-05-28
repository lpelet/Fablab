<?php
require_once("generic_view.php");

function html_reservation($data = [])
{

    $html = <<<END
   
    <!-- Content Start -->
            <div class="container_reservation">
                <h1>Réservation de machine</h1>
                <form action="reservation.php" method="post">
                    <label for="date">Choisissez une date et heure début :</label>
                    <input type="datetime-local" id="DateHeureDebut" name="dateDebut" required>
                    </br>
                    </br>
                    <label for="date">Choisissez une date et heure fin :</label>
                    <input type="datetime-local" id="DateHeureFin" name="dateFin" required>
                    </br>
                    </br>
                    <label for="Equipements">Choisissez une machine :</label>
                    <select id="nom" name="Equipements" required>
                        <option value="2">Imprimante 3D</option>
                        <option value="3">Découpe laser</option>
                    </select>
            
                    <input type="submit" value="Réserver">
                </form>
            </div>

END;
    if($data['flag_reservation_add'] == true){
        $html .= "
        </br>
        <h1> Réservation effectuée </h1>
        </br>
        <p> Votre réservation a bien été prise en compte. </p>
        <p> Merci d'attendre que cette dernière soit confirmée. </p> ";
    } else if ($data['flag_reservation_add'] == false){
        $html .= "
        </br>
        <h1> Réservation echouée </h1>
        </br>
        <p> Votre réservation a bien été prise en compte. </p>
        <p> Merci d'attendre que cette dernière soit confirmée. </p> ";

    }

    $html = <<<END
            {$html}
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">Fablab</a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->

        <!-- Content End -->
        END;
        
    return $html;
    
}