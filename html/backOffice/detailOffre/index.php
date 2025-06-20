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

$id_offre = null;
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

$currentOffre = $offreController->getOffreByIdDetails($_SESSION["id_utilisateur"],$id_offre);


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

$plageHoraire = explode(',', $currentOffre['horaires']);
$horaire1 = strtotime(trim(explode('|', $plageHoraire[0])[0]));
$horaire2 = strtotime(trim(explode('|', $plageHoraire[0])[1]));
if(count($plageHoraire) > 1) {
    $horaire3 = strtotime(trim(explode('|', $plageHoraire[1])[0]));
    $horaire4 = strtotime(trim(explode('|', $plageHoraire[1])[1]));
}
// Récupération des jours d'ouverture et conversion en tableau


$joursSemaines = explode(',', $currentOffre['jours_ouverture']);

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
                <!-- <div class="status-offre">
                    <label class="switch">
                        <input class="slider-etat" id="slider-etat" type="checkbox" <?php echo ($currentOffre['en_ligne'] == 1) ? "checked" : ""; ?>>
                        <span class="slider"></span>
                    </label>
                    <p class="status-text"><?php echo ($currentOffre['en_ligne'] == 1) ? 'En ligne' : 'Hors ligne'; ?></p>

                </div> -->
                <div class="grid-images">
                    <img src="<?= $currentOffre["chemin"] ?>" alt="<?= $currentOffre["titre_image"] ?>">
                    <?php
                    // On affiche les images de l'offre
                    for ($i = 0; $i < 4; $i++) {
                        if (isset($images[$i]) && !empty($images[$i])) {
                            $image_infos = explode('|', $images[$i]);
                            ?><img src="<?= $image_infos[1] ?>" alt="<?= $image_infos[0] ?>" class="image-secondaire"><?php
                        }
                    }?>
                </div>
                <input type="hidden" id="titre_image" name="titre_image" value="<?= $currentOffre["titre_image"] ?>">
                <input type="hidden" id="chemin_image" name="chemin_image" accept="image/*" style="display:none" value="<?= $currentOffre["chemin"] ?>">
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

                    <div class="champ-type-offre">
                        <h3>Jours d'ouvertures</h3>
                        <div id="jours-checkboxes" class="checkbox-container" >
                            <div>
                                <input type="checkbox" name="jours[]"  id="1" value="Lundi" <?=in_array("Lundi", $joursSemaines) ? 'checked' : '' ?>> 
                                <label class="label-input" for="1">Lundi</label>
                            </div>
                            <div>
                                <input type="checkbox" name="jours[]" id="2" value="Mardi" <?=in_array("Mardi", $joursSemaines) ? 'checked' : '' ?>> 
                                <label class="label-input" for="2">Mardi</label>
                            </div>
                            <div>
                                <input type="checkbox" name="jours[]" id="3" value="Mercredi" <?=in_array("Mercredi", $joursSemaines) ? 'checked' : '' ?>> 
                                <label class="label-input" for="3" >Mercredi</label>
                            </div>
                            <div>
                                <input type="checkbox" name="jours[]" id="4" value="Jeudi" <?=in_array("Jeudi", $joursSemaines) ? 'checked' : '' ?>> 
                                <label class="label-input" for="4">Jeudi</label>
                            </div>
                            <div>
                                <input type="checkbox" name="jours[]" id="5" value="Vendredi" <?=in_array("Vendredi", $joursSemaines) ? 'checked' : '' ?>> 
                                <label class="label-input" for="5">Vendredi</label>
                            </div>
                            <div>
                                <input type="checkbox" name="jours[]" id="6" value="Samedi" <?=in_array("Samedi", $joursSemaines) ? 'checked' : '' ?>> 
                                <label class="label-input" for="6">Samedi</label>
                            </div>
                            <div>
                                <input type="checkbox" name="jours[]" id="7" value="Dimanche" <?=in_array("Dimanche", $joursSemaines) ? 'checked' : '' ?>> 
                                <label class="label-input" for="7">Dimanche</label>
                            </div>
                        </div>
                    </div>
                    
                

                    <div class="horaires">
                        <div class="input-divers">
                            <label class="label-input" for="horaire-1">Horaire 1</label>
                            <input id="horaire-1" name="horaire-1" type="time" 
                            value="<?= date('H:i:s', $horaire1) ?>" required />

                        </div>
                        <div class="input-divers">
                            <label class="label-input" for="horaire-2">Horaire 2</label>
                            <input id="horaire-2" name="horaire-2" type="time" 
                            value="<?= date('H:i:s', $horaire2) ?>" required />
                        </div>
                    </div>
                    <?php if(isset($horaire3) && isset($horaire4)) { ?>
                        <div class="horaires">
                            <div class="input-divers">
                                <label class="label-input" for="horaire-3">Horaire 3</label>
                                <input id="horaire-3" name="horaire-3" type="time" 
                                value="<?= date('H:i:s', $horaire3) ?>" required />
                                
                            </div>
                            <div class="input-divers">
                                <label class="label-input" for="horaire-4">Horaire 4</label>
                                <input id="horaire-4" name="horaire-4" type="time" 
                                value="<?= date('H:i:s', $horaire4) ?>" required />
                            </div>
                        </div>
                    <?php } ?>


                    <?php if($type_activite == 'activite') {
                            require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/detailOffre/activite.php');
                        } else if($type_activite == 'visite_guidee') {
                            require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/detailOffre/visite.php');
                        } else if($type_activite == 'visite_non_guidee') {
                            require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/detailOffre/visite.php');
                        } else if($type_activite == 'parc_attraction') {
                            require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/detailOffre/parcAttraction.php');
                        } else if($type_activite == 'spectacle') {
                            require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/detailOffre/spectacle.php');
                        } else if ($type_activite == 'restauration') {
                            require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/detailOffre/restaurant.php');
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
                       <?php } 
                       ?>
                        <article class="tags">
                            <ul class="tag-list">
                                <?php
                                    //On affiche le nb de tag récuperé
                                    foreach (explode(",", $currentOffre["tags"]) as $tags):
                                ?>
                                <li>
                                    <div class="tag-container">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tag" viewBox="0 0 16 16">
                                            <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0"/>
                                            <path d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1m0 5.586 7 7L13.586 9l-7-7H2z"/>
                                        </svg>
                                        <h3> <?= $tags ?> </h3>
                                    </div>
                                </li>
                                <?php
                                    endforeach;
                                ?>
                            </ul>
                        </article>
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
    </div>
    <script src="/scripts/sauvegardeInfoOffre.js"></script>
    <script>
    // document.addEventListener("DOMContentLoaded", function() {
    //     const checkbox = document.querySelector('.slider-etat');
    //     const statusText = document.querySelector('.status-text');
    
    //     // Fonction pour mettre à jour le texte
    //     function updateStatus() {
    //         statusText.textContent = checkbox.checked ? "En ligne" : "Hors ligne";
    //     }
    
    //     // Met à jour au changement
    //     checkbox.addEventListener('change', updateStatus);
    
    //     // Initialise au cas où
    //     updateStatus();
        
    // });
    </script>
</body>

</html>