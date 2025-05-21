<main>
    <div class="overlay"></div>
    <div class="container">
        <nav>
            <a href="/"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                </svg></a>
            <a href="/"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                </svg></a>
        </nav>
        <form action="creationPro.php" method="POST" class="form-container">
            <br>
            <div>
                <img src="/images/logos/logoBlue.png" alt="logo de la PACT" />
                <h2>Inscrivez-vous pour profiter du meilleur de la PACT</h2>
            </div>
            <div class="grid">
                <div>
                    <label for="nom">Nom</label>
                    <input id="nom" type="text" required />
                </div>
                <div>
                    <label for="prenom">Prenom</label>
                    <input id="prenom" type="text" required />
                </div>
            </div>

            <label for="email">E-mail</label>
            <input id="email" type="email" required />

            <label for="telephone">Téléphone</label>
            <input type="tel" id="telephone" required />

            <h3>Adresse</h3>

            <label for="adresse">Adresse</label>
            <input type="text" id="adresse" required />

            <label for="complement">Complément</label>
            <input type="text" for="complement" required />

            <div class="grid">
                <div>
                    <label for="codePostal">Code Postal</label>
                    <input type="text" id="codePostal" required />
                </div>
                <div>
                    <label for="ville">Ville</label>
                    <input type="text" id="ville" required />
                </div>
            </div>


            <h3>Organisation</h3>
            <div class="checkbox-container">
                <input type="checkbox" id="entrepriseCheckbox" name="entreprise_privee" />
                <label class="checkbox" for="entrepriseCheckbox"> Entreprise privée ? </label>
            </div>


            <div class="option" id="entrepriseChamps" style="display: none">
                <label for="denomination">Dénomination</label>
                <input type="text" id="denomination" required />
                <label for="siren">Siren</label>
                <input type="phptext" id="siren" required />
                <label for="rib">RIB</label>
                <input type="text" id="rib" required />
            </div>

            <div class="option" id="associationChamps" style="display: flex">
                <label for="raisonSociale">Raison Sociale</label>
                <input type="text" id="raisonSociale" required />
            </div>

            <h3>Mot de passe</h3>
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" id="mot_de_passe" required />
            <label for="confirmation">Confirmation</label>
            <input type="password" id="confirmation" required />

            <button type="submit">S'inscrire</button>

            <p class="conditions">
                En créant un compte, vous acceptez nos
                <a href="#">Conditions Générales</a> d’utilisation et notre
                <a href="#">Politique de confidentialité</a>.
            </p>
        </form>
    </div>

</main>

<script>
    const checkbox = document.getElementById('entrepriseCheckbox');
    const entrepriseChamps = document.getElementById('entrepriseChamps');
    const associationChamps = document.getElementById('associationChamps');

    checkbox.addEventListener('change', function() {
        if (checkbox.checked) {
            entrepriseChamps.style.display = 'flex';
            associationChamps.style.display = 'none';
        } else {
            entrepriseChamps.style.display = 'none';
            associationChamps.style.display = 'flex';
        }
    });
</script>