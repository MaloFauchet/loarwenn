<?php
require_once('../controllers/UtilisateurController.php');

$controller = new UtilisateurController();
$utilisateurs = $controller->afficherUtilisateurs();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="styles/frontOffice.css">
</head>
<body>
    <main>
        <!-- Header compris dans le composant pageAccueil -->
        <?php 
            require_once('../views/frontOffice/pageAccueil.php'); 
            // require_once('../views/backOffice/pageAccueil.php');
        ?>
    </main>

    <?php require_once('../views/frontOffice/components/footer.php'); ?>

    <h1>Liste des utilisateurs</h1>

<table border="1" cellpadding="10" style="margin-top: 100px;">
    <tr>
        <th>ID</th>
        <th>Type</th>
        <th>Email</th>
        <th>Téléphone</th>
        <th>Nom complet / Dénomination</th>
    </tr>

    <?php foreach ($utilisateurs as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['id_utilisateur']) ?></td>
            <td><?= htmlspecialchars($user['type']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['num_telephone']) ?></td>
            <td>
                <?php
                    if ($user['type'] === 'membre') {
                        echo htmlspecialchars($user['prenom'] . ' ' . $user['nom'] . ' (' . $user['pseudo'] . ')');
                    } elseif ($user['type'] === 'prive') {
                        echo htmlspecialchars($user['denomination']);
                    } elseif ($user['type'] === 'public') {
                        echo htmlspecialchars($user['raison_sociale']);
                    }
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>