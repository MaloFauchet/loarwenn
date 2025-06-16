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
$controller = new ProfessionnelController();

$isEntreprisePrivee = $controller->estEntreprisePrivee($_SESSION['id_utilisateur']);

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
if (!isset($_POST['nom'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Paramètre manquant :  nom']);
    exit();
}

$nom = $_POST['nom'];

// Prenom Entreprise
if (!isset($_POST['prenom'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Paramètre manquant :  prenom']);
    exit();
}

$prenom = $_POST['prenom'];

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
// if (!isset($_POST['adresseEntreprise'])) {
//     http_response_code(400);
//     echo json_encode(['message' => 'Paramètre manquant :  adresseEntreprise']);
//     exit();
// }

// $adresse = $_POST['adresseEntreprise'];

// Numéro de l'adresse
if (!isset($_POST['numeroAdresse'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Paramètre manquant :  numeroAdresse']);
    exit();
}

$numeroAdresse = $_POST['numeroAdresse'];

// Voie de l'adresse
if (!isset($_POST['voieEntreprise'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Paramètre manquant :  voieEntreprise']);
    exit();
}

$voieEntreprise = $_POST['voieEntreprise'];

// Complément d'adresse
if (!isset($_POST['complementAdresseEntreprise'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Paramètre manquant :  complementAdresseEntreprise']);
    exit();
}

$complementAdresse = $_POST['complementAdresseEntreprise'];


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

if ($isEntreprisePrivee) {
    // SIREN
    if (!isset($_POST['sirenEntreprise'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Paramètre manquant :  sirenEntreprise']);
        exit();
    }

    $siren = $_POST['sirenEntreprise'];

    // RIB
    if (!isset($_POST['ribEntreprise'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Paramètre manquant :  ribEntreprise']);
        exit();
    }

    $rib = $_POST['ribEntreprise'];
}

// image
if (!isset($_POST['photoProfil'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Paramètre manquant :  photoProfil']);
    exit();
}

$photoProfil = $_POST['photoProfil'];
if ($photoProfil !== null) {
    // ecrire l'image dans le dossier images
    // recupere l'extension de l'image
    $extention = explode('/', explode(';', $photoProfil)[0])[1];
    $cheminImage = "/images/profils/" . $_SESSION["id_utilisateur"] . "." . $extention;
    $controller->updateImage($_SESSION['id_utilisateur'], $cheminImage);
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . $cheminImage, base64_decode(explode(',', $photoProfil)[1]));
}


if ($isEntreprisePrivee) {
    $controller->updateProfessionnelPrive(
        $_SESSION['id_utilisateur'],
        $nom,
        $prenom,
        $email,
        $numTelephone,
        $numeroAdresse,
        $voieEntreprise,
        $complementAdresse,
        $codePostal,
        $ville,
        $denominationEntreprise,
        $siren,
        $rib,
        $cheminImage
    );
} else {
    $controller->updateProfessionnelPublic(
        $_SESSION['id_utilisateur'],
        $nom,
        $prenom,
        $email,
        $numTelephone,
        $numeroAdresse,
        $voieEntreprise,
        $complementAdresse,
        $codePostal,
        $ville,
        $denominationEntreprise,
        $cheminImage
    );
}


// redirige vers la page de modification
// header('Location: /backOffice/profil/');