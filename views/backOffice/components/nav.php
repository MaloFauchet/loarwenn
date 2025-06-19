<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$currentPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

$isBackOffice = ($currentPath === 'backOffice' || $currentPath === 'backOffice/');
$isAjouterOffre = ($currentPath === 'backOffice/ajouterOffre' || $currentPath === 'backOffice/ajouterOffre/');

if (!$isBackOffice && !$isAjouterOffre) {
    $isBackOffice = true;
}
?>
<nav class="nav-back-office">
    <ul>
        <li>
            <a aria-label="Mes offres" href="/backOffice/" class="<?= $isBackOffice ? 'active' : '' ?>">
                <img src="/images/icons/offres-white.svg" alt="ticket page offre"><p>Mes Offres</p>
            </a>
        </li>
        <li>
            <a aria-label="Ajouter une offre" href="/backOffice/ajouterOffre/" class="<?= $isAjouterOffre ? 'active' : '' ?>">
                <img src="/images/icons/plus-lg-white.svg" alt="plus ajouter offre"><p>Ajouter une offre</p>
            </a>
        </li>
    </ul>
</nav>