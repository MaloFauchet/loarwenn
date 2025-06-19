<?php
session_start();
function dump($data) {
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}
// Vérification de la session
if (!isset($_SESSION['id_utilisateur'])) {
    header('Location: /frontOffice/connexion/connexionPro.php');
    exit();
}

require_once($_SERVER['DOCUMENT_ROOT'].'/../views/backOffice/components/inputAjoutMultiple.php');
if(isset($_GET['id_offre'])) {
    $id_offre = $_GET['id_offre'];
} else {
    header('Location: /html/backOffice/index.php');
    exit();
}
// Inclusion des fichiers nécessaires : modèle Offre, contrôleur Offre, et autres contrôleurs
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/Offre.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/../controllers/OffreController.php');
require_once $_SERVER['DOCUMENT_ROOT'] . '/../controllers/TagController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../controllers/TypeActiviteController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../controllers/PrestationController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../controllers/UtilisateurController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../controllers/LangueController.php';
require_once($_SERVER['DOCUMENT_ROOT'] .'/../views/componentsGlobaux/afficherEtoile.php');

// Création des instances des contrôleurs nécessaires
$offreController = new OffreController();
$typeActiviteController = new TypeActiviteController();
$prestationController = new PrestationController();
$utilisateurController = new UtilisateurController();

function stringToTab($string) {
    return $string ? explode(',', $string) : [];
    
}

$currentOffre = $offreController->getOffreById($_SESSION["id_utilisateur"],$id_offre);

// Récupération du type, des tags et de l'id du type d'activité
$type_activite = $currentOffre['type_offre'];

// Récupération des informations de l'utilisateur
$infoPro = $utilisateurController->getInfoUtilisateur($_SESSION['id_utilisateur']);

// Récupération des strings et conversion en tableaux
$tags = stringToTab($currentOffre['tags']);
$repas = stringToTab($currentOffre['repas']);
$langue = stringToTab($currentOffre['langue']);
$prestationIncluses = stringToTab($currentOffre['prestation_incluses']);
$prestationNonIncluses = stringToTab($currentOffre['prestation_non_incluses']);

//$currentOffre['horaires'] = //TODO explode la string;

?>

