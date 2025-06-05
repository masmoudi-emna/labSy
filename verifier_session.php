<?php
session_start();
header('Content-Type: application/json');

$response = [
    'authenticated' => isset($_SESSION['user_id']),
    'message' => isset($_SESSION['user_id']) ? 'Authentifié' : 'Non authentifié'
];

echo json_encode($response);
?> 