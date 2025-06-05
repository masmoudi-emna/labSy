document.getElementById('inscriptionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('nom', document.getElementById('nom').value);
    formData.append('email', document.getElementById('email').value);
    formData.append('password', document.getElementById('password').value);

    fetch('register_user.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Utilisateur inscrit avec succès');
            this.reset();
            loadUsers();
        } else {
            alert('Erreur: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur lors de l\'inscription');
    });
});

function loadUsers() {
    fetch('get_users.php')
    .then(response => response.json())
    .then(data => {
        const tbody = document.getElementById('usersList');
        tbody.innerHTML = '';
        
        data.forEach(user => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${user.nom}</td>
                <td>${user.email}</td>
                <td>
                    <button class="btn btn-sm btn-danger" onclick="deleteUser(${user.id})">Supprimer</button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    });
}

function deleteUser(id) {
    if (confirm('Voulez-vous vraiment supprimer cet utilisateur ?')) {
        fetch('delete_user.php', {
            method: 'POST',
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadUsers();
            } else {
                alert('Erreur lors de la suppression');
            }
        });
    }
}

// Charger les utilisateurs au chargement de la page
document.addEventListener('DOMContentLoaded', loadUsers); 