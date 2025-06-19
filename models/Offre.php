<?php
require_once($_SERVER['DOCUMENT_ROOT'] .  '/../config/Database.php');

class Offre {
    protected $conn;
    protected $id;
    protected $titre;
    protected $resume;
    protected $description;
    protected $dateCreation;
    protected $adresse;
    protected $enLigne;
    protected $type;
    protected $ville;
    protected $noteMoyenne;
    protected $nbAvis;
    protected $pathImage;
    protected $tags;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getOffreByIdAccueil($idOffre) {
        $sql = "
            SELECT * FROM tripenazor.infos_carte_offre as o
            WHERE o.id_offre = :idOffre;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':idOffre' => $idOffre]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


   
    /**
     * @id : id de l'offre
     * Récupère une offre  par son id
     * @return offre
     */
    public function getOffreById($id_professionnel,$id_offre) {
        $sql = "SELECT 
                o.*,

                -- Infos spécifiques selon le type
                ov.duree AS visite_duree,
                

                oa.duree AS activite_duree,
                oa.age AS activite_age,
                

                os.duree AS spectacle_duree,
                
                os.capacite_accueil AS spectacle_capacite,
                

                opa.nb_attraction AS pa_nb_attraction,
                opa.age_min AS pa_age_min,

                orestau.id_gamme_prix ,
				gp.libelle_gamme_prix AS restaurant_gamme_prix,
                tripenazor.get_langue_by_offre(o.id_offre) AS langue,
				tripenazor.get_prestation_incluses_by_offre(o.id_offre) as prestation_incluses,
				tripenazor.get_prestation_non_incluses_by_offre(o.id_offre) as prestation_non_incluses,
				


                -- Pro info
                COALESCE(pp.denomination, pu.raison_sociale) AS nom_societe,
                COALESCE(a.id_utilisateur_prive, ppp.id_utilisateur_public) AS id_professionnel,
                pro.lien_site_web AS site_web,
				pp.denomination as denomination,
				pu.raison_sociale as raison_sociale,
                util.nom AS nom_utilisateur,
                util.prenom AS prenom,
                util.email AS email_utilisateur,
                util.num_telephone AS telephone_utilisateur,
				tripenazor.get_images_by_offre(o.id_offre) as images,
				tripenazor.get_horaires_by_offre(o.id_offre) as horaires


                FROM tripenazor.infos_carte_offre_with_offline o

                -- Type spécifique
                LEFT JOIN tripenazor.offre_visite ov ON ov.id_offre = o.id_offre
                LEFT JOIN tripenazor.offre_activite oa ON oa.id_offre = o.id_offre
                LEFT JOIN tripenazor.offre_spectacle os ON os.id_offre = o.id_offre
                LEFT JOIN tripenazor.offre_parc_attraction opa ON opa.id_offre = o.id_offre
                LEFT JOIN tripenazor.offre_restauration orestau ON orestau.id_offre = o.id_offre
                

				-- gamme de prix
                LEFT JOIN tripenazor.gamme_prix gp ON orestau.id_gamme_prix = gp.id_gamme_prix

                -- Pro linkage
                LEFT JOIN tripenazor.abonnement a ON a.id_offre = o.id_offre
                LEFT JOIN tripenazor.pro_public_propose_offre ppp ON ppp.id_offre = o.id_offre
                LEFT JOIN tripenazor.professionnel p 
                    ON p.id_utilisateur = a.id_utilisateur_prive OR p.id_utilisateur = ppp.id_utilisateur_public
                LEFT JOIN tripenazor.professionnel_prive pp ON pp.id_utilisateur = p.id_utilisateur
                LEFT JOIN tripenazor.professionnel_public pu ON pu.id_utilisateur = p.id_utilisateur
                LEFT JOIN tripenazor.professionnel pro ON pro.id_utilisateur = COALESCE(a.id_utilisateur_prive, ppp.id_utilisateur_public)
                LEFT JOIN tripenazor.utilisateur util ON util.id_utilisateur = COALESCE(a.id_utilisateur_prive, ppp.id_utilisateur_public)

                -- Filtrage
                WHERE 
                    a.id_utilisateur_prive = :id_utilisateur
                    OR ppp.id_utilisateur_public = :id_utilisateur and o.id_offre = :id_offre;";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id_utilisateur' => $id_professionnel,
            ':id_offre' => $id_offre
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProByOffre($idOffre){
        $sql = "
            SELECT
			p.id_utilisateur,
			i.chemin

			FROM tripenazor.professionnel p
			JOIN tripenazor.utilisateur_represente_image uimg ON uimg.id_utilisateur = p.id_utilisateur
			JOIN tripenazor.image i ON i.id_image = uimg.id_image
			
			WHERE p.id_utilisateur;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id_offre' => $this->id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //récupérer une offre par l'id de son professionel
    public function getOffreByIdProfessionnel($id_professionnel) {
        $sql = "SELECT 
            o.*,
            COALESCE(a.id_utilisateur_prive, ppp.id_utilisateur_public) AS id_professionnel
            FROM tripenazor.infos_carte_offre_with_offline o
            LEFT JOIN tripenazor.abonnement a ON a.id_offre = o.id_offre
            LEFT JOIN tripenazor.pro_public_propose_offre ppp ON ppp.id_offre = o.id_offre
            WHERE 
                a.id_utilisateur_prive = :id_utilisateur
                OR ppp.id_utilisateur_public = :id_utilisateur
            "
        
            ;

        $stmt = $this->conn->prepare($sql); 
        $stmt->execute([':id_utilisateur' => $id_professionnel]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function formatArrayToPostgresText($array) {
        if (!is_array($array)) {
            return '{}';
        }

        $escaped = array_map(function($item) {
            return '"' . addslashes($item) . '"';
        }, $array);

        return '{' . implode(',', $escaped) . '}';
    }


    //récupérer une offre par l'id de son professionel
    

    public function insertOffreActivite($data)
    {
        $joursTexte = $data['jours'];
        $joursMap = [
            "Lundi" => 1,
            "Mardi" => 2,
            "Mercredi" => 3,
            "Jeudi" => 4,
            "Vendredi" => 5,
            "Samedi" => 6,
            "Dimanche" => 7
        ];
        $joursNumeriques = array_map(function($jour) use ($joursMap) {
            return $joursMap[$jour] ?? null;
        }, $joursTexte);

        try {
            $sql = "
            SELECT tripenazor.inserer_offre_activite(
                :p_nom_ville::TEXT,   
                :p_code_postal::TEXT,
                :p_titre_offre::TEXT,
                :p_en_ligne::BOOLEAN,
                :p_resume::TEXT,
                :p_description::TEXT,
                :p_accessibilite::TEXT,
                :p_type_offre::tripenazor.type_activite,
                :p_prix_TCC_min::FLOAT,
                :p_tags::TEXT[],
                :p_voie::TEXT,
                :p_numero_adresse::INT,
                :p_complement_adresse::TEXT,
                :p_titre_image::TEXT,
                :p_chemin_image::TEXT,
                :p_titre_image_secondaire::TEXT[],
                :p_chemin_image_secondaire::TEXT[],
                :p_jours::NUMERIC[],
                :p_matin_heure_debut::TIME,
                :p_matin_heure_fin::TIME,
                :p_apres_midi_heure_debut::TIME,
                :p_apres_midi_heure_fin::TIME,
                :p_id_professionnel::INT,

                :p_prestations_incluses::TEXT[],
                :p_prestations_non_incluses::TEXT[],
                :p_duree::TIME,
                :p_age::INT,
                :p_prix_prive::FLOAT    
            );
        ";

        $stmt = $this->conn->prepare($sql);

      
        $stmt->bindValue(':p_nom_ville', $data['nom_ville'], PDO::PARAM_STR);
        $stmt->bindValue(':p_code_postal', $data['code_postal'], PDO::PARAM_STR);
        $stmt->bindValue(':p_titre_offre',$data['titre_offre'] );
        $stmt->bindValue(':p_en_ligne', false, PDO::PARAM_BOOL);
        $stmt->bindValue(':p_resume', $data['resume'], PDO::PARAM_STR);
        $stmt->bindValue(':p_description', $data['description'], PDO::PARAM_STR);
        $stmt->bindValue(':p_accessibilite', $data['accessibilite'], PDO::PARAM_STR);
        $stmt->bindValue(':p_type_offre', $data['type'], PDO::PARAM_STR);
        $stmt->bindValue(':p_prix_TCC_min', $data['prixMin'], PDO::PARAM_STR);
        $stmt->bindValue(':p_tags', $this->formatArrayToPostgresText($data['tags']), PDO::PARAM_STR);
        $stmt->bindValue(':p_voie', $data['voie'], PDO::PARAM_STR);
        $stmt->bindValue(':p_numero_adresse', $data['numero_adresse'], PDO::PARAM_STR);
        $stmt->bindValue(':p_complement_adresse', $data['complement_adresse'], PDO::PARAM_STR);
        $stmt->bindValue(':p_titre_image', $data['nomImagePrincipale'], PDO::PARAM_STR);
        $stmt->bindValue(':p_chemin_image', $data['cheminImagePrincipale'], PDO::PARAM_STR);
        $stmt->bindValue(':p_titre_image_secondaire', $this->formatArrayToPostgresText($data['nomsImagesSecondaire']), PDO::PARAM_STR);
        $stmt->bindValue(':p_chemin_image_secondaire', $this->formatArrayToPostgresText($data['cheminImageSecondaire']), PDO::PARAM_STR);
        $stmt->bindValue(':p_jours', $this->formatArrayToPostgresText($joursNumeriques), PDO::PARAM_STR);
        $stmt->bindValue(':p_matin_heure_debut', $data['dateDebutMatin']);
        $stmt->bindValue(':p_matin_heure_fin', $data['dateFinMatin']);
        $stmt->bindValue(':p_apres_midi_heure_debut', $data['dateDebutApresMidi']);
        $stmt->bindValue(':p_apres_midi_heure_fin', $data['dateFinApresMidi']);
        $stmt->bindValue(':p_id_professionnel',$data['userId'] );
        $stmt->bindValue(':p_prestations_incluses', $this->formatArrayToPostgresText($data['prestation_incluse']));
        $stmt->bindValue(':p_prestations_non_incluses', $this->formatArrayToPostgresText($data['prestation_non_incluse']));
        $stmt->bindValue(':p_duree', $data['duree'], PDO::PARAM_INT);
        $stmt->bindValue(':p_age', $data['age_min'], PDO::PARAM_INT);
        $stmt->bindValue(':p_prix_prive', 0, PDO::PARAM_INT);

        // Exécution
        $stmt->execute();

       

        } catch (PDOException $e) {
            die(print_r($e->getMessage()));  
            echo "Erreur SQL : " . $e->getMessage();
        }
    }


    public function insertOffreSpectacle($data)
   {
        $joursTexte = $data['jours'];
        $joursMap = [
            "Lundi" => 1,
            "Mardi" => 2,
            "Mercredi" => 3,
            "Jeudi" => 4,
            "Vendredi" => 5,
            "Samedi" => 6,
            "Dimanche" => 7
        ];
        $joursNumeriques = array_map(function($jour) use ($joursMap) {
            return $joursMap[$jour] ?? null;
        }, $joursTexte);

        try {
            $sql = "
            SELECT tripenazor.inserer_offre_spectacle(
                :p_nom_ville::TEXT,   
                :p_code_postal::TEXT,
                :p_titre_offre::TEXT,
                :p_en_ligne::BOOLEAN,
                :p_resume::TEXT,
                :p_description::TEXT,
                :p_accessibilite::TEXT,
                :p_type_offre::tripenazor.type_activite,
                :p_prix_TCC_min::FLOAT,
                :p_tags::TEXT[],
                :p_voie::TEXT,
                :p_numero_adresse::INT,
                :p_complement_adresse::TEXT,
                :p_titre_image::TEXT,
                :p_chemin_image::TEXT,
                :p_titre_image_secondaire::TEXT[],
                :p_chemin_image_secondaire::TEXT[],
                :p_jours::NUMERIC[],
                :p_matin_heure_debut::TIME,
                :p_matin_heure_fin::TIME,
                :p_apres_midi_heure_debut::TIME,
                :p_apres_midi_heure_fin::TIME,
                :p_id_professionnel::INT,

                :p_duree::TIME,
                :p_capacite_accueil::FLOAT,
                :p_prix_prive::INT
            );
        ";

        $stmt = $this->conn->prepare($sql);

      
        $stmt->bindValue(':p_nom_ville', $data['nom_ville'], PDO::PARAM_STR);
        $stmt->bindValue(':p_code_postal', $data['code_postal'], PDO::PARAM_STR);
        $stmt->bindValue(':p_titre_offre',$data['titre_offre'] );
        $stmt->bindValue(':p_en_ligne', false, PDO::PARAM_BOOL);
        $stmt->bindValue(':p_resume', $data['resume'], PDO::PARAM_STR);
        $stmt->bindValue(':p_description', $data['description'], PDO::PARAM_STR);
        $stmt->bindValue(':p_accessibilite', $data['accessibilite'], PDO::PARAM_STR);
        $stmt->bindValue(':p_type_offre', $data['type'], PDO::PARAM_STR);
        $stmt->bindValue(':p_prix_TCC_min', $data['prixMin'], PDO::PARAM_STR);
        $stmt->bindValue(':p_tags', $this->formatArrayToPostgresText($data['tags']), PDO::PARAM_STR);
        $stmt->bindValue(':p_voie', $data['voie'], PDO::PARAM_STR);
        $stmt->bindValue(':p_numero_adresse', $data['numero_adresse'], PDO::PARAM_STR);
        $stmt->bindValue(':p_complement_adresse', $data['complement_adresse'], PDO::PARAM_STR);
        $stmt->bindValue(':p_titre_image', $data['nomImagePrincipale'], PDO::PARAM_STR);
        $stmt->bindValue(':p_chemin_image', $data['cheminImagePrincipale'], PDO::PARAM_STR);
        $stmt->bindValue(':p_titre_image_secondaire', $this->formatArrayToPostgresText($data['nomsImagesSecondaire']), PDO::PARAM_STR);
        $stmt->bindValue(':p_chemin_image_secondaire', $this->formatArrayToPostgresText($data['cheminImageSecondaire']), PDO::PARAM_STR);
        $stmt->bindValue(':p_jours', $this->formatArrayToPostgresText($joursNumeriques), PDO::PARAM_STR);
        $stmt->bindValue(':p_matin_heure_debut', $data['dateDebutMatin'], PDO::PARAM_STR);
        $stmt->bindValue(':p_matin_heure_fin', $data['dateFinMatin'], PDO::PARAM_STR);
        $stmt->bindValue(':p_apres_midi_heure_debut', $data['dateDebutApresMidi'], PDO::PARAM_STR);
        $stmt->bindValue(':p_apres_midi_heure_fin', $data['dateFinApresMidi'], PDO::PARAM_STR);
        $stmt->bindValue(':p_id_professionnel',$data['userId'] );
        $stmt->bindValue(':p_duree', $data['duree'], PDO::PARAM_INT);
        $stmt->bindValue(':p_capacite_accueil', $data['capacite_accueil'], PDO::PARAM_INT);
        $stmt->bindValue(':p_prix_prive', 0, PDO::PARAM_INT);

        // Exécution
        $stmt->execute();

       

        } catch (PDOException $e) {
            die(print_r($$e->getMessage()));  
            echo "Erreur SQL : " . $e->getMessage();
        }
    }

    public function insertOffreVisiteGuidee($data)
   {
        $joursTexte = $data['jours'];
        $joursMap = [
            "Lundi" => 1,
            "Mardi" => 2,
            "Mercredi" => 3,
            "Jeudi" => 4,
            "Vendredi" => 5,
            "Samedi" => 6,
            "Dimanche" => 7
        ];
        $joursNumeriques = array_map(function($jour) use ($joursMap) {
            return $joursMap[$jour] ?? null;
        }, $joursTexte);

        try {
            $sql = "
            SELECT tripenazor.inserer_offre_visite_guidee(
                :p_nom_ville::TEXT,   
                :p_code_postal::TEXT,
                :p_titre_offre::TEXT,
                :p_en_ligne::BOOLEAN,
                :p_resume::TEXT,
                :p_description::TEXT,
                :p_accessibilite::TEXT,
                :p_type_offre::tripenazor.type_activite,
                :p_prix_TCC_min::FLOAT,
                :p_tags::TEXT[],
                :p_voie::TEXT,
                :p_numero_adresse::INT,
                :p_complement_adresse::TEXT,
                :p_titre_image::TEXT,
                :p_chemin_image::TEXT,
                :p_titre_image_secondaire::TEXT[],
                :p_chemin_image_secondaire::TEXT[],
                :p_jours::NUMERIC[],
                :p_matin_heure_debut::TIME,
                :p_matin_heure_fin::TIME,
                :p_apres_midi_heure_debut::TIME,
                :p_apres_midi_heure_fin::TIME,
                :p_id_professionnel::INT,

                :p_duree::TIME,
                :p_langues::TEXT[],
                

                :p_prix_prive::INT
    
            );
        ";

        $stmt = $this->conn->prepare($sql);

      
        $stmt->bindValue(':p_nom_ville', $data['nom_ville'], PDO::PARAM_STR);
        $stmt->bindValue(':p_code_postal', $data['code_postal'], PDO::PARAM_STR);
        $stmt->bindValue(':p_titre_offre',$data['titre_offre'] );
        $stmt->bindValue(':p_en_ligne', false, PDO::PARAM_BOOL);
        $stmt->bindValue(':p_resume', $data['resume'], PDO::PARAM_STR);
        $stmt->bindValue(':p_description', $data['description'], PDO::PARAM_STR);
        $stmt->bindValue(':p_accessibilite', $data['accessibilite'], PDO::PARAM_STR);
        $stmt->bindValue(':p_type_offre', $data['type'], PDO::PARAM_STR);
        $stmt->bindValue(':p_prix_TCC_min', $data['prixMin'], PDO::PARAM_STR);
        $stmt->bindValue(':p_tags', $this->formatArrayToPostgresText($data['tags']), PDO::PARAM_STR);
        $stmt->bindValue(':p_voie', $data['voie'], PDO::PARAM_STR);
        $stmt->bindValue(':p_numero_adresse', $data['numero_adresse'], PDO::PARAM_STR);
        $stmt->bindValue(':p_complement_adresse', $data['complement_adresse'], PDO::PARAM_STR);
        $stmt->bindValue(':p_titre_image', $data['nomImagePrincipale'], PDO::PARAM_STR);
        $stmt->bindValue(':p_chemin_image', $data['cheminImagePrincipale'], PDO::PARAM_STR);
        $stmt->bindValue(':p_titre_image_secondaire', $this->formatArrayToPostgresText($data['nomsImagesSecondaire']), PDO::PARAM_STR);
        $stmt->bindValue(':p_chemin_image_secondaire', $this->formatArrayToPostgresText($data['cheminImageSecondaire']), PDO::PARAM_STR);
        $stmt->bindValue(':p_jours', $this->formatArrayToPostgresText($joursNumeriques), PDO::PARAM_STR);
        $stmt->bindValue(':p_matin_heure_debut', $data['dateDebutMatin'], PDO::PARAM_STR);
        $stmt->bindValue(':p_matin_heure_fin', $data['dateFinMatin'], PDO::PARAM_STR);
        $stmt->bindValue(':p_apres_midi_heure_debut', $data['dateDebutApresMidi'], PDO::PARAM_STR);
        $stmt->bindValue(':p_apres_midi_heure_fin', $data['dateFinApresMidi'], PDO::PARAM_STR);
        $stmt->bindValue(':p_id_professionnel',$data['userId'] );
        $stmt->bindValue(':p_prix_prive', 0, PDO::PARAM_INT);

        $stmt->bindValue(':p_duree', $data['duree'], PDO::PARAM_INT);
        $stmt->bindValue(':p_langues', $this->formatArrayToPostgresText($data['langues']), PDO::PARAM_STR);


        // Exécution
        $stmt->execute();

       

        } catch (PDOException $e) {
            die(print_r($$e->getMessage()));  
            echo "Erreur SQL : " . $e->getMessage();
        }
    }

    public function insertOffreParc($data)
   {
        $joursTexte = $data['jours'];
        $joursMap = [
            "Lundi" => 1,
            "Mardi" => 2,
            "Mercredi" => 3,
            "Jeudi" => 4,
            "Vendredi" => 5,
            "Samedi" => 6,
            "Dimanche" => 7
        ];
        $joursNumeriques = array_map(function($jour) use ($joursMap) {
            return $joursMap[$jour] ?? null;
        }, $joursTexte);

        try {
            $sql = "
            SELECT tripenazor.inserer_offre_parc_attration(
                :p_nom_ville::TEXT,   
                :p_code_postal::TEXT,
                :p_titre_offre::TEXT,
                :p_en_ligne::BOOLEAN,
                :p_resume::TEXT,
                :p_description::TEXT,
                :p_accessibilite::TEXT,
                :p_type_offre::tripenazor.type_activite,
                :p_prix_TCC_min::FLOAT,
                :p_tags::TEXT[],
                :p_voie::TEXT,
                :p_numero_adresse::INT,
                :p_complement_adresse::TEXT,
                :p_titre_image::TEXT,
                :p_chemin_image::TEXT,
                :p_titre_image_secondaire::TEXT[],
                :p_chemin_image_secondaire::TEXT[],
                :p_jours::NUMERIC[],
                :p_matin_heure_debut::TIME,
                :p_matin_heure_fin::TIME,
                :p_apres_midi_heure_debut::TIME,
                :p_apres_midi_heure_fin::TIME,
                :p_id_professionnel::INT,

                :p_nb_attractions::INT,
                :p_age_min::INT,
                :p_titre_image_parc::TEXT,
                :p_chemin_image_parc::TEXT,
            
                :p_prix_prive::INT
                
            );
        ";

        $stmt = $this->conn->prepare($sql);

      
        $stmt->bindValue(':p_nom_ville', $data['nom_ville'], PDO::PARAM_STR);
        $stmt->bindValue(':p_code_postal', $data['code_postal'], PDO::PARAM_STR);
        $stmt->bindValue(':p_titre_offre',$data['titre_offre'] );
        $stmt->bindValue(':p_en_ligne', false, PDO::PARAM_BOOL);
        $stmt->bindValue(':p_resume', $data['resume'], PDO::PARAM_STR);
        $stmt->bindValue(':p_description', $data['description'], PDO::PARAM_STR);
        $stmt->bindValue(':p_accessibilite', $data['accessibilite'], PDO::PARAM_STR);
        $stmt->bindValue(':p_type_offre', $data['type'], PDO::PARAM_STR);
        $stmt->bindValue(':p_prix_TCC_min', $data['prixMin'], PDO::PARAM_STR);
        $stmt->bindValue(':p_tags', $this->formatArrayToPostgresText($data['tags']), PDO::PARAM_STR);
        $stmt->bindValue(':p_voie', $data['voie'], PDO::PARAM_STR);
        $stmt->bindValue(':p_numero_adresse', $data['numero_adresse'], PDO::PARAM_STR);
        $stmt->bindValue(':p_complement_adresse', $data['complement_adresse'], PDO::PARAM_STR);
        $stmt->bindValue(':p_titre_image', $data['nomImagePrincipale'], PDO::PARAM_STR);
        $stmt->bindValue(':p_chemin_image', $data['cheminImagePrincipale'], PDO::PARAM_STR);
        $stmt->bindValue(':p_titre_image_secondaire', $this->formatArrayToPostgresText($data['nomsImagesSecondaire']), PDO::PARAM_STR);
        $stmt->bindValue(':p_chemin_image_secondaire', $this->formatArrayToPostgresText($data['cheminImageSecondaire']), PDO::PARAM_STR);
        $stmt->bindValue(':p_jours', $this->formatArrayToPostgresText($joursNumeriques), PDO::PARAM_STR);
        $stmt->bindValue(':p_matin_heure_debut', $data['dateDebutMatin'], PDO::PARAM_STR);
        $stmt->bindValue(':p_matin_heure_fin', $data['dateFinMatin'], PDO::PARAM_STR);
        $stmt->bindValue(':p_apres_midi_heure_debut', $data['dateDebutApresMidi'], PDO::PARAM_STR);
        $stmt->bindValue(':p_apres_midi_heure_fin', $data['dateFinApresMidi'], PDO::PARAM_STR);
        $stmt->bindValue(':p_id_professionnel',$data['userId'] );
        $stmt->bindValue(':p_prix_prive', 0, PDO::PARAM_INT);

        $stmt->bindValue(':p_chemin_image_parc', $data['cheminCarteParc'], PDO::PARAM_STR);
        $stmt->bindValue(':p_titre_image_parc', $data['nomCarteParc'], PDO::PARAM_STR);
        $stmt->bindValue(':p_nb_attractions', $data['numero'], PDO::PARAM_INT);
        $stmt->bindValue(':p_age_min', $data['age'], PDO::PARAM_INT);



        // Exécution
        $stmt->execute();

       

        } catch (PDOException $e) {
            die(print_r($$e->getMessage()));  
            echo "Erreur SQL : " . $e->getMessage();
        }
    }


    
    public function insertOffreRestaurant($data)
   {
        $joursTexte = $data['jours'];
        $joursMap = [
            "Lundi" => 1,
            "Mardi" => 2,
            "Mercredi" => 3,
            "Jeudi" => 4,
            "Vendredi" => 5,
            "Samedi" => 6,
            "Dimanche" => 7
        ];
        $joursNumeriques = array_map(function($jour) use ($joursMap) {
            return $joursMap[$jour] ?? null;
        }, $joursTexte);

        try {
            $sql = "
            SELECT tripenazor.inserer_offre_restauration(
                :p_nom_ville::TEXT,   
                :p_code_postal::TEXT,
                :p_titre_offre::TEXT,
                :p_en_ligne::BOOLEAN,
                :p_resume::TEXT,
                :p_description::TEXT,
                :p_accessibilite::TEXT,
                :p_type_offre::tripenazor.type_activite,
                :p_prix_TCC_min::FLOAT,
                :p_tags::TEXT[],
                :p_voie::TEXT,
                :p_numero_adresse::INT,
                :p_complement_adresse::TEXT,
                :p_titre_image::TEXT,
                :p_chemin_image::TEXT,
                :p_titre_image_secondaire::TEXT[],
                :p_chemin_image_secondaire::TEXT[],
                :p_jours::NUMERIC[],
                :p_matin_heure_debut::TIME,
                :p_matin_heure_fin::TIME,
                :p_apres_midi_heure_debut::TIME,
                :p_apres_midi_heure_fin::TIME,
                :p_id_professionnel::INT,

                :p_titre_image_carte::TEXT,
                :p_chemin_image_carte::TEXT,
                :p_libelle_gamme_prix::TEXT,

                :p_prix_prive::INT
                
            );
        ";

        $stmt = $this->conn->prepare($sql);

      
        $stmt->bindValue(':p_nom_ville', $data['nom_ville'], PDO::PARAM_STR);
        $stmt->bindValue(':p_code_postal', $data['code_postal'], PDO::PARAM_STR);
        $stmt->bindValue(':p_titre_offre',$data['titre_offre'] );
        $stmt->bindValue(':p_en_ligne', false, PDO::PARAM_BOOL);
        $stmt->bindValue(':p_resume', $data['resume'], PDO::PARAM_STR);
        $stmt->bindValue(':p_description', $data['description'], PDO::PARAM_STR);
        $stmt->bindValue(':p_accessibilite', $data['accessibilite'], PDO::PARAM_STR);
        $stmt->bindValue(':p_type_offre', $data['type'], PDO::PARAM_STR);
        $stmt->bindValue(':p_prix_TCC_min', $data['prixMin'], PDO::PARAM_STR);
        $stmt->bindValue(':p_tags', $this->formatArrayToPostgresText($data['tags']), PDO::PARAM_STR);
        $stmt->bindValue(':p_voie', $data['voie'], PDO::PARAM_STR);
        $stmt->bindValue(':p_numero_adresse', $data['numero_adresse'], PDO::PARAM_STR);
        $stmt->bindValue(':p_complement_adresse', $data['complement_adresse'], PDO::PARAM_STR);
        $stmt->bindValue(':p_titre_image', $data['nomImagePrincipale'], PDO::PARAM_STR);
        $stmt->bindValue(':p_chemin_image', $data['cheminImagePrincipale'], PDO::PARAM_STR);
        $stmt->bindValue(':p_titre_image_secondaire', $this->formatArrayToPostgresText($data['nomsImagesSecondaire']), PDO::PARAM_STR);
        $stmt->bindValue(':p_chemin_image_secondaire', $this->formatArrayToPostgresText($data['cheminImageSecondaire']), PDO::PARAM_STR);
        $stmt->bindValue(':p_jours', $this->formatArrayToPostgresText($joursNumeriques), PDO::PARAM_STR);
        $stmt->bindValue(':p_matin_heure_debut', $data['dateDebutMatin'], PDO::PARAM_STR);
        $stmt->bindValue(':p_matin_heure_fin', $data['dateFinMatin'], PDO::PARAM_STR);
        $stmt->bindValue(':p_apres_midi_heure_debut', $data['dateDebutApresMidi'], PDO::PARAM_STR);
        $stmt->bindValue(':p_apres_midi_heure_fin', $data['dateFinApresMidi'], PDO::PARAM_STR);
        $stmt->bindValue(':p_id_professionnel',$data['userId'] );
        $stmt->bindValue(':p_prix_prive', 0, PDO::PARAM_INT);

        $stmt->bindValue(':p_titre_image_carte', $data['nomCarteRestaurant'], PDO::PARAM_STR);
        $stmt->bindValue(':p_chemin_image_carte', $data['cheminCarteRestaurant'], PDO::PARAM_STR);
        $stmt->bindValue(':p_libelle_gamme_prix', $data['gamme_prix'], PDO::PARAM_STR);



        // Exécution
        $stmt->execute();

       

        } catch (PDOException $e) {
            die(print_r($$e->getMessage()));  
            echo "Erreur SQL : " . $e->getMessage();
        }
    }



    
    public function insertOffreVisiteNonGuidee($data)
   {
        $joursTexte = $data['jours'];
        $joursMap = [
            "Lundi" => 1,
            "Mardi" => 2,
            "Mercredi" => 3,
            "Jeudi" => 4,
            "Vendredi" => 5,
            "Samedi" => 6,
            "Dimanche" => 7
        ];
        $joursNumeriques = array_map(function($jour) use ($joursMap) {
            return $joursMap[$jour] ?? null;
        }, $joursTexte);

        try {
            $sql = "
            SELECT tripenazor.inserer_offre_visite_non_guidee(
                :p_nom_ville::TEXT,   
                :p_code_postal::TEXT,
                :p_titre_offre::TEXT,
                :p_en_ligne::BOOLEAN,
                :p_resume::TEXT,
                :p_description::TEXT,
                :p_accessibilite::TEXT,
                :p_type_offre::tripenazor.type_activite,
                :p_prix_TCC_min::FLOAT,
                :p_tags::TEXT[],
                :p_voie::TEXT,
                :p_numero_adresse::INT,
                :p_complement_adresse::TEXT,
                :p_titre_image::TEXT,
                :p_chemin_image::TEXT,
                :p_titre_image_secondaire::TEXT[],
                :p_chemin_image_secondaire::TEXT[],
                :p_jours::NUMERIC[],
                :p_matin_heure_debut::TIME,
                :p_matin_heure_fin::TIME,
                :p_apres_midi_heure_debut::TIME,
                :p_apres_midi_heure_fin::TIME,
                :p_id_professionnel::INT,

             
                :p_duree::TIME,
                
                :p_prix_prive::INT
                
            );
        ";

        $stmt = $this->conn->prepare($sql);

      
        $stmt->bindValue(':p_nom_ville', $data['nom_ville'], PDO::PARAM_STR);
        $stmt->bindValue(':p_code_postal', $data['code_postal'], PDO::PARAM_STR);
        $stmt->bindValue(':p_titre_offre',$data['titre_offre'] );
        $stmt->bindValue(':p_en_ligne', false, PDO::PARAM_BOOL);
        $stmt->bindValue(':p_resume', $data['resume'], PDO::PARAM_STR);
        $stmt->bindValue(':p_description', $data['description'], PDO::PARAM_STR);
        $stmt->bindValue(':p_accessibilite', $data['accessibilite'], PDO::PARAM_STR);
        $stmt->bindValue(':p_type_offre', $data['type'], PDO::PARAM_STR);
        $stmt->bindValue(':p_prix_TCC_min', $data['prixMin'], PDO::PARAM_STR);
        $stmt->bindValue(':p_tags', $this->formatArrayToPostgresText($data['tags']), PDO::PARAM_STR);
        $stmt->bindValue(':p_voie', $data['voie'], PDO::PARAM_STR);
        $stmt->bindValue(':p_numero_adresse', $data['numero_adresse'], PDO::PARAM_STR);
        $stmt->bindValue(':p_complement_adresse', $data['complement_adresse'], PDO::PARAM_STR);
        $stmt->bindValue(':p_titre_image', $data['nomImagePrincipale'], PDO::PARAM_STR);
        $stmt->bindValue(':p_chemin_image', $data['cheminImagePrincipale'], PDO::PARAM_STR);
        $stmt->bindValue(':p_titre_image_secondaire', $this->formatArrayToPostgresText($data['nomsImagesSecondaire']), PDO::PARAM_STR);
        $stmt->bindValue(':p_chemin_image_secondaire', $this->formatArrayToPostgresText($data['cheminImageSecondaire']), PDO::PARAM_STR);
        $stmt->bindValue(':p_jours', $this->formatArrayToPostgresText($joursNumeriques), PDO::PARAM_STR);
        $stmt->bindValue(':p_matin_heure_debut', $data['dateDebutMatin'], PDO::PARAM_STR);
        $stmt->bindValue(':p_matin_heure_fin', $data['dateFinMatin'], PDO::PARAM_STR);
        $stmt->bindValue(':p_apres_midi_heure_debut', $data['dateDebutApresMidi'], PDO::PARAM_STR);
        $stmt->bindValue(':p_apres_midi_heure_fin', $data['dateFinApresMidi'], PDO::PARAM_STR);
        $stmt->bindValue(':p_id_professionnel',$data['userId'] );
        $stmt->bindValue(':p_prix_prive', 0, PDO::PARAM_INT);

        $stmt->bindValue(':p_duree', $data['duree'], PDO::PARAM_INT);



        // Exécution
        $stmt->execute();

       

        } catch (PDOException $e) {
            die(print_r($$e->getMessage()));  
            echo "Erreur SQL : " . $e->getMessage();
        }
    }

    
    public function getAllOffreByLatest() {
        $sql = "
            SELECT * FROM tripenazor.infos_carte_offre 
            ORDER BY date_creation DESC;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOffre() {
        $sql = "
            SELECT * FROM tripenazor.infos_carte_offre            
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getViewOffreAccueil() {
        $sql = "
            SELECT * FROM tripenazor.infos_carte_offre
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProfessionnelByIdOffre($id_offre) {
        $sql = "
                SELECT 
                pu.raison_sociale,
                pp.denomination

                FROM tripenazor.professionnel p
                LEFT JOIN tripenazor.abonnement a ON p.id_utilisateur = a.id_utilisateur_prive
                LEFT JOIN tripenazor.pro_public_propose_offre pppo ON pppo.id_utilisateur_public = p.id_utilisateur
                LEFT JOIN tripenazor.professionnel_prive pp ON pp.id_utilisateur = p.id_utilisateur
                LEFT JOIN tripenazor.professionnel_public pu ON pu.id_utilisateur = p.id_utilisateur

                WHERE a.id_offre = :id_offre OR pppo.id_offre = :id_offre
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_offre', $id_offre);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result['raison_sociale'] != null){
            return $result['raison_sociale'];
        }else if($result['denomination'] != null){
            return $result['denomination'];
        }else{
            return false;
        }
    }

    public function getProfessionnelInformationsByIdOffre($id_offre) {
        $sql = "
            SELECT 
            *

            FROM tripenazor.professionnel p
            LEFT JOIN tripenazor.abonnement a ON p.id_utilisateur = a.id_utilisateur_prive
            LEFT JOIN tripenazor.pro_public_propose_offre pppo ON pppo.id_utilisateur_public = p.id_utilisateur
            LEFT JOIN tripenazor.professionnel_prive pp ON pp.id_utilisateur = p.id_utilisateur
            LEFT JOIN tripenazor.professionnel_public pu ON pu.id_utilisateur = p.id_utilisateur

            WHERE a.id_offre = :id_offre
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_offre', $id_offre);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    function publicationOffre($idOffre, $enRelief, $aLaUne, $nbSemaines) {
        $sql = "
            SELECT tripenazor.publication_offre(:idOffre, :enRelief, :aLaUne, :nbSemaines);
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idOffre', $idOffre);
        $stmt->bindParam(':enRelief', $enRelief, PDO::PARAM_BOOL);
        $stmt->bindParam(':aLaUne', $aLaUne, PDO::PARAM_BOOL);
        $stmt->bindParam(':nbSemaines', $nbSemaines, PDO::PARAM_INT);

        return $stmt->execute();
    }



    function dePublicationOffre($idOffre) {
        $sql = "
            UPDATE tripenazor.offre
            SET en_ligne = FALSE
            WHERE id_offre = :idOffre;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idOffre', $idOffre);

        return $stmt->execute();
    }
    



    /**
     * Setters
     */

    function setId($id) {
        $this->id = $id;
    }

    function setTitre($t) {
        $this->titre = $t;
    }

    function setResume($r) {
        $this->resume = $r;
    }

    function setDescription($d) {
        $this->description = $d;
    }

    function setDateCreation($dc) {
        $this->dateCreation = $dc;
    }

    function setAdresse($ad) {
        $this->adresse = $ad;
    }

    function setEnLigne($el) {
        $this->enLigne = $el;
    }

    function setType($t) {
        $this->type = $t;
    }

    function setNoteMoyenne($nm) {
        $this->noteMoyenne = $nm;
    }

    function setNbAvis($na) {
        $this->nbAvis = $na;
    }

    function setIdVille($v) {
        $this->ville = $v;
    }

    function setPathImage($pi) {
        $this->pathImage = $pi;
    }

    function setTag($t) {
        $this->tags[] = $t;
    }

    /**
     * Getters
     */

    function getId() {
        return $this->id;
    }

    function getTitre() {
        return $this->titre;
    }

    function getResume() {
        return $this->resume;
    }

    function getDescription() {
        return $this->description;
    }

    function getDateCreation() {
        return $this->dateCreation;
    }

    function getAdresse() {
        return $this->adresse;
    }

    function getEnLigne() {
        return $this->enLigne;
    }

    function getType() {
        return $this->type;
    }

    function getNoteMoyenne() {
        return $this->noteMoyenne;
    }

    function getNbAvis() {
        return $this->nbAvis;
    }

    function getVille() {
        return $this->ville;
    }

    function getPathImage() {
        return $this->pathImage;
    }

    function getTags() {
        return $this->tags;
    }
}