<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>PACT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/offreDetaille.css">
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/components/headerFrontOffice.css">
    <link rel="stylesheet" href="/styles/components/footerFrontOffice.css">
    <link rel="icon" type="image/png" href="/images/logos/logoBlue.png">
</head>
<body class="offre-detaille-front">

    <!-- Appel de la vue Header -->
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/frontOffice/components/header.php'); ?>
    <!-- Appel de la vue Offre Détaillée -->
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/frontOffice/offreDetaille.php'); ?>
    <!-- Appel de la vue Footer -->
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/frontOffice/components/footer.php'); ?>

</body>
</html>