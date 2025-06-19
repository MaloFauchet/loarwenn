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
        <p>En ligne</p>
    </div>
</div>

<div class="number">
    <img src="/images/icons/clock.svg" alt="Horloge">
    <div class="input-divers">
        <label class="label-input" for="nb-attraction">Nombre d'attraction</label>
        <input id="nb-attraction" name="nb-attraction" type="number"  
        value="<?php echo $currentOffre["nb_attraction"] ?>" min="0" required />
    </div>
    <div class="input-titre">
        <label class="label-input" for="titre">Titre</label>
        <input id="titre" type="text" 
        value="<?php echo $currentOffre->getTitre() ?>" required />
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

if (!isset($_POST["type"])) {
    $_POST["type"] = $type_activite;
}
?>

<div class="age-min">
                <img src="/images/icons/cake-fill.svg" alt="age">
                <div class="input-divers">
                    <label class="label-input" for="age-min">Age min</label>
                    <input id="age-min" name="age-min" type="number"  
                    value="<?php echo $currentOffre["pa_age_min"] ?>" min="0" required />
                </div>
            </div>

            <div class="number">
                <img src="/images/icons/clock.svg" alt="Horloge">
                <div class="input-divers">
                    <label class="label-input" for="nb-attraction">Nombre d'attraction</label>
                    <input id="nb-attraction" name="nb-attraction" type="number"  
                    value="<?php echo $currentOffre["nb_attraction"] ?>" min="0" required />
                </div>
            </div>
