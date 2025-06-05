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

// Vérifier si l'ID de l'échantillon est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode([
        'success' => false,
        'message' => "ID de l'échantillon non fourni"
    ]);
    exit;
}

$id = $_GET['id'];

// Préparer et exécuter la requête de sélection
$sql = "SELECT * FROM enregistrer_echantillon WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Extraire les informations du patient et des tests à partir de la description
    $patientName = "";
    $tests = "";
    $comments = "";
    $userId = "";
    
    if (preg_match('/Patient: ([^,]+)/', $row['description'], $matches)) {
        $patientName = $matches[1];
    }
    
    if (preg_match('/Tests: ([^,]+)/', $row['description'], $matches)) {
        $tests = $matches[1];
    }
    
    if (preg_match('/Commentaires: ([^,]+)/', $row['description'], $matches)) {
        $comments = $matches[1];
    }
    
    if (preg_match('/User ID: ([^,]+)/', $row['description'], $matches)) {
        $userId = $matches[1];
    }
    
    // Formatage pour correspondre à l'ancienne structure utilisée par le frontend
    $sample = [
        'id' => $row['id'],
        'user_id' => $userId,
        'sample_id' => $row['nom_echantillon'],
        'patient_name' => $patientName,
        'sample_type' => $row['type_echantillon'],
        'tests' => $tests,
        'collection_date' => $row['date_enregistrement'],
        'sample_status' => $row['statut'],
        'comments' => $comments,
        'created_at' => $row['date_enregistrement'],
        'quantite' => $row['quantite'],
        'localisation' => $row['localisation']
    ];
    
    echo json_encode([
        'success' => true,
        'sample' => $sample
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => "Échantillon non trouvé"
    ]);
}

$stmt->close();
$conn->close();
?> 