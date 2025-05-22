<a style="text-decoration:none;color:#011B43" href="<?php $_SERVER['DOCUMENT_ROOT']. "/frontOffice/offreDetaille/index.php?id=" . $valueOfOffre['id_offre'] ?>">
    <div class="card-horizontal">
        <div class="item-image">
            <img src="<?php $valueOfOffre["chemin"] ?>" alt="<?php $valueOfOffre["titre_image"] ?>">
        </div>
        <div class="item-body">
            <div class="item-title"><?= $valueOfOffre["titre_offre"]  ?></div>
            <div class="item-location">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                </svg>
                <p><?= $valueOfOffre["nom_ville"]?></p>
                <div class="tel-card">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
                    </svg>
                    <p>06 54 69 52 33</p>
                </div>
                <p>100-300 €</p>
            </div>
            <div class="item-avis">
                <p><?= $valueOfOffre["note_moyenne"]  ?></p>
                <?php afficherEtoile($valueOfOffre["note_moyenne"])  ?>
                <p><?= $valueOfOffre["nb_avis"]  ?></p>
            </div>
            <div class="item-description"> <?= $valueOfOffre["description"]  ?>
            </div>
            <div class="item-tag">
                <?php foreach ($tabTag as $id_offre => $tags) { 
                if ($id_offre === $valueOfOffre["id_offre"]) { ?>
                    <?php foreach ($tags as $tag => $value) { ?>
                       
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tags-fill" viewBox="0 0 16 16">
                                <path d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
                                <path d="M1.293 7.793A1 1 0 0 1 1 7.086V2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l.043-.043z"/>
                            </svg>
                            <p><?= $value ?></p>
                        </span>
                    <?php } ?>
               <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</a>