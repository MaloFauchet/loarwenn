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
    // Récupère le QR Code OTP et insert dans la base de données le secret
    $otp = $otpController->genererOTP($dataPro['email']);
    $qrCode = $otpController->getQRCode();
    $_SESSION['otp_secret'] = $otpController->getSecret(null);
    
    if ($qrCode) {
        header('Content-Type: application/json');
        echo json_encode(['qrCode' => $qrCode, 'secret' => $_SESSION['otp_secret'] ?? null]);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Erreur lors de la génération du QR Code']);
    }
}