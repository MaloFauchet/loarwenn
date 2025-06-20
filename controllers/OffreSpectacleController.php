<?php
require_once($_SERVER['DOCUMENT_ROOT'] .  '/../models/OffreSpectacle.php');

class OffreSpectacleController {
    private $offre;

    public function __construct() {
        $this->offre = new OffreSpectacle();
    }

    public function updateSpectacleOffre(
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
        $capacite_accueil,
        
        $apres_midi_heure_debut,
        $apres_midi_heure_fin,
        $prix_prive,
    ) {
        return $this->offre->updateSpectacleOffre(
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
        $capacite_accueil,
        
        $apres_midi_heure_debut,
        $apres_midi_heure_fin,
        $prix_prive,
        );
    }

}
