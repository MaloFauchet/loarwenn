<?php if (!empty($errors)): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $err): ?>
            <li><?= htmlspecialchars($err) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/components/inputAjoutMultiple.php');
?>
<form action="/backOffice/ajouterOffreTraitement.php" method="POST" enctype="multipart/form-data">
    <div class="formulaire">
        <div class="champ-type-offre">
            <h3>Titre</h3>
            <label class="label-input" for="titre">Titre</label>
            <input id="titre" name="titre" type="text" required />
        </div>

        <div class="champ-type-offre">
            <h3>Photo</h3>  
            <input id="image" name="image" type="file" accept="image/*" required />
        </div>

        <div class="champ-type-offre">
            <h3>Lieu</h3>
            <label class="label-input" for="lieu">Lieu</label>
            <input id="lieu" name="lieu" type="text" required />
        </div>

        <div class="champ-type-offre-row">
            <div class="champ-type-offre">
                <h3>Durée</h3>
                <label class="label-input" for="duree">Durée</label>
                <input id="duree" name="duree" type="text" required />
            </div>

            <div class="champ-type-offre">
                <h3>Âge</h3>
                <label class="label-input" for="age">Âge</label>
                <input id="age" name="age" type="text" required />
            </div>

            <div class="champ-type-offre">
                <h3>Gamme de prix</h3>
                <label class="label-input" for="prix">Prix</label>
                <input id="prix" name="prix" type="text" required />
            </div>
        </div>

        <div class="champ-type-offre">
            <h3>Description détaillée</h3>
            <label class="label-input" for="description">Description</label>
            <input id="description" name="description" type="text" required />
        </div>

        <?php 
            ajoutMultiple('Prestation','Prestation incluse',1);  
            ajoutMultiple('Prestation','Prestation non incluse',2);
        ?>

        <div class="champ-type-offre">
            <h3>Accessibilité</h3>
            <label class="label-input" for="accessibilite">Accessibilité</label>
            <input id="accessibilite" name="accessibilite" type="text" required />
        </div>

        <?php 
            ajoutMultiple('Tags','Tags',3); 
        ?>

        <div class="options-payantes">
            <p>Voulez-vous prendre une option :</p>

            <label>
                <input type="checkbox" name="a_la_une" value="1" checked>
                A la une : (+xx€/mois)
            </label><br>

            <label>
                <input type="checkbox" name="en_relief" value="1" checked>
                En relief : (+xx€/mois)
            </label><br>
        </div>
    </div>
    <button type="submit">Enregistrer l’offre</button>
</form>
