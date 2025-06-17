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
        $apres_midi_heure_debut,
        $apres_midi_heure_fin,

        $id_professionnel,
        $prix,
        $nb_attractions,
        $prix_prive,


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
            :nb_attractions,
            :age,

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
        $stmt->bindParam(':nb_attractions', $this->nbAttractions);
        $stmt->bindParam(':age', $this->ageMinimum);
        $stmt->bindParam(':prix_prive', $prix_prive);

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