<?php
require_once('../config/Database.php');

class Offre {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllOffre() {
        $sql = "
            SELECT * FROM tripenazor.offre;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOffreByLatest() {
        $sql = "
            SELECT * FROM tripenazor.offre 
            JOIN tripenazor.ville ON offre.id_ville = ville.id_ville 
            JOIN tripenazor.type_activite ON offre.id_type_activite = type_activite.id_type_activite
            JOIN tripenazor.image_illustre_offre ON offre.id_offre = image_illustre_offre.id_offre
            JOIN tripenazor.image ON image_illustre_offre.id_image = image.id_image
            ORDER BY date_creation DESC;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getOffreById($idOffre) {
        $sql = "
            SELECT * FROM tripenazor.offre 
            JOIN tripenazor.ville ON offre.id_ville = ville.id_ville 
            JOIN tripenazor.type_activite ON offre.id_type_activite = type_activite.id_type_activite
            JOIN tripenazor.image_illustre_offre ON offre.id_offre = image_illustre_offre.id_offre
            JOIN tripenazor.image ON image_illustre_offre.id_image = image.id_image
            WHERE offre.id_offre = :idOffre;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':idOffre' => $idOffre]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOffreRecommande() {
        $sql = "
            SELECT * FROM tripenazor.offre 
            JOIN tripenazor.ville ON offre.id_ville = ville.id_ville 
            JOIN tripenazor.type_activite ON offre.id_type_activite = type_activite.id_type_activite
            JOIN tripenazor.image_illustre_offre ON offre.id_offre = image_illustre_offre.id_offre
            JOIN tripenazor.image ON image_illustre_offre.id_image = image.id_image
            JOIN tripenazor.option_payante_offre ON offre.id_offre = option_payante_offre.id_offre
            JOIN tripenazor.option ON option_payante_offre.id_offre = option.id_option
            JOIN tripenazor.souscription ON option_payante_offre.id_souscription = souscription.id_souscription
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOffreTag() {
        $sql = "
            SELECT * FROM tripenazor.offre 
            JOIN tripenazor.ville ON offre.id_ville = ville.id_ville 
            JOIN tripenazor.type_activite ON offre.id_type_activite = type_activite.id_type_activite
            JOIN tripenazor.image_illustre_offre ON offre.id_offre = image_illustre_offre.id_offre
            JOIN tripenazor.image ON image_illustre_offre.id_image = image.id_image
            JOIN tripenazor.option_payante_offre ON offre.id_offre = option_payante_offre.id_offre
            JOIN tripenazor.option ON option_payante_offre.id_offre = option.id_option
            JOIN tripenazor.souscription ON option_payante_offre.id_souscription = souscription.id_souscription
            JOIN tripenazor.offre_possede_tags ON offre.id_offre = offre_possede_tags.id_offre 
            JOIN tripenazor.tag ON offre_possede_tags.id_tag = tag.id_tag
            


        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    


    //TODO changer camelCase
    public function createOffre(
        $id_ville, 
        $id_statut_log, 
        $id_type_activite, 
        $titre_offre, 
        $note_moyenne, 
        $nb_avis, 
        $en_ligne, 
        $resume, 
        $description, 
        $adresse_offre
    ) {
        $sql = "
            INSERT INTO tripenazor.offre (
                id_ville,
                id_statut_log,
                id_type_activite,
                titre_offre,
                note_moyenne,
                nb_avis,
                en_ligne,
                resume,
                description,
                adresse_offre
            ) VALUES (
                :id_ville,
                :id_statut_log,
                :id_type_activite,
                :titre_offre,
                :note_moyenne,
                :nb_avis,
                :en_ligne,
                :resume,
                :description,
                :adresse_offre
            )
            
            ;
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':id_ville' => $id_ville,
            ':id_statut_log' => $id_statut_log,
            ':id_type_activite' => $id_type_activite,
            ':titre_offre' => $titre_offre,
            ':note_moyenne' => $note_moyenne,
            ':nb_avis' => $nb_avis,
            ':en_ligne' => $en_ligne,
            ':resume' => $resume,
            ':description' => $description,
            ':adresse_offre' => $adresse_offre,
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    //TODO changer camelCase
    public function editOffre(
        $id_offre,
        $id_ville, 
        $id_statut_log, 
        $id_type_activite, 
        $titre_offre, 
        $note_moyenne, 
        $nb_avis, 
        $en_ligne, 
        $resume, 
        $description, 
        $adresse_offre
    ) {
        $sql = "
           UPDATE tripenazor.offre SET
                id_ville = :id_ville,
                id_statut_log = :id_statut_log,
                id_type_activite = :id_type_activite,
                titre_offre = :titre_offre,
                note_moyenne = :note_moyenne,
                nb_avis = :nb_avis,
                en_ligne = :en_ligne,
                resume = :resume,
                description = :description,
                adresse_offre = :adresse_offre
            WHERE id_offre = :id_offre
            ;
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':id_offre' => $id_offre,
            ':id_ville' => $id_ville,
            ':id_statut_log' => $id_statut_log,
            ':id_type_activite' => $id_type_activite,
            ':titre_offre' => $titre_offre,
            ':note_moyenne' => $note_moyenne,
            ':nb_avis' => $nb_avis,
            ':en_ligne' => $en_ligne,
            ':resume' => $resume,
            ':description' => $description,
            ':adresse_offre' => $adresse_offre,
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

}