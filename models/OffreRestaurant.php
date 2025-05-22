<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/Offre.php');

class OffreRestaurant extends Offre {
    private $prix;
    protected $pathImage;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();

        parent::__construct();
    }

    /**
     * @return offreSpectacle (array d'offreSpectacle)
     * Récupère toutes les offres de spectacle
     */
    public function getAllOffreRestaurant() {
        $sql = "
            SELECT * FROM tripenazor.offre_spectacle as spectacle
            JOIN tripenazor.offre as offre 
            ON spectacle.id_offre = offre.id_offre
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        $offresRestaurant = [];
        foreach ($result as $value) {
            $restaurant = new self();
            
            /**
             * Setters de la classe même
             */
            echo $value['pathImage'];
            $restaurant->setPrix($value['prix']);
            $restaurant->setPathImage($value['pathImage']);

            /**
             * Setters de la classe mère
             */
            $restaurant->setId($value['id']);
            $restaurant->setTitre($value['titre']);
            $restaurant->setResume($value['resume']);
            $restaurant->setDescription($value['description']);
            $restaurant->setDateCreation($value['dateCreation']);
            $restaurant->setAdresse($value['adresse']);
            $restaurant->setEnLigne($value['enLigne']);
            $restaurant->setType($value['type']);
            $restaurant->setNoteMoyenne($value['noteMoyenne']);
            $restaurant->setNbAvis($value['nbAvis']);

            $offresRestaurant[] = $restaurant;

            
        }
        return $offresRestaurant;
    }



    

    /**
     * ToString
     * @return string
     */
    public function __toString() {
        return "Offre Restaurant : " . $this->getTitre() . ", Prix : ". ", Accessibilité : " . $this->accessibilite;
    }


    /**
     * Setters
     */
    function setGammePrix($p) {
        $this->prix = $p;
    }

    function setPathImage($path) {
        $this->pathImage = $path;
    }

    /**
     * Getters
     */

    function getGammePrix() {
        return $this->prix;
    }

    function getPathImage() {
        return $this->pathImage;
    }
}