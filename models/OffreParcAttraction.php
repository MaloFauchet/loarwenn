<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/Offre.php');

class OffreParcAttraction extends Offre {
    private $nbAttractions;
    private $ageMinimum;

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
     * @return offreActivite (array d'OffreActivite)
     * Récupère toutes les offres d'activités
     */
    public function getAllOffreActivite() {
        $sql = "
            SELECT * FROM tripenazor.offre_activite as activite
            JOIN tripenazor.offre as offre 
            ON visite.id_offre = offre.id_offre
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        $offresActivite = [];
        foreach ($result as $value) {
            $parcAttraction = new self();
            
            /**
             * Setters de la classe même
             */
            $parcAttraction->setNbAttraction($value['nb_attractions']);
            
            $parcAttraction->setAgeMin($value['age']);

            /**
             * Setters de la classe mère
             */
            $parcAttraction->setId($value['id']);
            $parcAttraction->setTitre($value['titre']);
            $parcAttraction->setResume($value['resume']);
            $parcAttraction->setDescription($value['description']);
            $parcAttraction->setDateCreation($value['dateCreation']);
            $parcAttraction->setAdresse($value['adresse']);
            $parcAttraction->setEnLigne($value['enLigne']);
            $parcAttraction->setType($value['type']);
            $parcAttraction->setNoteMoyenne($value['noteMoyenne']);
            $parcAttraction->setNbAvis($value['nbAvis']);

            $offresActivite[] = $parcAttraction;
        }
        return $offresActivite;
    }

    function updateParcAttractionOffre(
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

        $nb_attractions,
        $age_min,
        $titre_image_parc,
        $chemin_image_parc,

        $apres_midi_heure_debut,
        $apres_midi_heure_fin,
        $prix_prive,


    ){

        $sql = "select tripenazor.update_offre_parc_attraction(
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
            :p_nb_attractions ,
            :p_age_min ,
            :p_titre_image_parc ,
            :p_chemin_image_parc ,

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

        $stmt->bindValue(':p_jours', $this->convertArrayToPgArray($jours));
        $stmt->bindParam(':p_matin_heure_debut', $matin_heure_debut);
        $stmt->bindParam(':p_matin_heure_fin', $matin_heure_fin);

        $stmt->bindParam(':p_id_professionnel', $id_professionnel);

        $stmt->bindParam(':p_nb_attractions', $nb_attractions);
        $stmt->bindParam(':p_age_min', $age_min);
        $stmt->bindParam(':p_titre_image_parc', $titre_image_parc);
        $stmt->bindParam(':p_chemin_image_parc', $chemin_image_parc);

        $stmt->bindValue(':p_apres_midi_heure_debut', $apres_midi_heure_debut, $apres_midi_heure_debut === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':p_apres_midi_heure_fin', $apres_midi_heure_fin, $apres_midi_heure_fin === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindParam(':p_prix_prive', $prix_prive);
        

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Setters
     */
    function setNbAttraction($nbAttractions) {
        $this->nbAttractions = $nbAttractions;
    } 
    
    function setAgeMin($age) {
        $this->ageMinimum = $age;
    }


    /**
     * Getters
     */

    function getNbAttraction() {
        return $this->nbAttractions;
    }

    function getAge() {
        return $this->ageMinimum;
    }
}