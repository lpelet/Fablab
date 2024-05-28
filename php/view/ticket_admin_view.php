<?php

function html_ticket_admin($type)
{
    $html_tableau = null;
    $index = 0;

    if (count($type) > 0) {
        foreach ($type as $row) {
            $titre = htmlspecialchars($row["date_ouverture"]) . " : " . htmlspecialchars($row["titre"]);
            $description = " Contact : " . htmlspecialchars($row["email"]) . "<br>" . htmlspecialchars($row["description"]);
            $index += 1;
            
            // Générer des ID uniques pour les attributs "id" et "data-bs-target"
            $accordionID = "flush-collapse" . $index;
            $headingID = "flush-heading" . $index;
            
            $html_tableau .= <<<END
            <div class="accordion-item">
                <h2 class="accordion-header" id="$headingID">
                    <button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#$accordionID"
                        aria-expanded="false" aria-controls="$accordionID">
                        $titre
                    </button>
                </h2>
                <div id="$accordionID" class="accordion-collapse collapse"
                    aria-labelledby="$headingID" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        $description
                        <br>
                        <form method="post" action="php/modele/update_ticket.php">
                            <input type="hidden" name="ticket_id" value="{$row['id']}">
                            <button type="submit" class="btn btn-primary mt-3">Cloturer</button>
                        </form>

                    </div>
                </div>
            </div>
            END;
        }
    } else {
        $html_tableau = "<p>Aucun ticket</p>";
    }

    $html = <<<END

        <!-- Table Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Ticket en cours</h6>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        $html_tableau
                    </div>
                </div>
            </div>
        </div>
    END;

    return $html;
}

