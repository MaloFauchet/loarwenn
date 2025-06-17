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
    let allInputs = [...inputs].filter(input => input.id !== "otp-code-input");
    setupInputs(allInputs, estModifie, sauvegardeDiv);

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
            photoDeProfil.onmouseenter = () => {
                debugger;
                let newPhotoDeProfilSrc = photoDeProfil.src;
                photoDeProfil.onmouseleave = () => {
                  photoDeProfilOnMouseLeave(photoDeProfil, newPhotoDeProfilSrc);
                }
                photoDeProfil.style.cursor = "pointer";
                photoDeProfil.setAttribute("src", "/images/profils/changerPhotoDeProfil.png");
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
        nom: document.getElementById("nom").value,
        prenom: document.getElementById("prenom").value,
        telephoneEntreprise: document.getElementById("telephoneEntreprise").value,
        emailEntreprise: document.getElementById("emailEntreprise").value,
        voieEntreprise: document.getElementById("voieEntreprise").value,
        numeroAdresse: document.getElementById("numeroAdresse").value,
        codePostalEntreprise: document.getElementById("codePostalEntreprise").value,
        villeEntreprise: document.getElementById("villeEntreprise").value,
        complementAdresseEntreprise: document.getElementById("complementAdresseEntreprise").value,
        photoProfil: null // sera rempli plus tard avec la photo de profil si une est donnée
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

    // Fonction de vérification des entrées
    debugger;
    if (!verifyInputs(data)) {
        console.error("Les données saisies ne sont pas valides.");
        // preventDefault();
        return;
    }

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
    // console.log(Object.entries(data).map(([k, v]) => { return k + '=' + encodeURIComponent(v); }).join('&'));
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
        alert("Vos informations ont été sauvegardées avec succès.");
    }).catch(error => {
        // TODO : afficher un message d'erreur
        alert("Erreur lors de la sauvegarde. Veuillez réessayer plus tard.");
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

function verifyInputs(data) {
    // Vérification des champs requis
    if (!data.denominationEntreprise || !data.nom || !data.prenom ||
        !data.telephoneEntreprise || !data.emailEntreprise || !data.adresseEntreprise ||
        !data.codePostalEntreprise || !data.villeEntreprise) {
        alert("Veuillez remplir tous les champs obligatoires.");
        return false;
    }

    // Vérification de la dénomination de l'entreprise
    if (data.denominationEntreprise.length > 50) {
        alert("La dénomination de l'entreprise doit contenir au maximum 50 caractères.");
        return false;
    }

    // Vérification du nom
    if (data.nom.length > 50) {
        alert("Votre nom doit contenir au maximum 50 caractères.");
        return false;
    }

    // Vérification du prénom
    if (data.prenom.length > 50) {
        alert("Votre prénom doit contenir au maximum 50 caractères.");
        return false;
    }

    // Vérification de l'adresse
    // Vérification du numéro d'adresse
    if (!/^\d+$/.test(data.numeroAdresse)) {
        alert("Veuillez entrer un numéro d'adresse valide (chiffres uniquement).");
        return false;
    }
    // Vérification de la voie de l'entreprise
    if (data.voieEntreprise.length > 100) {
        alert("L'adresse doit contenir au maximum 100 caractères.");
        return false;
    }

    // Vérification du code postal
    if (!/^\d{5}$/.test(data.codePostalEntreprise)) {
        alert("Veuillez entrer un code postal valide (5 chiffres).");
        return false;
    }

    // Vérification du format du téléphone (exemple simple, à adapter selon les besoins)
    const phoneRegex = /^(?:(?:\+|00)33|0)\s*[1-9](?:[\s]*\d{2}){4}$/; // 10 chiffres pour un numéro français
    if (!phoneRegex.test(data.telephoneEntreprise)) {
        alert("Veuillez entrer un numéro de téléphone valide (10 chiffres).");
        return false;
    }

    // Vérification du format de l'email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(data.emailEntreprise)) {
        alert("Veuillez entrer un email valide.");
        return false;
    }

    // Vérification de la ville
    if (data.villeEntreprise.length > 50) {
        alert("La ville doit contenir au maximum 50 caractères.");
        return false;
    }

    // Vérification du complément d'adresse (optionnel, mais limité à 100 caractères)
    if (data.complementAdresseEntreprise && data.complementAdresseEntreprise.length > 100) {
        alert("Le complément d'adresse doit contenir au maximum 100 caractères.");
        return false;
    }
    
    console.log("Vérification des entrées de professionnel privé");
    // Si l'utilisateur est une entreprise privée, vérifier le RIB et le SIREN
    if (document.getElementById("ribEntreprise") !== null) {
        console.log("Vérification du RIB et du SIREN");
        
        console.log("Vérification du SIREN");
        const sirenRegex = /^[0-9]{9}$/; // SIREN doit être composé de 9 chiffres
        if (!sirenRegex.test(data.sirenEntreprise)) {
            alert("Veuillez entrer un SIREN valide (9 chiffres).");
            console.log("SIREN invalide : " + data.sirenEntreprise);
            return false;
        }

        const ibanRegex = /^[A-Z]{2}[0-9]{2}([ ]?[0-9]{4}){5}([ ]?[0-9]{3}){1}$/;
        if (!ibanRegex.test(data.ribEntreprise)) {
            alert("Veuillez entrer un IBAN valide.");
            return false;
        }
    }

    return true; // Toutes les vérifications sont passées
}