<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/../models/Offre.php'    ;

class OffreController {
    private $offreModel;

    public function __construct() {
        $this->offreModel = new Offre();
    }

    public function allOffre() {
        return $this->offreModel->getAllOffre();
    }
    public function getOffreByIdProfessionnel($id_professionnel) {
        return $this->offreModel->getOffreByIdProfessionnel($id_professionnel);
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
