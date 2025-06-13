


    
        

        

        

        <div class="champ-type-offre-row">
            <div class="champ-type-offre">
                <h3>Durée</h3>
                <label class="label-input" for="duree">Durée</label>
                <input id="duree" name="duree" type="number" required />
            </div>

            <div class="champ-type-offre">
                <h3>Âge</h3>
                <label class="label-input" for="age">Âge</label>
                <input id="age" name="age" type="number" required />
            </div>

        </div>

        
        <?php
            require_once($_SERVER['DOCUMENT_ROOT'].'/../views/backOffice/components/inputAjoutMultiple.php')
        ?>
        <?php 
            ajoutMultiple('Prestation','Prestation incluse',1);  
            ajoutMultiple('Prestation','Prestation non incluse',2); 
        ?>

       

       

       

        <?php
            require_once($_SERVER['DOCUMENT_ROOT'] .'/../views/backOffice/ajouterOffre/function.php');  
        
            
            $name= $_COOKIE['selectedLibelle'];
            $selectedActiviteId= $_COOKIE['selectedActiviteId'];
          
            

            $id_tags = $typeActiviteController->getTagIdByTypeActivite($name);
            $arrayIdTags = array_column($id_tags, 'id_tag');
            $tags = $tagController->getAllTagByIdTagActivite($arrayIdTags);
            $tags = array_column($tags, 'libelle_tag');

            

            afficherTag($tags, $name,$selectedActiviteId);


        ?>
   
    
        
       
        
    
    
