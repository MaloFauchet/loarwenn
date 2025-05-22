<?php
require_once($_SERVER['DOCUMENT_ROOT'] .  '/../models/OffreVisite.php');

class OffreVisiteController {
    private $offreVisite;

    public function __construct() {
        $this->offreVisite = new OffreVisite();
    }

    // Récupérer toutes les offres d'activités
    public function getAllOffresVisite() {
        return $this->offreVisite->getAllOffreVisite();
    }

    // Récupérer une offre activité par ID
    public function getOffreVisiteById($id) {
        return $this->offreVisite->getVisiteById($id);
    }

    //toString
    public function __toString() {
        return $this->offreVisite->__toString();
    }
}