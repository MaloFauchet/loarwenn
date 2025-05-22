<?php
require_once('../models/Offre.php');

class OffreController {
    private $offreModel;

    public function __construct() {
        $this->offreModel = new Offre();
    }

    public function allOffre() {
        return $this->offreModel->getAllOffre();
    }

    public function AllOffreByLatest()  {
        return $this->offreModel->getAllOffreByLatest();
    }
    public function getOffreById($id)  {
        return $this->offreModel->getOffreById($id);
    }
    public function getAllOffreRecommande()  {
        return $this->offreModel->getAllOffreRecommande();
    }
    public function getAllOffreTag()  {
        return $this->offreModel->getAllOffreTag();
    }
    
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
        return $this->offreModel->createOffre(
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
        return $this->offreModel->editOffre(
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
    }
}
