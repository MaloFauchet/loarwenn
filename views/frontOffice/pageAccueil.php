<?php 
     
    /*          FAIRE LA CONNEXION     +        modifier le code juste en dessous    */ 

    require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OffreController.php');

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

    $listeOffreView = $offreController->getViewOffreAccueil();
    $i=0;

    function dump($dataDump) {
        echo "<pre>";
        print_r($dataDump);
        echo "</pre>";
    }

    // dump($listeOffreView);
?>


<header class="front-office-main">
    <!-- Video Arriere Plan -->
    <video autoplay muted loop id="myVideo" class="video-header">
        <source src="videos/video_accueil.mp4" type="video/mp4">
        <track kind="captions" src="" srclang="fr" label="Français" default>
        Votre navigateur ne supporte pas la vidéo.
    </video>

    <div>
        <!-- Navigation Bar -->
        <nav>
            <!-- Logo -->
            <a href="/" id="logo-navbar" aria-label="Page accueil">
                <img src="images/logos/logoBlue.png" alt="logoBlue" height="50px" width="50px">
            </a>
            <ul class="ul-fo">
                <li><a href="/" aria-label="Page accueil">Accueil</a></li>
                <li><a href="/frontOffice/listeOffre/" aria-label="Page offre">Offres</a></li>
            </ul>

            <!-- Profil -->
            <?php if (isset($_SESSION['id_utilisateur'])) { ?>
            <div class="profil" id="profil-navbar">
                <a href="" aria-label="Profil">
                    <img class="profil" src="<?= "/images/profils/" . $_SESSION['id_utilisateur']?>.jpg" alt="">
                </a>
                <a href="/scriptPHP/logout.php" aria-label="Déconnexion">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                        <path fill-rule="evenodd"
                            d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                    </svg>
                </a>
            </div>
            <?php } else{?>
            <a href="/frontOffice/connexion/" id="profil-navbar" aria-label="Connexion">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                    class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                    <path fill-rule="evenodd"
                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                </svg>
            </a>
            <?php } ?>
        </nav>

        <!-- Titre -->
        <h2 class="welcome-text-fo">Bienvenue sur la PACT</h2>
        <h2 class="discover-text-fo">Découvrez vos vacances</h2>

        <div class="search-container">
            <div class="container-search-funnel">
                <div class="search-row">
                    <input type="search" name="search" placeholder="Rechercher une offre" id="searchbar">
                    <button class="search-icon" id="search-button" aria-label="Rechercher">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>
<main>
    <h1>Sélectionnées pour vous</h1>
    <hr>
    <div class="container-caroussel">
        <div id="carousselSelectForYou">
            <?php foreach ($listeOffreView as $offreRecommande => $valueOfOffre) {
                require($_SERVER['DOCUMENT_ROOT'] . '/../views/componentsGlobaux/cardVerticalCaroussel.php'); 
            }?>
        </div>
        <h1>Les nouveautés</h1>
        <hr>
        <div class="container-nouveautes">
            <?php
                foreach ($listeOffreView as $offre => $valueOfOffre) {
                    require($_SERVER['DOCUMENT_ROOT'] . '/../views/componentsGlobaux/cardHorizontal.php');
                }    
            ?>  
        </div>
    </main>


    </div>
</main>  
<script>
    window.onload = function () {
      const params = new URLSearchParams(window.location.search);
      const success = params.get('success');

      if (success === '1') {
        alert("L'opération s'est bien déroulée !");
      } else if (success === '0') {
        alert("Une erreur est survenue.");
      }
    }
  </script>




<!-- TO FIX -->
<?php //require_once("./components/footer.php") ?>


</html>