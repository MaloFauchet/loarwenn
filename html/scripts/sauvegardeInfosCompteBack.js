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

    let photoInput = document.getElementById("photo-profil-input");
    let photoDeProfil = document.getElementById("photo-profil");
    let photoDeProfilOriginale = photoDeProfil.getAttribute("src");
    setupPhotoDeProfil(photoInput, photoDeProfil, photoDeProfilOriginale);
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

function photoDeProfilOnMouseLeave(photoDeProfil, photoDeProfilOriginale) {
    photoDeProfil.style.cursor = "default";
    photoDeProfil.setAttribute("src", photoDeProfilOriginale);
}

function setupPhotoDeProfil(photoInput, photoDeProfil, photoDeProfilOriginale) {
    photoDeProfil.onmouseenter = () => {
        photoDeProfil.onmouseleave = () => {
            photoDeProfilOnMouseLeave(photoDeProfil, photoDeProfilOriginale);
        }
        photoDeProfil.style.cursor = "pointer";
        photoDeProfil.setAttribute("src", "/images/profils/changerPhotoDeProfil.png")
    }
    photoDeProfil.onclick = () => {
        photoInput.click();
    }
    photoInput.addEventListener('change', (event) => {
      const file = event.target.files[0];
      
      if (file) {
        const maxSizeMB = 2; // set your size limit (e.g. 2 MB)
        const fileSizeMB = file.size / (1024 * 1024); // convert from bytes to MB

        if (fileSizeMB > maxSizeMB) {
            alert(`File is too large. Maximum allowed size is ${maxSizeMB} MB.`);
            fileInput.value = ''; // optional: reset the input
            return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
          photoDeProfil.src = e.target.result;
          photoDeProfil.onmouseleave = () => {
              photoDeProfilOnMouseLeave(photoDeProfil, photoDeProfil.src);
          }
        };
        reader.readAsDataURL(file);
      }
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

function getValuesInputs() {
    let result = {
        denominationEntreprise: document.getElementById("denominationEntreprise").value,
        nomEntreprise: document.getElementById("nomEntreprise").value,
        prenomEntreprise: document.getElementById("prenomEntreprise").value,
        telephoneEntreprise: document.getElementById("telephoneEntreprise").value,
        emailEntreprise: document.getElementById("emailEntreprise").value,
        adresseEntreprise: document.getElementById("adresseEntreprise").value,
        codePostalEntreprise: document.getElementById("codePostalEntreprise").value,
        villeEntreprise: document.getElementById("villeEntreprise").value,
        complementAdresseEntreprise: document.getElementById("complementAdresseEntreprise").value
    };

    // si l'utilisateur est une entreprise privée
    if (document.getElementById("ribEntreprise") !== null) {
        result.ribEntreprise = document.getElementById("ribEntreprise").value;
        result.sirenEntreprise = document.getElementById("sirenEntreprise").value;
    }
    return result;
}

/**
 * Fonction qui est appelée lorsque le bouton de sauvegarde est cliqué
 */
async function sauvegarderClique() {
    let data = getValuesInputs();

    const photoFile = document.getElementById("photo-profil-input").files[0];

    if (photoFile) {
        const reader = new FileReader();
        reader.onload = async function(e) {
            data.photoProfil = e.target.result || ""; // base64 string, fallback to empty string if undefined
            await sendData(data);
        };
        reader.readAsDataURL(photoFile);
    } else {
        data.photoProfil = "";
        await sendData(data);
    }
}

async function sendData(data) {
    console.log(Object.entries(data).map(([k, v]) => { return k + '=' + encodeURIComponent(v); }).join('&'));
    fetch("/api/compte/pro/update/", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: Object.entries(data).map(([k, v]) => { return k + '=' + encodeURIComponent(v); }).join('&')
    }).then(response => {
        if (response.ok) {
            return response.json();
        } else {
            throw new Error(response.json().message);
        }
    }).then(data => {
        // TODO : afficher un message de succès
        console.log("Sauvegarde réussie");
    }).catch(error => {
        // TODO : afficher un message d'erreur
        console.error("Erreur lors de la sauvegarde", error);
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