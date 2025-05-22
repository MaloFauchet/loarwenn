<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/../models/Prestation.php';

class TagController {
    private $tagModel;

    public function __construct() {
        $this->tagModel = new Prestation();
    }

    public function getAllPrestationIncluse($id_offre) {
        return $this->tagModel->getAllPrestationIncluse($id_offre);
    }
}
