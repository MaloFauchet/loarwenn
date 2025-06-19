<?php
function afficherTag($tags, $libelle, $id_activite) {
    echo "<h4>Tags liés à l'activité : " . htmlspecialchars($libelle) . "</h4>";

    echo "<input type='hidden' name='id_activite' value='" . htmlspecialchars($id_activite) . "'>";

    echo "<div style='display: flex; flex-wrap: wrap; gap: 0.5em;'>";
    foreach ($tags as $index => $tag) {
        $tagId = 'tag_' . $index;
        echo "<label for='$tagId' style='border: 1px solid #ccc; border-radius: 5px; padding: 0.3em 0.6em; background: #f4f4f4; cursor: pointer;'>";
        echo "<input type='checkbox' id='$tagId' name='tags[]' value='" . htmlspecialchars($tag) . "' style='margin-right: 0.3em;'>";
        echo htmlspecialchars($tag);
        echo "</label>";
    }
    echo "</div>";
}
?>