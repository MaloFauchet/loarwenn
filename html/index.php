<?php
/*require_once('../controllers/UtilisateurController.php');

$controller = new UtilisateurController();
$utilisateurs = $controller->afficherUtilisateurs();*/
    //require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/componentsGlobaux/afficherEtoile.php');
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    /*  POUR SLOAN POUR SAVOIR COMMENT RECUP UNE OFFRE RECEMMENT CONSULTE*/
    $tabConsulteRecement[] = 1;
    $tabConsulteRecement[] = 2;
    // Définir les cookies avant tout output
    setcookie('consulte',json_encode($tabConsulteRecement) ,time()+ 60 * 60 * 24 * 7, "/");
    $tabConsulteRecement[] = 8;
    setcookie('consulte',json_encode($tabConsulteRecement) , time() + 60 * 60 * 24 * 7, "/");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/frontOffice.css">
    
</head>
<body class="body-main">
    
        <!-- Header compris dans le composant pageAccueil -->
        <?php 
            require_once('../views/frontOffice/pageAccueil.php'); 
            // require_once('../views/backOffice/pageAccueil.php');
        ?>

    <?php require_once('../views/frontOffice/components/footer.php'); ?>

</body>
</html>