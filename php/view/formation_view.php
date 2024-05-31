<?php

function html_chat() {
    $html = <<<END
    <!DOCTYPE html>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formation et Test de Certification</title>
        <style>
            :root {
                --primary: #08ab9f;
                --light: #F3F6F9;
                --dark: #191C24;
                --success-bg: #dff0d8;
                --success-color: #3c763d;
                --fail-bg: #f2dede;
                --fail-color: #a94442;
            }
    
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f4f4f4;
                color: var(--dark);
            }
    
            .container {
                max-width: 800px;
                margin: 40px auto;
                background-color: var(--light);
                border-radius: 10px;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
                padding: 20px;
            }
    
            h1, h2 {
                color: var(--primary);
                text-align: center;
            }
    
            .accordion-button {
                background-color: var(--primary);
                color: #fff;
                font-weight: bold;
                border: none;
                border-radius: 5px;
            }
    
            .accordion-button.collapsed {
                background-color: var(--primary);
            }
    
            .accordion-button:focus {
                box-shadow: none;
            }
    
            .accordion-item {
                border: none;
            }
    
            .accordion-body {
                background-color: #fff;
                border-radius: 0 0 5px 5px;
            }
    
            .btn-primary {
                background-color: var(--primary);
                border: none;
            }
    
            .btn-primary:hover {
                background-color: #067d76;
            }
    
            .result {
                margin-top: 20px;
                padding: 20px;
                border-radius: 5px;
                display: none;
            }
    
            .result.success {
                background-color: var(--success-bg);
                color: var(--success-color);
            }
    
            .result.fail {
                background-color: var(--fail-bg);
                color: var(--fail-color);
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Formation et Test de Certification</h1>
            <div class="accordion" id="accordionExample">
                <!-- Formation Imprimante 3D Start -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Formation Imprimante 3D
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <h3>Introduction</h3>
                            <p>Bienvenue à la formation sur l'utilisation des imprimantes 3D. Cette formation détaillée vous guidera à travers les étapes spécifiques et les consignes de sécurité essentielles pour utiliser ces machines de manière efficace et sécurisée.</p>
    
                            <h4>1. Présentation</h4>
                            <p>Les imprimantes 3D fabriquent des objets en ajoutant des couches successives de matériau. Elles sont couramment utilisées dans le prototypage, l'ingénierie, et les arts créatifs.</p>
    
                            <h4>2. Consignes de Sécurité</h4>
                            <ul>
                                <li><b>Porter des lunettes de protection</b> : Protégez vos yeux des éclats et de la lumière vive émise par l'imprimante.</li>
                                <li><b>Ventilation adéquate</b> : Assurez-vous que la pièce est bien ventilée pour éviter l'inhalation de vapeurs potentiellement nocives.</li>
                                <li><b>Ne pas toucher les pièces chaudes</b> : La buse et le lit d'impression peuvent atteindre des températures élevées. Laissez-les refroidir avant de les manipuler.</li>
                                <li><b>Supervision continue</b> : Ne laissez jamais l'imprimante fonctionner sans surveillance pour éviter les risques d'incendie.</li>
                            </ul>
    
                            <h4>3. Étapes pour Utiliser une Imprimante 3D</h4>
                            <ol>
                                <li>
                                    <b>Préparation du Modèle 3D</b> :
                                    <ul>
                                        <li>Utilisez un logiciel de modélisation 3D (TinkerCAD, Fusion 360, etc.) pour créer votre modèle.</li>
                                        <li>Exportez le modèle au format STL.</li>
                                    </ul>
                                </li>
                                <li>
                                    <b>Tranchage du Modèle</b> :
                                    <ul>
                                        <li>Importez le fichier STL dans un logiciel de tranchage (Cura, PrusaSlicer).</li>
                                        <li>Configurez les paramètres d'impression : hauteur de couche, remplissage, température de la buse et du lit, vitesse d'impression.</li>
                                        <li>Générer le fichier G-code.</li>
                                    </ul>
                                </li>
                                <li>
                                    <b>Préparation de l'Imprimante</b> :
                                    <ul>
                                        <li>Allumez l'imprimante 3D et chargez le filament en suivant les instructions spécifiques à votre modèle d'imprimante.</li>
                                        <li>Nettoyez le lit d'impression et appliquez une fine couche de laque adhésive si nécessaire.</li>
                                        <li>Assurez-vous que le lit est nivelé.</li>
                                    </ul>
                                </li>
                                <li>
                                    <b>Lancement de l'Impression</b> :
                                    <ul>
                                        <li>Chargez le fichier G-code via une carte SD ou une connexion USB.</li>
                                        <li>Démarrez l'impression et surveillez les premières couches pour vérifier l'adhérence au lit.</li>
                                        <li>Faites attention aux bruits anormaux ou aux erreurs de couche pendant l'impression.</li>
                                    </ul>
                                </li>
                                <li>
                                    <b>Post-traitement</b> :
                                    <ul>
                                        <li>Une fois l'impression terminée, laissez l'objet refroidir avant de le retirer du lit.</li>
                                        <li>Enlevez les supports avec des pinces et poncez les surfaces si nécessaire.</li>
                                        <li>Si vous utilisez des matériaux spécifiques (ABS, PETG), un post-traitement supplémentaire (polissage, peinture) peut être requis.</li>
                                    </ul>
                                </li>
                            </ol>
    
                            <button class="btn btn-primary mt-3" data-bs-toggle="collapse" data-bs-target="#test3D">Passer le Test Imprimante 3D</button>
                        </div>
                    </div>
                </div>
                <!-- Formation Imprimante 3D End -->
    
                <!-- Formation Découpe Laser Start -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Formation Découpe Laser
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <h3>Introduction</h3>
                            <p>Bienvenue à la formation sur l'utilisation des découpeuses laser. Cette formation détaillée vous guidera à travers les étapes spécifiques et les consignes de sécurité essentielles pour utiliser ces machines de manière efficace et sécurisée.</p>
    
                            <h4>1. Présentation</h4>
                            <p>Les découpeuses laser découpent ou gravent des matériaux avec un faisceau laser focalisé. Elles sont parfaites pour des découpes précises et des gravures complexes sur divers matériaux.</p>
    
                            <h4>2. Consignes de Sécurité</h4>
                            <ul>
                                <li><b>Porter des lunettes de protection adaptées</b> : Protégez vos yeux des rayons laser.</li>
                                <li><b>Assurer une ventilation adéquate</b> : Utilisez des systèmes d'extraction pour évacuer les fumées et les gaz.</li>
                                <li><b>Ne jamais laisser la machine sans surveillance</b> : Les matériaux peuvent s'enflammer rapidement.</li>
                                <li><b>Éviter les matériaux interdits</b> : Ne découpez pas des matériaux comme le PVC, qui dégagent des fumées toxiques.</li>
                            </ul>
    
                            <h4>3. Étapes pour Utiliser une Découpeuse Laser</h4>
                            <ol>
                                <li>
                                    <b>Préparation du Fichier</b> :
                                    <ul>
                                        <li>Utilisez un logiciel de dessin vectoriel (Adobe Illustrator, Inkscape) pour créer votre design.</li>
                                        <li>Exportez le fichier au format compatible (DXF, SVG).</li>
                                    </ul>
                                </li>
                                <li>
                                    <b>Configuration de la Machine</b> :
                                    <ul>
                                        <li>Placez le matériau sur le lit de la découpeuse et assurez-vous qu'il est bien fixé.</li>
                                        <li>Ajustez la hauteur du lit pour focaliser le laser correctement.</li>
                                    </ul>
                                </li>
                                <li>
                                    <b>Paramétrage des Paramètres de Découpe</b> :
                                    <ul>
                                        <li>Dans le logiciel de contrôle de la découpeuse (LightBurn, RDWorks), importez votre fichier.</li>
                                        <li>Réglez les paramètres de découpe : puissance du laser, vitesse de coupe, fréquence des pulsations.</li>
                                        <li>Effectuez un test de coupe sur un petit morceau pour vérifier les réglages.</li>
                                    </ul>
                                </li>
                                <li>
                                    <b>Lancement de la Découpe/Gravure</b> :
                                    <ul>
                                        <li>Démarrez le processus de découpe ou de gravure.</li>
                                        <li>Surveillez constamment la machine pour intervenir rapidement en cas de problème.</li>
                                        <li>Utilisez des dispositifs d'extinction rapide à portée de main (extincteur, couverture anti-feu).</li>
                                    </ul>
                                </li>
                                <li>
                                    <b>Post-traitement</b> :
                                    <ul>
                                        <li>Laissez le matériau refroidir avant de le manipuler.</li>
                                        <li>Nettoyez les bords coupés et retirez les résidus.</li>
                                        <li>Pour les gravures, un nettoyage supplémentaire peut être nécessaire pour améliorer la finition.</li>
                                    </ul>
                                </li>
                            </ol>
    
                            <button class="btn btn-primary mt-3" data-bs-toggle="collapse" data-bs-target="#testLaser">Passer le Test Découpe Laser</button>
                        </div>
                    </div>
                </div>
                <!-- Formation Découpe Laser End -->
            </div>
    
            <!-- Test Imprimante 3D -->
            <div class="form-section collapse" id="test3D">
                <h2>Test de Certification Imprimante 3D</h2>
                <form id="testForm3D">
                    <div>
                        <label for="question1_3D">Question 1: Quel est le capital de la France?</label>
                        <input type="text" id="question1_3D" name="question1_3D" required>
                    </div>
                    <div>
                        <label for="question2_3D">Question 2: Combien font 2 + 2?</label>
                        <input type="text" id="question2_3D" name="question2_3D" required>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="submitTest('3D')">Soumettre</button>
                </form>
                <div id="result3D" class="result">
                    <h3 id="resultTitle3D"></h3>
                    <p id="resultMessage3D"></p>
                </div>
            </div>
    
            <!-- Test Découpe Laser -->
            <div class="form-section collapse" id="testLaser">
                <h2>Test de Certification Découpe Laser</h2>
                <form id="testFormLaser">
                    <div>
                        <label for="question1_Laser">Question 1: Quel est le capital de la France?</label>
                        <input type="text" id="question1_Laser" name="question1_Laser" required>
                    </div>
                    <div>
                        <label for="question2_Laser">Question 2: Combien font 2 + 2?</label>
                        <input type="text" id="question2_Laser" name="question2_Laser" required>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="submitTest('Laser')">Soumettre</button>
                </form>
                <div id="resultLaser" class="result">
                    <h3 id="resultTitleLaser"></h3>
                    <p id="resultMessageLaser"></p>
                </div>
            </div>
        </div>
    
        <script>
            function submitTest(testType) {
                var question1, question2;
    
                if (testType === '3D') {
                    question1 = document.getElementById('question1_3D').value.toLowerCase().trim();
                    question2 = document.getElementById('question2_3D').value.trim();
                } else if (testType === 'Laser') {
                    question1 = document.getElementById('question1_Laser').value.toLowerCase().trim();
                    question2 = document.getElementById('question2_Laser').value.trim();
                }
    
                console.log('Test Type:', testType);
                console.log('Question 1:', question1);
                console.log('Question 2:', question2);
    
                var formData = new FormData();
                formData.append('test_type', testType);
                formData.append('question1', question1);
                formData.append('question2', question2);
    
                fetch('php/modele/submit_test.php', { // Assurez-vous que le chemin est correct
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Response Data:', data);
                    var resultTitle, resultMessage, resultDiv;
    
                    if (testType === '3D') {
                        resultTitle = document.getElementById('resultTitle3D');
                        resultMessage = document.getElementById('resultMessage3D');
                        resultDiv = document.getElementById('result3D');
                    } else if (testType === 'Laser') {
                        resultTitle = document.getElementById('resultTitleLaser');
                        resultMessage = document.getElementById('resultMessageLaser');
                        resultDiv = document.getElementById('resultLaser');
                    }
    
                    if (data.status === 'success') {
                        resultTitle.innerText = 'Félicitations!';
                        resultMessage.innerText = data.message;
                        resultDiv.className = 'result success';
                    } else {
                        resultTitle.innerText = 'Échec';
                        resultMessage.innerText = data.message;
                        resultDiv.className = 'result fail';
                    }
    
                    resultDiv.style.display = 'block';
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur s\'est produite. Veuillez réessayer.');
                });
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    
END;

    return $html;
}
?>
