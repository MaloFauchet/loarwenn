document.addEventListener("DOMContentLoaded", function() {
    /**
     * FILTRE SUR LES CATEGORIES
     */
    const allCat = document.getElementById("AllCategories");
    const otherCats = document.querySelectorAll("input[class='categories']:not(#AllCategories)");


    // Si "Toute catégorie" est coché, afficher toutes les cartes
    // et décocher les autres catégories
    allCat.addEventListener("change", function() {
        otherCats.forEach(category => {
            category.checked = false; // Décoché les autres catégories
        });
        document.querySelectorAll(".a-card").forEach(card => {
            card.style.display = ""; 
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
            .map(checkbox => checkbox.id.trim().toLocaleLowerCase());

            document.querySelectorAll(".a-card").forEach(card => {
                const category = card.getAttribute("data-category");
                if (allChecked.length === 0 || allChecked.includes(category)) {
                    card.style.display = ""; 
                }else {
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
                card.style.display = ""; 
            } else if (searchTerm === "") {
                card.style.display = ""; 
            }else {
                card.style.display = "none"; 
            }
        });
    });


    /**
     * FILTRE PAR PRIX MINIMUM
     */
    const minPriceInput = document.getElementById("minPrice");
    const maxPriceInput = document.getElementById("maxPrice");
    function filterByPrice() {
        const minPrice = parseFloat(minPriceInput.value);
        const maxPrice = parseFloat(maxPriceInput.value);

        document.querySelectorAll(".a-card").forEach(card => {
            const priceElement = card.querySelector('.item-price');
            if (!priceElement) return;

            const cardPrice = parseFloat(priceElement.textContent.replace("€", "").trim());

            const isAboveMin = isNaN(minPrice) || cardPrice >= minPrice;
            const isBelowMax = isNaN(maxPrice) || cardPrice <= maxPrice;

            card.style.display = (isAboveMin && isBelowMax) ? "" : "none";
        });
    }

    minPriceInput.addEventListener("input", filterByPrice);
    maxPriceInput.addEventListener("input", filterByPrice);

    /**
     * FILTRE PAR JOUR D'OUVERTURE
     * */
    const openClosedCheckbox = document.querySelectorAll("input.openDays");
    openClosedCheckbox.forEach(day => {
        day.addEventListener("change", function() {
            // Liste des jours cochés
            const allChecked = Array.from(openClosedCheckbox)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.id.trim().toLowerCase());

            document.querySelectorAll(".a-card").forEach(card => {
                const days = card.getAttribute("data-open-days")
                    .split(",")
                    .map(j => j.trim().toLowerCase());

                // Affiche la carte si aucun filtre OU au moins un jour coché est dans les jours d'ouverture
                if (allChecked.length === 0 || allChecked.some(jour => days.includes(jour))) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
            });
        });
    });


    /** 
    * * FILTRE PAR NOTION OUVERT/FERMÉ AUJOURD'HUI
     */
    const openInput = document.getElementsByName("Open/Close");
    console.log(new Date().getDay().toString());
    openInput.forEach(input => {
        input.addEventListener("change", function() {
            if(input.id === "open"){
                document.querySelectorAll('.a-card').forEach(card => {
                    const days = card.getAttribute('data-open-days')
                    .split(',')
                    .map(j => j.trim().toLowerCase());

                    const jours = ['dimanche','lundi','mardi','mercredi','jeudi','vendredi','samedi'];
                    const today = jours[new Date().getDay()];

                    if (days.includes(today)) {
                        card.style.display = ""; 
                    } else {
                        card.style.display = "none";
                    }
                });
            }
            if(input.id === "close"){
                document.querySelectorAll(".a-card").forEach(card => {
                    const days = card.getAttribute('data-open-days')
                    .split(',')
                    .map(j => j.trim().toLowerCase());

                    const jours = ['dimanche','lundi','mardi','mercredi','jeudi','vendredi','samedi'];
                    const today = jours[new Date().getDay()];

                    if (!days.includes(today)) {
                        card.style.display = ""; 
                    } else {
                        card.style.display = "none";
                    }
                });
            }
        });
    });
});
