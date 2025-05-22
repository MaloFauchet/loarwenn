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

    public function insertProfessionnelPrive(
        $nom,
        $prenom,
        $email,
        $telephone,
        $adresse,
        $complement,
        $codePostal,
        $ville,
        $denomination,
        $siren,
        $rib,
        $motDePasse
    ) {
        $sql = "
        SELECT * FROM inserer_utilisateur_et_professionnel_prive(
            :nom::TEXT, :prenom::TEXT, :email::TEXT, :telephone::TEXT,
            :adresse::TEXT, :complement::TEXT, :codePostal::TEXT, :ville::TEXT,
            :denomination::TEXT, :siren::INT, :rib::TEXT, :motDePasse::TEXT
        )
    ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':complement', $complement);
        $stmt->bindParam(':codePostal', $codePostal);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':denomination', $denomination);
        $stmt->bindParam(':siren', $siren);
        $stmt->bindParam(':rib', $rib);
        $stmt->bindParam(':motDePasse', $motDePasse);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function insertProfessionnelPublic($nom, $prenom, $email, $telephone, $adresse, $complement, $codePostal, $ville, $raisonSociale, $motDePasse)
    {
        $sql = "
        SELECT * FROM tripenazor.inserer_utilisateur_et_professionnel_public(
            :nom::TEXT, :prenom::TEXT, :email::TEXT, :telephone::TEXT,
            :adresse::TEXT, :complement::TEXT, :codePostal::TEXT,
            :ville::TEXT, :raisonSociale::TEXT, :motDePasse::TEXT)";


        $stmt = $this->conn->prepare($sql);

        // Liaison des paramètres
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':complement', $complement);
        $stmt->bindParam(':codePostal', $codePostal);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':raisonSociale', $raisonSociale);
        $stmt->bindParam(':motDePasse', $motDePasse);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
