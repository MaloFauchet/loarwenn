<?php
// Démarrer le buffer de sortie pour éviter les erreurs liées aux headers
ob_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OffreController.php');

$controller = new OffreController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $controller->ajouterOffre($_POST, $_FILES);

    if ($result['success']) {
        // Rediriger avant toute sortie
        header('Location: /backOffice/');
        exit;
    } else {
        // Pas de sortie avant ce require pour afficher la vue avec erreurs
        $errors = $result['errors'];
        require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/ajouterOffreActivite.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/ajouterOffreParcDattraction.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/ajouterOffreRestaurant.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/ajouterOffreSpectacle.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/ajouterOffrevisteGuidee.php');
    }
} else {
    // Pas de sortie avant ce require
    $controller->afficherFormulaire();
}

// Vider le buffer (envoi du contenu, s'il y en a)
ob_end_flush();
?>