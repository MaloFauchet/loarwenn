<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/Offre.php');

class OffreActivite extends Offre {
    private $duree;
    private $accessibilite;
    private $age;

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
            $activite = new self();
            
            /**
             * Setters de la classe même
             */
            $activite->setDuree($value['duree']);
            $activite->setAccessibilite($value['accessibilite']);
            $activite->setAgeMin($value['age']);

            /**
             * Setters de la classe mère
             */
            $activite->setId($value['id']);
            $activite->setTitre($value['titre']);
            $activite->setResume($value['resume']);
            $activite->setDescription($value['description']);
            $activite->setDateCreation($value['dateCreation']);
            $activite->setAdresse($value['adresse']);
            $activite->setEnLigne($value['enLigne']);
            $activite->setType($value['type']);
            $activite->setNoteMoyenne($value['noteMoyenne']);
            $activite->setNbAvis($value['nbAvis']);

            $offresActivite[] = $activite;

            
        }
        return $offresActivite;
    }

    function updateActiviteOffre(
        $id_offre,

        $nom_ville,
        $code_postal,

        $titre_offre,
        $enLigne, 
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
        
        $prestationIncluse,
        $prestationNonIncluse,
        $duree,
        $age,
        
        $apres_midi_heure_debut,
        $apres_midi_heure_fin,
        $prix,
        
        ){
        
        $sql = "SELECT tripenazor.update_offre_activite(
            :id_offre::INT,
            
            -- Paramètres de l'offre
            :nom_ville::TEXT,
            :code_postal::TEXT,

            :titre_offre::TEXT,
            :en_ligne::BOOLEAN, -- En ligne est géré par la classe mère Offre
            :resume::TEXT,
            :description::TEXT,
            :accessibilite::TEXT,
            :type_offre::tripenazor.type_activite,
            :prix_TTC_min::FLOAT,
            :tags::TEXT[],

            -- Adresse
            :voie::TEXT,
            :numero_adresse::INT,
            :complement_adresse::TEXT,

            -- Image
            :titre_image::TEXT,
            :chemin_image::TEXT,

            -- Jour de l'activité
            :jours::NUMERIC[],
            :matin_heure_debut::TIME,
            :matin_heure_fin::TIME,

            -- Professionnel
            :id_professionnel::INT,

            -- Paramètres spécifiques à l'activité
            :prestations_incluses::TEXT[],
            :prestations_non_incluses::TEXT[],
            :duree::TIME,
            :age::INT,

            :apres_midi_heure_debut::TIME,
            :apres_midi_heure_fin::TIME,
            :prix::FLOAT
        )";

        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(':id_offre', $id_offre);

        $stmt->bindParam(':nom_ville', $nom_ville);
        $stmt->bindParam(':code_postal', $code_postal);

        $stmt->bindParam(':titre_offre', $titre_offre);
        $stmt->bindParam(':en_ligne', $enLigne); // En ligne est géré par la classe mère Offre
        $stmt->bindParam(':voie', $voie);
        $stmt->bindParam(':resume', $resume);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':accessibilite', $accessibility);
        $stmt->bindParam(':type_offre', $type_offre);
        $stmt->bindParam(':prix_TTC_min', $prix_TCC_min);

        $stmt->bindValue(':tags', $this->convertArrayToPgArray($tags));

        $stmt->bindParam(':voie', $voie);
        $stmt->bindParam(':numero_adresse', $numero_adresse);
        $stmt->bindParam(':complement_adresse', $complement_adresse);

        $stmt->bindParam(':titre_image', $titre_image);
        $stmt->bindParam(':chemin_image', $chemin_image);


        $stmt->bindValue(':jours', $this->convertArrayToPgArray($jours));

        $stmt->bindParam(':matin_heure_debut', $matin_heure_debut);
        $stmt->bindParam(':matin_heure_fin', $matin_heure_fin);
       
        //$stmt->bindValue(':apres_midi_heure_debut', $apres_midi_heure_debut ?? null);

        //$stmt->bindValue(':apres_midi_heure_debut', $apres_midi_heure_debut ?? null);
        $stmt->bindValue(':apres_midi_heure_debut', $apres_midi_heure_debut, $apres_midi_heure_debut === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $stmt->bindValue(':apres_midi_heure_fin', $apres_midi_heure_fin, $apres_midi_heure_fin === null ? PDO::PARAM_NULL : PDO::PARAM_STR);


        $stmt->bindParam(':id_professionnel', $id_professionnel);
        $stmt->bindParam(':prix', $prix);

        
        $stmt->bindValue(':prestations_incluses', $this->convertArrayToPgArray($prestationIncluse));
        $stmt->bindValue(':prestations_non_incluses', $this->convertArrayToPgArray($prestationNonIncluse));

        $stmt->bindParam(':duree', $duree);
        $stmt->bindParam(':age', $age);
        
        

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    

    

    /**
     * ToString
     * @return string
     */
    public function __toString() {
        return "Offre Visite : " . $this->getTitre() . ", Durée : ". ", Accessibilité : " . $this->accessibilite;
    }


    /**
     * Setters
     */
    function setDuree($d) {
        $this->duree = $d;
    } 

    function setAccessibilite($ac) {
        $this->accessibilite = $ac;
    }

    function setAgeMin($age) {
        $this->age = $age;
    }

    /**
     * Getters
     */

    function getDuree() {
        return $this->duree;
    }

    function getAccessibilite() {
        return $this->accessibilite;
    }
    
    function getAge() {
        return $this->age;
    }
}