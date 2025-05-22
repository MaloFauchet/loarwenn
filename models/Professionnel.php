<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../model/Model.php');


class Professionnel extends Model{

    public function getProfessionnelParId($id) {
        $sql = "
            SELECT * FROM tripenazor.proffessionnel
            LEFT JOIN tripenazor.proffessionnel_prive on  tripenazor.proffessionnel.id_utilisateur
            LEFT JOIN tripenazor.proffessionnel_public on  tripenazor.proffessionnel.id_utilisateur
            INNER JOIN tripenazor.utilisateur on tripenazor.proffessionnel.id_utilisateur = tripenazor.utilisateur.id_utilisateur WHERE tripenazor.proffessionnel.id_utilisateur=$id;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        public function getProfessionnelParEmailMotDePasse($email, $mdp) {
        $sql = "
            SELECT * FROM tripenazor.proffessionnel
            LEFT JOIN tripenazor.proffessionnel_prive on  tripenazor.proffessionnel.id_utilisateur
            LEFT JOIN tripenazor.proffessionnel_public on  tripenazor.proffessionnel.id_utilisateur
            INNER JOIN tripenazor.utilisateur on tripenazor.proffessionnel.id_utilisateur = tripenazor.utilisateur.id_utilisateur WHERE tripenazor.proffessionnel.id_utilisateur=$email, $mdp;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertProfessionnelPrive($nom, $prenom, $email, $telephone, $adresse, $complement, $codePostal, $ville, $denomination, $siren, $rib, $motDePasse) {
        $sql = "
            SELECT inserer_utilisateur_et_professionnel()
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertProfessionnelPublic($nom, $prenom, $email, $telephone, $adresse, $complement, $codePostal, $ville, $raisonSociale, $motDePasse) {
        $sql = "
            SELECT * FROM tripenazor.proffessionnel
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}