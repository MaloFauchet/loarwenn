<main>
    <div class="overlay"></div>
    <div class="container">
        <nav>
            <a href="#" onclick="window.history.back()" aria-label="Retour" title="Retour" role="link">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
                    class="bi bi-chevron-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                </svg>
            </a>
            <a href="/" aria-label="Fermer" title="Fermer" role="link">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                    class="bi bi-x" viewBox="0 0 16 16">
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                </svg>
            </a>
        </nav>
        <form action="" method="POST" class="form-container">
            <br>
            <div>
                <img src="/images/logos/logoBlue.png" alt="logo de la PACT" />
                <h2>Entrez le code généré par votre application</h2>
            </div>

            <label class="label-input" for="otp">Code OTP</label>
            <input id="otp" type="text" name="otp" required />
            <?php 
            if($idPro) {
                ?><input aria-label="Professionnel" type="hidden" name="id_pro" value="<?php echo htmlspecialchars($idPro); ?>"><?php
            }
            if(isset($_SESSION['messageOtp'])) {
                ?><p style="color:red;"><?php echo htmlspecialchars($_SESSION['messageOtp']); ?></p><?php
            }
            ?>
            <button aria-label="Valider" type="submit">Valider</button>
        </form>
    </div>
</main>