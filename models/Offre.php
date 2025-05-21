<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/../config/Database.php';

class Offre {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllOffre() {
        $sql = "
            SELECT * FROM tripenazor.offre
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

    public function getOffreByIdProfessionnel($id_professionnel) {
    $sql = "
        SELECT o.*, i.chemin AS image_chemin, i.titre_image
        FROM tripenazor.offre o
        JOIN tripenazor.abonnement a ON a.id_offre = o.id_offre
        JOIN tripenazor.professionnel p ON p.id_utilisateur = a.id_utilisateur_prive
        LEFT JOIN tripenazor.image_illustre_offre io ON io.id_offre = o.id_offre
        LEFT JOIN tripenazor.image i ON i.id_image = io.id_image
        WHERE p.id_utilisateur = :id_utilisateur;
    ";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([':id_utilisateur' => $id_professionnel]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    

}