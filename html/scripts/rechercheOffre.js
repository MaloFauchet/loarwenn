"use strict";

// Chaque fois que l'utilisateur tape dans la barre de recherche, on filtre les offres
// par titre.
document.getElementById("searchbar").onkeyup = () => {
    // On récupère la valeur de la barre de recherche
    const searchValue = document.getElementById("searchbar").value.toLowerCase();
    
    // On récupère toutes les offres
    const offres = document.querySelectorAll(".offre");

    offres.forEach(offre => {
        // On récupère le titre de l'offre
        const titre = offre.querySelector(".titre").textContent.toLowerCase();
        
        // On vérifie si le titre contient la valeur de la barre de recherche
        if (titre.includes(searchValue)) {
            // Si oui, on affiche l'offre
            offre.style.display = "block";
        } else {
            // Sinon, on cache l'offre
            offre.style.display = "none";
        }
    });
}