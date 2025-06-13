

<?php


// Le paramètre donnée est un tableau de strings
// Utiliser array_column pour récupérer les libellés, voir doc comment elle fonctionne
// Fonction pour afficher un champ d'ajout multiple avec un label et un identifiant unique
function ajoutMultiple($label, $label2, $id, $donnee = []) {
    
    ?>
    <!-- Titre du champ -->
    <h3><?php echo htmlspecialchars($label2) ?></h3>
    
    <div class="ajoutMultiple-container">
        <div class="ajoutMultiple-header">
            <!-- Champ de saisie et bouton d'ajout -->
            <input type="text" id="ajoutMultipleInput_<?php echo $id ?>" placeholder="<?php echo htmlspecialchars($label) ?>" />
            <button type="button" onclick="ajouterajoutMultiple('<?php echo $id ?>')">Ajouter</button>

        </div>  
        <!-- Liste des éléments ajoutés -->
        <ul class="ajoutMultiple-list" id="ajoutMultipleList_<?php echo $id ?>">
            <?php 
                if(count($donnee) > 0) {
                    foreach ($donnee as $element) {
                        ?>
                        <li>
                            <?php echo htmlspecialchars($element) ?> 
                            <button onclick="supprimerajoutMultiple(this)">✖</button>
                        <?php
                    }
                }
            ?>
        </ul>
    </div>

   
    <?php
}
?>