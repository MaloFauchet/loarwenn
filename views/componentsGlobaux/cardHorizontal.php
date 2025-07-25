<a aria-label="Une offre" style="text-decoration:none;color:#011B43" href="<?="/frontOffice/offreDetaille/index.php?id=" . $valueOfOffre['id_offre'] ?>" class="a-card">
    <div class="card-horizontal">
        <div class="item-image">
            <img src="<?= $valueOfOffre["chemin"] ?$valueOfOffre["chemin"] : "/images/offres/missingImage.png" ?>" alt="<?php $valueOfOffre["titre_image"] ?>">
        </div>
        <div class="item-body">
            <div class="item-title"><?= $valueOfOffre["titre_offre"]  ?></div>
            <div class="item-location">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                </svg>
                <p><?= $valueOfOffre["numero_adresse"] . ' ' . $valueOfOffre["voie"] . ', ' . $valueOfOffre["nom_ville"] . ', ' . $valueOfOffre["code_postal"]?></p>
            </div>
            <div class="item-description">
                <?php 
                    $description =  substr($valueOfOffre["description"], 0, 200);
                    if (strlen($valueOfOffre["description"]) > 200) {
                        $description .= '...';
                    }
                    echo $description;
                ?>
            </div>
            <div class="container-avis-tags">
                <div class="item-avis">
                    <?php if ($valueOfOffre["note_avis"]) : ?>
                        <p><?= $valueOfOffre["note_avis"]  ?></p>
                        <?= afficherEtoile($valueOfOffre["note_avis"]) ?>
                        <p>(<?= $valueOfOffre["nb_avis"]  ?>)</p>
                    <?php else: ?>
                        <p>Aucun avis</p>
                    <?php endif;?>
                </div>
                <div class="item-tag">
                    <?php 
                    if($valueOfOffre['tags']) {
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
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
            
    </div>
</a>