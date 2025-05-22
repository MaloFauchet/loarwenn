<?php
// On inclut le controller OffreActivité
require_once($_SERVER['DOCUMENT_ROOT'] .  '/../controllers/OffreController.php');
// On instancie le controller
$offreController = new OffreController();
// On récupère l'ID de l'offre à afficher
$id = $_GET['id'] ?? null;
//On récupère l'offre d'activité par son ID
$offre = $offreController->getOffreById($id);

 /**
  * Affichage des étoiles en fonction de la note
  *La note est une etoile remplie si elle est supérieure ou égale à 0.8
*/ 
function afficherEtoile($note){
   
    $etoiles = '';
    for ($i = 0; $i < 5; $i++) {
        if ($note >= $i + 0.8) {
            $etoiles .= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                        </svg>';
        } elseif ($note > $i && $note < $i + 1) {
            $etoiles .= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-half" viewBox="0 0 16 16">
                            <path d="M5.354 5.119 7.538.792A.52.52 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.54.54 0 0 1 16 6.32a.55.55 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.5.5 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.6.6 0 0 1 .085-.302.51.51 0 0 1 .37-.245zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.56.56 0 0 1 .162-.505l2.907-2.77-4.052-.576a.53.53 0 0 1-.393-.288L8.001 2.223 8 2.226z"/>
                        </svg>';
        } else {
            $etoiles .= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                            <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                        </svg>';
        }
    }
    return $etoiles;
}
?>

