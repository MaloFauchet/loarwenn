<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/Professionnel.php');

class ProfessionnelController {
    private $professionnelModel;

    public function __construct() {
        $this->professionnelModel = new Professionnel();
    }

    public function updateTentativeOTP($idPro, $tentatives, $bloqueJusqua) {
        return $this->professionnelModel->updateTentativeOTP($idPro, $tentatives, $bloqueJusqua, $now = date('Y-m-d H:i:s'));
    }

    public function seConnecter($email, $motDePasse) {
        return $this->professionnelModel->getProfessionnelParEmailMotDePasse($email, $motDePasse);
    }

    public function getProfessionnelById($id) {
        return $this->professionnelModel->getProfessionnelParId($id);
    }

    public function estEntreprisePrivee($id) {
        $data = $this->getProfessionnelById($id)[0];
        return $data['denomination'] !== null;
    }
    
    public function recuperationProfessionnelparID($id) {
        return $this->professionnelModel->getProfessionnelParId($id);
    }

    public function nouveauCompteProfessionnelPrive($nom, $prenom, $email, $telephone, $adresse, $complement, $codePostal, $ville, $denomination, $siren, $rib, $motDePasse) {
        return $this->professionnelModel->insertProfessionnelPrive($nom, $prenom, $email, $telephone, $adresse, $complement, $codePostal, $ville, $denomination, $siren, $rib, $motDePasse);
    }

    public function nouveauCompteProfessionnelPublic($nom, $prenom, $email, $telephone, $adresse, $complement, $codePostal, $ville, $raisonSociale, $motDePasse) {
        return $this->professionnelModel->insertProfessionnelPublic($nom, $prenom, $email, $telephone, $adresse, $complement, $codePostal, $ville, $raisonSociale, $motDePasse);
    }

    public function addOffreProPublic($post, $files) {
        // Validation simple
        $errors = [];
        $titre = trim($post['titre'] ?? '');
        $lieu = trim($post['lieu'] ?? '');
        $image = $files['image'] ?? null;

        if ($titre === '') $errors[] = "Le titre est obligatoire.";
        if ($lieu === '') $errors[] = "Le lieu est obligatoire.";
        if (!$image || $image['error'] !== UPLOAD_ERR_OK) $errors[] = "Une image valide est requise.";

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        // Upload image
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $imageName = basename($image['name']);
        $uploadPath = $uploadDir . $imageName;
        if (!move_uploaded_file($image['tmp_name'], $uploadPath)) {
            return ['success' => false, 'errors' => ['Erreur lors de l\'upload de l\'image.']];
        }

        // Insertion en BDD via le modèle
        $this->professionnelModel->addOffreByIdd([
            'titre' => $titre,
            'lieu' => $lieu,
            'image' => $imageName,
            'duree' => $post['duree'] ?? '',
            'age' => $post['age'] ?? '',
            'prix' => $post['prix'] ?? '',
            'description' => $post['description'] ?? '',
            'accessibilite' => $post['accessibilite'] ?? '',
            'id_activite' => $post['id_activite'] ?? '',
            'user_id' => $post['user_id'] ?? '',
        ]);

        return ['success' => true];
    }

    public function isProfessionnel($id) {
        return $this->professionnelModel->isProfessionnel($id);
    }
}
