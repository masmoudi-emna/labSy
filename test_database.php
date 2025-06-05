<?php
// Afficher toutes les erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Test et configuration de la base de données</h1>";

// Connexion au serveur MySQL sans spécifier de base de données
$conn = new mysqli("localhost", "root", "");

// Vérifier la connexion
if ($conn->connect_error) {
    die("<p style='color:red'>Connexion au serveur MySQL échouée: " . $conn->connect_error . "</p>");
}
echo "<p style='color:green'>Connexion au serveur MySQL réussie</p>";

// Vérifier si la base de données existe
$db_name = "gestiondesechantillons";
$result = $conn->query("SHOW DATABASES LIKE '$db_name'");

if ($result->num_rows == 0) {
    echo "<p style='color:orange'>La base de données '$db_name' n'existe pas.</p>";
    
    // Créer la base de données
    if ($conn->query("CREATE DATABASE $db_name") === TRUE) {
        echo "<p style='color:green'>Base de données '$db_name' créée avec succès!</p>";
    } else {
        echo "<p style='color:red'>Erreur lors de la création de la base de données: " . $conn->error . "</p>";
        exit;
    }
} else {
    echo "<p style='color:green'>La base de données '$db_name' existe déjà.</p>";
}

// Se connecter à la base de données
$conn->select_db($db_name);
echo "<p>Connexion à la base de données '$db_name' réussie</p>";

// Vérifier si la table existe
$table_name = "enregistrer_echantillon";
$result = $conn->query("SHOW TABLES LIKE '$table_name'");

if ($result->num_rows == 0) {
    echo "<p style='color:orange'>La table '$table_name' n'existe pas.</p>";
    
    // Créer la table
    $sql = "CREATE TABLE $table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom_echantillon VARCHAR(255) NOT NULL,
        date_enregistrement DATE NOT NULL,
        description TEXT,
        localisation VARCHAR(255),
        type_echantillon VARCHAR(100),
        quantite DECIMAL(10, 2) DEFAULT 1.00,
        statut VARCHAR(50) DEFAULT 'en_attente'
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green'>Table '$table_name' créée avec succès!</p>";
        
        // Insérer un échantillon de test
        $sql = "INSERT INTO $table_name 
                (nom_echantillon, date_enregistrement, description, localisation, type_echantillon, quantite, statut) 
                VALUES ('TEST_" . time() . "', '" . date('Y-m-d') . "', 'Patient: Test Auto, User ID: 1', 'Laboratoire', 'sang', 1.00, 'en_attente')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<p style='color:green'>Échantillon de test inséré avec succès!</p>";
        } else {
            echo "<p style='color:red'>Erreur lors de l'insertion de l'échantillon de test: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color:red'>Erreur lors de la création de la table: " . $conn->error . "</p>";
    }
} else {
    echo "<p style='color:green'>La table '$table_name' existe déjà.</p>";
    
    // Afficher la structure de la table
    echo "<h2>Structure de la table:</h2>";
    $result = $conn->query("DESCRIBE $table_name");
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Champ</th><th>Type</th><th>Null</th><th>Clé</th><th>Défaut</th><th>Extra</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["Field"] . "</td>";
        echo "<td>" . $row["Type"] . "</td>";
        echo "<td>" . $row["Null"] . "</td>";
        echo "<td>" . $row["Key"] . "</td>";
        echo "<td>" . ($row["Default"] === NULL ? "NULL" : $row["Default"]) . "</td>";
        echo "<td>" . $row["Extra"] . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    // Afficher quelques données
    echo "<h2>Échantillons existants (5 derniers):</h2>";
    $result = $conn->query("SELECT * FROM $table_name ORDER BY id DESC LIMIT 5");
    
    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Nom échantillon</th><th>Date</th><th>Type</th><th>Statut</th></tr>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["nom_echantillon"] . "</td>";
            echo "<td>" . $row["date_enregistrement"] . "</td>";
            echo "<td>" . $row["type_echantillon"] . "</td>";
            echo "<td>" . $row["statut"] . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "<p>Aucun échantillon trouvé dans la table.</p>";
    }
}

// Liens utiles
echo "<h2>Liens utiles</h2>";
echo "<ul>";
echo "<li><a href='minimal_form.html'>Aller au formulaire minimal</a></li>";
echo "<li><a href='http://localhost/phpmyadmin/' target='_blank'>Ouvrir phpMyAdmin</a></li>";
echo "</ul>";

$conn->close();
?> 