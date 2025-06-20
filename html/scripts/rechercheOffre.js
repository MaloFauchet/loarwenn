"use strict";

// Chaque fois que l'utilisateur tape dans la barre de recherche, on filtre les offres
// par titre.
let searchbar = document.getElementById("searchbar");
searchbar.onkeyup = () => {
    // On récupère la valeur de la barre de recherche
    let searchValue = searchbar.value.toLowerCase();
    searchValue = searchValue.normalize("NFD").replace(/[\u0300-\u036f]/g, "")  // remove any accents
    
    // On récupère toutes les offres
    const offres = document.querySelectorAll(".offre");

    offres.forEach(offre => {
        // On récupère le titre de l'offre
        let titre = offre.querySelector(".item-title").textContent.toLowerCase();
        titre = titre.normalize("NFD").replace(/[\u0300-\u036f]/g, "") // remove any accents
        
        // On vérifie si le titre contient la valeur de la barre de recherche
        if (titre.includes(searchValue)) {
            // Si oui, on affiche l'offre
            // On supprime la classe non-visible si elle est présente
            if (offre.classList.contains("non-visible-search")) {
                // On supprime la classe non-visible pour afficher l'offre
                offre.classList.remove("non-visible-search");
            }
        } else {
            // Sinon, on cache l'offre
            if (!offre.classList.contains("non-visible-search")) {
                // On ajoute la classe non-visible si elle n'est pas déjà présente
                offre.classList.add("non-visible-search");
            }
        }
    });

    const cards = document.querySelectorAll('.a-card');
    const visibleCards = Array.from(cards).filter(card => !card.classList.contains("non-visible-search") && !card.classList.contains("non-visible-filter"));

    if (visibleCards.length === 0) {
        document.getElementById('no-result').style.display = 'flex';
    } else {
        document.getElementById('no-result').style.display = 'none';
    }
}

searchbar.onchange = searchbar.onkeyup;

// Si une recherche était présente dans l'URL, on la met dans la barre de recherche
if (initialSearch !== '') {
    searchbar.value = initialSearch;
    // On déclenche l'événement keyup pour filtrer les offres
    searchbar.onkeyup();
}