<?php 

$profilePicturePath = "/images/profils/elouan.jpg";

// input data
$nomEntreprise = "Nom de l'entreprise";
$telephoneEntreprise = "06 85 95 23 14";
$emailEntreprise = "Toto.dupont@gmail.com";
$siretEntreprise = "658574125615";
$adresseEntreprise = "8 rue du pont Paris";

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/styles/style.css">
    <link rel="stylesheet" href="/styles/input.css">
</head>
<body>
    <?php // include header
    require_once "../../../phpTemplates/headerBackOffice.php";
    ?>

    <div class="page-back-office">
        <?php require_once '../../../phpTemplates/navBack.php'; ?>
    

        <main class="info-compte">
            <h1>Compte</h1>
            
            <h2>Informations personnelles</h2>
            
            <div class="info-compte-container">
                <img src="<?= $profilePicturePath ?>" alt="Photo de profil">
                <div>                   
                    <label for="nomEntreprise">NOM DE L'ENTREPRISE</label>
                    <input type="text" name="nomEntreprise" id="nomEntreprise" value="<?= $nomEntreprise ?>">
                    <label for="telephoneEntreprise">NUMÉRO DE TÉLÉPHONE</label>
                    <input type="tel" name="telephoneEntreprise" id="telephoneEntreprise" value="<?= $telephoneEntreprise ?>">
                    <label for="emailEntreprise">E-MAIL</label>
                    <input type="email" name="emailEntreprise" id="emailEntreprise" value="<?= $emailEntreprise ?>">
                </div>
            </div>
            <div>
                <label for="siretEntreprise">NUMÉRO SIRET</label>
                <input type="text" name="siretEntreprise" id="siretEntreprise" value="<?= $siretEntreprise ?>">
                <label for="adresseEntreprise">ADRESSE POSTALE</label>
                <input type="text" name="adresseEntreprise" id="adresseEntreprise" value="<?= $adresseEntreprise ?>">
                <a href="/changerMotDePasse" class="modification-mdp">Modifier mon mot de passe</a>
            </div>

        </main>

        <div id="sauvegarder">
            <p>Voulez-vous appliquer les modifications ?</p>
            <div>
                <button type="button" id="annuler-btn">Annuler</button>
                <button type="button" id="sauvegarder-btn">Appliquer</button>
            </div>
        </div>
        
        <?php // include footer
        require_once "../../../phpTemplates/footerBack.php";
        ?>
    </div>

    <script src="/scripts/sauvegardeInfosCompteBack.js"></script>
</body>
</html>