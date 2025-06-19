<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OffreActiviteController.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OffreVisiteController.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OffreSpectacleController.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OffreRestaurantController.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OffreParcAttractionController.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OffreController.php');



$controllerActivite = new OffreActiviteController();
$controllerVisite = new OffreVisiteController();
$controllerSpectacle = new OffreSpectacleController();
$controllerRestaurant = new OffreRestaurantController();
$controllerParcAttraction = new OffreParcAttractionController();



// Met à jour les informations d'un professionnel
// Vérifie si l'utilisateur est connecté
// TODO : Vérifier si l'utilisateur est un professionnel

// suffisant ???
session_start();
if (!isset($_SESSION['id_utilisateur'])) {
    header('Location: /frontOffice/connexionPro.php');
    exit();
}



// Vérifie les données envoyées
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['message' => 'Méthode non authorisée']);
    exit();
}

//print_r($_POST["type_offre"]);

//var_dump($_POST["tags"]);

//TODO json decode le body qui fournit un type et assigner le bon controller au bon type d'offre
try{

    $horaire3 = ($_POST["horaire3"] !== 'null' && $_POST["horaire3"] !== '') ? $_POST["horaire3"] : null;
    $horaire4 = ($_POST["horaire4"] !== 'null' && $_POST["horaire4"] !== '') ? $_POST["horaire4"] : null;
    if ($_POST["type_offre"] === 'activite') {
        $controllerActivite->updateActiviteOffre(
        $_GET["id_offre"],

        $_POST["city"],
        $_POST["codePostal"],

        $_POST["title"],
        $_POST["enLigne"] ,
        $_POST["resume"],
        $_POST["description"],
        $_POST["accessibility"],
        $_POST["type_offre"],
        $_POST["prix_TTC_min"],
        isset($_POST["tags"]) ? $_POST["tags"] : null,

        $_POST["voie"],
        $_POST["numeroAdresse"],
        $_POST["complementAdresse"],
        
        $_POST["titre_image"],
        $_POST["chemin_image"],
        
        $_POST["joursOuverture"],
        $_POST["horaire1"],
        $_POST["horaire2"],

        $_SESSION['id_utilisateur'],
        //activite
        
        isset($_POST["prestationIncluse"]) ? $_POST["prestationIncluse"] : null,
        isset($_POST["prestationNonIncluse"]) ? $_POST["prestationNonIncluse"] : null,
        
        $_POST["duration"],
        $_POST["age"],
        
        $horaire3,  // corrigé ici
        $horaire4,

        $_POST["horaire3"],
        $_POST["horaire4"],
        $_POST["prix"],
        );
    } else if ($_POST["type_offre"] === 'restaurant') {
        $controllerRestaurant->updateRestaurantOffre(
            $_GET["id_offre"],

            $_POST["city"],
            $_POST["codePostal"],

            $_POST["title"],
            $_POST["enLigne"] ,
            $_POST["resume"],
            $_POST["description"],
            $_POST["accessibility"],
            $_POST["type_offre"],
            $_POST["prix_TTC_min"],
            isset($_POST["tags"]) ? $_POST["tags"] : null,

            $_POST["voie"],
            $_POST["numeroAdresse"],
            $_POST["complementAdresse"],
            
            $_POST["titre_image"],
            $_POST["chemin_image"],
            
            $_POST["joursOuverture"],
            $_POST["horaire1"],
            $_POST["horaire2"],

            $_SESSION['id_utilisateur'],

            isset($_POST["titre_image_carte"]) ? $_POST["titre_image_carte"] : null,
            isset($_POST["chemin_image_carte"]) ? $_POST["chemin_image_carte"] : null,
            isset($_POST["libelleGammePrix"]) ? $_POST["libelleGammePrix"] : null,
            
            $horaire3,  
            $horaire4,
            $_POST["prix"]
        );
    } else if ($_POST["type_offre"] === 'parc_attraction') {
        $controllerParcAttraction->updateParcAttractionOffre(
            $_GET["id_offre"],

            $_POST["city"],
            $_POST["codePostal"],

            $_POST["title"],
            $_POST["enLigne"] ,
            $_POST["resume"],
            $_POST["description"],
            $_POST["accessibility"],
            $_POST["type_offre"],
            $_POST["prix_TTC_min"],
            isset($_POST["tags"]) ? $_POST["tags"] : null,

            $_POST["voie"],
            $_POST["numeroAdresse"],
            $_POST["complementAdresse"],
            
            $_POST["titre_image"],
            $_POST["chemin_image"],
            
            $_POST["joursOuverture"],

            $_POST["horaire1"],

            $_POST["horaire2"],

            $_SESSION['id_utilisateur'],
            
            $_POST["nbAttractions"],
            $_POST["age"],
            isset($_POST["titre_image_parc"]) ? $_POST["titre_image_parc"] : null,
            isset($_POST["chemin_image_parc"]) ? $_POST["chemin_image_parc"] : null,

            $horaire3,  
            $horaire4,

            isset($_POST["prix"]) ? $_POST["prix"] : null,
        );
    } else if ($_POST["type_offre"] === 'visite_guidee') {
        $controllerVisite->updateVisiteOffre(
            $_GET["id_offre"],

            $_POST["city"],
            $_POST["codePostal"],

            $_POST["title"],
            $_POST["enLigne"] ,
            $_POST["resume"],
            $_POST["description"],
            $_POST["accessibility"],
            $_POST["type_offre"],
            $_POST["prix_TTC_min"],
            isset($_POST["tags"]) ? $_POST["tags"] : null,

            $_POST["voie"],
            $_POST["numeroAdresse"],
            $_POST["complementAdresse"],
            
            $_POST["titre_image"],
            $_POST["chemin_image"],
            
            $_POST["joursOuverture"],
            $_POST["horaire1"],
            $_POST["horaire2"],

            $_SESSION['id_utilisateur'],
            
            $_POST["duration"],
            isset($_POST["langues"]) ? $_POST["langues"] : null,

            $horaire3,  
            $horaire4,
            isset($_POST["prix"]) ? $_POST["prix"] : null,
        );
    }else if ($_POST["type_offre"] === 'visite_non_guidee') {
        # code...
        $controllerVisite->updateVisiteNonGuideeOffre(
            $_GET["id_offre"],

            $_POST["city"],
            $_POST["codePostal"],

            $_POST["title"],
            $_POST["enLigne"] ,
            $_POST["resume"],
            $_POST["description"],
            $_POST["accessibility"],
            $_POST["type_offre"],
            $_POST["prix_TTC_min"],
            isset($_POST["tags"]) ? $_POST["tags"] : null,

            $_POST["voie"],
            $_POST["numeroAdresse"],
            $_POST["complementAdresse"],
            
            $_POST["titre_image"],
            $_POST["chemin_image"],
            
            $_POST["joursOuverture"],
            $_POST["horaire1"],
            $_POST["horaire2"],

            $_SESSION['id_utilisateur'],

            isset($_POST["duration"]) ? $_POST["duration"] : null,

            $horaire3,
            $horaire4,
            isset($_POST["prix"]) ? $_POST["prix"] : null,
        );
    }
    else if ($_POST["type_offre"] === 'spectacle') {
        $controllerSpectacle->updateSpectacleOffre(
            $_GET["id_offre"],

            $_POST["city"],
            $_POST["codePostal"],

            $_POST["title"],
            $_POST["enLigne"] ,
            $_POST["resume"],
            $_POST["description"],
            $_POST["accessibility"],
            $_POST["type_offre"],
            $_POST["prix_TTC_min"],
            isset($_POST["tags"]) ? $_POST["tags"] : null,

            $_POST["voie"],
            $_POST["numeroAdresse"],
            $_POST["complementAdresse"],
            
            $_POST["titre_image"],
            $_POST["chemin_image"],
            
            $_POST["joursOuverture"],
            $_POST["horaire1"],
            $_POST["horaire2"],

            $_SESSION['id_utilisateur'],
            
            $_POST["duration"] ,
            $_POST["capaciteAccueil"],

            
            $horaire3,  
            $horaire4,
            isset($_POST["prix"]) ? $_POST["prix"] : null,

        );
    }elseif ($_POST["type_offre"] === 'restauration') {
        $controllerRestaurant->updateRestaurantOffre(
            $_GET["id_offre"],

            $_POST["city"],
            $_POST["codePostal"],

            $_POST["title"],
            $_POST["enLigne"] ,
            $_POST["resume"],
            $_POST["description"],
            $_POST["accessibility"],
            $_POST["type_offre"],
            $_POST["prix_TTC_min"],
            isset($_POST["tags"]) ? $_POST["tags"] : null,

            $_POST["voie"],
            $_POST["numeroAdresse"],
            $_POST["complementAdresse"],
            
            $_POST["titre_image"],
            $_POST["chemin_image"],
            
            $_POST["joursOuverture"],
            $_POST["horaire1"],
            $_POST["horaire2"],

            $_SESSION['id_utilisateur'],
            
            isset($_POST["titre_image_carte"]) ? $_POST["titre_image_carte"] : null,
            isset($_POST["chemin_image_carte"]) ? $_POST["chemin_image_carte"] : null,
            isset($_POST["libelleGammePrix"]) ? $_POST["libelleGammePrix"] : null,
            
            $horaire3,  
            $horaire4,
            isset($_POST["prix"]) ? $_POST["prix"] : null,
            
        );
    }
    else {
        throw new Error("Type d'offre non reconnu", 1);
    }
    //echo json_encode(['message' => $_POST["horaire3"]]); 
    //die(print_r($_POST));
    /*echo json_encode([
        'message' => $_POST,
    ]);*/


    




}catch (Error $e) {
    http_response_code(400);
    echo json_encode(['message' => 'Erreur dans les données envoyées : ' . $e->getMessage()]);
    exit();
}


function validateData($controller) {
    if (
        isset($_POST["title"]) && 
        isset($_POST["duration"]) &&
        isset($_POST["age"]) &&
        isset($_POST["location"]) &&
        isset($_POST["description"]) &&
        isset($_POST["resume"]) &&
        isset($_POST["accessibility"]) &&
        isset($_POST["enRelief"]) &&
        isset($_POST["aLaUne"]) &&
        isset($_POST["prestationIncluse"]) &&
        isset($_POST["prestationNonIncluse"]) &&
        isset($_POST["tags"]) 
    
    ) {
        //update offre
        $offre = $controller->updateOffre($_GET["id"],$_POST);
       if (isset($_POST["enRelief"])) {
            //créer une option
       }
       if (isset($_POST["aLaUne"])) {
            //créer une option
       }
    }else {
        throw new Error("Manque d'une valeur", 1);
        
    }
    
}

//validateData($controller);
echo json_encode([
    'status' => 'OK',
    'message' => "Sauvegarde effectuée",
    'info' => $_GET["id_offre"],
    
]);