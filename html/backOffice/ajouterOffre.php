<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/UtilisateurController.php');

$controller = new UtilisateurController();
$utilisateurs = $controller->afficherUtilisateurs();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/backOffice.css">
</head>
<body>
    <main>
        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/components/header.php'); ?>
        <?php 
            // require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/pageAccueil.php');
            require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/ajouterOffre.php');
        ?>
    </main>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/components/footer.php'); ?>
</body>
</html>