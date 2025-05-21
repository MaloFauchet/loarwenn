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

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
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
            o.titre_offre,
            o.resume,
            o.description,
            o.date_creation,
            o.adresse_offre,
            o.id_ville,
            o.en_ligne,
            o.note_moyenne,
            o.nb_avis,

            ville.nom as ville,
            ville.code_postal,

            img.chemin,

            ta.libelle_activite as type_activite,

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
            opa.age AS pa_age,

            orestau.gamme_prix AS restaurant_gamme_prix

            FROM tripenazor.offre as o

            JOIN tripenazor.ville as ville ON o.id_ville = ville.id_ville
            JOIN tripenazor.image_illustre_offre as iio ON o.id_offre = iio.id_offre
            JOIN tripenazor.image as img ON iio.id_image = img.id_image
            JOIN tripenazor.type_activite as ta ON o.id_type_activite = ta.id_type_activite

            LEFT JOIN tripenazor.offre_visite as ov ON o.id_offre = ov.id_offre
            LEFT JOIN tripenazor.offre_activite as oa ON o.id_offre = oa.id_offre
            LEFT JOIN tripenazor.offre_spectacle as os ON o.id_offre = os.id_offre
            LEFT JOIN tripenazor.offre_parc_attraction as opa ON o.id_offre = opa.id_offre
            LEFT JOIN tripenazor.offre_restauration as orestau ON o.id_offre = orestau.id_offre


            WHERE o.id_offre = :id
        ";    

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $result =  $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            switch ($result['type_activite']) {
                case 'Visite nature':
                    require_once(__DIR__ . '/../models/OffreVisite.php');
                    $offre = new OffreVisite();
                    break;
                case 'Activité':
                    require_once(__DIR__ . '/../models/OffreActivite.php');
                    $offre = new OffreActivite();
                    break;
                case 'Spectacle':
                    require_once(__DIR__ . '/../models/OffreSpectacle.php');
                    $offre = new OffreSpectacle();
                    break;
                case 'Parc d\'attraction':
                    require_once(__DIR__ . '/../models/OffreParcAttraction.php');
                    $offre = new OffreParcAttraction();
                    break;
                case 'Restaurant':
                    require_once(__DIR__ . '/../models/OffreRestaurant.php');
                    $offre = new OffreRestaurant();
                    break;

                default:
                    $offre = new Offre();
            }
            
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
                $offre->setCapacite($result['capacite']);
                $offre->setPrix($result['prix']);
            }else if($offre instanceof OffreParcAttraction) {
                $offre->setNbAttraction($result['pa_nb_attraction']);
                $offre->setMinAge($result['pa_age']);
            }elseif ($offre instanceof OffreRestaurant) {
                $offre->setGammePrix($result['restaurant_gamme_prix']);
            }
            
            /**
             * Setters de la classe mère
             */
            //Type
            $offre->setType($result['type_activite']);
            $offre->setId($result['id_offre']);
            $offre->setTitre($result['titre_offre']);
            $offre->setResume($result['resume']);
            $offre->setDescription($result['description']);
            $offre->setDateCreation($result['date_creation']);
            $offre->setAdresse($result['adresse_offre']);
            $offre->setEnLigne($result['en_ligne']);
            $offre->setType($result['type_activite']);
            $offre->setNoteMoyenne($result['note_moyenne']);
            $offre->setNbAvis($result['nb_avis']);
            $offre->setIdVille($result['ville']);

            return $offre;
        }
        return null;
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

}