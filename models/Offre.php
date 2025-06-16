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
            SELECT * FROM tripenazor.offre 
            JOIN tripenazor.ville ON offre.id_ville = ville.id_ville 
            JOIN tripenazor.type_activite ON offre.id_type_activite = type_activite.id_type_activite
            JOIN tripenazor.image_illustre_offre ON offre.id_offre = image_illustre_offre.id_offre
            JOIN tripenazor.image ON image_illustre_offre.id_image = image.id_image
            WHERE offre.id_offre = :idOffre;
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
    public function getOffreById($id) {
        $sql = "
            SELECT 
            o.id_offre,
            o.id_ville,
            o.titre_offre,
            o.note_moyenne,
            o.nb_avis,
            o.resume,
            o.description,
            o.adresse_offre,

            ville.nom_ville as ville,

            img.chemin,

            ta.libelle_activite as type_activite,

            tag_agg.libelle_tag,

            ov.duree AS visite_duree,
            ov.accessibilite AS visite_accessibilite,

            oa.duree AS activite_duree,
            oa.age AS activite_age,
            oa.accessibilite AS activite_accessibilite,

            os.duree AS spectacle_duree,
            os.accessibilite AS spectacle_accessibilite,
            os.capacite_accueil AS spectacle_capacite,
            os.prix AS spectacle_prix,

            opa.nb_attraction AS pa_nb_attraction,
            opa.age_min AS pa_age_min,

            orestau.gamme_prix AS restaurant_gamme_prix

            FROM tripenazor.offre as o

            JOIN tripenazor.ville as ville ON o.id_ville = ville.id_ville
            JOIN tripenazor.image_illustre_offre as iio ON o.id_offre = iio.id_offre
            JOIN tripenazor.image as img ON iio.id_image = img.id_image
            JOIN tripenazor.type_activite as ta ON o.id_type_activite = ta.id_type_activite
            JOIN LATERAL (
                SELECT string_agg(t.libelle_tag, ', ') AS libelle_tag
                FROM tripenazor.type_activite_autorise_tag taot
                JOIN tripenazor.tag t ON taot.id_tag = t.id_tag
                WHERE taot.id_type_activite = o.id_type_activite
            ) AS tag_agg ON TRUE

            LEFT JOIN tripenazor.offre_visite as ov ON o.id_offre = ov.id_offre
            LEFT JOIN tripenazor.offre_activite as oa ON o.id_offre = oa.id_offre
            LEFT JOIN tripenazor.offre_spectacle as os ON o.id_offre = os.id_offre
            LEFT JOIN tripenazor.offre_parc_attraction as opa ON o.id_offre = opa.id_offre
            LEFT JOIN tripenazor.offre_restauration as orestau ON o.id_offre = orestau.id_offre

            WHERE o.id_offre = :id;

        ";    

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $result =  $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            switch ($result['type_activite']) {
                case 'Visite guidée':
                    require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/OffreVisite.php');
                    $offre = new OffreVisite();
                    break;
                case 'Visite non guidée':
                    require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/OffreVisite.php');
                    $offre = new OffreVisite();
                    break;
                case 'Activité':
                    require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/OffreActivite.php');
                    $offre = new OffreActivite();
                    break;
                case 'Spectacle':
                    require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/OffreSpectacle.php');
                    $offre = new OffreSpectacle();
                    break;
                case 'Parc d\'attraction':
                    require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/OffreParcAttraction.php');
                    $offre = new OffreParcAttraction();
                    break;
                case 'Restaurant':
                    require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/OffreRestaurant.php');
                    $offre = new OffreRestaurant();
                    break;

                default:
                    $offre = new Offre();
            }

            /**
             * Setters de la classe mère
             */

            //Recupération des tags
            foreach (explode(',', $result['libelle_tag']) as $tag) {
                $offre->setTag($tag);
            }
            //Type
            $offre->setType($result['type_activite']);
            $offre->setId($result['id_offre']);
            $offre->setTitre($result['titre_offre']);
            $offre->setResume($result['resume']);
            $offre->setDescription($result['description']);
            $offre->setAdresse($result['adresse_offre']);
            $offre->setType($result['type_activite']);
            $offre->setNoteMoyenne($result['note_moyenne']);
            $offre->setNbAvis($result['nb_avis']);
            $offre->setIdVille($result['ville']);
            $offre->setPathImage($result['chemin']);

            /**
             * Setters de la classe spécifique
             */
            if ($offre instanceof OffreVisite) {
                $offre->setDuree($result['visite_duree']);
                $offre->setAccessibilite($result['visite_accessibilite']);
            }elseif ($offre instanceof OffreActivite) {
                $offre->setDuree($result['activite_duree']);
                $offre->setAgeMin($result['activite_age']);
                $offre->setAccessibilite($result['activite_accessibilite']);
            }elseif ($offre instanceof OffreSpectacle) {
                $offre->setDuree($result['spectacle_duree']);
                $offre->setAccessibilite($result['spectacle_accessibilite']);
                $offre->setCapaciteAccueil($result['spectacle_capacite']);
                $offre->setPrix($result['spectacle_prix']);
            }else if($offre instanceof OffreParcAttraction) {
                $offre->setNbAttraction($result['pa_nb_attraction']);
                $offre->setAgeMin($result['pa_age_min']);
            }elseif ($offre instanceof OffreRestaurant) {
                $offre->setGammePrix($result['restaurant_gamme_prix']);
            }
            
            
            

            return $offre;
        }
        return null;
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

    public function getOffreByIdProfessionnel($id_professionnel) {
        $sql = "
            SELECT o.*, i.chemin AS image_chemin, i.titre_image
            FROM tripenazor.offre o
            JOIN tripenazor.abonnement a ON a.id_offre = o.id_offre
            JOIN tripenazor.professionnel p ON p.id_utilisateur = a.id_utilisateur_prive
            LEFT JOIN tripenazor.image_illustre_offre io ON io.id_offre = o.id_offre
            LEFT JOIN tripenazor.image i ON i.id_image = io.id_image
            WHERE p.id_utilisateur = :id_utilisateur;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id_utilisateur' => $id_professionnel]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            SELECT * FROM tripenazor.offre 
            JOIN tripenazor.ville ON offre.id_ville = ville.id_ville 
            JOIN tripenazor.type_activite ON offre.id_type_activite = type_activite.id_type_activite
            JOIN tripenazor.image_illustre_offre ON offre.id_offre = image_illustre_offre.id_offre
            JOIN tripenazor.image ON image_illustre_offre.id_image = image.id_image
            ORDER BY date_creation DESC;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOffre() {
        $sql = "
            SELECT * FROM tripenazor.offre 
            JOIN tripenazor.ville ON offre.id_ville = ville.id_ville 
            JOIN tripenazor.type_activite ON offre.id_type_activite = type_activite.id_type_activite
            JOIN tripenazor.image_illustre_offre ON offre.id_offre = image_illustre_offre.id_offre
            JOIN tripenazor.image ON image_illustre_offre.id_image = image.id_image
            
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOffreRecommande() {
        $sql = "
            SELECT * FROM tripenazor.offre 
            JOIN tripenazor.ville ON offre.id_ville = ville.id_ville 
            JOIN tripenazor.type_activite ON offre.id_type_activite = type_activite.id_type_activite
            JOIN tripenazor.image_illustre_offre ON offre.id_offre = image_illustre_offre.id_offre
            JOIN tripenazor.image ON image_illustre_offre.id_image = image.id_image
            JOIN tripenazor.option_payante_offre ON offre.id_offre = option_payante_offre.id_offre
            JOIN tripenazor.option ON option_payante_offre.id_offre = option.id_option
            JOIN tripenazor.souscription ON option_payante_offre.id_souscription = souscription.id_souscription
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOffreTag() {
        $sql = "
            SELECT offre.id_offre,libelle_tag FROM tripenazor.offre 
            JOIN tripenazor.offre_possede_tags ON offre.id_offre = offre_possede_tags.id_offre 
            JOIN tripenazor.tag ON offre_possede_tags.id_tag = tag.id_tag
            


        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getViewOffreAccueil() {
        $sql = "
            SELECT * FROM tripenazor.infos_offre_page_accueil
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