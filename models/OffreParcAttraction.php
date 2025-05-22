<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/Offre.php');

class OffreParcAttraction extends Offre {
    protected $nb_attraction;
    protected $age_min;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();

        parent::__construct();
    }

    /**
     * @return array d'OffreParcAttraction
     * Récupère toutes les offres de parc d'attraction
     */
    public function getAllOffreParcAttraction() {
        $sql = "
            SELECT * FROM tripenazor.offre_parc_attraction as parc
            JOIN tripenazor.offre as offre 
            ON parc.id_offre = offre.id_offre
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        $offresParc = [];
        foreach ($result as $value) {
            $parc = new self();

            // Setters de la classe même
            $parc->setNbAttraction($value['nb_attraction']);
            $parc->setAgeMin($value['age_min']);

            // Setters de la classe mère
            $parc->setId($value['id_offre']);
            $parc->setTitre($value['titre']);
            $parc->setResume($value['resume']);
            $parc->setDescription($value['description']);
            $parc->setDateCreation($value['dateCreation']);
            $parc->setAdresse($value['adresse']);
            $parc->setEnLigne($value['enLigne']);
            $parc->setType($value['type']);
            $parc->setNoteMoyenne($value['noteMoyenne']);
            $parc->setNbAvis($value['nbAvis']);

            $offresParc[] = $parc;
        }

        return $offresParc;
    }

    /**
     * ToString
     */
    public function __toString() {
        return "Offre Parc Attraction : " . $this->getTitre() . 
               ", Nb attractions : " . $this->getNbAttraction() . 
               ", Âge minimum : " . $this->getAgeMin();
    }

    /**
     * Setters
     */
    public function setNbAttraction($nb) {
        $this->nb_attraction = $nb;
    }

    public function setAgeMin($age) {
        $this->age_min = $age;
    }

    /**
     * Getters
     */
    public function getNbAttraction() {
        return $this->nb_attraction;
    }

    public function getAgeMin() {
        return $this->age_min;
    }
}