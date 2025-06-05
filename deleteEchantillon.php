<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestiondesechantillons";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die(json_encode([
        'success' => false,
        'message' => "Connexion échouée: " . $conn->connect_error
    ]));
}

// Vérifier si la requête est de type POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo json_encode([
        'success' => false,
        'message' => "Méthode non autorisée"
    ]);
    exit;
}

// Vérifier si l'ID utilisateur et l'ID de l'échantillon sont fournis
if (!isset($_POST['userId']) || empty($_POST['userId']) || !isset($_POST['sampleId']) || empty($_POST['sampleId'])) {
    echo json_encode([
        'success' => false,
        'message' => "Paramètres manquants"
    ]);
    exit;
}

$userId = $_POST['userId'];
$sampleId = $_POST['sampleId'];

// D'abord, vérifiez si l'échantillon appartient à l'utilisateur
$checkSql = "SELECT * FROM enregistrer_echantillon WHERE nom_echantillon = ? AND description LIKE ?";
$searchTerm = "%User ID: " . $userId . "%";

$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("ss", $sampleId, $searchTerm);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows == 0) {
    echo json_encode([
        'success' => false,
        'message' => "Échantillon non trouvé ou vous n'avez pas l'autorisation de le supprimer"
    ]);
    $checkStmt->close();
    $conn->close();
    exit;
}

// Préparer et exécuter la requête de suppression
$sql = "DELETE FROM enregistrer_echantillon WHERE nom_echantillon = ? AND description LIKE ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $sampleId, $searchTerm);
$stmt->execute();

// Vérifier si la suppression a été effectuée
if ($stmt->affected_rows > 0) {
    echo json_encode([
        'success' => true,
        'message' => "Échantillon supprimé avec succès"
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => "Erreur lors de la suppression de l'échantillon"
    ]);
}

$stmt->close();
$conn->close();
?> 