<?php
// Le paramètre donnée est un tableau de strings
// Utiliser array_column pour récupérer les libellés, voir doc comment elle fonctionne
// Fonction pour afficher un champ d'ajout multiple avec un label et un identifiant unique
function ajoutMultiple($label, $label2, $id, $donnee = []) {    
    ?>
    <div>
        <h3><?php echo htmlspecialchars($label2) ?></h3>
        
        <div class="ajoutMultiple-container">
            <div class="ajoutMultiple-header">
                <input aria-label="Ajouter input" 
                       type="text" 
                       id="ajoutMultipleInput_<?php echo $id ?>" 
                       placeholder="<?php echo htmlspecialchars($label) ?>" />
                       
                <button aria-label="Ajouter bouton" 
                        type="button" 
                        onclick="ajouterajoutMultiple('<?php echo $id ?>')">Ajouter</button>
            </div>  
            
            <ul class="ajoutMultiple-list" id="ajoutMultipleList_<?php echo $id ?>">
                <?php 
                if (!empty($donnee)) {
                    foreach ($donnee as $element) {
                        ?>
                        <li>
                            <?php echo htmlspecialchars($element) ?> 
                            <input type="hidden" name="ajoutMultiple_<?php echo $id ?>[]" value="<?php echo htmlspecialchars($element) ?>">
                            <button type="button" onclick="supprimerajoutMultiple(this)">✖</button>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>
<?php } ?>
