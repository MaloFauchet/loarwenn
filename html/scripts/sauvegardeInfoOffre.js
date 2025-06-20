const params = new URLSearchParams(window.location.search);
const id = params.get('id_offre'); 


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
    setupInputs(inputs, estModifie, sauvegardeDiv);
    const textareas = document.querySelectorAll("textarea");
    setupInputs(textareas, estModifie, sauvegardeDiv);
    const checkboxs = document.querySelectorAll("input[type=checkbox]");
    setUpCheckBox(checkboxs, estModifie, sauvegardeDiv)

}


function setupInputs(inputs, estModifie, sauvegardeDiv) {
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

function setUpCheckBox(checkboxs, estModifie, sauvegardeDiv) {
    checkboxs.forEach(checkbox => {
        // recupere la valeur de chaque input
        const valeurOriginale = checkbox.checked;

        estModifie[checkbox.id] = false;

        // ajoute un event listener sur chaque input
        checkbox.oninput = () => {
            // si la valeur de l'input est different de la valeur de base
            if (checkbox.checked !== valeurOriginale) {
                // affiche le bouton de sauvegarde et d'annulation
                estModifie[checkbox.id] = true;
            } else {
                // cache le bouton de sauvegarde et d'annulation
                // sauvegardeDiv.style.display = "none";
                estModifie[checkbox.id] = false;
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

    //alert()
    // si quelque chose a été modifié
    if (modificationPresente) {
        // affiche le bouton de sauvegarde et d'annulation
        sauvegardeDiv.style.bottom = "0";
    } else {
        // cache le bouton de sauvegarde et d'annulation
        sauvegardeDiv.style.bottom = "-100px";
    }
}

function getListValues(id) {
    const list = document.querySelectorAll(`#ajoutMultipleList_${id} > li`);
    const values = [];

    list.forEach(li => {
        // Récupère uniquement le texte avant le bouton
        const text = li.firstChild.nodeType === 3 ? li.firstChild.textContent.trim() : '';
        if (text !== "") {
            values.push(text);
        }
    });

    return values;
}

function getValuesInputs() {

    let checkboxJours = document.querySelectorAll('#jours-checkboxes input[type="checkbox"]');
    let jours = Array.from(checkboxJours)
        .filter(checkbox => checkbox.checked)
        .map(checkbox => checkbox.id);
        console.log("chemin:",document.getElementById("chemin_image").value);
    let result = {
        //champ commun a toutes les offres
        type_offre:document.getElementById("type-offre").value,
        title: document.getElementById("titre").value,
        enLigne:document.getElementById("slider-etat").checked  ?1 :0, 
        codePostal: document.getElementById("code-postal").value,
        complementAdresse: document.getElementById("complement-adresse").value,
        voie: document.getElementById("voie").value,
        numeroAdresse:document.getElementById("numero-adresse").value,
        prix:document.getElementById("prix").value,
        prix_TTC_min:document.getElementById("prix").value,
        city: document.getElementById("ville").value,
        description: document.getElementById("description").value,
        resume: document.getElementById("resume").value,
        accessibility: document.getElementById("accessibilite").value,
        joursOuverture:jours,
        horaire1:document.getElementById("horaire-1").value,
        horaire2:document.getElementById("horaire-2").value,
        horaire3:document.getElementById("horaire-3")? document.getElementById("horaire-3").value: null,
        horaire4:document.getElementById("horaire-4") ? document.getElementById("horaire-4").value:null,

        titre_image:document.getElementById("titre_image").value,
        chemin_image:document.getElementById("chemin_image").value,
        

        //specifique au differentes type offres
        duration: document.getElementById("duree") ? document.getElementById("duree").value:null,
        age: document.getElementById("age-min")? document.getElementById("age-min").value:null,
        nbAttractions: document.getElementById("nb-attraction")? document.getElementById("nb-attraction").value:null,
        capaciteAccueil: document.getElementById("capacite")? document.getElementById("capacite").value:null,
        prestationIncluse: getListValues("prestation-incluse") ?getListValues("prestation-incluse") :[],
        prestationNonIncluse: getListValues("prestation-non-incluse")? getListValues("prestation-non-incluse") : [],

        titre_image_carte: document.getElementById("age-min")? document.getElementById("age-min").value:null,
        chemin_image_carte: document.getElementById("age-min")? document.getElementById("age-min").value:null,
        libelleGammePrix: document.getElementById("gamme-prix")? document.getElementById("gamme-prix").options[document.getElementById("gamme-prix").selectedIndex].text:null,

        titre_image_parc:document.getElementById("age-min")? document.getElementById("age-min").value:null,
        chemin_image_parc:document.getElementById("age-min")? document.getElementById("age-min").value:null,

        repasServi:getListValues("repas-servi") ? getListValues("repas-servi") : [],
        langue:getListValues("langue") ? getListValues("langue") : [],

        tags: getListValues("tags") ? getListValues("tags") :[] ,

    };

    
    return result;
}

/**
 * Fonction qui est appelée lorsque le bouton de sauvegarde est cliqué
 */
async function sauvegarderClique() {
    let data = getValuesInputs();
    await sendData(data);
    
}


function encodeFormData(data) {
    const params = [];

    for (let [key, value] of Object.entries(data)) {
        if (Array.isArray(value)) {
            value.forEach(v => {
                params.push(`${encodeURIComponent(key)}[]=${encodeURIComponent(v)}`);
            });
        } else {
            params.push(`${encodeURIComponent(key)}=${encodeURIComponent(value)}`);
        }
    }

    return params.join('&');
}


async function sendData(data) {
    console.log(encodeFormData(data));
    fetch("/api/offre/update/?id_offre=" + id, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: encodeFormData(data)
    }).then(response => {
        if (response.ok) {
            const sauvegardeDiv = document.getElementById("sauvegarder");
            sauvegardeDiv.style.bottom = "-100px";
            const li = document.querySelector("ul#ajoutMultipleList_tags > li")
            const text = li.firstChild.nodeType === 3 ? li.firstChild.textContent.trim() : '';
            console.log(text)
            
            return response.json();
        } else {
            throw new Error(response.json().message);
        }
    }).then(data => {
        // TODO : afficher un message de succès (flash card)
        //console.log("Sauvegarde réussie  " + data.message);
        displayFlashCard("success",data.message)
    }).catch(error => {
        // TODO : afficher un message d'erreur (flash card)
        console.error("Erreur lors de la sauvegarde", "Erreur lors de l'enregistrement");
        displayFlashCard("erroe","Erreur lors de l'enregistrement")
        //displayFlashCard("error")
    });

    // relance la fonction onload de la page pour mettre à jour les données
    window.onload();
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

function displayFlashCard(response, message) {
    const flashCard = document.getElementById("reponse-flash");
    const p = document.getElementById("message-flash");

    // Nettoie les classes précédentes
    flashCard.classList.remove("success", "error");

    // Applique la bonne classe
    if (response === "success") {
        flashCard.classList.add("success");
    } else {
        flashCard.classList.add("error");
    }

    // Affiche le message
    p.textContent = message;

    // Relance proprement l'animation
    flashCard.style.display = "block";
    flashCard.style.animation = "none";
    flashCard.offsetHeight; // trigger reflow
    flashCard.style.animation = null;

    // Masque après 4 secondes (ou ce que tu veux)
    setTimeout(() => {
        flashCard.style.display = "none";
    }, 4000);
}
