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

    function updateSpectacleOffre(
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

        $duree,
        $prix_prive,

        $enRelief,
        $aLaUne,

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
            :capacite_accueil,
            :duree,

            :prix_prive
        )";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':id_offre', $id_offre);

        $stmt->bindParam(':nom_ville', $nom_ville);
        $stmt->bindParam(':code_postal', $code_postal);

        $stmt->bindParam(':titre_offre', $titre_offre);
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
        $stmt->bindParam(':capacite_accueil', $this->capaciteAccueil);
        $stmt->bindParam(':duree', $duree);

        $stmt->bindParam(':prix_prive', $prix_prive);
        
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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