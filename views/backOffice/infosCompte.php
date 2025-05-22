<?php 

// Vérifie si l'utilisateur est connecté
// TODO : Vérifier si l'utilisateur est un professionnel


require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/ProfessionnelController.php');

$controller = new ProfessionnelController();

// Récupère l'id de l'utilisateur connecté
// $id = $_SESSION['id_utilisateur'];
$id = 3;

// TODO : Vérifier si l'utilisateur est un professionnel privée
$isEntreprisePrivee = true;

// Récupère les informations de l'utilisateur
// $data = $controller->getProfessionnelById($id);

// Image
// $profilePicturePath = $data['chemin'];
$profilePicturePath = "/images/profils/elouan.jpg";

$attr_name = "denomination";
if ($isEntreprisePrivee) {
    $attr_name = "raison_sociale";
}

// input data
// $denominationEntreprise = $data[$attr_name];
// $nomEntreprise = $data['nom'];
// $prenomEntreprise = $data['prenom'];

// $telephoneEntreprise = $data['num_telephone'];
// $emailEntreprise = $data['email'];

// $adresseEntreprise = $data['adresse'];
// $complementAdresseEntreprise = $data['complement_adresse'];
// $codePostalEntreprise = $data['code_postal'];
// $villeEntreprise = $data['nom'];

// $sirenEntreprise = $data['siren'];
// $ribEntreprise = $data['rib'];

$denominationEntreprise = "Entreprise de test";
$nomEntreprise = "Dupont";
$prenomEntreprise = "Toto";

$telephoneEntreprise = "06 52 02 54 68";
$emailEntreprise = "toto.dupont@mail.fr";

$adresseEntreprise = "1 rue de la paix";
$complementAdresseEntreprise = "Appartement 1";
$codePostalEntreprise = "75001";
$villeEntreprise = "Paris";

$sirenEntreprise = "123456789";
$ribEntreprise = "FR7612345678901234567890123";


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information de mon compte</title>
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/backOffice.css">
    <link rel="stylesheet" href="/styles/infoComptePro.css">
    <link rel="stylesheet" href="/styles/components/input.css">
</head>
<body>
    

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/components/header.php'); ?>

    <div class="page-back-office">
        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/components/nav.php'); ?>
        <div class="container-back-office">
            <main class="contenu-back-office info-compte">

                
            <h1>Compte</h1>
            
            <h2>Informations personnelles</h2>
            
            <div class="info-compte-container">
                <img src="<?= $profilePicturePath ?>" alt="<?= $denominationEntreprise ?>" id="photo-profil">
                <input type="file" src="<?= $profilePicturePath ?>" alt="Photo de profil" id="photo-profil-input" accept="image/*" width="306px" height="306px">

                <div>
                    <label class="label-input" for="denominationEntreprise">NOM DE L'ENTREPRISE</label>
                    <input type="text" name="denominationEntreprise" id="denominationEntreprise" value="<?= $denominationEntreprise ?>" required>
                    <div class="input-row">
                        <div class="input">    
                            <label class="label-input" for="nomEntreprise">NOM</label>
                            <input type="text" name="nomEntreprise" id="nomEntreprise" value="<?= $nomEntreprise ?>" required>
                        </div>
                        <div class="input">
                            <label class="label-input" for="prenomEntreprise">PRÉNOM</label>
                            <input type="text" name="prenomEntreprise" id="prenomEntreprise" value="<?= $prenomEntreprise ?>" required>
                        </div>
                    </div>
                    <label class="label-input" for="telephoneEntreprise">NUMÉRO DE TÉLÉPHONE</label>
                    <input type="tel" name="telephoneEntreprise" id="telephoneEntreprise" value="<?= $telephoneEntreprise ?>" required>
                    <label class="label-input" for="emailEntreprise">E-MAIL</label>
                    <input type="email" name="emailEntreprise" id="emailEntreprise" value="<?= $emailEntreprise ?>" required>
                </div>
            </div>
            <div>

                <h3>Adresse Postale</h3>
                <label class="label-input" for="adresseEntreprise">ADRESSE</label>
                <input type="text" name="adresseEntreprise" id="adresseEntreprise" value="<?= $adresseEntreprise ?>" required>
                <div class="input-row">
                    <div class="input">
                        <label class="label-input" for="villeEntreprise">VILLE</label>
                        <input type="text" name="villeEntreprise" id="villeEntreprise" value="<?= $villeEntreprise ?>" required>
                    </div>
                    <div class="input">
                        <label class="label-input" for="codePostalEntreprise">CODE POSTAL</label>
                        <input type="text" name="codePostalEntreprise" id="codePostalEntreprise" value="<?= $codePostalEntreprise ?>" required>
                    </div>
                </div>
                <label class="label-input" for="complementAdresseEntreprise">COMPLÉMENT D'ADRESSE</label>
                <input type="text" name="complementAdresseEntreprise" id="complementAdresseEntreprise" value="<?= $complementAdresseEntreprise ?>" required>

                <?php if ($isEntreprisePrivee) { ?>
                <h3>Entreprise Privé</h3>
                <label class="label-input" for="sirenEntreprise">NUMÉRO SIREN</label>
                <input type="text" name="sirenEntreprise" id="sirenEntreprise" value="<?= $sirenEntreprise ?>" required>
                <label class="label-input" for="ribEntreprise">RIB</label>
                <input type="text" name="ribEntreprise" id="ribEntreprise" value="<?= $ribEntreprise ?>" required>
                <?php } ?>
                
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

            <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/components/footer.php'); ?>
        </div>
    </div>

    

    <script src="/scripts/sauvegardeInfosCompteBack.js"></script>
</body>
</html>