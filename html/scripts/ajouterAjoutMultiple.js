
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

function supprimerajoutMultiple(btn) {
    btn.parentElement.remove();
}

/*
* selectionne le type de l'offre
*/
function TypeSelectChange() {
    const select = document.getElementById('type-select');
    const detailsDiv = document.getElementById('activite-details');

    select.addEventListener('change', function () {
        // Récupérer les deux valeurs séparées par |
        const [selectedId, selectedLibelle] = this.value.split('|');

        // Stocker dans les cookies
        document.cookie = `selectedActiviteId=${encodeURIComponent(selectedId)}; path=/`;
        document.cookie = `selectedLibelle=${encodeURIComponent(selectedLibelle)}; path=/`;
       

        if (!selectedLibelle) {
            detailsDiv.innerHTML = '';
            return;
        }

        // Nettoyage du libellé
        const libelleSanitized = selectedLibelle
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '') // supprime accents
            .replace(/[^a-zA-Z]/g, ''); // garde que lettres uniquement

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
    const option = document.getElementById('option');

    typeSelect.addEventListener('change', function () {
        if (this.value === "") {
            champsOffre.style.display = "none";
            champsSubmit.style.display = "none";
            option.style.display = "none";
        } else {
            champsOffre.style.display = "block";
            champsSubmit.style.display = "block";
            option.style.display = "block";
        }
    });
}   

