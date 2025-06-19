


        

       <h3 class="nameActivite">Champs liées a l'offre Parc d'attraction</h3>
       <div class="champ-type-offre-row">
            <div class="champ-type-offre">
                <h3>Nombre d'attraction</h3>
                <label class="label-input" for="numero">Numéro</label>
                <input id="numero" name="numero" type="number" required />
            </div> 
            <div class="champ-type-offre">
                <h3>Age minimum</h3>   
                <label class="label-input" for="age">Age minimum</label>
                <input id="age" name="age" type="number" required />
            </div> 
        </div>

        <div class="champ-type-offre principale">
            <h3>Carte</h3>
            <label for="carteParc" class="custom-file-button">Image de la carte du parc</label>
            <input id="carteParc" name="carteParc" type="file" accept="image/*" onchange="imagePreviewMap()" hidden />
            <div id="previewMap" class="preview-container"></div>
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
   
    
        
       
        
   
