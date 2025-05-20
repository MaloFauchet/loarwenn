<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');

class Utilisateur {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllUtilisateurs() {
        $sql = "
            SELECT * FROM tripenazor.utilisateur
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}