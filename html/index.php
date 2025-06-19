<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/componentsGlobaux/afficherEtoile.php');
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['id_utilisateur']) && !isset($_SESSION['pseudo'])) {
        header("Location: /backOffice/");
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>PACT</title>
    <link rel="icon" type="image/png" href="/images/logos/logoBlue.png">
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/frontOffice.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="body-main">
    <!-- Header compris dans le composant pageAccueil -->
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/frontOffice/pageAccueil.php');?>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/frontOffice/components/footer.php'); ?>

    <script src="<?='/scripts/caroussel.js'?>"></script>
    <script src="<?='/scripts/frontOffice.js'?>"></script>
    <script src="<?='/scripts/rechercheOffreAcceuil.js'?>"></script>
</body>
</html>