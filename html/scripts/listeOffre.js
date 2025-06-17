document.addEventListener("DOMContentLoaded", function () {
    const search = document.querySelector('.liste-offre input[placeholder="Rechercher une offre"]');
    const searchBorder = document.querySelector('.liste-offre .search-row');
    const loupe = document.querySelector('.liste-offre .search-icon');

    search.addEventListener('focus', function() {
        searchBorder.style.border = "3px solid var(--main-color)";
        loupe.style.backgroundColor = "var(--main-color)";
    });

    search.addEventListener('blur', function() {
        searchBorder.style.border = "1px solid var(--main-color)";
        loupe.style.backgroundColor = "grey";
    });
});