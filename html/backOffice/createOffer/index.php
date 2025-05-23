<?php 
session_start();
// Vérification de la session
if (!isset($_SESSION['id_utilisateur'])) {
    header('Location: /backOffice/connexion/connexionPro.php');
    exit();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/../controllers/OffreConroller.php'); 

$controllerOffre = new OffreController();

if ($_GET) {
    //créer l'offre si toute les infos sont bonnes
    /*
    if (condition) {
        $controllerOffre->createOffre()
    } else if() {
       $controllerOffre->createOffre()
    }
    else if() {
        $controllerOffre->createOffre()
    }
    else if() {
        $controllerOffre->createOffre()
    }
    else if() {
        $controllerOffre->createOffre()
    }*/
    

    //header("Location: " . $_SERVER['DOCUMENT_ROOT'] . '/backOffice.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une offre</title>
</head>
<body>

    <?php /*require_once('../views/backOffice/header/footer.php');*/ ?>
    <h2>Nouvelle offre</h2>
    <form action="./" method="get">
        <div>
            <h3>Sélection des activités</h3>
            <select name="prestationIncluse" id="">
                <option value=""></option>
            </select>
        </div>
    
        <div>
            <h3>Titre</h3>
            <label for=""></label>
            <input type="text">
        </div>
        <div>
            <h3>Photo</h3>
            <label for=""></label>
            <input type="text">
        </div>
        <div>
            <h3>Description détaillé</h3>
            <label for=""></label>
            <input type="text">
        </div>
        <div>
            <h3>Lieu</h3>
            <label for=""></label>
            <input type="text">
        </div>
        <?php if(true || $offre === "resto"){ ?>
            <div>
                <h3>Image</h3>
                <label for="">Menu</label>
                <input type="file">
            </div>
            <div>
                <h3>Gamme prix</h3>
                <label for=""></label>
                <input type="text">
            </div>
        <?php } ?>
        <?php if ($offre ==="activite"){ ?>
            <div>
                <h3>Durée</h3>
                <label for=""></label>
                <input type="text">
            </div>
            <div>
                <h3>Age</h3>
                <label for=""></label>
                <input type="text">
            </div>
            <div>
                <h3>Prestation Incluse</h3>
                <select name="prestationIncluse" id="">
                    <option value=""></option>
                </select>
                <button>Ajouter</button>
            </div>
            <div>
                <h3>Prestation Non Incluse</h3>
                <select name="prestationNonIncluse" id="">
                    <option value=""></option>
                </select>
                <button>Ajouter</button>
            </div>
        <?php } ?>
        <?php if ($offre ==="visite"){ ?>
            <div>
                <h3>Durée</h3>
                <label for=""></label>
                <input type="text">
            </div>
            <div>
                <h3>Accessibilité</h3>
                <label for=""></label>
                <input type="text">
            </div>
        <?php } ?>
        <?php if ($offre ==="spectacles"){ ?>
            
            <div>
                <h3>Durée</h3>
                <label for=""></label>
                <input type="text">
            </div>
            <div>
                <h3>prix</h3>
                <label for=""></label>
                <input type="text">
            </div>
            <div>
                <h3>Capacité d'accueil</h3>
                <label for=""></label>
                <input type="number">
            </div>
            <div>
                <h3>Accessibilité</h3>
                <label for=""></label>
                <input type="text">
            </div>
        <?php } ?>
        <?php if ($offre ==="parcAttraction"){ ?>
            <div>
                <h3>Nombre d'attraction</h3>
                <label for=""></label>
                <input type="text">
            </div>
            <div>
                <h3>Age</h3>
                <label for=""></label>
                <input type="text">
            </div>
            <div>
                <h3>Image des attractions</h3>
                <label for=""></label>
                <input type="text">
            </div>
            <div>
                <h3>Accessibilité</h3>
                <label for=""></label>
                <input type="text">
            </div>
        <?php } ?>
        
        <div>
            <h3>Tags</h3>
            <select name="tags" id="">
                <option value=""></option>
            </select>
        </div>
        <?php if (!$offrePayante) { ?>
            <div>
                <label for=""></label>
                <input type="text">
                <p></p>
            </div>
            <div>
                <label for=""></label>
                <input type="text">
                <p></p>
            </div>
        <?php } ?>
        <div>
            <button>Annuler</button>
            <button type="submit">Créer</button>
        </div>
    </form>

    <?php /* require_once('../views/backOffice/components/footer.php');*/ ?>
</body>
</html>