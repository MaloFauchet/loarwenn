SET SCHEMA 'tripenazor';

-- Insertion Ville
INSERT INTO ville (nom_ville, code_postal) VALUES
  ('Nice', '06000'),
  ('Cannes', '06400'),
  ('Antibes', '06600'),
  ('Grasse', '06130'),
  ('Menton', '06500'),
  ('Saint-Tropez', '83990'),
  ('Hyères', '83400'),
  ('Fréjus', '83600'),
  ('Toulon', '83000'),
  ('La Seyne-sur-Mer', '83500'),
  ('Beaulieu-sur-Mer', '06310'),
  ('Villefranche-sur-Mer', '06230'),
  ('Saint-Raphaël', '83700'),
  ('Cavalaire-sur-Mer', '83240'),
  ('Bormes‑les‑Mimosas', '83230');

-- Insertion Adresse
INSERT INTO adresse (voie, numero_adresse, complement_adresse, id_ville) VALUES
('Avenue des Fleurs', 17, NULL, 1),
('Rue Masséna', 4, '2e étage', 1),
('Promenade des Anglais', 113, 'Résidence Neptune', 1),
('Rue Georges Clemenceau', 8, NULL, 2),
('Avenue du Maréchal Juin', 59, NULL, 2),
('Rue Lacan', 14, 'Boutique n°2', 2),
('Avenue Robert Soleau', 3, NULL, 3),
('Rue de la République', 27, NULL, 3),
('Boulevard du Président Wilson', 66, 'Villa Azure', 3),
('Chemin des Bastides', 40, NULL, 4),
('Rue de l’Orme', 18, 'Rez-de-chaussée', 4),
('Place aux Aires', 1, NULL, 4),
('Rue Partouneaux', 7, '4e étage', 5),
('Avenue Carnot', 12, NULL, 5),
('Chemin de la Madone', 89, NULL, 5),
('Avenue Foch', 21, NULL, 6),
('Rue Sibilli', 6, 'Appartement 4C', 6),
('Chemin des Amoureux', 3, NULL, 6),
('Chemin de Saint-Lambert', 90, NULL, 7),
('Place Clémenceau', 11, 'Immeuble Bleu', 7),
('Rue Victor Hugo', 54, NULL, 8),
('Avenue du Général Leclerc', 73, 'Bâtiment C', 9),
('Chemin Notre-Dame', 8, NULL, 9),
('Rue Maréchal Joffre', 19, NULL, 10),
('Rue de l’Église', 5, '1er étage', 11),
('Montée de l’Observatoire', 7, NULL, 12),
('Boulevard des Cigales', 26, NULL, 13),
('Rue du Soleil', 61, 'Villa Émeraude', 14),
('Chemin du Vallon', 4, NULL, 15),
('Avenue de la Corniche', 50, NULL, 15);


-- Insertion Langue
INSERT INTO langue (libelle_langue) VALUES
('Français'),
('Anglais'),
('Espagnol'),
('Allemand'),
('Italien'),
('Chinois'),
('Japonais'),
('Russe'),
('Arabe'),
('Portugais');


-- Insertion Jour
INSERT INTO jour (libelle) VALUES
('Lundi'),
('Mardi'),
('Mercredi'),
('Jeudi'),
('Vendredi'),
('Samedi'),
('Dimanche');

-- Insertion Utilisateur
INSERT INTO utilisateur (id_adresse, prenom, nom, num_telephone, email, mot_de_passe) VALUES
(1, 'Lucas', 'Martin', '0612345678', 'lucas.martin@example.com', '$2y$10$zPW8jeQFX9FL5Z9bMhFkJeC.YNutCKU5.RklANJ66/fBNxm2un1FG'),
(5, 'Claire', 'Dubois', '0698765432', 'claire.dubois@example.com', '$2y$10$zPW8jeQFX9FL5Z9bMhFkJeC.YNutCKU5.RklANJ66/fBNxm2un1FG'),
(10, 'Nora', 'Moreau', '0678123456', 'nora.moreau@example.com', '$2y$10$zPW8jeQFX9FL5Z9bMhFkJeC.YNutCKU5.RklANJ66/fBNxm2un1FG'),
(15, 'Julien', 'Bernard', '0654321876', 'julien.bernard@example.com', '$2y$10$zPW8jeQFX9FL5Z9bMhFkJeC.YNutCKU5.RklANJ66/fBNxm2un1FG'),
(20, 'Sophie', 'Lemoine', '0623456789', 'sophie.lemoine@example.com', '$2y$10$zPW8jeQFX9FL5Z9bMhFkJeC.YNutCKU5.RklANJ66/fBNxm2un1FG');

