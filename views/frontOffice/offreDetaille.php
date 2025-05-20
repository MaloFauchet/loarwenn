<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offre en détail</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body class="offre-detaille-front">

    <!-- Composant Header -->
    <?php require_once(__DIR__ . '/components/header.php'); ?>
    
    <!-- Main-->
    <main>
        <div class="breadcrumb-container">
            <a href="index.php" class="breadcrumb-back-link">
                <img src="images/icons/chevron-left.svg" alt="Retour" class="breadcrumb-back">
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
                            <img src="images/offres/canyioning2.png" alt="Image de l'offre" class="offre-image">
                        </div>
                        <div class="gallery-offre-parent">
                            <div class="grid-offre-1">
                                <img src="images/offres/canyioning2.png" alt="">
                            </div>
                            <div class="grid-offre-2">
                                <img src="images/offres/canyioning.jpg" alt="">
                            <div class="grid-offre-3">
                                <img src="images/offres/canyioning.jpg" alt="">
                            </div>
                            <div class="grid-offre-4">
                                <img src="images/offres/canyioning2.png" alt="">
                            </div>
                        </div>
                    </div>
                    <figcaption>
                        <h2>Excursion vers les 7 îles<!-- Titre a recup dans la bdd--></h2>
                    <figcaption>
                </figure>
            </article>
            <hr>

            <!-- Profi Du Pro -->
            <article>
                <figure class="pp-pro">
                    <!--PP a recup dans la bdd -->
                    <img src="images/profils/elouan.jpg" alt="Photo de profil pro" id="pp-pro">
                    <figcaption>
                        <h4>Association : Armor Naviguation<!--Denomination a recup dans la bdd--></h4>
                        <?php
                            // Si pro est SUPER ASSO | ORGANISATION
                            echo '<p>Super Association</p>';
                        ?>
                    </figcaption>
                </figure>
                <div>
                    <h2>3.7<!--Note a recup dans la bdd--></h2>
                    <div class="star-container">
                        <!-- On affiche le nombre d'étoiles en fonction des notes-->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                        </svg>
                    </div>
                    <p>sur 300 avis <!--Nombre d'avis a recup dans la bdd--></p>
                </div>
            </article>
            <hr>

            <!-- Informations sur l'offre -->
            <article class="info">
                <div>
                    <h3>Résumé</h3>
                    <p><!-- Résumé a recup dans la bdd -->
                        Découvrez l'archipel des Sept-îles,
                        la plus grande réserve ornithologique de France,
                        à bord d'une vedette ou d'un bateau de la Ligue de Protection des Oiseaux
                        
                    </p>
                </div>
                <div>
                    <h3>Description</h3>
                    <p><!-- Description a recup dans la bdd -->
                        Les Vedettes des 7 Iles proposent des excursions et des visites commentées vers l'archipel des Sept-Iles,
                        au départ de Perros-Guirec. 
                        Le site est protégé et l'accès aux îles réglementé,
                        mais vous pourrez néanmoins fouler le sol de l'Île-aux-Moines et admirer les autres îles depuis le bateau.
                        Les 7 îles sont un véritable sanctuaire pour les oiseaux marins,
                        notamment les goélands, les fous de Bassan et les macareux. ...Plus
                    </p>
                </div>
            </article>
            <hr>

            <!-- Informations Pratique -->  
            <article class="info">
                <h3>Informations pratiques</h3>
                <ul>
                    <li>
                        <figure class="info-pratique">
                            <img src="images/icons/clock.svg" alt="Horaires">
                            <figcaption>
                                <h3>3H<!-- Horaires a recup dans la bdd --></h3>
                            </figcaption>
                        </figure>
                    </li>
                    <li>
                        <figure class="info-pratique">
                            <img src="images/icons/geo-alt-fill.svg" alt="Localisation">
                            <figcaption>
                                <h3>Perros-guirec<!-- Localisation a recup dans la bdd --></h3>
                            </figcaption>
                        </figure>
                    </li>
                    <li>
                        <figure class="info-pratique">
                            <img src="images/icons/cake-fill.svg" alt="Age">
                            <figcaption>
                                <h3>12 ans<!-- Age a recup dans la bdd --></h3>
                            </figcaption>
                        </figure>
                    </li>
                    <li>
                        <figure class="info-pratique">
                            <img src="images/icons/cash.svg" alt="Prix">
                            <figcaption>
                                <h3>0€<!-- Prix a recup dans la bdd --></h3>
                            </figcaption>
                        </figure>
                    </li>
                </ul>
            </article>

            <article>
                <ul>
                    <?php
                        //On affiche le nb de tag
                        
                    ?>
                </ul>
            </article>
        </section>
    </main>
    <?php require_once('./footerFront.php'); ?>
</body>
</html>