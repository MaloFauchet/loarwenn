<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offre en détails</title>
    <link rel="stylesheet" href="/styles/listeOffre.css">
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/components/headerFrontOffice.css">
    <link rel="stylesheet" href="/styles/components/footerFrontOffice.css">
</head>
<body class="liste-offre">

    <!-- Appel de la vue Header -->
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/frontOffice/components/header.php'); ?>
    <!-- Appel de la vue Liste Offre -->
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/frontOffice/listeOffre.php'); ?>
    <!-- Appel de la vue Footer -->
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/frontOffice/components/footer.php'); ?>

    
    <script src="/scripts/openFilter.js"></script>
    <script src="/scripts/filter.js"></script>
    <script src="/scripts/listeOffre.js"></script>
</body>
</html>