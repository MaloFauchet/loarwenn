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
    public function getAllOffreVisite() {
        $sql = "
            SELECT * FROM tripenazor.offre_spectacle as spectacle
            JOIN tripenazor.offre as offre 
            ON spectacle.id_offre = offre.id_offre
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
        $this->capaciteAccueil = $d;
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