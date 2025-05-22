<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OffreController.php');

$controller = new OffreController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $controller->ajouterOffre($_POST, $_FILES);
    if ($result['success']) {
        // Rediriger ou afficher un message
        header('Location: /backOffice/offresListe.php?success=1');
        exit;
    } else {
        // Afficher les erreurs dans la vue
        $errors = $result['errors'];
        // Ici tu peux inclure la vue avec affichage des erreurs
        require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/ajouterOffreActivite.php');
    }
} else {
    // Si pas POST, afficher le formulaire
    $controller->afficherFormulaire();
}
