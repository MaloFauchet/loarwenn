-- Suppression des tables existantes
DROP SCHEMA IF EXISTS tripenazor CASCADE;
CREATE SCHEMA tripenazor;
SET SCHEMA 'tripenazor';

-- Table ville
CREATE TABLE ville (
    id_ville SERIAL PRIMARY KEY,
    nom_ville VARCHAR(50) NOT NULL,
    code_postal VARCHAR(5) NOT NULL
);

CREATE TABLE adresse (
    id_adresse SERIAL PRIMARY KEY,
    voie VARCHAR(50) NOT NULL,
    numero_adresse INT,
    libelle_adresse VARCHAR(255) NOT NULL,
    complement_adresse VARCHAR(255),
    id_ville REFERENCES ville(id_ville)
);

-- Table utilisateur (classe mère)
CREATE TABLE utilisateur (
    id_utilisateur SERIAL PRIMARY KEY,
    id_adresse INT NOT NULL REFERENCES adresse(id_adresse),
    prenom VARCHAR(50) NOT NULL,
    nom VARCHAR(50) NOT NULL,
    num_telephone VARCHAR(10) NOT NULL,
    email VARCHAR(50) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL
);

-- Table professionnel (hérite de utilisateur)
CREATE TABLE professionnel (
    id_utilisateur INT PRIMARY KEY REFERENCES utilisateur(id_utilisateur),
    lien_site_web VARCHAR(100),
    code_secret TEXT
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

-- Table type_activite
CREATE TABLE type_activite (
    id_type_activite SERIAL PRIMARY KEY,
    libelle_activite VARCHAR(50)
);

-- Table offre
CREATE TABLE offre (
    id_offre SERIAL PRIMARY KEY,
    id_type_activite INT NOT NULL REFERENCES type_activite(id_type_activite),
    titre_offre VARCHAR(50) NOT NULL,
    note_moyenne FLOAT NOT NULL,
    nb_avis INT NOT NULL,
    en_ligne BOOLEAN NOT NULL,
    resume VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    date_creation TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    accessibilite VARCHAR(100),
    id_adresse INT NOT NULL REFERENCES adresse(id_adresse),
    id_image_couverture INT NOT NULL REFERENCES image(id_image)
);

CREATE TABLE horaire(
    id_horaire SERIAL PRIMARY KEY,
    debut TIME NOT NULL,
    fin TIME NOT NULL
)

CREATE TABLE horaire_ouverture(
    id_horaire INT REFERENCES horaire(id_horaire),
    id_offre INT REFERENCES offre(id_offre)
    PRIMARY KEY (id_horaire, id_offre)
)

CREATE TABLE jour(
    id_jour SERIAL PRIMARY KEY,
    libelle VARCHAR(50),
)

CREATE TABLE jour_ouverture(
    id_jour INT REFERENCES jour(id_jour),
    id_offre INT REFERENCES offre(id_offre)
    PRIMARY KEY (id_jour, id_offre)
)



-- Table statut_log
CREATE TABLE statut_log (
    id_statut_log SERIAL PRIMARY KEY,
    id_offre INT NOT NULL REFERENCES offre(id_offre), 
    date_mise_en_ligne DATE,
    date_mise_hors_ligne DATE
);

-- Table avis
CREATE TABLE avis (
    id_avis SERIAL PRIMARY KEY,
    id_utilisateur INT REFERENCES membre(id_utilisateur),
    id_offre INT NOT NULL REFERENCES offre(id_offre),
    description_avis VARCHAR(255) NOT NULL,
    note_avis FLOAT NOT NULL,
    titre_avis VARCHAR(50) NOT NULL,
    date_avis DATE NOT NULL DEFAULT CURRENT_DATE
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

CREATE TABLE tag_restauration (
    id_tag SERIAL PRIMARY KEY REFERENCES tag(id_tag),
);

CREATE TABLE tag_commun (
    id_tag SERIAL PRIMARY KEY REFERENCES tag(id_tag),
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
    id_visite INT NOT NULL REFERENCES visite_guidee(id_offre),
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
    id_image INT NOT NULL REFERENCES image(id_image),
    nb_attraction INT NOT NULL,
    age_min INT NOT NULL
);

-- Table offre_restauration
CREATE TABLE offre_restauration (
    id_offre INT PRIMARY KEY REFERENCES offre(id_offre),
    id_image INT REFERENCES image(id_image),
    gamme_prix VARCHAR(50) NOT NULL
);

CREATE TABLE type_repas(
    id_repas SERIAL PRIMARY KEY,
    libelle_repas VARCHAR(50) NOT NULL
)

CREATE TABLE type_repas_disponible(
    id_repas INT REFERENCES type_repas(id_repas),
    id_offre INT REFERENCES offre_restauration(id_offre),
    PRIMARY KEY (id_repas, id_offre)
)

-- Table reponse_pro
CREATE TABLE reponse_pro (
    id_avis INT NOT NULL REFERENCES avis(id_avis) PRIMARY KEY,
    description_rep VARCHAR(255) NOT NULL,
);

-- Table membre_aime_avis
CREATE TABLE membre_aime_avis (
    id_utilisateur INT NOT NULL REFERENCES membre(id_utilisateur),
    id_avis INT NOT NULL REFERENCES avis(id_avis),
    aime BOOLEAN NOT NULL,
    PRIMARY KEY (id_utilisateur, id_avis)
);

-- Table activite_inclus_prestation
CREATE TABLE activite_inclus_prestation (
    id_offre INT NOT NULL REFERENCES offre_activite(id_offre),
    id_prestation INT NOT NULL REFERENCES prestation(id_prestation),
    PRIMARY KEY (id_offre, id_prestation)
);

-- Table activite_non_inclus_prestation
CREATE TABLE activite_non_inclus_prestation (
    id_offre INT NOT NULL REFERENCES offre_activite(id_offre),
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
CREATE TABLE offre_restauration_possede_tag (
    id_offre INT NOT NULL REFERENCES offre_restauration(id_offre),
    id_tag INT NOT NULL REFERENCES tag_restauration(id_tag),
    PRIMARY KEY (id_offre, id_tag)
);

CREATE TABLE offre_activite_possede_tag (
    id_offre INT NOT NULL REFERENCES offre_activite(id_offre),
    id_tag INT NOT NULL REFERENCES tag_commun(id_tag),
    PRIMARY KEY (id_offre, id_tag)
);

CREATE TABLE offre_visite_possede_tag (
    id_offre INT NOT NULL REFERENCES offre_visite(id_offre),
    id_tag INT NOT NULL REFERENCES tag_commun(id_tag),
    PRIMARY KEY (id_offre, id_tag)
);

CREATE TABLE offre_parc_attraction_possede_tag (
    id_offre INT NOT NULL REFERENCES offre_parc_attraction(id_offre),
    id_tag INT NOT NULL REFERENCES tag_commun(id_tag),
    PRIMARY KEY (id_offre, id_tag)
);

CREATE TABLE offre_spectacle_possede_tag (
    id_offre INT NOT NULL REFERENCES offre_spectacle(id_offre),
    id_tag INT NOT NULL REFERENCES tag_commun(id_tag),
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
    id_offre INT REFERENCES offre(id_offre),
    id_utilisateur_public INT NOT NULL REFERENCES professionnel_public(id_utilisateur),
    PRIMARY KEY (id_offre, id_utilisateur_public)
);


-- Vues de données

CREATE VIEW infos_offre_page_accueil AS
SELECT 
    o.id_offre,
    o.titre_offre,
    o.note_moyenne,
    o.nb_avis,
    o.resume,
    o.description,
    o.adresse_offre,
	image.titre_image,
	image.chemin,

    MAX(CASE WHEN op.libelle_option = 'Recommandé' THEN 1 ELSE 0 END)::BOOLEAN AS "Recommandé",
    MAX(CASE WHEN op.libelle_option = 'En relief' THEN 1 ELSE 0 END)::BOOLEAN AS "En relief"

FROM offre o

LEFT JOIN option_payante_offre opo ON o.id_offre = opo.id_offre
LEFT JOIN option op ON opo.id_option = op.id_option
LEFT JOIN (
    SELECT id_offre, id_image
    FROM (
        SELECT 
            id_offre,
            id_image,
            ROW_NUMBER() OVER (PARTITION BY id_offre ORDER BY id_image ASC) AS rn
        FROM image_illustre_offre
    ) AS sub
    WHERE rn = 1
) AS banniere_img ON o.id_offre = banniere_img.id_offre
LEFT JOIN image ON banniere_img.id_image= image.id_image
WHERE en_ligne is TRUE
GROUP BY 
    o.id_offre,
    o.titre_offre,
    o.note_moyenne,
    o.nb_avis,
    o.resume,
    o.description,
    o.adresse_offre,
	image.titre_image,
	image.chemin;


-- Fonctions d'insertion

CREATE OR REPLACE FUNCTION inserer_utilisateur_et_professionnel_prive(
    p_nom TEXT,
    p_prenom TEXT,
    p_email TEXT,
    p_telephone TEXT,
    p_adresse TEXT,
    p_complement TEXT,
    p_code_postal TEXT,
    p_nom_ville TEXT,
    p_denomination TEXT,
    p_siren INT,
    p_rib TEXT,
    p_mot_de_passe TEXT
)
RETURNS VOID AS $$
DECLARE
    v_id_ville INTEGER;
    v_id_utilisateur INTEGER;
	v_id_image INTEGER;
BEGIN
    -- 1. Chercher ou insérer la ville
    SELECT id_ville INTO v_id_ville
    FROM tripenazor.ville
    WHERE nom_ville = p_nom_ville AND code_postal = p_code_postal;

    IF v_id_ville IS NULL THEN
        INSERT INTO tripenazor.ville (nom_ville, code_postal)
        VALUES (p_nom_ville, p_code_postal)
        RETURNING id_ville INTO v_id_ville;
    END IF;

    -- 2. Insérer l'utilisateur
    INSERT INTO tripenazor.utilisateur (
        nom, prenom, email, num_telephone, adresse, complement_adresse, mot_de_passe, id_ville
    )
    VALUES (
        p_nom, p_prenom, p_email, p_telephone, p_adresse, p_complement, p_mot_de_passe, v_id_ville
    )
    RETURNING id_utilisateur INTO v_id_utilisateur;

    -- 3. Insérer dans professionnel
	INSERT INTO tripenazor.professionnel (id_utilisateur)
	VALUES (v_id_utilisateur);
    INSERT INTO tripenazor.professionnel_prive (id_utilisateur, denomination, siren, rib)
    VALUES (v_id_utilisateur, p_denomination, p_siren, p_rib);

    -- 4. Insérer dans image
    INSERT INTO tripenazor.image (titre_image, chemin)
    VALUES ('Photo de profil', '/images/profils/default_profil.png')
    RETURNING id_image INTO v_id_image;

    --5 Liaison image

    INSERT INTO tripenazor.utilisateur_represente_image (id_utilisateur, id_image)
    VALUES (v_id_utilisateur, v_id_image);

END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION inserer_utilisateur_et_professionnel_public(
    p_nom TEXT,
    p_prenom TEXT,
    p_email TEXT,
    p_telephone TEXT,
    p_adresse TEXT,
    p_complement TEXT,
    p_code_postal TEXT,
    p_nom_ville TEXT,
    p_raison_sociale TEXT,
    p_mot_de_passe TEXT
)
RETURNS VOID AS $$
DECLARE
    v_id_ville INTEGER;
    v_id_utilisateur INTEGER;
	v_id_image INTEGER;
BEGIN
    -- 1. Chercher ou insérer la ville
    SELECT id_ville INTO v_id_ville
    FROM tripenazor.ville
    WHERE nom_ville = p_nom_ville AND code_postal = p_code_postal;

    IF v_id_ville IS NULL THEN
        INSERT INTO tripenazor.ville (nom_ville, code_postal)
        VALUES (p_nom_ville, p_code_postal)
        RETURNING id_ville INTO v_id_ville;
    END IF;

    -- 2. Insérer l'utilisateur
    INSERT INTO tripenazor.utilisateur (
        nom, prenom, email, num_telephone, adresse, complement_adresse, mot_de_passe, id_ville
    )
    VALUES (
        p_nom, p_prenom, p_email, p_telephone, p_adresse, p_complement, p_mot_de_passe, v_id_ville
    )
    RETURNING id_utilisateur INTO v_id_utilisateur;

    -- 3. Insérer dans professionnel
	INSERT INTO tripenazor.professionnel (id_utilisateur)
	VALUES (v_id_utilisateur);
    INSERT INTO tripenazor.professionnel_public (id_utilisateur, raison_sociale)
    VALUES (v_id_utilisateur, p_raison_sociale);

    -- 4. Insérer dans image
    INSERT INTO tripenazor.image (titre_image, chemin)
    VALUES ('Photo de profil', '/images/profils/default_profil.png')
    RETURNING id_image INTO v_id_image;

    --5 Liaison image

    INSERT INTO tripenazor.utilisateur_represente_image (id_utilisateur, id_image)
    VALUES (v_id_utilisateur, v_id_image);
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION tripenazor.inserer_utilisateur_et_membre(
    p_nom TEXT,
    p_prenom TEXT,
    p_email TEXT,
    p_telephone TEXT,
    p_adresse TEXT,
    p_complement TEXT,
    p_code_postal TEXT,
    p_nom_ville TEXT,
    p_pseudo TEXT,
    p_mot_de_passe TEXT
)
RETURNS VOID AS $$
DECLARE
    v_id_ville INTEGER;
    v_id_utilisateur INTEGER;
	v_id_image INTEGER;
BEGIN
    -- 1. Chercher ou insérer la ville
    SELECT id_ville INTO v_id_ville
    FROM tripenazor.ville
    WHERE nom_ville = p_nom_ville AND code_postal = p_code_postal;

    IF v_id_ville IS NULL THEN
        INSERT INTO tripenazor.ville (nom_ville, code_postal)
        VALUES (p_nom_ville, p_code_postal)
        RETURNING id_ville INTO v_id_ville;
    END IF;

    -- 2. Insérer l'utilisateur
    INSERT INTO tripenazor.utilisateur (
        nom, prenom, email, num_telephone, adresse, complement_adresse, mot_de_passe, id_ville
    )
    VALUES (
        p_nom, p_prenom, p_email, p_telephone, p_adresse, p_complement, p_mot_de_passe, v_id_ville
    )
    RETURNING id_utilisateur INTO v_id_utilisateur;

    -- 3. Insérer dans membre
	INSERT INTO tripenazor.membre (id_utilisateur, pseudo)
	VALUES (v_id_utilisateur, p_pseudo);

    -- 4. Insérer dans image
    INSERT INTO tripenazor.image (titre_image, chemin)
    VALUES ('Photo de profil', '/images/profils/default_profil.png')
    RETURNING id_image INTO v_id_image;

    --5 Liaison image

    INSERT INTO tripenazor.utilisateur_represente_image (id_utilisateur, id_image)
    VALUES (v_id_utilisateur, v_id_image);

END;
$$ LANGUAGE plpgsql;
