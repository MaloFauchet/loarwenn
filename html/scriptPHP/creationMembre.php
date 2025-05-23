<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/UtilisateurController.php');

$membre = new UtilisateurController();

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$adresse = $_POST['adresse'];
$complement = $_POST['complement'];
$codePostal = $_POST['codePostal'];
$ville = $_POST['ville'];

$motDePasse = password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT);
$confirmation = $_POST['confirmation'];
$pseudo = $_POST['pseudo']; // si besoin

$membre->nouveauCompteMembre($nom, $prenom, $email, $telephone, $adresse, $complement, $codePostal, $ville, $pseudo, $motDePasse);

header('Location: /');
exit;