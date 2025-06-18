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


    //récupérer une offre par l'id de son professionel
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
                    OR ppp.id_utilisateur_public = :id_utilisateur and o.id_offre = :id_offre;"

        
            ;

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id_utilisateur' => $id_professionnel,
            ':id_offre' => $id_offre

        
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertOffreActivite($data)
    {
        try {
            // 1. Récupérer ou insérer la ville
            $nomVille = trim($data['lieu']); // Ex : "Paris"

            $codePostal = isset($data['code_postal']) && $data['code_postal'] !== '' ? trim($data['code_postal']) : '00000';


            // Chercher ville existante
            $sqlVille = "SELECT id_ville FROM tripenazor.ville WHERE nom_ville = :nomVille";
            $stmtVille = $this->conn->prepare($sqlVille);
            $stmtVille->bindParam(':nomVille', $nomVille);
            $stmtVille->execute();

            $ville = $stmtVille->fetch(PDO::FETCH_ASSOC);

            if ($ville) {
                $idVille = $ville['id_ville'];
            } else {
                // Insérer nouvelle ville
                $sqlInsertVille = "INSERT INTO tripenazor.ville (nom_ville, code_postal) VALUES (:nomVille, :codePostal)";
                $stmtInsertVille = $this->conn->prepare($sqlInsertVille);
                $stmtInsertVille->bindParam(':nomVille', $nomVille);
                $stmtInsertVille->bindParam(':codePostal', $codePostal);
                $stmtInsertVille->execute();
                $idVille = $this->conn->lastInsertId();
            }

            // 2. Insérer l'offre avec id_ville obtenu
            $sql = "INSERT INTO tripenazor.offre (
                        id_ville,
                        id_type_activite,
                        titre_offre,
                        note_moyenne,
                        nb_avis,
                        en_ligne,
                        resume,
                        description,
                        adresse_offre
                    ) VALUES (
                        :id_ville,
                        :id_type_activite,
                        :titre_offre,
                        :note_moyenne,
                        :nb_avis,
                        :en_ligne,
                        :resume,
                        :description,
                        :adresse_offre
                    )";

            $stmt = $this->conn->prepare($sql);

            // Lier les paramètres
            $stmt->bindParam(':id_ville', $idVille, PDO::PARAM_INT);
            $stmt->bindParam(':id_type_activite', $data['id_activite'], PDO::PARAM_INT);
            $stmt->bindParam(':titre_offre', $data['titre']);
            $stmt->bindValue(':note_moyenne', 0);
            $stmt->bindValue(':nb_avis', 0, PDO::PARAM_INT);
            $stmt->bindValue(':en_ligne', 1, PDO::PARAM_INT);
            $stmt->bindParam(':resume', $data['description']);
            $stmt->bindParam(':description', $data['description']);
            $adresseAleatoire = "123 Rue de la Paix, 75002 Paris";
            $stmt->bindParam(':adresse_offre', $adresseAleatoire);

            $stmt->execute();

            echo "Offre insérée avec succès.";

        } catch (PDOException $e) {
            echo "Erreur SQL : " . $e->getMessage();
        }
    }


    public function insertOffreSpectacle($data)
    {
        try {
            // 1. Récupérer ou insérer la ville
            $nomVille = trim($data['lieu']); // Ex : "Paris"

            $codePostal = isset($data['code_postal']) && $data['code_postal'] !== '' ? trim($data['code_postal']) : '00000';


            // Chercher ville existante
            $sqlVille = "SELECT id_ville FROM tripenazor.ville WHERE nom_ville = :nomVille";
            $stmtVille = $this->conn->prepare($sqlVille);
            $stmtVille->bindParam(':nomVille', $nomVille);
            $stmtVille->execute();

            $ville = $stmtVille->fetch(PDO::FETCH_ASSOC);

            if ($ville) {
                $idVille = $ville['id_ville'];
            } else {
                // Insérer nouvelle ville
                $sqlInsertVille = "INSERT INTO tripenazor.ville (nom_ville, code_postal) VALUES (:nomVille, :codePostal)";
                $stmtInsertVille = $this->conn->prepare($sqlInsertVille);
                $stmtInsertVille->bindParam(':nomVille', $nomVille);
                $stmtInsertVille->bindParam(':codePostal', $codePostal);
                $stmtInsertVille->execute();
                $idVille = $this->conn->lastInsertId();
            }

            // 2. Insérer l'offre avec id_ville obtenu
            $sql = "INSERT INTO tripenazor.offre (
                        id_ville,
                        id_type_activite,
                        titre_offre,
                        note_moyenne,
                        nb_avis,
                        en_ligne,
                        resume,
                        description,
                        adresse_offre
                    ) VALUES (
                        :id_ville,
                        :id_type_activite,
                        :titre_offre,
                        :note_moyenne,
                        :nb_avis,
                        :en_ligne,
                        :resume,
                        :description,
                        :adresse_offre
                    )";

            $stmt = $this->conn->prepare($sql);

            // Lier les paramètres
            $stmt->bindParam(':id_ville', $idVille, PDO::PARAM_INT);
            $stmt->bindParam(':id_type_activite', $data['id_activite'], PDO::PARAM_INT);
            $stmt->bindParam(':titre_offre', $data['titre']);
            $stmt->bindValue(':note_moyenne', 0);
            $stmt->bindValue(':nb_avis', 0, PDO::PARAM_INT);
            $stmt->bindValue(':en_ligne', 1, PDO::PARAM_INT);
            $stmt->bindParam(':resume', $data['description']);
            $stmt->bindParam(':description', $data['description']);
            $adresseAleatoire = "123 Rue de la Paix, 75002 Paris";
            $stmt->bindParam(':adresse_offre', $adresseAleatoire);

            $stmt->execute();

            $idOffre = $this->conn->lastInsertId();

            // 3. Insérer dans offre_spectacle
            $sqlSpectacle = "INSERT INTO tripenazor.offre_spectacle (
                                id_offre,
                                duree,
                                accessibilite,
                                capacite_accueil,
                                prix
                            ) VALUES (
                                :id_offre,
                                :duree,
                                :accessibilite,
                                :capacite_accueil,
                                :prix
                            )";

            $stmtSpectacle = $this->conn->prepare($sqlSpectacle);
            $stmtSpectacle->bindParam(':id_offre', $idOffre, PDO::PARAM_INT);
            $stmtSpectacle->bindParam(':duree', $data['duree']);
            $stmtSpectacle->bindParam(':accessibilite', $data['accessibilite']);
            $stmtSpectacle->bindParam(':capacite_accueil', $data['capacite']);
            $stmtSpectacle->bindParam(':prix', $data['prix']);
            $stmtSpectacle->execute();

            echo "Offre et offre_spectacle insérées avec succès.";

        } catch (PDOException $e) {
            echo "Erreur SQL : " . $e->getMessage();
        }
    }


    
    public function insertOffreRestaurant($data)
    {
        try {
            // 1. Récupérer ou insérer la ville
            $nomVille = trim($data['lieu']); 

            $codePostal = isset($data['code_postal']) && $data['code_postal'] !== '' ? trim($data['code_postal']) : '00000';


            // Chercher ville existante
            $sqlVille = "SELECT id_ville FROM tripenazor.ville WHERE nom_ville = :nomVille";
            $stmtVille = $this->conn->prepare($sqlVille);
            $stmtVille->bindParam(':nomVille', $nomVille);
            $stmtVille->execute();

            $ville = $stmtVille->fetch(PDO::FETCH_ASSOC);

            if ($ville) {
                $idVille = $ville['id_ville'];
            } else {
                // Insérer nouvelle ville
                $sqlInsertVille = "INSERT INTO tripenazor.ville (nom_ville, code_postal) VALUES (:nomVille, :codePostal)";
                $stmtInsertVille = $this->conn->prepare($sqlInsertVille);
                $stmtInsertVille->bindParam(':nomVille', $nomVille);
                $stmtInsertVille->bindParam(':codePostal', $codePostal);
                $stmtInsertVille->execute();
                $idVille = $this->conn->lastInsertId();
            }

            // 2. Insérer l'offre avec id_ville obtenu
            $sql = "INSERT INTO tripenazor.offre (
                        id_ville,
                        id_type_activite,
                        titre_offre,
                        note_moyenne,
                        nb_avis,
                        en_ligne,
                        resume,
                        description,
                        adresse_offre
                    ) VALUES (
                        :id_ville,
                        :id_type_activite,
                        :titre_offre,
                        :note_moyenne,
                        :nb_avis,
                        :en_ligne,
                        :resume,
                        :description,
                        :adresse_offre
                    )";

            $stmt = $this->conn->prepare($sql);

            // Lier les paramètres
            $stmt->bindParam(':id_ville', $idVille, PDO::PARAM_INT);
            $stmt->bindParam(':id_type_activite', $data['id_activite'], PDO::PARAM_INT);
            $stmt->bindParam(':titre_offre', $data['titre']);
            $stmt->bindValue(':note_moyenne', 0);
            $stmt->bindValue(':nb_avis', 0, PDO::PARAM_INT);
            $stmt->bindValue(':en_ligne', 1, PDO::PARAM_INT);
            $stmt->bindParam(':resume', $data['description']);
            $stmt->bindParam(':description', $data['description']);
            $adresseAleatoire = "123 Rue de la Paix, 75002 Paris";
            $stmt->bindParam(':adresse_offre', $adresseAleatoire);

            $stmt->execute();

            $idOffre = $this->conn->lastInsertId();

            // 3. Insérer dans offre_spectacle
            $sqlRestauration = "INSERT INTO tripenazor.offre_restauration (
                            id_offre,
                            id_image,
                            gamme_prix
                        ) VALUES (
                            :id_offre,
                            :id_image,
                            :gamme_prix
                        )";

            $stmtRestauration = $this->conn->prepare($sqlRestauration);
            $stmtRestauration->bindParam(':id_offre', $idOffre, PDO::PARAM_INT);

            // Si aucune image n'est fournie, on passe NULL
            if (!empty($data['id_image'])) {
                $stmtRestauration->bindParam(':id_image', $data['id_image'], PDO::PARAM_INT);
            } else {
                $stmtRestauration->bindValue(':id_image', null, PDO::PARAM_NULL);
            }

            $stmtRestauration->bindParam(':gamme_prix', $data['gamme_prix']);

            $stmtRestauration->execute();

            echo "Offre et offre_restauration insérées avec succès.";

        } catch (PDOException $e) {
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