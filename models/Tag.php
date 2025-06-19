<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');

class Tag {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * @return tag (array de tags)
     * Récupère tous les tags
     */
    public function getAllTagByIdTagActivite($id_tags) {
        $result = [];
        if (empty($id_tags)) {
            return $result;
        }
        foreach ($id_tags as $id_tag) {
            $sql = "
                SELECT * FROM tripenazor.tag as t
                WHERE t.id_tag = :id_tag
            ";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_tag', $id_tag);
            $stmt->execute();

            $result[] = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $result;
    }

    /**
     * @return tag (array de tags)
     * Récupère tous les tags
     */
    public function getAllTagByIdoffre($id_offre) {
            $sql = "
                SELECT * FROM tripenazor.tag as t
                WHERE t.id_tag = :id_tag
            ";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_tag', $id_tag);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }
}