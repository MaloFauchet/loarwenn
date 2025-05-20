<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offre en détail</title>
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/backOffice.css">
    <link rel="stylesheet" href="/styles/offreDetailleActivite.css">
</head>
<body>

<div class="page-back-office">
        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/components/nav.php'); ?>
        
        <div class="container-back-office">
            <main class="contenu-back-office">
                <div class="status-offre">
                    <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider"></span>
                    </label>
                    <p>En ligne</p>
                </div>
                <div class="grid-images">
                    <img src="/images/offres/cannyoning.jpg" alt="Cannyoning">
                    <img src="/images/offres/imageOffre.png" alt="Fleurs paysage">
                    <img src="/images/offres/phare.png" alt="Phare">
                    <img src="/images/offres/paysage.png" alt="Paysage">
                    <img src="/images/offres/velo.png" alt="Vélo">
                </div>
                <!-- Mettre le input de MALO -->
                <div class="inputGroup">
                    <input type="text" required="" autocomplete="off" value="Cannyoning en famille">
                    <label for="name">Titre</label>
                </div>
                
                <hr class="black-separator">
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
            </main>
            <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/components/footer.php'); ?>
        </div>
    </div>
</body>
</html>