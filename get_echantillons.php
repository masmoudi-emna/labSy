<?php
session_start();
header('Content-Type: application/json');

// Log pour le débogage
error_log('Fetching echantillons - Session: ' . print_r($_SESSION, true));

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false, 
        'message' => 'Non connecté',
        'session_debug' => $_SESSION
    ]);
    exit;
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=gestiondesechantillons", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT * FROM enregistrer_echantillon WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $echantillons = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Log pour le débogage
    error_log('Echantillons trouvés: ' . count($echantillons));

    echo json_encode([
        'success' => true, 
        'data' => $echantillons,
        'user_id' => $_SESSION['user_id']
    ]);
} catch(PDOException $e) {
    error_log('Erreur DB: ' . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
}
?> 