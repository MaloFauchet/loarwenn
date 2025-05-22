<?php
if (!isset($_GET['libelle'])) {
    http_response_code(400);
    echo "Paramètre manquant.";
    exit;
}

$libelle = $_GET['libelle'];
$sanitized = $_GET['sanitized'] ?? '';

// Nettoyage du nom pour le fichier
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

// Chargement du fichier de composant selon l'activité
$filePath = $_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/ajouterOffre/ajouterOffre' . $cleaned . '.php';

if (file_exists($filePath)) {
    require $filePath;
} else {
    http_response_code(404);
    echo "Fichier introuvable.";
    exit;
}

// Récupération des tags associés à l'activité
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/TypeActiviteController.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/TagController.php');

$typeActiviteController = new TypeActiviteController();
$tagController = new TagController();

$id_tags = $typeActiviteController->getTagIdByTypeActivite($libelle);
$arrayIdTags = array_column($id_tags, 'id_tag');

if (!empty($arrayIdTags)) {
    $tags = $tagController->getAllTagByIdTagActivite($arrayIdTags);
    $tags = array_column($tags, 'libelle_tag');

    echo "<h4>Tags liés à l'activité : " . htmlspecialchars($libelle) . "</h4>";
    echo "<ul>";
    foreach ($tags as $tag) {
        echo "<li>" . htmlspecialchars($tag) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Aucun tag associé à cette activité.</p>";
}


?>
