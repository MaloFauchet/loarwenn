<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/../views/backOffice/components/inputAjoutMultiple.php');
if(isset($_GET['id_offre'])) {
    $id_offre = $_GET['id_offre'];
} else {
    header('Location: /html/backOffice/index.php');
    exit();
}
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/Offre.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/../controllers/OffreController.php');

$offreController = new OffreController();

$currentOffre = $offreController->getOffreById($id_offre);

// Récupération du type, des tags et de l'id du type d'activité
$type_activite = $currentOffre->getType();
?>

<head>
    <meta charset="UTF-8">
    <title>PACT</title>
    <link rel="icon" type="image/png" href="/images/logos/logoBlue.png">
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/components/headerBackOffice.css">
    <link rel="stylesheet" href="/styles/components/navBackOffice.css">
    <link rel="stylesheet" href="/styles/components/footerBackOffice.css">
    <link rel="stylesheet" href="/styles/backOffice.css">
    <link rel="stylesheet" href="/styles/offreDetailleBack.css">
    <link rel="stylesheet" href="/styles/components/ajoutMultiple.css">
    <link rel="stylesheet" href="/styles/components/input.css">
</head>

<body>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/components/header.php'); ?>
    <div class="page-back-office">
        <div class="container-back-office">
            <?php 
            require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/components/nav.php'); 

            if($type_activite == 'Activité') {
                require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/detailOffre/activite.php');
            } elseif($type_activite == 'Visite guidée') {
                require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/detailOffre/visite.php');
            } elseif($type_activite == 'Parc d\'attraction') {
                require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/detailOffre/parcAttraction.php');
            } elseif($type_activite == 'Spectacle') {
                require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/detailOffre/spectacle.php');
            } elseif($type_activite == 'Restaurant') {
                require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/detailOffre/restaurant.php');
            }
            ?>
        </div>
        <?php require_once($_SERVER['DOCUMENT_ROOT'].'/../views/backOffice/components/footer.php'); ?>
    </div>
</body>

</html>