<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de connexion</title>
</head>
<body>
    <header>
        <a href="index.php">
            <img src="/images/icons/x.svg" alt="Retour">
        </a>
    </header>
    <main>
        <img src="/images/logos/logoBlue.png" alt="logoBlue">
        <h1>Heureux de vous revoir</h1>
        <form action="" method="post">
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>
            <p>Mot de passe oublié ?</p>
            <div>
                <input type="checkbox" name="saveme" id="saveme">
                <label for="saveme">Se souvenir de moi</label>
            </div>
            <button type="submit">Se connecter</button>
        </form>
        <p>Inscription pour membre</p>
        <button>S'inscrire</button>
        <p>Si vous êtes un professionnel,</p>
        <p><strong>inscrivez-vous ici</strong></p>
        <p>
            En créant ou en vous connectant à un compte,
            vous acceptez nos Conditions Générales d'Utilisations et nos Conditions Générales de Ventes
        </p>
    </main>
</body>
</html>