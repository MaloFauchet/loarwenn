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