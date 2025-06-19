<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/Model.php');

class Professionnel extends Model{ 

    public function getProfessionnelParId($id)
    {
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

    public function updateTentativeOTP($idPro, $tentatives, $bloqueJusqua, $now) {
        $sql = "
            UPDATE tripenazor.professionnel 
            SET tentative_otp = :tentatives,
                derniere_tentative_otp = :now,
                bloque_jusqua = :bloque 
            WHERE id_utilisateur = :id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'tentatives' => $tentatives,
            'now' => $now,
            'bloque' => $bloqueJusqua,
            'id' => $idPro
        ]);
    }

    public function getProfessionnelParEmailMotDePasse($email, $mdp)
    {
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
        SELECT * FROM tripenazor.inserer_utilisateur_et_professionnel_prive(
            :nom::TEXT, :prenom::TEXT, :email::TEXT, :telephone::TEXT,
            :adresse::TEXT, :complement::TEXT, :codePostal::TEXT, :ville::TEXT,
            :denomination::TEXT, :siren::INTEGER, :rib::TEXT, :motDePasse::TEXT
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

    public function addOffreByIdd($id_offre) {
        try {
            session_start();

            // Vérifie que l'utilisateur est connecté et est professionnel public
            if (!isset($_SESSION['user_id'])) {
                throw new Exception("Utilisateur non connecté.");
            }

            $id_utilisateur_public = $_SESSION['user_id'];

            $sql = "INSERT INTO tripenazor.pro_public_propose_offre (id_offre, id_utilisateur_public)
                    VALUES (:id_offre, :id_utilisateur_public)";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_offre', $id_offre, PDO::PARAM_INT);
            $stmt->bindParam(':id_utilisateur_public', $id_utilisateur_public, PDO::PARAM_INT);

            $stmt->execute();

            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => "Erreur SQL : " . $e->getMessage()];
        } catch (Exception $e) {
            return ['success' => false, 'error' => "Erreur : " . $e->getMessage()];
        }
    }

    public function isProfessionnel($id) {
        $sql = "SELECT COUNT(*) FROM tripenazor.professionnel WHERE id_utilisateur = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function updateProfessionnelPrive(
        $id,
        $nom,
        $prenom,
        $email,
        $telephone,
        $numeroAdresse, 
        $voieEntreprise,
        $complementAdresse,
        $codePostal,
        $ville,
        $denomination,
        $siren,
        $rib
    ) {
        // TODO : requete avec nouvelles fonctions
        $sql = "
        SELECT * FROM tripenazor.update_professionnel_prive(
            :id::INTEGER, :nom::TEXT, :prenom::TEXT, :email::TEXT, :telephone::TEXT,
            :numeroAdresse::TEXT, :voieEntreprise::TEXT, :complementAdresse::TEXT,
            :codePostal::TEXT, :ville::TEXT, :denomination::TEXT, :siren::INTEGER, :rib::TEXT
        )";

        $stmt = $this->conn->prepare($sql);

        // Liaison des paramètres
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':numeroAdresse', $numeroAdresse);
        $stmt->bindParam(':voieEntreprise', $voieEntreprise);
        $stmt->bindParam(':complementAdresse', $complementAdresse);
        $stmt->bindParam(':codePostal', $codePostal);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':denomination', $denomination);
        $stmt->bindParam(':siren', $siren);
        $stmt->bindParam(':rib', $rib);

        // Exécution de la requête
        return ($stmt->execute()) ? true : false;
    }

    public function updateProfessionnelPublic(
        $id,
        $nom,
        $prenom,
        $email,
        $telephone,
        $numeroAdresse, 
        $voieEntreprise,
        $complementAdresse,
        $codePostal,
        $ville,
        $raisonSociale
    ) {
        // TODO : requete avec nouvelles fonctions
        $sql = "
        SELECT * FROM tripenazor.update_professionnel_public(
            :id::INTEGER, :nom::TEXT, :prenom::TEXT, :email::TEXT, :telephone::TEXT,
            :numeroAdresse::TEXT, :voieEntreprise::TEXT, :complementAdresse::TEXT,
            :codePostal::TEXT, :ville::TEXT, :raisonSociale::TEXT
        )";

        $stmt = $this->conn->prepare($sql);

        // Liaison des paramètres
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':numeroAdresse', $numeroAdresse);
        $stmt->bindParam(':voieEntreprise', $voieEntreprise);
        $stmt->bindParam(':complementAdresse', $complementAdresse);
        $stmt->bindParam(':codePostal', $codePostal);
        $stmt->bindParam(':ville', $ville);

        // Exécution de la requête
        return ($stmt->execute()) ? true : false;
    }

    public function updateImage($id, $cheminImage) {
        $sql = "
        SELECT * FROM tripenazor.update_utilisateur_image(
            :id::INTEGER, :cheminImage::TEXT
        )";

        $stmt = $this->conn->prepare($sql);
        // Liaison des paramètres
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':cheminImage', $cheminImage);

        // Exécution de la requête
        return ($stmt->execute()) ? true : false;
    }
}
