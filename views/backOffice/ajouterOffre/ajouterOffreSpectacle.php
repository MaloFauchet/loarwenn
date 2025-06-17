

       
      
        <div class="champ-type-offre-row">
            <div class="champ-type-offre">
                <h3>Durée</h3>
                <label class="label-input" for="duree">Durée</label>
                <input id="duree" name="duree" type="number" required />
            </div>

            <div class="champ-type-offre">
                <h3>Capacité d'accueil</h3>
                <label class="label-input" for="capacite">Capacité</label>
                <input id="capacite" name="capacite" type="number" required />
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
   
    
        
       
        
    
