<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/Professionnel.php');

class ProfessionnelController {
    private $professionnelModel;

    public function __construct() {
        $this->professionnelModel = new Professionnel();
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
    
    public function recuperationProfessionnelparID($id) {
        return $this->professionnelModel->getProfessionnelParId($id);
    }

    public function nouveauCompteProfessionnelPrive($nom, $prenom, $email, $telephone, $adresse, $complement, $codePostal, $ville, $denomination, $siren, $rib, $motDePasse) {
        return $this->professionnelModel->insertProfessionnelPrive($nom, $prenom, $email, $telephone, $adresse, $complement, $codePostal, $ville, $denomination, $siren, $rib, $motDePasse);
    }

    public function nouveauCompteProfessionnelPublic($nom, $prenom, $email, $telephone, $adresse, $complement, $codePostal, $ville, $raisonSociale, $motDePasse) {
        return $this->professionnelModel->insertProfessionnelPublic($nom, $prenom, $email, $telephone, $adresse, $complement, $codePostal, $ville, $raisonSociale, $motDePasse);
    }
}
