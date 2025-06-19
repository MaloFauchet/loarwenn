<?php
// On inclut le controller ProfessionnelController
require_once($_SERVER['DOCUMENT_ROOT'] .  '/../controllers/ProfessionnelController.php');

// On instancie le controller ProfessionnelController
$professionnelController = new ProfessionnelController();


// On inclut le controller OffreActivité
require_once($_SERVER['DOCUMENT_ROOT'] .  '/../controllers/OffreController.php');

// On instancie le controller
$offreController = new OffreController();


// On récupère l'ID de l'offre à afficher
$id = $_GET['id'] ?? null;
// Si l'ID n'est pas défini, on redirige vers la page d'accueil
if ($id === null) {
    header('Location: /index.php');
    exit;
}
// On vérifie que l'ID est un entier
if (!filter_var($id, FILTER_VALIDATE_INT)) {
    header('Location: /index.php');
    exit;
}
//On récupère l'offre d'activité par son ID
$id = intval($id);
$offre = $offreController->getOffreById($id);
// si l'offre est hors ligne, on redirige vers la page d'accueil
if ($offre === null || $offre['en_ligne'] == 0) {
    header('Location: /index.php');
    exit;
}
$pro = $professionnelController->getProfessionnelById($offre['id_professionnel'])[0];

// On récupère les informations du professionnel lié à l'offre
// $info_pro = $offreController->getProfessionnelInformationsByIdOffre($offre['id_offre']);
// On récupère l'id du professionnel
// $id_pro = $info_pro['id_utilisateur'];
// // Si l'id du professionnel est null, on essaie de récupérer l'id du professionnel privé
// if ($id_pro === null) {
//     $id_pro = $info_pro['id_utilisateur_prive'];
// }
// // Si c'est un professionnel public, on essaie de récupérer l'id du professionnel public
// if ($id_pro === null) {
//     $id_pro = $info_pro['id_utilisateur_public'];
// }

// On récupère les informations du professionnel par son id
// $pro = $professionnelController->getProfessionnelById($id_pro);
echo "<pre>";
print_r($offre);
// print_r($pro);
echo "</pre>";

$images_str = $offre["images"];
// On transforme la chaîne d'images en tableau
$images = explode(',', $images_str);

 /**
  * Affichage des étoiles en fonction de la note
  *La note est une etoile remplie si elle est supérieure ou égale à 0.8
*/ 
function afficherEtoile($note){
   
    $etoiles = '';
    for ($i = 0; $i < 5; $i++) {
        if ($note >= $i + 0.8) {
            $etoiles .= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                        </svg>';
        } elseif ($note > $i && $note < $i + 1) {
            $etoiles .= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-half" viewBox="0 0 16 16">
                            <path d="M5.354 5.119 7.538.792A.52.52 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.54.54 0 0 1 16 6.32a.55.55 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.5.5 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.6.6 0 0 1 .085-.302.51.51 0 0 1 .37-.245zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.56.56 0 0 1 .162-.505l2.907-2.77-4.052-.576a.53.53 0 0 1-.393-.288L8.001 2.223 8 2.226z"/>
                        </svg>';
        } else {
            $etoiles .= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                            <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                        </svg>';
        }
    }
    return $etoiles;
}
?>

