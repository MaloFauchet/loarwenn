let optCreate = document.getElementById("activer-otp-bouton");

optCreate?.addEventListener("click", function () {
    // Ouvrir la modale
    let optModal = document.getElementById("opt-modal");
    let body = document.querySelector("body");

    optModal.classList.remove("hidden");
    body.classList.add("overflow-hidden");

    // Récupérer le QR code OTP via une requête AJAX
    fetch('/api/otp/creerSecret', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            let qrCodeContainer = document.getElementById("qr-code-container");
            qrCodeContainer.innerHTML = '';
            if (data.qrCode) {
                let img = document.createElement("img");
                img.src = data.qrCode;
                img.alt = "QR Code OTP";
                qrCodeContainer.appendChild(img);
            } else {
                console.error("QR Code non disponible");
            }
        })
        .catch(error => {
            console.error('Erreur AJAX:', error);
        });
});


// Ajouter un écouteur d'événement pour fermer et valider
let optClose = document.getElementById("otp-fermer-btn");
optClose?.addEventListener("click", function () {
    let optModal = document.getElementById("opt-modal");
    let body = document.querySelector("body");
    let confirmer = confirm("Êtes-vous sûr de vouloir annuler la configuration de l'A2F ?");

    if (!confirmer) {
        return;
    }

    optModal.classList.add("hidden");
    body.classList.remove("overflow-hidden");
});

// Listener sur le bouton valider.
let optValidate = document.getElementById("otp-valider-btn");
optValidate?.addEventListener("click", function () {
    let optModal = document.getElementById("opt-modal");
    let body = document.querySelector("body");

    // Récupérer le contenu de l'input du code.
    let inputCode = document.getElementById("otp-code-input");
    if (inputCode.value.trim() === "") {
        alert("Veuillez entrer le code OTP.");
        return;
    }

    let confirmer = confirm("Êtes-vous sûr de vouloir activer la configuration de l'A2F ? Avez-vous bien scanner ce qrcode et enregistrer le code ? Pas de retour en arrière possible.");

    if (!confirmer) {
        return;
    }

    // Vérifier si le code OTP est valide
    const params = new URLSearchParams();
    params.append('otpCode', inputCode.value.trim());

    fetch('/api/otp/verifierOtpCode/', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            otpCode: inputCode.value.trim()
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.message === "CodeOK") {
                // Insert
                fetch('/api/otp/insertCodeSecret', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    credentials: 'same-origin'
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("OTP activé avec succès !");
                            window.location.reload();
                        } else {
                            alert("Erreur lors de l'activation de l'OTP.");
                        }
                    })
                    .catch(error => {
                        console.error('Erreur AJAX:', error);
                        alert("Une erreur s'est produite lors de l'activation de l'OTP.");
                    });
            } else {
                alert("Code OTP invalide. Veuillez réessayer.");
            }
        })
        .catch(error => {
            console.error('Erreur AJAX:', error);
            alert("Une erreur s'est produite lors de la vérification du code OTP.");
        });

    // Fermer la modale après validation
    optModal.classList.add("hidden");
    body.classList.remove("overflow-hidden");
});