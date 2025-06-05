<?php
// Démarrer la session
session_start();

// Connexion à la base de données
$host = 'localhost';
$user = 'root';
$pass = '';
$bd = 'gestiondesechantillons';
$con = mysqli_connect($host, $user, $pass, $bd);

// Vérification de la connexion
if (!$con) {
    die(json_encode(['success' => false, 'message' => 'Erreur de connexion à la base de données']));
}

// Vérification si la requête est envoyée via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $motDePass1 = mysqli_real_escape_string($con, $_POST['motDePass1']);
    
    // Vérifier si l'utilisateur existe
    $sql = "SELECT * FROM inscription WHERE email = '$email' AND motDePass1 = '$motDePass1'";
    $result = mysqli_query($con, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        // Récupérer les données de l'utilisateur
        $user_data = mysqli_fetch_assoc($result);
        
        // Stocker les informations de l'utilisateur en session
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $user_data['id'];
        $_SESSION['user_email'] = $user_data['email'];
        $_SESSION['user_nom'] = $user_data['nom'];
        $_SESSION['user_prenom'] = $user_data['prenom'];
        
        // Si l'utilisateur est trouvé, renvoyer une réponse de succès avec URL de redirection
        // Cette réponse sera utilisée par JavaScript pour stocker les données dans sessionStorage
        echo json_encode([
            'success' => true, 
            'message' => 'Connexion réussie', 
            'redirect' => 'index.html', 
            'userData' => [
                'id' => $user_data['id'],
                'email' => $user_data['email'],
                'nom' => $user_data['nom'],
                'prenom' => $user_data['prenom']
            ]
        ]);
        
    } else {
        // Si l'utilisateur n'est pas trouvé, renvoyer une erreur
        echo json_encode(['success' => false, 'message' => 'Email ou mot de passe incorrect']);
    }
}

// Fermer la connexion
mysqli_close($con);
?>
