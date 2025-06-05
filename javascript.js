/*page generer le type du test*/
/*fonction pour generer le type du test*/
// Tableau de correspondance entre échantillons et tests
// Base de données des tests

// Base de données étendue des tests avec descriptions
const testsParType = {
  sang: [
    { 
      code: "NFS", 
      nom: "Numération Formule Sanguine", 
      delai: "24h", 
      prix: "120 DH",
      description: "Prélèvement sanguin veineux sur tube EDTA. Analyse des différentes cellules sanguines (globules rouges, globules blancs, plaquettes). À jeun de préférence pour éviter les interférences avec les lipides sanguins."
    },
    { 
      code: "GLY", 
      nom: "Glycémie à jeun", 
      delai: "6h", 
      prix: "50 DH",
      description: "Prélèvement sanguin veineux sur tube fluoré (gris). Patient strictement à jeun depuis au moins 8 heures. Mesure du taux de glucose dans le sang."
    },
    { 
      code: "CHOL", 
      nom: "Cholestérol Total", 
      delai: "24h", 
      prix: "80 DH",
      description: "Prélèvement sanguin veineux sur tube sec (rouge) ou hépariné (vert). Patient à jeun depuis 12 heures. Éviter les repas gras la veille."
    },
    { 
      code: "FER", 
      nom: "Ferritine Sérique", 
      delai: "48h", 
      prix: "90 DH",
      description: "Prélèvement sanguin veineux sur tube sec. Éviter une prise de sang après un effort physique intense qui peut augmenter transitoirement le taux de ferritine."
    },
    { 
      code: "TP-INR", 
      nom: "Taux de Prothrombine et INR", 
      delai: "6h", 
      prix: "65 DH",
      description: "Prélèvement sanguin veineux sur tube citraté (bleu). Ne pas hépariner le tube. Le tube doit être rempli correctement jusqu'au trait. À réaliser de préférence le matin."
    },
    { 
      code: "ION", 
      nom: "Ionogramme", 
      delai: "12h", 
      prix: "70 DH",
      description: "Prélèvement sanguin veineux sur tube hépariné. Mesure des électrolytes sanguins (sodium, potassium, chlore, bicarbonates). Pas de préparation particulière nécessaire."
    },
    { 
      code: "TSH", 
      nom: "Thyréostimuline", 
      delai: "48h", 
      prix: "110 DH",
      description: "Prélèvement sanguin veineux sur tube sec. À réaliser de préférence le matin entre 7h et 9h. Pas nécessaire d'être à jeun, mais éviter la prise de biotine (vitamine B8) 8h avant le prélèvement."
    }
  ],
  urine: [
    { 
      code: "ECBU", 
      nom: "Examen Cyto-Bactériologique", 
      delai: "48h", 
      prix: "90 DH",
      description: "Recueil des urines du matin (de préférence) dans un récipient stérile après toilette locale soigneuse. Privilégier le milieu du jet. Conserver au réfrigérateur et apporter au laboratoire dans les 2 heures."
    },
    { 
      code: "PROT", 
      nom: "Protéinurie", 
      delai: "24h", 
      prix: "60 DH",
      description: "Recueil des urines de 24 heures. Le matin à heure fixe, vider la vessie aux toilettes, puis recueillir toutes les urines pendant 24h, jusqu'au lendemain à la même heure (incluses)."
    },
    { 
      code: "UREE", 
      nom: "Urée Urinaire", 
      delai: "24h", 
      prix: "55 DH",
      description: "Recueil des urines de 24 heures dans un flacon propre. Conserver au réfrigérateur pendant la durée du recueil. Pas de restriction alimentaire particulière."
    },
    { 
      code: "TOXI", 
      nom: "Dépistage Toxicologique", 
      delai: "72h", 
      prix: "180 DH",
      description: "Recueil d'un échantillon d'urine fraîche dans un récipient propre et sec. Ne pas boire excessivement avant le prélèvement pour éviter la dilution des urines."
    },
    { 
      code: "CLEAR", 
      nom: "Clairance de la Créatinine", 
      delai: "48h", 
      prix: "95 DH",
      description: "Recueil des urines de 24 heures dans un flacon propre + prise de sang. Maintenir une hydratation normale pendant la période de recueil."
    }
  ],
  tissus: [
    { 
      code: "BIO", 
      nom: "Biopsie", 
      delai: "72h", 
      prix: "200 DH",
      description: "Prélèvement réalisé par un médecin. L'échantillon doit être immédiatement placé dans un fixateur (formol). Éviter toute contamination. Ne pas congeler."
    },
    { 
      code: "HIST", 
      nom: "Examen Histologique", 
      delai: "120h", 
      prix: "250 DH",
      description: "Prélèvement fixé dans du formol tamponné à 4%. Le volume de fixateur doit être au moins 5 fois supérieur à celui du prélèvement. Identifier précisément l'échantillon."
    },
    { 
      code: "IMH", 
      nom: "Immunohistochimie", 
      delai: "168h", 
      prix: "350 DH",
      description: "Nécessite une étape de préparation spécifique. Le prélèvement doit être fixé selon un protocole strict pour préserver l'antigénicité. À manipuler avec précaution."
    },
    { 
      code: "MOE", 
      nom: "Myélogramme", 
      delai: "72h", 
      prix: "280 DH",
      description: "Prélèvement réalisé par ponction de moelle osseuse. Les frottis doivent être réalisés immédiatement après le prélèvement. Éviter toute coagulation de l'échantillon."
    }
  ],
  salive: [
    { 
      code: "CORT", 
      nom: "Cortisol Salivaire", 
      delai: "72h", 
      prix: "150 DH",
      description: "Recueil de salive sur Salivette® ou dispositif équivalent. Ne pas manger, boire, fumer ou se brosser les dents 30 minutes avant le prélèvement."
    },
    { 
      code: "HORM", 
      nom: "Hormones Salivaires", 
      delai: "96h", 
      prix: "220 DH",
      description: "Recueil à effectuer à des horaires précis selon l'hormone dosée. Éviter les contaminations par le sang (pas de brossage de dents avant)."
    },
    { 
      code: "MICRO", 
      nom: "Microbiologie Salivaire", 
      delai: "48h", 
      prix: "110 DH",
      description: "Recueil dans un flacon stérile. À jeun et sans brossage de dents préalable pour un résultat optimal. Conserver au réfrigérateur avant analyse."
    }
  ],
  LCR: [
    { 
      code: "CULT", 
      nom: "Culture Bactériologique", 
      delai: "72h", 
      prix: "180 DH",
      description: "Ponction lombaire réalisée par un médecin. Trois tubes stériles numérotés dans l'ordre du prélèvement. À transporter immédiatement au laboratoire."
    },
    { 
      code: "CELL", 
      nom: "Examen Cytologique", 
      delai: "24h", 
      prix: "140 DH",
      description: "Recueil dans un tube spécifique. L'analyse doit être effectuée dans l'heure qui suit le prélèvement pour éviter la dégradation cellulaire."
    },
    { 
      code: "PROT-LCR", 
      nom: "Protéinorachie", 
      delai: "24h", 
      prix: "90 DH",
      description: "Prélèvement à analyser rapidement. Éviter l'hémolyse qui pourrait fausser les résultats. Transporter à température ambiante."
    }
  ],
  selles: [
    { 
      code: "PARA", 
      nom: "Examen Parasitologique", 
      delai: "48h", 
      prix: "85 DH",
      description: "Recueil d'un échantillon frais dans un pot propre et sec. L'échantillon doit être de la taille d'une noix. À apporter au laboratoire dans les 3 heures."
    },
    { 
      code: "COPR", 
      nom: "Coproculture", 
      delai: "72h", 
      prix: "110 DH",
      description: "Recueil dans un pot stérile. Éviter de contaminer l'échantillon avec l'urine. Conserver au réfrigérateur si le transport est différé."
    },
    { 
      code: "CALO", 
      nom: "Calprotectine Fécale", 
      delai: "96h", 
      prix: "195 DH",
      description: "Recueil d'un petit fragment de selles dans un conteneur spécifique fourni par le laboratoire. Ne pas prendre d'anti-inflammatoires dans les jours précédents."
    },
    { 
      code: "SANG", 
      nom: "Recherche de Sang Occulte", 
      delai: "24h", 
      prix: "70 DH",
      description: "Utiliser le kit spécifique fourni par le laboratoire. Suivre strictement les instructions du kit. Certains aliments peuvent interférer avec le test."
    }
  ],
  autre: [
    { 
      code: "PCR", 
      nom: "Test PCR", 
      delai: "24h", 
      prix: "300 DH",
      description: "Prélèvement nasopharyngé ou oropharyngé réalisé avec un écouvillon spécifique. Conditionner dans un milieu de transport viral. Conserver à 4°C."
    },
    { 
      code: "SERO", 
      nom: "Sérologie", 
      delai: "48h", 
      prix: "150 DH",
      description: "Prélèvement sanguin veineux sur tube sec. Centrifuger dans les 2 heures. Conserver le sérum à 4°C si l'analyse est différée."
    },
    { 
      code: "LIQU", 
      nom: "Analyse de Liquide Biologique", 
      delai: "48h", 
      prix: "170 DH",
      description: "Recueil dans des tubes stériles selon la nature du liquide (pleural, articulaire, etc.). Transport immédiat au laboratoire à température ambiante."
    },
    { 
      code: "GENE", 
      nom: "Test Génétique", 
      delai: "240h", 
      prix: "750 DH",
      description: "Prélèvement sanguin sur tube EDTA. Consentement écrit obligatoire. Conserver à température ambiante, ne pas congeler. Ne pas exposer à la chaleur."
    }
  ]
};

