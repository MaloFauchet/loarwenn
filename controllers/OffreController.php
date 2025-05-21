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
}