<?php
// Démarrer la session
session_start();

// Détruire toutes les variables de session
$_SESSION = array();

// Détruire la session
session_destroy();

// Retourner une réponse JSON pour AJAX
if(isset($_GET['ajax']) && $_GET['ajax'] == 1) {
    echo json_encode(['success' => true, 'message' => 'Déconnexion réussie']);
    exit; // Arrêter l'exécution du script ici
}

// Rediriger vers la page d'accueil si pas en AJAX
header("Location: index.html");
exit;



?>