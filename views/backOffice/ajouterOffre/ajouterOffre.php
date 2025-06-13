

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

        input {
            width: 66%;
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

        }

        
        .formulaire .options-payantes input {
            width: auto;
            margin-left: 50px;

        }


    </style>
    <script src="../../scripts/ajouterAjoutMultiple.js"></script>
    
    
</head>
<body>
    
    </script>   
    
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

                    
                ?>
                <form action="/backOffice/ajouterOffreTraitement.php" method="POST" enctype="multipart/form-data">
                    <div class="formulaire">
                        <div id="type-activite-app">
                            <label for="type-select">Choisir un type d'activité :</label>
                            <select id="type-select">
                                <option value="">-- Sélectionner --</option>
                                <?php foreach ($typeActivites as $index => $type): ?>
                                    <option value="<?= $type['id_type_activite'] . '|' . $type['libelle_activite'] ?>">
                                        <?= htmlspecialchars($type['libelle_activite']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <div id="champs-offre" style="display: none;">
                                <div class="champ-type-offre">
                                    <h3>Titre</h3>
                                    <label class="label-input" for="titre">Titre</label>
                                    <input id="titre" name="titre" type="text" required />
                                </div>

                                <div class="champ-type-offre">
                                    <h3>Photo principale</h3>
                                    <input id="imagePrincipale" name="imagePrincipale" type="file" accept="image/*"  />
                                </div>

                                <div class="champ-type-offre">
                                    <h3>Photos secondaires</h3>
                                    <input id="imagesSecondaires" name="imagesSecondaires[]" type="file" accept="image/*" multiple />                                
                                </div>

                                <div class="champ-type-offre">
                                    <h3>Prix minimum TTC</h3>
                                    <label class="label-input" for="prixMin">Prix</label>
                                    <input id="prixMin" name="prixMin" type="text" required style="width: 20%;" />
                                </div>


                                <div class="champ-type-offre">
                                    <h3>Jours d'ouvertures</h3>
                                    <button type="button" onclick="document.getElementById('jours-checkboxes').style.display = (document.getElementById('jours-checkboxes').style.display === 'none' ? 'block' : 'none');">
                                        Sélectionner les jours d'ouverture
                                    </button>
                                    <div id="jours-checkboxes" style="display: none; margin-top: 10px;">
                                        <label><input type="checkbox" name="jours[]" value="Lundi"> Lundi</label>
                                        <label><input type="checkbox" name="jours[]" value="Mardi"> Mardi</label>
                                        <label><input type="checkbox" name="jours[]" value="Mercredi"> Mercredi</label>
                                        <label><input type="checkbox" name="jours[]" value="Jeudi"> Jeudi</label>
                                        <label><input type="checkbox" name="jours[]" value="Vendredi"> Vendredi</label>
                                        <label><input type="checkbox" name="jours[]" value="Samedi"> Samedi</label>
                                        <label><input type="checkbox" name="jours[]" value="Dimanche"> Dimanche</label>
                                    </div>
                                </div>
                                
                                <h3>Date matin</h3>    
                                <div class="champ-type-offre-row">
                                    
                                    <div class="champ-type-offre">
                                        
                                        <label class="label-input" for="dateDebutMatin">Debut</label>
                                        <input id="dateDebutMatin" name="dateDebutMatin" type="text" required />
                                    </div>
                                    <div class="champ-type-offre">
                                        
                                        <label class="label-input" for="dateFinMatin">Fin</label>
                                        <input id="dateFinMatin" name="dateFinMatin" type="text" required />
                                    </div>
                                </div>

                                    
                                <h3>Date apres midi</h3>    
                                <div class="champ-type-offre-row">
                                    
                                    <div class="champ-type-offre">
                                        
                                        <label class="label-input" for="dateDebutApresMidi">Debut</label>
                                        <input id="dateDebutApresMidi" name="dateDebutApresMidi" type="text" required />
                                    </div>
                                    <div class="champ-type-offre">
                                        
                                        <label class="label-input" for="dateFinApresMidi">Fin</label>
                                        <input id="dateFinApresMidi " name="dateFinApresMidi" type="text" required />
                                    </div>
                                </div>

                                <div class="champ-type-offre">
                                    <h3>Description</h3>
                                    <label class="label-input" for="description">Description</label>
                                    <input id="description" name="description" type="text" required />
                                </div>

                                <div class="champ-type-offre">
                                    <h3>Resume</h3>
                                    <label class="label-input" for="resume">Resume</label>
                                    <input id="resume" name="resume" type="text" required />
                                </div>

                                <div class="champ-type-offre">
                                    <h3>Accessibilité</h3>
                                    <label class="label-input" for="accessibilite">Accessibilité</label>
                                    <input id="accessibilite" name="accessibilite" type="text" required />
                                </div>  

                                

                                <div class="champ-type-offre-row">
                                    <div class="champ-type-offre">
                                        <h3>Ville</h3>
                                        <label class="label-input" for="ville">Ville</label>
                                        <input id="ville" name="ville" type="text" required />
                                    </div> 
                                    <div class="champ-type-offre">
                                        <h3>Code postal</h3>
                                        <label class="label-input" for="codePostal">Code postal</label>
                                        <input id="codePostal" name="codePostal" type="text" required />
                                    </div>
                                    
                                </div>

                                <div class="champ-type-offre-row">
                                    <div class="champ-type-offre">
                                        <h3>Numéro</h3>
                                        <label class="label-input" for="numero">Numéro</label>
                                        <input id="numero" name="numero" type="text" required />
                                    </div> 
                                    <div class="champ-type-offre">
                                        <h3>Voie</h3>   
                                        <label class="label-input" for="voie">Voie</label>
                                        <input id="voie" name="voie" type="text" required />
                                    </div> 
                                    <div class="champ-type-offre" style="width: 100%;">
                                        <h3>Adresse</h3>
                                        <label class="label-input" for="adresse">Adresse</label>
                                        <input id="adresse" name="adresse" type="text" required />
                                    </div> 
                                </div>

                                <div class="champ-type-offre" style="width: 100%;">
                                    <h3>Complement Adresse</h3>
                                    <label class="label-input" for="complementAdresse">Complement Adresse</label>
                                    <input id="complementAdresse" name="complementAdresse" type="text" required />
                                </div> 


                                





                            </div>

                            

                            <div id="activite-details" style="margin-top: 1em;"></div>

                            <div id="option" class="options-payantes" style="display: none;">
                                <p>Voulez-vous prendre une option :</p>

                                <label>
                                    <input type="checkbox" name="a_la_une" value="1" >
                                    A la une : (+20€/mois)
                                </label><br>

                                <label>
                                    <input type="checkbox" name="en_relief" value="1" >
                                    En relief : (+10€/mois)
                                </label><br>

                                
                            </div>

                        </div>
                        
                        

                        
                                            
                    
                        <script>
                            const select = document.getElementById('type-select');
                            const detailsDiv = document.getElementById('activite-details');

                            select.addEventListener('change', function () {
                                // Récupérer les deux valeurs séparées par |
                                const [selectedId, selectedLibelle] = this.value.split('|');

                                // Stocker dans les cookies
                                document.cookie = `selectedActiviteId=${encodeURIComponent(selectedId)}; path=/`;
                                document.cookie = `selectedLibelle=${encodeURIComponent(selectedLibelle)}; path=/`;
                                console.log(selectedId);
                            
                                
                                
                                if (!selectedLibelle) {
                                    detailsDiv.innerHTML = '';
                                    return;
                                }

                                // Nettoyage du libellé
                                const libelleSanitized = selectedLibelle
                                    .normalize('NFD').replace(/[\u0300-\u036f]/g, '') // supprime accents
                                    .replace(/[^a-zA-Z]/g, ''); // garde que lettres uniquement

                                // Envoi des deux versions au backend
                                const url = `/backOffice/chargeComposant.php?libelle=${encodeURIComponent(selectedLibelle)}&sanitized=${encodeURIComponent(libelleSanitized)}`;

                                fetch(url)
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error("Fichier non trouvé");
                                        }
                                        return response.text();
                                    })
                                    .then(html => {
                                        detailsDiv.innerHTML = html;
                                    })
                                    .catch(error => {
                                        detailsDiv.innerHTML = `<p style="color:red;">Erreur : ${error.message}</p>`;
                                    });
                            });
                        </script>




                    </div>
                    
                    <div id="champs-submit" style="display: none;">
                        <button type="submit">Enregistrer l’offre</button>
                    </div>

                    <script>
                        // Afficher ou masquer les champs d'offre en fonction de la sélection du type d'activité
                        const typeSelect = document.getElementById('type-select');
                        const champsOffre = document.getElementById('champs-offre');
                        const champsSubmit = document.getElementById('champs-submit');
                        const option = document.getElementById('option');

                        typeSelect.addEventListener('change', function () {
                            if (this.value === "") {
                                champsOffre.style.display = "none";
                                champsSubmit.style.display = "none";
                                option.style.display = "none";
                            } else {
                                champsOffre.style.display = "block";
                                champsSubmit.style.display = "block";
                                option.style.display = "block";
                            }
                        });
                    </script>
                </form>
                 

            </main>
            
            <?php require_once($_SERVER['DOCUMENT_ROOT'] .'/../views/backOffice/components/footer.php'); ?>
        </div>
    </div>

    


</body>
</html>
    

