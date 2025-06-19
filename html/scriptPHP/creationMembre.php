<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/UtilisateurController.php');

$membre = new UtilisateurController();

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$num_adresse = $_POST['num'];
$voie_adresse = $_POST['voie'];
$complement = $_POST['complement'];
$codePostal = $_POST['codePostal'];
$ville = $_POST['ville'];

$motDePasse = password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT);
$confirmation = $_POST['confirmation'];
$pseudo = $_POST['pseudo']; // si besoin

try {
    $membre->nouveauCompteMembre($nom, $prenom, $email, $telephone, $num_adresse, $voie_adresse, $complement, $codePostal, $ville, $pseudo, $motDePasse);
    header('Location: /?success=1');
    exit;
} catch (Exception $th) {
    header('Location: /?success=0');
    exit;
}
