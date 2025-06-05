<?php
session_start();
header('Content-Type: application/json');
require_once 'config.php';

try {
    // Vérifier si les données sont reçues
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        throw new Exception('Email et mot de passe requis');
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Debug
    error_log("Tentative de connexion pour email: " . $email);

    // Requête pour trouver l'utilisateur
    $sql = "SELECT * FROM inscription WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Debug
    error_log("Utilisateur trouvé: " . print_r($user, true));

    if ($user) {
        // Vérifier le mot de passe
        if ($password === $user['password']) { // À remplacer par password_verify() dans un environnement de production
            // Créer la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nom'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['logged_in'] = true;

            echo json_encode([
                'success' => true,
                'message' => 'Connexion réussie',
                'redirect' => 'MesEchantillons.html'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Mot de passe incorrect'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Utilisateur non trouvé'
        ]);
    }

} catch(Exception $e) {
    error_log("Erreur de connexion: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Erreur: ' . $e->getMessage()
    ]);
}
?> 