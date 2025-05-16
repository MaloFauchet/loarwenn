<?php

function afficherEtoile($note){
    $etoiles = '';
    for ($i = 0; $i < 5; $i++) {
        if ($note >= $i + 1) {
            $etoiles .= '<img src="/images/icons/star-filled.svg" alt="Étoile remplie">';
        } elseif ($note > $i && $note < $i + 1) {
            $etoiles .= '<img src="/images/icons/star-half.svg" alt="Demi étoile">';
        } else {
            $etoiles .= '<img src="/images/icons/star-empty.svg" alt="Étoile vide">';
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
        <div class="container-back-office">
            
            <?php require_once '../../phpTemplates/navBack.php'; ?>
            

            <main class="contenu-back-office">
                <h1>Mes Offres</h1>
                <div class="offre">
                    <img src="/images/offres/imageOffre.png" alt="Image de l'offre">
                    <div>
                        <h2>Archipel de Béhat en kayak</h2>
                        <p>5</p>
                        <?php

                        ?>
                    </div>
                </div>  
            </main>
        </div>

        <footer class="footer-back-office">
            <?php require_once '../../phpTemplates/footerBack.php'; ?>
        </footer>
    </div>

    
    

</body>
</html>