<!DOCTYPE html>
<html lang="fr">
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
            require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/components/nav.php'); ?>


            <main class="contenu-back-office">
                <div id="reponse-flash" class="flash-card" style="display:none">
                    <p id="message-flash"></p>
                </div>
                <div class="status-offre">
                    <label class="switch">
                        <input class="slider-etat" id="slider-etat" type="checkbox" <?php echo ($currentOffre['en_ligne'] == 1) ? "checked" : ""; ?>>
                        <span class="slider"></span>
                    </label>
                    <p class="status-text"><?php echo ($currentOffre['en_ligne'] == 1) ? 'En ligne' : 'Hors ligne'; ?></p>

                </div>
                <div class="grid-images">

                    <img src="/images/offres/canyoning.jpg" alt="Canyoning">
                    <img src="/images/offres/paysage.png" alt="Fleurs paysage">
                    <img src="/images/offres/phare.png" alt="Phare">
                    <img src="/images/offres/paysage.png" alt="Paysage">
                    <img src="/images/offres/velo.png" alt="Vélo">
                </div>
                <input type="hidden" id="titre_image" name="titre_image" value="<?= $currentOffre["titre_image"] ?>">
                <input type="file" id="chemin_image" name="chemin_image" accept="image/*" style="display:none" value="<?= $currentOffre["chemin"] ?>">
                <div class="input-titre">
                    <label class="label-input" for="titre">Titre</label>
                    <input id="titre" type="text" 
                    value="<?php echo $currentOffre["titre_offre"] ?>" required />
                </div>

                <article>
                    <hr class="black-separator"> 
                    <div class="profil-note">
                        <figure class="pp-pro">
                            <!--PP a recup dans la bdd -->
                            <img src="/images/profils/1.jpg" alt="Photo de profil pro" id="pp-pro">
                            <figcaption>
                                <h4><?= $currentOffre['denomination'] ? $currentOffre['denomination']:$currentOffre['raison_sociale'] ?>
                                    <!--Denomination a recup dans la bdd-->
                                </h4>
                                <p><?= $currentOffre['nom_utilisateur'] ?></p>
                                <p><?= $currentOffre['prenom'] ?></p>
                                <!--Email a recup dans la bdd-->
                                <p><?= $currentOffre['telephone_utilisateur'] ?></p>
                                    <!--Téléphone a recup dans la bdd-->
                            </figcaption>
                        </figure>

                        <div class="note">
                            <h2>
                                <!--Note a recup dans la bdd-->
                                <?=$currentOffre["note_avis"]?>
                            </h2>
                            <div class="star-container">
                                <!-- On affiche le nombre d'étoiles en fonction des notes-->
                                <?php
                                if ($currentOffre["note_avis"] == null) {
                                    echo afficherEtoile(0);
                                } else {
                                    echo afficherEtoile($currentOffre["note_avis"]);
                                }?>
                            </div>
                            <p><?=$currentOffre["nb_avis"]?>
                                <!--Nombre d'avis a recup dans la bdd-->
                            </p>
                        </div>
                    </div>
                    <hr class="black-separator">
                    <div class="info-divers">
                        <input type="text" id="type-offre" name="type-offre" value="<?= $currentOffre["type_offre"] ?>" hidden>
                        <div class="prix">
                            <img src="/images/icons/currency-euro.svg" alt="Prix">
                            <div class="input-divers">
                                <label class="label-input" for="prix">Prix</label>
                                <input id="prix" name="prix" type="number" 
                                value="<?php echo $currentOffre["prix_ttc_min"] ?>" min="0" required />
                            </div>
                        </div>
                    </div>

                    <div class="lieux">
                        <img src="/images/icons/geo-alt.svg" alt="Point GPS">
                        <div class="input-lieux">
                            <label class="label-input" for="numero-adresse">Numéro</label>
                            <input id="numero-adresse" name="numero-adresse" type="number" 
                            value="<?php echo $currentOffre["numero_adresse"] ?>" min="0" required />
                        </div>
                    </div>

                    <div class="lieux">
                        <img src="/images/icons/geo-alt.svg" alt="Point GPS">
                        <div class="input-lieux">
                            <label class="label-input" for="voie">Voie</label>
                            <input id="voie" name="voie" type="text" 
                            value="<?php echo $currentOffre["voie"] ?>" required />
                        </div>
                    </div>

                    <div class="lieux">
                        <img src="/images/icons/geo-alt.svg" alt="Point GPS">
                        <div class="input-lieux">
                            <label class="label-input" for="complement-adresse">Complément d'adresse</label>
                            <input id="complement-adresse" name="complement-adresse" type="text" 
                            value="<?php echo $currentOffre["complement_adresse"] ?>" required />
                        </div>
                    </div>

                    <div class="lieux">
                        <img src="/images/icons/geo-alt.svg" alt="Point GPS">
                        <div class="input-lieux">
                            <label class="label-input" for="code-postal">Code postal</label>
                            <input id="code-postal" name="code-postal" type="text" 
                            value="<?php echo $currentOffre["code_postal"] ?>" required />
                        </div>
                    </div>

                    <div class="lieux">
                        <img src="/images/icons/geo-alt.svg" alt="Point GPS">
                        <div class="input-lieux">
                            <label class="label-input" for="ville">Ville</label>
                            <input id="ville" name="ville" type="text" 
                            value="<?php echo $currentOffre["nom_ville"] ?>" required />
                        </div>
                    </div>
                    
                    <div class="resume">
                        <div class="input-divers">
                            <label class="label-input" for="resume">Résumé</label>
                            <textarea id="resume" name="resume" rows="4" cols="50"><?php echo $currentOffre["resume"] ?>
                            </textarea>
                        </div>
                    </div>

                    <div class="description">
                        <div class="input-divers">
                            <label class="label-input" for="description">Description</label>
                            <textarea id="description" name="description" rows="4" cols="50"><?php echo $currentOffre["description"] ?>
                            </textarea>
                        </div>
                    </div>

                    <div class="accessibilite">
                        <div class="input-divers">
                            <label class="label-input" for="accessibilite">accessibilite</label>
                            <textarea id="accessibilite" name="accessibilite" rows="4" cols="50"><?php echo $currentOffre["accessibilite"] ?>
                            </textarea>
                        </div>
                    </div>

                    <div class="jours">
                        <div class="input-divers">
                            <label class="label-input" for="jours">Jours</label>
                            <input id="jours" name="jours" type="text" 
                            value="<?php echo $currentOffre["jours_ouverture"] ?>" required />
                        </div>
                    </div>

                    <div class="matin_heure_debut">
                        <div class="input-divers">
                            <label class="label-input" for="matin_heure_debut">Horaires de début du matin </label>
                            <input id="matin_heure_debut" name="matin_heure_debut" type="text" 
                            value="<?php echo $currentOffre["horaires"] ?>" required />
                        </div>
                    </div>

                    <div class="matin_heure_fin">
                        <div class="input-divers">
                            <label class="label-input" for="matin_heure_fin">Horaires de fin du matin</label>
                            <input id="matin_heure_fin" name="matin_heure_fin" type="text" 
                            value="<?php echo $currentOffre["horaires"] ?>" required />
                        </div>
                    </div>

                    <div class="apres_midi_heure_debut">
                        <div class="input-divers">
                            <label class="label-input" for="apres_midi_heure_debut">Horaires de début de l'après-midi</label>
                            <input id="apres_midi_heure_debut" name="apres_midi_heure_debut" type="text" 
                            value="<?php echo $currentOffre["horaires"] ?>" required />
                        </div>
                    </div>

                    <div class="apres_midi_heure_fin">
                        <div class="input-divers">
                            <label class="label-input" for="apres_midi_heure_fin">Horaires de fin de l'après-midi</label>
                            <input id="apres_midi_heure_fin" name="apres_midi_heure_fin" type="text" 
                            value="<?php echo $currentOffre["horaires"] ?>" required />
                        </div>
                    </div>
                    <?php if($type_activite == 'activite') {
                            require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/detailOffre/activite.php');
                        } elseif($type_activite == 'visite_guide') {
                            require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/detailOffre/visite.php');
                        } elseif($type_activite == 'parc_attraction') {
                            require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/detailOffre/parcAttraction.php');
                        } elseif($type_activite == 'spectacle') {
                            require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/detailOffre/spectacle.php');
                        } 
                    ?>

                    <div class="choix-divers">
                        <?php if($type_activite == 'activite') { ?>
                            <div class="choix-prestation">
                                <?php ajoutMultiple('Prestation incluse', '', "prestation-incluse", $prestationIncluses); ?>
                                <?php ajoutMultiple('Prestation non incluse', '', "prestation-non-incluse", $prestationNonIncluses); ?>
                            </div>
                        <?php }elseif ($type_activite == 'restauration'){ ?>
                            <div class="choix-prestation">
                                <?php ajoutMultiple('Repas servi', '', "repas-servi", $repas); ?>
                            </div>

                       <?php }elseif ($type_activite == 'visite_guide') { ?>
                            <div class="choix-prestation">
                                <?php ajoutMultiple('Langue', '', "langue", $langue); ?>
                            </div>
                       <?php } ?>
                        <?php ajoutMultiple('Tags', '', "tags", $tags); ?>
                    </div>
                </article>
                <div id="sauvegarder">
                    <p>Voulez-vous appliquer les modifications ?</p>
                    <div>
                        <button type="button" id="annuler-btn">Annuler</button>
                        <button type="button" id="sauvegarder-btn">Appliquer</button>
                    </div>
                </div>
            </main>
        </div>
        <?php require_once($_SERVER['DOCUMENT_ROOT'].'/../views/backOffice/components/footer.php'); ?>
    </div>
</body>

</html>
<script src="/scripts/sauvegardeInfoOffre.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const checkbox = document.querySelector('.slider-etat');
    const statusText = document.querySelector('.status-text');

    // Fonction pour mettre à jour le texte
    function updateStatus() {
        statusText.textContent = checkbox.checked ? "En ligne" : "Hors ligne";
    }

    // Met à jour au changement
    checkbox.addEventListener('change', updateStatus);

    // Initialise au cas où
    updateStatus();
    
});
</script>