-- Insertion Membre
INSERT INTO membre (id_utilisateur, pseudo) VALUES
(1, 'Lucas06'),
(3, 'NoraAzur');

-- Insertion Professionnel
INSERT INTO professionnel (id_utilisateur, lien_site_web) VALUES
(2, 'https://www.clairedesigns.fr'),
(4, 'https://www.julien-tech.pro'),
(5, NULL);

-- Insertion Professionnel Public
INSERT INTO professionnel_public (id_utilisateur, raison_sociale) VALUES
(2, 'Claire Designs');

-- Insertion Professionnel Prive
INSERT INTO professionnel_prive (id_utilisateur, denomination, siren, iban) VALUES
(4, 'Julien Tech Solutions', 812345678, 'FR761234598765432109876543210'),
(5, 'Sophie Beauty Studio', 823456789, 'FR7630006000011234567890189');

-- Insertion Image
INSERT INTO image(titre_image, chemin) VALUES
('Balade en bord de mer', '/image/offres/3d76cb4c-64dc-46aa-9fc6-355fb180f1bf/balade_en_bord_de_mer.jpg'),
('Visite historique', '/image/offres/9e780305-a5d1-4a93-bcd4-e0ec8b027f6c/visite_historique.jpg'),
('Dégustation de vins', '/image/offres/a58b52ec-f634-4de6-be60-72f759f88bf4/degustation_de_vins.jpg'),
('Atelier cuisine provençale', '/image/offres/aa9947c6-84b7-4a2c-b28e-27eac9dd8d99/atelier_cuisine_provençale.jpg'),
('Cours de voile', '/image/offres/f6451f82-1992-478c-b99e-5cc5d21f5dfc/cours_de_voile.jpg'),
('Randonnée dans l''arrière-pays', '/image/offres/e80df84c-cc13-43d1-9e11-02c75aa6a84e/randonnee_dans_l_arrière-pays.jpg'),
('Concert jazz en plein air', '/image/offres/3fd6b07b-5a9a-4c93-bf4f-9a4c3e3785b5/concert_jazz_en_plein_air.jpg'),
('Cours de peinture', '/image/offres/c6c4bc20-464c-41ff-a6d2-d69ac7faac99/cours_de_peinture.jpg'),
('Visite des marchés locaux', '/image/offres/22289d70-74f6-4e30-b032-5d0e179ffec6/visite_des_marches_locaux.jpg'),
('Tour en vélo électrique', '/image/offres/4fcb8574-63b4-4ec9-a073-38352010a1c3/tour_en_velo_électrique.jpg'),
('Dîner gastronomique', '/image/offres/0cfb6744-43c0-45aa-857b-6c227e8fe810/diner_gastronomique.jpg'),
('Cours de yoga en plein air', '/image/offres/75f12ee4-844f-43a5-9fa2-0ef6e3b22e93/cours_de_yoga_en_plein_air.jpg'),
('Excursion en bateau', '/image/offres/61f1e16d-6e89-4532-ace1-1463c8f5a18d/excursion_en_bateau.jpg'),
('Atelier sculpture', '/image/offres/9a8c861c-9df2-4719-b36f-61efbfca67a2/atelier_sculpture.jpg'),
('Festival de cinéma', '/image/offres/003e3504-0c0f-408e-8264-d013f3a03a27/festival_de_cinema.jpg'),
('Parcours accrobranche', '/image/offres/b69c01fb-8a94-4d38-8584-49f9336b1b3c/parcours_accrobranche.jpg'),
('Dégustation de produits locaux', '/image/offres/980ed9bb-bd0b-4b0d-a94b-f328bc8f4d85/degustation_de_produits_locaux.jpg'),
('Initiation à la photographie', '/image/offres/0bcba216-b6a3-44e1-a847-4984d47091d5/initiation_à_la_photographie.jpg'),
('Stage de plongée', '/image/offres/7792a9b0-2a3c-48ab-8fa2-e96ff7ce8455/stage_de_plongée.jpg'),
('Cours de danse provençale', '/image/offres/dfc60b08-27cd-4129-aeb3-77fc6eaf8133/cours_de_danse_provençale.jpg'),
('Photo de profil', '/image/profils/1.jpg'),
('Photo de profil', '/image/profils/2.jpg'),
('Photo de profil', '/image/profils/3.jpg'),
('Photo de profil', '/image/profils/4.jpg'),
('Photo de profil', '/image/profils/5.jpg'),
('Plan Parcours accrobranche', '/image/offres/b69c01fb-8a94-4d38-8584-49f9336b1b3c/plan_parcours_accrobranche.jpg'),
('Carte Dégustation de vins', '/image/offres/a58b52ec-f634-4de6-be60-72f759f88bf4/carte_degustation_de_vins.jpg'),
('Carte Dîner gastronomique', '/image/offres/0cfb6744-43c0-45aa-857b-6c227e8fe810/carte_diner_gastronomique.jpg'),
('Carte Dégustation de produits locaux', '/image/offres/980ed9bb-bd0b-4b0d-a94b-f328bc8f4d85/carte_degustation_de_produits_locaux.jpg');




