<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/frontOffice.css">
    <link rel="stylesheet" href="/styles/components/headerBackOffice.css">
    <link rel="stylesheet" href="/styles/components/footerBackOffice.css">
    <link rel="stylesheet" href="/styles/components/navBackOffice.css">
</head>
<body>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/frontOffice/components/header.php'); ?>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/frontOffice/offreDetaille.php');?>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/frontOffice/components/footer.php'); ?>
</body>
</html>