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
        value="<?php echo $currentOffre["spectacle_duree"] ?>" required />
    </div>
</div>
<div class="capactie-accueil">
    <img src="/images/icons/personnes.svg" alt="Capacité d'accueil">
    <div class="input-divers">
        <label class="label-input" for="capacite">Capacité d'accueil</label>
        <input id="capacite" name="capacite" type="number" 
        value="<?php echo $currentOffre["spectacle_capacite"] ?>" min="0" required />
    </div>
</div>
