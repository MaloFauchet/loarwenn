<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/Membre.php');

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
       
        if (password_verify($mdp, $result['mot_de_passe'])) {
            // Connexion réussie
            $membre = new Membre();
            $membre->setIdUtilisateur($result['id_utilisateur']);
            $membre->setPseudo($result['pseudo']);
            return $membre;
        }else{
            return false;
        }
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