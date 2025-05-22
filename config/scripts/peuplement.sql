SET SCHEMA 'tripenazor';

-- 1. Ville (doit être insérée en premier car référencée par d'autres tables)
INSERT INTO ville (nom, code_postal) VALUES
('Lannion', '22300'),
('Perros-Guirec', '22700'),
('Pleumeur-Bodou', '22560'),
('Rospez', '22400'),
('Tréguier', '22220'),
('Paimpol', '22500'),
('Guingamp', '22200'),
('Saint-Brieuc', '22000');

-- 2. Utilisateur (professionnels et membres dépendent de cette table)
INSERT INTO utilisateur (id_ville, nom_entreprise, num_telephone, email, adresse, complement_adresse, mot_de_passe) VALUES
(1, 'Planète Kayak', '0296483726', 'contact@planetekayak.com', '12 Rue des Goélands', 'Bâtiment B', 'mdp123'),
(1, 'Trégor Bicyclette', '0296123456', 'contact@tregorbicyclette.fr', '3 Allée des Soupirs', '', 'velo456'),
(1, 'Mairie de Lannion', '0296461000', 'culture@lannion.bzh', '1 Place du Général Leclerc', '', 'mairie789'),
(2, 'Armor Navigation', '0296234567', 'info@armornav.com', 'Port de Ploumanach', 'Quai C', 'bateau123'),
(3, 'Un Village Gaulois pour l''Afrique', '0296384927', 'contact@villagegaulois.org', 'Route du Radôme', '', 'gaulois456'),
(4, 'SARL La Ville Blanche', '0296789456', 'reservation@lavilleblanche.fr', 'La Ville Blanche', '', 'gastronomie789'),
(1, 'Département des Côtes d''Armor', '0296808080', 'culture@cotesdarmor.fr', '9 Place du Général de Gaulle', 'BP 2091', 'cd22000'),
(2, 'Fondation Cité des Télécoms', '0296403030', 'accueil@citedestelecoms.fr', 'Parc du Radôme', '', 'telecom123');

-- 3. Professionnel (hérite de utilisateur)
INSERT INTO professionnel (id_utilisateur) VALUES
(1),
(2),
(4),
(6),
(7),
(8),
(3);

-- 4. Professionnel_prive
INSERT INTO professionnel_prive (id_utilisateur, denomination, siren, rib) VALUES
(1, 'Mme Agnès Pinson', 519495882, 'FR7630001007941234567890185'),
(4, 'Armor Navigation SAS', 398414698, 'FR7630001007949876543210185'),
(6, 'SARL La Ville Blanche', 384552014, 'FR7630001007944561237890185');

-- 5. Professionnel_public
INSERT INTO professionnel_public (id_utilisateur, raison_sociale) VALUES
(2, 'Association Trégor Bicyclette'),
(3, 'Mairie de Lannion'),
(7, 'Conseil Départemental des Côtes d''Armor');

-- 6. Membre
INSERT INTO membre (id_utilisateur, nom, prenom, email, num_telephone, adresse, complement_adresse, mot_de_passe, pseudo) VALUES
(5, 'Dupont', 'Jean', 'jean.dupont@email.com', '0612345678', '15 Rue des Roses, Lannion', 'bat 5', 'password123', 'jeand'),
(8, 'Martin', 'Sophie', 'sophie.martin@email.com', '0698765432', '22 Avenue des Plages, Perros-Guirec','bat 6', 'sophie456', 'sophiem');

-- 7. Image
INSERT INTO image (titre_image, chemin) VALUES
('Kayak Bréhat', '/images/kayak_brehat.jpg'),
('Vélo Trégor', '/images/velo_tregor.jpg'),
('Château Roche Jagu', '/images/roche_jagu.jpg'),
('7 Îles', '/images/7_iles.jpg'),
('Village Gaulois', '/images/village_gaulois.jpg'),
('Restaurant Ville Blanche', '/images/ville_blanche.jpg'),
('Magie des Arbres', '/images/magie_arbres.jpg'),
('Centre Lannion', '/images/centre_lannion.jpg');

-- 8. Utilisateur_represente_image
INSERT INTO utilisateur_represente_image (id_utilisateur, id_image) VALUES
(1, 1),
(2, 2),
(3, 8),
(4, 4),
(5, 5),
(6, 6),
(7, 3),
(8, 7);

-- 9. Statut_log
INSERT INTO statut_log (date_mise_en_ligne, date_mise_hors_ligne) VALUES
('2023-01-15', NULL),
('2023-02-20', NULL),
('2023-03-10', NULL),
('2023-04-05', NULL),
('2023-05-12', NULL),
('2023-06-18', NULL),
('2023-07-22', NULL),
('2023-08-30', NULL);

-- 10. Type_activite
INSERT INTO type_activite (libelle_activite) VALUES
('Activité nautique'),
('Randonnée'),
('Visite culturelle'),
('Spectacle'),
('Parc d''attractions'),
('Restauration'),
('Visite nature');

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
(5, 1), (5, 3), (5, 6),
(6, 3), (6, 7),
(7, 1), (7, 3), (7, 4);

-- 13. Langue
INSERT INTO langue (libelle_langue) VALUES
('Français'),
('Anglais'),
('Allemand'),
('Espagnol'),
('Breton');

-- 14. Offre (table parent)
INSERT INTO offre (id_ville, id_statut_log, id_type_activite, titre_offre, note_moyenne, nb_avis, en_ligne, resume, description, adresse_offre) VALUES
(1, 1, 1, 'Archipel de Bréhat en kayak', 4.7, 42, TRUE, 'Découverte des îles en kayak de mer', 'Excursion guidée autour des îles de l''archipel de Bréhat avec un guide diplômé.', 'Port de Ploumanach'),
(1, 2, 2, 'Balade familiale à vélo', 4.5, 35, TRUE, 'Balade à vélo dans le Trégor', 'Sortie familiale sur petites routes tranquilles adaptée aux enfants.', '3 Allée des Soupirs'),
(1, 3, 3, 'Centre-ville historique de Lannion', 4.3, 28, TRUE, 'Découverte du patrimoine', 'Visite des monuments historiques du centre-ville médiéval.', 'Place du Centre'),
(2, 4, 7, 'Excursion vers les 7 Îles', 4.8, 56, TRUE, 'Réserve ornithologique', 'Découverte de la plus grande réserve d''oiseaux marins de France.', 'Port de Perros-Guirec'),
(3, 5, 5, 'Le Village Gaulois', 4.6, 31, TRUE, 'Parc à thème gaulois', 'Découverte interactive de la vie des Gaulois avec animations.', 'Route du Radôme'),
(4, 6, 6, 'La Ville Blanche', 4.9, 78, TRUE, 'Gastronomie bretonne', 'Cuisine traditionnelle revisitée avec produits locaux.', 'La Ville Blanche'),
(2, 7, 4, 'La Magie des arbres', 4.4, 25, TRUE, 'Festival son et lumière', 'Spectacle nocturne dans les arbres avec effets pyrotechniques.', 'Plage de Tourony'),
(1, 8, 3, 'Parc et Château de la Roche Jagu', 4.7, 48, TRUE, 'Domaine historique', 'Château médiéval et jardins remarquables sur les bords du Trieux.', 'La Roche Jagu');

-- 15. Offre_activite
INSERT INTO offre_activite (id_offre, duree, age, accessibilite) VALUES
(1, 4.5, 12, 'Accessible avec certaines limitations'),
(2, 6.0, 7, 'Accessible aux personnes à mobilité réduite');

-- 16. Offre_visite
INSERT INTO offre_visite (id_offre, duree, accessibilite) VALUES
(3, 2.0, 'Accessible en fauteuil roulant'),
(4, 3.0, 'Accessible avec fauteuil roulant manuel'),
(8, 2.5, 'Partiellement accessible');

-- 17. Visite_guidee
INSERT INTO visite_guidee (id_offre) VALUES
(3), (4), (8);

-- 18. Visite_non_guidee
-- (Pas d'exemple dans les données fournies)

-- 19. Offre_spectacle
INSERT INTO offre_spectacle (id_offre, duree, accessibilite, capacite_accueil, prix) VALUES
(7, 1.5, 'Totalement accessible', 300, 5.0);

-- 20. Offre_parc_attraction
INSERT INTO offre_parc_attraction (id_offre, nb_attraction, age, id_image) VALUES
(5, 15, 3, 5);

-- 21. Offre_restauration
INSERT INTO offre_restauration (id_offre, gamme_prix, id_image) VALUES
(6, 35.0, 6);

-- 22. Visite_guidee_disponible_en_langue
INSERT INTO visite_guidee_disponible_en_langue (id_visite, id_langue) VALUES
(3, 1), (3, 2),
(4, 1), (4, 2),
(8, 1);

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
('Location vélo', 15.0, 18.0),
('Location kayak', 20.0, 24.0),
('Pique-nique', 12.0, 14.4),
('Guide privé', 50.0, 60.0),
('Photos souvenir', 25.0, 30.0);

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
INSERT INTO avis (id_utilisateur, id_offre, message, note_avis) VALUES
(1, 1, 'Super expérience, paysages magnifiques!', 5.0),
(2, 1, 'Guide très professionnel, à refaire', 4.5),
(3, 2, 'Parfait pour une sortie en famille', 4.0),
(4, 3, 'Visite très intéressante', 4.5),
(5, 4, 'Les oiseaux sont impressionnants', 5.0),
(6, 5, 'Les enfants ont adoré', 4.5),
(7, 6, 'Repas excellent, service impeccable', 5.0),
(8, 7, 'Spectacle magique', 4.0);

-- 32. Avis_possede_image
INSERT INTO avis_possede_image (id_avis, id_image) VALUES
(1, 1),
(4, 8),
(5, 4),
(7, 6);

-- 33. Pro_repond_avis
INSERT INTO pro_repond_avis (id_utilisateur, id_avis, description_rep) VALUES
(1, 1, 'Merci pour votre commentaire!'),
(2, 3, 'Ravi que vous ayez apprécié la balade.'),
(6, 7, 'Nous sommes heureux que le repas vous ait plu.');

-- 34. Membre_aime_avis
INSERT INTO membre_aime_avis (id_utilisateur, id_avis, aime) VALUES
(5, 1, TRUE),
(8, 2, TRUE);

-- 35. Abonnement
INSERT INTO abonnement (id_offre, id_utilisateur_prive, prix) VALUES
(1, 1, 120.0),
(6, 6, 200.0);

-- 36. Pro_public_propose_offre
INSERT INTO pro_public_propose_offre (id_offre, id_utilisateur_public) VALUES
(2, 2),
(3, 3),
(4, 7);