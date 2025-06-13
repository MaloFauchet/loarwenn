document.addEventListener("DOMContentLoaded", function() {

    /**
     * FILTRE SUR LES CATEGORIES
     */
    const allCat = document.getElementById("AllCategories");
    const otherCats = document.querySelectorAll("input[type='checkbox']:not(#AllCategories)");


    // Si "Toute catégorie" est coché, afficher toutes les cartes
    // et décocher les autres catégories
    allCat.addEventListener("change", function() {
        otherCats.forEach(category => {
            category.checked = false; // Décoché les autres catégories
        });
        document.querySelectorAll(".a-card").forEach(card => {
            card.style.display = "block"; 
        });
    });


    // Si une autre catégorie est cochée, décocher "Toute catégorie"
    // et afficher uniquement les cartes correspondantes
    otherCats.forEach(category => {
        category.addEventListener("change", function() {

            // Décoché Toute catégorie
            allCat.checked = false;
            //Liste des catégories cochées
            const allChecked = Array.from(otherCats)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.name);

            document.querySelectorAll(".a-card").forEach(card => {
                const cardClasses = card.getAttribute("type_activite");
                if (!cardClasses.some(type => allChecked.includes(type))) {
                    card.style.display = "none"; 
                }
            });
        });
    });



    /**
     * FILTRE SUR LES LIEUX
     */
    const locInput = document.getElementById("location");
    locInput.addEventListener("input", function() {

        //Récupérer la valeur de l'input
        const searchTerm = locInput.value;

        //Afficher les cartes qui correspondent à la recherche
        document.querySelectorAll(".a-card").forEach(card => {
            const cardLocation = card.getAttribute("location");
            if (cardLocation && cardLocation.toLowerCase().includes(searchTerm.toLowerCase())) {
                card.style.display = "block"; 
            } else {
                card.style.display = "none"; 
            }
        });
    });


    /**
     * 
     */

});