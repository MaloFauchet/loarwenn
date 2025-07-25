<?php
require_once($_SERVER['DOCUMENT_ROOT'] .  '/../models/OffreActivite.php');

class OffreActiviteController {
    private $offre;

    public function __construct() {
        $this->offre = new OffreActivite();
    }

    public function updateActiviteOffre(
        
        $id_offre,

        $nom_ville,
        $code_postal,
        
        $titre_offre,
        $enLigne,
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
        
        $prestationIncluse,
        $prestationNonIncluse,
        $duree,
        $age,
        
        $apres_midi_heure_debut,
        $apres_midi_heure_fin,
        $prix,
        ) {
        return $this->offre->updateActiviteOffre(
            $id_offre,

            $nom_ville,
            $code_postal,

            $titre_offre,
            $enLigne,
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
            
            $prestationIncluse,
            $prestationNonIncluse,
            
            $duree ,
            $age ,
            
            $apres_midi_heure_debut,
            $apres_midi_heure_fin,
            0.0,
        );
    }

}
