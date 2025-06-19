<?php
session_start();

// Vérification de la session
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OffreController.php');

//Creation des variables pour la publication d'une offre
$offreController = new OffreController();

$idOffre = $_POST['id_offre'];
$enRelief = $_POST['en_relief'] ?? FALSE;
$aLaUne = $_POST['aLaUne'] ?? FALSE;
$nbSemaines = $_POST['nbSemaines'] ?? 0;

$success = $offreController->publicationOffre($idOffre, $enRelief, $aLaUne, $nbSemaines);

// Renvoie la réponse
echo json_encode(['success' => $success]);
exit;

?>