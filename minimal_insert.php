<?php
// Afficher toutes les erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Traitement d'échantillon</h1>";

echo "<h2>Données reçues:</h2>";
echo "<pre>";
print_r($_POST);
echo "</pre>";

// Connexion database
$conn = new mysqli("localhost", "root", "", "gestiondesechantillons");

// Vérifier connexion
if ($conn->connect_error) {
    die("<p style='color:red'>Connexion échouée: " . $conn->connect_error . "</p>");
}
echo "<p style='color:green'>Connexion à la base de données réussie</p>";

// Récupérer données
$id = $_POST['sampleId'];
$patient = $_POST['patientName'];
$type = $_POST['sampleType'];
$date = $_POST['collectionDate'];
$loc = $_POST['localisation'];
$qte = $_POST['quantite'];
$statut = $_POST['sampleStatus'];
$description = "Patient: $patient, User ID: 1";

// Créer requête SQL
$sql = "INSERT INTO enregistrer_echantillon 
        (nom_echantillon, date_enregistrement, description, localisation, type_echantillon, quantite, statut) 
        VALUES ('$id', '$date', '$description', '$loc', '$type', $qte, '$statut')";

echo "<h2>Requête SQL:</h2>";
echo "<pre>$sql</pre>";

// Exécuter requête
if ($conn->query($sql) === TRUE) {
    echo "<p style='color:green'>Échantillon enregistré avec succès!</p>";
} else {
    echo "<p style='color:red'>Erreur: " . $conn->error . "</p>";
    
    // Vérifier si la table existe
    echo "<h2>Vérification de la table:</h2>";
    $result = $conn->query("SHOW TABLES LIKE 'enregistrer_echantillon'");
    if ($result->num_rows == 0) {
        echo "<p style='color:red'>La table 'enregistrer_echantillon' n'existe pas!</p>";
        
        // Créer la table
        echo "<h3>Création de la table:</h3>";
        $create_sql = "CREATE TABLE enregistrer_echantillon (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nom_echantillon VARCHAR(255) NOT NULL,
            date_enregistrement DATE NOT NULL,
            description TEXT,
            localisation VARCHAR(255),
            type_echantillon VARCHAR(100),
            quantite DECIMAL(10, 2) DEFAULT 1.00,
            statut VARCHAR(50) DEFAULT 'en_attente'
        )";
        
        if ($conn->query($create_sql) === TRUE) {
            echo "<p style='color:green'>Table créée avec succès! Essayez de soumettre à nouveau le formulaire.</p>";
        } else {
            echo "<p style='color:red'>Erreur lors de la création de la table: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color:green'>La table 'enregistrer_echantillon' existe.</p>";
        
        // Afficher la structure de la table
        echo "<h3>Structure de la table:</h3>";
        $result = $conn->query("DESCRIBE enregistrer_echantillon");
        echo "<pre>";
        while ($row = $result->fetch_assoc()) {
            print_r($row);
        }
        echo "</pre>";
    }
}

echo "<p><a href='minimal_form.html'>Retour au formulaire</a></p>";
echo "<p><a href='http://localhost/phpmyadmin/' target='_blank'>Ouvrir phpMyAdmin</a></p>";

$conn->close();
?> 