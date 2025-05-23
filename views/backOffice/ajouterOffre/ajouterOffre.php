

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

        .formulaire div:last-child {
            width: 66%;

        }
        .formulaire .options-payantes input {
            width: auto;
            margin-left: 50px;

        }


    </style>
    
</head>
<body>
    <script>
        function ajouterajoutMultiple(id) { 
            const input = document.getElementById('ajoutMultipleInput_' + id);
            const list = document.getElementById('ajoutMultipleList_' + id);
            const value = input.value.trim();

            if (value !== '') {
                const li = document.createElement('li');
                li.innerHTML = `${value} <button onclick="supprimerajoutMultiple(this)">✖</button>`;
                list.appendChild(li);
                input.value = '';
            }
        }

        function supprimerajoutMultiple(btn) {
            btn.parentElement.remove();
        }
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

                    <div id="activite-details" style="margin-top: 1em;"></div>
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
                 

            </main>
            
            <?php require_once($_SERVER['DOCUMENT_ROOT'] .'/../views/backOffice/components/footer.php'); ?>
        </div>
    </div>

    


</body>
</html>
    

