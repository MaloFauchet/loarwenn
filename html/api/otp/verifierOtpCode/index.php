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
    $input = file_get_contents("php://input");
    $string = json_decode($input, true);

    $code = $string['otpCode'] ?? null;

    if ($code === null) {
        http_response_code(400);
        echo json_encode(['error' => 'Code manquant']);
        return;
    } else {
        $verif = $otpController->verifierOTP($code, $_SESSION['otp_secret'] ?? null);
        if($verif === false) {
            http_response_code(400);
            echo json_encode(['error' => 'Code OTP invalide']);
            return;
        } else {
            $_SESSION['otp_verifier'] = true;
            echo json_encode(['message' => "CodeOK"]);
        }
    }
}