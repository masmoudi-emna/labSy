<?php
// Activer l'affichage des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Informations de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestiondesechantillons";

echo "<h1>Vérification de la table 'enregistrer_echantillon'</h1>";

// Connexion à la base de données
try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    echo "<p style='color:green'>Connexion à la base de données réussie</p>";
} catch (Exception $e) {
    die("<p style='color:red'>Erreur de connexion: " . $e->getMessage() . "</p>");
}

// Vérifier si la connexion a réussi
if ($conn->connect_error) {
    die("<p style='color:red'>Erreur de connexion à la base de données: " . $conn->connect_error . "</p>");
}

// Vérifier si la table existe
$result = $conn->query("SHOW TABLES LIKE 'enregistrer_echantillon'");
if ($result->num_rows > 0) {
    echo "<p style='color:green'>La table 'enregistrer_echantillon' existe.</p>";
} else {
    echo "<p style='color:red'>La table 'enregistrer_echantillon' n'existe pas!</p>";
    
    // Proposer de créer la table
    echo "<h2>Création de la table</h2>";
    echo "<p>Voulez-vous créer la table? <a href='create_table.php' style='color:blue'>Cliquez ici pour créer la table</a></p>";
    
    $conn->close();
    exit;
}

// Afficher la structure de la table
$result = $conn->query("DESCRIBE enregistrer_echantillon");
if ($result) {
    echo "<h2>Structure de la table</h2>";
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
} else {
    echo "<p style='color:red'>Erreur lors de la récupération de la structure de la table: " . $conn->error . "</p>";
}

// Afficher les données existantes
$result = $conn->query("SELECT * FROM enregistrer_echantillon LIMIT 10");
if ($result) {
    if ($result->num_rows > 0) {
        echo "<h2>Données existantes (10 premiers enregistrements)</h2>";
        echo "<table border='1' cellpadding='5'>";
        
        // En-têtes de colonnes
        $row = $result->fetch_assoc();
        echo "<tr>";
        foreach ($row as $key => $value) {
            echo "<th>" . $key . "</th>";
        }
        echo "</tr>";
        
        // Réinitialiser le pointeur de résultat
        $result->data_seek(0);
        
        // Données
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . (strlen($value) > 50 ? substr($value, 0, 47) . "..." : $value) . "</td>";
            }
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "<p>La table est vide. Aucun enregistrement trouvé.</p>";
    }
} else {
    echo "<p style='color:red'>Erreur lors de la récupération des données: " . $conn->error . "</p>";
}

// Fermer la connexion
$conn->close();
?> 