<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<?php
$currentPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

?>
<nav class="nav-back-office">
    <ul>
        <li>
            <a href="/backOffice/" class="<?= ($currentPath === 'backOffice' || $currentPath === 'backOffice/') ? 'active' : '' ?>">
                <img src="/images/icons/offres-white.svg"><p>Mes Offres</p>
            </a>
        </li>
        <li>
            <a href="/backOffice/ajouterOffre/" class="<?= ($currentPath === 'backOffice/ajouterOffre' || $currentPath === 'backOffice/ajouterOffre/') ? 'active' : '' ?>">
                <img src="/images/icons/plus-lg-white.svg"><p>Ajouter une offre</p>
            </a>
        </li>
    </ul>
</nav>