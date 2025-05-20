-- Suppression des tables existantes
DROP SCHEMA IF EXISTS tripenazor CASCADE;
CREATE SCHEMA tripenazor;
SET SCHEMA 'tripenazor';

-- Table ville
CREATE TABLE ville (
    id_ville SERIAL PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    code_postal VARCHAR(5) NOT NULL
);

-- Table utilisateur (classe mère)
CREATE TABLE utilisateur (
    id_utilisateur SERIAL PRIMARY KEY,
    id_ville INT NOT NULL REFERENCES ville(id_ville),
    nom_entreprise VARCHAR(50) NOT NULL,
    num_telephone VARCHAR(10) NOT NULL,
    email VARCHAR(50) NOT NULL,
    adresse VARCHAR(100) NOT NULL,
    complement_adresse VARCHAR(100) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL
);

-- Table professionnel (hérite de utilisateur)
CREATE TABLE professionnel (
    id_utilisateur INT PRIMARY KEY REFERENCES utilisateur(id_utilisateur)
);

-- Table professionnel_prive
CREATE TABLE professionnel_prive (
    id_utilisateur INT PRIMARY KEY REFERENCES professionnel(id_utilisateur),
    denomination VARCHAR(50) NOT NULL,
    siren NUMERIC(9) NOT NULL,
    rib VARCHAR(40) NOT NULL
);

-- Table professionnel_public
CREATE TABLE professionnel_public (
    id_utilisateur INT PRIMARY KEY REFERENCES professionnel(id_utilisateur),
    raison_sociale VARCHAR(50) NOT NULL
);

-- Table membre (indépendant de utilisateur)
CREATE TABLE membre (
    id_utilisateur INT PRIMARY KEY REFERENCES utilisateur(id_utilisateur),
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    num_telephone VARCHAR(10) NOT NULL,
    adresse VARCHAR(100) NOT NULL,
    complement_adresse VARCHAR(50) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    pseudo VARCHAR(50) NOT NULL
);

-- Table image
CREATE TABLE image (
    id_image SERIAL PRIMARY KEY,
    titre_image VARCHAR(50) NOT NULL,
    chemin VARCHAR(50) NOT NULL
);

-- Table utilisateur_represente_image
CREATE TABLE utilisateur_represente_image (
    id_utilisateur INT NOT NULL REFERENCES utilisateur(id_utilisateur),
    id_image INT NOT NULL REFERENCES image(id_image),
    PRIMARY KEY (id_utilisateur, id_image)
);

-- Table statut_log
CREATE TABLE statut_log (
    id_statut_log SERIAL PRIMARY KEY,
    date_mise_en_ligne DATE,
    date_mise_hors_ligne DATE
);

-- Table type_activite
CREATE TABLE type_activite (
    id_type_activite SERIAL PRIMARY KEY,
    libelle_activite VARCHAR(50)
);

-- Table offre
CREATE TABLE offre (
    id_offre SERIAL PRIMARY KEY,
    id_ville INT NOT NULL REFERENCES ville(id_ville),
    id_statut_log INT NOT NULL REFERENCES statut_log(id_statut_log),
    id_type_activite INT NOT NULL REFERENCES type_activite(id_type_activite),
    titre_offre VARCHAR(50) NOT NULL,
    note_moyenne FLOAT NOT NULL,
    nb_avis INT NOT NULL,
    en_ligne BOOLEAN NOT NULL,
    resume VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    date_creation TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    adresse_offre VARCHAR(50) NOT NULL
);

-- Table avis
CREATE TABLE avis (
    id_avis SERIAL PRIMARY KEY,
    id_utilisateur INT REFERENCES utilisateur(id_utilisateur),
    id_offre INT NOT NULL REFERENCES offre(id_offre),
    message VARCHAR(255) NOT NULL,
    note_avis FLOAT NOT NULL
);

-- Table avis_possede_image
CREATE TABLE avis_possede_image (
    id_avis INT NOT NULL REFERENCES avis(id_avis), 
    id_image INT NOT NULL REFERENCES image(id_image),
    PRIMARY KEY (id_avis, id_image)
);

-- Table image_illustre_offre
CREATE TABLE image_illustre_offre (
    id_offre INT NOT NULL REFERENCES offre(id_offre),
    id_image INT NOT NULL REFERENCES image(id_image),
    PRIMARY KEY (id_offre, id_image)
);

-- Table tag
CREATE TABLE tag (
    id_tag SERIAL PRIMARY KEY,
    libelle_tag VARCHAR(50)
);

