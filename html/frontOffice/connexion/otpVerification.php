<?php
    session_start();
    require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/UtilisateurController.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OTPController.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/ProfessionnelController.php');
    
    // Enlever la session de l'utilisateur le temps de la vérification de l'OTP
    $idPro = $_SESSION['id_utilisateur'] ?? $_POST['id_pro'] ?? null;
    unset($_SESSION['id_utilisateur']);
    unset($_SESSION['messageOtp']);

    /**
     * Récupère les informations du professionnel
     * Et les creer les variables de session
     */
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['otp'])) {
        $proController = new ProfessionnelController();
        $proData = $proController->getProfessionnelById($idPro);
        $proData = $proData[0] ?? null;

        $tentatives = $proData['tentative_otp'] ?? 0;
        $now = date('Y-m-d H:i:s');

        if(($proData['bloque_jusqua'] && strtotime($proData['bloque_jusqua']) > time()) || $tentatives >= 3) {
            $minutesRestantes = ceil((strtotime($proData['bloque_jusqua']) - time()) / 60);
            // Si le professionnel est bloqué, on redirige vers la page de connexion
            $_SESSION['id_utilisateur'] = $idPro;
            $_SESSION['messageOtp'] = 'Vous avez atteint le nombre maximum de tentatives. Veuillez réessayer plus tard.';
            header('Location: /frontOffice/connexion/connexionPro.php');
            exit;
        }


        $otpController = new OTPController();

        $secret = $otpController->getSecret($idPro);
        $isValid = $otpController->verifierOTP($_POST['otp'], $secret);

        if ($isValid) {
            $_SESSION['id_utilisateur'] = $idPro;
            $_SESSION['otp_verifier'] = true;
            $_SESSION['tentatives_otp'] = 0;
            $proController->updateTentativeOTP($idPro, 0, null, $now);
            header('Location: /backOffice/index.php');
            exit;
        } else {
            $tentatives++;
            $_SESSION['tentatives_otp'] = $tentatives;
            $_SESSION['messageOtp'] = 'Mauvais code OTP. Veuillez réessayer.';

            if ($tentatives >= 3) {
                $bloqueJusqua = date('Y-m-d H:i:s', strtotime('+1 minutes'));
                $proController->updateTentativeOTP($idPro, 0, $bloqueJusqua, $now);
                $_SESSION['id_utilisateur'] = $idPro;
                $_SESSION['tentatives_otp'] = 0;
                $_SESSION['messageOtp'] = 'Vous avez atteint le nombre maximum de tentatives. Veuillez réessayer plus tard.';
                header('Location: /frontOffice/connexion/connexionPro.php');
                exit;
            } else {
                $proController->updateTentativeOTP($idPro, $tentatives, null, $now);
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de connexion</title>
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/components/input.css">
    <link rel="stylesheet" href="/styles/components/formulaire.css">
    <link rel="icon" type="image/png" href="/images/logos/logoBlue.png">
</head>

<body>
    <!-- Vue de connexion -->
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/frontOffice/components/otpVerifModal.php'); ?>
</body>

</html>