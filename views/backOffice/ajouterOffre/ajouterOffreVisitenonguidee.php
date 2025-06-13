



        
        <div class="champ-type-offre">
            <h3>Durée</h3>
            <label class="label-input" for="duree">Durée</label>
            <input id="duree" name="duree" type="number" required />
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
   
    
        
       
        
   