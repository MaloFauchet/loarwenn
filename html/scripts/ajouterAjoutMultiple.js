/**
 * Ajoute un nouvel élément à une liste d'entrées multiples pour un identifiant donné.
 */

function ajouterajoutMultiple(id) {
    const input = document.getElementById('ajoutMultipleInput_' + id);
    const list = document.getElementById('ajoutMultipleList_' + id);
    const value = input.value.trim();

    if (value !== '') {
        const li = document.createElement('li');
        li.innerHTML = `${value} 
            <input type="hidden" name="ajoutMultiple_${id}[]" value="${value}">
            <button type="button" onclick="supprimerajoutMultiple(this)">✖</button>`;
        list.appendChild(li);
        input.value = '';
    }
}

function supprimerajoutMultiple(button) {
    const li = button.parentElement;
    li.remove();
}

/*
* Sélectionne le type de l'offre
*/
function TypeSelectChange() {

    const select = document.getElementById('type-select');
    const detailsDiv = document.getElementById('activite-details');

    select.addEventListener('change', function () {
        if (!this.value) {
            detailsDiv.innerHTML = '';
            return;
        }

        // Récupérer les deux valeurs séparées par |
        const [selectedId, selectedLibelle] = this.value.split('|');

        // Stocker dans les cookies
        document.cookie = `selectedActiviteId=${encodeURIComponent(selectedId)}; path=/`;
        document.cookie = `selectedLibelle=${encodeURIComponent(selectedLibelle)}; path=/`;

        // Nettoyage du libellé
        const libelleSanitized = selectedLibelle
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '') // supprime les accents
            .replace(/[^a-zA-Z]/g, ''); // garde uniquement les lettres

        // Envoi des deux versions au backend
        const url = `/backOffice/chargeComposant.php?libelle=${encodeURIComponent(selectedLibelle)}&sanitized=${encodeURIComponent(libelleSanitized)}`;

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error("Fichier non trouvé");
                }
                return response.text();
            })
            .then(html => {
                detailsDiv.innerHTML = html;
            })
            .catch(error => {
                detailsDiv.innerHTML = `<p style="color:red;">Erreur : ${error.message}</p>`;
            });
    });
}


// Afficher ou masquer les champs d'offre en fonction de la sélection du type d'activité
function afficherElementMasque(){
    const typeSelect = document.getElementById('type-select');
    const champsOffre = document.getElementById('champs-offre');
    const champsSubmit = document.getElementById('champs-submit');
   
    typeSelect.addEventListener('change', function () {
        if (this.value === "") {
            champsOffre.style.display = "none";
            champsSubmit.style.display = "none";
        } else {
            champsOffre.style.display = "block";
            champsSubmit.style.display = "block";
        }
    });
}  

/**
 * Gère l'aperçu des images sélectionnées pour l'image principale et les images secondaires.
 */
function imagePreview() {
    // Gestion de l'aperçu pour l'image principale
    document.getElementById('imagePrincipale').addEventListener('change', function (event) {
        const preview = document.getElementById('previewPrincipale');
        preview.innerHTML = ''; // Réinitialise l'aperçu
        const file = event.target.files[0];
        // Vérifie si un fichier image est sélectionné
        if (file && file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file); // Crée un aperçu temporaire
            preview.appendChild(img);
        }
    });

    // Gestion de l'aperçu pour les images secondaires (jusqu'à 4 images)
    document.getElementById('imagesSecondaires').addEventListener('change', function (event) {
        const preview = document.getElementById('previewSecondaires');
        preview.innerHTML = ''; // Réinitialise l'aperçu

        // Filtre les fichiers pour ne garder que les images
        const files = Array.from(event.target.files).filter(file => file.type.startsWith('image/'));
        
        // Limite à 4 images et crée un aperçu pour chacune
        files.slice(0, 4).forEach(file => {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file); // Crée un aperçu temporaire
            preview.appendChild(img);
        });
    });
}

/**
 * Gère l'aperçu de l'image sélectionnée pour la carte du restaurant.
 */
function imagePreviewResto(){
    // Récupère l'élément d'aperçu et le réinitialise
    const preview = document.getElementById('previewCarteRestaurant');
    preview.innerHTML = ''; 

    // Récupère le premier fichier sélectionné
    const file = event.target.files[0];

    // Vérifie si un fichier image est sélectionné
    if (file && file.type.startsWith('image/')) {
        const img = document.createElement('img');
        img.id = 'mapImagePreview'; // Attribue un identifiant à l'image d'aperçu
        img.src = URL.createObjectURL(file); // Crée un aperçu temporaire de l'image
        preview.appendChild(img); // Ajoute l'image à l'aperçu
    }
}


/**
 * Gère l'aperçu de l'image sélectionnée pour la carte (map).
 */
function imagePreviewMap() {
    // Récupère l'élément d'aperçu et le réinitialise
    const preview = document.getElementById('previewMap');
    preview.innerHTML = '';

    // Récupère le premier fichier sélectionné
    const file = event.target.files[0];

    // Vérifie si un fichier image est sélectionné
    if (file && file.type.startsWith('image/')) {
        const img = document.createElement('img');
        img.id = 'mapImagePreview'; // Attribue un identifiant à l'image d'aperçu
        img.src = URL.createObjectURL(file); // Crée un aperçu temporaire de l'image
        preview.appendChild(img); // Ajoute l'image à l'aperçu
    }
}





