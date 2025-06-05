<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $pdo = new PDO("mysql:host=localhost;dbname=labsys", "root", "");
    echo "Connexion à la base de données réussie!<br>";
    
    $sql = "SHOW TABLES";
    $stmt = $pdo->query($sql);
    echo "Tables dans la base de données:<br>";
    while($row = $stmt->fetch()) {
        echo "- " . $row[0] . "<br>";
    }
    
    $sql = "DESCRIBE inscription";
    $stmt = $pdo->query($sql);
    echo "<br>Structure de la table inscription:<br>";
    while($row = $stmt->fetch()) {
        echo "- " . $row['Field'] . " (" . $row['Type'] . ")<br>";
    }
    
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}
?> 