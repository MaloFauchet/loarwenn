<?php

// Fonction pour afficher un champ d'ajout multiple avec un label et un identifiant unique
function ajoutMultiple($label, $label2, $id) {
    // Nom du champ dynamique selon l'ID pour bien les distinguer
    $name = '';
    switch ($id) {
        case 1: $name = 'prestation_incluse'; break;
        case 2: $name = 'prestation_exclue'; break;
        case 3: $name = 'tags'; break;
        default: $name = 'champ_multiple_' . $id; break;
    }
    ?>
    <h3><?php echo htmlspecialchars($label2) ?></h3>
    <div class="ajoutMultiple-container">
        <div class="ajoutMultiple-header">
            <input type="text" id="ajoutMultipleInput_<?php echo $id ?>" placeholder="<?php echo htmlspecialchars($label) ?>" />
            <button type="button" onclick="ajouterajoutMultiple('<?php echo $id ?>', '<?php echo $name ?>')">Ajouter</button>
        </div>
        <ul class="ajoutMultiple-list" id="ajoutMultipleList_<?php echo $id ?>"></ul>
    </div>

    <script>
        function ajouterajoutMultiple(id, name) {
            const input = document.getElementById('ajoutMultipleInput_' + id);
            const list = document.getElementById('ajoutMultipleList_' + id);
            const value = input.value.trim();

            if (value !== '') {
                const li = document.createElement('li');
                li.innerHTML = `
                    ${value}
                    <input type="hidden" name="${name}[]" value="${value}">
                    <button type="button" onclick="supprimerajoutMultiple(this)">✖</button>
                `;
                list.appendChild(li);
                input.value = '';
            }
        }

        function supprimerajoutMultiple(btn) {
            btn.parentElement.remove();
        }
    </script>
    <?php
}

?>