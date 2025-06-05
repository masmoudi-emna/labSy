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

// Vérifier si l'ID utilisateur est fourni
if (!isset($_GET['userId']) || empty($_GET['userId'])) {
    echo json_encode([
        'success' => false,
        'message' => "ID utilisateur non fourni"
    ]);
    exit;
}

$userId = $_GET['userId'];

// Préparer et exécuter la requête de sélection
// Nous allons chercher les échantillons où l'ID utilisateur est mentionné dans la description
$sql = "SELECT * FROM enregistrer_echantillon WHERE description LIKE ? ORDER BY date_enregistrement DESC";
$searchTerm = "%User ID: " . $userId . "%";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$samples = [];
while ($row = $result->fetch_assoc()) {
    // Extraire les informations du patient et des tests à partir de la description
    $patientName = "";
    $tests = "";
    $comments = "";
    
    if (preg_match('/Patient: ([^,]+)/', $row['description'], $matches)) {
        $patientName = $matches[1];
    }
    
    if (preg_match('/Tests: ([^,]+)/', $row['description'], $matches)) {
        $tests = $matches[1];
    }
    
    if (preg_match('/Commentaires: ([^,]+)/', $row['description'], $matches)) {
        $comments = $matches[1];
    }
    
    // Formatage pour correspondre à l'ancienne structure utilisée par le frontend
    $samples[] = [
        'id' => $row['id'],
        'sample_id' => $row['nom_echantillon'],
        'patient_name' => $patientName,
        'sample_type' => $row['type_echantillon'],
        'tests' => $tests,
        'collection_date' => $row['date_enregistrement'],
        'sample_status' => $row['statut'],
        'comments' => $comments,
        'created_at' => $row['date_enregistrement']
    ];
}

echo json_encode([
    'success' => true,
    'samples' => $samples
]);

$stmt->close();
$conn->close();
?> 