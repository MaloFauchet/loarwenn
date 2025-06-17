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

    //Retourne le nom de l'entreprise de l'offre
    public function getProfessionnelInformationsByIdOffre($id_offre){
        return $this->offre->getProfessionnelInformationsByIdOffre($id_offre);
    }


    public function getAllOffre() {
        return $this->offre->getAllOffre();
    }

    
    public function ajouterOffre($post, $files) {
        // echo "<pre>";
        // die(print_r($files));
        // echo "</pre>";
        
        
        //valeur pour la bdd    
        $titre = trim($post['titre'] ?? '');
        $prixMin = trim($post['prixMin'] ?? '');
        $dateDebutMatin = trim($post['dateDebutMatin'] ?? '');
        $dateFinMatin = trim($post['dateFinMatin'] ?? '');
        $dateDebutApresMidi = trim($post['dateDebutApresMidi'] ?? '');
        $dateFinApresMidi = trim($post['dateFinApresMidi'] ?? '');
        $description = trim($post['description'] ?? '');
        $resume = trim($post['resume'] ?? '');
        $accessibilite = trim($post['accessibilite'] ?? '');
        $ville = trim($post['ville'] ?? '');
        $codePostal = trim($post['codePostal'] ?? '');
        $numero = trim($post['numero'] ?? '');
        $voie = trim($post['voie'] ?? '');
        $complementAdresse = trim($post['complementAdresse'] ?? '');
        $a_la_une = trim($post['a_la_une'] ?? 0);
        $en_relief = trim($post['en_relief'] ?? 0);
        $jours = $post['jours'] ?? [];
        $tags = $post['tags'] ??[];
        $userId = $post['userId'] ?? null;


        // Générer un dossier unique pour l'offre
        $uniqueId = uniqid();
        $baseDir = $_SERVER['DOCUMENT_ROOT'] . '/images/offres/' . $uniqueId . '/';
        $baseDirBdd = '/images/offres/' . $uniqueId . '/';

        // Créer le dossier
        if (!is_dir($baseDir)) {
            mkdir($baseDir, 0755, true);
        }

        // Traitement de l'image principale
        $imagePrincipalePath = null;

        if (isset($files['imagePrincipale']) && $files['imagePrincipale']['error'] === UPLOAD_ERR_OK) {
            $tmpName = $files['imagePrincipale']['tmp_name'];
            $fileName = basename($files['imagePrincipale']['name']);

            $destination = $baseDir.$fileName;

            move_uploaded_file($tmpName, $destination);
                
        }

        

        //valeur pour la bdd
        $cheminImagePrincipale = $baseDirBdd.$fileName;
        $nomImagePrincipale = $fileName;

        // Traitement des images secondaires
        $imagesSecondairesPaths = [];

        //valeur pour la bdd
        $nomsImagesSecondaire  = [];

        if (isset($files['imagesSecondaires'])) {
            foreach ($files['imagesSecondaires']['tmp_name'] as $index => $tmpName) {
                if ($files['imagesSecondaires']['error'][$index] === UPLOAD_ERR_OK) {
                    $fileName = basename($files['imagesSecondaires']['name'][$index]);
                    array_push($nomsImagesSecondaire,$fileName);
                    $destination = $baseDir . $fileName;

                    move_uploaded_file($tmpName, $destination);
                    $cheminImageSecondaire[] = $baseDirBdd.$fileName;
                    
                }
            }
        }



        //activite:1
        if($post['id_activite'] == 1) {

            
            $type = "activite";
            $duree = trim($post['duree']);
            $age = trim($post['age']);
            $prestation_incluse  = $post['ajoutMultiple_1'];
            $prestation_non_incluse  = $post['ajoutMultiple_2'];

            
        
            // Insertion en BDD via le modèle
            $this->offre->insertOffreActivite([
                'titre_offre' => $titre,
                'prixMin' => $prixMin,
                'dateDebutMatin' => $dateDebutMatin,
                'dateFinMatin' => $dateFinMatin,
                'dateDebutApresMidi' => $dateDebutApresMidi,
                'dateFinApresMidi' => $dateFinApresMidi,
                'description' => $description,
                'resume' => $resume,
                'accessibilite' => $accessibilite,
                'nom_ville' => $ville,
                'code_postal' => $codePostal,
                'numero_adresse' => $numero,
                'voie' => $voie,
                'complement_adresse' => $complementAdresse,
                'a_la_une' => $a_la_une,
                'en_relief' => $en_relief,
                'jours' => $jours,
                'tags' => $tags,
                'cheminImagePrincipale' => $cheminImagePrincipale,
                'nomImagePrincipale' => $nomImagePrincipale,
                'cheminImageSecondaire' => $cheminImageSecondaire,
                'nomsImagesSecondaire' => $nomsImagesSecondaire,
                'id_activite' => $post['id_activite'],

                'duree' => $duree,
                'age_min' =>$age,
                'prestation_non_incluse' => $prestation_non_incluse,
                'prestation_incluse' => $prestation_incluse,

                'type' => $type,
                'userId' => $userId,
                
                
            ]);

            return ['success' => true];


        }
        //spectacle:2
        else if($post['id_activite'] == 2) {
            
            $duree = trim($post['duree']);
            $capacite_accueil  = trim($post['capacite']);
           
            $type = "spectacle";

            
            // Insertion en BDD via le modèle
            $this->offre->insertOffreSpectacle([
                'titre_offre' => $titre,
                'prixMin' => $prixMin,
                'dateDebutMatin' => $dateDebutMatin,
                'dateFinMatin' => $dateFinMatin,
                'dateDebutApresMidi' => $dateDebutApresMidi,
                'dateFinApresMidi' => $dateFinApresMidi,
                'description' => $description,
                'resume' => $resume,
                'accessibilite' => $accessibilite,
                'nom_ville' => $ville,
                'code_postal' => $codePostal,
                'numero_adresse' => $numero,
                'voie' => $voie,
                'complement_adresse' => $complementAdresse,
                'a_la_une' => $a_la_une,
                'en_relief' => $en_relief,
                'jours' => $jours,
                'tags' => $tags,
                'cheminImagePrincipale' => $cheminImagePrincipale,
                'nomImagePrincipale' => $nomImagePrincipale,
                'cheminImageSecondaire' => $cheminImageSecondaire,
                'nomsImagesSecondaire' => $nomsImagesSecondaire,
                'id_activite' => $post['id_activite'],

                'duree' => $duree,
                'capacite_accueil' =>$capacite_accueil,

                'type' => $type,

                'userId' => $userId,
                
                
                
            ]);

            return ['success' => true];
        }

        


        //visite guidee:3
        else if($post['id_activite'] == 3) {
            
            $type = "visite_guidee";
            
            $duree = trim($post['duree']);
            $langues = implode(', ', $post['langue']);
            
            
            // Insertion en BDD via le modèle
            $this->offre->insertOffreVisiteGuidee([
                'titre_offre' => $titre,
                'prixMin' => $prixMin,
                'dateDebutMatin' => $dateDebutMatin,
                'dateFinMatin' => $dateFinMatin,
                'dateDebutApresMidi' => $dateDebutApresMidi,
                'dateFinApresMidi' => $dateFinApresMidi,
                'description' => $description,
                'resume' => $resume,
                'accessibilite' => $accessibilite,
                'nom_ville' => $ville,
                'code_postal' => $codePostal,
                'numero_adresse' => $numero,
                'voie' => $voie,
                'complement_adresse' => $complementAdresse,
                'a_la_une' => $a_la_une,
                'en_relief' => $en_relief,
                'jours' => $jours,
                'tags' => $tags,
                'cheminImagePrincipale' => $cheminImagePrincipale,
                'nomImagePrincipale' => $nomImagePrincipale,
                'cheminImageSecondaire' => $cheminImageSecondaire,
                'nomsImagesSecondaire' => $nomsImagesSecondaire,
                'id_activite' => $post['id_activite'],

                'langues' => $langues,
                'duree' =>$duree,

                'userId' => $userId,
                'type' => $type,
               
                
                
                
            ]);

            return ['success' => true];
        }

        //parc d'attraction:4
        else if($post['id_activite'] == 4) {
            $type= "parc_attraction";
            

            $numero  = trim($post['numero']);
            $age  = trim($post['age']);

            // Traitement de la carte du parc
            $carteParc = null;

            if (isset($files['imagePlan']) && $files['imagePlan']['error'] === UPLOAD_ERR_OK) {
                $tmpName = $files['imagePlan']['tmp_name'];
                $fileName = basename($files['imagePlan']['name']);

                $destination = $baseDirBdd . $fileName;

                if (move_uploaded_file($tmpName, $destination)) {
                    $carteParc = $destination;
                }
            }

            //valeur pour la bdd
            $cheminCarteParc = $destination;
            $nomCarteParc = $fileName;
            
            
            // Insertion en BDD via le modèle
            $this->offre->insertOffreParc([
                'titre_offre' => $titre,
                'prixMin' => $prixMin,
                'dateDebutMatin' => $dateDebutMatin,
                'dateFinMatin' => $dateFinMatin,
                'dateDebutApresMidi' => $dateDebutApresMidi,
                'dateFinApresMidi' => $dateFinApresMidi,
                'description' => $description,
                'resume' => $resume,
                'accessibilite' => $accessibilite,
                'nom_ville' => $ville,
                'code_postal' => $codePostal,
                'numero_adresse' => $numero,
                'voie' => $voie,
                'complement_adresse' => $complementAdresse,
                'a_la_une' => $a_la_une,
                'en_relief' => $en_relief,
                'jours' => $jours,
                'tags' => $tags,
                'cheminImagePrincipale' => $cheminImagePrincipale,
                'nomImagePrincipale' => $nomImagePrincipale,
                'cheminImageSecondaire' => $cheminImageSecondaire,
                'nomsImagesSecondaire' => $nomsImagesSecondaire,
                'id_activite' => $post['id_activite'],

                'cheminCarteParc' => $cheminCarteParc,
                'nomCarteParc' =>$nomCarteParc,
                'numero' => $numero,
                'age' => $age,

                'userId' => $userId,
                'type' => $type,
                
                
                
            ]);

            return ['success' => true];
        }


        //restaurant:5
        else if($post['id_activite'] == 5) {
            
            $type = "restauration";

            $gamme_prix  = trim($post['prix']);

           // Traitement de l'image principale
            $carteRestaurant = null;

            if (isset($files['imagePlan']) && $files['imagePlan']['error'] === UPLOAD_ERR_OK) {
                $tmpName = $files['imagePlan']['tmp_name'];
                $fileName = basename($files['imagePlan']['name']);

                $destination = $baseDir . $fileName;

                if (move_uploaded_file($tmpName, $destination)) {
                    $carteRestaurant = $destination;
                }
            }

            //valeur pour la bdd
            $cheminCarteRestaurant = $baseDir;
            $nomCarteRestaurant = $fileName;
            
            
            // Insertion en BDD via le modèle
            $this->offre->insertOffreRestaurant([
                'titre_offre' => $titre,
                'prixMin' => $prixMin,
                'dateDebutMatin' => $dateDebutMatin,
                'dateFinMatin' => $dateFinMatin,
                'dateDebutApresMidi' => $dateDebutApresMidi,
                'dateFinApresMidi' => $dateFinApresMidi,
                'description' => $description,
                'resume' => $resume,
                'accessibilite' => $accessibilite,
                'nom_ville' => $ville,
                'code_postal' => $codePostal,
                'numero_adresse' => $numero,
                'voie' => $voie,
                'complement_adresse' => $complementAdresse,
                'a_la_une' => $a_la_une,
                'en_relief' => $en_relief,
                'jours' => $jours,
                'tags' => $tags,
                'cheminImagePrincipale' => $cheminImagePrincipale,
                'nomImagePrincipale' => $nomImagePrincipale,
                'cheminImageSecondaire' => $cheminImageSecondaire,
                'nomsImagesSecondaire' => $nomsImagesSecondaire,
                'id_activite' => $post['id_activite'],

                'cheminCarteRestaurant' => $cheminCarteRestaurant,
                'nomCarteRestaurant' =>$nomCarteRestaurant,
                'gamme_prix' => $gamme_prix,

                'userId' => $userId,
                'type' => $type,
                
                
            ]);

            return ['success' => true];
        }

        //visite non guidee :6
        else if($post['id_activite'] == 6) {
            
            $type= "visite_non_guidee";

            $duree  = trim($post['duree']);

           
            
            
            // Insertion en BDD via le modèle
            $this->offre->insertOffreVisiteNonGuidee([
                'titre_offre' => $titre,
                'prixMin' => $prixMin,
                'dateDebutMatin' => $dateDebutMatin,
                'dateFinMatin' => $dateFinMatin,
                'dateDebutApresMidi' => $dateDebutApresMidi,
                'dateFinApresMidi' => $dateFinApresMidi,
                'description' => $description,
                'resume' => $resume,
                'accessibilite' => $accessibilite,
                'nom_ville' => $ville,
                'code_postal' => $codePostal,
                'numero_adresse' => $numero,
                'voie' => $voie,
                'complement_adresse' => $complementAdresse,
                'a_la_une' => $a_la_une,
                'en_relief' => $en_relief,
                'jours' => $jours,
                'tags' => $tags,
                'cheminImagePrincipale' => $cheminImagePrincipale,
                'nomImagePrincipale' => $nomImagePrincipale,
                'cheminImageSecondaire' => $cheminImageSecondaire,
                'nomsImagesSecondaire' => $nomsImagesSecondaire,
                'id_activite' => $post['id_activite'],

                'duree' => $duree,

                'userId' => $userId,
                'type' => $type,
                
                
                
            ]);

            return ['success' => true];
        }


    }
    
    
    public function getAllOffreByCategory($category) {
        return $this->offre->getAllOffreByCategory($category);
    }
}
