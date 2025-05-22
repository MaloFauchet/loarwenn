SET SCHEMA 'tripenazor';

-- 1. Ville (doit être insérée en premier car référencée par d'autres tables)
INSERT INTO ville (nom_ville, code_postal) VALUES
('Lannion', '22300'),
('Perros-Guirec', '22700'),
('Pleumeur-Bodou', '22560'),
('Rospez', '22400'),
('Tréguier', '22220'),
('Paimpol', '22500'),
('Guingamp', '22200'),
('Saint-Brieuc', '22000'),
('Ploubezre', '22300'),
('Louannec', '22700'),
('Trélévern', '22660'),
('Trébeurden', '22560'),
('Minihy-Tréguier', '22220'),
('Plouha', '22580'),
('Ploumagoar', '22970'),
('Plérin', '22190'),
('Binic-Étables-sur-Mer', '22520'),
('Lanvollon', '22290');

-- 2. Utilisateur (professionnels et membres dépendent de cette table)
INSERT INTO utilisateur (id_ville, prenom, nom, num_telephone, email, adresse, complement_adresse, mot_de_passe) VALUES
(3, 'Noémie', 'Faure', '0296345678', 'noemie.faure@example.com', '7 Rue des Acacias', '', '$2y$10$zxy/fQ18EZKSp8WBOuo1y.ULyufuMUfVgZLI7j4.Mit5WwPp0XoZe'),
(4, 'Alexandre', 'Gilles', '0296987654', 'alexandre.gilles@example.com', '10 Boulevard de la Mer', 'Bât C', '$2y$10$eSsA46lkDnjnUpgQFkOXHuBBqGWgPv215HiDu46zhWchzqvARJZv2'),
(5, 'Lucie', 'Benoit', '0296677889', 'lucie.benoit@example.com', '2 Rue du Stade', '', '$2y$10$U3K/u8LhrwTDvaXiqoieu.3hjzKQxrQ/WOo1bStfQKmeYHwihpX9K'),
(6, 'Romain', 'Philippe', '0296554433', 'romain.philippe@example.com', '21 Rue de l’Église', '', '$2y$10$.bmTuUleXlpDTXZgKeVr6O9N244qisBkasa/CZFS3VzyNAop315ly'),
(7, 'Isabelle', 'Lemoine', '0296213456', 'isabelle.lemoine@example.com', '18 Avenue des Chênes', '', '$2y$10$GXlUTGX0k.jofnD9GVVbd.qlauEpgTOCW8eG3Yy.c.9/SLnDDNRs2'),
(8, 'Gaëtan', 'Cousin', '0296123900', 'gaetan.cousin@example.com', '3 Rue de la Gare', '', '$2y$10$BbxUR0YIXUQS4Svla8N1FOX4iMXf81JsYaWZkMlSQpJM/90zQ3pp2'),
(5, 'Mélanie', 'Andre', '0296127788', 'melanie.andre@example.com', '15 Chemin Vert', '', '$2y$10$HMPZTY4TMRiRtJ5xIzqhk.RPnrcQ7Az4ABsfUsWUZr6ikoSJIsb7q'),
(6, 'Quentin', 'Robert', '0296998877', 'quentin.robert@example.com', '19 Rue des Hirondelles', '', '$2y$10$O.i4lWtspTdaxSigYhiZfuiD7SlwkyeIEFSjrjsecqeGeOVaWJIOK'),
(7, 'Sarah', 'Colin', '0296552211', 'sarah.colin@example.com', '24 Rue des Peupliers', '', '$2y$10$qzElRhDBtHB7ZCBeIGh8SuW1jZ4Eac1BWX3SbCiXfZjmltPYNuye6'),
(8, 'Baptiste', 'Durand', '0296775544', 'baptiste.durand@example.com', '6 Impasse des Mimosas', '', '$2y$10$OmAh2lo6MYmReqnROdYrBuSN3VV56uYCAxjlN7X.C5kbA1n52DoFe');



-- 3. Professionnel (hérite de utilisateur)
INSERT INTO professionnel (id_utilisateur) VALUES
(1),
(2),
(3),
(4),
(6),
(7);

-- 4. Professionnel_prive
INSERT INTO professionnel_prive (id_utilisateur, denomination, siren, rib) VALUES
(1, 'Mme Agnès Pinson', 519495882, 'FR7630001007941234567890185'),
(2, 'Armor Navigation SAS', 398414698, 'FR7630001007949876543210185');

-- 5. Professionnel_public
INSERT INTO professionnel_public (id_utilisateur, raison_sociale) VALUES
(3, 'Association Trégor Bicyclette'),
(4, 'Mairie de Lannion');

-- 6. Membre
INSERT INTO membre (id_utilisateur, pseudo) VALUES
(5, 'jeand'),
(6, 'sophiem');

-- 7. Image
INSERT INTO image (titre_image, chemin) VALUES
('Kayak Bréhat', '/images/offres/kayak-randonne.png'),
('Vélo Trégor', '/images/offres/velo-randonne.png'),
('Château Roche Jagu', '/images/offres/chateau.png'),
('7 Îles', '/images/offres/7iles.png'),
('Village Gaulois', '/images/offres/village-gaulois.png'),
('Restaurant Ville Blanche', '/images/offres/restaurant.png'),
('Magie des Arbres', '/images/offres/arbres.png'),
('Centre Lannion', '/images/offres/lannion.png'),
('Photo de profil', '/images/profils/1.jpg'),
('Photo de profil', '/images/profils/2.jpg'),
('Photo de profil', '/images/profils/3.jpg'),
('Photo de profil', '/images/profils/4.jpg'),
('Photo de profil', '/images/profils/5.jpg'),
('Photo de profil', '/images/profils/6.jpg'),
('Photo de profil', '/images/profils/7.jpg'),
('Photo de profil', '/images/profils/8.jpg'),
('Photo de profil', '/images/profils/9.jpg'),
('Photo de profil', '/images/profils/10.jpg');

-- 8. Utilisateur_represente_image
INSERT INTO utilisateur_represente_image (id_utilisateur, id_image) VALUES
(1, 9),
(2, 10),
(3, 11),
(4, 12),
(5, 13),
(6, 14),
(7, 15),
(8, 16),
(9, 17),
(10, 18);

-- 10. Type_activite
INSERT INTO type_activite (libelle_activite) VALUES
('Activité'),
('Spectacle'),
('Visite guidée'),
('Parc d''attraction'),
('Restaurant'),
('Visite non guidée');


-- 14. Offre (table parent)
INSERT INTO offre (id_ville, id_type_activite, titre_offre, note_moyenne, nb_avis, en_ligne, resume, description, adresse_offre) VALUES
(1, 1, 'Archipel de Bréhat en kayak', 4.7, 42, TRUE, 'Découverte des îles en kayak de mer', 'Excursion guidée autour des îles de l''archipel de Bréhat avec un guide diplômé.', 'Port de Ploumanach'),
(1, 1, 'Balade familiale à vélo', 4.5, 35, TRUE, 'Balade à vélo dans le Trégor', 'Sortie familiale sur petites routes tranquilles adaptée aux enfants.', '3 Allée des Soupirs'),
(1, 3, 'Centre-ville historique de Lannion', 4.3, 28, TRUE, 'Découverte du patrimoine', 'Visite des monuments historiques du centre-ville médiéval.', 'Place du Centre'),
(2, 3, 'Excursion vers les 7 Îles', 4.8, 56, TRUE, 'Réserve ornithologique', 'Découverte de la plus grande réserve d''oiseaux marins de France.', 'Port de Perros-Guirec'),
(3, 3, 'Le Village Gaulois', 4.6, 31, TRUE, 'Parc à thème gaulois', 'Découverte interactive de la vie des Gaulois avec animations.', 'Route du Radôme'),
(4, 5, 'La Ville Blanche', 4.9, 78, TRUE, 'Gastronomie bretonne', 'Cuisine traditionnelle revisitée avec produits locaux.', 'La Ville Blanche'),
(2, 2, 'La Magie des arbres', 4.4, 25, TRUE, 'Festival son et lumière', 'Spectacle nocturne dans les arbres avec effets pyrotechniques.', 'Plage de Tourony'),
(1, 4, 'Parc et Château de la Roche Jagu', 4.7, 48, TRUE, 'Domaine historique', 'Château médiéval et jardins remarquables sur les bords du Trieux.', 'La Roche Jagu'),
(3, 1, 'Croisière au coucher du soleil', 4.6, 39, FALSE, 'Balade en mer romantique', 'Naviguez le long de la côte bretonne à bord d''un voilier au coucher du soleil, avec dégustation de produits locaux à bord.', 'Port de Trégastel'),
(2, 1, 'Atelier fabrication de menhirs en argile', 4.2, 18, FALSE, 'Activité artisanale familiale', 'Atelier ludique pour petits et grands autour de la fabrication de menhirs miniatures en argile, avec explications historiques.', 'Maison des Mégalithes – Pleumeur-Bodou');


-- 9. Statut_log
INSERT INTO statut_log (id_offre, date_mise_en_ligne, date_mise_hors_ligne) VALUES
(1, '2023-01-15', '2023-01-30'),
(2, '2023-01-30', '2023-02-28'),
(3, '2023-03-10', NULL),
(4, '2023-04-05', NULL),
(5, '2023-05-12', NULL),
(6, '2023-06-18', NULL),
(7, '2023-07-22', NULL),
(8, '2023-08-30', NULL);

-- 11. Tag
INSERT INTO tag (libelle_tag) VALUES
('Plein air'),
('Sport'),
('Famille'),
('Nature'),
('Nautique'),
('Culture'),
('Gastronomique'),
('Historique'),
('Musique'),
('Son et lumière');

-- 12. Type_activite_autorise_tag
INSERT INTO type_activite_autorise_tag (id_type_activite, id_tag) VALUES
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5),
(2, 1), (2, 2), (2, 3), (2, 4),
(3, 3), (3, 6), (3, 8),
(4, 3), (4, 6), (4, 9), (4, 10),
(5, 1), (5, 3), (5, 6), (1, 7);