// Fonction pour afficher les tests recommandés
function afficherTestsRecommandes() {
  const typeSelectionne = document.getElementById('sampleType').value;
  const modalContent = document.getElementById('modalTestsContent');
  
  // Validation
  if (!typeSelectionne) {
    modalContent.innerHTML = `
      <div class="alert alert-danger">
        Veuillez d'abord sélectionner un type d'échantillon
      </div>
    `;
    const modal = new bootstrap.Modal(document.getElementById('testsModal'));
    modal.show();
    return;
  }

  // Récupération des tests
  const tests = testsParType[typeSelectionne] || [];
  
  // Construction du HTML
  let html = '';
  if (tests.length === 0) {
    html = `<div class="alert alert-warning">Aucun test standard pour ce type</div>`;
  } else {
    html = `
      <h6 class="mb-3">Pour l'échantillon de <span class="text-primary">${typeSelectionne}</span> :</h6>
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead class="table-primary">
            <tr>
              <th>Code</th>
              <th>Test</th>
              <th>Délai</th>
              <th>Prix</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            ${tests.map(test => `
              <tr>
                <td><strong>${test.code}</strong></td>
                <td>${test.nom}</td>
                <td><span class="badge bg-info">${test.delai}</span></td>
                <td>${test.prix}</td>
                <td>
                  <button class="btn btn-sm btn-outline-info" 
                          onclick="afficherDescription('${test.code}', '${test.nom}', '${test.description.replace(/'/g, "\\'")}')">
                    <i class="fas fa-info-circle"></i> Info
                  </button>
                </td>
              </tr>
            `).join('')}
          </tbody>
        </table>
      </div>
    `;
  }

  // Injection dans le modal
  modalContent.innerHTML = html;
  
  // Affichage du modal
  const modal = new bootstrap.Modal(document.getElementById('testsModal'));
  modal.show();
  
  // Mise à jour de la div résultats (optionnel)
  document.getElementById('resultatsTests').innerHTML = `
    <div class="alert alert-success">
      ${tests.length} tests recommandés générés pour ${typeSelectionne}
    </div>
  `;
}

