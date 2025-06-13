


        


       <div class="champ-type-offre-row">
            <div class="champ-type-offre">
                <h3>Nombre d'attraction</h3>
                <label class="label-input" for="numero">Numéro</label>
                <input id="numero" name="numero" type="text" required />
            </div> 
            <div class="champ-type-offre">
                <h3>Age minimum</h3>   
                <label class="label-input" for="age">Age minimum</label>
                <input id="age" name="age" type="text" required />
            </div> 
        </div>


        <div class="champ-type-offre">
            <h3>Image du plan</h3>  
            <input id="imagePlan" name="imagePlan" type="file" accept="image/*" />
        </div>


        <?php
      
            require_once($_SERVER['DOCUMENT_ROOT'] .'/../views/backOffice/ajouterOffre/function.php');  
            
            $name= $_COOKIE['selectedLibelle'];
            $selectedActiviteId= $_COOKIE['selectedActiviteId'];
            $idSession = session_id();

            $userId = $_SESSION['id_utilisateur'] ?? null;
            
            echo "<input type='hidden' name='id_utilisatuer' value='" .$userId . "'>";

            $id_tags = $typeActiviteController->getTagIdByTypeActivite($name);
            $arrayIdTags = array_column($id_tags, 'id_tag');
            $tags = $tagController->getAllTagByIdTagActivite($arrayIdTags);
            $tags = array_column($tags, 'libelle_tag');

            

            afficherTag($tags, $name,$selectedActiviteId);


        ?>
   
    
        
       
        
   
