<?php
session_start();
header('Content-Type: application/json');
require_once 'config.php';

try {
    $sql = "SELECT * FROM echantillons ORDER BY date_enregistrement DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $echantillons = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'data' => $echantillons
    ]);
} catch(Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 