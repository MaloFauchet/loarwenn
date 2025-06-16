"use strict";

// Chaque fois que l'utilisateur tape dans la barre de recherche, on filtre les offres
// par titre.
let searchbar = document.getElementById("searchbar");
searchbar.onkeyup = (event) => {
    // Si l'utilisateur appuie sur "Entrée"
    if (event.key === "Enter") {
        // on récupère la valeur de la barre de recherche
        // et on renvoie l'utilisateur vers la page de recherche
        // avec la valeur de la barre de recherche
        const searchValue = searchbar.value.toLowerCase();
        window.location.href = `/frontOffice/listeOffre/?search=${encodeURIComponent(searchValue)}`;
    }

};

let searchButton = document.getElementById("search-button");
searchButton.onclick = () => {
    // on récupère la valeur de la barre de recherche
    // et on renvoie l'utilisateur vers la page de recherche
    // avec la valeur de la barre de recherche
    const searchValue = searchbar.value.toLowerCase();
    window.location.href = `/frontOffice/listeOffre/?search=${encodeURIComponent(searchValue)}`;
};
