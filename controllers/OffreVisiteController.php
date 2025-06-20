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
    /*public function getOffreVisiteById($id) {
        return $this->offreVisite->getVisiteById($id);
    }*/

    //toString
    public function __toString() {
        return $this->offreVisite->__toString();
    }

    public function updateVisiteOffre(

        $id_offre,

        $nom_ville,
        $code_postal,

        $titre_offre,
        $en_ligne,
        $resume,
        $description,
        $accessibility,
        $type_offre,
        $prix_TCC_min,
        $tags, 

        $voie,
        $numero_adresse,
        $complement_adresse,

        $titre_image,
        $chemin_image,

        $jours,
        $matin_heure_debut,
        $matin_heure_fin,
        
        $id_professionnel,
        
        $duree,
        $langues,

        $apres_midi_heure_debut,
        $apres_midi_heure_fin,
        $prix_prive,
        ) {
        return $this->offreVisite->updateVisiteOffre(
            $id_offre,

            $nom_ville,
            $code_postal,

            $titre_offre,
            $en_ligne,
            $resume,
            $description,
            $accessibility,
            $type_offre,
            $prix_TCC_min,
            $tags, 

            $voie,
            $numero_adresse,
            $complement_adresse,

            $titre_image,
            $chemin_image,

            $jours,
            $matin_heure_debut,
            $matin_heure_fin,
            
            $id_professionnel,
            
            $duree,
            $langues,
            
            $apres_midi_heure_debut,
            $apres_midi_heure_fin,
            $prix_prive,
        );
    }

    public function updateVisiteNonGuideeOffre(
        $id_offre,

        $nom_ville,
        $code_postal,

        $titre_offre,
        $en_ligne,
        $resume,
        $description,
        $accessibility,
        $type_offre,
        $prix_TCC_min,
        $tags, 

        $voie,
        $numero_adresse,
        $complement_adresse,

        $titre_image,
        $chemin_image,

        $jours,
        $matin_heure_debut,
        $matin_heure_fin,
        
        $id_professionnel,
        
        $duree,
        
        $apres_midi_heure_debut,
        $apres_midi_heure_fin,
        $prix_prive,
        ) {
        return $this->offreVisite->updateVisiteNonGuideeOffre(
            $id_offre,

        $nom_ville,
        $code_postal,

        $titre_offre,
        $en_ligne,
        $resume,
        $description,
        $accessibility,
        $type_offre,
        $prix_TCC_min,
        $tags, 

        $voie,
        $numero_adresse,
        $complement_adresse,

        $titre_image,
        $chemin_image,

        $jours,
        $matin_heure_debut,
        $matin_heure_fin,
        
        $id_professionnel,
        
        
        $duree,

        $apres_midi_heure_debut,
        $apres_midi_heure_fin,
        $prix_prive,
        );
    }
}