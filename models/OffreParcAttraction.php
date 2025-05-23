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