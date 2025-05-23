<?php
require_once($_SERVER['DOCUMENT_ROOT'] .  '/../models/Offre.php');

class OffreController {
    private $offre;

    public function __construct() {
        $this->offre = new Offre();
    }

    // Récupérer toutes les offres d'activités
    public function getAllOffres() {
        return $this->offre->getAllOffre();
    }

    // Récupérer une offre activité par ID
    public function getOffreById($id) {
        return $this->offre->getOffreById($id);
    }

    public function getOffreByIdAccueil($id) {
        return $this->offre->getOffreByIdAccueil($id);
    }
    public function getViewOffreAccueil() {
        return $this->offre->getViewOffreAccueil();
    }
    //toString
    
    // Récupérer toutes les offres d'activités par ID professionnel
    public function getOffreByIdProfessionnel($id_professionnel) {
        return $this->offre->getOffreByIdProfessionnel($id_professionnel);
    }
    public function AllOffreByLatest()  {
        return $this->offre->getAllOffreByLatest();
    }
    //Retourne le nom de l'entreprise de l'offre
    public function getProfessionnelByIdOffre($id_offre){
        return $this->offre->getProfessionnelByIdOffre($id_offre);
    }


    public function allOffre() {
        return $this->offre->getAllOffre();
    }
    public function getAllOffreRecommande()  {
        return $this->offre->getAllOffreRecommande();
    }
    public function getAllOffreTag()  {
        return $this->offre->getAllOffreTag();
    }

     public function ajouterOffre($post, $files) {
        print_r($post);
        // Validation simple
        $errors = [];

        if($post['id_activite'] == 1) {
            
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
            $this->offre->insertOffreActivite([
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

        else if($post['id_activite'] == 2) {
            
            $titre = trim($post['titre'] ?? '');
            $image = $files['image'] ?? null;
            $lieu = trim($post['lieu'] ?? '');

            if ($titre === '') $errors[] = "Le titre est obligatoire.";

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
            $this->offre->insertOffreSpectacle([
                'titre' => $titre,
                'lieu' => $lieu,
                'adresse' => $post['adresse'] ?? '',
                'duree' => $post['duree'] ?? '',
                'capacite' => $post['capacite'] ?? '',
                'prix' => $post['prix'] ?? '',
                'resume' => $post['resume'] ?? '',
                'description' => $post['description'] ?? '',
                'id_activite' => $post['id_activite'] ?? '',
                'accessibilite' => $post['accessibilite'] ?? '',
                'user_id' => $post['user_id'] ?? '',
            ]);

            return ['success' => true];
        }

        else if($post['id_activite'] == 5) {
            
            $titre = trim($post['titre'] ?? '');
            $image = $files['image'] ?? null;
            $lieu = trim($post['lieu'] ?? '');

            if ($titre === '') $errors[] = "Le titre est obligatoire.";

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
            $this->offre->insertOffreRestaurant([
                'titre' => $titre,
                'lieu' => $lieu,
                'adresse' => $post['adresse'] ?? '',
                'prix' => $post['prix'] ?? '',
                'resume' => $post['resume'] ?? '',
                'description' => $post['description'] ?? '',
                'id_activite' => $post['id_activite'] ?? '',
                'user_id' => $post['user_id'] ?? '',
            ]);

            return ['success' => true];
        }
    }
    /*
    public function createOffre(
        $id_ville, 
        $id_statut_log, 
        $id_type_activite, 
        $titre_offre, 
        $note_moyenne, 
        $nb_avis, 
        $en_ligne, 
        $resume, 
        $description, 
        $adresse_offre
        
    ) {
        return $this->offre->createOffre(
            $id_ville, 
            $id_statut_log, 
            $id_type_activite, 
            $titre_offre, 
            $note_moyenne, 
            $nb_avis, 
            $en_ligne, 
            $resume, 
            $description, 
            $adresse_offre
        );
    }

    public function editOffre(
        $idOffre,
        $id_ville, 
        $id_statut_log, 
        $id_type_activite, 
        $titre_offre, 
        $note_moyenne, 
        $nb_avis, 
        $en_ligne, 
        $resume, 
        $description, 
        $adresse_offre
        
    ) {
        return $this->offre->editOffre(
            $idOffre,
            $id_ville, 
            $id_statut_log, 
            $id_type_activite, 
            $titre_offre, 
            $note_moyenne, 
            $nb_avis, 
            $en_ligne, 
            $resume, 
            $description, 
            $adresse_offre
        );
    }*/
}
