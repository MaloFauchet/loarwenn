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
        value="<?php echo $currentOffre["activite_duree"] ?>" required />
    </div>
</div>
<div class="age-min">
    <img src="/images/icons/cake-fill.svg" alt="Horloge">
    <div class="input-divers">
        <label class="label-input" for="age">Age minimum</label>
        <input id="age-min" name="age-min" type="number"  
        value="<?php echo $currentOffre["activite_age"] ?>" min="0" required />
    </div>
</div>
