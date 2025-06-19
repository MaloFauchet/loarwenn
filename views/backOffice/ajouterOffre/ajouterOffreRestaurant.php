
     

        
        <h3 class="nameActivite">Champs liées a l'offre Restaurant</h3>
        
        <div class="champ-type-offre principale">
            <h3>Carte</h3>
            <label for="carteRestaurant" class="custom-file-button">Image de la carte du restaurant</label>
            <input id="carteRestaurant" name="carteRestaurant" type="file" accept="image/*" onchange="imagePreviewResto()" hidden />
            <div id="previewCarteRestaurant" class="preview-container"></div>
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

        <script defer>
            alert();
            console.log("Restaurant");
        </script>

         

        <div class="champ-type-offre">
            <h3>Menus</h3>
            <div id="menu-checkboxes" style="margin-top: 10px; display: flex; flex-direction: column; gap: 8px;">
                <label><input type="checkbox" name="menu[]" value="petit-dej"> Petit déjeuner</label>
                <label><input type="checkbox" name="menu[]" value="dej"> Déjeuner</label>
                <label><input type="checkbox" name="menu[]" value="diner"> Diner</label>
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
   
    
        
       
        
  