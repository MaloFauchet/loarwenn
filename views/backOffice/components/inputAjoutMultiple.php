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

    <script>
        // Fonction pour ajouter un élément à la liste
        function ajouterajoutMultiple(id) {
            const input = document.getElementById('ajoutMultipleInput_' + id);
            const list = document.getElementById('ajoutMultipleList_' + id);
            const value = input.value.trim();

            if (value !== '') {
                // Création d'un nouvel élément de liste avec un bouton de suppression
                const li = document.createElement('li');
                li.innerHTML = `${value} <button onclick="supprimerajoutMultiple(this)">✖</button>`;
                list.appendChild(li);
                input.value = '';
            }
        }

        // Fonction pour supprimer un élément de la liste
        function supprimerajoutMultiple(btn) {
            btn.parentElement.remove();
        }
    </script>
    <?php
}
?>