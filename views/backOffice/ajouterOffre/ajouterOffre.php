

<?php


require_once($_SERVER['DOCUMENT_ROOT'].'/../controllers/OffreController.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit_offre'])) {
        // Soumission finale du formulaire complet
        $controller = new OffreController();
        $controller->createOffre();
        header('Location: /backOffice/ajouterOffre/');
        exit(0);
    }
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouvelle offre</title>
    <style>
        
        select {
            padding: 10px;
            border-radius: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
        }
        label {
            font-size: 18px;
        }
            
       

        .ajoutMultiple-container {
            max-width: 400px;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 100px;
        }

        .ajoutMultiple-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            font-weight: bold;
            border-bottom: 1px solid #eee;
        }

        .ajoutMultiple-header input {
            flex: 1;
            margin-right: 10px;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .ajoutMultiple-header button {
            padding: 5px 10px;
            border: 1px solid #007bff;
            background-color: white;
            color: #007bff;
            border-radius: 5px;
            cursor: pointer;
        }

        .ajoutMultiple-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .ajoutMultiple-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            border-top: 1px solid #eee;
        }

        .ajoutMultiple-list button {
            background: none;
            border: none;
            font-size: 18px;
            color: red;
            cursor: pointer;
        }

        h1{
            align-items: center;
            margin-bottom: 20px;
        }

        .titre {
            display: flex;
            justify-content: center;
        }
        
        .label-type-offre {
            font-size: 30px;
            margin-bottom: 20px;
        }

        
        h3 {
            margin-bottom:0px;
            margin-top:0px;
        }
        .formulaire  .champ-type-offre {
            display: flex;
            flex-direction: column;
            margin-bottom: 50px;

        }
        .formulaire  .champ-type-offre-row {
            display: flex;
            flex-direction: row;
            margin-bottom: 50px;
            gap :10em;

        }

        
        .formulaire .options-payantes input {
            width: auto;
            margin-left: 50px;

        }

        .champ-type-offre h3 {
            margin-bottom: 10px;
            font-size: 1.5em;
            color: #333;
        }

        .toggle-button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 1em;
            border-radius: 5px;
            cursor: pointer;
           
        }

        .toggle-button:hover {
            background-color: #0056b3;
        }

        .checkbox-container {
            display: none;
            margin-top: 10px;
        }

        .checkbox-container label {
            display: block;
            margin-bottom: 0.5em;
            font-size: 1em;
        }

        .formulaire  .champ-type-offre-row-jour {
            display: flex;
            flex-direction: row;
            margin-bottom: 50px;
            gap: 10em; 
        }
        #description,#resume,#accessibilite
        {
            height: 10em;
        }

        .adressePostale{
            margin-bottom:2em;
        }

        #dateDebutMatin ,#dateFinMatin ,#dateDebutApresMidi ,#dateFinApresMidi{
            height: 2em;
        }
        #prixMin{
            width: 4em;

        }
        #voie{
            width: 100vh;
        }

        .options-payantes {
            display: none; /* caché par défaut */
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            max-width: 400px;
            margin: 20px 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .options-payantes p {
            font-size: 1.2em;
            margin-bottom: 15px;
            color: #333;
        }

        .option-item {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px 15px;
            margin-bottom: 10px;
            transition: box-shadow 0.3s, transform 0.2s;
            cursor: pointer;
        }

        .option-item:hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .option-item label {
            font-size: 1em;
            color: #333;
            display: flex;
            align-items: center;
        }

        .option-item input[type="checkbox"] {
            margin-right: 10px;
            transform: scale(1.3);
            cursor: pointer;
        }

        .select {
            display: flex;
            flex-direction:column;
            width: 35%;
        }


        .select label {
            font-weight: bold;
            font-size: 30px;
        }

        .submit-container {
            display: none; 
            margin-top: 20px;
            text-align: right; 
        }

        .submit-button {
            background-color: #007BFF;
            color: white;
            font-size: 1.1em;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .submit-button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .submit-button:active {
            transform: translateY(0);
        }



       

    </style>
    <script src="<?php echo $_SERVER['DOCUMENT_ROOT'] ?>/../../../scripts/ajouterAjoutMultiple.js"></script>

    
    
</head>
<body>  
    
    <?php require_once($_SERVER['DOCUMENT_ROOT'] .'/../views/backOffice/components/header.php'); 
  
    require_once($_SERVER['DOCUMENT_ROOT'] .'/../views/componentsGlobaux/afficherEtoile.php');
    require_once($_SERVER['DOCUMENT_ROOT'] .'/../controllers/TypeActiviteController.php'); 
    require_once($_SERVER['DOCUMENT_ROOT'] .'/../controllers/OffreController.php'); 
    
    ?>
    
        
    <div class="page-back-office">
        <?php require_once($_SERVER['DOCUMENT_ROOT'] .'/../views/backOffice/components/nav.php'); ?>

        <div class="container-back-office">
            <main class="contenu-back-office">
                <?php
                    $typeActiviteController = new TypeActiviteController(); 
                    $typeActivites = $typeActiviteController->getAllTypeActivite();
                    $userId = $_SESSION['id_utilisateur'];

                ?>
                
                <form action="/backOffice/ajouterOffreTraitement.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="userId" value="<?= htmlspecialchars($userId) ?>">
                    <div class="formulaire">
                        <div id="type-activite-app">
                            <div class="select">
                                <label for="type-select">Sélectionner un type d'offre : </label>
                                <select id="type-select">
                                    <option value="">-- Sélectionner --</option>
                                    <option value="1|activite">Activité</option>
                                    <option value="2|spectacle">Spectacle</option>
                                    <option value="3|visite guidee">Visite guidée</option>
                                    <option value="4|parc dattraction">Parc d'attraction</option>
                                    <option value="5|restaurant">Restaurant</option>
                                    <option value="6|visite non guidee">Visite non guidée</option>
                                </select>
                            </div>

                            <div id="champs-offre" style="display: none;margin-top:2em;">
                                <div class="champ-type-offre-row">
                                    <div class="champ-type-offre">
                                        <h3>Titre</h3>
                                        <label class="label-input" for="titre">Titre</label>
                                        <input id="titre" name="titre" type="text" required />
                                    </div>

                                    <div class="champ-type-offre">
                                        <h3>Prix minimum TTC</h3>
                                        <label class="label-input" for="prixMin">Prix</label>
                                        <input id="prixMin" name="prixMin" type="number" required  />
                                    </div>
                                </div>
                                
                                <div class="champ-type-offre-row">
                                    <div class="champ-type-offre" style="margin-right:10em;">
                                        <h3>Photo principale</h3>
                                        <input aria-label="Photo principale" id="imagePrincipale" name="imagePrincipale" type="file" accept="image/*"  />
                                        
                                    </div>
                                    
                                
                                    <div class="champ-type-offre">
                                        <h3>Photos secondaires</h3>
                                        <input aria-label="Photos secondaires" id="imagesSecondaires" name="imagesSecondaires[]" type="file" accept="image/*" multiple />                                
                                    </div>
                                </div>    

                                

                                <div class="champ-type-offre-row-jour">
                                    <div class="champ-type-offre">
                                        <h3>Jours d'ouvertures</h3>
                                        <button aria-label="Jours d'ouverture" type="button" class="toggle-button" onclick="document.getElementById('jours-checkboxes').style.display = (document.getElementById('jours-checkboxes').style.display === 'none' ? 'block' : 'none');">
                                            Sélectionner les jours d'ouverture
                                        </button>
                                        <div id="jours-checkboxes" class="checkbox-container" >
                                            <label><input type="checkbox" name="jours[]" value="Lundi"> Lundi</label>
                                            <label><input type="checkbox" name="jours[]" value="Mardi"> Mardi</label>
                                            <label><input type="checkbox" name="jours[]" value="Mercredi"> Mercredi</label>
                                            <label><input type="checkbox" name="jours[]" value="Jeudi"> Jeudi</label>
                                            <label><input type="checkbox" name="jours[]" value="Vendredi"> Vendredi</label>
                                            <label><input type="checkbox" name="jours[]" value="Samedi"> Samedi</label>
                                            <label><input type="checkbox" name="jours[]" value="Dimanche"> Dimanche</label>
                                        </div>
                                    </div>
                                    <div>
                                        <h3>Heure matin</h3>
                                        
                                        
                                            <div class="champ-type-offre">
                                                <label class="label-input" for="dateDebutMatin">Debut</label>
                                                <input id="dateDebutMatin" name="dateDebutMatin" type="time" required />
                                            </div>
                                            <div class="champ-type-offre">
                                                <label class="label-input" for="dateFinMatin">Fin</label>
                                                <input id="dateFinMatin" name="dateFinMatin" type="time" required />
                                            </div>
                                        
                                    </div> 
                                    <div>
                                        <h3>Heure apres midi</h3>    
                                        
                                            
                                            <div class="champ-type-offre">
                                                
                                                <label class="label-input" for="dateDebutApresMidi">Debut</label>
                                                <input id="dateDebutApresMidi" name="dateDebutApresMidi" type="time" required />
                                            </div>
                                            <div class="champ-type-offre">
                                                <label class="label-input" for="dateFinApresMidi">Fin</label>
                                                <input id="dateFinApresMidi" name="dateFinApresMidi" type="time" required />
                                            </div>
                                        
                                    </div>   
                                </div>

                                    
                                

                                <div class="champ-type-offre">
                                    <h3>Description</h3>
                                    <label class="label-input" for="description">Description</label>
                                    <textarea id="description" name="description" type="text" required >
                                       
                                    </textarea>
                                </div>

                                <div class="champ-type-offre">
                                    <h3>Resume</h3>
                                    <label class="label-input" for="resume">Resume</label>
                                    <textarea id="resume" name="resume" type="text" required >

                                    </textarea>
                                </div>

                                <div class="champ-type-offre">
                                    <h3>Accessibilité</h3>
                                    <label class="label-input" for="accessibilite">Accessibilité</label>
                                    <textarea id="accessibilite" name="accessibilite" type="text" required>
                                    </textarea>
                                </div>  

                                
                                <h3 class="adressePostale">Adresse postale</h3>
                                <div class="champ-type-offre-row">
                                    <div class="champ-type-offre">
                                        <h3>Ville</h3>
                                        <label class="label-input" for="ville">Ville</label>
                                        <input id="ville" name="ville" type="text" required />
                                    </div> 
                                    <div class="champ-type-offre">
                                        <h3>Code postal</h3>
                                        <label class="label-input" for="codePostal">Code postal</label>
                                        <input id="codePostal" name="codePostal" type="number" required />
                                    </div>
                                    
                                </div>

                                <div class="champ-type-offre-row">
                                    <div class="champ-type-offre">
                                        <h3>Numéro</h3>
                                        <label class="label-input" for="numero">Numéro</label>
                                        <input id="numero" name="numero" type="number" required />
                                    </div> 
                                    <div class="champ-type-offre">
                                        <h3>Voie</h3>   
                                        <label class="label-input" for="voie">Voie</label>
                                        <input id="voie" name="voie" type="text" required />
                                    </div>  
                                </div>

                                <div class="champ-type-offre" style="width: 100%;">
                                    <h3>Complement Adresse</h3>
                                    <label class="label-input" for="complementAdresse">Complement Adresse</label>
                                    <input id="complementAdresse" name="complementAdresse" type="text" required />
                                </div> 
                            </div>


                            <div id="activite-details" style="margin-top: 1em;"></div>

                            <div id="option" class="options-payantes">
                                <p>Voulez-vous prendre une option :</p>

                                <div class="option-item">
                                    <label>
                                        <input type="checkbox" name="a_la_une" value="1">
                                        A la une : (+20€/mois)
                                    </label>
                                </div>

                                <div class="option-item">
                                    <label>
                                        <input type="checkbox" name="en_relief" value="1">
                                        En relief : (+10€/mois)
                                    </label>
                                </div>
                            </div>

                        </div>
                        
                        <script defer>
                            
                            TypeSelectChange();
                        </script>
                        

                        

                    </div>
                    
                    <div id="champs-submit" style="display: none;">
                        <button type="submit" class="submit-button" aria-label="Enregistrer l’offre">Enregistrer l’offre</button>
                    </div>

                    <script defer>
                        afficherElementMasque();
                    </script>
                </form>
                 

            </main>
            
            <?php require_once($_SERVER['DOCUMENT_ROOT'] .'/../views/backOffice/components/footer.php'); ?>
        </div>
    </div>

    


</body>
</html>
    

