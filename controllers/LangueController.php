<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/../models/Langue.php';

class LangueController {
    private $langueModel;

    public function __construct() {
        $this->langueModel = new Langue();
    }

    public function getAllLangueForVisiteGuidee($id_type_activite) {
        return $this->langueModel->getAllLangueForVisiteGuidee($id_type_activite);
    }
}