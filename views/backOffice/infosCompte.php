<?php 

require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/ProfessionnelController.php');

$controller = new ProfessionnelController();

// Récupère l'id de l'utilisateur connecté
$id = $_SESSION['id_utilisateur'];

// Récupère les informations de l'utilisateur
$data = $controller->getProfessionnelById($id)[0];

// Vérifier si l'utilisateur est un professionnel privée
if ($data['raison_sociale'] !== null) {
    $isEntreprisePrivee = false;
} else {
    $isEntreprisePrivee = true;
}


// Image
$profilePicturePath = $data['chemin'] ?? "/images/default_profil.png";

$denominationEntreprise;
// $ribEntreprise = "";
// $sirenEntreprise = "";

if ($isEntreprisePrivee) {
    $denominationEntreprise = $data['denomination'];
    $ribEntreprise = $data['rib'];
    $sirenEntreprise = $data['siren'];
} else {
    $denominationEntreprise = $data['raison_sociale'];
}

// input data
$nomEntreprise = $data['nom'];
$prenomEntreprise = $data['prenom'];

$telephoneEntreprise = $data['num_telephone'];
$emailEntreprise = $data['email'];

$adresseEntreprise = $data['adresse'];
$complementAdresseEntreprise = $data['complement_adresse'];
$codePostalEntreprise = $data['code_postal'];
$villeEntreprise = $data['nom_ville'];

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
                    <img src="<?= $profilePicturePath ?>" alt="Photo de profil de <?= $denominationEntreprise ?>"
                        id="photo-profil">
                    <input type="file" src="<?= $profilePicturePath ?>" alt="Photo de profil" id="photo-profil-input"
                        accept="image/*" width="306px" height="306px">

                    <div>
                        <label class="label-input" for="denominationEntreprise">NOM DE L'ENTREPRISE *</label>
                        <input type="text" name="denominationEntreprise" id="denominationEntreprise"
                            value="<?= $denominationEntreprise ?>" required>
                        <div class="input-row">
                            <div class="input">
                                <label class="label-input" for="nomEntreprise">NOM *</label>
                                <input type="text" name="nomEntreprise" id="nomEntreprise" value="<?= $nomEntreprise ?>"
                                    required>
                            </div>
                            <div class="input">
                                <label class="label-input" for="prenomEntreprise">PRÉNOM *</label>
                                <input type="text" name="prenomEntreprise" id="prenomEntreprise"
                                    value="<?= $prenomEntreprise ?>" required>
                            </div>
                        </div>
                        <label class="label-input" for="telephoneEntreprise">NUMÉRO DE TÉLÉPHONE *</label>
                        <input type="tel" name="telephoneEntreprise" id="telephoneEntreprise"
                            value="<?= $telephoneEntreprise ?>" required>
                        <label class="label-input" for="emailEntreprise">E-MAIL *</label>
                        <input type="email" name="emailEntreprise" id="emailEntreprise" value="<?= $emailEntreprise ?>"
                            required>
                    </div>
                </div>
                <div>

                    <h3>Adresse Postale</h3>
                    <label class="label-input" for="adresseEntreprise">ADRESSE *</label>
                    <input type="text" name="adresseEntreprise" id="adresseEntreprise" value="<?= $adresseEntreprise ?>"
                        required>
                    <div class="input-row">
                        <div class="input">
                            <label class="label-input" for="villeEntreprise">VILLE *</label>
                            <input type="text" name="villeEntreprise" id="villeEntreprise"
                                value="<?= $villeEntreprise ?>" required>
                        </div>
                        <div class="input">
                            <label class="label-input" for="codePostalEntreprise">CODE POSTAL *</label>
                            <input type="text" name="codePostalEntreprise" id="codePostalEntreprise"
                                value="<?= $codePostalEntreprise ?>" required>
                        </div>
                    </div>
                    <label class="label-input" for="complementAdresseEntreprise">COMPLÉMENT D'ADRESSE</label>
                    <input type="text" name="complementAdresseEntreprise" id="complementAdresseEntreprise"
                        value="<?= $complementAdresseEntreprise ?>" required>

                    <?php if ($isEntreprisePrivee) { ?>
                    <h3>Entreprise Privé</h3>
                    <label class="label-input" for="sirenEntreprise">NUMÉRO SIREN *</label>
                    <input type="text" name="sirenEntreprise" id="sirenEntreprise" value="<?= $sirenEntreprise ?>"
                        required>
                    <label class="label-input" for="ribEntreprise">RIB *</label>
                    <input type="text" name="ribEntreprise" id="ribEntreprise" value="<?= $ribEntreprise ?>" required>
                    <?php } ?>

                    <a href="/changerMotDePasse" class="modification-mdp">Modifier mon mot de passe</a>

                    <div>
                        <h2>Sécurité</h2>
                        
                        <?php 
                        require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OTPController.php');      
                        $otpController = new OTPController();
                        $secret = $otpController->secretGenere($id);

                        if (!$secret) { 
                            ?>
                        <button type="button" id="activer-otp-bouton">Activer l'authentifiaction à 2 facteur</button>

                        <div id="opt-modal" class="opt-modal hidden" id="modal-otp">
                            <div class="opt-modal-content">
                                <h2>Activer l'authentification à 2 facteurs</h2>
                                <p>Veuillez configurer le code secret 
                                    dans une application prévue à cet effet en scannant ce QR Code. 
                                    (ex: google authenticator)</p>
                                    
                                <div id="qr-code-container"></div>

                                <p>En cas de perte de ce code secret, aucune modification n'est possible, garder le précieusement dans le google authenticator.</p>
                                
                                <p>Entrez le premier code OTP généré par ce code secret de l'application : </p>
                                <input name="otp-code-input" type="text" id="otp-code-input" placeholder="Entrez le code OTP généré" required>
                                <div class="container-button-modal">
                                    <button type="button" id="otp-valider-btn">Activer</button>
                                    <button type="button" id="otp-fermer-btn">Fermer</button>
                                </div>
                            </div>
                        </div>
                        <?php
                    } else {
                        if(isset($_SESSION['otp_secret'])) {
                            unset($_SESSION['otp_secret']);
                        }
                        ?>
                            <div class="otp-active-container">
                                <img src="/images/icons/check.svg" alt="check">
                                <p>L'authentification à 2 facteurs est activée et fonctionnelle.</p>
                            </div>
                        <?php } ?>
                    </div>
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
    <script src="/scripts/otpGestion.js"></script>
</body>

</html>