<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/../models/Utilisateur.php';

class UtilisateurController {
    private $utilisateurModel;

    public function __construct() {
        $this->utilisateurModel = new Utilisateur();
    }

    public function afficherUtilisateurs() {
        return $this->utilisateurModel->getAllUtilisateurs();
    }

    public function connexionMembre($email, $mdp) {
        $membre = $this->utilisateurModel->connexionMembre($email, $mdp);
        if ($membre) {
            $_SESSION['id_utilisateur'] = $membre->getIdUtilisateur();
            $_SESSION['pseudo'] = $membre->getPseudo();
            return $membre;
        }
        return $membre;
    }
}
