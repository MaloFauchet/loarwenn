<?php
if (!isset($_GET['libelle'])) {
    http_response_code(400);
    echo "Paramètre manquant.";
    exit;
}

$libelle = $_GET['libelle'];
$sanitized = $_GET['sanitized'] ?? '';


// Nettoyage pour correspondance whitelist
$cleaned = preg_replace('/[^a-zA-Z]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $libelle));

$whitelist = [
    'Activite',
    'Spectacle',
    'VisiteGuidee',
    'ParcDattraction',
    'Restaurant'
];

if (!in_array($cleaned, $whitelist)) {
    http_response_code(403);
    echo "Accès refusé.";
    exit;
}

// Inclure les contrôleurs (nécessaire pour récupérer les tags)
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/TypeActiviteController.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/TagController.php');

$typeActiviteController = new TypeActiviteController();
$tagController = new TagController();

// Charger le fichier de composant
$filePath = $_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/ajouterOffre/ajouterOffre' . $cleaned . '.php';

if (file_exists($filePath)) {
    require $filePath;
} else {
    http_response_code(404);
    echo "Fichier introuvable.";
    exit;
}

