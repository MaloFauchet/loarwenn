<?php 

if (!isset($_POST["type"])) {
    $_POST["type"] = $type_activite;
}


?>
            
    <div class="champ-type-offre principale">
            <h3>Carte</h3>
            <label for="carteRestaurant" class="custom-file-button">Image de la carte du restaurant</label>
            <input id="carteRestaurant" name="carteRestaurant" type="file" accept="image/*" onchange="imagePreviewResto()" hidden />
            <div id="previewCarteRestaurant" class="preview-container"></div>

        </div>

        <div class="champ-type-offre">
            <h3>Gamme de prix</h3>
            <label class="label-input" for="gamme-prix">Prix</label>
            <select id="gamme-prix" name="gamme-prix" required>
                
                <option value="1">€ (menu à moins de 25€)</option>
                <option value="2">€€ (entre 25 et 40€)</option>
                <option value="3">€€€ (au-delà de 40€)</option>
            </select>
        </div>

        <script defer>
            alert();
            console.log("Restaurant");
        </script>

         

        <div class="champ-type-offre">
            <h3>Menus</h3>

            <button aria-label="Sélection menu" type="button" onclick="document.getElementById('menu-checkboxes').style.display = (document.getElementById('menu-checkboxes').style.display === 'none' ? 'block' : 'none');">
                Sélectionner le/les type(s) de menu(s)
            </button>
            <div id="menu-checkboxes" style="display: none; margin-top: 10px;">
                <label><input aria-label="Petit déjeuner" type="checkbox" name="menu[]" value="petit-dej"> Petit déjeuner</label>
                <label><input aria-label="Déjeuner" type="checkbox" name="menu[]" value="dej"> Déjeuner</label>
                <label><input aria-label="Diner" type="checkbox" name="menu[]" value="diner    "> Diner</label> 
            </div>
        </div> 