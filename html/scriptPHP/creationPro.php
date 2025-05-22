<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/ProfessionnelController.php');

$professionnel = new ProfessionnelController();

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$adresse = $_POST['adresse'];
$complement = $_POST['complement'];
$codePostal = $_POST['codePostal'];
$ville = $_POST['ville'];

$estEntreprise = isset($_POST['entreprise_privee']); // true si coché

$motDePasse = $_POST['mot_de_passe'];
$confirmation = $_POST['confirmation'];
$raisonSociale = $_POST['raisonSociale']; // si besoin

if ($estEntreprise) {
    $denomination = $_POST['denomination'];
    $siren = $_POST['siren'];
    $rib = $_POST['rib'];
    $professionnel->nouveauCompteProfessionnelPrive($nom, $prenom, $email, $telephone, $adresse, $complement, $codePostal, $ville, $denomination, $siren, $rib, $motDePasse);
} else {
    $raisonSociale = $_POST['raisonSociale'];
    $professionnel->nouveauCompteProfessionnelPublic($nom, $prenom, $email, $telephone, $adresse, $complement, $codePostal, $ville, $raisonSociale, $motDePasse);
}

header('Location: /');
exit;