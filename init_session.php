<?php
// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrer la session
session_start();

// Initialiser les variables de session pour un utilisateur test
$_SESSION['loggedin'] = true;
$_SESSION['user_id'] = 1;
$_SESSION['user_email'] = 'test@example.com';
$_SESSION['user_nom'] = 'Utilisateur';
$_SESSION['user_prenom'] = 'Test';

echo "<h1>Session initialisée</h1>";
echo "<p>Une session a été créée pour un utilisateur de test.</p>";
echo "<p>Voici les valeurs de session qui ont été définies:</p>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

// Ajouter du code JavaScript pour définir le sessionStorage
echo "<script>
sessionStorage.setItem('user_id', '1');
sessionStorage.setItem('user_email', 'test@example.com');
sessionStorage.setItem('user_nom', 'Utilisateur');
sessionStorage.setItem('user_prenom', 'Test');
console.log('sessionStorage initialisé');
</script>";

echo "<p>Le sessionStorage a également été initialisé avec les mêmes valeurs.</p>";
echo "<p>Vous devriez maintenant pouvoir accéder aux pages protégées.</p>";
echo "<p><a href='EnregistrerUnEchantillons.html'>Aller à la page d'enregistrement d'échantillons</a></p>";
?> 