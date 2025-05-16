<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PACT</title>
    <link rel="stylesheet" href="styles/style.css">
    
</head>
<body>
    <?php require_once '../phpTemplates/headerBackOffice.php'; ?>

    <div class="page-back-office">
        <div class="container-back-office">
            <nav class="nav-back-office">
                <ul>
                    <li><a href="../html/backOffice/index.php">Mes Offres</a></li>
                    <li><a href="../html/ajouterOffre.php">Ajouter une offre</a></li>
                </ul>
            </nav>

            <main class="contenu-back-office">
                <h1>Mes Offres</h1>
                <div class="offre">
                    <div class="offre-header">
                        <h2>Offre 1</h2>
                    </div>
                    <p>Description de l'offre 1</p>
                </div>
                <div class="offre">
                    <div class="offre-header">
                        <h2>Offre 2</h2>
                    </div>
                    <p>Description de l'offre 2</p>
                </div>
            </main>
        </div>

        <footer class="footer-back-office">
            <?php require_once '../phpTemplates/footerFront.php'; ?>
        </footer>
    </div>

    
    

</body>
</html>