-- Insertion Utilisateur PDP
INSERT INTO utilisateur_represente_image(id_utilisateur, id_image) VALUES 
(1,21),
(2,22),
(3,23),
(4,24),
(5,25);

-- Insertion Offre
INSERT INTO offre (titre_offre, en_ligne, resume, description, accessibilite, type_offre, id_adresse, id_image_couverture, prix_TTC_min) VALUES
('Balade en bord de mer', TRUE, 'Partez pour une balade guidée le long de la côte, idéale pour se ressourcer en famille.', 'Profitez d’une sortie en plein air de 2h30 encadrée par un guide passionné pour découvrir la faune, la flore et les paysages du littoral. Vous longerez les plages sauvages tout en apprenant l’histoire naturelle et locale. L’activité est ponctuée de pauses explicatives, de moments d’observation et de temps libres pour profiter de la mer. Cette expérience accessible ravira aussi bien les enfants que les adultes, et ne nécessite aucune condition physique particulière. Une immersion sensorielle et culturelle au bord de l’eau, propice à la détente et à la découverte en pleine nature.', 'Accessibilité PMR', 'activite', 2, 1, 0.0),

('Visite historique', TRUE, 'Remontez le temps lors d’une visite guidée à travers les sites historiques emblématiques de la région.', 'Explorez les trésors du patrimoine local lors d’une visite guidée immersive de 2 heures au cœur des monuments emblématiques de la ville. Accompagnés d’un guide expérimenté, les participants découvrent l’histoire, l’architecture et les anecdotes culturelles qui façonnent l’identité du territoire. Chaque étape est l’occasion d’observer des détails historiques, de poser des questions, et d’enrichir ses connaissances. Une activité parfaite pour les amateurs d’histoire, les curieux et les familles souhaitant découvrir leur région autrement.', 'Ouvert à tous', 'visite_guide', 3, 2, 6.0),

('Dégustation de vins', FALSE, 'Une soirée conviviale autour des vins du terroir, idéale pour amateurs et passionnés.', 'Lors de cette soirée gourmande, les participants découvrent une sélection de vins locaux présentée par un sommelier. Dans une ambiance chaleureuse, vous apprendrez à reconnaître les arômes, les cépages et les accords mets-vins. L’événement se déroule dans un cadre convivial, propice aux échanges et à la découverte sensorielle. Chaque vin est accompagné d’explications détaillées et de produits locaux en dégustation. Un moment idéal pour les amateurs comme pour les curieux désireux d’enrichir leur culture œnologique dans une atmosphère détendue.', 'Accessible aux adultes uniquement', 'restauration', 4, 3, 15.0),

('Atelier cuisine provençale', TRUE, 'Initiez-vous à la gastronomie provençale dans un atelier de cuisine interactif et gourmand.', 'Cet atelier de 3 heures vous plonge au cœur de la cuisine traditionnelle provençale. Guidés par un chef local, vous apprendrez à confectionner plusieurs recettes typiques à base de produits frais et de saison. L’atelier est ponctué d’astuces culinaires, de moments de partage, et se conclut par une dégustation conviviale des plats préparés ensemble. Que vous soyez débutant ou cuisinier passionné, cette expérience enrichissante allie apprentissage, plaisir gustatif et immersion dans les saveurs du Sud.', 'Accès handicapés', 'activite', 6, 4, 25.0),

('Cours de voile', TRUE, 'Apprenez les bases de la navigation', 
'Participez à un cours d’initiation à la voile en Méditerranée de 4h. Vous apprendrez à manœuvrer un voilier en toute sécurité, guidé par un moniteur expérimenté. Une activité idéale pour découvrir les plaisirs de la navigation tout en profitant du paysage maritime.', 
'Sur inscription', 'activite', 7, 5, 40.0),

('Randonnée dans l''arrière-pays', TRUE, 'Explorez les sentiers de la nature provençale', 
'Randonnée guidée de 5h à travers les sentiers vallonnés de l’arrière-pays. Découvrez la flore locale, les points de vue panoramiques et l’histoire naturelle de la région. Prévue pour les débutants, cette excursion offre une immersion complète dans un environnement authentique.', 
'Niveau débutant', 'activite', 8, 6, 5.0),

