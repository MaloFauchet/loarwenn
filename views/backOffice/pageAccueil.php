<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/Offre.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OffreController.php');

$offreController = new OffreController();
$offres = $offreController->getOffreByIdProfessionnel(1);






$note = 3.5;
$nbNouveauxAvis = 5;
?>



<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PACT</title>
    <link rel="stylesheet" href="/styles/backOffice.css">
    <link rel="stylesheet" href="/styles/styles.css">
    <script>
        // Ajoute un texte "Nouveaux avis" lors du survol de la pastille
        document.addEventListener('DOMContentLoaded', function() {
            var pastille = document.querySelector('.pastille');
            if (pastille) {
                var textBase = pastille.textContent;
                pastille.parentElement.addEventListener('mouseenter', function() {
                    pastille.textContent = textBase + 'Nouveaux avis';
                });
                pastille.parentElement.addEventListener('mouseleave', function() {
                    pastille.textContent = textBase;
                });
            }
        });
    </script>

</head>

<body>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] .'/../views/backOffice/components/header.php'); 
    require_once($_SERVER['DOCUMENT_ROOT'] .'/../views/componentsGlobaux/afficherEtoile.php');?>

    <div class="page-back-office">
        <?php require_once($_SERVER['DOCUMENT_ROOT'] .'/../views/backOffice/components/nav.php'); ?>
        <div class="container-back-office">
            <main class="contenu-back-office">

                <div class="search-filter-bar">
                    <form >
                        <input type="search" placeholder="Rechercher une offre" name="Rechercher">
                        <div>
                            <button type="submit">
                                <img src="/images/icons/search-white.svg" alt="Rechercher">
                            </button>
                        </div>
                    </form>
                
                    <button>
                        <img src="/images/icons/funnel-fill-blue.svg" alt="Filtrer">
                    </button>
                    
                </div>
                <?php
                foreach ($offres as $offre) {
                    
                ?>
                    <div class="offre">
                        <div class="image-container">
                            <span class="pastille">
                                <?php echo $nbNouveauxAvis ?>
                            </span>
                            
                            <img src="/images/offres/kayak_brehat.jpg" alt="<?php echo $offre['titre_image']; ?>">

                        </div>
                        <div class="offre-content">
                            <h2><?php echo $offre['titre_offre']; ?></h2>
                            <div class="avis-offre">
                                <p><?php echo $offre['note_moyenne'] ?></p>
                                <div class="etoiles">
                                    <?php
                                    
                                        echo afficherEtoile($offre['note_moyenne']);
                                    ?>
                                </div>
                                
                                <p>(<?php echo $offre['nb_avis']; ?> avis)</p>
                                
                            </div>
                            <p><?php echo $offre['resume']; ?></p>
                            <div class="bas-offre">
                                <div>   
                                    <img src="/images/icons/<?php echo ($offre['en_ligne'] == 1) ? 'wifi-on' : 'wifi-off'; ?>.svg" alt="Statut en ligne">
                                    <p><?php echo ($offre['en_ligne'] == 1) ? 'En ligne' : 'Hors ligne'; ?></p>
                                </div>


                                <div>
                                    <a href="/backOffice/detailOffre?id_offre=<?php echo $offre['id_offre']; ?>">
                                        <img src="/images/icons/pensil-square.svg" alt="bouton modifier">
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </main>
            <?php require_once($_SERVER['DOCUMENT_ROOT'] .'/../views/backOffice/components/footer.php'); ?>
        </div>

    </div>

</body>

</html>