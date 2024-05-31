<?php
session_start();
error_log("Script submit_test.php started");

try {
    $db = new PDO('mysql:host=localhost;dbname=fablab', 'fablab', 'fablab');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die(json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    error_log("User not logged in");
    echo json_encode(['status' => 'error', 'message' => 'Vous devez être connecté pour passer le test.']);
    exit();
}

$user_id = $_SESSION['user_id'];
$test_type = $_POST['test_type'];
$question1 = strtolower(trim($_POST['question1']));
$question2 = trim($_POST['question2']);

error_log("Test Type: $test_type, Question 1: $question1, Question 2: $question2");

// Vérification des réponses (ajustez les conditions selon vos besoins)
if ($test_type === '3D' && $question1 === 'paris' && $question2 === '4') {
    $certification_type = 1; // ID de l'Imprimante 3D dans la table Formations
} elseif ($test_type === 'Laser' && $question1 === 'paris' && $question2 === '4') {
    $certification_type = 2; // ID de la Découpe Laser dans la table Formations
} else {
    error_log("Test failed: Wrong answers");
    echo json_encode(['status' => 'fail', 'message' => 'Vous n\'avez pas réussi le test. Veuillez réessayer.']);
    exit();
}

// Vérifiez si l'utilisateur a déjà cette certification
$stmt = $conn->prepare("SELECT * FROM certifications WHERE ID_Utilisateur = ? AND ID_Formation = ?");
if (!$stmt) {
    error_log("Prepare failed: " . $conn->error);
    echo json_encode(['status' => 'error', 'message' => 'Erreur de requête.']);
    exit();
}
$stmt->bind_param("ii", $user_id, $certification_type);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    error_log("User already has this certification");
    echo json_encode(['status' => 'error', 'message' => 'Vous avez déjà cette certification.']);
    exit();
}

// Insertion de la certification dans la base de données
$stmt = $conn->prepare("INSERT INTO certifications (ID_Utilisateur, ID_Formation, DateObtention, Score) VALUES (?, ?, NOW(), ?)");
if (!$stmt) {
    error_log("Prepare failed: " . $conn->error);
    echo json_encode(['status' => 'error', 'message' => 'Erreur de requête.']);
    exit();
}
$score = 100; // Note fixe pour simplifier, vous pouvez adapter
$stmt->bind_param("iii", $user_id, $certification_type, $score);

if ($stmt->execute()) {
    // Met à jour le champ StatutCertification de l'utilisateur
    $stmt = $conn->prepare("UPDATE utilisateurs SET StatutCertification = ? WHERE ID_Utilisateur = ?");
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        echo json_encode(['status' => 'error', 'message' => 'Erreur de requête.']);
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

$stmt->close();
$conn->close();
?>
