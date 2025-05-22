<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>PACT</title>
    <link rel="stylesheet" href="styles/frontOffice.css">
    <link rel="icon" type="image/png" href="/images/logos/logoBlue.png">
</head>
<body class="body-main">
    
        <!-- Header compris dans le composant pageAccueil -->
        <?php 
            require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/frontOffice/pageAccueil.php');
            // require_once('../views/backOffice/pageAccueil.php');
        ?>
    

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/frontOffice/components/footer.php'); ?>
</body>
</html>