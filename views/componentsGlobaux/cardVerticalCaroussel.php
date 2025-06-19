<div>
    <a aria-label="Une offre" style="text-decoration:none;color:#011B43"
        href="<?="/frontOffice/offreDetaille/index.php?id=" . $valueOfOffre['id_offre'] ?>" class="a-card">
        <div>
            <?php 
        if ($valueOfOffre["En relief"]) { ?>
            <div class="recommended">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-patch-check-fill" viewBox="0 0 16 16">
                        <path
                            d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708" />
                    </svg>
                    <p>Recommandé</p>
                </div>
            </div>
            <?php } ?>
            <div class="item-image">
                <img src="<?= $valueOfOffre["chemin"] ?$valueOfOffre["chemin"] : "/images/offres/missingImage.png" ?>"
                    alt="<?php $valueOfOffre["titre_image"] ?>">

            </div>
            <div class="item-body">
                <div class="item-title"><?= $valueOfOffre["titre_offre"]  ?></div>
                <div class="item-location">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                    </svg>
                    <p><?= $valueOfOffre["numero_adresse"] . ' ' . $valueOfOffre["voie"] . ', ' . $valueOfOffre["nom_ville"] . ', ' . $valueOfOffre["code_postal"]?>
                    </p>
                </div>
                <div class="item-avis">
                    <?php 
                    if ($valueOfOffre["note_avis"]) : ?>
                    <p><?= $valueOfOffre["note_avis"]  ?></p>
                    <?= afficherEtoile($valueOfOffre["note_avis"]) ?>
                    <p>(<?= $valueOfOffre["nb_avis"]  ?>)</p>
                    <?php endif; ?>
                </div>
                <div class="item-description"> <?= $valueOfOffre["description"]  ?>
                </div>
                <div class="item-tag">
                    <?php 
                    $allTagsOffre = explode(',', $valueOfOffre['tags']);
                    $i = 0;
                    foreach ($allTagsOffre as $id_offre => $tag) {
                        if ($i < 3) { 
                        ?>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-tags-fill" viewBox="0 0 16 16">
                                    <path d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3" />
                                    <path d="M1.293 7.793A1 1 0 0 1 1 7.086V2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l.043-.043z" />
                                </svg>
                                <p><?= $tag ?></p>
                            </span>
                        <?php 
                            $i++;
                        } 
                        if ($i === 3) { 
                            ?>
                            <span>
                                <p>...</p>
                            </span>
                            <?php 
                            break;
                        } 
                    }?>
                </div>

            </div>
        </div>
    </a>
</div>