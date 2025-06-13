



        
        <div class="champ-type-offre">
            <h3>Durée</h3>
            <label class="label-input" for="duree">Durée</label>
            <input id="duree" name="duree" type="number" required />
        </div>

        <div class="champ-type-offre">
            <h3>Langue</h3>
            <button type="button" onclick="document.getElementById('langue-checkboxes').style.display = (document.getElementById('langue-checkboxes').style.display === 'none' ? 'block' : 'none');">
                Sélectionner une/des langue(s)
            </button>
            <div id="langue-checkboxes" style="display: none; margin-top: 10px;">
                <label><input type="checkbox" name="langue[]" value="Francais"> Francais</label>
                <label><input type="checkbox" name="langue[]" value="Anglais"> Anglais</label>
                <label><input type="checkbox" name="langue[]" value="Espagnol"> Espagnol</label>
                <label><input type="checkbox" name="langue[]" value="Italien"> Italien</label>
                <label><input type="checkbox" name="langue[]" value="Provençal"> Provençal</label>
                <label><input type="checkbox" name="langue[]" value="Allemand"> Allemand</label>
            </div>
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
   
    
        
       
        
   