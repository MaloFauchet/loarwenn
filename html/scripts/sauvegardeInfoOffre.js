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
    let result = {
        title: document.getElementById("titre").value,
        codePostal: document.getElementById("code-postal").value,
        complementAdresse: document.getElementById("complement-adresse").value,
        voie: document.getElementById("voie").value,
        numeroAdresse:document.getElementById("numero-adresse").value,
        prix:document.getElementById("numero-adresse").value,
        city: document.getElementById("ville").value,
        description: document.getElementById("description").value,
        resume: document.getElementById("resume").value,
        accessibility: document.getElementById("accessibilite").value,
        
        duration: document.getElementById("duree") ? document.getElementById("duree").value:null,
        age: document.getElementById("age-min")? document.getElementById("age-min").value:null,
        nbAttractions: document.getElementById("nb-attraction")? document.getElementById("nb-attraction").value:null,
        nbAttractions: document.getElementById("capacite")? document.getElementById("capacite").value:null,
        prestationIncluse: getListValues("prestation-incluse") ?getListValues("prestation-incluse") :null,
        prestationNonIncluse: getListValues("prestation-non-incluse")? getListValues("prestation-non-incluse") : null,
        repasServi:getListValues("repas-servi") ? getListValues("repas-servi") : null,
        langue:getListValues("langue") ? getListValues("langue") : null,

        tags: getListValues("tags"),

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
    fetch("/api/offre/update/?id=" + id, {
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
        console.log("Sauvegarde réussie  " + data.message);
        displayFlashCard("success",data.message)
    }).catch(error => {
        // TODO : afficher un message d'erreur (flash card)
        console.error("Erreur lors de la sauvegarde", error);
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

function displayFlashCard(response,message) {
    const flashCard = document.getElementById("reponse-flash")
    const p = document.getElementById("message-flash")
    console.log(p)

    if(response == "success"){
        flashCard.style.display = "block"
        p.text = message
    }else{
        flashCard.style.display = ""
        p.text = message
    }
}