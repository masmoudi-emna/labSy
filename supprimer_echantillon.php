<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Non connecté']);
    exit;
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=gestiondesechantillons", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("DELETE FROM enregistrer_echantillon WHERE id = ?");
    $stmt->execute([$_POST['id']]);

    echo json_encode(['success' => true, 'message' => 'Échantillon supprimé avec succès']);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?> 