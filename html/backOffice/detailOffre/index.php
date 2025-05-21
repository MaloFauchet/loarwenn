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
    <link rel="stylesheet" href="/styles/offreDetailleBack.css">
</head>

<body>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/components/header.php'); ?>
    <div class="page-back-office">
        <div class="container-back-office">
            <?php require_once($_SERVER['DOCUMENT_ROOT'].'/../views/backOffice/components/nav.php'); ?>
            <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/offreDetaille.php');?>
        </div>
        <?php require_once($_SERVER['DOCUMENT_ROOT'].'/../views/backOffice/components/footer.php'); ?>
    </div>
</body>

</html>