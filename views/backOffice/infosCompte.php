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
$denominationLabel;
// $ribEntreprise = "";
// $sirenEntreprise = "";

if ($isEntreprisePrivee) {
    $denominationEntreprise = $data['denomination'];
    $denominationLabel = "Dénomination Sociale";
    $ribEntreprise = $data['rib'];
    $sirenEntreprise = $data['siren'];
} else {
    $denominationEntreprise = $data['raison_sociale'];
    $denominationLabel = "Raison Sociale";
}

// input data
$nom = $data['nom'];
$prenom = $data['prenom'];

$telephoneEntreprise = $data['num_telephone'];
$emailEntreprise = $data['email'];
$lienSiteWeb = $data['lien_site_web'];

$numeroAdresse = ($data['numero_adresse']) ? $data['numero_adresse'] : "";  

$voieEntreprise = ($data['voie']) ? $data['voie'] : "";
                                                         // Remplacer par $data['voie'] quand la bdd sera mise à jour
$complementAdresseEntreprise = $data['complement_adresse'];
$codePostalEntreprise = $data['code_postal'];
$villeEntreprise = $data['nom_ville'];
?>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/components/header.php'); ?>
<main> 
    <div class="page-back-office">
        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/components/nav.php'); ?>
        <form onsubmit="return sauvegarderClique()" method="post">
            <!-- <form onsubmit="" action="/api/compte/pro/update/" method="post"> -->

            <div class="container-back-office">
                <main class="contenu-back-office info-compte">
                    <h1>Compte</h1>

                    <h2>Informations personnelles</h2>

                    <div class="info-compte-container">
                        <img src="<?= $profilePicturePath ?>" alt="Photo de profil de <?= $denominationEntreprise ?>"
                            id="photo-profil">
                        <input aria-label="Photo de profil" type="file" src="<?= $profilePicturePath ?>" alt="Photo de profil"
                            id="photo-profil-input" accept="image/*" width="306px" height="306px">

                        <div>
                            <label class="label-input" for="denominationEntreprise"><?= $denominationLabel ?> *</label>
                            <input type="text" name="denominationEntreprise" id="denominationEntreprise"
                                value="<?= $denominationEntreprise ?>" required>
                            <div class="input-row">
                                <div class="input">
                                    <label class="label-input" for="nom">NOM *</label>
                                    <input type="text" name="nom" id="nom" value="<?= $nom ?>" required>
                                </div>
                                <div class="input">
                                    <label class="label-input" for="prenom">PRÉNOM *</label>
                                    <input type="text" name="prenom" id="prenom" value="<?= $prenom ?>" required>
                                </div>
                            </div>
                            <label class="label-input" for="telephoneEntreprise">NUMÉRO DE TÉLÉPHONE *</label>
                            <input type="tel" name="telephoneEntreprise" id="telephoneEntreprise"
                                value="<?= $telephoneEntreprise ?>" required>
                            <label class="label-input" for="emailEntreprise">E-MAIL *</label>
                            <input type="email" name="emailEntreprise" id="emailEntreprise"
                                value="<?= $emailEntreprise ?>" required>
                            
                            <label class="label-input" for="siteWeb">Site web</label>
                            <input type="text" name="siteWeb" id="siteWeb"
                                value="<?= $lienSiteWeb ?>" required>
                        </div>
                    </div>
                    <div>

                        <h3>Adresse Postale</h3>
                        <div class="input-row" id="addresse-voie-row">
                            <div class="input" id="numero-addr-container">
                                <label class="label-input" for="numeroAdresse">NUMÉRO *</label>
                                <input type="text" name="numeroAdresse" id="numeroAdresse" value="<?= $numeroAdresse ?>"
                                    required>
                            </div>
                            <div class="input" id="voie-input-container">
                                <label class="label-input" for="voieEntreprise">VOIE *</label>
                                <input type="text" name="voieEntreprise" id="voieEntreprise"
                                    value="<?= $voieEntreprise ?>" required>
                            </div>
                        </div>
                        <div class="input-row" id="ville-code-postal-row">
                            <div class="input" id="ville-input-container">
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
                            value="<?= $complementAdresseEntreprise ?>">

                        <?php if ($isEntreprisePrivee) { ?>
                        <h3>Entreprise Privé</h3>
                        <label class="label-input" for="sirenEntreprise">NUMÉRO SIREN *</label>
                        <input type="text" name="sirenEntreprise" id="sirenEntreprise" value="<?= $sirenEntreprise ?>"
                            required>
                        <label class="label-input" for="ribEntreprise">IBAN *</label>
                        <input type="text" name="ribEntreprise" id="ribEntreprise" value="<?= $ribEntreprise ?>"
                            required>
                        <?php } ?>

                        <div>
                            <h2>Sécurité</h2>

                            <?php 
                        require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OTPController.php');      
                        $otpController = new OTPController();
                        $secret = $otpController->secretGenere($id);

                        if (!$secret) { 
                            ?>
                            <button type="button" id="activer-otp-bouton">Activer l'authentifiaction à 2
                                facteur</button>

                            <div id="opt-modal" class="opt-modal hidden" id="modal-otp">
                                <div class="opt-modal-content">
                                    <h2>Activer l'authentification à 2 facteurs</h2>
                                    <p>Veuillez configurer le code secret
                                        dans une application prévue à cet effet en scannant ce QR Code.
                                        (ex: google authenticator)</p>

                                    <div id="qr-code-container"></div>

                                    <p>En cas de perte de ce code secret, aucune modification n'est possible, garder le
                                        précieusement dans le google authenticator.</p>

                                    <p>Entrez le premier code OTP généré par ce code secret de l'application : </p>
                                    <input name="otp-code-input" type="text" id="otp-code-input"
                                        placeholder="Entrez le code OTP généré" required>
                                    <div class="container-button-modal">
                                        <button aria-label="Activer" type="button" id="otp-valider-btn">Activer</button>
                                        <button aria-label="Fermer" type="button" id="otp-fermer-btn">Fermer</button>
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

                        <!-- <a href="/changerMotDePasse" class="modification-mdp">Modifier mon mot de passe</a> -->
                    </div>
                </main>

                <div id="sauvegarder">
                    <p>Voulez-vous appliquer les modifications ?</p>
                    <div>
                        <button aria-label="Annuler" type="button" id="annuler-btn">Annuler</button>
                        <button aria-label="Appliquer" type="button" id="sauvegarder-btn">Appliquer</button>
                    </div>
                </div>
            </div>
        </form>

    </div>

    <script src="/scripts/sauvegardeInfosCompteBack.js"></script>
    <script src="/scripts/otpGestion.js"></script>
</main> 