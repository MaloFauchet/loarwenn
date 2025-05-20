<?php
require_once('../models/Utilisateur.php');

class UtilisateurController {
    private $utilisateurModel;

    public function __construct() {
        $this->utilisateurModel = new Utilisateur();
    }

    public function afficherUtilisateurs() {
        return $this->utilisateurModel->getAllUtilisateurs();
    }
}
