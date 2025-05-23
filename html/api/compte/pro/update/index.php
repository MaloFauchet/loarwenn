<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/ProfessionnelController.php');

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

// denomination entreprise
if (!isset($_POST['denominationEntreprise'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Paramètre manquant :  denominationEntreprise']);
    exit();
}

$denominationEntreprise = $_POST['denominationEntreprise'];

// Nom Entreprise
if (!isset($_POST['nomEntreprise'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Paramètre manquant :  nomEntreprise']);
    exit();
}

$nomEntreprise = $_POST['nomEntreprise'];

// Numéro de téléphone
if (!isset($_POST['telephoneEntreprise'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Paramètre manquant :  telephoneEntreprise']);
    exit();
}

$numTelephone = $_POST['telephoneEntreprise'];

// Adresse mail
if (!isset($_POST['emailEntreprise'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Paramètre manquant :  emailEntreprise']);
    exit();
}

$email = $_POST['emailEntreprise'];

// Adresse
if (!isset($_POST['adresseEntreprise'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Paramètre manquant :  adresseEntreprise']);
    exit();
}

$adresse = $_POST['adresseEntreprise'];

// Complément d'adresse
if (!isset($_POST['complementAdresseEntreprise'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Paramètre manquant :  complementAdresseEntreprise']);
    exit();
}

$complementAdresse = $_POST['complementAdresseEntreprise'];

// Mot de passe
// if (!isset($_SESSION['motDePasse'])) {
//     http_response_code(400);
//     echo json_encode(['message' => 'Paramètre manquant :  motDePasse']);
//     exit();
// }

// $motDePasse = $_SESSION['mot_de_passe'];
$motDepasse = null;
// TODO : Prendre en compte le mot de passe

// Ville
if (!isset($_POST['villeEntreprise'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Paramètre manquant :  villeEntreprise']);
    exit();
}

$ville = $_POST['villeEntreprise'];

// Code postal
if (!isset($_POST['codePostalEntreprise'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Paramètre manquant :  codePostalEntreprise']);
    exit();
}

$codePostal = $_POST['codePostalEntreprise'];

// image
if (!isset($_POST['photoProfil'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Paramètre manquant :  photoProfil']);
    exit();
}

$photoProfil = $_POST['photoProfil'];
// ecrire l'image dans le dossier images
// recupere l'extension de l'image
$extention = explode('/', explode(';', $photoProfil)[0])[1];
$cheminImage = "/images/profils/" . $denominationEntreprise . "." . $extention;
echo $_POST['photoProfil'];
file_put_contents($_SERVER['DOCUMENT_ROOT'] . $cheminImage, base64_decode(explode(',', $photoProfil)[1]));
// TODO : enregistrer l'image dans la base de données


// redirectionne vers la page de modification
header('Location: /backOffice/profil/');