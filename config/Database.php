<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../config/getDataEnv.php';
loadEnv($_SERVER['DOCUMENT_ROOT'] . '/../config/.env');

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct() {
        $this->host = 'postgresdb';
        $this->db_name = getenv('DB_NAME');
        $this->username = getenv('DB_USER');
        $this->password = getenv('DB_ROOT_PASSWORD');
    }

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "pgsql:host={$this->host};dbname={$this->db_name}",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            throw new Exception("Connection error: " . $exception->getMessage());
        }
        return $this->conn;
    }
}
