<?php

// Inclusion des fichiers nécessaires : modèle Offre, configuration de la base de données et contrôleur Offre
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/Offre.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OffreController.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OptionController.php');

// Création d'une instance du contrôleur Offre et récupération des offres du professionnel 
$offreController = new OffreController();
$userId = $_SESSION['id_utilisateur'];

$offres = $offreController->getOffreByIdProfessionnel($userId);

// Récuperation des options
$optionsController = new OptionController();
$options = $optionsController->getOption();

// Variables pour la note et le nombre de nouveaux avis (exemple statique)
$note = 3.5;
$nbNouveauxAvis = 5;

echo '<pre>';
print_r($offres);
echo '</pre>';
?>

<script>
    // Script pour afficher "Nouveaux avis" lors du survol de la pastille
    document.addEventListener('DOMContentLoaded', function() {
        var pastilles = document.querySelectorAll('.pastille');
        pastilles.forEach(function(pastille) {
            var textBase = pastille.textContent;

            pastille.parentElement.addEventListener('mouseenter', function() {
                pastille.textContent = textBase + ' Nouveaux avis';
            });

            pastille.parentElement.addEventListener('mouseleave', function() {
                pastille.textContent = textBase;
            });
        });
    });
</script>

<?php
// Inclusion du composant pour afficher les étoiles de notation
require_once($_SERVER['DOCUMENT_ROOT'] .'/../views/componentsGlobaux/afficherEtoile.php');
?>

<main class="contenu-back-office">
    <?php
    // Boucle sur chaque offre récupérée pour l'afficher
    foreach ($offres as $offre) {
    ?>
    <div class="offre" style="margin-bottom: 20px;" data-id="<?= $offre['id_offre']; ?>">
        <div class="image-container">
            <!-- Pastille affichant le nombre de nouveaux avis -->
            <span class="pastille" style="display: none">
                <?php echo $nbNouveauxAvis ?>
            </span>

            <!-- Image de l'offre -->
 
            <img src="<?php echo $offre['image_chemin']; ?>" alt="<?php echo $offre['titre_image']; ?>">
        </div>
        <div class="offre-content">
            <!-- Titre de l'offre -->
            <div>
                <h2><?php echo $offre['titre_offre']; ?></h2>
                <div class="status-offre">
                    <label class="switch">
                    <?php if ($offre['en_ligne'] == 1) : ?>
                            <input class="slider-etat" type="checkbox" checked data-id="<?=$offre['id_offre'];?>">
                            <span class="slider"></span>
                        </label>
                        <p class="status-text">En ligne</p>
                    <?php else : ?>
                        <input class="slider-etat" type="checkbox" data-id="<?=$offre['id_offre'];?>">
                            <span class="slider"></span>
                        </label>
                        <p class="status-text">Hors ligne</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="avis-offre">
                <!-- Note moyenne -->
                <p><?php echo $offre['note_moyenne'] ?></p>
                <div class="etoiles">
                    <?php
                    // Affichage des étoiles selon la note moyenne
                    echo afficherEtoile($offre['note_moyenne']);
                    ?>
                </div>
                <!-- Nombre d'avis -->
                <p>(<?php echo $offre['nb_avis']; ?> avis)</p>
            </div>
            <!-- Résumé de l'offre -->
            <p><?php echo $offre['resume']; ?></p>
            <div class="bas-offre">
                <div>
                    <!-- Statut en ligne/hors ligne -->
                    <img src="/images/icons/<?php echo ($offre['en_ligne'] == 1) ? 'wifi-on' : 'wifi-off'; ?>.svg"
                        alt="Statut en ligne">
                    <p><?php echo ($offre['en_ligne'] == 1) ? 'En ligne' : 'Hors ligne'; ?></p>
                </div>
                <div>
                    <!-- Lien pour modifier l'offre -->
                    <a href="/backOffice/detailOffre?id_offre=<?php echo $offre['id_offre']; ?>" aria-label="Modification">
                        <img src="/images/icons/pensil-square.svg" alt="bouton modifier">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>

    <div class="modal-publication" id="modal-publication">
        <div class="modal-content">
            <h3>Vous allez mettre en ligne une offre</h3>
            <form id="onlineForm">
                <input type="hidden" name="id_offre" value="<?= $offre['id_offre']; ?>">
                <div class="checkbox-container">
                    <label for="enRelief"><?=$options[0]['libelle_option'] ?> : <?=$options[0]['prix_s_ttc_option'] ?>€</label>
                    <input type="checkbox" name="enRelief" id="enReliefInput">
                </div>
            
                <div class="checkbox-container">
                    <label for="enLigne"><?=$options[1]['libelle_option'] ?> : <?=$options[1]['prix_s_ttc_option'] ?>€</label>
                    <input type="checkbox" name="aLaUne" id="enLigneInput">
                </div>
                
                <div style="display: none;">
                    <label for="nbSemaines">Nombre de semaines de mise en ligne</label>
                    <input type="number" name="nbSemaines" id="nbSemainesInput" min="1" max="52" value="1">
                </div>
                
                <div>
                    <button type="submit">Publier</button>
                    <button type="reset">Fermer</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-depublication" id="modal-depublication">
        <div class="modal-content">
            <h3>Vous allez mettre hors ligne une offre</h3>
            <form id="outlineForm" method="post">
                <input type="hidden" name="id_offre" value="<?= $offre['id_offre']; ?>">
                <div>
                    <button type="submit">Valider</button>
                    <button type="reset">Fermer</button>
                </div>
            </form>
        </div>
    </div>
</main>