('Concert jazz en plein air', TRUE, 'Vivez une soirée jazz sous les étoiles', 
'Un concert exceptionnel de 2h dans un parc naturel. Des musiciens de jazz animent la soirée avec des sons envoûtants. Apportez votre plaid et installez-vous confortablement pour un moment musical unique au cœur de la nature, dans une ambiance détendue et conviviale.', 
'Ouvert à tous', 'spectacle', 9, 7, 0.0),

('Cours de peinture', FALSE, 'Initiez-vous à l’art pictural avec un artiste local', 
'Atelier de peinture de 3h guidé par un artiste local passionné. Découvrez les techniques de base, les jeux de couleurs et les secrets d’une toile réussie. Accessible à tous, cet atelier offre une pause créative dans un cadre chaleureux. Tout le matériel est fourni sur place.', 
'Matériel fourni', 'activite', 11, 8, 20.0),

('Visite des marchés locaux', TRUE, 'Parcourez les marchés et goûtez aux spécialités', 
'Une visite de 3h des marchés provençaux où vous découvrirez des produits du terroir : fruits, fromages, charcuteries et spécialités locales. Échangez avec les producteurs et savourez des dégustations tout au long du parcours. Une immersion gustative idéale pour les familles.', 
'Accessible aux familles', 'visite_non_guide', 12, 9, 0.0),

('Tour en vélo électrique', TRUE, 'Explorez la région à vélo sans effort', 
'Tour guidé de 2h en vélo électrique à travers les paysages naturels et les petits villages. Adapté à tous les niveaux, le circuit vous permet de découvrir la région autrement tout en profitant d’explications historiques et culturelles du guide. Casques et vélos fournis.', 
'Casques fournis', 'activite', 13, 10, 18.0),

('Dîner gastronomique', FALSE, 'Savourez un dîner raffiné avec un chef étoilé', 
'Un dîner de 3h dans un restaurant renommé, où un chef étoilé propose un menu dégustation de saison. Profitez d’un moment culinaire d’exception dans un cadre élégant. Les plats sont accompagnés de vins soigneusement sélectionnés. Une expérience gastronomique unique et mémorable.', 
'Sur réservation', 'restauration', 14, 11, 60.0),

('Cours de yoga en plein air', TRUE, 'Un moment de sérénité face à la mer', 
'Séance de yoga de 1h30 sur la plage, idéale pour tous les niveaux. Respirez, détendez-vous et recentrez-vous en pratiquant des postures douces au rythme des vagues. Encadrée par un professeur certifié, cette activité favorise bien-être et relaxation dans un décor naturel apaisant.', 
'Tous niveaux', 'activite', 16, 12, 8.0),

('Excursion en bateau', TRUE, 'Partez à la découverte des criques méditerranéennes', 
'Excursion maritime de 3h à bord d’un bateau confortable. Vous longerez la côte pour découvrir des criques sauvages, accessibles uniquement par la mer. Arrêts baignade et commentaires du guide pour tout connaître de la faune marine et de la géologie locale. Équipement inclus.', 
'Gilet de sauvetage obligatoire', 'activite', 17, 13, 35.0),

('Atelier sculpture', FALSE, 'Initiez-vous à la sculpture sur pierre', 
'Durant cet atelier de 4h, découvrez les outils et techniques de base de la sculpture sur pierre avec un sculpteur professionnel. Apprenez à modeler une œuvre simple tout en explorant votre créativité. Convivial et stimulant, cet atelier est réservé aux adultes curieux d’art.', 
'Public adulte', 'activite', 18, 14, 28.0),

('Festival de cinéma', TRUE, 'Participez à un festival de films en plein air',
'Profitez de 3h de projection de courts et longs métrages réalisés par des cinéastes locaux et émergents. Le festival propose une programmation riche et variée en extérieur, accompagnée d’échanges avec les réalisateurs. Une ambiance conviviale, gratuite et accessible à tous les cinéphiles.', 
'Gratuit', 'spectacle', 19, 15, 0.0),

('Parcours accrobranche', TRUE, 'Vivez l’aventure dans un parcours forestier',
'Ce parcours accrobranche de 4h propose 15 attractions suspendues entre les arbres, accessibles aux petits comme aux grands. Tyroliennes, ponts de singe et filets suspendus sont au programme pour tester votre agilité et votre courage. Tout le matériel est fourni et les encadrants assurent votre sécurité.', 
'Équipement fourni', 'parc_attraction', 21, 16, 22.0),

('Dégustation de produits locaux', TRUE, 'Savourez les spécialités artisanales du terroir',
'Cette dégustation vous emmène à la rencontre de producteurs locaux passionnés. Charcuterie, fromages, confitures, huiles et autres produits du terroir sont à l’honneur. En famille ou entre amis, laissez-vous guider dans un voyage gustatif authentique au cœur des traditions régionales.', 
'Accessible aux familles', 'restauration', 22, 17, 10.0),

