<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');

class TypeActivite {
    protected $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllActivite() {
        $sql = "
            SELECT * FROM tripenazor.offre
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTagIdByTypeActivite($id_activite,$name_activite) {
        // Liste des tables possibles
        $allowed_tables = ['activite', 'spectacle', 'visite', 'parc_attractions', 'restauration','visite_guidee'];
        
        $liste = [
            'Activite' => 'id_activite',
            'Spectacle' => 'id_spectacle',
            'Visitenonguidee' => 'id_visite',
            'ParcDattraction' => 'id_parc_attractions',
            'Restaurant' => 'id_restaurant',
            'VisiteGuidee' => 'id_visite-guidee'
        ];  

        $id_colonne = $liste[$name_activite];

        if ($name_activite === 'restaurant') {
            $sql = "
                SELECT t.id_tag, t.libelle_tag
                FROM tripenazor.tag t
                JOIN tripenazor.tag_restauration c ON t.id_tag = c.id_tag
            ";
        } else {
            $sql = "
                SELECT t.id_tag, t.libelle_tag
                FROM tripenazor.tag t
                JOIN tripenazor.tag_commun c ON t.id_tag = c.id_tag
            ";
        }

        $stmt = $this->conn->prepare($sql);
       
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
