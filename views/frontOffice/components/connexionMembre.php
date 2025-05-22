
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
        <form action="" method="POST" class="form-container">
            <br>
            <div>
                <img src="/images/logos/logoBlue.png" alt="logo de la PACT" />
                <h2>Heureux de vous revoir !</h2>
            </div>

            <label class="label-input" for="email">E-mail</label>
            <input id="email" type="email" name="email" required />

            <label class="label-input" for="mot-de-passe">Mot de passe</label>
            <input type="password" id="mot-de-passe" name="mot-de-passe" required />

            <button type="submit">Se connecter</button>

            <button type="submit">S'inscrire</button>

            <p>
                Si vous êtes un professionnel, <br>
                <a href="connexionPro.php">C'est par ici !</a>
            </p>
            <p class="conditions">
                En créant un compte, vous acceptez nos
                <a href="#">Conditions Générales</a> d'utilisation et notre
                <a href="#">Politique de confidentialité</a>.
            </p>
        </form>
    </div>
</main>