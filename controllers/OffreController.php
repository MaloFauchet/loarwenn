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

    //toString
    public function __toString() {
        return $this->offre->__toString();
    }
    // Récupérer toutes les offres d'activités par ID professionnel
    public function getOffreByIdProfessionnel($id_professionnel) {
        return $this->offre->getOffreByIdProfessionnel($id_professionnel);
    }
    public function AllOffreByLatest()  {
        return $this->offre->getAllOffreByLatest();
    }
    public function getAllOffreRecommande()  {
        return $this->offre->getAllOffreRecommande();
    }
    public function getAllOffreTag()  {
        return $this->offre->getAllOffreTag();
    }

    public function allOffre() {
        return $this->offre->getAllOffre();
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
    }
}