('Initiation à la photographie', FALSE, 'Maîtrisez les bases de la photo avec un pro',
'Un atelier de 3h conçu pour les débutants qui souhaitent apprendre à utiliser leur appareil photo. Accompagné d’un photographe expérimenté, vous découvrirez les réglages essentiels, la composition d’image et l’utilisation de la lumière naturelle lors d’exercices pratiques en extérieur.', 
'Matériel personnel requis', 'activite', 23, 18, 16.0),

('Stage de plongée', TRUE, 'Plongez à la découverte des fonds marins',
'Ce stage de 5h en Méditerranée vous initiera aux bases de la plongée sous-marine. Après une présentation du matériel et des règles de sécurité, partez explorer des fonds marins riches en biodiversité, accompagné d’un moniteur diplômé. Expérience inoubliable garantie pour les amateurs de sensations aquatiques.', 
'Certificat médical requis', 'activite', 24, 19, 50.0),

('Cours de danse provençale', TRUE, 'Initiez-vous aux danses traditionnelles du sud',
'Venez découvrir les danses folkloriques de Provence lors d’un cours de 2h30 ouvert à tous. Rythmes entraînants, tenues traditionnelles et ambiance conviviale seront au rendez-vous. Un moment d’échange culturel et festif qui vous plongera dans les traditions musicales de la région.', 
'Ouvert à tous', 'activite', 25, 20, 12.0);

-- Insertion Activite
INSERT INTO offre_activite (id_offre, duree, age) VALUES
(1, '02:30:00', 6),
(4, '03:00:00', 12),
(5, '04:00:00', 14),
(6, '05:00:00', 8),
(8, '03:00:00', 15),
(10, '02:00:00', 10),
(12, '01:30:00', 8),
(13, '03:00:00', 12),
(14, '04:00:00', 16),
(18, '03:00:00', 14),
(19, '05:00:00', 16),
(20, '02:30:00', 10);

-- Insertion Visite
INSERT INTO offre_visite (id_offre, duree) VALUES
(2, '02:00:00'),
(9, '03:00:00');

INSERT INTO visite_non_guidee (id_offre) VALUES (9);
INSERT INTO visite_guidee (id_offre) VALUES (2);
INSERT INTO visite_guidee_disponible_en_langue (id_visite, id_langue) VALUES 
(2,1),
(2,2),
(2,4);

-- Insertion Spectacle
INSERT INTO offre_spectacle (id_offre, duree, capacite_accueil) VALUES
(7, '02:00:00', 200),
(15, '03:00:00', 500);

-- Insertion Parc d'attraction
INSERT INTO offre_parc_attraction (id_offre, id_image, nb_attraction, age_min) VALUES
(16, 26, 15, 6);

-- Insertion Restauration
INSERT INTO gamme_prix (libelle_gamme_prix) VALUES ('€ (menu à moins de 25€)'), ('€€ (entre 25 et 40€)'), ('€€€ (au-delà de 40€)');
INSERT INTO offre_restauration (id_offre, id_image, id_gamme_prix) VALUES
(3, 27, 2),
(11, 28, 3),
(17, 29, 1);
INSERT INTO type_repas (libelle_repas) VALUES
('Petit-déjeuner'),
('Brunch'),
('Déjeuner'),
('Dîner'),
('Boissons');
INSERT INTO type_repas_disponible (id_repas, id_offre) VALUES
-- Offre 3 (Repas gastronomique)
(3, 3), -- Déjeuner
(4, 3), -- Dîner
(5, 3), -- Boissons
-- Offre 11 (Dîner raffiné)
(4, 11), -- Dîner
(5, 11), -- Boissons
-- Offre 17 (Repas terroir)
(1, 17), -- Petit-déjeuner
(3, 17), -- Déjeuner
(5, 17); -- Boissons

-- Insertion Horaires standardisés
INSERT INTO horaire (debut, fin) VALUES
('2025-06-12 08:00:00', '2025-06-12 12:00:00'),  -- 1: Matin
('2025-06-12 12:00:00', '2025-06-12 14:00:00'),  -- 2: Déjeuner
('2025-06-12 14:00:00', '2025-06-12 18:00:00'),  -- 3: Après-midi
('2025-06-12 18:00:00', '2025-06-12 22:00:00'),  -- 4: Soirée
('2025-06-12 10:00:00', '2025-06-12 16:00:00'),  -- 5: Journée continue
('2025-06-12 09:00:00', '2025-06-12 13:00:00'),  -- 6: Matinée prolongée
('2025-06-12 15:00:00', '2025-06-12 19:00:00'),  -- 7: Après-midi tard
('2025-06-12 20:00:00', '2025-06-12 23:59:00');  -- 8: Spectacle soir tard

