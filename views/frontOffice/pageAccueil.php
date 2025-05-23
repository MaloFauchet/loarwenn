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

    function dump($dataDump) {
        echo "<pre>";
        var_dump($dataDump);
        echo "</pre>";
    }
    

?>
    
    
    <header class="front-office-main">
        <video autoplay muted loop id="myVideo" class="video-header">
            <source src="videos/video_accueil.mp4" type="video/mp4">
        </video>
        <div >
            <img src="images/logos/logoBlue.png" alt="logoBlue" height="50px" width="50px"  >
        </div>
            
        <!--
        <nav>
            <ul class="ul-fo">
                <li><a href="index.php">Accueil</a></li>
                <li><a href="">Offres</a></li>
                <li><a href="">Cartographie</a></li>
            </ul>
        </nav>!-->
        <?php if (isset($_SESSION['id_utilisateur']) && isset($_SESSION['pseuddo'])) { ?>
            <a href="">
                <img src="<?= "/images/profils/" . $_SESSION['id_utilisateur']?>.jpg" alt="">
            </a>
        <?php } else{?>
        <a href="/frontOffice/connexion/index.php" >
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
            </svg>
        </a>
        <?php } ?>

        <!--
        <div class="sample one" >
            <input type="text" name="search" placeholder="Rechercher...">
            <button type="submit" class="btn-search" >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                </svg>
            </button>
        </div>!-->
        <h2 class="welcome-text-fo">Bienvenue sur la PACT</h2>
        <h2 class="discover-text-fo">Découvrez vos vacances</h2>
    </header>
    <main><!--
        <h1>Récemment consultés</h1>
        <hr>
        <?php //  FAIRE CONNEXION     if ($connected) { ?>
            
            <div class="container-caroussel">
                <div id="carousselAlreadySee">
                    
                    <?php /*foreach ($listeOffreConsultes as $listeOffreRecementConsultes =>$offreRecementConsultes ) { 
                        
                        foreach ($offreRecementConsultes as $offreRecementConsulte =>$valueOfOffre) {
                            require($_SERVER['DOCUMENT_ROOT'] . '/../views/componentsGlobaux/cardVerticalCaroussel.php');  
                        }
                    }*/ ?>
            </div>
        </div>!-->
        <?php //} ?>
        <h1>Sélectionnés pour vous</h1>
        <hr>
        <div class="container-caroussel">
            <div id="carousselSelectForYou">

                <?php foreach ($listeOffreView as $offreRecommande => $valueOfOffre) {
                    if ($valueOfOffre['Recommandé']) {
                        require($_SERVER['DOCUMENT_ROOT'] . '/../views/componentsGlobaux/cardRecommendedVerticalCarousselle.php'); 
                    }elseif ($valueOfOffre['En relief']) {
                        require($_SERVER['DOCUMENT_ROOT'] . '/../views/componentsGlobaux/cardVerticalCaroussel.php'); 
                    }
                }?>

            </div>
        </div>
        <h1>Les nouveautés</h1>
        <hr>
        <div class="container-nouveautes">
            <?php

            foreach ($listeOffreView as $offre => $valueOfOffre) {
                if ($valueOfOffre['Recommandé']) {
                    require($_SERVER['DOCUMENT_ROOT'] . '/../views/componentsGlobaux/cardRecommendedHorizontal.php'); 
                }else{
                    require($_SERVER['DOCUMENT_ROOT'] . '/../views/componentsGlobaux/cardHorizontal.php');
                    
                }
                
                
            }    
            ?>
            
            
        </div>
    </main>


    
    
    <!-- TO FIX -->
    <?php //require_once("./components/footer.php") ?>


</html>