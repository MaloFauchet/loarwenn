<main>
    <div class="overlay"></div>
    <div class="container">
        <nav>
            <a href="#" onclick="window.history.back()"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                </svg></a>
            <a href="/"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                </svg></a>
        </nav>
        <form action="/scriptPHP/creationMembre.php" method="POST" class="form-container">
            <br>
            <div>
                <img src="/images/logos/logoBlue.png" alt="logo de la PACT" />
                <h2>Inscrivez-vous pour profiter du meilleur de la PACT</h2>
            </div>
            <div class="grid">
                <div>
                    <label class="label-input" for="nom">Nom</label>
                    <input id="nom" name="nom" type="text" required />
                </div>
                <div>
                    <label class="label-input" for="prenom">Prenom</label>
                    <input id="prenom" name="prenom" type="text" required />
                </div>
            </div>

            <label class="label-input" for="pseudo">Pseudo</label>
            <input id="pseudo" name="pseudo" type="text" required />

            <label class="label-input" for="email">E-mail</label>
            <input id="email" name="email" type="email" required />

            <label class="label-input" for="telephone">Téléphone</label>
            <input type="tel" id="telephone" name="telephone" required />

            <h3>Adresse</h3>

            <div class="grid">
                <div class="smaller">
                    <label class="label-input" for="num">Numéro</label>
                    <input type="number" id="num" name="num" required />
                </div>
                <div class="bigger">
                    <label class="label-input" for="voie">Voie</label>
                    <input type="text" id="voie" name="voie" required />
                </div>
            </div>

            <label class="label-input" for="complement">Complément</label>
            <input type="text" id="complement" name="complement" />

            <div class="grid">
                <div>
                    <label class="label-input" for="codePostal">Code Postal</label>
                    <input type="text" id="codePostal" name="codePostal" required />
                </div>
                <div>
                    <label class="label-input" for="ville">Ville</label>
                    <input type="text" id="ville" name="ville" required />
                </div>
            </div>

            <h3>Mot de passe</h3>
            <label class="label-input" for="mot_de_passe">Mot de passe</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required />
            <label class="label-input" for="confirmation">Confirmation</label>
            <input type="password" id="confirmation" name="confirmation" required />

            <button type="submit" id="inscrire" class="disabled">S'inscrire</button>

            <p class="conditions">
                En créant un compte, vous acceptez nos
                <a href="#">Conditions Générales</a> d’utilisation et notre
                <a href="#">Politique de confidentialité</a>.
            </p>
        </form>
    </div>
</main>

<script>
    const motDePasse = document.getElementById('mot_de_passe');
    const confirmation = document.getElementById('confirmation');
    const submitBtn = document.getElementById('inscrire');

    function checkInputs() {
        if (motDePasse.value === confirmation.value && motDePasse.value.trim() !== '') {
            submitBtn.classList.remove('disabled');
        } else {
            submitBtn.classList.add('disabled');
        }
    }

    motDePasse.oninput = checkInputs;
    confirmation.oninput = checkInputs;
</script>