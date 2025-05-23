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


    public function connexionPro($email, $mdp) {
        $pro = $this->utilisateurModel->connexionPro($email, $mdp);
        if ($pro) {
            $_SESSION['id_utilisateur'] = $pro['id_utilisateur'];
            $_SESSION['nom'] = $pro['nom'];
            $_SESSION['prenom'] = $pro['prenom'];
            $_SESSION['pathImg'] = $pro['chemin'];
            if(isset($pro['denomination'])) {
                $_SESSION['type'] = "prive";
            } else if(isset($pro['raison_sociale'])) {
                $_SESSION['type'] = "public";
            }
            return $pro;
        }
        return $pro;
    }

    public function nouveauCompteMembre($nom, $prenom, $email, $telephone, $adresse, $complement, $codePostal, $ville, $pseudo, $motDePasse) {
        return $this->utilisateurModel->insertMembre($nom, $prenom, $email, $telephone, $adresse, $complement, $codePostal, $ville, $pseudo, $motDePasse);
    }
}
