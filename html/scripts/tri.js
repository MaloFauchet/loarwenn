
    function triCroissantParPrix() {
        const container = document.querySelector('.container-offre'); 
        const cards = Array.from(container.querySelectorAll('.a-card'));

        cards.sort((a, b) => {
            const prixA = parseFloat(a.querySelector('.item-price').textContent.replace('€', '').trim()) || 0;
            const prixB = parseFloat(b.querySelector('.item-price').textContent.replace('€', '').trim()) || 0;
            return prixA - prixB;
        });

        // Réinjection des cartes triées dans le DOM
        cards.forEach(card => container.appendChild(card));
    }

    function triDecroissantParPrix() {
        const container = document.querySelector('.container-offre'); 
        const cards = Array.from(container.querySelectorAll('.a-card'));

        cards.sort((a, b) => {
            const prixA = parseFloat(a.querySelector('.item-price').textContent.replace('€', '').trim()) || 0;
            const prixB = parseFloat(b.querySelector('.item-price').textContent.replace('€', '').trim()) || 0;
            return prixB - prixA;
        });

        // Réinjection des cartes triées dans le DOM
        cards.forEach(card => container.appendChild(card));
    }

    function triCroissantNote() {
        const container = document.querySelector('.container-offre'); 
        const cards = Array.from(container.querySelectorAll('.a-card'));

        cards.sort((a, b) => {
            const prixA = a.getAttribute('note_avis');
            const prixB = b.getAttribute('note_avis');
            return prixA - prixB;
        });

        // Réinjection des cartes triées dans le DOM
        cards.forEach(card => container.appendChild(card));
    }

    function triDecroissantParNote() {
        const container = document.querySelector('.container-offre'); 
        const cards = Array.from(container.querySelectorAll('.a-card'));

        cards.sort((a, b) => {
            const prixA = a.getAttribute('note_avis');
            const prixB = b.getAttribute('note_avis');
            return prixB - prixA;
        });

        // Réinjection des cartes triées dans le DOM
        cards.forEach(card => container.appendChild(card));
    }