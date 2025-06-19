<?php
class Model {
    protected $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }
}
