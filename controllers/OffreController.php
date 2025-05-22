<?php
require_once($_SERVER['DOCUMENT_ROOT'] .  '/../models/Offre.php');

class OffreController {
    private $offre;

    public function __construct() {
        $this->offre = new Offre();
    }

    // Récupérer toutes les offres d'activités
    public function getAllOffres() {
        return $this->offre->getAllOffre();
    }

    // Récupérer une offre activité par ID
    public function getOffreById($id) {
        return $this->offre->getOffreById($id);
    }

    //toString
    public function __toString() {
        return $this->offre->__toString();
    }
    // Récupérer toutes les offres d'activités par ID professionnel
    public function getOffreByIdProfessionnel($id_professionnel) {
        return $this->offre->getOffreByIdProfessionnel($id_professionnel);
    }


    public function allOffre() {
        return $this->offre->getAllOffre();
    }

    public function ajouterOffre($post, $files) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $titre = $_POST['titre'] ?? '';
            $lieu = $_POST['lieu'] ?? '';
            $duree = $_POST['duree'] ?? '';
            $age = $_POST['age'] ?? '';
            $prix = $_POST['prix'] ?? '';
            $description = $_POST['description'] ?? '';
            $accessibilite = $_POST['accessibilite'] ?? '';
            $a_la_une = isset($_POST['a_la_une']) ? 1 : 0;
            $en_relief = isset($_POST['en_relief']) ? 1 : 0;

            // Pour les champs multiples (Prestation incluse, non incluse, tags)
            // supposons que la fonction ajoutMultiple crée des inputs de type "name='prestation_incluse[]'"
            $prestation_incluse = $_POST['prestation_incluse'] ?? [];
            $prestation_non_incluse = $_POST['prestation_non_incluse'] ?? [];
            $tags = $_POST['tags'] ?? [];

            // Afficher les infos (à adapter pour un rendu ou retour JSON)
            echo "<h2>Données reçues :</h2>";
            echo "Titre : " . htmlspecialchars($titre) . "<br>";
            echo "Lieu : " . htmlspecialchars($lieu) . "<br>";
            echo "Durée : " . htmlspecialchars($duree) . "<br>";
            echo "Âge : " . htmlspecialchars($age) . "<br>";
            echo "Prix : " . htmlspecialchars($prix) . "<br>";
            echo "Description : " . htmlspecialchars($description) . "<br>";
            echo "Accessibilité : " . htmlspecialchars($accessibilite) . "<br>";
            echo "À la une : " . ($a_la_une ? "Oui" : "Non") . "<br>";
            echo "En relief : " . ($en_relief ? "Oui" : "Non") . "<br>";

            echo "<h3>Prestations incluses :</h3>";
            if (!empty($prestation_incluse)) {
                echo "<ul>";
                foreach ($prestation_incluse as $p) {
                    echo "<li>" . htmlspecialchars($p) . "</li>";
                }
                echo "</ul>";
            } else {
                echo "Aucune prestation incluse.<br>";
            }

            echo "<h3>Prestations non incluses :</h3>";
            if (!empty($prestation_non_incluse)) {
                echo "<ul>";
                foreach ($prestation_non_incluse as $p) {
                    echo "<li>" . htmlspecialchars($p) . "</li>";
                }
                echo "</ul>";
            } else {
                echo "Aucune prestation non incluse.<br>";
            }

            echo "<h3>Tags :</h3>";
            if (!empty($tags)) {
                echo "<ul>";
                foreach ($tags as $tag) {
                    echo "<li>" . htmlspecialchars($tag) . "</li>";
                }
                echo "</ul>";
            } else {
                echo "Aucun tag.<br>";
            }
        } else {
            echo "Aucune donnée reçue.";
        }
    }

    public function editOffre(
        $idOffre,
        $id_ville, 
        $id_statut_log, 
        $id_type_activite, 
        $titre_offre, 
        $note_moyenne, 
        $nb_avis, 
        $en_ligne, 
        $resume, 
        $description, 
        $adresse_offre
        
    ) {
        return $this->offre->editOffre(
            $idOffre,
            $id_ville, 
            $id_statut_log, 
            $id_type_activite, 
            $titre_offre, 
            $note_moyenne, 
            $nb_avis, 
            $en_ligne, 
            $resume, 
            $description, 
            $adresse_offre
        );
    }
}
