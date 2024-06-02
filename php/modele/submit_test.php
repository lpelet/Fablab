<?php
session_start();
error_log("Script submit_test.php started");

try {
    $db = new PDO('mysql:host=localhost;dbname=fablab', 'fablab', 'fablab');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

$conn = new mysqli('localhost', 'fablab', 'fablab', 'fablab');

if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die(json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]));
}
error_log("Connection to database established");

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    error_log("User not logged in");
    echo json_encode(['status' => 'error', 'message' => 'Vous devez être connecté pour passer le test.']);
    exit();
}

$user_id = $_SESSION['user_id'];
$test_type = $_POST['test_type'];
$question1 = strtolower(trim($_POST['question1']));
$question2 = strtolower(trim($_POST['question2']));
$question3 = strtolower(trim($_POST['question3']));
$question4 = strtolower(trim($_POST['question4']));
$question5 = strtolower(trim($_POST['question5']));

error_log("Test Type: $test_type, Question 1: $question1, Question 2: $question2, Question 3: $question3, Question 4: $question4, Question 5: $question5");

// Vérification des réponses pour le test Imprimante 3D
$validAnswers3D = [
    'stl',   // Réponse pour la question 1
    'cura',  // Réponse pour la question 2
    'buse',  // Réponse pour la question 3
    'adhérence', // Réponse pour la question 4
    'poncer' // Réponse pour la question 5
];

// Vérification des réponses pour le test Découpe Laser
$validAnswersLaser = [
    'dxf',      // Réponse pour la question 1
    'ventilation', // Réponse pour la question 2
    'hauteur',   // Réponse pour la question 3
    'incendie',  // Réponse pour la question 4
    'pvc'      // Réponse pour la question 5
];

// Vérification des réponses (ajustez les conditions selon vos besoins)
if ($test_type === '3D' && 
    $question1 === $validAnswers3D[0] && 
    $question2 === $validAnswers3D[1] && 
    $question3 === $validAnswers3D[2] && 
    $question4 === $validAnswers3D[3] && 
    $question5 === $validAnswers3D[4]) {
    $certification_type = 1; // ID de l'Imprimante 3D dans la table Formations
} elseif ($test_type === 'Laser' && 
    $question1 === $validAnswersLaser[0] && 
    $question2 === $validAnswersLaser[1] && 
    $question3 === $validAnswersLaser[2] && 
    $question4 === $validAnswersLaser[3] && 
    $question5 === $validAnswersLaser[4]) {
    $certification_type = 2; // ID de la Découpe Laser dans la table Formations
} else {
    error_log("Test failed: Wrong answers");
    echo json_encode(['status' => 'fail', 'message' => 'Vous n\'avez pas réussi le test. Veuillez réessayer.']);
    exit();
}

// Vérifiez si l'utilisateur a déjà cette certification
$query = "SELECT * FROM certifications WHERE ID_Utilisateur = ? AND ID_Formation = ?";
error_log("Prepare query: $query");
$stmt = $conn->prepare($query);
if (!$stmt) {
    error_log("Prepare failed (select): " . $conn->error);
    echo json_encode(['status' => 'error', 'message' => 'Erreur de requête lors de la vérification de la certification.']);
    exit();
}
$stmt->bind_param("ii", $user_id, $certification_type);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Met à jour la certification existante
    $update_query = "UPDATE certifications SET DateObtention = NOW(), Score = ? WHERE ID_Utilisateur = ? AND ID_Formation = ?";
    error_log("Prepare update query: $update_query");
    $stmt = $conn->prepare($update_query);
    if (!$stmt) {
        error_log("Prepare failed (update): " . $conn->error);
        echo json_encode(['status' => 'error', 'message' => 'Erreur de requête lors de la mise à jour de la certification.']);
        exit();
    }
    $score = 100; // Note fixe pour simplifier, vous pouvez adapter
    $stmt->bind_param("iii", $score, $user_id, $certification_type);
    if ($stmt->execute()) {
        error_log("Certification updated for user $user_id");
        echo json_encode(['status' => 'success', 'message' => 'Félicitations! Votre certification a été mise à jour.']);
    } else {
        error_log("Failed to update certification: " . $stmt->error);
        echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la mise à jour de la certification.']);
    }
} else {
    // Insère une nouvelle certification
    $insert_query = "INSERT INTO certifications (ID_Utilisateur, ID_Formation, DateObtention, Score) VALUES (?, ?, NOW(), ?)";
    error_log("Prepare insert query: $insert_query");
    $stmt = $conn->prepare($insert_query);
    if (!$stmt) {
        error_log("Prepare failed (insert): " . $conn->error);
        echo json_encode(['status' => 'error', 'message' => 'Erreur de requête lors de l\'insertion de la certification.']);
        exit();
    }
    $score = 100; // Note fixe pour simplifier, vous pouvez adapter
    $stmt->bind_param("iii", $user_id, $certification_type, $score);

    if ($stmt->execute()) {
        // Met à jour le champ StatutCertification de l'utilisateur
        $update_user_query = "UPDATE utilisateurs SET StatutCertification = ? WHERE ID_Utilisateur = ?";
        error_log("Prepare update user query: $update_user_query");
        $stmt = $conn->prepare($update_user_query);
        if (!$stmt) {
            error_log("Prepare failed (update user): " . $conn->error);
            echo json_encode(['status' => 'error', 'message' => 'Erreur de requête lors de la mise à jour de l\'utilisateur.']);
            exit();
        }
        $certification_status = ($certification_type == 1) ? 'imprimante_3d' : 'decoupe_laser';
        $stmt->bind_param("si", $certification_status, $user_id);
        if ($stmt->execute()) {
            error_log("Certification granted: $certification_status for user $user_id");
            echo json_encode(['status' => 'success', 'message' => 'Félicitations! Vous avez obtenu la certification.']);
        } else {
            error_log("Failed to update user certification: " . $stmt->error);
            echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'attribution de la certification.']);
        }
    } else {
        error_log("Failed to insert certification: " . $stmt->error);
        echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'attribution de la certification.']);
    }
}

$stmt->close();
$conn->close();
?>
