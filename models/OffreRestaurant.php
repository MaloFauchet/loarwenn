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

    private function convertArrayToPgArray( $array) {
        
        if (!is_array($array) || empty($array)) {
            return '{}';
        }
        return '{' . implode(',', array_map(function ($val) {
            return '"' . addslashes($val) . '"';
        }, $array)) . '}';
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
            //$restaurant->setPrix($value['prix']);
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


    function updateRestaurantOffre(
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
        
        $id_professionnel,

        $titre_image_carte,
        $chemin_image_carte,
        $libelle_gamme_prix,

        $apres_midi_heure_debut,
        $apres_midi_heure_fin,
        $prix,

    ){
        
        $sql = "select tripenazor.update_offre_restaurant(
            :p_id_offre ,
            
            -- Paramètres de l'offre
            :p_nom_ville ,
            :p_code_postal ,

            :p_titre_offre ,
            :p_en_ligne ,
            :p_resume ,
            :p_description ,
            :p_accessibilite ,
            
            :p_type_offre ,
            :p_prix_TTC_min ,
            :p_tags ,

            -- Adresse
            :p_voie ,
            :p_numero_adresse ,
            :p_complement_adresse ,
            
            -- Image
            :p_titre_image ,
            :p_chemin_image ,

            -- Jour de l'activité
            :p_jours ,
            :p_matin_heure_debut ,
            :p_matin_heure_fin ,

            -- Professionnel
            :p_id_professionnel ,

            -- Paramètres spécifiques à l'activité
            :p_titre_image_carte ,
            :p_chemin_image_carte ,
            :p_libelle_gamme_prix ,

            :p_apres_midi_heure_debut ,
            :p_apres_midi_heure_fin ,
            :p_prix_prive 
        )";



        $stmt = $this->conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':p_id_offre', $id_offre);

        $stmt->bindParam(':p_nom_ville', $nom_ville);
        $stmt->bindParam(':p_code_postal', $code_postal);

        $stmt->bindParam(':p_titre_offre', $titre_offre);
        $stmt->bindParam(':p_en_ligne', $en_ligne);
        $stmt->bindParam(':p_resume', $resume);
        $stmt->bindParam(':p_description', $description);
        $stmt->bindParam(':p_accessibilite', $accessibility);
        $stmt->bindParam(':p_type_offre', $type_offre);
        $stmt->bindParam(':p_prix_TTC_min', $prix_TCC_min);
        $stmt->bindValue(':p_tags', $this->convertArrayToPgArray($tags));

        $stmt->bindParam(':p_voie', $voie);
        $stmt->bindParam(':p_numero_adresse', $numero_adresse);
        $stmt->bindParam(':p_complement_adresse', $complement_adresse);

        $stmt->bindParam(':p_titre_image', $titre_image);
        $stmt->bindParam(':p_chemin_image', $chemin_image);

        $stmt->bindParam(':p_titre_image_carte', $titre_image_carte);
        $stmt->bindParam(':p_chemin_image_carte', $chemin_image_carte);
        $stmt->bindParam(':p_libelle_gamme_prix', $libelle_gamme_prix);

        $stmt->bindValue(':p_jours', $this->convertArrayToPgArray($jours));
        $stmt->bindParam(':p_matin_heure_debut', $matin_heure_debut);
        $stmt->bindParam(':p_matin_heure_fin', $matin_heure_fin);

        $stmt->bindParam(':p_id_professionnel', $id_professionnel);
        
        $stmt->bindValue(':p_apres_midi_heure_debut', $apres_midi_heure_debut, $apres_midi_heure_debut === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':p_apres_midi_heure_fin', $apres_midi_heure_fin, $apres_midi_heure_fin === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindParam(':p_prix_prive', $prix);

        
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    /**
     * ToString
     * @return string
     
    public function __toString() {
        return "Offre Restaurant : " . $this->getTitre() . ", Prix : ". ", Accessibilité : " . $this->accessibilite;
    }*/

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