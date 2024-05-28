<?php
require_once("generic_admin_view.php");

function html_machines($type_machine_1, $type_machine_2)
{

    // Step 3: Generate HTML table rows dynamically
    if (count($type_machine_1) > 0) {
        $html_tableau = "";
        // output data of each row
        $index_tab_affichage = 1;
        foreach ($type_machine_1 as $row) {
            $html_tableau .= "<tr>\n";
            $html_tableau .= "<th scope='row'>" . $index_tab_affichage . "</th>\n";
            $html_tableau .= "<td>" . htmlspecialchars($row["nom"]) . "</td>\n";
            $html_tableau .= "<td>" .strtoupper(htmlspecialchars($row["statut"])) . "</td>\n";
            $html_tableau .= "</tr>\n";
            $index_tab_affichage += 1;            
        }
    } else {
        $html_tableau = "<tr><td colspan='4'>Aucune machine</td></tr>";
    }

    // Step 3: Generate HTML table rows dynamically
    if (count($type_machine_2) > 0) {
        $html_tableau1 = "";
        // output data of each row
        $index_tab_affichage = 1;           
        foreach ($type_machine_2 as $row) {
            $html_tableau1 .= "<tr>\n";
            $html_tableau1 .= "<th scope='row'>" . $index_tab_affichage . "</th>\n";
            $html_tableau1 .= "<td>" . htmlspecialchars($row["nom"]) . "</td>\n";
            $html_tableau1 .= "<td>" . strtoupper(htmlspecialchars($row["statut"])) . "</td>\n";
            $html_tableau1 .= "</tr>\n";
            $index_tab_affichage += 1;            
            }
        } else {
            $html_tableau1 = "<tr><td colspan='4'>Aucune machine</td></tr>";
        }


    $html = <<<END
    <!-- Content Start -->
    
        <!-- Table Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <!-- Tableau imprimante 3D -->
                <div class="col-12">
                    <div class="bg-light rounded h-100 p-4">
                        <h6 class="mb-4">Machines 3D</h6>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nom machine</th>
                                        <th scope="col">Status</th>
    
                                    </tr>
                                </thead>
                                <tbody>
                                    $html_tableau
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tableau découpe laser -->
                <div class="col-12">
                    <div class="bg-light rounded h-100 p-4">
                        <h6 class="mb-4">Découpeuse laser</h6>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nom machine</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    $html_tableau1
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>         
END;

    return $html;
}