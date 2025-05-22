<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/Professionnel.php');

class ProfessionnelController {
    private $professionnelModel;

    public function __construct() {
        $this->professionnelModel = new Professionnel();
    }

    public function seConnecterProfessionnel($email, $motDePasse) {
        return $this->professionnelModel->getProfessionnelParEmailMotDePasse($email, $motDePasse);
    }

    public function seConnecter($email, $motDePasse) {
        return $this->professionnelModel->getProfessionnelParEmailMotDePasse($email, $motDePasse);
    }

    public function getProfessionnelById($id) {
        return $this->professionnelModel->getProfessionnelParId($id);
    }

    public function estEntreprisePrivee($id) {
        $data = $this->getProfessionnelById($id)[0];
        return $data['denomination'] !== null;
    }
}
