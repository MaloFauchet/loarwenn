<?php
session_start();
// Vérification de la session
if (!isset($_SESSION['id_utilisateur'])) {
    header('Location: /frontOffice/connexion/connexionPro.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>PACT</title>
    <link rel="icon" type="image/png" href="/images/logos/logoBlue.png">
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/components/headerBackOffice.css">
    <link rel="stylesheet" href="/styles/components/navBackOffice.css">
    <link rel="stylesheet" href="/styles/components/footerBackOffice.css">
    <link rel="stylesheet" href="/styles/backOffice.css">
</head>
<body>
    <?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/components/header.php'); ?>
    <div class="page-back-office">
        <div class="container-back-office">
            <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/components/nav.php'); ?>
            <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/../views/backOffice/pageAccueil.php');?>
        </div>
    </div>
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/../views/backOffice/components/footer.php'); ?>

    <script>
document.addEventListener("DOMContentLoaded", function () {
    
    /**
     * 
     * Pour chaque offre, on recupère le checkbox et l'id de l'offre.
     */
    document.querySelectorAll('.offre').forEach(function (offre) {
        const checkbox = offre.querySelector('.slider-etat');
        const idOffre = offre.getAttribute('data-id');

        if (checkbox) {

            /**
             * Pour chaque slider, on ajoute un listener au click.
             */
            checkbox.addEventListener('click', function (e) {
                e.preventDefault(); // On empêche le changement immédiat


                /**
                 * Si la checkox est cochée
                 */
                if (checkbox.checked) {

                    /**
                     * On ouvre la modale de publication
                     */
                    const modalPub = document.getElementById('modal-publication');
                    modalPub.style.display = 'flex';
                    modalPub.setAttribute('data-id', idOffre);
                    modalPub.querySelector('input[name="id_offre"]').value = idOffre;

                    /**
                     * Ajout d'un ecouteur d'événement pour fermer la modale
                     */
                    
                
                    /**
                     *   On clone le formulaire de publication
                     *  On supprime tout ancien listener avant d’en ajouter un nouveau
                     */
                    const onlineForm = document.getElementById('onlineForm');
                    const newForm = onlineForm.cloneNode(true);
                    onlineForm.parentNode.replaceChild(newForm, onlineForm);


                    /**
                     * Ajout d'un listener au bouton de fermeture de la modale
                     */
                    const closeBtnPub = newForm.querySelector('button[type="reset"]');
                    if (closeBtnPub) {
                        closeBtnPub.addEventListener('click', function () {
                            document.getElementById('modal-publication').style.display = 'none';
                        });
                    }

                    /**
                     * 
                     * Si une des options est cochée, on affiche le champ "Nombre de semaines"
                     * Sinon, on le cache.
                     */
                    const optionInput = document.querySelectorAll('input[type="checkbox"]');
                    optionInput.forEach(c => {
                        c.addEventListener('change', function () {
                            if (c.checked) {
                                newForm.querySelector(' div:nth-child(4)').style.display = "block";
                            }else{
                                newForm.querySelector(' div:nth-child(4)').style.display = "none";
                            }
                        });
                    });
                    /**
                     * Gestion du click sur le bouton "Publier"
                     */
                    newForm.addEventListener('submit', function (e) {
                        e.preventDefault();

                        // Récupération des données du formulaire
                        const formData = new FormData(newForm);

                        //Envoie d'une requete AJAX au script PHP pour la publication de l'offre
                        fetch('/scriptPHP/publicationOffre.php', {
                            method: 'POST',
                            body: formData
                        })

                        // Traitement de la réponse du serveur
                        .then(res => res.json())
                        .then(data =>{

                            // Si la publication est réussie, on met à jour le slider et le texte de statut
                            // Sinon, on affiche une alerte d'erreur
                            if (data.success) {
                                offre.querySelector('.status-text').textContent = 'En ligne';
                                checkbox.checked = true;
                            } else {
                                alert('Erreur lors de la publication');
                                checkbox.checked = false;
                            }

                            //On cache la modale de publication
                            modalPub.style.display = 'none';
                        });
                    });
                } else {
                    // Ouverture de la modale dépublication
                    const modalDepub = document.getElementById('modal-depublication');
                    modalDepub.style.display = 'flex';
                    modalDepub.setAttribute('data-id', idOffre);
                    modalDepub.querySelector('input[name="id_offre"]').value = idOffre;

                    /**
                     *  On clone le formulaire de publication
                     *  On supprime tout ancien listener avant d’en ajouter un nouveau
                     */
                    const outlineForm = document.getElementById('outlineForm');
                    const newForm = outlineForm.cloneNode(true);
                    outlineForm.parentNode.replaceChild(newForm, outlineForm);

                    /**
                     * Ajout d'un listener au bouton de fermeture de la modale
                     */
                    const closeBtnDepub = newForm.querySelector('button[type="reset"]');
                    if (closeBtnDepub) {
                        closeBtnDepub.addEventListener('click', function () {
                            document.getElementById('modal-depublication').style.display = 'none';
                        });
                    }

                    /**
                     * Gestion du click sur le bouton "Dépublier"
                     * On ajoute un listener au formulaire de dépublication
                     * Lors de la soumission, on envoie une requête AJAX au script PHP pour la dépublication de l'offre
                     */
                    newForm.addEventListener('submit', function (e) {
                        e.preventDefault();

                        fetch('/scriptPHP/dePublicationOffre.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ id_offre: idOffre })
                        })

                        // Traitement de la réponse du serveur
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                offre.querySelector('.status-text').textContent = 'Hors ligne';
                                checkbox.checked = false;
                            } else {
                                alert('Erreur lors de la dépublication');
                                checkbox.checked = true;
                            }
                            modalDepub.style.display = 'none';
                        });
                    });
                }
            });
        }
    });

    document.querySelectorAll('button[type="reset"]').forEach(btn => {
        console.log(btn);
        btn.addEventListener('click', function() {
            console.log('Bouton de fermeture cliqué');
            let modalPubli = document.getElementById('modal-publication');
            let modalDePubli = document.getElementById('modal-depublication');
            console.log("modal1 : " + modalPubli + " modal2 : " + modalDePubli);
            modalPubli.style.display = 'none';
            modalDePubli.style.display = 'none';
        });
    });;
});
</script>
</body>
</html>
