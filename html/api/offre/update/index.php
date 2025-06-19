<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OffreActiviteController.php');

$controller = new OffreActiviteController();



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

    //die(print_r($_POST));
    $controller->updateActiviteOffre(
    $_GET["id"],

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
    $_POST["matin_heure_debut"],
    $_POST["matin_heure_fin"],
    $_POST["apres_midi_heure_debut"],
    $_POST["apres_midi_heure_fin"],

    $_SESSION['id_utilisateur'],
    $_POST["prix"],
    //activite
    
    isset($_POST["prestationIncluse"]) ? $_POST["prestationIncluse"] : null,
    isset($_POST["prestationNonIncluse"]) ? $_POST["prestationNonIncluse"] : null,

    $_POST["duration"],
    $_POST["age"],
);
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
/*echo json_encode([
    'status' => 'OK',
    'message' => "Sauvegarde effectuée",
    'info' => $_GET["id"],
    
]);*/