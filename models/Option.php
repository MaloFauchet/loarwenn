<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');

    class Option {
        private $conn;

        public function __construct() {
            $database = new Database();
            $this->conn = $database->getConnection();
        }

        function getOption(){
            $sql = "SELECT * FROM tripenazor.option";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>