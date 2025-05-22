<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');

class Prestation {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllPrestationIncluse($id_offre) {
        $sql = "
            SELECT p.id_prestation, p.libelle_prestation FROM tripenazor.activite_inclus_prestation as ap
            JOIN tripenazor.prestation as p ON ap.id_prestation = p.id_prestation
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllPrestationNonIncluse($id_offre) {
        $sql = "
            SELECT p.id_prestation, p.libelle_prestation FROM tripenazor.activite_non_inclus_prestation as ap
            JOIN tripenazor.prestation as p ON ap.id_prestation = p.id_prestation
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}