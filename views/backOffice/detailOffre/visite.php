<?php 

if (!isset($_POST["type"])) {
    $_POST["type"] = $type_activite;
}
?>

<div class="duree">
                <img src="/images/icons/clock.svg" alt="Horloge">
                <div class="input-divers">
                    <label class="label-input" for="duree">Durée (h)</label>
                    <input id="duree" name="duree" type="time"  
                    value="<?php echo $currentOffre["visite_duree"] ?>" min="0" required />
                </div>
            </div>