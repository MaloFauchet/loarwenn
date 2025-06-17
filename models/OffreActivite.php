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

        $prestationIncluse,
        $prestationNonIncluse,
  
        $enRelief,
        $aLaUne,

    ){
        
        $sql = "tripenazor.update_offre_activite(
            :id_offre,
            
            -- Paramètres de l'offre
            :nom_ville,
            :code_postal,

            :titre_offre,
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
            :prestations_incluses,
            :prestations_non_incluses,
            :duree,
            :age,

        )";

        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(':id_offre', $id_offre);

        $stmt->bindParam(':nom_ville', $nom_ville);
        $stmt->bindParam(':code_postal', $code_postal);

        $stmt->bindParam(':titre_offre', $titre_offre);
        $stmt->bindParam(':voie', $voie);;
        $stmt->bindParam(':en_ligne', $this->enLigne);
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

        $prestationIncluse = json_encode($prestationIncluse);
        $prestationNonIncluse = json_encode($prestationNonIncluse);
        $stmt->bindParam(':prestations_incluses', $prestationIncluse);
        $stmt->bindParam(':prestations_non_incluses', $prestationNonIncluse);
        $stmt->bindParam(':duree', $this->duree);
        $stmt->bindParam(':age', $this->age);
        
        

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