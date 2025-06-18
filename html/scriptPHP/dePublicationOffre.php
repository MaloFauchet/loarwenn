<?php
// Indique que la réponse sera en JSON
header('Content-Type: application/json');

require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OffreController.php');

$data = json_decode(file_get_contents("php://input"), true);

$idOffre = $data['id_offre'];

// Appelle le contrôleur
$offreController = new OffreController();
$success = $offreController->dePublicationOffre($idOffre);

// Renvoie la réponse
echo json_encode(['success' => $success]);
exit;

?>