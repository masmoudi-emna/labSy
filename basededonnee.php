<?php
// Connexion à la base de données
$host = 'localhost';
$user = 'root';
$pass = '';
$bd = 'gestiondesechantillons';

$con = mysqli_connect($host, $user, $pass, $bd);
if (!$con) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

// Vérification si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $motDePass1 = $_POST['motDePass1'];

    // Vérifier que les champs ne sont pas vides
    if (!empty($id) && !empty($nom) && !empty($prenom) && !empty($email) && !empty($motDePass1)) {
        $sql = "INSERT INTO inscription (id, nom, prenom, email, motDePass1) 
                VALUES ('$id', '$nom', '$prenom', '$email', '$motDePass1')";

        if (mysqli_query($con, $sql)) {
            echo "✅ Inscription réussie !";
        } else {
            echo "❌ Erreur : " . mysqli_error($con);
        }
    } else {
        echo "⚠️ Tous les champs sont obligatoires.";
    }
}




// 📌 SUPPRIMER UN TECHNICIEN
if (isset($_POST['remove'])) {
    $id_delete = intval($_POST['id_delete']);

    // Vérifier si l'ID existe
    $check_sql = "SELECT * FROM inscription WHERE id = $id_delete";
    $result = mysqli_query($con, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        // Suppression de l'utilisateur
        $delete_sql = "DELETE FROM inscription WHERE id = $id_delete";
        if (mysqli_query($con, $delete_sql)) {
            echo "Technicien supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression : " . mysqli_error($con);
        }
    } else {
        echo "Aucun technicien trouvé avec cet ID.";
    }
}

// Fermer la connexion
mysqli_close($con);


?>
