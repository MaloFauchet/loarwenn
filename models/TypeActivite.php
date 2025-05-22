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
            SELECT * FROM tripenazor.type_activite
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTagIdByTypeActivite($type_activite) {
        $sql = "
            SELECT t.id_tag FROM tripenazor.type_activite_autorise_tag as t
            JOIN tripenazor.type_activite as ta ON t.id_type_activite = ta.id_type_activite
            WHERE ta.libelle_activite = :type_activite;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':type_activite', $type_activite);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}