// Fonction pour afficher la description d'un test
function afficherDescription(code, nom, description) {
  // Création d'un nouveau modal pour la description
  const descriptionModalId = 'descriptionModal';
  
  // Supprimer le modal précédent s'il existe
  let oldModal = document.getElementById(descriptionModalId);
  if (oldModal) {
    oldModal.remove();
  }
  
  // Créer le HTML du modal
  const modalHTML = `
    <div class="modal fade" id="${descriptionModalId}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-info text-white">
            <h5 class="modal-title">${code} - ${nom}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <h6 class="mb-3">Protocole de prélèvement :</h6>
            <p>${description}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          </div>
        </div>
      </div>
    </div>
  `;
  
  // Ajouter le modal au corps du document
  document.body.insertAdjacentHTML('beforeend', modalHTML);
  
  // Afficher le modal
  const descriptionModal = new bootstrap.Modal(document.getElementById(descriptionModalId));
  descriptionModal.show();
}

// Page enregistrer un échantillon - Gestion des tests disponibles
// Base de tests pour la page d'enregistrement d'échantillons
const tests = {
  sang: ["NFS", "Glycémie", "Cholestérol", "Ferritine", "TP-INR", "Ionogramme", "TSH"],
  urine: ["ECBU", "Protéinurie", "Urée Urinaire", "Dépistage Toxicologique", "Clairance Créatinine"],
  tissus: ["Biopsie", "Examen Histologique", "Immunohistochimie", "Myélogramme"],
  salive: ["Cortisol Salivaire", "Hormones Salivaires", "Microbiologie Salivaire"],
  LCR: ["Culture Bactériologique", "Examen Cytologique", "Protéinorachie"],
  selles: ["Examen Parasitologique", "Coproculture", "Calprotectine Fécale", "Recherche de Sang Occulte"],
  autre: ["Test PCR", "Sérologie", "Analyse de Liquide Biologique", "Test Génétique"]
};

