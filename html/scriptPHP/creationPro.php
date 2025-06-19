<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/ProfessionnelController.php');

$professionnel = new ProfessionnelController();

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$num_adresse = $_POST['num'];
$voie_adresse = $_POST['voie'];
$complement = $_POST['complement'];
$codePostal = $_POST['codePostal'];
$ville = $_POST['ville'];

$estEntreprise = isset($_POST['est_entreprise']); // true si coché

$motDePasse = password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT);
$confirmation = $_POST['confirmation'];

try {
    if ($estEntreprise) {
        $denomination = $_POST['denomination'];
        $siren = $_POST['siren'];
        $iban = $_POST['iban'];
        $professionnel->nouveauCompteProfessionnelPrive($nom, $prenom, $email, $telephone, $num_adresse, $voie_adresse, $complement, $codePostal, $ville, $denomination, $siren, $iban, $motDePasse);
    } else {
        $raisonSociale = $_POST['raisonSociale'];
        $professionnel->nouveauCompteProfessionnelPublic($nom, $prenom, $email, $telephone, $num_adresse, $voie_adresse, $complement, $codePostal, $ville, $raisonSociale, $motDePasse);
    }

    header('Location: /?success=1');
    exit;

} catch (Exception $th) {
    header('Location: /?success=0');
    exit;
}