-- 13. Langue
INSERT INTO langue (libelle_langue) VALUES
('Français'),
('Anglais'),
('Allemand'),
('Espagnol'),
('Breton');

-- 15. Offre_activite
INSERT INTO offre_activite (id_offre, duree, age, accessibilite) VALUES
(1, 4.5, 12, 'Accessible avec certaines limitations'),
(2, 6.0, 7, 'Accessible aux personnes à mobilité réduite'),
(9, 6.0, 7, 'Accessible aux personnes à mobilité réduite'),
(10, 6.0, 7, 'Accessible aux personnes à mobilité réduite');

-- 16. Offre_visite
INSERT INTO offre_visite (id_offre, duree, accessibilite) VALUES
(3, 2.0, 'Accessible en fauteuil roulant'),
(4, 3.0, 'Accessible avec fauteuil roulant manuel'),
(5, 2.5, 'Partiellement accessible');

-- 17. Visite_guidee
INSERT INTO visite_guidee (id_offre) VALUES
(4), (3);

-- 18. Visite_non_guidee
INSERT INTO visite_non_guidee (id_offre) VALUES
(5);

-- 19. Offre_spectacle
INSERT INTO offre_spectacle (id_offre, duree, accessibilite, capacite_accueil, prix) VALUES
(7, 1.5, 'Totalement accessible', 300, 5.0);

