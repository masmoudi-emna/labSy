<?php
try {
    $pdo = new PDO("mysql:host=localhost", "root", "");
    echo "Connexion MySQL OK<br>";
    
    $pdo->exec("CREATE DATABASE IF NOT EXISTS labsys");
    echo "Base de données labsys créée/existante<br>";
    
    $pdo->exec("USE labsys");
    echo "Base de données labsys sélectionnée<br>";
    
    echo "Tout est OK!";
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?> 