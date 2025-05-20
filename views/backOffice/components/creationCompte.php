<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Inscription PACT</title>
    <link rel="stylesheet" href="/styles/components/creationCompteBackOffice.css" />
</head>


<body>
    <main>
        <div>
            <img src="/images/logos/logoBlue.png" alt="logo de la PACT" />
            <h2>Inscrivez-vous pour profiter du meilleur de la PACT</h2>
        </div>

        <form action="traitement.php" method="POST" class="form-container">
            <div class="grid">
                <div>
                    <label for="nom">Nom</label>
                    <input id="nom" type="text" required/>
                </div>
                <div>
                    <label for="prenom">Prenom</label>
                    <input id="prenom" type="text" required/>
                </div>
            </div>

            <label for="email">E-mail</label>
            <input id="email" type="email" required/>

            <label for="telephone">Téléphone</label>
            <input type="tel" id="telephone" required/>

            <h3>Adresse</h3>

            <label for="adresse">Téléphone</label>
            <input type="text" id="adresse" required />

            <label for="complement">Téléphone</label>
            <input type="text" for="complement" required />

            <div class="grid">
                <div>
                    <label for="code_postal">Téléphone</label>
                    <input type="text" id="code_postal" required />
                </div>
                <div>
                    <label for="ville">Téléphone</label>
                    <input type="text" id="ville" required />
                </div>
            </div>


            <h3>Organisation</h3>
            <label class="checkbox">
                <input type="checkbox" id="entrepriseCheckbox" name="entreprise_privee" />
                Entreprise privée ?
            </label>

            <div id="entrepriseFields" style="display: none">
                <label for="denomination">Dénomination</label>
                <input type="text" id="denomination" required/>
                <label for="siren">Siren</label>
                <input type="text" id="siren" required/>
                <label for="rib">RIB</label>
                <input type="text" id="rib" required/>
            </div>

            <div id="associationField" style="display: block">
                <label for="raison_sociale">RIB</label>
                <input type="text" id="raison_sociale" required/>
            </div>

            <h3>Mot de passe</h3>
            <label for="mot_de_passe">RIB</label>
            <input type="password" id="mot_de_passe" required />
            <label for="confirmation">RIB</label>
            <input type="password" id="confirmation" required />

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