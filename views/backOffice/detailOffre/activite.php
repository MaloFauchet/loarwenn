<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/../controllers/TagController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../controllers/OffreController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../controllers/TypeActiviteController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../controllers/PrestationController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../controllers/UtilisateurController.php';

// Récupération de l'id de l'offre depuis l'URL
$id_offre = $_GET['id_offre'];

// Création des instances des contrôleurs
$offreController = new OffreController();
$tagController = new TagController();
$typeActiviteController = new TypeActiviteController();
$prestationController = new PrestationController();
$utilisateurController = new UtilisateurController();

// Récupération des informations de l'utilisateur
$infoPro = $utilisateurController->getInfoUtilisateur($_SESSION['id_utilisateur']);

$currentOffre = $offreController->getOffreById($id_offre);

// Récupération du type, des tags et de l'id du type d'activité
$type_activite = $currentOffre->getType();
$id_tags = $typeActiviteController->getTagIdByTypeActivite($type_activite);

// Array_column permet de mettre tous les tags dans un tableau simple sans 2 profondeur.
$arrayIdTags = array_column($id_tags, 'id_tag');
$tags = $tagController->getAllTagByIdTagActivite($arrayIdTags);
$tags = array_column($tags, 'libelle_tag');

// Prestation incluse ou non
$prestationIncluse = $prestationController->getAllPrestationIncluse($id_offre);
$arrayPrestationIncluse = array_column($prestationIncluse, 'libelle_prestation');

$prestationNonIncluse = $prestationController->getAllPrestationNonIncluse($id_offre);
$arrayPrestationNonIncluse = array_column($prestationNonIncluse, 'libelle_prestation');
?>

<main class="contenu-back-office">
    <div class="status-offre">
        <label class="switch">
            <input aria-label="Statut de l'offre" class="slider-etat" type="checkbox" checked>
            <span class="slider"></span>
        </label>
        <p class="status-text">En ligne</p>
    </div>
</div>
<div class="age-min">
    <img src="/images/icons/cake-fill.svg" alt="Horloge">
    <div class="input-divers">
        <label class="label-input" for="age">Age minimum</label>
        <input id="age-min" name="age-min" type="number"  
        value="<?php echo $currentOffre["activite_age"] ?>" min="0" required />
    </div>
    <div class="input-titre">
        <label class="label-input" for="titre">Titre</label>
        <input id="titre" type="text" value="<?php echo $currentOffre->getTitre() ?>" required />
    </div>

    <article>
        <hr class="black-separator"> 
        <div class="profil-note">
            <figure class="pp-pro">
                
                <!--PP a recup dans la bdd -->
                <img src="/images/profils/1.jpg" alt="Photo de profil pro" id="pp-pro">
                <figcaption>
                    <h4>Association : Armor Naviguation
                        <!--Denomination a recup dans la bdd-->
                    </h4>
                    <?php
                // Si pro est SUPER ASSO | ORGANISATION
                echo '<p>Super Association</p>';
            ?>
                </figcaption>
            </figure>

            <div class="note" style="display:none;">
                <h2>3.7
                    <!--Note a recup dans la bdd-->
                </h2>
                <div class="star-container">
                    <!-- On affiche le nombre d'étoiles en fonction des notes-->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-star-fill" viewBox="0 0 16 16">
                        <path
                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-star-fill" viewBox="0 0 16 16">
                        <path
                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-star-fill" viewBox="0 0 16 16">
                        <path
                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-star-fill" viewBox="0 0 16 16">
                        <path
                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-star-fill" viewBox="0 0 16 16">
                        <path
                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                </div>
                <p>sur 300 avis
                    <!--Nombre d'avis a recup dans la bdd-->
                </p>
            </div>
        </div>
        <hr class="black-separator">
        <div class="info-divers">
            <div class="telephone">
                <img src="/images/icons/telephone.svg" alt="Téléphone">
                <div class="input-divers">
                    <label class="label-input" for="telephone">Téléphone</label>
                    <input id="telephone" name="telephone" type="tel" 
                    value="<?php echo $infoPro['num_telephone'] ?>" required />
                </div>
            </div>
            <div class="duree">

if (!isset($_POST["type"])) {
    $_POST["type"] = $type_activite;
}
?>

<div class="duree">
                <img src="/images/icons/clock.svg" alt="Horloge">
                <div class="input-divers">
                    <label class="label-input" for="duree">Durée (h)</label>
                    <input id="duree" name="duree" type="time" 
                    value="<?php echo $currentOffre["activite_duree"] ?>" required />
                </div>
            </div>
            <div class="age-min">
                <img src="/images/icons/cake-fill.svg" alt="Horloge">
                <div class="input-divers">
                    <label class="label-input" for="age">Age minimum</label>
                    <input id="age-min" name="age-min" type="number"  
                    value="<?php echo $currentOffre["activite_age"] ?>" min="0" required />
                </div>
            </div>
        </div>

        <div class="lieux">
            <img src="/images/icons/geo-alt.svg" alt="Point GPS">
            <div class="input-lieux">
                <label class="label-input" for="lieu">Lieu</label>
                <input id="lieu" name="lieu" type="text" 
                value="<?php echo $currentOffre->getAdresse() ?>" required />
            </div>
        </div>

        <div class="lieux">
            <img src="/images/icons/geo-alt.svg" alt="Point GPS">
            <div class="input-lieux">
                <label class="label-input" for="ville">Ville</label>
                <input id="ville" name="ville" type="text" 
                value="<?php echo $currentOffre->getVille() ?>" required />
            </div>
        </div>

        <div class="choix-options">
            <h3>Voulez-vous prendre un option ?</h3>

            <div class="checkbox-cont">
                <div>
                    <p>À la une : </p>
                    <div class=".checkbox-option">
                        <input id="a-la-une" name="a-la-une" type="checkbox" />
                        <label class="label-input" for="a-la-une">(+20€/mois)</label>
                    </div>
                </div>
                <div>
                    <p>En relief :</p>
                    <div class=".checkbox-option">
                        <input id="relief" name="relief" type="checkbox" />
                        <label class="label-input" for="relief">(+10€/mois)</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="resume">
            <div class="input-divers">
                <label class="label-input" for="resume">Résumé</label>
                <textarea id="resume" name="resume" rows="4" cols="50"><?php echo $currentOffre->getResume() ?>
                </textarea>
            </div>
        </div>

        <div class="description">
            <div class="input-divers">
                <label class="label-input" for="description">Description</label>
                <textarea id="description" name="description" rows="4" cols="50"><?php echo $currentOffre->getDescription() ?>
                </textarea>
            </div>
        </div>

        <div class="accessibilite">
            <div class="input-divers">
                <label class="label-input" for="accessibilite">accessibilite</label>
                <textarea id="accessibilite" name="accessibilite" rows="4" cols="50"><?php echo $currentOffre->getAccessibilite() ?>
                </textarea>
            </div>
        </div>

        <div class="choix-divers">
            <div class="choix-prestation">
                <?php ajoutMultiple('Prestation incluse', '', 1, $arrayPrestationIncluse); ?>
                <?php ajoutMultiple('Prestation non incluse', '', 2, $arrayPrestationNonIncluse); ?>
            </div>
            <?php ajoutMultiple('Tags', '', 3, $tags); ?>
        </div>
    </article>
    <div id="sauvegarder">
        <p>Voulez-vous appliquer les modifications ?</p>
        <div>
            <button aria-label="Annuler" type="button" id="annuler-btn">Annuler</button>
            <button aria-label="Appliquer" type="button" id="sauvegarder-btn">Appliquer</button>
        </div>
    </div>
          </main>
            </div>
