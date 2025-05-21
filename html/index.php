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
    <link rel="stylesheet" href="styles/frontOffice.css">
</head>
<body>
    <main>
        <!-- Header compris dans le composant pageAccueil -->
        <?php 
            require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/frontOffice/pageAccueil.php');
            // require_once('../views/backOffice/pageAccueil.php');
        ?>
    </main>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/frontOffice/components/footer.php'); ?>
</body>
</html>