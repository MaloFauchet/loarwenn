window.onload = () => {
    // recupere la div de sauvegarde
    const sauvegardeDiv = document.getElementById("sauvegarder");

    // recupere le bouton de sauvegarde et d'annulation
    const sauvegarderBtn = document.getElementById("sauvegarder-btn");
    sauvegarderBtn.onclick = () => sauvegarderClique();
    const annulerBtn = document.getElementById("annuler-btn");
    annulerBtn.onclick = () => annulerClique(sauvegardeDiv);

    // cree une variable qui stocke, pour chaque input, si il a été modifié ou pas
    const estModifie = {};

    // recupere les données de base de chaque input
    // et les stockes dans une variable.
    const inputs = document.querySelectorAll("input");
    inputs.forEach(input => {
        // recupere la valeur de chaque input
        const valeurOriginale = input.value;

        estModifie[input.id] = false;

        // ajoute un event listener sur chaque input
        input.oninput = () => {
            // si la valeur de l'input est different de la valeur de base
            if (input.value !== valeurOriginale) {
                // affiche le bouton de sauvegarde et d'annulation
                estModifie[input.id] = true;
            } else {
                // cache le bouton de sauvegarde et d'annulation
                // sauvegardeDiv.style.display = "none";
                estModifie[input.id] = false;
            }
            updateAffichageDivSauvegarde(sauvegardeDiv, estModifie);
        };
    });
}

/**
 * Affiche ou cache la div des boutons de sauvegarde et d'annulation
 * en fonction de si quelque chose a été modifié ou non.
 * @param {HTMLDivElement} sauvegardeDiv Conteneur des boutons de sauvegarde et d'annulation
 * @param {object} estModifie Object contenant les id des inputs et un booléen indiquant si l'input a été modifié
 */
function updateAffichageDivSauvegarde(sauvegardeDiv, estModifie) {
    // si quelque chose a été modifié
    let modificationPresente = false;

    // checker pour chaque input
    for (const key in estModifie) {
        if (estModifie[key]) {
            modificationPresente = true;
            break;
        }
    }

    // si quelque chose a été modifié
    if (modificationPresente) {
        // affiche le bouton de sauvegarde et d'annulation
        sauvegardeDiv.style.bottom = "0";
    } else {
        // cache le bouton de sauvegarde et d'annulation
        sauvegardeDiv.style.bottom = "-100px";
    }
}

/**
 * Fonction qui est appelée lorsque le bouton de sauvegarde est cliqué
 */
function sauvegarderClique() {
    // TODO : faire la requete
    console.warn("TODO : faire la requete");
}

/**
 * Fonction qui est appelée lorsque le bouton d'annulation est cliqué
 * @param {HTMLDivElement} sauvegardeDiv Conteneur des boutons de sauvegarde et d'annulation
 */
function annulerClique(sauvegardeDiv) {
    // cache le bouton de sauvegarde et d'annulation
    sauvegardeDiv.style.bottom = "-100px";
    // recharge la page
    location.reload();
}