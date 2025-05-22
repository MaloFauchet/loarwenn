<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/Model.php');


class Professionnel extends Model
{

    public function getProfessionnelParId($id)
    {
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

    public function getProfessionnelParEmailMotDePasse($email, $mdp)
    {
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

    public function insertProfessionnelPrive($nom, $prenom, $email, $telephone, $adresse, $complement, $codePostal, $ville, $denomination, $siren, $rib, $motDePasse)
    {
        $sql = "
            SELECT inserer_utilisateur_et_professionnel_prive($nom, $prenom, $email, $telephone, $adresse, $complement, $codePostal, $ville, $denomination, $siren, $rib, $motDePasse)
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertProfessionnelPublic($nom, $prenom, $email, $telephone, $adresse, $complement, $codePostal, $ville, $raisonSociale, $motDePasse)
    {
        $sql = "
        SELECT inserer_utilisateur_et_professionnel_public(
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )
    ";

        $stmt = $this->conn->prepare($sql);

        // Liaison des paramètres dans l'ordre
        $stmt->bindParam(1, $nom);
        $stmt->bindParam(2, $prenom);
        $stmt->bindParam(3, $email);
        $stmt->bindParam(4, $telephone);
        $stmt->bindParam(5, $adresse);
        $stmt->bindParam(6, $complement);
        $stmt->bindParam(7, $codePostal);
        $stmt->bindParam(8, $ville);
        $stmt->bindParam(9, $raisonSociale);
        $stmt->bindParam(10, $motDePasse);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
