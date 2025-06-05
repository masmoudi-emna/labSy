// Fonctions pour gérer l'authentification et l'état de l'interface
document.addEventListener('DOMContentLoaded', function() {
    // Vérifier si l'utilisateur est connecté via le serveur
    checkServerLoginStatus();
    
    // Attacher les écouteurs d'événements
    attachEventListeners();
});

// Vérifier l'état de connexion côté serveur
function checkServerLoginStatus() {
    fetch('check-auth.php')
        .then(response => response.json())
        .then(data => {
            if (data.isLoggedIn && data.userData) {
                // Mettre à jour localStorage avec les données serveur
                localStorage.setItem('loggedIn', 'true');
                localStorage.setItem('userData', JSON.stringify(data.userData));
                
                // Mettre à jour l'interface
                updateInterface(true, data.userData);
            } else {
                // Vérifier le localStorage comme fallback
                checkLocalLoginStatus();
            }
        })
        .catch(error => {
            console.error('Erreur lors de la vérification de session:', error);
            // Fallback vers localStorage en cas d'erreur
            checkLocalLoginStatus();
        });
}

// Vérifier si l'utilisateur est connecté en vérifiant localStorage
function checkLocalLoginStatus() {
    const isLoggedIn = localStorage.getItem('loggedIn') === 'true';
    const userData = JSON.parse(localStorage.getItem('userData') || '{}');
    
    // Mettre à jour l'interface en fonction de l'état de connexion
    updateInterface(isLoggedIn, userData);
}

// Mettre à jour l'interface utilisateur en fonction de l'état de connexion
function updateInterface(isLoggedIn, userData) {
    const connexionLink = document.querySelector('a[href="seConnecter.html"]')?.closest('h3');
    const inscriptionLink = document.querySelector('a[href="inscription.html"]')?.closest('h3');
    const deconnexionLink = document.getElementById('deconnexion-link');
    const userInfoContainer = document.getElementById('user-info-container');
    
    if (isLoggedIn && userData) {
        // Masquer le lien d'inscription
        if (inscriptionLink) inscriptionLink.style.display = 'none';
        
        // Changer le lien de connexion en lien de déconnexion s'il n'existe pas déjà
        if (connexionLink) {
            if (!deconnexionLink) {
                // Créer un lien de déconnexion
                connexionLink.innerHTML = `<h3 class="fw-bolder" id="deconnexion-link">
                    <a href="#" onclick="logout(event)"><i class="fa-solid fa-sign-out-alt"></i> 
                    <span class="d-none d-sm-inline">Se déconnecter</span></a>
                </h3>`;
            }
        }
        
        // Afficher le nom de l'utilisateur s'il existe un conteneur prévu à cet effet
        if (userInfoContainer) {
            userInfoContainer.innerHTML = `<span class="text-primary fw-bold">
                Bienvenue, ${userData.prenom || 'Utilisateur'} ${userData.nom || ''}
            </span>`;
            userInfoContainer.style.display = 'block';
        }
    } else {
        // Réinitialiser l'interface en mode déconnecté
        if (inscriptionLink) inscriptionLink.style.display = '';
        if (connexionLink && connexionLink.id === 'deconnexion-link') {
            connexionLink.innerHTML = `<h3 class="fw-bolder" id="icon1">
                <a href="seConnecter.html"><i class="fa-solid fa-user"></i> 
                <span class="d-none d-sm-inline">se connecter</span></a>
            </h3>`;
        }
        if (userInfoContainer) userInfoContainer.style.display = 'none';
    }
}

// Fonction pour gérer la connexion
function handleLogin(userData) {
    // Stocker les données utilisateur
    localStorage.setItem('loggedIn', 'true');
    localStorage.setItem('userData', JSON.stringify(userData));
    
    // Mettre à jour l'interface
    updateInterface(true, userData);
}

// Fonction pour gérer la déconnexion
function logout(event) {
    if (event) event.preventDefault();
    
    // Appeler l'API de déconnexion
    fetch('deconnexion.php?ajax=1')
        .then(response => response.json())
        .then(data => {
            // Effacer les données de session côté client
            localStorage.removeItem('loggedIn');
            localStorage.removeItem('userData');
            
            // Mettre à jour l'interface
            updateInterface(false, null);
            
            // Rediriger vers la page d'accueil
            window.location.href = 'index.html';
        })
        .catch(error => {
            console.error('Erreur lors de la déconnexion:', error);
            
            // En cas d'erreur, forcer la déconnexion côté client quand même
            localStorage.removeItem('loggedIn');
            localStorage.removeItem('userData');
            updateInterface(false, null);
            window.location.href = 'index.html';
        });
}

// Attacher les écouteurs d'événements nécessaires
function attachEventListeners() {
    // Pour le formulaire de connexion
    const loginForm = document.getElementById('connexionForm');
    if (loginForm) {
        // Remplacer l'écouteur d'événements par défaut
        loginForm.addEventListener('submit', function(event) {
            event.preventDefault();
            loginUser(event);
        });
    }
}

// Fonction de connexion
function loginUser(event) {
    if (event) event.preventDefault();
    
    // Récupération des champs
    let email = document.getElementById('email').value.trim();
    let motDePass1 = document.getElementById('motDePass1').value;
    
    // Vérification des champs
    if (!email || !motDePass1) {
        let errElement = document.getElementById('errLOGIN');
        if (errElement) errElement.innerHTML = "Veuillez remplir tous les champs.";
        return;
    }
    
    // Envoi des données via AJAX
    let formData = new FormData();
    formData.append('email', email);
    formData.append('motDePass1', motDePass1);
    
    fetch('SeConnecter.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log("Réponse du serveur:", data);
        if (data.success) {
            // Gérer la connexion réussie
            handleLogin(data.userData);
            window.location.href = data.redirect || "index.html";
        } else {
            let errElement = document.getElementById('errLOGIN');
            if (errElement) errElement.innerHTML = data.message;
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        let errElement = document.getElementById('errLOGIN');
        if (errElement) errElement.innerHTML = 'Erreur de connexion au serveur.';
    });
} 