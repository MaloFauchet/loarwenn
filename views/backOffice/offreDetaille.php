<main class="contenu-back-office">
    <div class="status-offre">
        <label class="switch">
            <input class="slider-etat" type="checkbox" checked>
            <span class="slider"></span>
        </label>
        <p>En ligne</p>
    </div>
    <div class="grid-images">
        <img src="/images/offres/canyoning.jpg" alt="Canyoning">
        <img src="/images/offres/imageOffre.png" alt="Fleurs paysage">
        <img src="/images/offres/phare.png" alt="Phare">
        <img src="/images/offres/paysage.png" alt="Paysage">
        <img src="/images/offres/velo.png" alt="Vélo">
    </div>
    <div class="input-titre">
        <label class="label-input" for="email">Titre</label>
        <input id="email" type="email" required />
    </div>

    <article>
        <hr class="black-separator">
        <div class="profil-note">
            <figure class="pp-pro">
                <!--PP a recup dans la bdd -->
                <img src="/images/profils/elouan.jpg" alt="Photo de profil pro" id="pp-pro">
                <figcaption>
                    <h4>Association : Armor Naviguation
                        <!--Denomination a recup dans la bdd-->
                    </h4>
                    <?php
                // Si pro est SUPER ASSO | ORGANISATION
                echo '<p>Super Association</p>';
            ?>
                </figcaption>
            </figure>

            <div class="note">
                <h2>3.7
                    <!--Note a recup dans la bdd-->
                </h2>
                <div class="star-container">
                    <!-- On affiche le nombre d'étoiles en fonction des notes-->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-star-fill" viewBox="0 0 16 16">
                        <path
                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-star-fill" viewBox="0 0 16 16">
                        <path
                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-star-fill" viewBox="0 0 16 16">
                        <path
                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-star-fill" viewBox="0 0 16 16">
                        <path
                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-star-fill" viewBox="0 0 16 16">
                        <path
                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                </div>
                <p>sur 300 avis
                    <!--Nombre d'avis a recup dans la bdd-->
                </p>
            </div>
        </div>
        <hr class="black-separator">
        <div class="info-divers">
            <div class="telephone">
                <img src="/images/icons/telephone.svg" alt="Téléphone">
                <label class="label-input" for="telephone">Téléphone</label>
                <input id="telephone" name="telephone" type="tel" required />
            </div>
            <div class="duree">
                <img src="/images/icons/clock.svg" alt="Horloge">
                <label class="label-input" for="duree">Durée</label>
                <input id="duree" name="duree" type="text" required />
            </div>
            <div class="age-min">
                <img src="/images/icons/cake-fill.svg" alt="Gâteau d'anniversaire">
                <label class="label-input" for="age-min">Âge minimal</label>
                <input id="age-min" name="age_min" type="number" min="0" required />
            </div>
            <div class="prix">
                <img src="/images/icons/currency-euro.svg" alt="Euro">
                <label class="label-input" for="prix">Prix</label>
                <input id="prix" name="prix" type="number" step="0.01" min="0" required />
            </div>
        </div>

        <div class="lieux">
            <img src="/images/icons/geo-alt.svg" alt="Point GPS">
            <label class="label-input" for="lieu">Lieu</label>
            <input id="lieu" name="lieu" type="text" required />
        </div>

        <div class="choix-options">
            <h3>Voulez-vous prendre un option ?</h3>

            <div class="checkbox-cont">
                <p>À la une : </p>
                <input id="lieu" name="lieu" type="checkbox" />
                <label class="label-input" for="lieu">(+xx€/mois)</label>

                <p>En relief :</p>
                <input id="lieu" name="lieu" type="checkbox" />
                <label class="label-input" for="lieu">(+xx€/mois)</label>
            </div>
        </div>
    </article>
</main>