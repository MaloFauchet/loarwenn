<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/Offre.php');

class OffreSpectacle extends Offre {
    private $capaciteAccueil;
    private $accessibilite;
    private $prix;
    private $duree;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();

        parent::__construct();
    }

    /**
     * @return offreSpectacle (array d'offreSpectacle)
     * Récupère toutes les offres de spectacle
     */
    public function getAllOffreSpectacle() {
        $sql = "
            SELECT * FROM tripenazor.offre_spectacle as spectacle
            JOIN tripenazor.offre as offre 
            ON spectacle.id_offre = offre.id_offre
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        $offresSpectacle = [];
        foreach ($result as $value) {
            $spectacle = new self();
            
            /**
             * Setters de la classe même
             */
            $spectacle->setDuree($value['duree']);
            $spectacle->setAccessibilite($value['accessibilite']);
            $spectacle->setCapaciteAccueil($value['capaciteAccueil']);
            $spectacle->setPrix($value['prix']);

            /**
             * Setters de la classe mère
             */
            $spectacle->setId($value['id']);
            $spectacle->setTitre($value['titre']);
            $spectacle->setResume($value['resume']);
            $spectacle->setDescription($value['description']);
            $spectacle->setDateCreation($value['dateCreation']);
            $spectacle->setAdresse($value['adresse']);
            $spectacle->setEnLigne($value['enLigne']);
            $spectacle->setType($value['type']);
            $spectacle->setNoteMoyenne($value['noteMoyenne']);
            $spectacle->setNbAvis($value['nbAvis']);

            $offresSpectacle[] = $spectacle;
        }
        return $offresSpectacle;
    }



    

    /**
     * ToString
     * @return string
     */
    public function __toString() {
        return "Offre Spectacle : " . $this->getTitre() . ", Prix : ". ", Accessibilité : " . $this->accessibilite;
    }


    /**
     * Setters
     */
    function setPrix($p) {
        $this->prix = $p;
    } 

    function setAccessibilite($ac) {
        $this->accessibilite = $ac;
    }

    function setCapaciteAccueil($ca) {
        $this->capaciteAccueil = $ca;
    }

    function setDuree($d) {
        $this->duree = $d;
    }

    /**
     * Getters
     */

    function getPrix() {
        return $this->prix;
    }

    function getAccessibilite() {
        return $this->accessibilite;
    }

    function getCapaciteAccueil() {
        return $this->capaciteAccueil;
    }

    function getDuree() {
        return $this->duree;
    }
}