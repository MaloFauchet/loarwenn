<?php
require_once($_SERVER['DOCUMENT_ROOT'] .  '/../models/OffreRestaurant.php');

class OffreRestaurantController {
    private $offre;

    public function __construct() {
        $this->offre = new OffreRestaurant();
    }

    public function updateRestaurantOffre(

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

        $titre_image_carte,
        $chemin_image_carte,
        $libelle_gamme_prix,

        $apres_midi_heure_debut,
        $apres_midi_heure_fin,
        $prix,
    ) {
        return $this->offre->updateRestaurantOffre(
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

            $titre_image_carte,
            $chemin_image_carte,
            $libelle_gamme_prix,

            $apres_midi_heure_debut,
            $apres_midi_heure_fin,
            $prix,
        );
    }

}
