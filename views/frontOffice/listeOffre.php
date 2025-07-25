<!-- Main-->
<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OffreController.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/componentsGlobaux/afficherEtoile.php');

    // Verification du GET
    // si un search est présent dans l'URL, on le stocke dans une variable
    if (isset($_GET['search'])) {
        $search = htmlspecialchars($_GET['search']);
    } else {
        $search = '';
    }

    $offreController = new OffreController();
    $lastId = -1;
    $listeOffre = $offreController->getAllOffre();
    $listeOffreConsultes = [];

    if (isset($_COOKIE['consulte'])) {
        $tabConsulte = json_decode($_COOKIE['consulte']);
        foreach ($tabConsulte as $id) {
            $offreConsulte = $offreController->getOffreByIdAccueil($id);
            $listeOffreConsultes[] = $offreConsulte;
        }
    }

    $listeOffreView = $offreController->getViewOffreAccueil();
    $i=0;
?>
<script type="text/javascript">
    const initialSearch = '<?= $search ?>';
    // utilisé pour transférer la variable PHP dans le script JS
</script>
<main>
    <section>
        <!-- Fil d'arianne -->
        <div class="breadcrumb-container">
            <a aria-label="Retour" href="/index.php" class="breadcrumb-back-link">
                <img src="/images/icons/chevron-left.svg" alt="Retour" class="breadcrumb-back">
            </a>
            <nav class="breadcrumb">
                <ul>
                    <li>
                        <a aria-label="Accueil" href="/">Accueil</a>
                    </li>
                    <li>Liste des offres</li>
                </ul>
            </nav>
        </div>

        <!-- Barre de recherche -->
        <div class="search-container">
            <div class="container-search-funnel">
                <div class="search-row">
                    <button aria-label="Rechercher">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel-fill" viewBox="0 0 16 16">
                            <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5z"/>
                        </svg>
                    </button>
                    <input aria-label="Barre de recherche" type="search" name="search" placeholder="Rechercher une offre" id="searchbar">
                    <div class="search-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg>
                    </div>
                </div>
                <div class="container-funnel">
                    <div class="filter" id="filter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sliders2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10.5 1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4H1.5a.5.5 0 0 1 0-1H10V1.5a.5.5 0 0 1 .5-.5M12 3.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m-6.5 2A.5.5 0 0 1 6 6v1.5h8.5a.5.5 0 0 1 0 1H6V10a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5M1 8a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 1 8m9.5 2a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V13H1.5a.5.5 0 0 1 0-1H10v-1.5a.5.5 0 0 1 .5-.5m1.5 2.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5"/>
                        </svg>
                        <p>filtres</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="container-offre-filtre">

        <!-- Liste des Offres -->
        <article class="container-offre">
            <div id="no-result" style="display:none;">Aucune offre ne correspond à vos critères.</div>
            <?php
                foreach ($listeOffreView as $offre => $valueOfOffre) {
                    require($_SERVER['DOCUMENT_ROOT'] . '/../views/componentsGlobaux/cardMobileHorizontal.php'); 
                } 
            ?>
        </article>

        <!-- Filtre et Tri -->
        <aside>
            <button aria-label="Fermer filtre">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                </svg>
            </button>
            <div>
                <p>Catégories</p>
                <ul>
                    <li>
                        <input type="checkbox" name="AllCategories" id="AllCategories" class="categories" checked>
                        <label for="AllCategories">Toutes Catégories</label>
                    </li>
                    <li>
                        <input type="checkbox" name="Restaurant" id="restauration" class="categories" >
                        <label for="restauration">Restaurant</label>
                    </li>
                    <li>
                        <input type="checkbox" name="spectacle" id="spectacle" class="categories">
                        <label for="spectacle">Spectacle</label>
                    </li>
                    <li>
                        <input type="checkbox" name="Visite guidée" id="visite_guidee" class="categories">
                        <label for="visite_guidee">Visite guidée</label>
                    </li>
                    <li>
                        <input type="checkbox" name="Visite non guidée" id="visite_non_guidee" class="categories">
                        <label for="visite_non_guidee">Visite non guidée</label>
                    </li>
                    <li>
                        <input type="checkbox" name="Activité" id="activite" class="categories">
                        <label for="activite">Activité</label>
                    </li>
                    <li>
                        <input type="checkbox" name="Parc d'attraction" id="parc_attraction" class="categories">
                        <label for="parc_attraction">Parc d'attraction</label>
                    </li>
                    
                </ul>
            </div>
            <hr>
            <div>
                <p>Lieu</p>
                <input type="search" name="Location" id="location" placeholder="Ville">
            </div>
            <hr>
            <div>
                <p>Jour d'ouverture</p>
                <ul>
                    <li>
                        <input type="checkbox" name="Lundi" id="Lundi" class="openDays">
                        <label for="Lundi">Lundi</label>
                    </li>
                    <li>
                        <input type="checkbox" name="Mardi" id="Mardi" class="openDays">
                        <label for="Mardi">Mardi</label>
                    </li>
                    <li>
                        <input type="checkbox" name="Mercredi" id="Mercredi" class="openDays">
                        <label for="Mercredi">Mercredi</label>
                    </li>
                    <li>
                        <input type="checkbox" name="Jeudi" id="Jeudi" class="openDays">
                        <label for="Jeudi">Jeudi</label>
                    </li>
                    <li>
                        <input type="checkbox" name="Vendredi" id="Vendredi" class="openDays">
                        <label for="Vendredi">Vendredi</label>
                    </li>
                    <li>
                        <input type="checkbox" name="Samedi" id="Samedi" class="openDays">
                        <label for="Samedi">Samedi</label>
                    </li>
                    <li>
                        <input type="checkbox" name="Dimanche" id="Dimanche" class="openDays">
                        <label for="Dimanche">Dimanche</label>
                    </li>
                </ul>
            </div>
            <hr>
            <div>
                <p>Ouvert / Fermé</p>
                <div class="filtre-ouvert-fermer-container">
                    <div>
                        <input type="radio" name="Open/Close" id="open">
                        <label for="open">Ouvert</label>
                    </div>
                    <div>
                        <input type="radio" name="Open/Close" id="close">
                        <label for="close">Fermé</label>
                    </div>
                </div>
            </div>
            <hr>
            <div>
                <p>Prix</p>
                <div>
                    <input type="number" name="MinPrice" id="minPrice" placeholder="Prix minimum">
                    <input type="number" name="MaxPrice" id="maxPrice" placeholder="Prix maximum">
                </div>
            </div>
            <hr>
            <div>
                <p>Trier par</p>
                <ul>
                    <li>
                        <input type="radio" name="sort" id="sortGrowingOpinions" onclick="triCroissantNote()">
                        <label for="sortGrowingOpinions">Avis croissant</label>
                    </li>
                    <li>
                        <input type="radio" name="sort" id="sortDecreasingOpinions" onclick="triDecroissantParNote()">
                        <label for="sortDecreasingOpinions">Avis décroissant</label>
                    </li>
                    <li>
                        <input type="radio" name="sort" id="sortPriceAsc" onclick="triCroissantParPrix()">
                        <label for="sortPriceAsc">Prix croissant</label>
                    </li>
                    <li>
                        <input type="radio" name="sort" id="sortPriceDesc" onclick="triDecroissantParPrix()">
                        <label for="sortPriceDesc">Prix décroissant</label>
                    </li>
                </ul>
            </div>
            <div>
                <button aria-label="Réinitialiser">Réinitialiser</button>
            </div>
        </aside>
    </section>
</main>
<div class="modal-overlay"></div>

