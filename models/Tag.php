<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');

class Tag {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllTagByIdTagActivite($id_type_activite) {
        $sql = "
            SELECT * FROM tripenazor.tag;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}