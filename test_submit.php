<?php
// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Résultats de soumission du formulaire</h1>";

// Afficher toutes les données POST reçues
echo "<h2>Données reçues (POST)</h2>";
echo "<pre>";
print_r($_POST);
echo "</pre>";

// Vérifier si tous les champs nécessaires sont présents
echo "<h2>Vérification des champs</h2>";
$required_fields = [
    'userId', 'sampleId', 'patientName', 'sampleType', 
    'tests', 'collectionDate', 'localisation', 'quantite', 'sampleStatus'
];

$missing_fields = [];
foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || empty($_POST[$field])) {
        $missing_fields[] = $field;
    }
}

if (empty($missing_fields)) {
    echo "Tous les champs requis sont présents.<br>";
} else {
    echo "Champs manquants: " . implode(', ', $missing_fields) . "<br>";
}

// Essayer d'insérer les données dans la base de données
echo "<h2>Tentative d'insertion dans la base de données</h2>";

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestiondesechantillons";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
} else {
    echo "Connexion à la base de données réussie.<br>";
}

// Récupération des données du formulaire
$userId = isset($_POST['userId']) ? $_POST['userId'] : '';
$nom_echantillon = isset($_POST['sampleId']) ? $_POST['sampleId'] : '';
$type_echantillon = isset($_POST['sampleType']) ? $_POST['sampleType'] : '';
$date_enregistrement = isset($_POST['collectionDate']) ? $_POST['collectionDate'] : date('Y-m-d');
$statut = isset($_POST['sampleStatus']) ? $_POST['sampleStatus'] : 'en_attente';

// Informations additionnelles pour la description
$patientName = isset($_POST['patientName']) ? $_POST['patientName'] : '';
$tests = isset($_POST['tests']) ? $_POST['tests'] : '';
$comments = isset($_POST['comments']) ? $_POST['comments'] : '';

// Créer la description complète
$description = "Patient: " . $patientName . ", Tests: " . $tests . ", Commentaires: " . $comments . ", User ID: " . $userId;

// Localisation et quantité directement du formulaire
$localisation = isset($_POST['localisation']) ? $_POST['localisation'] : 'Laboratoire principal';
$quantite = isset($_POST['quantite']) ? floatval($_POST['quantite']) : 1.00;

echo "<p>Valeurs formatées pour l'insertion:</p>";
echo "<ul>";
echo "<li>nom_echantillon: $nom_echantillon</li>";
echo "<li>date_enregistrement: $date_enregistrement</li>";
echo "<li>description: $description</li>";
echo "<li>localisation: $localisation</li>";
echo "<li>type_echantillon: $type_echantillon</li>";
echo "<li>quantite: $quantite</li>";
echo "<li>statut: $statut</li>";
echo "</ul>";

// Préparer et exécuter la requête d'insertion
$sql = "INSERT INTO enregistrer_echantillon (nom_echantillon, date_enregistrement, description, localisation, type_echantillon, quantite, statut) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sssssds", $nom_echantillon, $date_enregistrement, $description, $localisation, $type_echantillon, $quantite, $statut);
    
    if ($stmt->execute()) {
        echo "<p style='color:green;font-weight:bold;'>Insertion réussie! ID de l'échantillon inséré: $nom_echantillon</p>";
    } else {
        echo "<p style='color:red;font-weight:bold;'>Erreur lors de l'exécution de la requête: " . $stmt->error . "</p>";
    }
    
    $stmt->close();
} else {
    echo "<p style='color:red;font-weight:bold;'>Erreur de préparation de la requête: " . $conn->error . "</p>";
}

$conn->close();

// Ajouter un lien pour revenir au test
echo "<p><a href='test_echantillon.php'>Retour au test</a></p>";
?> 