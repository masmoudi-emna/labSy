<?php
session_start();
header('Content-Type: application/json');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Vous devez être connecté pour enregistrer un échantillon']);
    exit;
}

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=localhost;dbname=gestiondesechantillons", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparation de la requête sans spécifier l'ID (il sera auto-incrémenté)
    $sql = "INSERT INTO enregistrer_echantillon (
        id_echantillon,
        nom_patient, 
        date_enregistrement, 
        echantillon_type, 
        test_type, 
        quantite, 
        statut,
        user_id
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    
    // Exécution de la requête avec les données du formulaire
    $stmt->execute([
        $_POST['sample_id'],
        $_POST['nom_patient'],
        $_POST['date_enregistrement'],
        $_POST['echantillon_type'],
        $_POST['test_type'],
        $_POST['quantite'],
        $_POST['statut'],
        isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1
    ]);

    echo json_encode([
        'success' => true, 
        'message' => 'Échantillon enregistré avec succès',
        'id' => $pdo->lastInsertId()
    ]);

} catch(PDOException $e) {
    // Gestion spécifique de l'erreur de doublon
    if ($e->getCode() == '23000') {
        echo json_encode([
            'success' => false, 
            'message' => 'Cet ID d\'échantillon existe déjà. Veuillez réessayer avec un nouvel ID.'
        ]);
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'Erreur lors de l\'enregistrement: ' . $e->getMessage()
        ]);
    }
}
?> 