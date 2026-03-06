/**
 * JavaScript principal - TahitiGame
 *
 * TODO POUR LES ÉTUDIANTS :
 * - Ajouter la validation côté client des formulaires
 * - Ajouter des confirmations de suppression
 * - Ajouter des animations
 * - Ajouter du code AJAX pour des fonctionnalités dynamiques
 */

// Fonction pour confirmer la suppression (à utiliser dans les liens de suppression)
function confirmDelete(message) {
    return confirm(message || 'Êtes-vous sûr de vouloir supprimer cet élément ?');
}

// Fermeture automatique des alertes après 5 secondes
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');

    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';

            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });
});

// Validation basique d'un formulaire de produit
function validateProductForm(form) {
    const nom = form.nom.value.trim();
    const prix = parseFloat(form.prix.value);
    const stock = parseInt(form.stock.value);

    if (nom.length < 3) {
        alert('Le nom du produit doit contenir au moins 3 caractères');
        return false;
    }

    if (prix <= 0) {
        alert('Le prix doit être supérieur à 0');
        return false;
    }

    if (stock < 0) {
        alert('Le stock ne peut pas être négatif');
        return false;
    }

    return true;
}

// Exemple : prévisualisation d'image avant upload
// TODO : à compléter par les étudiants
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            // Afficher l'image dans un élément <img id="image-preview">
            const preview = document.getElementById('image-preview');
            if (preview) {
                preview.src = e.target.result;
            }
        };

        reader.readAsDataURL(input.files[0]);
    }
}
