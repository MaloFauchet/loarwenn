<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/Professionnel.php');

class ProfessionnelController {
    private $professionnelModel;

    public function __construct() {
        $this->professionnelModel = new Professionnel();
    }

    public function afficherUtilisateurs() {
        return $this->professionnelModel->getAllUtilisateurs();
    }
}
