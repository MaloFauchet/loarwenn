function displayFlashCard(response, message) {
    // Crée la carte flash
    const flashCard = document.createElement("div");
    flashCard.classList.add("flash-card");

    // Applique la bonne classe selon le type de réponse
    if (response === "success") {
        flashCard.classList.add("success");
    } else {
        flashCard.classList.add("error");
    }

    // Crée et ajoute le message
    const p = document.createElement("p");
    p.textContent = message;
    flashCard.appendChild(p);

    // Applique les styles de base (ou utilise une feuille CSS)
    flashCard.style.position = "fixed";
    flashCard.style.top = "20px";
    flashCard.style.left = "50%";
    flashCard.style.transform = "translateX(-50%)";
    flashCard.style.padding = "1rem 2rem";
    flashCard.style.borderRadius = "8px";
    flashCard.style.color = "white";
    flashCard.style.zIndex = "1000";
    flashCard.style.animation = "fadeInOut 4s ease-in-out";

    // Styles spécifiques
    if (response === "success") {
        flashCard.style.backgroundColor = "#4caf50"; // vert
    } else {
        flashCard.style.backgroundColor = "#f44336"; // rouge
    }

    // Ajoute au body
    document.body.appendChild(flashCard);

    // Supprime la carte après 4 secondes
    setTimeout(() => {
        flashCard.remove();
    }, 4000);
}
