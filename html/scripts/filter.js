document.addEventListener("DOMContentLoaded", function () {
    /**
     * Récupération des inputs
     */
    const allCat = document.getElementById("AllCategories");
    const otherCats = Array.from(document.querySelectorAll("input.categories:not(#AllCategories)"));
    const locInput = document.getElementById("location");
    const minPriceInput = document.getElementById("minPrice");
    const maxPriceInput = document.getElementById("maxPrice");
    const openInput = document.getElementsByName("Open/Close");
    const selectedDaysInput = Array.from(document.querySelectorAll("input[class='openDays']"));
    const today = ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'][new Date().getDay()];
    const resetButton = document.querySelector(".liste-offre aside div:has(button) button");
    const triInput = document.querySelectorAll("input[name='sort']");
    const container = document.querySelector('.container-offre'); 
    const cards = Array.from(container.querySelectorAll('.a-card'));


    /**
     * Fonction pour obtenir les catégories sélectionnées
     * @returns {string[]} Liste des catégories sélectionnées
     */
    function getSelectedCategories() {
        return otherCats.filter(c => c.checked).map(c => c.id.trim().toLowerCase());
    }

    /**
     * Fonction pour obtenir les jours d'ouverture sélectionnées
     * @returns {string[]} Liste des jours d'ouvertures sélectionnées
     */
    function getSelectedDays() {
        return selectedDaysInput.filter(c => c.checked).map(c => c.id.trim().toLowerCase());
    }


    /**
     * 
     * @param {*} card 
     * Cette fonction vérifie si une carte correspond aux critères de filtrage définis par l'utilisateur.
     * Elle prend en compte la catégorie, la ville, les jours d'ouverture, le prix et l'état d'ouverture.
     * @returns {boolean} - Retourne true si la carte correspond aux critères, sinon false.
     */
    function matchCard(card) {
        const type = card.getAttribute("data-category")?.trim().toLowerCase();
        const ville = card.getAttribute("data-location")?.trim().toLowerCase();
        const openDays = card.getAttribute("data-open-days");
        const days = openDays.split(",").map(d => d.trim().toLowerCase());
        const priceElement = card.querySelector(".item-price");

        

        const searchTerm = locInput.value.trim().toLowerCase();
        const minPrice = parseFloat(minPriceInput.value);
        const maxPrice = parseFloat(maxPriceInput.value);
        const selectedCategories = getSelectedCategories();
        const isOpenToday = openDays.split(",").map(j => j.trim().toLowerCase()).includes(today);
        const selectedOpenInput = Array.from(openInput).find(i => i.checked);
        const dayChecked = getSelectedDays();


        let cardPrice = NaN;
        if (priceElement) {
            const priceText = priceElement.textContent.trim().toLowerCase();

            // Vérification si le prix est "gratuit"
            if (priceText === "gratuit") {
                cardPrice = 0;
            }else{
                const priceText = priceElement.textContent.replace(/[^\d,.-]/g, "").replace(",", ".");
                cardPrice = parseFloat(priceText);
            }
        }

        const matchType = selectedCategories.length === 0 || selectedCategories.includes(type);
        const matchVille = ville.includes(searchTerm);
        const matchPrice = (isNaN(minPrice) || cardPrice >= minPrice) && (isNaN(maxPrice) || cardPrice <= maxPrice);
        const matchOpen = selectedOpenInput?.id === "open" ? isOpenToday : selectedOpenInput?.id === "close" ? !isOpenToday : true;
        const matchDay = dayChecked.length === 0 || dayChecked.some(day => days.includes(day));

        return matchType && matchVille && matchPrice && matchOpen && matchDay;
    }


    /**
     * Fonction pour mettre à jour l'affichage des cartes en fonction des filtres sélectionnés
     * 
     * Cette fonction parcourt toutes les cartes et les affiche ou les masque en fonction des critères de filtrage.
     */
    function updateCards() {
        const selectedCategories = getSelectedCategories();
        allCat.checked = selectedCategories.length === 0;

        document.querySelectorAll(".a-card").forEach(card => {
            card.style.display = matchCard(card) ? "" : "none";
        });

        const cards = document.querySelectorAll('.a-card');
        const visibleCards = Array.from(cards).filter(card => card.style.display !== 'none');

        if (visibleCards.length === 0) {
            document.getElementById('no-result').style.display = 'flex';
        } else {
            document.getElementById('no-result').style.display = 'none';
        }
    }

    // Gestion de "Toute catégorie"
    allCat.addEventListener("change", function () {
        if (allCat.checked) {
            otherCats.forEach(c => c.checked = false);
            updateCards();
        }
    });

    // Gestion des autres catégories
    otherCats.forEach(cat => {
        cat.addEventListener("change", function () {
            allCat.checked = false;
            updateCards();
        });
    });

    // Gestion des jours d'ouverture
    selectedDaysInput.forEach(day => {
        day.addEventListener("change", function () {
            updateCards();
        });
    });

    

    // Événements de filtrage
    locInput.addEventListener("input", updateCards);
    minPriceInput.addEventListener("input", updateCards);
    maxPriceInput.addEventListener("input", updateCards);
    openInput.forEach(input => input.addEventListener("change", updateCards));


    // Gestion du bouton de réinitialisation
    resetButton.addEventListener("click", function () {

        allCat.checked = true;
        otherCats.forEach(c => c.checked = false);
        locInput.value = "";
        minPriceInput.value = "";
        maxPriceInput.value = "";
        openInput.forEach(input => input.checked = false);
        selectedDaysInput.forEach(day => day.checked = false);

        // Réinitialisation de l'affichage des cartes si aucun tri n'est actif
        triInput.forEach(input => {
            cards.forEach(card => container.appendChild(card));
            input.checked = false;
        });
        updateCards();
    });
});


