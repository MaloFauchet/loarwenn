<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PACT</title>
    <link rel="stylesheet" href="/styles/style.css">
    
</head>
<body>
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/../views/backOffice/components/header.php'); ?>

    <div class="page-back-office">
        <div class="container-back-office">
            
            <?php require_once($_SERVER['DOCUMENT_ROOT'].'/../views/backOffice/components/nav.php'); ?>
            

            <main class="contenu-back-office">
                <h1>Mes Offres</h1>
                <div class="offre">
                    <div class="offre-header">
                        <h2>Offre 1</h2>
                    </div>
                    <p>Description de l'offre 1</p>

                </div>  
            </main>
        </div>

        <?php require_once($_SERVER['DOCUMENT_ROOT'].'/../views/backOffice/components/footer.php'); ?>
    </div>

    
    

</body>
</html>