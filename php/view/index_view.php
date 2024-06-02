<?php
require_once("generic_view.php");

function html_accueil()
{


    $html = <<<END
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
        <link rel="stylesheet" href="path_to_your_css.css"> <!-- Lien vers votre fichier CSS -->
        <style>
            /* Ajout des styles spécifiques pour cette page */
            .container-fluid {
                margin-bottom: 20px;
            }
    
            .bg-light1 {
                background-color: var(--light) !important;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
            }
    
            .bg-light1:hover {
                transform: translateY(-5px);
            }
    
            .rounded {
                border-radius: 8px !important;
            }
    
            .calendar-div, .ticket-div {
                cursor: pointer;
                background-size: cover;
                background-position: center;
                height: 200px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--dark);
                text-align: center;
                font-size: 24px;
                font-weight: bold;
            }
    
            .calendar-div {
                background-image: url('path_to_calendar_image.jpg'); /* Ajoutez le chemin vers votre image de calendrier */
            }
    
            .ticket-div {
                background-image: url('path_to_ticket_image.jpg'); /* Ajoutez le chemin vers votre image de ticket */
            }
    
            .chat-div {
                cursor: pointer;
                background-color: var(--primary);
                color: #fff;
                text-align: center;
                padding: 50px 0;
                font-size: 24px;
                border-radius: 8px;
                transition: background-color 0.3s ease;
            }
    
            .chat-div:hover {
                background-color: #066d67;
            }
        </style>
    </head>
    <body>
        <!-- Main Container Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <!-- Calendar Div -->
                <div class="col-sm-12 col-md-6" onclick="location.href='calendrier.php';" style="cursor:pointer;">
                    <div class="bg-light1 text-center rounded p-4 calendar-div">
                        <div>
                        <i class="bi bi-calendar-week icon"></i>
                            <h6 class="mb-0">Calendrier</h6>
                            <p>Voir et gérer vos événements</p>
                        </div>
                    </div>
                </div>
                <!-- Ticket Div -->
                <div class="col-sm-12 col-md-6" onclick="location.href='ticket_user.php';" style="cursor:pointer;">
                    <div class="bg-light1 text-center rounded p-4 ticket-div">
                        <div>
                            <i class="bi bi-folder"></i>
                            <h6 class="mb-0">Tickets</h6>
                            <p>Voir et gérer vos tickets</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Container End -->
    
        <!-- Formation & Certification Div -->
        <div class="container-fluid pt-4 px-4">
            <div class="bg-light1 text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Formation & Certification</h6>
                </div>
                <div class="table-responsive">
                    <table class="table text-start align-middle table-bordered table-hover mb-0">
                        <thead>
                            <tr class="text-dark">
                                <th scope="col">Formation</th>
                                <th scope="col">Type de Machine</th>
                                <th scope="col">Accès</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Formation Imprimante 3D</td>
                                <td>Imprimante 3D</td>
                                <td><a class="btn btn-sm btn-primary" href="formation.php">Accéder</a></td>
                            </tr>
                            <tr>
                                <td>Formation Découpe Laser</td>
                                <td>Découpe Laser</td>
                                <td><a class="btn btn-sm btn-primary" href="formation.php">Accéder</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    
        <!-- Chat Section Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-12" onclick="location.href='chat.html';" style="cursor:pointer;">
                    <div class="chat-div">
                        <h6 class="mb-0">Chat</h6>
                        <p>Communiquez avec vos collègues</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Chat Section End -->
    </body>
    </html>
    
END;

    return $html;
}
