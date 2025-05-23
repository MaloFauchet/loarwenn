<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');
require_once(__DIR__ . '/../models/Offre.php');

class OffreVisite extends Offre {
    private $duree;
    private $accessibilite;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();

        parent::__construct();
    }

    /**
     * @return offreVisite (array d'OffreVisite)
     * Récupère toutes les offres d'activités
     */
    public function getAllOffreVisite() {
        $sql = "
            SELECT * FROM tripenazor.offre_visite as visite
            JOIN tripenazor.offre as offre 
            ON visite.id_offre = offre.id_offre
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        $offresVisite = [];
        foreach ($result as $value) {
            $visite = new self();
            
            /**
             * Setters de la classe même
             */
            $visite->setDuree($value['duree']);
            $visite->setAccessibilite($value['accessibilite']);

            /**
             * Setters de la classe mère
             */
            $visite->setId($value['id']);
            $visite->setTitre($value['titre']);
            $visite->setResume($value['resume']);
            $visite->setDescription($value['description']);
            $visite->setDateCreation($value['dateCreation']);
            $visite->setAdresse($value['adresse']);
            $visite->setEnLigne($value['enLigne']);
            $visite->setType($value['type']);
            $visite->setNoteMoyenne($value['noteMoyenne']);
            $visite->setNbAvis($value['nbAvis']);

            $offresVisite[] = $visite;

            
        }
        return $offresVisite;
    }



    

    /**
     * ToString
     * @return string
     */
    public function __toString() {
        return "Offre Visite : " . $this->getTitre() . 
       ", Durée : " . $this->getDuree() . 
       ", Accessibilité : " . $this->getAccessibilite();
    }


    /**
     * Setters
     */
    public function setDuree($d) {
        $this->duree = $d;
    } 

    public function setAccessibilite($ac) {
        $this->accessibilite = $ac;
    }

    /**
     * Getters
     */

    public function getDuree() {
        return $this->duree;
    }

    public function getAccessibilite() {
        return $this->accessibilite;
    }
}