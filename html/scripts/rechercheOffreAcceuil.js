"use strict";

let searchButton = document.getElementById("search-button");
searchButton.onclick = () => {
    // on récupère la valeur de la barre de recherche
    // et on renvoie l'utilisateur vers la page de recherche
    // avec la valeur de la barre de recherche
    const searchValue = searchbar.value.toLowerCase();
    window.location.href = `/frontOffice/listeOffre/?search=${encodeURIComponent(searchValue)}`;
};

// Chaque fois que l'utilisateur tape dans la barre de recherche, on filtre les offres
// par titre.
let searchbar = document.getElementById("searchbar");
searchbar.onkeyup = (event) => {
    // on récupère la valeur de la barre de recherche
    const searchValue = searchbar.value.toLowerCase();
    // on désactive le bouton de recherche si la barre de recherche est vide
    searchButton.disabled = (searchValue === '') ? true : false;

    // Si l'utilisateur appuie sur "Entrée"
    if (event.key === "Enter") {
        // on renvoie l'utilisateur vers la page de recherche
        // avec la valeur de la barre de recherche
        window.location.href = `/frontOffice/listeOffre/?search=${encodeURIComponent(searchValue)}`;
    }
};

searchButton.disabled = (searchbar.value === '') ? true : false;