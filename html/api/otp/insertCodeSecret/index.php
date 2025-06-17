<?php
session_start();
// Vérification de la session
if (!isset($_SESSION['id_utilisateur'])) {
    header('Location: /frontOffice/connexion/connexionPro.php');
    exit();
}
$idPro = $_SESSION['id_utilisateur'];

require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OTPController.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/../controllers/ProfessionnelController.php');

$professionnelController = new ProfessionnelController();
$dataPro = $professionnelController->getProfessionnelById($idPro)[0];

$otpController = new OTPController($dataPro['email']);

// Vérifie que c'est bien un professionnel
if($professionnelController->isProfessionnel($idPro) === false) {
    http_response_code(403);
    echo json_encode(['message' => 'Accès interdit']);
    exit();
} else {
    $secret = $_SESSION['otp_secret'] ?? null;
    
    if ($secret !== null) {
        // Insère le secret dans la base de données
        $insert = $otpController->insertSecret($idPro, $secret);
        if ($insert) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['message' => 'Votre code secret à bien été généré et pris en compte.', 'success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Vous avez déjà un code secret généré et fonctionnel.', 'success' => false]);
        }
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Erreur lors de la recupération du secret', 'success' => false, 'secret' => $secret]);
    }
}