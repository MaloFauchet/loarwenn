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

    function updateVisiteOffre(
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

    /**
     * Getters
     */

    function getDuree() {
        return $this->duree;
    }

    function getAccessibilite() {
        return $this->accessibilite;
    }
}