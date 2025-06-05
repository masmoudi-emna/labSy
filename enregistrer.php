<?php

// Activer l'affichage des erreurs pour le débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Définir le type de contenu comme JSON
header('Content-Type: application/json');

// Démarrer la session
session_start();

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "gestiondesechantillons");

// Vérifier la connexion
if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Erreur de connexion à la base de données: ' . $conn->connect_error
    ]);
    exit;
}

// Vérifier si une requête POST a été envoyée
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $patient = isset($_POST['patientName']) ? trim($_POST['patientName']) : '';
    $echantillon_type = isset($_POST['sampleType']) ? trim($_POST['sampleType']) : '';
    $test_type = isset($_POST['testType']) ? trim($_POST['testType']) : '';
    $date = isset($_POST['collectionDate']) ? $_POST['collectionDate'] : '';
    $quantite = isset($_POST['quantite']) ? floatval($_POST['quantite']) : 1.00;
    $statut = isset($_POST['sampleStatus']) ? trim($_POST['sampleStatus']) : 'en_attente';
    $comments = isset($_POST['comments']) ? trim($_POST['comments']) : '';

    // Récupérer l'ID utilisateur (depuis la session ou le formulaire)
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : (isset($_POST['userId']) ? $_POST['userId'] : 1);

    // Vérifier que les champs obligatoires sont remplis
    if (empty($patient) || empty($echantillon_type) || empty($test_type) || empty($date) || empty($quantite)) {
        echo json_encode([
            'success' => false,
            'message' => 'Tous les champs obligatoires doivent être remplis.'
        ]);
        exit;
    }

    // Vérifier si la table existe
    $tableExists = $conn->query("SHOW TABLES LIKE 'enregistrer_echantillon'")->num_rows > 0;

    if (!$tableExists) {
        // Créer la table si elle n'existe pas
        $sql = "CREATE TABLE enregistrer_echantillon (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nom_patient VARCHAR(255) NOT NULL,
            date_enregistrement DATE NOT NULL,
            echantillon_type VARCHAR(100) NOT NULL,
            test_type VARCHAR(100) NOT NULL,
            quantite DECIMAL(10,2) DEFAULT 1.00,
            statut VARCHAR(50) DEFAULT 'en_attente',
            description TEXT,
            user_id INT NOT NULL
        )";

        if (!$conn->query($sql)) {
            echo json_encode([
                'success' => false,
                'message' => 'Erreur lors de la création de la table: ' . $conn->error
            ]);
            exit;
        }
    }

    // Créer la description
    $description = "Patient: $patient" . ($comments ? ", Commentaires: $comments" : "") . ", User ID: $userId";

    // Préparer la requête SQL d'insertion
    $sql = "INSERT INTO enregistrer_echantillon 
            (nom_patient, date_enregistrement, echantillon_type, test_type, quantite, statut, description, user_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Préparer la requête
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind des paramètres (s = string, d = double, i = integer)
        $stmt->bind_param("ssssdsis", $patient, $date, $echantillon_type, $test_type, $quantite, $statut, $description, $userId);

        // Exécuter la requête
        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'Échantillon enregistré avec succès!',
                'id' => $conn->insert_id
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Erreur lors de l\'enregistrement: ' . $stmt->error
            ]);
        }

        // Fermer la requête préparée
        $stmt->close();
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Erreur de préparation de la requête: ' . $conn->error
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Méthode non autorisée. Utilisez POST pour soumettre des données.'
    ]);
}

// Fermer la connexion
$conn->close();

?>