<!-- Main-->
<main>
    <div class="breadcrumb-container">
        <a href="index.php" class="breadcrumb-back-link">
            <img src="/images/icons/chevron-left.svg" alt="Retour" class="breadcrumb-back">
        </a>
        <nav class="breadcrumb">
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li>Offre détaillée</li>
            </ul>
        </nav>
    </div>
    <section>

        <!-- Image et titre de l'offre -->
        <article>
            <figure class="offre">
                <div class="offre-image-container">
                    <!--Image a recup dans la bdd -->
                    <div class="main-image-container">
                        <img src="/images/offres/cannyoning2.png" alt="Image de l'offre" class="offre-image">
                    </div>
                    <div class="gallery-offre-parent">
                        <div class="grid-offre-1">
                            <img src="<?= $offre->getPathImage() ?>" alt="Image de l'offre">
                        </div>
                        <div class="grid-offre-2">
                            <img src="<?= $offre->getPathImage() ?>" alt="Image de l'offre">
                        </div>
                        <div class="grid-offre-3">
                            <img src="<?= $offre->getPathImage() ?>" alt="Image de l'offre">
                        </div>
                        <div class="grid-offre-4">
                            <img src="<?= $offre->getPathImage() ?>" alt="Image de l'offre">
                        </div>
                    </div>
                </div>
                <figcaption>
                    <h2> <?= $offre->getTitre() ?></h2>
                <figcaption>
            </figure>
        </article>
        <hr>

        <!-- Profi Du Pro -->
        <article>
            <figure class="pp-pro">
                <!--PP a recup dans la bdd -->
                <img src="/images/profils/elouan.jpg" alt="Photo de profil pro" id="pp-pro">
                <figcaption>
                    <h4>Association : Armor Naviguation<!--Denomination a recup dans la bdd--></h4>
                    <?php
                        // Si pro est SUPER ASSO | ORGANISATION
                        echo '<p>Super Association</p>';
                    ?>
                </figcaption>
            </figure>
            <div>
                <h2> <?= $offre->getNoteMoyenne() ?></h2>
                <div class="star-container">
                    <?php $etoiles = afficherEtoile($offre->getNoteMoyenne()); ?>
                    <?= $etoiles ?>
                </div>
                <p>sur <?= $offre->getNbAvis() ?> avis </p>
            </div>
        </article>
        <hr>

        <!-- Informations sur l'offre -->
        <article class="info">
            <div>
                <h3>Résumé</h3>
                <p> <?= $offre->getResume() ?></p>
            </div>
            <div>
                <h3>Description</h3>
                <p> <?= $offre->getDescription() ?></p>
            </div>
        </article>
        <hr>

        <!-- Informations Pratique -->  
        <article class="info">
            <h3>Informations pratiques</h3>
            <ul>
                <li>
                    <figure class="info-pratique">
                        <img src="/images/icons/geo-alt-fill.svg" alt="Localisation">
                        <figcaption>
                            <h3> <?= $offre->getAdresse()?>, <?= $offre->getVille()?></h3>
                        </figcaption>
                    </figure>
                </li>
                <?php
                    //En fonction du type d'offre, on affiche les différentes informations
                    switch ($offre->getType()) :
                    case 'Visite guidée': 
                ?>
                <li>
                    <figure class="info-pratique">
                        <img src="/images/icons/clock.svg" alt="Duree">
                        <figcaption>
                            <h3> <?= $offre->getDuree() ?>H </h3>
                        </figcaption>
                    </figure>
                </li>
                <li>
                    <figure class="info-pratique">
                        <img src="/images/icons/person-wheelchair.svg" alt="Accessibilite">
                        <figcaption>
                            <h3> <?= $offre->getAccessibilite()?> </h3>
                        </figcaption>
                    </figure>
                </li>
                <?php
                    break;
                    case 'Spectacle':
                ?>
                <li>
                    <figure class="info-pratique">
                        <img src="/images/icons/clock.svg" alt="Horaires">
                        <figcaption>
                            <h3> <?= $offre->getDuree() ?>H </h3>
                        </figcaption>
                    </figure>
                </li>
                <li>
                    <figure class="info-pratique">
                        <img src="/images/icons/person-wheelchair.svg" alt="Accessibilite">
                        <figcaption>
                            <h3> <?= $offre->getAccessibilite()?> </h3>
                        </figcaption>
                    </figure>
                </li>
                <li>
                    <figure class="info-pratique">
                        <img src="/images/icons/person-circle.svg" alt="Capacite">
                        <figcaption>
                            <h3> <?= $offre->getCapacite() ?></h3>
                        </figcaption>
                    </figure>
                </li>
                <li>
                    <figure class="info-pratique">
                        <img src="/images/icons/cash.svg" alt="Age">
                        <figcaption>
                            <h3> <?= $offre->getPrix()?> </h3>
                        </figcaption>
                    </figure>
                </li>
                <?php
                    break;
                    case 'Parc d\'attraction':
                ?>
                <li>
                    <figure class="info-pratique">
                        <img src="/images/icons/hypnotize.svg" alt="NBAttraction">
                        <figcaption>
                            <h3> <?= $offre->getNbAttraction() ?> </h3>
                        </figcaption>
                    </figure>
                </li>
                <li>
                    <figure class="info-pratique">
                        <img src="/images/icons/person-circle.svg" alt="Age">
                        <figcaption>
                            <h3> <?= $offre->getAge() ?> </h3>
                        </figcaption>
                    </figure>
                </li>
                <?php
                    break;
                    case 'Activité':
                ?>
                <li>
                    <figure class="info-pratique">
                        <img src="/images/icons/clock.svg" alt="Duree">
                        <figcaption>
                            <h3> <?= $offre->getDuree() ?>H </h3>
                        </figcaption>
                    </figure>
                </li>
                <li>
                    <figure class="info-pratique">
                        <img src="/images/icons/person-wheelchair.svg" alt="Accessibilite">
                        <figcaption>
                            <h3> <?= $offre->getAccessibilite()?> </h3>
                        </figcaption>
                    </figure>
                </li>
                <li>
                    <figure class="info-pratique">
                        <img src="/images/icons/person-circle.svg" alt="Age">
                        <figcaption>
                            <h3> <?= $offre->getAge() ?> </h3>
                        </figcaption>
                    </figure>
                </li>
                <?php
                    break;
                    case 'Restauration':
                ?>
                <li>
                    <figure class="info-pratique">
                        <img src="/images/icons/person-circle.svg" alt="Age">
                        <figcaption>
                            <h3> <?= $offre->getPrix() ?>H</h3>
                        </figcaption>
                    </figure>
                </li>
                <?php
                    break;
                    endswitch;
                ?>
            </ul>
        </article>
        <article class="tags">
            <ul class="tag-list">
                <?php
                    //On affiche le nb de tag récuperé
                    foreach ($offre->getTags() as $tags):
                ?>
                <li>
                    <div class="tag-container">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tag" viewBox="0 0 16 16">
                            <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0"/>
                            <path d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1m0 5.586 7 7L13.586 9l-7-7H2z"/>
                        </svg>
                        <h3> <?= $tags ?> </h3>
                    </div>
                </li>
                <?php
                    endforeach;
                ?>
            </ul>
        </article>
    </section>
</main>