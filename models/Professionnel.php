<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/Model.php');

class Professionnel extends Model{

    public function getProfessionnelById($id) {
        $sql = "
            SELECT * FROM tripenazor.proffessionnel
            INNER JOIN 
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addProfessionnelPrive($id) {
        $sql = "
            SELECT * FROM tripenazor.proffessionnel
            INNER JOIN 
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addProfessionnelPublic($id) {
        $sql = "
            SELECT * FROM tripenazor.proffessionnel
            INNER JOIN 
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}