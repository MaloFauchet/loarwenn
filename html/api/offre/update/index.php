<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OffreController.php');

$controller = new OffreController();



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



//var_dump($_POST["tags"]);

//TODO json decode le body qui fournit un type et assigner le bon controller au bon type d'offre
//$controller = new OffreActivite();


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
    'info' => $_GET["id"],
    
]);