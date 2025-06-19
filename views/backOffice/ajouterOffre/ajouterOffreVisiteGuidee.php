        <div class="champ-type-offre">
            <h3>Durée</h3>
            <label class="label-input" for="duree">Durée</label>
            <input id="duree" name="duree" type="time" required />
        </div>

        <div class="champ-type-offre">
            <h3>Langue</h3>
            <button aria-label="Sélection langue" type="button" onclick="document.getElementById('langue-checkboxes').style.display = (document.getElementById('langue-checkboxes').style.display === 'none' ? 'block' : 'none');">
                Sélectionner une/des langue(s)
            </button>
            <div id="langue-checkboxes" style="display: none; margin-top: 10px;">
                <label><input aria-label="Francais" type="checkbox" name="langue[]" value="Francais"> Francais</label>
                <label><input aria-label="Anglais" type="checkbox" name="langue[]" value="Anglais"> Anglais</label>
                <label><input aria-label="Espagnol" type="checkbox" name="langue[]" value="Espagnol"> Espagnol</label>
                <label><input aria-label="Italien" type="checkbox" name="langue[]" value="Italien"> Italien</label>
                <label><input aria-label="Provençal" type="checkbox" name="langue[]" value="Provençal"> Provençal</label>
                <label><input aria-label="Allemand" type="checkbox" name="langue[]" value="Allemand"> Allemand</label>
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