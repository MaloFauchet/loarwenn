<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');

class Langue {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * @return langue (array de langues)
     * Récupère toutes les langues
     */
    public function getAllLangueForVisiteGuidee($id_visite_guidee) {
        $sql = "
            SELECT l.libelle_langue FROM tripenazor.visite_guidee_disponible_en_langue vgl
            JOIN tripenazor.langue l ON vgl.id_langue = l.id_langue
            WHERE vgl.id_visite = :idVisite;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id_visite_guidee]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}