<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Inscription PACT</title>
    <link rel="stylesheet" href="styles/components/creationCompteBackOffice.css" />
</head>


<body>
    <header></header>
    <main>
        <div>
            <img src="" alt="logo de la PACT" />
            <h2>Inscrivez-vous pour profiter du meilleur de la PACT</h2>
        </div>

        <form action="traitement.php" method="POST" class="form-container">
            <div class="grid">
                <input type="text" name="nom" placeholder="Nom" />
                <input type="text" name="prenom" placeholder="Prénom" />
            </div>

            <input type="email" name="email" placeholder="E-mail" />
            <input type="tel" name="telephone" placeholder="Téléphone" />

            <h3>Adresse</h3>
            <input type="text" name="adresse" placeholder="Adresse postale *" required />
            <input type="text" name="complement" placeholder="Complément d'adresse *" required />

            <div class="grid">
                <input type="text" name="code_postal" placeholder="Code postal *" required />
                <input type="text" name="ville" placeholder="Ville *" required />
            </div>


            <h3>Organisation</h3>
            <label class="checkbox">
                <input type="checkbox" id="entrepriseCheckbox" name="entreprise_privee" />
                Entreprise privée ?
            </label>

            <div id="entrepriseFields" style="display: none">
                <input type="text" name="denomination" placeholder="Dénomination" />
                <input type="text" name="siren" placeholder="Siren" />
                <input type="text" name="rib" placeholder="RIB" />
            </div>

            <div id="associationField" style="display: block">
                <input type="text" name="raison_sociale" placeholder="Raison sociale" />
            </div>

            <h3>Mot de passe</h3>
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" required />
            <input type="password" name="confirmation" placeholder="Confirmation mot de passe" required />

            <button type="submit">S'inscrire</button>

            <p class="conditions">
                En créant un compte, vous acceptez nos
                <a href="#">Conditions Générales</a> d’utilisation et notre
                <a href="#">Politique de confidentialité</a>.
            </p>
        </form>
    </main>
</body>
<script>
    const checkbox = document.getElementById('entrepriseCheckbox');
    const entrepriseFields = document.getElementById('entrepriseFields');
    const associationField = document.getElementById('associationField');

    checkbox.addEventListener('change', function () {
        if (checkbox.checked) {
            entrepriseFields.style.display = 'block';
            associationField.style.display = 'none';
        } else {
            entrepriseFields.style.display = 'none';
            associationField.style.display = 'block';
        }
    });
</script>

</html>