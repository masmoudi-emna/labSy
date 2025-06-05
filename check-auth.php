<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;

// Préparer les données de l'utilisateur si connecté
$userData = null;
if ($isLoggedIn) {
    $userData = [
        'id' => $_SESSION['user_id'] ?? '',
        'email' => $_SESSION['user_email'] ?? '',
        'nom' => $_SESSION['user_nom'] ?? '',
        'prenom' => $_SESSION['user_prenom'] ?? ''
    ];
}

// Retourner la réponse en JSON
header('Content-Type: application/json');
echo json_encode([
    'isLoggedIn' => $isLoggedIn,
    'userData' => $userData
]);
?> 