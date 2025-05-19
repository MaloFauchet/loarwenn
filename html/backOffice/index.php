<?php

function afficherEtoile($note)
{
    // Affichage des étoiles en fonction de la note
    // La note est une etoile remplie si elle est supérieure ou égale à 0.8
    $etoiles = '';
    for ($i = 0; $i < 5; $i++) {
        if ($note >= $i + 0.8) {
            $etoiles .= '<img src="/images/icons/star-fill.svg" alt="Étoile remplie">';
        } elseif ($note > $i && $note < $i + 1) {
            $etoiles .= '<img src="/images/icons/star-half.svg" alt="Demi étoile">';
        } else {
            $etoiles .= '<img src="/images/icons/star.svg" alt="Étoile vide">';
        }
    }
    return $etoiles;
}
?>



<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PACT</title>
    <link rel="stylesheet" href="/styles/style.css">

</head>

<body>
    <?php require_once '../../phpTemplates/headerBackOffice.php'; ?>

    <div class="page-back-office">
        <?php require_once '../../phpTemplates/navBack.php'; ?>
        <div class="container-back-office">
            <main class="contenu-back-office">
                <h1>Mes Offres</h1>
                <div class="offre">
                    <img src="/images/offres/imageOffre.png" alt="Image de l'offre">
                    <div>
                        <h2>Archipel de Béhat en kayak</h2>
                        <div class="avis-offre">
                            <p>3.5</p>
                            <div class="etoiles">
                                <?php
                                $note = 3.5;
                                echo afficherEtoile($note);

                                ?>
                            </div>
                            
                            <p>(300 avis)</p>
                            <p>0€</p>
                        </div>
                        <p>Les sorties sont volontairement limitées entre 15 km et 20 km pour permettre
                            à un large public familial de se joindre à nous.
                            A partir de 6 ou 7 ans, un enfant à l'aise sur son vélo...</p>
                        <div class="bas-offre">
                            <div>
                                <img src="/images/icons/wifi-on.svg" alt="Wifi on">
                                <p>En ligne</p>
                            </div>
                            <div>
                                <img src="/images/icons/pensil-square.svg" alt="bouton modifier">
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php require_once '../../phpTemplates/footerBack.php'; ?>
        </div>

    </div>

</body>

</html>