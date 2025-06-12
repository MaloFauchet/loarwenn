<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/Membre.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/Professionnel.php');

class Utilisateur {
    private $conn;
    private $id_user;
    private $nom;
    private $prenom;


    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllUtilisateurs() {
        $sql = "
            SELECT * FROM tripenazor.utilisateur;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function connexionMembre($email, $mdp) {
        $sql = "
            SELECT
            u.id_utilisateur,
            u.mot_de_passe,

            m.pseudo

            FROM tripenazor.utilisateur as u

            JOIN tripenazor.membre as m
            ON m.id_utilisateur = u.id_utilisateur
            
            WHERE email = :email and u.id_utilisateur = m.id_utilisateur;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            if (password_verify($mdp, $result['mot_de_passe'])) {
                // Connexion réussie
                $membre = new Membre();
                $membre->setIdUtilisateur($result['id_utilisateur']);
                $membre->setPseudo($result['pseudo']);
                return $membre;
            }else{
                return false;
            }
        }else {
            return false;
        }
        
    }


    public function connexionPro($email, $mdp) {
        $sql = "
            SELECT

            u.id_utilisateur,
            u.email,
            u.mot_de_passe,
            u.nom,
            u.prenom,

            pprive.denomination,
            ppublic.raison_sociale,

            img.chemin
            
            FROM tripenazor.professionnel as p
            
            JOIN tripenazor.utilisateur as u
            ON p.id_utilisateur = u.id_utilisateur
            JOIN tripenazor.utilisateur_represente_image as uri
            ON uri.id_utilisateur = u.id_utilisateur
            JOIN tripenazor.image as img
            ON img.id_image = uri.id_image

            LEFT JOIN tripenazor.professionnel_prive as pprive
            ON p.id_utilisateur = pprive.id_utilisateur

            LEFT JOIN tripenazor.professionnel_public as ppublic
            ON p.id_utilisateur = ppublic.id_utilisateur

            WHERE u.email = :email
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($result){
            // Vérification du mot de passe
            if (password_verify($mdp, $result[0]['mot_de_passe'])) {
                return $result[0];
            }
            return false;
        }else{
            return false;
        }
        
    }

        public function insertMembre($nom, $prenom, $email, $telephone, $adresse, $complement, $codePostal, $ville, $pseudo, $motDePasse)
    {
        $sql = "
        SELECT * FROM tripenazor.inserer_utilisateur_et_membre(
            :nom::TEXT, :prenom::TEXT, :email::TEXT, :telephone::TEXT,
            :adresse::TEXT, :complement::TEXT, :codePostal::TEXT,
            :ville::TEXT, :pseudo::TEXT, :motDePasse::TEXT)";


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
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->bindParam(':motDePasse', $motDePasse);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInfoUtilisateur($id_utilisateur) {
        $sql = "
            SELECT * FROM tripenazor.utilisateur as u WHERE u.id_utilisateur = :id_utilisateur;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_utilisateur', $id_utilisateur);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /**
     * Setters
     */

    function setIdUtilisateur($id_user) {
        $this->id_user = $id_user;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    /**
     * Getters
     */

    function getIdUtilisateur() {
        return $this->id_user;
    }

    function getNom() {
        return $this->nom;
    }

    function getPrenom() {
        return $this->prenom;
    }
}