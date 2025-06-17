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
    
    public function getOffreById($id_professionnel,$id_offre) {
        return $this->offre->getOffreById($id_professionnel,$id_offre);
    }
    public function getOffreByIdAccueil($id) {
        return $this->offre->getOffreByIdAccueil($id);
    }
    public function getViewOffreAccueil() {
        return $this->offre->getViewOffreAccueil();
    }
    //toString
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

    /*
    public function ajouterOffre($post, $files) {

        #die(print_r($post,true));

        
        
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


        // Générer un dossier unique pour l'offre
        $uniqueId = uniqid();
        $baseDir = $_SERVER['DOCUMENT_ROOT'] . '/images/offres/' . $uniqueId . '/';

        // Créer le dossier
        if (!is_dir($baseDir)) {
            mkdir($baseDir, 0755, true);
        }

        // Traitement de l'image principale
        $imagePrincipalePath = null;

        if (isset($files['imagePrincipale']) && $files['imagePrincipale']['error'] === UPLOAD_ERR_OK) {
            $tmpName = $files['imagePrincipale']['tmp_name'];
            $fileName = basename($files['imagePrincipale']['name']);

            $destination = $baseDir . $fileName;

            if (move_uploaded_file($tmpName, $destination)) {
                $imagePrincipalePath = $destination;
            }
        }

        //valeur pour la bdd
        $cheminImagePrincipale = $baseDir;
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

                    if (move_uploaded_file($tmpName, $destination)) {
                        $imagesSecondairesPaths[] = $destination;
                    }
                }
            }
        }

        //valeur pour la bdd
        $cheminImageSecondaire = $baseDir;


        //activite:1
        if($post['id_activite'] == 1) {

            
            
            $duree = trim($post['duree']);
            $age = trim($post['age']);
            $prestation_incluse  = trim($post['ajoutMultiple_1']);
            $prestation_non_incluse  = trim($post['ajoutMultiple_2']);

            
        
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
                
                
            ]);

            return ['success' => true];
        }
        //spectacle:2
        else if($post['id_activite'] == 2) {
            
            $duree = trim($post['duree']);
            $capacite_accueil  = trim($post['capacite']);
           


            
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
                
                
                
            ]);

            return ['success' => true];
        }

        


        //visite guidee:3
        else if($post['id_activite'] == 3) {
            
            
            
            $duree = trim($post['duree']);
            $langues = trim($post['langue-checkboxes']);
            
            
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
               
                
                
                
            ]);

            return ['success' => true];
        }

        //parc d'attraction:4
        else if($post['id_activite'] == 4) {
            
            

            $numero  = trim($post['numero']);
            $age  = trim($post['age']);

           // Traitement de l'image principale
            $carteParc = null;

            if (isset($files['imagePrincipale']) && $files['imagePrincipale']['error'] === UPLOAD_ERR_OK) {
                $tmpName = $files['imagePrincipale']['tmp_name'];
                $fileName = basename($files['imagePrincipale']['name']);

                $destination = $baseDir . $fileName;

                if (move_uploaded_file($tmpName, $destination)) {
                    $carteParc = $destination;
                }
            }

            //valeur pour la bdd
            $cheminCarteParc = $baseDir;
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
                
                
                
            ]);

            return ['success' => true];
        }


        //restaurant:5
        else if($post['id_activite'] == 5) {
            
            

            $gamme_prix  = trim($post['prix']);

           // Traitement de l'image principale
            $carteRestaurant = null;

            if (isset($files['imagePrincipale']) && $files['imagePrincipale']['error'] === UPLOAD_ERR_OK) {
                $tmpName = $files['imagePrincipale']['tmp_name'];
                $fileName = basename($files['imagePrincipale']['name']);

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
                
                
                
            ]);

            return ['success' => true];
        }

        //visite non guidee :6
        else if($post['id_activite'] == 6) {
            
            

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
                
                
                
            ]);

            return ['success' => true];
        }


        

        } {
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
    */
    
    public function getAllOffreByCategory($category) {
        return $this->offre->getAllOffreByCategory($category);
    }
}
