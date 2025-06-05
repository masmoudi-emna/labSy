<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'labsys');
define('DB_USER', 'root'); // Remplacez par votre nom d'utilisateur MySQL
define('DB_PASS', ''); // Remplacez par votre mot de passe MySQL

try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?> 