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
    if ($data['flag_reservation_add'] == true){
        $html .= "
        </br>
        <h1> Réservation effectuée </h1>
        </br>
        <p> Votre réservation a bien été prise en compte. </p>
        <p> Merci d'attendre que cette dernière soit confirmée. </p> ";
    } else if (isset($data['flag_reservation_add']) && $data['flag_reservation_add'] == false) {
        $html .= "
        </br>
        <h1> Réservation échouée </h1>
        </br>
        <p> Votre réservation n'a pas été prise en compte. </p>
        <p> Merci de réessayer.</p> ";

    }

    $html = <<<END
            {$html}
        
            <!-- Footer End -->

        <!-- Content End -->
        END;
        
    return $html;
    
}