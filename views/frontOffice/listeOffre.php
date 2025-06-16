<!-- Main-->
<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OffreController.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/componentsGlobaux/afficherEtoile.php');

    $offreController = new OffreController();
    $lastId = -1;
    $listeOffre = array_slice($offreController->AllOffreByLatest(),0,10);
    $listeOffreConsultes = [];

    if (isset($_COOKIE['consulte'])) {
        $tabConsulte = json_decode($_COOKIE['consulte']);
        foreach ($tabConsulte as $id) {
            $offreConsulte = $offreController->getOffreByIdAccueil($id);
            $listeOffreConsultes[] = $offreConsulte;
        }
    }

    $offreRecommandes = $offreController->getAllOffreRecommande();


    $offreTag = $offreController->getAllOffreTag();

    $tabTag = [];

    foreach ($offreTag as $offreValue => $valueOfOffre) {
        if($lastId != $valueOfOffre['id_offre']){

            $lastId = $valueOfOffre['id_offre'];
        }
        $tabTag[$valueOfOffre['id_offre']][] = $valueOfOffre['libelle_tag'];

    }
    $listeOffreView = $offreController->getViewOffreAccueil();
    
    $i=0;
?>
<main>
    <section>

        <!-- Fil d'arianne -->
        <div class="breadcrumb-container">
            <a href="/index.php" class="breadcrumb-back-link">
                <img src="/images/icons/chevron-left.svg" alt="Retour" class="breadcrumb-back">
            </a>
            <nav class="breadcrumb">
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li>Liste des offres</li>
                </ul>
            </nav>
        </div>

        <!-- Barre de recherche -->
        <div class="search-container">
            <div class="container-search-funnel">
                <div class="search-row">
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel-fill" viewBox="0 0 16 16">
                            <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5z"/>
                        </svg>
                    </button>
                    <input type="search" name="search" placeholder="Rechercher une offre" id="searchbar">
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
            <?php
                foreach ($listeOffreView as $offre => $valueOfOffre) {
                    if ($valueOfOffre['Recommandé']) {
                        require($_SERVER['DOCUMENT_ROOT'] . '/../views/componentsGlobaux/cardRecommendedMobileHorizontal.php');  
                    }else {
                        require($_SERVER['DOCUMENT_ROOT'] . '/../views/componentsGlobaux/cardMobileHorizontal.php'); 
                    }
                } 
            ?>
        </article>

        <!-- Filtre et Tri -->
        <aside>
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                </svg>
            </button>
            <div>
                <h4>Catégories</h4>
                <ul>
                    <li>
                        <input type="checkbox" name="AllCategories" id="AllCategories" checked>
                        <label for="AllCategories">Toutes Catégories</label>
                    </li>
                    <li>
                        <input type="checkbox" name="Restaurant" id="Restaurant" >
                        <label for="Restaurant">Restaurant</label>
                    </li>
                    <li>
                        <input type="checkbox" name="Spectacles" id="Spectacles" >
                        <label for="Spectacles">Spectacles</label>
                    </li>
                    <li>
                        <input type="checkbox" name="Visites" id="Visites" >
                        <label for="Visites">Visites</label>
                    </li>
                    <li>
                        <input type="checkbox" name="Activite" id="Activite" >
                        <label for="Activite">Activite</label>
                    </li>
                    <li>
                        <input type="checkbox" name="ParcAttraction" id="ParcAttraction" >
                        <label for="ParcAttraction">ParcAttraction</label>
                    </li>
                </ul>
            </div>
            <hr>
            <div>
                <h4>Lieu</h4>
                <input type="search" name="Location" id="location" placeholder="Commune, lieu-dit">
            </div>
            <hr>
            <div>
                <h4>Période</h4>
                <input type="date" name="Start" id="startDate" placeholder="Date de début">
                <input type="date" name="End" id="endDate" placeholder="Date de fin">
            </div>
            <hr>
            <div>
                <h4>Ouvert / Fermé</h4>
                <div>
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
                <h4>Prix</h4>
                <div>
                    <input type="number" name="MinPrice" id="minPrice" placeholder="Prix minimum">
                    <input type="number" name="MaxPrice" id="maxPrice" placeholder="Prix maximum">
                </div>
            </div>
            <hr>
            <div>
                <h4>Avis</h4>
                <div>
                    <input type="number" name="MinNote" id="minNote" placeholder="Note minimale">
                    <input type="number" name="MaxNote" id="maxNote" placeholder="Note maximum">
                </div>
            </div>
            <hr>
            <div>
                <h4>Trier par</h4>
                <ul>
                    <li>
                        <input type="radio" name="sort" id="sortRelevance" checked>
                        <label for="sortRelevance">Pertinence</label>
                    </li>
                    <li>
                        <input type="radio" name="sort" id="sortGrowingOpinions">
                        <label for="sortGrowingOpinions">Avis croissant</label>
                    </li>
                    <li>
                        <input type="radio" name="sort" id="sortDecreasingOpinions">
                        <label for="sortDecreasingOpinions">Avis décroissant</label>
                    </li>
                    <li>
                        <input type="radio" name="sort" id="sortPriceAsc">
                        <label for="sortPriceAsc">Prix croissant</label>
                    </li>
                    <li>
                        <input type="radio" name="sort" id="sortPriceDesc">
                        <label for="sortPriceDesc">Prix décroissant</label>
                    </li>
                </ul>
            </div>
        </aside>
    </section>
</main>
<div class="modal-overlay"></div>