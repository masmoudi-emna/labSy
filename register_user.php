<?php
header('Content-Type: application/json');
require_once 'config.php';

try {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérifier si l'email existe déjà
    $stmt = $pdo->prepare("SELECT id FROM inscription WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        throw new Exception('Cet email est déjà utilisé');
    }

    // Insérer le nouvel utilisateur
    $stmt = $pdo->prepare("INSERT INTO inscription (nom, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$nom, $email, $password]);

    echo json_encode([
        'success' => true,
        'message' => 'Utilisateur inscrit avec succès'
    ]);

} catch(Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 