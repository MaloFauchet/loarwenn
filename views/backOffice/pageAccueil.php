<?php

// Inclusion des fichiers nécessaires : modèle Offre, configuration de la base de données et contrôleur Offre
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/Offre.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OffreController.php');

// Création d'une instance du contrôleur Offre et récupération des offres du professionnel avec l'ID 1
$offreController = new OffreController();
$offres = $offreController->getOffreByIdProfessionnel(1);

// Variables pour la note et le nombre de nouveaux avis (exemple statique)
$note = 3.5;
$nbNouveauxAvis = 5;
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

    <!-- Barre de recherche et de filtre -->
    <div class="search-filter-bar">
        <form>
            <input type="search" placeholder="Rechercher une offre" name="Rechercher" disabled>
            <div>
                <button type="submit">
                    <img src="/images/icons/search-white.svg" alt="Rechercher" style="margin-left:6px">
                </button>
            </div>
        </form>

        <button>
            <img src="/images/icons/funnel-fill-blue.svg" alt="Filtrer">
        </button>
    </div>

    <?php
    // Boucle sur chaque offre récupérée pour l'afficher
    foreach ($offres as $offre) {
    ?>
    <div class="offre" style="margin-bottom: 20px;">
        <div class="image-container">
            <!-- Pastille affichant le nombre de nouveaux avis -->
            <span class="pastille">
                <?php echo $nbNouveauxAvis ?>
            </span>

            <!-- Image de l'offre -->
            <img src="<?php echo $offre['image_chemin']; ?>" alt="<?php echo $offre['titre_image']; ?>">
        </div>
        <div class="offre-content">
            <!-- Titre de l'offre -->
            <h2><?php echo $offre['titre_offre']; ?></h2>
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
                    <a href="/backOffice/detailOffre?id_offre=<?php echo $offre['id_offre']; ?>">
                        <img src="/images/icons/pensil-square.svg" alt="bouton modifier">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
</main>