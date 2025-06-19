<?php 

if (!isset($_POST["type"])) {
    $_POST["type"] = $type_activite;
}
?>

<div class="age-min">
    <img src="/images/icons/cake-fill.svg" alt="age">
    <div class="input-divers">
        <label class="label-input" for="age-min">Age min</label>
        <input id="age-min" name="age-min" type="number"  
        value="<?php echo $currentOffre["pa_age_min"] ?>" min="0" required />
    </div>
</div>

<div class="number">
    <img src="/images/icons/clock.svg" alt="Horloge">
    <div class="input-divers">
        <label class="label-input" for="nb-attraction">Nombre d'attraction</label>
        <input id="nb-attraction" name="nb-attraction" type="number"  
        value="<?php echo $currentOffre["nb_attraction"] ?>" min="0" required />
    </div>
</div>