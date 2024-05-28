<?php

function html_gestion_utlisateur($type)
{
    $html_tableau = null;
    $index = 0;

    if (count($type) > 0) {
        foreach ($type as $row) {
            if ($row["uid_rfid"] === NULL) {
                $row["uid_rfid"] = "Aucun badge";
            }

            $titre = htmlspecialchars($row["Prenom"]) . " " . htmlspecialchars($row["Nom"]) . " mail : " . htmlspecialchars($row["Email"]);
            $description = " Certification : " . htmlspecialchars($row["StatutCertification"]) . "<br> UID badges : " . htmlspecialchars($row["uid_rfid"]);
            $index++;

            // Generate unique IDs for accordion controls
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
            <form method="post" action="php/modele/update_uid_rfid.php">
                <input type="hidden" name="id_utilisateur" value="{$row['ID_Utilisateur']}">
                <br>
                <input type="text" name="uid_rfid" class="form-control mb-3" placeholder="" value="{$row['uid_rfid']}">
                <button type="submit" class="btn btn-primary mt-3">Modifier UID</button>
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
                    <h6 class="mb-4">Étudiant</h6>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        $html_tableau
                    </div>
                </div>
            </div>
        </div>
    END;

    return $html;
}


