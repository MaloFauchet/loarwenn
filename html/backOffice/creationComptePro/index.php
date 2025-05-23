<?php
session_start();
// Vérification de la session
if (!isset($_SESSION['id_utilisateur'])) {
    header('Location: /backOffice/connexion/connexionPro.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Inscription PACT</title>
    <link rel="stylesheet" href="/styles/components/input.css" />
    <link rel="stylesheet" href="/styles/styles.css" />
    <link rel="stylesheet" href="/styles/components/formulaire.css" />
</head>
<body>
    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/../views/backOffice/components/creationCompte.php"); ?>
</body>
</html>