-- Insertion Horaires - Activités
INSERT INTO horaire_ouverture (id_horaire, id_offre) VALUES
(1, 1), (3, 1), (5, 1),
(1, 4), (3, 4), (5, 4),
(1, 5), (3, 5), (5, 5),
(1, 6), (3, 6), (5, 6),
(1, 8), (3, 8), (5, 8),
(1, 10), (3, 10), (5, 10),
(1, 12), (3, 12), (5, 12),
(1, 13), (3, 13), (5, 13),
(1, 14), (3, 14), (5, 14),
(1, 18), (3, 18), (5, 18),
(1, 19), (3, 19), (5, 19),
(1, 20), (3, 20), (5, 20);

-- Insertion Horaires - Visites
INSERT INTO horaire_ouverture (id_horaire, id_offre) VALUES
(6, 2), (7, 2),
(6, 9), (7, 9);

-- Insertion Horaires - Restauration
INSERT INTO horaire_ouverture (id_horaire, id_offre) VALUES
(2, 3), (4, 3),
(2, 11), (4, 11),
(2, 17), (4, 17);

-- Insertion Horaires - Spectacles
INSERT INTO horaire_ouverture (id_horaire, id_offre) VALUES
(4, 7), (8, 7),
(4, 15), (8, 15);

-- Insertion Horaires - Parc d'attraction
INSERT INTO horaire_ouverture (id_horaire, id_offre) VALUES
(1, 16), (3, 16), (5, 16);

-- Insertion Jour Activité / Visite
DO $$
DECLARE
    i INT;
BEGIN
    FOR i IN (SELECT id_offre FROM offre WHERE id_offre IN (1,2,4,5,6,8,9,10,12,13,14,18,19,20)) LOOP
        INSERT INTO jour_ouverture (id_jour, id_offre) VALUES
        (2, i), (3, i), (4, i), (5, i), (6, i), (7, i);
    END LOOP;
END $$;

-- Insertion Jour Restauration
DO $$
DECLARE
    i INT;
BEGIN
    FOR i IN (SELECT id_offre FROM offre WHERE id_offre IN (3,11,17)) LOOP
        INSERT INTO jour_ouverture (id_jour, id_offre) VALUES
        (1, i), (2, i), (3, i), (4, i), (5, i), (6, i), (7, i);
    END LOOP;
END $$;

-- Insertion Jour Spectacles
DO $$
DECLARE
    i INT;
BEGIN
    FOR i IN (SELECT id_offre FROM offre WHERE id_offre IN (7,15)) LOOP
        INSERT INTO jour_ouverture (id_jour, id_offre) VALUES
        (4, i), (5, i), (6, i);
    END LOOP;
END $$;

-- Insertion Jour Parc
INSERT INTO jour_ouverture (id_jour, id_offre) VALUES
(3, 16), (4, 16), (5, 16), (6, 16), (7, 16);


-- Insertion Statut Log
-- Offres actuellement en ligne
INSERT INTO statut_log (id_offre, date_mise_en_ligne, date_mise_hors_ligne) VALUES
(1, '2025-04-01', NULL),
(2, '2025-05-10', NULL),
(3, '2025-03-05', NULL),
(4, '2025-01-15', NULL),
(5, '2025-06-01', NULL),
(6, '2025-05-20', NULL),
(7, '2025-02-12', NULL),
(8, '2025-03-25', NULL),
(9, '2025-04-10', NULL),
(10, '2025-06-05', NULL),
(11, '2025-01-20', NULL),
(12, '2025-04-15', NULL),
(13, '2025-02-28', NULL),
(14, '2025-05-01', NULL),
(15, '2025-06-08', NULL);

-- Offres actuellement hors ligne (ayant eu une mise en ligne puis mise hors ligne)
INSERT INTO statut_log (id_offre, date_mise_en_ligne, date_mise_hors_ligne) VALUES
(16, '2025-01-10', '2025-03-10'),
(17, '2025-02-01', '2025-05-15'),
(18, '2025-03-01', '2025-04-20'),
(19, '2025-01-25', '2025-05-01'),
(20, '2025-02-10', '2025-06-01');

-- Historique supplémentaire pour certaines offres
INSERT INTO statut_log (id_offre, date_mise_en_ligne, date_mise_hors_ligne) VALUES
(3, '2024-10-01', '2025-02-20'),
(6, '2024-12-01', '2025-03-01'),
(10, '2025-01-01', '2025-04-01');


