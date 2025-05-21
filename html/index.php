<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/UtilisateurController.php');

$controller = new UtilisateurController();
$utilisateurs = $controller->afficherUtilisateurs();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
<<<<<<< HEAD
    <title>PACT</title>
    <link rel="stylesheet" href="styles/frontOffice.css">
    <link rel="icon" type="image/png" href="/images/logos/logoBlue.png">
=======
    <title>Accueil</title>
    <link rel="stylesheet" href="styles/style.css">
>>>>>>> sloan-offreDetaille-front
</head>
<body>
    <main>
        <!-- Header compris dans le composant pageAccueil -->
        <?php 
<<<<<<< HEAD
            require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/frontOffice/pageAccueil.php');
=======
            require_once('../views/frontOffice/offreDetaille.php'); 
>>>>>>> sloan-offreDetaille-front
            // require_once('../views/backOffice/pageAccueil.php');
        ?>
    </main>

<<<<<<< HEAD
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/frontOffice/components/footer.php'); ?>
=======
    <?php require_once('../views/frontOffice/components/footer.php'); ?>
>>>>>>> sloan-offreDetaille-front
</body>
</html>