<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/Offre.php');

class OffreRestaurant extends Offre {
    private $prix;
    protected $pathImage;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();

        parent::__construct();
    }

    /**
     * @return offreSpectacle (array d'offreSpectacle)
     * Récupère toutes les offres de spectacle
     */
    public function getAllOffreRestaurant() {
        $sql = "
            SELECT * FROM tripenazor.offre_spectacle as spectacle
            JOIN tripenazor.offre as offre 
            ON spectacle.id_offre = offre.id_offre
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        $offresRestaurant = [];
        foreach ($result as $value) {
            $restaurant = new self();
            
            /**
             * Setters de la classe même
             */
            echo $value['pathImage'];
            $restaurant->setPrix($value['prix']);
            $restaurant->setPathImage($value['pathImage']);

            /**
             * Setters de la classe mère
             */
            $restaurant->setId($value['id']);
            $restaurant->setTitre($value['titre']);
            $restaurant->setResume($value['resume']);
            $restaurant->setDescription($value['description']);
            $restaurant->setDateCreation($value['dateCreation']);
            $restaurant->setAdresse($value['adresse']);
            $restaurant->setEnLigne($value['enLigne']);
            $restaurant->setType($value['type']);
            $restaurant->setNoteMoyenne($value['noteMoyenne']);
            $restaurant->setNbAvis($value['nbAvis']);

            $offresRestaurant[] = $restaurant;

            
        }
        return $offresRestaurant;
    }


    function updateActiviteOffre(
        $id_offre,

        $nom_ville,
        $code_postal,

        $titre_offre,
        $en_ligne,
        $resume,
        $description,
        $accessibility,
        $type_offre,
        $prix_TCC_min,
        $tags, 

        $voie,
        $numero_adresse,
        $complement_adresse,

        $titre_image,
        $chemin_image,

        $jours,
        $matin_heure_debut,
        $matin_heure_fin,
        $apres_midi_heure_debut,
        $apres_midi_heure_fin,

        $id_professionnel,
        $prix,

    ){
        
        $sql = "tripenazor.update_offre_activite(
            :id_offre,
            
            -- Paramètres de l'offre
            :nom_ville,
            :code_postal,

            :titre_offre,
            :en_ligne,
            :resume,
            :description,
            :accessibilite,
            :type_offre,
            :prix_TCC_min,
            :tags,

            -- Adresse
            :voie,
            :numero_adresse,
            :complement_adresse,

            -- Image
            :titre_image,
            :chemin_image,

            -- Jour de l'activité
            :jours,
            :matin_heure_debut,
            :matin_heure_fin,
            :apres_midi_heure_debut,
            :apres_midi_heure_fin,

            -- Professionnel
            :id_professionnel,
            :prix,

            -- Paramètres spécifiques à l'activité

            :prix_prive
        )";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':id_offre', $id_offre);

        $stmt->bindParam(':nom_ville', $nom_ville);
        $stmt->bindParam(':code_postal', $code_postal);

        $stmt->bindParam(':titre_offre', $titre_offre);
        $stmt->bindParam(':en_ligne', $en_ligne);
        $stmt->bindParam(':resume', $resume);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':accessibilite', $accessibility);
        $stmt->bindParam(':type_offre', $type_offre);
        $stmt->bindParam(':prix_TCC_min', $prix_TCC_min);
        $stmt->bindParam(':tags', $tags);


        $stmt->bindParam(':voie', $voie);
        $stmt->bindParam(':numero_adresse', $numero_adresse);
        $stmt->bindParam(':complement_adresse', $complement_adresse);

        $stmt->bindParam(':titre_image', $titre_image);
        $stmt->bindParam(':chemin_image', $chemin_image);

        $stmt->bindParam(':jours', $jours);
        $stmt->bindParam(':matin_heure_debut', $matin_heure_debut);
        $stmt->bindParam(':matin_heure_fin', $matin_heure_fin);
        $stmt->bindParam(':apres_midi_heure_debut', $apres_midi_heure_debut);
        $stmt->bindParam(':apres_midi_heure_fin', $apres_midi_heure_fin);

        $stmt->bindParam(':id_professionnel', $id_professionnel);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':prix_prive', $prix_prive);

        
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    /**
     * ToString
     * @return string
     */
    public function __toString() {
        return "Offre Restaurant : " . $this->getTitre() . ", Prix : ". ", Accessibilité : " . $this->accessibilite;
    }

    function updateRestaurantOffre(
        $id_offre,
        $titre_offre,
        $note_moyenne,
        $en_ligne,
        $resume,
        $description,
        $adresse_offre,
        $id_ville,
        $accessibility,
        $enRelief,
        $aLaUne,
        $prestationIncluse,
        $prestationNonIncluse,
        $tags, 
    ){
        /* Fonction igor */
        $sql = "UPDATE tripenazor.offre 
                SET(
                    id_ville = $id_ville,
                    titre_offre = $titre_offre,
                    note_moyenne = $note_moyenne,
                    en_ligne = $en_ligne,
                    resume = $resume,
                    description = $description,
                    adresse_offre = $adresse_offre
                ) WHERE id_offre = $id_offre";

        $stmt = $this->conn->prepare($sql);
        
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Setters
     */
    function setGammePrix($p) {
        $this->prix = $p;
    }

    function setPathImage($path) {
        $this->pathImage = $path;
    }

    /**
     * Getters
     */

    function getGammePrix() {
        return $this->prix;
    }

    function getPathImage() {
        return $this->pathImage;
    }
}