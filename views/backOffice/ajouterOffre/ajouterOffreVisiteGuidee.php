

<style>
    .champ-type-offre button {
        width: 20em;
        padding: 10px;
        font-size: 1rem;
        box-sizing: border-box;
    }

   
</style>

        <h3 class="nameActivite">Champs liées a l'offre Visite guidé</h3>
        <div class="champ-type-offre-row">
            <div class="champ-type-offre">
                <h3>Durée de la visite</h3>
                <label class="label-input" for="duree">Durée</label>
                <input id="duree" name="duree" type="time" required />
            </div>

            <div class="champ-type-offre">
                <h3>Langue</h3>
                <div id="langue-checkboxes">
                    <div class="checkbox-column">
                        <label>
                            <input type="checkbox" name="langue[]" value="Francais">
                            <img src="/images/drapeaux/france.jpg" alt="Français">
                            Francais
                        </label>
                        <label>
                            <input type="checkbox" name="langue[]" value="Anglais">
                            <img src="/images/drapeaux/angleterre.jpg" alt="Anglais">
                            Anglais
                        </label>
                        <label>
                            <input type="checkbox" name="langue[]" value="Espagnol">
                            <img src="/images/drapeaux/espagne.png" alt="Espagnol">
                            Espagnol
                        </label>
                    </div>
                    <div class="checkbox-column">
                        <label>
                            <input type="checkbox" name="langue[]" value="Italien">
                            <img src="/images/drapeaux/italie.png" alt="Italien">
                            Italien
                        </label>
                        <label>
                            <input type="checkbox" name="langue[]" value="Provençal">
                            <img src="/images/drapeaux/provence.png" alt="Provençal">
                            Provençal
                        </label>
                        <label>
                            <input type="checkbox" name="langue[]" value="Allemand">
                            <img src="/images/drapeaux/allemagne.jpg" alt="Allemand">
                            Allemand
                        </label>
                    </div>
                </div>
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
   
    
        
       
        
   