// Attacher l'écouteur d'événements au chargement du DOM
document.addEventListener("DOMContentLoaded", function () {
  // Vérifier si on est sur la page d'enregistrement d'échantillon
  const sampleTypeSelect = document.getElementById('sampleType');
  if (sampleTypeSelect) {
    // Écouter les changements sur le select de type d'échantillon
    sampleTypeSelect.addEventListener('change', function() {
      const type = this.value;
      const container = document.getElementById('testsContainer');
      const testsDiv = document.getElementById('availableTests');
      
      if (!container || !testsDiv) return;
      
      if (!type || !tests[type]) {
        container.style.display = 'none';
        return;
      }

      testsDiv.innerHTML = '';
      tests[type].forEach(test => {
        testsDiv.innerHTML += `
          <div class="form-check">
            <input type="checkbox" class="form-check-input test-option" 
                  value="${test}" id="test_${test.replace(/\s+/g, '_')}">
            <label class="form-check-label" for="test_${test.replace(/\s+/g, '_')}">
                ${test}
            </label>
          </div>
        `;
      });
      
      container.style.display = 'block';
      updateSelection();
    });
    
    // Écoute les changements de checkbox
    document.addEventListener('change', function(e) {
      if (e.target.classList.contains('test-option')) {
        updateSelection();
      }
    });
  }
  
  // Reste du code existant pour la gestion des formulaires...
  const inscriptionForm = document.getElementById('inscriptionForm');
  if (inscriptionForm) {
    inscriptionForm.addEventListener('submit', function (e) {
      e.preventDefault(); // Empêche l'envoi immédiat du formulaire

      // Récupération des champs
      let id = document.getElementById('id').value.trim();
      let nom = document.getElementById('nom').value.trim();
      let prenom = document.getElementById('prenom').value.trim();
      let email = document.getElementById('email').value.trim();
      let motDePass1 = document.getElementById('motDePass1').value;

      // Vérification des champs
      if (!id || !nom || !prenom || !email || !motDePass1) {
        alert("Tous les champs sont obligatoires !");
        return;
      }

      // Envoi des données via AJAX
      let formData = new FormData();
      formData.append('id', id);
      formData.append('nom', nom);
      formData.append('prenom', prenom);
      formData.append('email', email);
      formData.append('motDePass1', motDePass1);
      formData.append('add', '1');

      fetch('inscription.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json()) // Attendre une réponse JSON
      .then(data => {
        if (data.success) {
          alert("Inscription réussie !");
          window.location.replace("connexion.html"); // Redirection après inscription
        } else {
          alert(data.message);
        }
      })
      .catch(error => console.error('Erreur:', error));
    });
  }

  // Existant - gestion du formulaire de connexion
  const connexionForm = document.getElementById('connexionForm');
  if (connexionForm) {
    connexionForm.addEventListener('submit', function (e) {
      e.preventDefault();
      loginUser();
    });
  }
});

// Met à jour le compteur et le champ caché pour les tests sélectionnés
function updateSelection() {
  const selectedCount = document.getElementById('selectedCount');
  const testsInput = document.getElementById('testsInput');
  
  if (!selectedCount || !testsInput) return;
  
  const selected = document.querySelectorAll('.test-option:checked');
  selectedCount.textContent = 
    `${selected.length} test${selected.length > 1 ? 's' : ''} sélectionné${selected.length > 1 ? 's' : ''}`;
  
  // Stocke les valeurs sélectionnées dans un champ caché (format CSV)
  testsInput.value = Array.from(selected).map(el => el.value).join(',');
}

// Function to handle login form submission
function loginUser() {
  event.preventDefault();
  
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