<!-- Main-->
<main>
    <div class="breadcrumb-container">
        <a aria-label="Retour" href="#" class="breadcrumb-back-link" onclick="history.back(); return false;">
            <img src="/images/icons/chevron-left.svg" alt="Retour" class="breadcrumb-back">
        </a>
        <nav class="breadcrumb">
            <ul>
                <li>
                    <a aria-label="Accueil" href="/">Accueil</a>
                </li>
                <li>Offre détaillée</li>
            </ul>
        </nav>
    </div>
    <section>

        <!-- Image et titre de l'offre -->
        <article>
            <figure class="offre">
                <div class="grid-images">
                    <img src="<?= $offre["chemin"] ?>" alt="<?= $offre["titre_image"] ?>">
                    <?php
                    // On affiche les images de l'offre
                    for ($i = 0; $i < 4; $i++) {
                        if (isset($images[$i]) && !empty($images[$i])) {
                            $image_infos = explode('|', $images[$i]);
                            ?><img src="<?= $image_infos[1] ?>" alt="<?= $image_infos[0] ?>" class="image-secondaire"><?php
                        }
                    }?>
                </div>
                <figcaption>
                    <h2> <?= $offre["titre_offre"] ?></h2>
                    <p> <?= $offre["resume"] ?></p>
                <figcaption>
            </figure>
        </article>
        
        <article>
            <!-- Profi Du Pro -->
            <figure class="pp-pro-container">
                <hr>
                <div class="pp-pro">
                    <!--PP a recup dans la bdd -->
                    <img src="<?= $pro["chemin"] ?>" alt="Photo de profil pro" id="pp-pro">
                    <figcaption>
                        <h4><?=$pro[($pro["denomination"] !== null) ? "denomination" : "raison_sociale"]?></h4>
                        <p><?= $pro["prenom"]; ?> <?=$pro["nom"]; ?></p>
                        <a aria-label="Téléphone" href="tel:<?= $pro["num_telephone"] ?>"><?= $pro["num_telephone"] ?></a>
                    </figcaption>
                </div>
                <hr>
            </figure>

            <!-- Note de l'offre -->
            <div class="note">
                <h2> <?= $offre["note_avis"] ?></h2>
                <div class="star-container">
                    <?php $etoiles = afficherEtoile($offre["note_avis"]); ?>
                    <?= $etoiles ?>
                </div>
                <p>sur <?= $offre["nb_avis"] ?> avis </p>
            </div>
        </article>
        

        <!-- Informations sur l'offre -->
        <article class="description">
            <div>
                <h3>Description</h3>
                <p> <?= $offre["description"] ?></p>
            </div>
            <div>
                <h3>Type d'offre</h3>
                <p> <?= str_replace("_", " ", ucfirst($offre["type_offre"])) ?></p>
            </div>
        </article>
        <hr>

        <div class="infos">
            <!-- Informations Pratique -->  
            <article class="info">
                <!-- Informations communes à toutes les offres -->
                <h3>Informations pratiques</h3>
                <ul>
                    <li>
                        <!-- Tableau des jours d'ouverture -->
                        <figure class="info-pratique">
                            <?php $jours_ouverture = explode(',', $offre["jours_ouverture"]);
                            $jours = ["Lundi","Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"] ?>
                            <!-- <img src="/images/icons/door-open.svg" alt="Jours d'ouverture"> -->
                            <figcaption>
                                <table>
                                    <thead>
                                        <tr>
                                            <?php foreach ($jours as $jour): ?>
                                                <th><?= $jour ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php foreach ($jours as $jour): ?>
                                                <td>
                                                    <?php 
                                                        // On vérifie si le jour est dans les jours d'ouverture
                                                        if (in_array($jour, $jours_ouverture)) {
                                                            echo "Ouvert";
                                                        } else {
                                                            echo "Fermé";
                                                        }
                                                    ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </figcaption>
                        </figure>
                    </li>
                    <li>
                        <!-- Horaire d'ouverture -->
                        <?php $horaires = explode(",", $offre["horaires"]) ?>
                        <figure class="info-pratique">
                            <img src="/images/icons/clock.svg" alt="Horaires d'ouverture">
                            <figcaption>
                                <?php if (count($horaires) > 1): ?>
                                    <?php $horaire1 = explode(" | ", $horaires[0]); ?>
                                    <?php $horaire2 = explode(" | ", $horaires[1]); ?>
                                    <h3>De <?= $horaire1[0] ?> à <?= $horaire1[1] ?> et de <?= $horaire2[0] ?> à <?= $horaire2[1] ?></h3>
                                <?php else: ?>
                                    <?php $horaire = explode(" | ", $horaires[0]); ?>
                                    <h3>De <?= $horaire[0] ?> à <?= $horaire[1] ?></h3>
                                <?php endif; ?>
                            </figcaption>
                        </figure>
                    </li>
                    <li>
                        <!-- Adresse -->
                        <figure class="info-pratique">
                            <img src="/images/icons/geo-alt-fill.svg" alt="Localisation">
                            <figcaption>
                                <h3><?= $offre["numero_adresse"] . " " . $offre["voie"]?><?= ($offre["complement_adresse"]) ? ", " . $offre["complement_adresse"] : ""?>, <?= $offre["code_postal"] . " " . $offre["nom_ville"]?></h3>
                            </figcaption>
                        </figure>
                    </li>
                    <li>
                        <!-- Accessibilité -->
                        <figure class="info-pratique">
                            <img src="/images/icons/person-wheelchair.svg" alt="Accessibilite">
                            <figcaption>
                                <h3> <?= $offre["accessibilite"] ?> </h3>
                            </figcaption>
                        </figure>
                    </li>
                    <?php
                        //En fonction du type d'offre, on affiche les différentes informations
                        switch ($offre["type_offre"]) :
                        case 'visite_guidee': 
                    ?>
                    <!-- VISITE GUIDEE -->
                    <li>
                        <!-- Durée du spectacle -->
                        <?php $duree = explode(":", $offre["visite_duree"]); ?>

                        <figure class="info-pratique">
                            <img src="/images/icons/stopwatch.svg" alt="Horaires">
                            <figcaption>
                                <h3>Durée : <?= $duree[0] ?>H<?= $duree[1] ?></h3>
                            </figcaption>
                        </figure>
                    </li>
                </ul>
            </article>
            <!-- Langues -->  
            <article class="info secondaire langues">
                <!-- Langues -->
                <h3>Langues</h3>
                <ul>
                    <?php 
                        // On affiche les langues incluses dans l'offre
                        $langues = explode(',', $offre["langue"]);
                        foreach ($langues as $langue):?>
                    <li>
                        <figure class="info-pratique">
                            <img src="/images/icons/check.svg" alt="Langues de la visite guidée">
                            <figcaption>
                                <h3><?= $langue ?></h3>
                            </figcaption>
                        </figure>
                    </li>
                    <?php endforeach; ?>
                </ul>
                    <?php
                        break;
                        case 'visite_non_guidee': 
                    ?>
                    <!-- VISITE NON GUIDEE -->
                    <li>
                        <!-- Durée du spectacle -->
                        <?php $duree = explode(":", $offre["visite_duree"]); ?>

                        <figure class="info-pratique">
                            <img src="/images/icons/stopwatch.svg" alt="Horaires">
                            <figcaption>
                                <h3>Durée : <?= $duree[0] ?>H<?= $duree[1] ?></h3>
                            </figcaption>
                        </figure>
                    </li>
                    <?php
                        break;
                        case 'spectacle':
                    ?>
                    <!-- SPECTACLE -->
                    <li>
                        <!-- Durée du spectacle -->
                        <?php $duree = explode(":", $offre["spectacle_duree"]); ?>

                        <figure class="info-pratique">
                            <img src="/images/icons/stopwatch.svg" alt="Horaires">
                            <figcaption>
                                <h3>Durée : <?= $duree[0] ?>H<?= $duree[1] ?></h3>
                            </figcaption>
                        </figure>
                    </li>
                    <li>
                        <!-- Accessibilité -->
                        <figure class="info-pratique">
                            <img src="/images/icons/person-wheelchair.svg" alt="Accessibilite">
                            <figcaption>
                                <h3><?= $offre["accessibilite"] ?> </h3>
                            </figcaption>
                        </figure>
                    </li>
                    <li>
                        <!-- Capacité du spectacle -->
                        <figure class="info-pratique">
                            <img src="/images/icons/person-circle.svg" alt="Capacite">
                            <figcaption>
                                <h3>Capacité de <?= $offre["spectacle_capacite"] ?> personnes</h3>
                            </figcaption>
                        </figure>
                    </li>
                    <li>
                        <!-- Prix du spectacle -->
                        <figure class="info-pratique">
                            <img src="/images/icons/cash.svg" alt="Age">
                            <figcaption>
                                <?php if ($offre["prix_ttc_min"] == 0): ?>
                                    <h3>Gratuit</h3>
                                <?php else: ?>
                                    <h3><?= $offre["prix_ttc_min"] ?>€</h3>
                                <?php endif; ?>
                            </figcaption>
                        </figure>
                    </li>
                    <?php
                        break;
                        case 'parc_attraction':
                    ?>
                    <!-- PARC D'ATTRACTION -->
                    <li>
                        <!-- Nombre d'attractions -->
                        <figure class="info-pratique">
                            <img src="/images/icons/hypnotize.svg" alt="NBAttraction">
                            <figcaption>
                                <h3> <?= $offre["pa_nb_attraction"] ?> attractions différentes </h3>
                            </figcaption>
                        </figure>
                    </li>
                    <li>
                        <!-- Age minimum -->
                        <figure class="info-pratique">
                            <img src="/images/icons/person-circle.svg" alt="Age">
                            <figcaption>
                                <h3> <?= $offre["pa_age_min"] ?> ans minimum </h3>
                            </figcaption>
                        </figure>
                    </li>
                </ul>
            </article>    
            <!-- PLAN DU PARC -->  
            <article class="info secondaire">
                <h3>Carte</h3>
                <img src="<?= $offre["pa_plan_image"] ?>" alt="Plan du parc d'attraction" class="carte-offre">
                <ul style="display: none;">
                    <?php
                        break;
                        case 'activite':
                    ?>
                    <!-- ACTIVITE -->
                    <li>
                        <!-- Durée de l'activité -->
                        <?php $duree = explode(":", $offre["activite_duree"]); ?>

                        <figure class="info-pratique">
                            <img src="/images/icons/stopwatch.svg" alt="Horaires">
                            <figcaption>
                                <h3>Durée : <?= $duree[0] ?>H<?= $duree[1] ?></h3>
                            </figcaption>
                        </figure>
                    </li>
                    <li>
                        <!-- Age minimum -->
                        <figure class="info-pratique">
                            <img src="/images/icons/person-circle.svg" alt="Age">
                            <figcaption>
                                <h3><?= $offre["activite_age"] ?> ans minimum</h3>
                            </figcaption>
                        </figure>
                    </li>
                </ul>
            </article>
            <!-- PRESTATIONS DE L'ACTIVITE -->  
            <article class="info secondaire">
                <!-- Prestations incluses -->
                <h3>Prestation Incluse</h3>
                <ul>
                    <?php 
                        // On affiche les prestations incluses dans l'offre
                        $prestations = explode(',', $offre["prestation_incluses"]);
                        foreach ($prestations as $prestation):?>
                    <li>
                        <figure class="info-pratique">
                            <img src="/images/icons/check.svg" alt="Prestation incluse">
                            <figcaption>
                                <h3><?= $prestation ?></h3>
                            </figcaption>
                        </figure>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <!-- Prestation non incluses -->
                <h3>Pestation Non Incluses</h3>
                <ul>
                    <?php
                        // On affiche les prestations non incluses dans l'offre
                        $prestations_non_incluses = explode(',', $offre["prestation_non_incluses"]);
                        foreach ($prestations_non_incluses as $prestation_non_incluse):?>
                    <li>
                        <figure class="info-pratique">
                            <img src="/images/icons/x.svg" alt="Prestation non incluse">
                            <figcaption>
                                <h3><?= $prestation_non_incluse ?></h3>
                            </figcaption>
                        </figure>
                    </li>
                    <?php endforeach; ?>
                    <?php
                        break;
                        case 'restauration':
                    ?>
                    <!-- RESTAURATION -->
                    <li>
                        <!-- Gamme de prix -->
                        <figure class="info-pratique">
                            <img src="/images/icons/cash.svg" alt="Gamme de prix">
                            <figcaption>
                                <h3>Gamme de prix : <?= $offre["restaurant_gamme_prix"] ?></h3>
                            </figcaption>
                        </figure>
                    </li>
                    <li>
                        <!-- Repas -->
                        <figure class="info-pratique">
                            <img src="/images/icons/fork-knife.svg" alt="Repas">
                            <figcaption>
                                <h3> <?= $offre["repas"] ?> </h3>
                            </figcaption>
                        </figure>
                    </li>
                </ul>
            </article>    
            <!-- MENU DU RESTAURANT -->  
            <article class="info secondaire">
                <h3>Carte</h3>
                <img src="<?= $offre["restaurant_carte_image"] ?>" alt="Carte de l'offre" class="carte-offre">
                <ul style="display: none;">
                    <?php
                        break;
                    endswitch;
                    ?>
                </ul>
            </article>
        </div>
        
        <article class="tags">
            <ul class="tag-list">
                <?php
                    //On affiche le nb de tag récuperé
                    foreach (explode(",", $offre["tags"]) as $tags):
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
    </section>
</main>