-- Insertion Avis
INSERT INTO avis (id_utilisateur, id_offre, description_avis, note_avis, titre_avis, date_avis) VALUES
-- Membre 1
(1, 3, 'Cuisine raffinée et service impeccable. Nous avons adoré le cadre et le menu dégustation.', 5.0, 'Excellent dîner gastronomique', '2025-06-10'),
(1, 7, 'Superbe spectacle en plein air, très bien organisé. Lumières et ambiance magique.', 4.0, 'Une belle soirée culturelle', '2025-06-08'),
(1, 14, 'Très bonne activité pour les enfants, animateurs au top. À refaire !', 4.5, 'Parfait pour les familles', '2025-06-11'),
(1, 5, 'Activité mal organisée, aucune explication claire. Nous avons attendu longtemps sans savoir quoi faire. Décevant.', 2.0, 'Organisation à revoir', '2025-06-11'),
-- Membre 3
(3, 2, 'Visite guidée très instructive, guide passionné. On a appris plein de choses.', 4.5, 'Découverte enrichissante', '2025-06-09'),
(3, 16, 'Beaucoup d’attractions, mais trop de monde l''après-midi. Prévoir tôt !', 4.0, 'Parc sympa mais bondé', '2025-06-10'),
(3, 11, 'Cadre romantique et plats délicieux. Mention spéciale au dessert.', 5.0, 'Un dîner parfait', '2025-06-12');

-- INSERT INTO avis_possede_image (id_avis, id_image) VALUES;

-- Insertion Reponse Pro
INSERT INTO reponse_pro (id_avis, description_rep) VALUES
(1, 'Merci beaucoup pour votre retour positif ! Nous sommes ravis que vous ayez passé un bon moment.'),
(6, 'Nous sommes heureux que vous ayez apprécié l’expérience. À très bientôt !'),
(4, 'Nous sommes désolés que votre expérience n’ait pas été à la hauteur. Nous ferons mieux.');

INSERT INTO image_illustre_offre (id_offre, id_image) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16),
(17, 17),
(18, 18),
(19, 19),
(20, 20);


-- Insertion Tag
INSERT INTO tag (libelle_tag) VALUES
('Culturel'),
('Patrimoine'),
('Histoire'),
('Urbain'),
('Nature'),
('Plein air'),
('Sport'),
('Nautique'),
('Gastronomie'),
('Musée'),
('Atelier'),
('Musique'),
('Famille'),
('Cinéma'),
('Cirque'),
('Son et lumière'),
('Humour'),
('Française'),
('Fruits de mer'),
('Asiatique'),
('Indienne'),
('Italienne'),
('Restauration rapide'),
('Crêperie');

INSERT INTO tag_commun (id_tag)
SELECT id_tag FROM tag WHERE libelle_tag IN (
  'Culturel', 'Patrimoine', 'Histoire', 'Urbain', 'Nature', 'Plein air', 
  'Sport', 'Nautique', 'Musée', 'Atelier', 'Musique', 
  'Famille', 'Cinéma', 'Cirque', 'Son et lumière', 'Humour'
);

INSERT INTO tag_restauration (id_tag)
SELECT id_tag FROM tag WHERE libelle_tag IN (
  'Française', 'Fruits de mer', 'Asiatique', 'Indienne', 'Italienne', 
  'Gastronomie', 'Restauration rapide', 'Crêperie', 'Fast-Food'
);

-- Insertion Offre Restauration Possède Tag
INSERT INTO offre_restauration_possede_tag (id_offre, id_tag) VALUES 
(3, 9),   -- Gastronomie
(3, 18),   -- Gastronomie
(11, 9),   -- Gastronomie
(17, 9);  -- Gastronomie

-- Insertion Offre Activité Possède Tag
INSERT INTO offre_activite_possede_tag (id_offre, id_tag) VALUES 
(1, 5),   -- Nature
(1, 6),   -- Plein air
(4, 11),  -- Atelier
(5, 7),   -- Sport
(5, 8),   -- Nautique
(6, 5),   -- Nature
(6, 7),   -- Sport
(8, 11),   -- Atelier
(8, 13),   -- Famille
(10, 6),  -- Plein air
(10, 7),  -- Sport
(12, 6),  -- Plein air
(12, 13), -- Famille
(13, 8),  -- Nautique
(13, 5),  -- Nature
(14, 11),  -- Atelier
(14, 3),  -- Histoire
(18, 5),  -- Nature
(18, 6),  -- Plein air
(19, 8),  -- Nautique
(19, 7),  -- Sport
(20, 1);  -- Culturel

