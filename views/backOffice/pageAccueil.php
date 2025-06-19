<?php
function dump($data) {
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}

// Inclusion des fichiers nécessaires : modèle Offre, configuration de la base de données et contrôleur Offre
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/Offre.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OffreController.php');

// Création d'une instance du contrôleur Offre et récupération des offres du professionnel avec l'ID 1
$offreController = new OffreController();
$userId = $_SESSION['id_utilisateur'];

$offres = $offreController->getOffreByIdProfessionnel($userId);

// Variables pour la note et le nombre de nouveaux avis (exemple statique)
$note = 0;
$nbNouveauxAvis = 5;
$nbAvis = 0
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
    <div class="offre" style="margin-bottom: 20px;">
        <div class="image-container">
            <!-- Pastille affichant le nombre de nouveaux avis -->
            <span class="pastille" style="display: none">
                <?php echo $nbNouveauxAvis ?>
            </span>

            <!-- Image de l'offre -->
            <img src="<?php echo $offre['chemin']; ?>" alt="<?php echo $offre['titre_image']; ?>">
 
        </div>
        <div class="offre-content">
            <!-- Titre de l'offre -->
            <h2><?php echo $offre['titre_offre']; ?></h2>
            <div class="avis-offre">
                <!-- Note moyenne -->
                <p><?php 
                if ($offre['note_avis'] == null) {
                    echo 0;
                }else{
                    $offre['note_avis'];
                }
                  
                
                ?></p>
                <div class="etoiles">
                    <?php
                        // Affichage des étoiles selon la note moyenne
                    if ($offre['note_avis'] == null) {
                 
                    echo afficherEtoile(0);
                    }else{
                        echo afficherEtoile($offre['note_avis']);
                    }
                    
                    ?>
                </div>
                <!-- Nombre d'avis -->
                <p>(<?php echo $offre['nb_avis'] ?> avis)</p>
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
</main>