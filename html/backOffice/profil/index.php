<?php
session_start();
// Vérification de la session
if (!isset($_SESSION['id_utilisateur'])) {
    header('Location: /frontOffice/connexion/connexionPro.php');
    exit();
}
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/ProfessionnelController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PACT</title>
    <link rel="icon" type="image/png" href="/images/logos/logoBlue.png">
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/backOffice.css">
    <link rel="stylesheet" href="/styles/infoComptePro.css">
    <link rel="stylesheet" href="/styles/components/input.css">
    <link rel="icon" type="image/png" href="/images/logos/logoBlue.png">
</head>
<body>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/infosCompte.php'); ?>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/components/footer.php'); ?>
</body>
</html>