<header class="front-office">
    <div>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
        </svg>
        <img src="/images/logos/logoBlue.png" alt="logoBlue">
        <h1>PACT</h1>
    </div>
    <nav >
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="">Offres</a></li>
            <li>Cartographie</li>
        </ul>
    </nav>
    <a href="">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
        </svg>
    </a>
</header>

<script>
    /**
     * Ajoute un événement au clic sur le burger pour afficher le nav
    */
    document.addEventListener('DOMContentLoaded', () => {
        console.log('DOM fully loaded and parsed');
        const burger = document.querySelector('svg'); 
        const nav = document.querySelector('nav'); 

        burger.addEventListener("click", () => {
            console.log('Burger clicked');
            nav.classList.toggle('active');
        });
    });
</script>
