<?php
    session_start();
    require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/UtilisateurController.php');

    /**
     * Récupère les informations du professionnel
     * Et les creer les variables de session
     */
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['mot-de-passe'])) {
        $utilisateurController = new UtilisateurController();
        $pro = $utilisateurController->connexionPro($_POST['email'], $_POST['mot-de-passe']);

        if ($pro) {
            //Redirection ou message de succès
            header('Location: /backOffice/index.php');
            exit;
        } else {
        ?>
            <script>
                alert("Erreur de connexion : Vérifiez votre email et mot de passe.");
            </script>        
        <?php
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de connexion</title>
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/components/input.css">
    <link rel="stylesheet" href="/styles/components/formulaire.css">
</head>
<body>
    <!-- Vue de connexion -->
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/frontOffice/components/connexionProfessionnel.php'); ?>
</body>
</html>