-- Insertion Offre Visite Possède Tag
INSERT INTO offre_visite_possede_tag (id_offre, id_tag) VALUES 
(2, 1),  -- Culturel
(2, 2),  -- Patrimoine
(2, 3),  -- Histoire
(9, 13); -- Famille

-- Insertion Offre Parc Attraction Possède Tag
INSERT INTO offre_parc_attraction_possede_tag (id_offre, id_tag) VALUES 
(16, 6),   -- Plein air
(16, 13);  -- Famille


-- Insertion Offre Spectacle Possède Tag
INSERT INTO offre_spectacle_possede_tag (id_offre, id_tag) VALUES 
(7, 12),  -- Musique
(7, 6),   -- Plein air
(15, 14); -- Cinéma

-- Insertion Prestation
INSERT INTO prestation (libelle_prestation) VALUES
('Guide professionnel'),
('Matériel fourni'),
('Collation incluse'),
('Transport depuis le point de rendez-vous'),
('Assurance incluse'),
('Casque fourni'),
('Dossier pédagogique'),
('Accès à une plateforme en ligne'),
('Équipement de sécurité'),
('Boissons offertes');


-- Insertion Activite Inclus Prestation
INSERT INTO activite_inclus_prestation (id_offre, id_prestation) VALUES 
(1, 1),  -- Balade en bord de mer → Guide professionnel
(4, 2),  -- Atelier cuisine → Matériel fourni
(5, 5),  -- Cours de voile → Assurance incluse
(6, 1),  -- Randonnée → Guide professionnel
(8, 2),  -- Cours de peinture → Matériel fourni
(10, 6), -- Vélo électrique → Casque fourni
(12, 1), -- Yoga → Guide professionnel
(13, 9), -- Bateau → Équipement de sécurité
(14, 2), -- Sculpture → Matériel fourni
(18, 2), -- Photo → Matériel fourni
(19, 9), -- Plongée → Équipement de sécurité
(20, 1); -- Danse provençale → Guide professionnel


-- Insertion Activite Non Inclus Prestation
INSERT INTO activite_non_inclus_prestation (id_offre, id_prestation) VALUES 
(1, 3),  -- Collation non incluse
(4, 4),  -- Transport non inclus
(5, 4),  -- Transport non inclus
(6, 3),  -- Collation non incluse
(8, 8),  -- Plateforme en ligne non incluse
(10, 5), -- Assurance non incluse
(13, 3), -- Collation non incluse
(18, 4), -- Transport non inclus
(19, 4), -- Transport non inclus
(20, 3); -- Collation non incluse


-- Insertion Abonnement (Pro Prive Propose Offre)
INSERT INTO abonnement (id_offre, id_utilisateur_prive) VALUES 
(1, 4),
(2, 5),
(3, 4),
(4, 5),
(5, 4),
(6, 5),
(8, 4),
(9, 5),
(10, 4),
(11, 5),
(14, 4),
(16, 5),
(18, 4),
(20, 5);


-- Insertion Pro Public Propose Offre
INSERT INTO pro_public_propose_offre (id_offre, id_utilisateur_public) VALUES 
(7, 2),
(12, 2),
(13, 2),
(15, 2),
(17, 2),
(19, 2);


-- Insertion Souscription
INSERT INTO souscription (nb_semaine, date_debut) VALUES
(4, CURRENT_DATE - INTERVAL '3 weeks'),   -- Active
(2, CURRENT_DATE - INTERVAL '3 weeks'),   -- Expirée
(6, CURRENT_DATE - INTERVAL '1 weeks'),   -- Active
(3, CURRENT_DATE - INTERVAL '4 weeks'),   -- Expirée
(1, CURRENT_DATE - INTERVAL '2 weeks'),   -- Expirée
(8, CURRENT_DATE - INTERVAL '1 weeks'),   -- Active
(5, CURRENT_DATE - INTERVAL '5 weeks'),   -- Expirée
(2, CURRENT_DATE - INTERVAL '1 weeks'),   -- Active
(3, CURRENT_DATE - INTERVAL '1 weeks');   -- Active

INSERT INTO option (libelle_option, prix_s_HT_option, prix_s_TTC_option) VALUES
('En relief', 15.0, 18.0),
('A la une', 20.0, 24.0);

-- Insertion Option Payante Offre
INSERT INTO option_payante_offre (id_offre, id_option, id_souscription) VALUES 
(1, 1, 1),   -- Active
(1, 2, 2),   -- Expirée
(3, 1, 3),   -- Active
(4, 2, 4),   -- Expirée
(5, 1, 5),   -- Expirée
(6, 1, 6),   -- Active
(6, 2, 7),   -- Expirée
(10, 2, 8),  -- Active
(12, 1, 9);  -- Active