-- Table souscription
CREATE TABLE souscription (
    id_souscription SERIAL PRIMARY KEY,
    nb_semaine INT NOT NULL,
    date_debut DATE NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Table option
CREATE TABLE option (
    id_option SERIAL PRIMARY KEY,
    libelle_option VARCHAR(50) NOT NULL,
    prix_s_HT_option FLOAT NOT NULL,
    prix_s_TTC_option FLOAT NOT NULL
);

-- Table langue
CREATE TABLE langue (
    id_langue SERIAL PRIMARY KEY,
    libelle_langue VARCHAR(50)
);

-- Table prestation
CREATE TABLE prestation (
    id_prestation SERIAL PRIMARY KEY,
    libelle_prestation VARCHAR(50)
);

-- Table offre_activite
CREATE TABLE offre_activite (
    id_offre INT PRIMARY KEY REFERENCES offre(id_offre),
    duree FLOAT NOT NULL,
    age INT NOT NULL,
    accessibilite VARCHAR(255) NOT NULL
);

-- Table offre_visite
CREATE TABLE offre_visite (
    id_offre INT PRIMARY KEY REFERENCES offre(id_offre),
    duree FLOAT NOT NULL,
    accessibilite VARCHAR(255) NOT NULL
);

-- Table visite_guidee
CREATE TABLE visite_guidee (
    id_offre INT PRIMARY KEY REFERENCES offre_visite(id_offre)
);

-- Table visite_guidee_disponible_en_langue
CREATE TABLE visite_guidee_disponible_en_langue (
    id_visite INT NOT NULL REFERENCES offre(id_offre),
    id_langue INT NOT NULL REFERENCES langue(id_langue),
    PRIMARY KEY (id_visite, id_langue)
);

-- Table visite_non_guidee
CREATE TABLE visite_non_guidee (
    id_offre INT PRIMARY KEY REFERENCES offre_visite(id_offre)
);

-- Table offre_spectacle
CREATE TABLE offre_spectacle (
    id_offre INT PRIMARY KEY REFERENCES offre(id_offre),
    duree FLOAT NOT NULL,
    accessibilite VARCHAR(255) NOT NULL,
    capacite_accueil INT NOT NULL,
    prix FLOAT NOT NULL
);

-- Table offre_parc_attraction
CREATE TABLE offre_parc_attraction (
    id_offre INT PRIMARY KEY REFERENCES offre(id_offre),
    nb_attraction INT NOT NULL,
    age INT NOT NULL,
    id_image INT NOT NULL REFERENCES image(id_image)
);

-- Table offre_restauration
CREATE TABLE offre_restauration (
    id_offre INT PRIMARY KEY REFERENCES offre(id_offre),
    gamme_prix FLOAT NOT NULL,
    id_image INT NOT NULL REFERENCES image(id_image)
);

-- Table pro_repond_avis
CREATE TABLE pro_repond_avis (
    id_utilisateur INT NOT NULL REFERENCES professionnel(id_utilisateur),
    id_avis INT NOT NULL REFERENCES avis(id_avis),
    description_rep VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_utilisateur, id_avis)
);

-- Table membre_aime_avis
CREATE TABLE membre_aime_avis (
    id_utilisateur INT NOT NULL REFERENCES membre(id_utilisateur),
    id_avis INT NOT NULL REFERENCES avis(id_avis),
    aime BOOLEAN NOT NULL,
    PRIMARY KEY (id_utilisateur, id_avis)
);

-- Table type_activite_autorise_tag
CREATE TABLE type_activite_autorise_tag (
    id_type_activite INT NOT NULL REFERENCES type_activite(id_type_activite),
    id_tag INT NOT NULL REFERENCES tag(id_tag),
    PRIMARY KEY (id_type_activite, id_tag)
);

-- Table activite_inclus_prestation
CREATE TABLE activite_inclus_prestation (
    id_offre INT NOT NULL REFERENCES offre(id_offre),
    id_prestation INT NOT NULL REFERENCES prestation(id_prestation),
    PRIMARY KEY (id_offre, id_prestation)
);

-- Table activite_non_inclus_prestation
CREATE TABLE activite_non_inclus_prestation (
    id_offre INT NOT NULL REFERENCES offre(id_offre),
    id_prestation INT NOT NULL REFERENCES prestation(id_prestation),
    PRIMARY KEY (id_offre, id_prestation)
);

-- Table option_payante_offre
CREATE TABLE option_payante_offre (
    id_offre INT NOT NULL REFERENCES offre(id_offre),
    id_option INT NOT NULL REFERENCES option(id_option),
    id_souscription INT NOT NULL REFERENCES souscription(id_souscription),
    PRIMARY KEY (id_offre, id_option, id_souscription)
);

-- Table offre_possede_tags
CREATE TABLE offre_possede_tags (
    id_offre INT NOT NULL REFERENCES offre(id_offre),
    id_tag INT NOT NULL REFERENCES tag(id_tag),
    PRIMARY KEY (id_offre, id_tag)
);

-- Table abonnement
CREATE TABLE abonnement (
    id_offre INT PRIMARY KEY REFERENCES offre(id_offre),
    id_utilisateur_prive INT NOT NULL REFERENCES professionnel_prive(id_utilisateur),
    prix FLOAT NOT NULL
);

-- Table pro_public_propose_offre
CREATE TABLE pro_public_propose_offre (
    id_offre INT PRIMARY KEY REFERENCES offre(id_offre),
    id_utilisateur_public INT NOT NULL REFERENCES professionnel_public(id_utilisateur)
);