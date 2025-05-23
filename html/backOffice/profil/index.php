<?php
session_start();
// Vérification de la session
if (!isset($_SESSION['id_utilisateur'])) {
    header('Location: /backOffice/connexion/connexionPro.php');
    exit();
}
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/ProfessionnelController.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/infosCompte.php');
?>