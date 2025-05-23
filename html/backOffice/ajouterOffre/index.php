<?php 
session_start();
// Vérification de la session
if (!isset($_SESSION['id_utilisateur'])) {
    header('Location: /backOffice/connexion/connexionPro.php');
    exit();
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>PACT</title>
    <link rel="icon" type="image/png" href="/images/logos/logoBlue.png">
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/backOffice.css">
    
    <link rel="stylesheet" href="/styles/components/headerBackOffice.css">
    <link rel="stylesheet" href="/styles/components/footerBackOffice.css">
    <link rel="stylesheet" href="/styles/components/navBackOffice.css">
    <link rel="stylesheet" href="/styles/components/input.css">
    
</head>
<body>
    <main>
        
        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/components/header.php'); ?>
        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/components/nav.php'); ?>
        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/ajouterOffre/ajouterOffre.php'); ?>
        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/components/footer.php'); ?>
        
    </main>
    
</body>
</html>