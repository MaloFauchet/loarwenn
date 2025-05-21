<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/UtilisateurController.php');

$controller = new UtilisateurController();
$utilisateurs = $controller->afficherUtilisateurs();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>PACT</title>
    <link rel="icon" type="image/png" href="/images/logos/logoBlue.png">
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/backOffice.css">
</head>
<body>
    <main>
        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/components/header.php'); ?>
        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/pageAccueil.php'); ?>
        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/components/footer.php'); ?>
    </main>
</body>
</html>