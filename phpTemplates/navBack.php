<?php

$currentPage = basename($_SERVER['PHP_SELF']);
?>
<nav class="nav-back-office">
    <ul>
        <li>
            <a href="/backOffice/index.php" class="<?= $currentPage === 'index.php' ? 'active' : '' ?>">
                <img src="/images/icons/offres-white.svg"><p>Mes Offres</p>
            </a>
        </li>
        <li>
            <a href="/backOffice/addOffre.php" class="<?= $currentPage === 'ajouterOffre.php' ? 'active' : '' ?>">
                <img src="/images/icons/plus-lg-white.svg"><p>Ajouter une offre</p>
            </a>
        </li>
    </ul>
</nav>