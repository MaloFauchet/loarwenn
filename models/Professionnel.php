<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/Model.php');


class Professionnel extends Model{

    public function getProfessionnelParId($id) {
        $sql = "
        SELECT * FROM tripenazor.professionnel
        LEFT JOIN tripenazor.professionnel_prive on tripenazor.professionnel.id_utilisateur = tripenazor.professionnel_prive.id_utilisateur
        LEFT JOIN tripenazor.professionnel_public on tripenazor.professionnel.id_utilisateur = tripenazor.professionnel_public.id_utilisateur
        INNER JOIN tripenazor.utilisateur on tripenazor.professionnel.id_utilisateur = tripenazor.utilisateur.id_utilisateur
        INNER JOIN tripenazor.ville on tripenazor.ville.id_ville = tripenazor.utilisateur.id_ville
        INNER JOIN tripenazor.utilisateur_represente_image on tripenazor.utilisateur_represente_image.id_utilisateur = tripenazor.utilisateur.id_utilisateur
        INNER JOIN tripenazor.image on tripenazor.image.id_image = tripenazor.utilisateur_represente_image.id_image
        WHERE tripenazor.utilisateur.id_utilisateur = :id;
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        public function getProfessionnelParEmailMotDePasse($email, $mdp) {
        $sql = "
            SELECT * FROM tripenazor.professionnel
            LEFT JOIN tripenazor.professionnel_prive on  tripenazor.professionnel.id_utilisateur
            LEFT JOIN tripenazor.professionnel_public on  tripenazor.professionnel.id_utilisateur
            INNER JOIN tripenazor.utilisateur on tripenazor.professionnel.id_utilisateur = tripenazor.utilisateur.id_utilisateur WHERE tripenazor.professionnel.id_utilisateur=$email, $mdp;
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
            SELECT * FROM tripenazor.professionnel
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}