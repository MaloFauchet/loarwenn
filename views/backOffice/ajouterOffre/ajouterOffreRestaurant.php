        <div class="champ-type-offre">
            <h3>Carte du restaurant</h3>  
            <input aria-label="Carte du restaurant" id="carteRestaurant" name="carteRestaurant" type="file" accept="image/*" required />
        </div>

    
        <div class="champ-type-offre">
            <h3>Gamme de prix</h3>
            <label class="label-input" for="prix">Prix</label>
            <select id="prix" name="prix" required>
                <option value="" disabled selected>Choisissez une gamme de prix</option>
                <option value="1">€ (menu à moins de 25€)</option>
                <option value="2">€€ (entre 25 et 40€)</option>
                <option value="3">€€€ (au-delà de 40€)</option>
            </select>
        </div>

         

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


        <?php
            require_once($_SERVER['DOCUMENT_ROOT'] .'/../views/backOffice/ajouterOffre/function.php');  
        
            $id= $_COOKIE['selectedActiviteId'];
            $name= $_COOKIE['selectedLibelle'];
            $selectedActiviteId= $_COOKIE['selectedActiviteId'];
          
            

            $id_tags = $typeActiviteController->getTagIdByTypeActivite($id,$name);
            $arrayIdTags = array_column($id_tags, 'id_tag');
            $tags = $tagController->getAllTagByIdTagActivite($arrayIdTags);
            $tags = array_column($tags, 'libelle_tag');


            afficherTag($tags, $name,$selectedActiviteId);


        ?>