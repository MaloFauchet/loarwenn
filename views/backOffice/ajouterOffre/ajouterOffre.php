<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/../controllers/OffreController.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit_offre'])) {
        // Soumission finale du formulaire complet
        $controller = new OffreController();
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
                                    <div class="champ-type-offre principale">
                                        <h3>Photo principale</h3>

                                        <label for="imagePrincipale" class="custom-file-button">Choisir une photo principale</label>
                                        <input id="imagePrincipale" name="imagePrincipale" type="file" accept="image/*" hidden />
                                        <div id="previewPrincipale" class="preview-container"></div>
                                    </div>

                                    <div class="champ-type-offre secondaires">
                                        <h3>Photos secondaires (4 maximum)</h3>
                                        <label for="imagesSecondaires" class="custom-file-button">Ajouter des photos secondaires</label>
                                        <input id="imagesSecondaires" name="imagesSecondaires[]" type="file" accept="image/*" multiple hidden />
                                        <div id="previewSecondaires" class="preview-container"></div>

                                    </div>
                                </div>

                                

                                <div class="champ-type-offre-row-jour">
                                    <div class="champ-type-offre">

                                        <h2 id="h2-jours">

                                            Sélectionner les jours d'ouverture
                                        </h2>
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
                                                <input id="dateDebutMatin" name="dateDebutMatin" type="time"  />
                                            </div>
                                            <div class="champ-type-offre">
                                                <label class="label-input" for="dateFinMatin">Fin</label>
                                                <input id="dateFinMatin" name="dateFinMatin" type="time"  />
                                            </div>
                                        
                                    </div> 
                                    <div>
                                        <h3>Heure apres midi</h3>    
                                        
                                            
                                            <div class="champ-type-offre">
                                                
                                                <label class="label-input" for="dateDebutApresMidi">Debut</label>
                                                <input id="dateDebutApresMidi" name="dateDebutApresMidi" type="time"  />
                                            </div>
                                            <div class="champ-type-offre">
                                                <label class="label-input" for="dateFinApresMidi">Fin</label>
                                                <input id="dateFinApresMidi" name="dateFinApresMidi" type="time"     />
                                            </div>
                                        
                                    </div>   
                                </div>

                                    
                                <div class="champ-type-offre">
                                    <h3>Resume</h3>
                                    <label class="label-input" for="resume">Resume</label>
                                    <input id="resume" name="resume" type="text" required >

                                </div>

                                <div class="champ-type-offre">
                                    <h3>Description</h3>
                                    <label class="label-input" for="description">Description</label>
                                    <textarea id="description" name="description" type="text" required >
                                       
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
<script defer>
    imagePreview();
</script>


    


</body>
</html>


    

