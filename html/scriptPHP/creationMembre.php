<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/ProfessionnelController.php');

// $membre = new MembreController();

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$adresse = $_POST['adresse'];
$complement = $_POST['complement'];
$codePostal = $_POST['codePostal'];
$ville = $_POST['ville'];

$motDePasse = $_POST['mot_de_passe'];
$confirmation = $_POST['confirmation'];
$raisonSociale = $_POST['pseudo']; // si besoin

// $membre->nouveauCompteMembre($nom, $prenom, $email, $telephone, $adresse, $complement, $codePostal, $ville, $pseudo, $motDePasse);

header('Location: /');
exit;