-- 20. Offre_parc_attraction
INSERT INTO offre_parc_attraction (id_offre, nb_attraction, age_min, id_image) VALUES
(8, 15, 3, 5);

-- 21. Offre_restauration
INSERT INTO offre_restauration (id_offre, gamme_prix, id_image) VALUES
(6, 35.0, 6);

-- 22. Visite_guidee_disponible_en_langue
INSERT INTO visite_guidee_disponible_en_langue (id_visite, id_langue) VALUES
(4, 1), (3, 2);

-- 23. Prestation
INSERT INTO prestation (libelle_prestation) VALUES
('Encadrant'),
('Kit de crevaison'),
('Déjeuner sandwich'),
('Bicyclette'),
('Crème solaire'),
('Guide audio'),
('Casque'),
('Gilet de sauvetage'),
('Parking'),
('WiFi');

-- 24. Activite_inclus_prestation
INSERT INTO activite_inclus_prestation (id_offre, id_prestation) VALUES
(1, 1), (1, 8),
(2, 1), (2, 2), (2, 3);

-- 25. Activite_non_inclus_prestation
INSERT INTO activite_non_inclus_prestation (id_offre, id_prestation) VALUES
(1, 4), (1, 5),
(2, 4), (2, 5);

-- 26. Souscription
INSERT INTO souscription (nb_semaine, date_debut) VALUES
(4, '2023-01-15'),
(8, '2023-11-25'),
(12, '2023-04-11');

-- 27. Option
INSERT INTO option (libelle_option, prix_s_HT_option, prix_s_TTC_option) VALUES
('Recommandé', 15.0, 18.0),
('En relief', 20.0, 24.0);

-- 28. Option_payante_offre
INSERT INTO option_payante_offre (id_offre, id_option, id_souscription) VALUES
(1, 2, 1),
(1, 1, 1),
(2, 1, 2),
(4, 2, 3);

-- 29. Offre_possede_tags
INSERT INTO offre_possede_tags (id_offre, id_tag) VALUES
(1, 1), (1, 2), (1, 3), (1, 5),
(2, 1), (2, 3),
(3, 3), (3, 6), (3, 8),
(4, 1), (4, 3), (4, 4), (4, 5),
(5, 1), (5, 3), (5, 6),
(6, 3), (6, 7),
(7, 3), (7, 6), (7, 9), (7, 10),
(8, 3), (8, 6), (8, 8);

-- 30. Image_illustre_offre
INSERT INTO image_illustre_offre (id_offre, id_image) VALUES
(1, 1),
(2, 2),
(3, 8),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 3);

-- 31. Avis
INSERT INTO avis (id_utilisateur, id_offre, description_avis, note_avis) VALUES
(5, 4, 'Les oiseaux sont impressionnants', 5.0),
(6, 7, 'Spectacle magique', 4.0);

-- 32. Avis_possede_image
INSERT INTO avis_possede_image (id_avis, id_image) VALUES
(1, 1),
(2, 8);

-- 33. Pro_repond_avis
INSERT INTO pro_repond_avis (id_utilisateur, id_avis, description_rep) VALUES
(1, 1, 'Merci pour votre commentaire!'),
(2, 2, 'Ravi que vous ayez apprécié la balade.');

-- 34. Membre_aime_avis
INSERT INTO membre_aime_avis (id_utilisateur, id_avis, aime) VALUES
(5, 1, TRUE),
(6, 2, TRUE);

-- 35. Abonnement
INSERT INTO abonnement (id_offre, id_utilisateur_prive, prix) VALUES
(1, 1, 120.0),
(6, 2, 200.0);

-- 36. Pro_public_propose_offre
INSERT INTO pro_public_propose_offre (id_offre, id_utilisateur_public) VALUES
(2, 3),
(3, 4);
