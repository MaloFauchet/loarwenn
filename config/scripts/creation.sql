-- Suppression des tables existantes
-- Suppression des tables existantes
DROP SCHEMA IF EXISTS tripenazor CASCADE;
CREATE SCHEMA tripenazor;
SET SCHEMA 'tripenazor';


-- Type Activité 
-- Type Activité 
CREATE TYPE type_activite AS ENUM (
  'visite_guidee',
  'visite_non_guidee',
  'activite',
  'parc_attraction',
  'spectacle',
  'restauration'

);


-- Table ville
CREATE TABLE ville (
    id_ville SERIAL PRIMARY KEY,
    nom_ville VARCHAR(50) NOT NULL,
    code_postal VARCHAR(5) NOT NULL
);

CREATE TABLE adresse (
    id_adresse SERIAL PRIMARY KEY,
    voie VARCHAR(50) NOT NULL,
    numero_adresse INT NOT NULL,
    complement_adresse VARCHAR(255),
    id_ville INT REFERENCES ville(id_ville) NOT NULL
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
    code_secret TEXT DEFAULT NULL,
    tentative_otp INT DEFAULT 0,
    derniere_tentative_otp TIMESTAMP DEFAULT NULL,
    bloque_jusqua TIMESTAMP DEFAULT NULL
);

-- Table professionnel_prive
CREATE TABLE professionnel_prive (
    id_utilisateur INT PRIMARY KEY REFERENCES professionnel(id_utilisateur),
    denomination VARCHAR(100) NOT NULL,
    siren NUMERIC(9) NOT NULL,
    iban VARCHAR(40) NOT NULL
);

-- Table professionnel_public
CREATE TABLE professionnel_public (
    id_utilisateur INT PRIMARY KEY REFERENCES professionnel(id_utilisateur),
    raison_sociale VARCHAR(100) NOT NULL
);

-- Table membre (indépendant de utilisateur)
CREATE TABLE membre (
    id_utilisateur INT PRIMARY KEY REFERENCES utilisateur(id_utilisateur),
    pseudo VARCHAR(50) NOT NULL
);

-- Table image
CREATE TABLE image (
    id_image SERIAL PRIMARY KEY,
    titre_image VARCHAR(100) NOT NULL,
    chemin TEXT NOT NULL
);

-- Table utilisateur_represente_image
CREATE TABLE utilisateur_represente_image (
    id_utilisateur INT NOT NULL REFERENCES utilisateur(id_utilisateur),
    id_image INT NOT NULL REFERENCES image(id_image),
    PRIMARY KEY (id_utilisateur, id_image)
);

-- Table offre
CREATE TABLE offre (
    id_offre SERIAL PRIMARY KEY,
    titre_offre VARCHAR(50) NOT NULL,
    en_ligne BOOLEAN NOT NULL,
    resume TEXT NOT NULL,
    description TEXT NOT NULL,
    date_creation TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    accessibilite VARCHAR(255),
    type_offre type_activite NOT NULL,
    prix_TTC_min FLOAT NOT NULL,
    id_adresse INT NOT NULL REFERENCES adresse(id_adresse),
    id_image_couverture INT NOT NULL REFERENCES image(id_image)
);

CREATE TABLE horaire(
    id_horaire SERIAL PRIMARY KEY,
    debut TIME NOT NULL,
    fin TIME NOT NULL
);

CREATE TABLE horaire_ouverture(
    id_horaire INT REFERENCES horaire(id_horaire),
    id_offre INT REFERENCES offre(id_offre),
    PRIMARY KEY (id_horaire, id_offre)
);

CREATE TABLE jour(
    id_jour SERIAL PRIMARY KEY,         
    libelle VARCHAR(50) NOT NULL
);

CREATE TABLE jour_ouverture(
    id_jour INT REFERENCES jour(id_jour),
    id_offre INT REFERENCES offre(id_offre),
    PRIMARY KEY (id_jour, id_offre)
);



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
    libelle_tag VARCHAR(100)
);

CREATE TABLE tag_restauration (
    id_tag SERIAL PRIMARY KEY REFERENCES tag(id_tag)
);

CREATE TABLE tag_commun (
    id_tag SERIAL PRIMARY KEY REFERENCES tag(id_tag)
);

-- Table souscription TODO
CREATE TABLE souscription (
    id_souscription SERIAL PRIMARY KEY,
    nb_semaine INT NOT NULL,
    date_debut DATE NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Table option TODO
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
    libelle_prestation VARCHAR(255)
);

-- Table offre_activite
CREATE TABLE offre_activite (
    id_offre INT PRIMARY KEY REFERENCES offre(id_offre),
    duree TIME NOT NULL,
    age INT NOT NULL
);

-- Table offre_visite
CREATE TABLE offre_visite (
    id_offre INT PRIMARY KEY REFERENCES offre(id_offre),
    duree TIME NOT NULL
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
    duree TIME NOT NULL,
    capacite_accueil INT NOT NULL
);

-- Table offre_parc_attraction
CREATE TABLE offre_parc_attraction (
    id_offre INT PRIMARY KEY REFERENCES offre(id_offre),
    id_image INT NOT NULL REFERENCES image(id_image),
    nb_attraction INT NOT NULL,
    age_min INT NOT NULL
);

-- Table gamme_prix
CREATE TABLE gamme_prix (
    id_gamme_prix SERIAL PRIMARY KEY,
    libelle_gamme_prix VARCHAR(100) NOT NULL
);

-- Table offre_restauration
CREATE TABLE offre_restauration (
    id_offre INT PRIMARY KEY REFERENCES offre(id_offre),
    id_image INT REFERENCES image(id_image),
    id_gamme_prix INT NOT NULL REFERENCES gamme_prix(id_gamme_prix)
);

CREATE TABLE type_repas(
    id_repas SERIAL PRIMARY KEY,
    libelle_repas VARCHAR(50) NOT NULL
);

CREATE TABLE type_repas_disponible(
    id_repas INT REFERENCES type_repas(id_repas),
    id_offre INT REFERENCES offre_restauration(id_offre),
    PRIMARY KEY (id_repas, id_offre)
);

-- Table reponse_pro
CREATE TABLE reponse_pro (
    id_avis INT NOT NULL REFERENCES avis(id_avis) PRIMARY KEY,
    description_rep VARCHAR(255) NOT NULL
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
    id_offre INT REFERENCES offre(id_offre),
    id_utilisateur_prive INT NOT NULL REFERENCES professionnel_prive(id_utilisateur),
    prix FLOAT NOT NULL DEFAULT 2.0,
    PRIMARY KEY (id_offre, id_utilisateur_prive)
);

-- Table pro_public_propose_offre
CREATE TABLE pro_public_propose_offre (
    id_offre INT REFERENCES offre(id_offre),
    id_utilisateur_public INT NOT NULL REFERENCES professionnel_public(id_utilisateur),
    PRIMARY KEY (id_offre, id_utilisateur_public)
);


-- Fonctions d'insertion

CREATE OR REPLACE FUNCTION inserer_utilisateur_et_professionnel_prive(
    p_nom TEXT,
    p_prenom TEXT,
    p_email TEXT,
    p_telephone TEXT,
    p_num_adresse INT,
    p_voie_adresse TEXT,
    p_complement TEXT,
    p_code_postal TEXT,
    p_nom_ville TEXT,
    p_denomination TEXT,
    p_siren INT,
    p_iban TEXT,
    p_mot_de_passe TEXT
)
RETURNS VOID AS $$
DECLARE
    v_id_ville INTEGER;
    v_id_adresse INTEGER;
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

    -- 1.5 Insérer l'adresse
    INSERT INTO tripenazor.adresse (voie, numero_adresse, complement_adresse, id_ville) 
    VALUES (p_voie_adresse, p_num_adresse, p_complement, v_id_ville)
    RETURNING id_adresse INTO v_id_adresse;

    -- 2. Insérer l'utilisateur
    INSERT INTO tripenazor.utilisateur (
        nom, prenom, email, num_telephone, mot_de_passe, id_adresse
    )
    VALUES (
        p_nom, p_prenom, p_email, p_telephone, p_mot_de_passe, v_id_adresse
    )
    RETURNING id_utilisateur INTO v_id_utilisateur;

    -- 3. Insérer dans professionnel
	INSERT INTO tripenazor.professionnel (id_utilisateur)
	VALUES (v_id_utilisateur);
    INSERT INTO tripenazor.professionnel_prive (id_utilisateur, denomination, siren, iban)
    VALUES (v_id_utilisateur, p_denomination, p_siren, p_iban);

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
    p_num_adresse INT,
    p_voie_adresse TEXT,
    p_complement TEXT,
    p_code_postal TEXT,
    p_nom_ville TEXT,
    p_raison_sociale TEXT,
    p_mot_de_passe TEXT
)
RETURNS VOID AS $$
DECLARE
    v_id_ville INTEGER;
    v_id_adresse INTEGER;
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

    -- 1.5 Insérer l'adresse
    INSERT INTO tripenazor.adresse (voie, numero_adresse, complement_adresse, id_ville) 
    VALUES (p_voie_adresse, p_num_adresse, p_complement, v_id_ville)
    RETURNING id_adresse INTO v_id_adresse;

    -- 1.5 Insérer l'adresse
    INSERT INTO tripenazor.adresse (voie, numero_adresse, complement_adresse, id_ville) 
    VALUES (p_voie_adresse, p_num_adresse, p_complement, v_id_ville)
    RETURNING id_adresse INTO v_id_adresse;

    -- 2. Insérer l'utilisateur
    INSERT INTO tripenazor.utilisateur (
        nom, prenom, email, num_telephone, mot_de_passe, id_adresse
    )
    VALUES (
        p_nom, p_prenom, p_email, p_telephone, p_mot_de_passe, v_id_adresse
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
    p_num_adresse INT,
    p_voie_adresse TEXT,
    p_complement TEXT,
    p_code_postal TEXT,
    p_nom_ville TEXT,
    p_pseudo TEXT,
    p_mot_de_passe TEXT
)
RETURNS VOID AS $$
DECLARE
    v_id_ville INTEGER;
    v_id_adresse INTEGER;
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

    -- 1.5 Insérer l'adresse
    INSERT INTO tripenazor.adresse (voie, numero_adresse, complement_adresse, id_ville) 
    VALUES (p_voie_adresse, p_num_adresse, p_complement, v_id_ville)
    RETURNING id_adresse INTO v_id_adresse;

    -- 1.5 Insérer l'adresse
    INSERT INTO tripenazor.adresse (voie, numero_adresse, complement_adresse, id_ville) 
    VALUES (p_voie_adresse, p_num_adresse, p_complement, v_id_ville)
    RETURNING id_adresse INTO v_id_adresse;

    -- 2. Insérer l'utilisateur
    INSERT INTO tripenazor.utilisateur (
        nom, prenom, email, num_telephone, mot_de_passe, id_adresse
    )
    VALUES (
        p_nom, p_prenom, p_email, p_telephone, p_mot_de_passe, v_id_adresse
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

CREATE OR REPLACE FUNCTION get_tags_by_offre(p_id_offre INT)
RETURNS TEXT AS $$
DECLARE
    result TEXT;
BEGIN
    SELECT string_agg(DISTINCT t.libelle_tag, ',')
    INTO result
    FROM tripenazor.tag t
    LEFT JOIN tripenazor.offre_activite_possede_tag oat ON t.id_tag = oat.id_tag AND oat.id_offre = p_id_offre
    LEFT JOIN tripenazor.offre_visite_possede_tag ovt ON t.id_tag = ovt.id_tag AND ovt.id_offre = p_id_offre
    LEFT JOIN tripenazor.offre_spectacle_possede_tag ost ON t.id_tag = ost.id_tag AND ost.id_offre = p_id_offre
    LEFT JOIN tripenazor.offre_parc_attraction_possede_tag opat ON t.id_tag = opat.id_tag AND opat.id_offre = p_id_offre
    LEFT JOIN tripenazor.offre_restauration_possede_tag ort ON t.id_tag = ort.id_tag AND ort.id_offre = p_id_offre
    WHERE oat.id_offre IS NOT NULL
       OR ovt.id_offre IS NOT NULL
       OR ost.id_offre IS NOT NULL
       OR opat.id_offre IS NOT NULL
       OR ort.id_offre IS NOT NULL;

    RETURN result;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION get_jours_by_offre(p_id_offre INT)
RETURNS TEXT AS $$
DECLARE
    result TEXT;
BEGIN
    SELECT string_agg(DISTINCT j.libelle, ',')
    INTO result
    FROM tripenazor.jour j
    INNER JOIN tripenazor.jour_ouverture jo ON j.id_jour=jo.id_jour AND jo.id_offre = p_id_offre;

    RETURN result;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION get_horaires_by_offre(p_id_offre INT)
RETURNS TEXT AS $$
DECLARE
    result TEXT;
BEGIN
    SELECT string_agg(
            to_char(h.debut, 'HH24:MI') || ' | ' || to_char(h.fin, 'HH24:MI'),
            ','
        )
    INTO result
    FROM tripenazor.horaire h
    INNER JOIN tripenazor.horaire_ouverture ho ON h.id_horaire=ho.id_horaire AND ho.id_offre = p_id_offre;

    RETURN result;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION get_images_by_offre(p_id_offre INT)
RETURNS TEXT AS $$
DECLARE
    result TEXT;
BEGIN
    SELECT string_agg(i.titre_image || ' | ' || i.chemin, ',')
    INTO result
    FROM tripenazor.image i
    INNER JOIN tripenazor.image_illustre_offre imo ON i.id_image = imo.id_image
    WHERE imo.id_offre = p_id_offre;

    RETURN result;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION get_langue_by_offre(o_id_offre INT)
RETURNS TEXT AS $$
DECLARE
    result TEXT;
BEGIN
    SELECT string_agg(DISTINCT langue.libelle_langue, ', ')
    INTO result
    FROM tripenazor.visite_guidee_disponible_en_langue vgl
    JOIN tripenazor.langue ON langue.id_langue = vgl.id_langue
    WHERE vgl.id_visite = o_id_offre;

    RETURN result;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION get_repas_by_offre(o_id_offre INT)
RETURNS TEXT AS $$
DECLARE
    result TEXT;
BEGIN
    SELECT string_agg(DISTINCT type_repas.libelle_repas, ', ')
    INTO result
    FROM tripenazor.type_repas
	LEFT JOIN tripenazor.type_repas_disponible ON type_repas.id_repas = type_repas_disponible.id_repas
    WHERE type_repas_disponible.id_offre = o_id_offre;
       

    RETURN result;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION get_prestation_incluses_by_offre(o_id_offre INT)
RETURNS TEXT AS $$
DECLARE
    result TEXT;
BEGIN
    SELECT string_agg(DISTINCT p.libelle_prestation, ', ')
    INTO result
    from tripenazor.activite_inclus_prestation as ap
	LEFT JOIN tripenazor.prestation as p ON ap.id_prestation = p.id_prestation
    WHERE ap.id_offre = o_id_offre;

    RETURN result;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION get_prestation_non_incluses_by_offre(o_id_offre INT)
RETURNS TEXT AS $$
DECLARE
    result TEXT;
BEGIN
    SELECT string_agg(DISTINCT p.libelle_prestation, ', ')
    INTO result
    from tripenazor.activite_non_inclus_prestation as ap
	LEFT JOIN tripenazor.prestation as p ON ap.id_prestation = p.id_prestation
    WHERE ap.id_offre = o_id_offre;

    RETURN result;
END;
$$ LANGUAGE plpgsql;
-- Vues de données


-- Vues de données
CREATE OR REPLACE VIEW infos_carte_offre AS
SELECT 
    o.id_offre,
    o.titre_offre,
    o.resume,
    o.description,
    o.accessibilite,
    o.date_creation,
	o.type_offre,
	o.prix_TTC_min,
	image.titre_image,
	image.chemin,
    adr.voie,
    adr.numero_adresse,
    adr.complement_adresse,
    v.nom_ville,
    v.code_postal,
    COUNT(avis.id_avis) as nb_avis,
    AVG(avis.note_avis) as note_avis,
    get_tags_by_offre(o.id_offre) as tags,
	get_jours_by_offre(o.id_offre) as jours_ouverture,

    MAX(CASE WHEN op.libelle_option = 'En relief' THEN 1 ELSE 0 END)::BOOLEAN AS "En relief",
    MAX(CASE WHEN op.libelle_option = 'A la une' THEN 1 ELSE 0 END)::BOOLEAN AS "A la une"

FROM offre o
LEFT JOIN option_payante_offre opo ON o.id_offre = opo.id_offre
LEFT JOIN option op ON opo.id_option = op.id_option
LEFT JOIN avis on o.id_offre = avis.id_offre
INNER JOIN adresse adr ON o.id_adresse=adr.id_adresse
INNER JOIN ville v on adr.id_ville=v.id_ville 
INNER JOIN image on o.id_image_couverture=image.id_image
WHERE en_ligne is TRUE
GROUP BY 
    o.id_offre,
    o.titre_offre,
    o.resume,
    o.description,
    o.accessibilite,
    o.date_creation,
	o.type_offre,
	o.prix_TTC_min,
	image.titre_image,
	image.chemin,
    adr.voie,
    adr.numero_adresse,
    adr.complement_adresse,
    v.nom_ville,
    v.code_postal;

    CREATE OR REPLACE VIEW infos_carte_offre_with_offline AS
SELECT 
    o.id_offre,
    o.titre_offre,
    o.resume,
    o.description,
    o.accessibilite,
    o.date_creation,
	o.type_offre,
	o.prix_TTC_min,
    o.en_ligne,
	image.titre_image,
	image.chemin,
    adr.voie,
    adr.numero_adresse,
    adr.complement_adresse,
    v.nom_ville,
    v.code_postal,
    COUNT(avis.id_avis) as nb_avis,
    AVG(avis.note_avis) as note_avis,
    get_tags_by_offre(o.id_offre) as tags,
	get_jours_by_offre(o.id_offre) as jours_ouverture,
    get_repas_by_offre(o.id_offre) as repas,

    MAX(CASE WHEN op.libelle_option = 'En relief' THEN 1 ELSE 0 END)::BOOLEAN AS "En relief",
    MAX(CASE WHEN op.libelle_option = 'A la une' THEN 1 ELSE 0 END)::BOOLEAN AS "A la une"

    FROM offre o
    LEFT JOIN option_payante_offre opo ON o.id_offre = opo.id_offre
    LEFT JOIN option op ON opo.id_option = op.id_option
    LEFT JOIN avis on o.id_offre = avis.id_offre
    INNER JOIN adresse adr ON o.id_adresse=adr.id_adresse
    INNER JOIN ville v on adr.id_ville=v.id_ville 
    INNER JOIN image on o.id_image_couverture=image.id_image
    GROUP BY 
        o.id_offre,
        o.titre_offre,
        o.resume,
        o.description,
        o.accessibilite,
        o.date_creation,
        o.type_offre,
        o.prix_TTC_min,
        image.titre_image,
        image.chemin,
        adr.voie,
        adr.numero_adresse,
        adr.complement_adresse,
        v.nom_ville,
        v.code_postal;

    CREATE OR REPLACE FUNCTION tripenazor.inserer_offre_activite(
    -- Paramètres de l'offre
    p_nom_ville TEXT,
    p_code_postal TEXT,

    p_titre_offre TEXT,
	p_en_ligne BOOLEAN,
    p_resume TEXT,
    p_description TEXT,
    p_accessibilite TEXT,
    p_type_offre tripenazor.type_activite,
    p_prix_TTC_min FLOAT,
    p_tags TEXT[],

    -- Adresse
    p_voie TEXT,
    p_numero_adresse INT,
    p_complement_adresse TEXT,
    
    -- Image
    p_titre_image TEXT,
    p_chemin_image TEXT,
    p_titre_image_secondaire TEXT[],
    p_chemin_image_secondaire TEXT[],

    -- Jour de l'activité
    p_jours NUMERIC[],
    p_matin_heure_debut TIME,
    p_matin_heure_fin TIME,

    -- Professionnel
    p_id_professionnel INT,

    -- Paramètres spécifiques à l'activité
    p_prestations_incluses TEXT[],
    p_prestations_non_incluses TEXT[],
    p_duree TIME,
    p_age INT,
	
    p_apres_midi_heure_debut TIME DEFAULT NULL,
    p_apres_midi_heure_fin TIME DEFAULT NULL,
	p_prix_prive FLOAT DEFAULT NULL
)
RETURNS VOID AS $$
DECLARE
    v_id_offre INT;
    v_id_image INT;
    v_id_horaire_matin INT;
    v_id_horaire_apres_midi INT;
    v_id_adresse INT;
    v_id_ville INT;
	v_id_jour INT;
    v_id_professionnel_prive INT;
    v_id_professionnel_public INT;
    v_id_tag INT;
    v_id_tag_commun INT;
    v_id_prestation_incluse INT;
    v_id_prestation_non_incluse INT;
	v_jour TEXT;
    v_tag TEXT;
	v_prestation_incluse TEXT;
	v_prestation_non_incluse TEXT;
BEGIN
    SELECT id_ville INTO v_id_ville FROM tripenazor.ville 
    WHERE nom_ville = p_nom_ville AND code_postal = p_code_postal;

    IF v_id_ville IS NULL THEN
        -- Insère la ville
        INSERT INTO tripenazor.ville(nom_ville, code_postal)
        VALUES (p_nom_ville, p_code_postal)
        RETURNING id_ville INTO v_id_ville;
    END IF;

    SELECT id_adresse INTO v_id_adresse FROM tripenazor.adresse
    WHERE voie = p_voie AND
        numero_adresse = p_numero_adresse AND
        complement_adresse = p_complement_adresse AND
        id_ville = v_id_ville;

    IF v_id_adresse IS NULL THEN
        -- Insère l'adresse
        INSERT INTO tripenazor.adresse(voie, numero_adresse, complement_adresse, id_ville)
        VALUES (p_voie, p_numero_adresse, p_complement_adresse, v_id_ville)
        RETURNING id_adresse INTO v_id_adresse;
    END IF;

    -- Insère image
    INSERT INTO tripenazor.image (titre_image, chemin)
    VALUES (p_titre_image, p_chemin_image)
    RETURNING id_image INTO v_id_image;
	
    -- Insertion de l'offre
    INSERT INTO tripenazor.offre (
        titre_offre,
        en_ligne,
        resume,
        description,
        accessibilite,
        type_offre,
        prix_TTC_min,
        id_adresse,
        id_image_couverture
    )
    VALUES (
        p_titre_offre,
        p_en_ligne,
        p_resume,
        p_description,
        p_accessibilite,
        p_type_offre::tripenazor.type_activite,
        p_prix_TTC_min,
        v_id_adresse,
        v_id_image
    )
    RETURNING id_offre INTO v_id_offre;

    -- Liaison image et offre
    INSERT INTO tripenazor.image_illustre_offre (id_offre, id_image)
    VALUES (v_id_offre, v_id_image);

    FOR i IN 1 .. array_length(p_titre_image_secondaire, 1) LOOP
        -- Insère chaque image secondaire
        INSERT INTO tripenazor.image (titre_image, chemin)
        VALUES (p_titre_image_secondaire[i], p_chemin_image_secondaire[i])
        RETURNING id_image INTO v_id_image;

        -- Liaison image et offre
        INSERT INTO tripenazor.image_illustre_offre (id_offre, id_image)
        VALUES (v_id_offre, v_id_image);
    END LOOP;

    -- Jour et horaire de l'activité
    FOREACH v_jour IN ARRAY p_jours
    LOOP
        v_id_jour = null;

        SELECT id_jour INTO v_id_jour FROM tripenazor.jour
        WHERE id_jour = v_jour::INT;

        IF v_id_jour IS NOT NULL THEN 
            INSERT INTO tripenazor.jour_ouverture(id_jour, id_offre)
            VALUES (v_id_jour, v_id_offre);
        END IF;
    END LOOP;

    -- Insertion des horaires
    SELECT id_horaire INTO v_id_horaire_matin FROM tripenazor.horaire
    WHERE debut = p_matin_heure_debut::TIME WITH TIME ZONE  AND
    fin = p_matin_heure_fin::TIME WITH TIME ZONE;

    IF v_id_horaire_matin IS NULL THEN
        INSERT INTO tripenazor.horaire(debut, fin)
        VALUES (
            p_matin_heure_debut::TIME WITH TIME ZONE, 
            p_matin_heure_fin::TIME WITH TIME ZONE
        ) RETURNING id_horaire INTO v_id_horaire_matin;

        INSERT INTO tripenazor.horaire_ouverture(id_horaire, id_offre)
        VALUES (v_id_horaire_matin, v_id_offre);
    END IF;

    IF p_apres_midi_heure_debut IS NOT NULL AND p_apres_midi_heure_fin IS NOT NULL THEN
        SELECT id_horaire INTO v_id_horaire_apres_midi FROM tripenazor.horaire
        WHERE debut = p_apres_midi_heure_debut::TIME AND
        fin = p_apres_midi_heure_fin::TIME;

        IF v_id_horaire_apres_midi IS NULL THEN
            INSERT INTO tripenazor.horaire(debut, fin)
            VALUES (
                p_apres_midi_heure_debut::TIME, 
                p_apres_midi_heure_fin::TIME
            ) RETURNING id_horaire INTO v_id_horaire_apres_midi;

            INSERT INTO tripenazor.horaire_ouverture(id_horaire, id_offre)
            VALUES (v_id_horaire_apres_midi, v_id_offre);
        END IF;
    END IF;

    -- Insertion du professionnel
    SELECT id_utilisateur INTO v_id_professionnel_prive FROM tripenazor.professionnel_prive
    WHERE id_utilisateur = p_id_professionnel;

    SELECT id_utilisateur INTO v_id_professionnel_public FROM tripenazor.professionnel_public
    WHERE id_utilisateur = p_id_professionnel;

    IF v_id_professionnel_prive IS NOT NULL THEN
        INSERT INTO tripenazor.abonnement (id_offre, id_utilisateur_prive, prix)
        VALUES (v_id_offre, v_id_professionnel_prive, p_prix_prive);
    ELSIF v_id_professionnel_public IS NOT NULL THEN
        INSERT INTO tripenazor.pro_public_propose_offre (id_offre, id_utilisateur_public)
        VALUES (v_id_offre, v_id_professionnel_public);
    ELSE
        RAISE EXCEPTION 'Le professionnel avec l''ID % n''existe pas dans les tables professionnel_prive ou professionnel_public', p_id_professionnel;
    END IF;

    -- ///////// Partie différente /////////
    -- Insertion dans offre_activite
    INSERT INTO tripenazor.offre_activite (
        id_offre, duree, age
    )
    VALUES (
        v_id_offre, p_duree, p_age
    );

    -- Insert des tags
    FOREACH v_tag IN ARRAY p_tags
    LOOP
        v_id_tag := NULL;
        v_id_tag_commun := NULL;

        -- Chercher le tag dans la table "tag"
        SELECT id_tag INTO v_id_tag
        FROM tripenazor.tag
        WHERE libelle_tag = v_tag;

        -- Si le tag n'existe pas, on l'insère, puis on le marque comme commun
        IF v_id_tag IS NULL THEN
            INSERT INTO tripenazor.tag (libelle_tag)
            VALUES (v_tag)
            RETURNING id_tag INTO v_id_tag;

            INSERT INTO tripenazor.tag_commun (id_tag)
            VALUES (v_id_tag);
        END IF;

        -- Vérifie que ce tag est bien commun
        SELECT id_tag INTO v_id_tag_commun
        FROM tripenazor.tag_commun
        WHERE id_tag = v_id_tag;

        -- Si c'est bien un tag commun, lier à l'offre si pas déjà lié
        IF v_id_tag_commun IS NOT NULL THEN
            IF NOT EXISTS (
                SELECT 1 FROM tripenazor.offre_activite_possede_tag
                WHERE id_offre = v_id_offre AND id_tag = v_id_tag
            ) THEN
                INSERT INTO tripenazor.offre_activite_possede_tag (id_offre, id_tag)
                VALUES (v_id_offre, v_id_tag);
            END IF;
        END IF;
    END LOOP;

    -- Prestation incluses
    FOREACH v_prestation_incluse IN ARRAY p_prestations_incluses
    LOOP
        v_id_prestation_incluse = NULL;

        SELECT id_prestation INTO v_id_prestation_incluse FROM tripenazor.prestation 
        WHERE libelle_prestation = v_prestation_incluse;

        IF v_id_prestation_incluse IS NULL THEN
            INSERT INTO tripenazor.prestation (libelle_prestation)
            VALUES (v_prestation_incluse)
			RETURNING id_prestation INTO v_id_prestation_incluse;

            INSERT INTO tripenazor.activite_inclus_prestation (id_offre, id_prestation)
            VALUES (v_id_offre, v_id_prestation_incluse);
        END IF;
    END LOOP;

    -- Prestation non incluses
    FOREACH v_prestation_non_incluse IN ARRAY p_prestations_non_incluses
    LOOP
        v_id_prestation_incluse = NULL;

        SELECT id_prestation INTO v_id_prestation_incluse FROM tripenazor.prestation 
        WHERE libelle_prestation = v_prestation_non_incluse;

        IF v_id_prestation_non_incluse IS NULL THEN 
            INSERT INTO tripenazor.prestation (libelle_prestation)
            VALUES (v_prestation_non_incluse)
			RETURNING id_prestation INTO v_id_prestation_incluse;

            INSERT INTO tripenazor.activite_non_inclus_prestation (id_offre, id_prestation)
            VALUES (v_id_offre, v_id_prestation_incluse);
        END IF;
    END LOOP;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION tripenazor.inserer_offre_parc_attration(
    -- Paramètres de l'offre
    p_nom_ville TEXT,
    p_code_postal TEXT,

    p_titre_offre TEXT,
	p_en_ligne BOOLEAN,
    p_resume TEXT,
    p_description TEXT,
    p_accessibilite TEXT,
    p_type_offre tripenazor.type_activite,
    p_prix_TTC_min FLOAT,
    p_tags TEXT[],

    -- Adresse
    p_voie TEXT,
    p_numero_adresse INT,
    p_complement_adresse TEXT,
    
    -- Image
    p_titre_image TEXT,
    p_chemin_image TEXT,
    p_titre_image_secondaire TEXT[],
    p_chemin_image_secondaire TEXT[],

    -- Jour de l'activité
    p_jours NUMERIC[],
    p_matin_heure_debut TIME,
    p_matin_heure_fin TIME,

    -- Professionnel
    p_id_professionnel INT,

    -- Paramètres spécifiques à l'activité
    p_nb_attractions INT,
    p_age_min INT,
    p_titre_image_parc TEXT,
    p_chemin_image_parc TEXT,

    p_apres_midi_heure_debut TIME DEFAULT NULL,
    p_apres_midi_heure_fin TIME DEFAULT NULL,
    p_prix_prive FLOAT DEFAULT NULL
)
RETURNS VOID AS $$
DECLARE
    v_id_offre INT;
    v_id_image INT;
    v_id_horaire_matin INT;
    v_id_horaire_apres_midi INT;
    v_id_adresse INT;
    v_id_ville INT;
	v_id_jour INT;
    v_id_professionnel_prive INT;
    v_id_professionnel_public INT;
    v_id_image_parc INT;
    v_id_tag INT;
    v_id_tag_commun INT;
	v_jour INT;
    v_tag TEXT;
BEGIN
    SELECT id_ville INTO v_id_ville FROM tripenazor.ville 
    WHERE nom_ville = p_nom_ville AND code_postal = p_code_postal;

    IF v_id_ville IS NULL THEN
        -- Insère la ville
        INSERT INTO tripenazor.ville(nom_ville, code_postal)
        VALUES (p_nom_ville, p_code_postal)
        RETURNING id_ville INTO v_id_ville;
    END IF;

    SELECT id_adresse INTO v_id_adresse FROM tripenazor.adresse
    WHERE voie = p_voie AND
        numero_adresse = p_numero_adresse AND
        complement_adresse = p_complement_adresse AND
        id_ville = v_id_ville;

    IF v_id_adresse IS NULL THEN
        -- Insère l'adresse
        INSERT INTO tripenazor.adresse(voie, numero_adresse, complement_adresse, id_ville)
        VALUES (p_voie, p_numero_adresse, p_complement_adresse, v_id_ville)
        RETURNING id_adresse INTO v_id_adresse;
    END IF;

    -- Insère image
    INSERT INTO tripenazor.image (titre_image, chemin)
    VALUES (p_titre_image, p_chemin_image)
    RETURNING id_image INTO v_id_image;
	
    -- Insertion de l'offre
    INSERT INTO tripenazor.offre (
        titre_offre,
        en_ligne,
        resume,
        description,
        accessibilite,
        type_offre,
        prix_TTC_min,
        id_adresse,
        id_image_couverture
    )
    VALUES (
        p_titre_offre,
        p_en_ligne,
        p_resume,
        p_description,
        p_accessibilite,
        p_type_offre::tripenazor.type_activite,
        p_prix_TTC_min,
        v_id_adresse,
        v_id_image
    )
    RETURNING id_offre INTO v_id_offre;

    -- Liaison image et offre
    INSERT INTO tripenazor.image_illustre_offre (id_offre, id_image)
    VALUES (v_id_offre, v_id_image);

    FOR i IN 1 .. array_length(p_titre_image_secondaire, 1) LOOP
        -- Insère chaque image secondaire
        INSERT INTO tripenazor.image (titre_image, chemin)
        VALUES (p_titre_image_secondaire[i], p_chemin_image_secondaire[i])
        RETURNING id_image INTO v_id_image;

        -- Liaison image et offre
        INSERT INTO tripenazor.image_illustre_offre (id_offre, id_image)
        VALUES (v_id_offre, v_id_image);
    END LOOP;

    -- Jour et horaire de l'activité
    FOREACH v_jour IN ARRAY p_jours
    LOOP
        v_id_jour = null;

        SELECT id_jour INTO v_id_jour FROM tripenazor.jour
        WHERE id_jour = v_jour::INT;

        IF v_id_jour IS NOT NULL THEN 
            INSERT INTO tripenazor.jour_ouverture(id_jour, id_offre)
            VALUES (v_id_jour, v_id_offre);
        END IF;
    END LOOP;

    -- Insertion des horaires
    SELECT id_horaire INTO v_id_horaire_matin FROM tripenazor.horaire
    WHERE debut = p_matin_heure_debut::TIME WITH TIME ZONE  AND
    fin = p_matin_heure_fin::TIME WITH TIME ZONE;

    IF v_id_horaire_matin IS NULL THEN
        INSERT INTO tripenazor.horaire(debut, fin)
        VALUES (
            p_matin_heure_debut::TIME WITH TIME ZONE, 
            p_matin_heure_fin::TIME WITH TIME ZONE
        ) RETURNING id_horaire INTO v_id_horaire_matin;

        INSERT INTO tripenazor.horaire_ouverture(id_horaire, id_offre)
        VALUES (v_id_horaire_matin, v_id_offre);
    END IF;

    
    IF p_apres_midi_heure_debut IS NOT NULL AND p_apres_midi_heure_fin IS NOT NULL THEN
        SELECT id_horaire INTO v_id_horaire_apres_midi FROM tripenazor.horaire
        WHERE debut = p_apres_midi_heure_debut::TIME AND
        fin = p_apres_midi_heure_fin::TIME;

        IF v_id_horaire_apres_midi IS NULL THEN
            INSERT INTO tripenazor.horaire(debut, fin)
            VALUES (
                p_apres_midi_heure_debut::TIME, 
                p_apres_midi_heure_fin::TIME
            ) RETURNING id_horaire INTO v_id_horaire_apres_midi;

            INSERT INTO tripenazor.horaire_ouverture(id_horaire, id_offre)
            VALUES (v_id_horaire_apres_midi, v_id_offre);
        END IF;
    END IF;

    -- Insertion du professionnel
    SELECT id_utilisateur INTO v_id_professionnel_prive FROM tripenazor.professionnel_prive
    WHERE id_utilisateur = p_id_professionnel;

    SELECT id_utilisateur INTO v_id_professionnel_public FROM tripenazor.professionnel_public
    WHERE id_utilisateur = p_id_professionnel;

    IF v_id_professionnel_prive IS NOT NULL THEN
        INSERT INTO tripenazor.abonnement (id_offre, id_utilisateur_prive, prix)
        VALUES (v_id_offre, v_id_professionnel_prive, p_prix_prive);
    ELSIF v_id_professionnel_public IS NOT NULL THEN
        INSERT INTO tripenazor.pro_public_propose_offre (id_offre, id_utilisateur_public)
        VALUES (v_id_offre, v_id_professionnel_public);
    ELSE
        RAISE EXCEPTION 'Le professionnel avec l''ID % n''existe pas dans les tables professionnel_prive ou professionnel_public', p_id_professionnel;
    END IF;
    
    -- ///////// Partie différente /////////
	-- Image carte du parc
    INSERT INTO tripenazor.image (titre_image, chemin)
    VALUES (p_titre_image_parc, p_chemin_image_parc)
    RETURNING id_image INTO v_id_image_parc;

    -- Liaison image et offre
    INSERT INTO tripenazor.image_illustre_offre (id_offre, id_image)
    VALUES (v_id_offre, v_id_image_parc);
	
	-- Insertion dans offre_parc_attraction
    INSERT INTO tripenazor.offre_parc_attraction (id_offre, id_image, nb_attraction, age_min)
    VALUES (v_id_offre, v_id_image_parc, p_nb_attractions, p_age_min);
	
    -- Insert des tags
    FOREACH v_tag IN ARRAY p_tags
    LOOP
        v_id_tag_commun = null;
        v_id_tag = null;

        SELECT id_tag INTO v_id_tag FROM tripenazor.tag
        WHERE libelle_tag = v_tag;

        IF v_id_tag IS NOT NULL THEN
            SELECT id_tag INTO v_id_tag_commun FROM tripenazor.tag_commun
            WHERE id_tag = v_id_tag;

            IF v_id_tag_commun IS NOT NULL THEN
                INSERT INTO tripenazor.offre_parc_attraction_possede_tag(id_offre, id_tag)
                VALUES (v_id_offre, v_id_tag);
            END IF;
        END IF;
    END LOOP;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION tripenazor.inserer_offre_restauration(
    -- Paramètres de l'offre
    p_nom_ville TEXT,
    p_code_postal TEXT,

    p_titre_offre TEXT,
	p_en_ligne BOOLEAN,
    p_resume TEXT,
    p_description TEXT,
    p_accessibilite TEXT,
    p_type_offre tripenazor.type_activite,
    p_prix_TTC_min FLOAT,
    p_tags TEXT[],

    -- Adresse
    p_voie TEXT,
    p_numero_adresse INT,
    p_complement_adresse TEXT,
    
    -- Image
    p_titre_image TEXT,
    p_chemin_image TEXT,
    p_titre_image_secondaire TEXT[],
    p_chemin_image_secondaire TEXT[],

    -- Jour de l'activité
    p_jours NUMERIC[],
    p_matin_heure_debut TIME,
    p_matin_heure_fin TIME,

    -- Professionnel
    p_id_professionnel INT,

    -- Paramètres spécifiques à l'activité
    p_titre_image_carte TEXT,
    p_chemin_image_carte TEXT,
    p_libelle_gamme_prix TEXT,

    p_apres_midi_heure_debut TIME DEFAULT NULL,
    p_apres_midi_heure_fin TIME DEFAULT NULL,
	p_prix_prive INT DEFAULT NULL
)
RETURNS VOID AS $$
DECLARE
    v_id_offre INT;
    v_id_image INT;
    v_id_horaire_matin INT;
    v_id_horaire_apres_midi INT;
    v_id_adresse INT;
    v_id_ville INT;
	v_id_jour INT;
    v_id_professionnel_prive INT;
    v_id_professionnel_public INT;
    v_id_tag INT;
    v_id_tag_restauration INT;
    v_id_image_carte INT;
    v_id_gamme_prix INT;
	v_jour INT;
    v_tag TEXT;
BEGIN
    SELECT id_ville INTO v_id_ville FROM tripenazor.ville 
    WHERE nom_ville = p_nom_ville AND code_postal = p_code_postal;

    IF v_id_ville IS NULL THEN
        -- Insère la ville
        INSERT INTO tripenazor.ville(nom_ville, code_postal)
        VALUES (p_nom_ville, p_code_postal)
        RETURNING id_ville INTO v_id_ville;
    END IF;

    SELECT id_adresse INTO v_id_adresse FROM tripenazor.adresse
    WHERE voie = p_voie AND
        numero_adresse = p_numero_adresse AND
        complement_adresse = p_complement_adresse AND
        id_ville = v_id_ville;

    IF v_id_adresse IS NULL THEN
        -- Insère l'adresse
        INSERT INTO tripenazor.adresse(voie, numero_adresse, complement_adresse, id_ville)
        VALUES (p_voie, p_numero_adresse, p_complement_adresse, v_id_ville)
        RETURNING id_adresse INTO v_id_adresse;
    END IF;

    -- Insère image
    INSERT INTO tripenazor.image (titre_image, chemin)
    VALUES (p_titre_image, p_chemin_image)
    RETURNING id_image INTO v_id_image;
	
    -- Insertion de l'offre
    INSERT INTO tripenazor.offre (
        titre_offre,
        en_ligne,
        resume,
        description,
        accessibilite,
        type_offre,
        prix_TTC_min,
        id_adresse,
        id_image_couverture
    )
    VALUES (
        p_titre_offre,
        p_en_ligne,
        p_resume,
        p_description,
        p_accessibilite,
        p_type_offre::tripenazor.type_activite,
        p_prix_TTC_min,
        v_id_adresse,
        v_id_image
    )
    RETURNING id_offre INTO v_id_offre;

    -- Liaison image et offre
    INSERT INTO tripenazor.image_illustre_offre (id_offre, id_image)
    VALUES (v_id_offre, v_id_image);

    FOR i IN 1 .. array_length(p_titre_image_secondaire, 1) LOOP
        -- Insère chaque image secondaire
        INSERT INTO tripenazor.image (titre_image, chemin)
        VALUES (p_titre_image_secondaire[i], p_chemin_image_secondaire[i])
        RETURNING id_image INTO v_id_image;

        -- Liaison image et offre
        INSERT INTO tripenazor.image_illustre_offre (id_offre, id_image)
        VALUES (v_id_offre, v_id_image);
    END LOOP;

    -- Jour et horaire de l'activité
    FOREACH v_jour IN ARRAY p_jours
    LOOP
        v_id_jour = null;

        SELECT id_jour INTO v_id_jour FROM tripenazor.jour
        WHERE id_jour = v_jour::INT;

        IF v_id_jour IS NOT NULL THEN 
            INSERT INTO tripenazor.jour_ouverture(id_jour, id_offre)
            VALUES (v_id_jour, v_id_offre);
        END IF;
    END LOOP;

    -- Insertion des horaires
    SELECT id_horaire INTO v_id_horaire_matin FROM tripenazor.horaire
    WHERE debut = p_matin_heure_debut::TIME WITH TIME ZONE  AND
    fin = p_matin_heure_fin::TIME WITH TIME ZONE;

    IF v_id_horaire_matin IS NULL THEN
        INSERT INTO tripenazor.horaire(debut, fin)
        VALUES (
            p_matin_heure_debut::TIME WITH TIME ZONE, 
            p_matin_heure_fin::TIME WITH TIME ZONE
        ) RETURNING id_horaire INTO v_id_horaire_matin;

        INSERT INTO tripenazor.horaire_ouverture(id_horaire, id_offre)
        VALUES (v_id_horaire_matin, v_id_offre);
    END IF;

    
    IF p_apres_midi_heure_debut IS NOT NULL AND p_apres_midi_heure_fin IS NOT NULL THEN
        SELECT id_horaire INTO v_id_horaire_apres_midi FROM tripenazor.horaire
        WHERE debut = p_apres_midi_heure_debut::TIME AND
        fin = p_apres_midi_heure_fin::TIME;

        IF v_id_horaire_apres_midi IS NULL THEN
            INSERT INTO tripenazor.horaire(debut, fin)
            VALUES (
                p_apres_midi_heure_debut::TIME, 
                p_apres_midi_heure_fin::TIME
            ) RETURNING id_horaire INTO v_id_horaire_apres_midi;

            INSERT INTO tripenazor.horaire_ouverture(id_horaire, id_offre)
            VALUES (v_id_horaire_apres_midi, v_id_offre);
        END IF;
    END IF;

    -- Insertion du professionnel
    SELECT id_utilisateur INTO v_id_professionnel_prive FROM tripenazor.professionnel_prive
    WHERE id_utilisateur = p_id_professionnel;

    SELECT id_utilisateur INTO v_id_professionnel_public FROM tripenazor.professionnel_public
    WHERE id_utilisateur = p_id_professionnel;

    IF v_id_professionnel_prive IS NOT NULL THEN
        INSERT INTO tripenazor.abonnement (id_offre, id_utilisateur_prive, prix)
        VALUES (v_id_offre, v_id_professionnel_prive, p_prix_prive);
    ELSIF v_id_professionnel_public IS NOT NULL THEN
        INSERT INTO tripenazor.pro_public_propose_offre (id_offre, id_utilisateur_public)
        VALUES (v_id_offre, v_id_professionnel_public);
    ELSE
        RAISE EXCEPTION 'Le professionnel avec l''ID % n''existe pas dans les tables professionnel_prive ou professionnel_public', p_id_professionnel;
    END IF;

    -- ///////// Partie différente /////////
    -- Image de la carte
    INSERT INTO tripenazor.image (titre_image, chemin)
    VALUES (p_titre_image_carte, p_chemin_image_carte)
    RETURNING id_image INTO v_id_image_carte;
    
    -- Liaison image et offre
    INSERT INTO tripenazor.image_illustre_offre (id_offre, id_image)
    VALUES (v_id_offre, v_id_image_carte);

    -- Gamme de prix
    SELECT id_gamme_prix INTO v_id_gamme_prix 
    FROM tripenazor.gamme_prix
    WHERE libelle_gamme_prix = p_libelle_gamme_prix;

    IF v_id_gamme_prix IS NULL THEN
        INSERT INTO tripenazor.gamme_prix (libelle_gamme_prix)
        VALUES (p_libelle_gamme_prix)
        RETURNING id_gamme_prix INTO v_id_gamme_prix;
    END IF;

    -- Insertion dans offre_activite
    INSERT INTO tripenazor.offre_restauration (id_offre, id_image, id_gamme_prix)
    VALUES (v_id_offre, v_id_image_carte, v_id_gamme_prix);

    -- Insert des tags
    FOREACH v_tag IN ARRAY p_tags
    LOOP
        v_id_tag_restauration = null;
        v_id_tag = null;

        SELECT id_tag FROM tripenazor.tag
        WHERE libelle_tag = v_tag
        INTO v_id_tag;

        IF v_id_tag IS NOT NULL THEN
            SELECT id_tag FROM tripenazor.tag_commun
            WHERE id_tag = v_id_tag
            INTO v_id_tag_restauration;

            IF v_id_tag_restauration IS NOT NULL THEN
                INSERT INTO tripenazor.offre_activite_possede_tag(id_offre, id_tag)
                VALUES (v_id_offre, v_id_tag);
            END IF;
        END IF;
    END LOOP;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION tripenazor.inserer_offre_spectacle(
    -- Paramètres de l'offre
    p_nom_ville TEXT,
    p_code_postal TEXT,

    p_titre_offre TEXT,
	p_en_ligne BOOLEAN,
    p_resume TEXT,
    p_description TEXT,
    p_accessibilite TEXT,
    p_type_offre tripenazor.type_activite,
    p_prix_TTC_min FLOAT,
    p_tags TEXT[],

    -- Adresse
    p_voie TEXT,
    p_numero_adresse INT,
    p_complement_adresse TEXT,
    -- Image
    p_titre_image TEXT,
    p_chemin_image TEXT,
    p_titre_image_secondaire TEXT[],
    p_chemin_image_secondaire TEXT[],

    -- Jour de l'activité
    p_jours NUMERIC[],
    p_matin_heure_debut TIME,
    p_matin_heure_fin TIME,

    -- Professionnel
    p_id_professionnel INT,

    -- Paramètres spécifiques à l'activité
    p_duree TIME,
    p_capacite_accueil FLOAT,

    p_apres_midi_heure_debut TIME DEFAULT NULL,
    p_apres_midi_heure_fin TIME DEFAULT NULL,
    p_prix_prive INT DEFAULT NULL
)
RETURNS VOID AS $$
DECLARE
    v_id_offre INT;
    v_id_image INT;
    v_id_horaire_matin INT;
    v_id_horaire_apres_midi INT;
    v_id_adresse INT;
    v_id_ville INT;
	v_id_jour INT;
    v_id_professionnel_prive INT;
    v_id_professionnel_public INT;
    v_id_tag INT;
	v_id_tag_commun INT;
	v_jour INT;
    v_tag TEXT;
BEGIN
    SELECT id_ville INTO v_id_ville FROM tripenazor.ville 
    WHERE nom_ville = p_nom_ville AND code_postal = p_code_postal;

    IF v_id_ville IS NULL THEN
        -- Insère la ville
        INSERT INTO tripenazor.ville(nom_ville, code_postal)
        VALUES (p_nom_ville, p_code_postal)
        RETURNING id_ville INTO v_id_ville;
    END IF;

    SELECT id_adresse INTO v_id_adresse FROM tripenazor.adresse
    WHERE voie = p_voie AND
        numero_adresse = p_numero_adresse AND
        complement_adresse = p_complement_adresse AND
        id_ville = v_id_ville;

    IF v_id_adresse IS NULL THEN
        -- Insère l'adresse
        INSERT INTO tripenazor.adresse(voie, numero_adresse, complement_adresse, id_ville)
        VALUES (p_voie, p_numero_adresse, p_complement_adresse, v_id_ville)
        RETURNING id_adresse INTO v_id_adresse;
    END IF;

    -- Insère image
    INSERT INTO tripenazor.image (titre_image, chemin)
    VALUES (p_titre_image, p_chemin_image)
    RETURNING id_image INTO v_id_image;
	
    -- Insertion de l'offre
    INSERT INTO tripenazor.offre (
        titre_offre,
        en_ligne,
        resume,
        description,
        accessibilite,
        type_offre,
        prix_TTC_min,
        id_adresse,
        id_image_couverture
    )
    VALUES (
        p_titre_offre,
        p_en_ligne,
        p_resume,
        p_description,
        p_accessibilite,
        p_type_offre::tripenazor.type_activite,
        p_prix_TTC_min,
        v_id_adresse,
        v_id_image
    )
    RETURNING id_offre INTO v_id_offre;

    -- Liaison image et offre
    INSERT INTO tripenazor.image_illustre_offre (id_offre, id_image)
    VALUES (v_id_offre, v_id_image);

    FOR i IN 1 .. array_length(p_titre_image_secondaire, 1) LOOP
        -- Insère chaque image secondaire
        INSERT INTO tripenazor.image (titre_image, chemin)
        VALUES (p_titre_image_secondaire[i], p_chemin_image_secondaire[i])
        RETURNING id_image INTO v_id_image;

        -- Liaison image et offre
        INSERT INTO tripenazor.image_illustre_offre (id_offre, id_image)
        VALUES (v_id_offre, v_id_image);
    END LOOP;

    -- Jour et horaire de l'activité
    FOREACH v_jour IN ARRAY p_jours
    LOOP
        v_id_jour = null;

        SELECT id_jour INTO v_id_jour FROM tripenazor.jour
        WHERE id_jour = v_jour::INT;

        IF v_id_jour IS NOT NULL THEN 
            INSERT INTO tripenazor.jour_ouverture(id_jour, id_offre)
            VALUES (v_id_jour, v_id_offre);
        END IF;
    END LOOP;

    -- Insertion des horaires
    SELECT id_horaire INTO v_id_horaire_matin FROM tripenazor.horaire
    WHERE debut = p_matin_heure_debut::TIME WITH TIME ZONE  AND
    fin = p_matin_heure_fin::TIME WITH TIME ZONE;

    IF v_id_horaire_matin IS NULL THEN
        INSERT INTO tripenazor.horaire(debut, fin)
        VALUES (
            p_matin_heure_debut::TIME WITH TIME ZONE, 
            p_matin_heure_fin::TIME WITH TIME ZONE
        ) RETURNING id_horaire INTO v_id_horaire_matin;

        INSERT INTO tripenazor.horaire_ouverture(id_horaire, id_offre)
        VALUES (v_id_horaire_matin, v_id_offre);
    END IF;

    
    IF p_apres_midi_heure_debut IS NOT NULL AND p_apres_midi_heure_fin IS NOT NULL THEN
        SELECT id_horaire INTO v_id_horaire_apres_midi FROM tripenazor.horaire
        WHERE debut = p_apres_midi_heure_debut::TIME AND
        fin = p_apres_midi_heure_fin::TIME;

        IF v_id_horaire_apres_midi IS NULL THEN
            INSERT INTO tripenazor.horaire(debut, fin)
            VALUES (
                p_apres_midi_heure_debut::TIME, 
                p_apres_midi_heure_fin::TIME
            ) RETURNING id_horaire INTO v_id_horaire_apres_midi;

            INSERT INTO tripenazor.horaire_ouverture(id_horaire, id_offre)
            VALUES (v_id_horaire_apres_midi, v_id_offre);
        END IF;
    END IF;

    -- Insertion du professionnel
    SELECT id_utilisateur INTO v_id_professionnel_prive FROM tripenazor.professionnel_prive
    WHERE id_utilisateur = p_id_professionnel;

    SELECT id_utilisateur INTO v_id_professionnel_public FROM tripenazor.professionnel_public
    WHERE id_utilisateur = p_id_professionnel;

    IF v_id_professionnel_prive IS NOT NULL THEN
        INSERT INTO tripenazor.abonnement (id_offre, id_utilisateur_prive, prix)
        VALUES (v_id_offre, v_id_professionnel_prive, p_prix_prive);
    ELSIF v_id_professionnel_public IS NOT NULL THEN
        INSERT INTO tripenazor.pro_public_propose_offre (id_offre, id_utilisateur_public)
        VALUES (v_id_offre, v_id_professionnel_public);
    ELSE
        RAISE EXCEPTION 'Le professionnel avec l''ID % n''existe pas dans les tables professionnel_prive ou professionnel_public', p_id_professionnel;
    END IF;

    -- ///////// Partie différente /////////
    -- Insertion dans offre_activite
    INSERT INTO tripenazor.offre_spectacle (id_offre, duree, capacite_accueil)VALUES (v_id_offre, p_duree, p_capacite_accueil);

    -- Insert des tags
    FOREACH v_tag IN ARRAY p_tags
    LOOP
        v_id_tag_commun = null;
        v_id_tag = null;

        SELECT id_tag FROM tripenazor.tag
        WHERE libelle_tag = v_tag
        INTO v_id_tag;

        IF v_id_tag IS NOT NULL THEN
            SELECT id_tag FROM tripenazor.tag_commun
            WHERE id_tag = v_id_tag
            INTO v_id_tag_commun;

            IF v_id_tag_commun IS NOT NULL THEN
                INSERT INTO tripenazor.offre_spectacle_possede_tag(id_offre, id_tag)
                VALUES (v_id_offre, v_id_tag);
            END IF;
        END IF;
    END LOOP;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION tripenazor.inserer_offre_visite_guidee(
    -- Paramètres de l'offre
    p_nom_ville TEXT,
    p_code_postal TEXT,

    p_titre_offre TEXT,
	p_en_ligne BOOLEAN,
    p_resume TEXT,
    p_description TEXT,
    p_accessibilite TEXT,
    p_type_offre tripenazor.type_activite,
    p_prix_TTC_min FLOAT,
    p_tags TEXT[],

    -- Adresse
    p_voie TEXT,
    p_numero_adresse INT,
    p_complement_adresse TEXT,
    -- Image
    p_titre_image TEXT,
    p_chemin_image TEXT,
    p_titre_image_secondaire TEXT[],
    p_chemin_image_secondaire TEXT[],

    -- Jour de l'activité
    p_jours NUMERIC[],
    p_matin_heure_debut TIME,
    p_matin_heure_fin TIME,

    -- Professionnel
    p_id_professionnel INT,

    -- Paramètres spécifiques à l'activité
    p_duree TIME,
    p_langues TEXT[],

    p_apres_midi_heure_debut TIME DEFAULT NULL,
    p_apres_midi_heure_fin TIME DEFAULT NULL,
    p_prix_prive INT DEFAULT NULL
)
RETURNS VOID AS $$
DECLARE
    v_id_offre INT;
    v_id_image INT;
    v_id_horaire_matin INT;
    v_id_horaire_apres_midi INT;
    v_id_adresse INT;
    v_id_ville INT;
	v_id_jour INT;
    v_id_professionnel_prive INT;
    v_id_professionnel_public INT;
    v_id_tag INT;
    v_id_tag_commun INT;
    v_id_langue INT;
	v_jour INT;
    v_tag TEXT;
    v_langue TEXT;
BEGIN
    SELECT id_ville INTO v_id_ville FROM tripenazor.ville 
    WHERE nom_ville = p_nom_ville AND code_postal = p_code_postal;

    IF v_id_ville IS NULL THEN
        -- Insère la ville
        INSERT INTO tripenazor.ville(nom_ville, code_postal)
        VALUES (p_nom_ville, p_code_postal)
        RETURNING id_ville INTO v_id_ville;
    END IF;

    SELECT id_adresse INTO v_id_adresse FROM tripenazor.adresse
    WHERE voie = p_voie AND
        numero_adresse = p_numero_adresse AND
        complement_adresse = p_complement_adresse AND
        id_ville = v_id_ville;

    IF v_id_adresse IS NULL THEN
        -- Insère l'adresse
        INSERT INTO tripenazor.adresse(voie, numero_adresse, complement_adresse, id_ville)
        VALUES (p_voie, p_numero_adresse, p_complement_adresse, v_id_ville)
        RETURNING id_adresse INTO v_id_adresse;
    END IF;

    -- Insère image
    INSERT INTO tripenazor.image (titre_image, chemin)
    VALUES (p_titre_image, p_chemin_image)
    RETURNING id_image INTO v_id_image;
	
    -- Insertion de l'offre
    INSERT INTO tripenazor.offre (
        titre_offre,
        en_ligne,
        resume,
        description,
        accessibilite,
        type_offre,
        prix_TTC_min,
        id_adresse,
        id_image_couverture
    )
    VALUES (
        p_titre_offre,
        p_en_ligne,
        p_resume,
        p_description,
        p_accessibilite,
        p_type_offre::tripenazor.type_activite,
        p_prix_TTC_min,
        v_id_adresse,
        v_id_image
    )
    RETURNING id_offre INTO v_id_offre;

    -- Liaison image et offre
    INSERT INTO tripenazor.image_illustre_offre (id_offre, id_image)
    VALUES (v_id_offre, v_id_image);

    FOR i IN 1 .. array_length(p_titre_image_secondaire, 1) LOOP
        -- Insère chaque image secondaire
        INSERT INTO tripenazor.image (titre_image, chemin)
        VALUES (p_titre_image_secondaire[i], p_chemin_image_secondaire[i])
        RETURNING id_image INTO v_id_image;

        -- Liaison image et offre
        INSERT INTO tripenazor.image_illustre_offre (id_offre, id_image)
        VALUES (v_id_offre, v_id_image);
    END LOOP;

    -- Jour et horaire de l'activité
    FOREACH v_jour IN ARRAY p_jours
    LOOP
        v_id_jour = null;

        SELECT id_jour INTO v_id_jour FROM tripenazor.jour
        WHERE id_jour = v_jour::INT;

        IF v_id_jour IS NOT NULL THEN 
            INSERT INTO tripenazor.jour_ouverture(id_jour, id_offre)
            VALUES (v_id_jour, v_id_offre);
        END IF;
    END LOOP;

    -- Insertion des horaires
    SELECT id_horaire INTO v_id_horaire_matin FROM tripenazor.horaire
    WHERE debut = p_matin_heure_debut::TIME WITH TIME ZONE  AND
    fin = p_matin_heure_fin::TIME WITH TIME ZONE;

    IF v_id_horaire_matin IS NULL THEN
        INSERT INTO tripenazor.horaire(debut, fin)
        VALUES (
            p_matin_heure_debut::TIME WITH TIME ZONE, 
            p_matin_heure_fin::TIME WITH TIME ZONE
        ) RETURNING id_horaire INTO v_id_horaire_matin;

        INSERT INTO tripenazor.horaire_ouverture(id_horaire, id_offre)
        VALUES (v_id_horaire_matin, v_id_offre);
    END IF;

    
    IF p_apres_midi_heure_debut IS NOT NULL AND p_apres_midi_heure_fin IS NOT NULL THEN
        SELECT id_horaire INTO v_id_horaire_apres_midi FROM tripenazor.horaire
        WHERE debut = p_apres_midi_heure_debut::TIME AND
        fin = p_apres_midi_heure_fin::TIME;

        IF v_id_horaire_apres_midi IS NULL THEN
            INSERT INTO tripenazor.horaire(debut, fin)
            VALUES (
                p_apres_midi_heure_debut::TIME, 
                p_apres_midi_heure_fin::TIME
            ) RETURNING id_horaire INTO v_id_horaire_apres_midi;

            INSERT INTO tripenazor.horaire_ouverture(id_horaire, id_offre)
            VALUES (v_id_horaire_apres_midi, v_id_offre);
        END IF;
    END IF;

    -- Insertion du professionnel
    SELECT id_utilisateur INTO v_id_professionnel_prive FROM tripenazor.professionnel_prive
    WHERE id_utilisateur = p_id_professionnel;

    SELECT id_utilisateur INTO v_id_professionnel_public FROM tripenazor.professionnel_public
    WHERE id_utilisateur = p_id_professionnel;

    IF v_id_professionnel_prive IS NOT NULL THEN
        INSERT INTO tripenazor.abonnement (id_offre, id_utilisateur_prive, prix)
        VALUES (v_id_offre, v_id_professionnel_prive, p_prix_prive);
    ELSIF v_id_professionnel_public IS NOT NULL THEN
        INSERT INTO tripenazor.pro_public_propose_offre (id_offre, id_utilisateur_public)
        VALUES (v_id_offre, v_id_professionnel_public);
    ELSE
        RAISE EXCEPTION 'Le professionnel avec l''ID % n''existe pas dans les tables professionnel_prive ou professionnel_public', p_id_professionnel;
    END IF;

    -- ///////// Partie différente /////////
    -- Insertion dans offre_visite
    INSERT INTO tripenazor.offre_visite (id_offre, duree)VALUES (v_id_offre, p_duree);

    -- Insertion dans visite_guidee
    INSERT INTO tripenazor.visite_guidee (id_offre)VALUES (v_id_offre);

    -- Les langues
    FOREACH v_langue IN ARRAY p_langues
    LOOP
        v_id_langue = null;
        SELECT id_langue FROM tripenazor.langue l
        WHERE l.libelle_langue = v_langue
        INTO v_id_langue;

        IF v_id_langue IS NULL THEN 
            INSERT INTO tripenazor.langue (libelle_langue) VALUES (v_langue)
			RETURNING id_langue INTO v_id_langue;
        END IF;
        
        INSERT INTO tripenazor.visite_guidee_disponible_en_langue (id_visite, id_langue)VALUES ( v_id_offre, v_id_langue);
    END LOOP;

    -- Insert des tags
    FOREACH v_tag IN ARRAY p_tags
    LOOP
        v_id_tag_commun = null;
        v_id_tag = null;

        SELECT id_tag FROM tripenazor.tag
        WHERE libelle_tag = v_tag
        INTO v_id_tag;

        IF v_id_tag IS NOT NULL THEN
            SELECT id_tag FROM tripenazor.tag_commun
            WHERE id_tag = v_id_tag
            INTO v_id_tag_commun;

            IF v_id_tag_commun IS NOT NULL THEN
                INSERT INTO tripenazor.offre_visite_possede_tag(id_offre, id_tag)
                VALUES (v_id_offre, v_id_tag);
            END IF;
        END IF;
    END LOOP;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION tripenazor.inserer_offre_visite_non_guidee(
    -- Paramètres de l'offre
    p_nom_ville TEXT,
    p_code_postal TEXT,

    p_titre_offre TEXT,
	p_en_ligne BOOLEAN,
    p_resume TEXT,
    p_description TEXT,
    p_accessibilite TEXT,
    p_type_offre tripenazor.type_activite,
    p_prix_TTC_min FLOAT,
    p_tags TEXT[],

    -- Adresse
    p_voie TEXT,
    p_numero_adresse INT,
    p_complement_adresse TEXT,
    -- Image
    p_titre_image TEXT,
    p_chemin_image TEXT,
    p_titre_image_secondaire TEXT[],
    p_chemin_image_secondaire TEXT[],

    -- Jour de l'activité
    p_jours NUMERIC[],
    p_matin_heure_debut TIME,
    p_matin_heure_fin TIME,

    -- Professionnel
    p_id_professionnel INT,

    -- Paramètres spécifiques à l'activité
    p_duree TIME,

    p_apres_midi_heure_debut TIME DEFAULT NULL,
    p_apres_midi_heure_fin TIME DEFAULT NULL,
    p_prix_prive INT DEFAULT NULL
)
RETURNS VOID AS $$
DECLARE
    v_id_offre INT;
    v_id_image INT;
    v_id_horaire_matin INT;
    v_id_horaire_apres_midi INT;
    v_id_adresse INT;
    v_id_ville INT;
	v_id_jour INT;
    v_id_professionnel_prive INT;
    v_id_professionnel_public INT;
    v_id_tag INT;
    v_id_tag_commun INT;
	v_jour INT;
    v_tag TEXT;
BEGIN
    SELECT id_ville INTO v_id_ville FROM tripenazor.ville 
    WHERE nom_ville = p_nom_ville AND code_postal = p_code_postal;

    IF v_id_ville IS NULL THEN
        -- Insère la ville
        INSERT INTO tripenazor.ville(nom_ville, code_postal)
        VALUES (p_nom_ville, p_code_postal)
        RETURNING id_ville INTO v_id_ville;
    END IF;

    SELECT id_adresse INTO v_id_adresse FROM tripenazor.adresse
    WHERE voie = p_voie AND
        numero_adresse = p_numero_adresse AND
        complement_adresse = p_complement_adresse AND
        id_ville = v_id_ville;

    IF v_id_adresse IS NULL THEN
        -- Insère l'adresse
        INSERT INTO tripenazor.adresse(voie, numero_adresse, complement_adresse, id_ville)
        VALUES (p_voie, p_numero_adresse, p_complement_adresse, v_id_ville)
        RETURNING id_adresse INTO v_id_adresse;
    END IF;

    -- Insère image
    INSERT INTO tripenazor.image (titre_image, chemin)
    VALUES (p_titre_image, p_chemin_image)
    RETURNING id_image INTO v_id_image;
	
    -- Insertion de l'offre
    INSERT INTO tripenazor.offre (
        titre_offre,
        en_ligne,
        resume,
        description,
        accessibilite,
        type_offre,
        prix_TTC_min,
        id_adresse,
        id_image_couverture
    )
    VALUES (
        p_titre_offre,
        p_en_ligne,
        p_resume,
        p_description,
        p_accessibilite,
        p_type_offre::tripenazor.type_activite,
        p_prix_TTC_min,
        v_id_adresse,
        v_id_image
    )
    RETURNING id_offre INTO v_id_offre;

    -- Liaison image et offre
    INSERT INTO tripenazor.image_illustre_offre (id_offre, id_image)
    VALUES (v_id_offre, v_id_image);

    FOR i IN 1 .. array_length(p_titre_image_secondaire, 1) LOOP
        -- Insère chaque image secondaire
        INSERT INTO tripenazor.image (titre_image, chemin)
        VALUES (p_titre_image_secondaire[i], p_chemin_image_secondaire[i])
        RETURNING id_image INTO v_id_image;

        -- Liaison image et offre
        INSERT INTO tripenazor.image_illustre_offre (id_offre, id_image)
        VALUES (v_id_offre, v_id_image);
    END LOOP;

    -- Jour et horaire de l'activité
    FOREACH v_jour IN ARRAY p_jours
    LOOP
        v_id_jour = null;

        SELECT id_jour INTO v_id_jour FROM tripenazor.jour
        WHERE id_jour = v_jour::INT;

        IF v_id_jour IS NOT NULL THEN 
            INSERT INTO tripenazor.jour_ouverture(id_jour, id_offre)
            VALUES (v_id_jour, v_id_offre);
        END IF;
    END LOOP;

    -- Insertion des horaires
    SELECT id_horaire INTO v_id_horaire_matin FROM tripenazor.horaire
    WHERE debut = p_matin_heure_debut::TIME WITH TIME ZONE  AND
    fin = p_matin_heure_fin::TIME WITH TIME ZONE;

    IF v_id_horaire_matin IS NULL THEN
        INSERT INTO tripenazor.horaire(debut, fin)
        VALUES (
            p_matin_heure_debut::TIME WITH TIME ZONE, 
            p_matin_heure_fin::TIME WITH TIME ZONE
        ) RETURNING id_horaire INTO v_id_horaire_matin;

        INSERT INTO tripenazor.horaire_ouverture(id_horaire, id_offre)
        VALUES (v_id_horaire_matin, v_id_offre);
    END IF;

    
    IF p_apres_midi_heure_debut IS NOT NULL AND p_apres_midi_heure_fin IS NOT NULL THEN
        SELECT id_horaire INTO v_id_horaire_apres_midi FROM tripenazor.horaire
        WHERE debut = p_apres_midi_heure_debut::TIME AND
        fin = p_apres_midi_heure_fin::TIME;

        IF v_id_horaire_apres_midi IS NULL THEN
            INSERT INTO tripenazor.horaire(debut, fin)
            VALUES (
                p_apres_midi_heure_debut::TIME, 
                p_apres_midi_heure_fin::TIME
            ) RETURNING id_horaire INTO v_id_horaire_apres_midi;

            INSERT INTO tripenazor.horaire_ouverture(id_horaire, id_offre)
            VALUES (v_id_horaire_apres_midi, v_id_offre);
        END IF;
    END IF;

    -- Insertion du professionnel
    SELECT id_utilisateur INTO v_id_professionnel_prive FROM tripenazor.professionnel_prive
    WHERE id_utilisateur = p_id_professionnel;

    SELECT id_utilisateur INTO v_id_professionnel_public FROM tripenazor.professionnel_public
    WHERE id_utilisateur = p_id_professionnel;

    IF v_id_professionnel_prive IS NOT NULL THEN
        INSERT INTO tripenazor.abonnement (id_offre, id_utilisateur_prive, prix)
        VALUES (v_id_offre, v_id_professionnel_prive, p_prix_prive);
    ELSIF v_id_professionnel_public IS NOT NULL THEN
        INSERT INTO tripenazor.pro_public_propose_offre (id_offre, id_utilisateur_public)
        VALUES (v_id_offre, v_id_professionnel_public);
    ELSE
        RAISE EXCEPTION 'Le professionnel avec l''ID % n''existe pas dans les tables professionnel_prive ou professionnel_public', p_id_professionnel;
    END IF;

    -- ///////// Partie différente /////////
        -- Insertion dans offre_visite
    INSERT INTO tripenazor.offre_visite (id_offre, duree)VALUES (v_id_offre, p_duree);

    -- Insertion dans visite_guidee
    INSERT INTO tripenazor.visite_guidee (id_offre)VALUES (v_id_offre);

    -- Insert des tags
    FOREACH v_tag IN ARRAY p_tags
    LOOP
        v_id_tag_commun = null;
        v_id_tag = null;

        SELECT id_tag FROM tripenazor.tag
        WHERE libelle_tag = v_tag
        INTO v_id_tag;

        IF v_id_tag IS NOT NULL THEN
            SELECT id_tag FROM tripenazor.tag_commun
            WHERE id_tag = v_id_tag
            INTO v_id_tag_commun;

            IF v_id_tag_commun IS NOT NULL THEN
                INSERT INTO tripenazor.offre_visite_possede_tag(id_offre, id_tag)
                VALUES (v_id_offre, v_id_tag);
            END IF;
        END IF;
    END LOOP;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE VIEW v_avis AS
SELECT 
    a.id_avis,
    a.id_utilisateur,
    a.id_offre,
    a.description_avis,
    a.note_avis,
    a.titre_avis,
    a.date_avis,
    (
        SELECT COUNT(*) 
        FROM tripenazor.membre_aime_avis maa 
        WHERE maa.id_avis = a.id_avis
    ) AS nb_aime,

    r.id_avis AS id_avis_reponse,
    r.description_rep,

    i.id_image,
    i.titre_image,
    i.chemin
FROM tripenazor.avis a
LEFT JOIN tripenazor.reponse_pro r ON a.id_avis = r.id_avis
LEFT JOIN tripenazor.membre m ON a.id_utilisateur = m.id_utilisateur
LEFT JOIN tripenazor.avis_possede_image api ON a.id_avis = api.id_avis
LEFT JOIN tripenazor.image i ON api.id_image = i.id_image;

CREATE OR REPLACE FUNCTION tripenazor.update_offre_activite(
    p_id_offre INT,
    
    -- Paramètres de l'offre
    p_nom_ville TEXT,
    p_code_postal TEXT,

    p_titre_offre TEXT,
	p_en_ligne BOOLEAN,
    p_resume TEXT,
    p_description TEXT,
    p_accessibilite TEXT,
    p_type_offre tripenazor.type_activite,
    p_prix_TTC_min FLOAT,
    p_tags TEXT[],

    -- Adresse
    p_voie TEXT,
    p_numero_adresse INT,
    p_complement_adresse TEXT,
    
    -- Image
    p_titre_image TEXT,
    p_chemin_image TEXT,

    -- Jour de l'activité
    p_jours NUMERIC[],
    p_matin_heure_debut TIME,
    p_matin_heure_fin TIME,

    -- Professionnel
    p_id_professionnel INT,

    -- Paramètres spécifiques à l'activité
    p_prestations_incluses TEXT[],
    p_prestations_non_incluses TEXT[],
    p_duree TIME,
    p_age INT,
	
    p_apres_midi_heure_debut TIME DEFAULT NULL,
    p_apres_midi_heure_fin TIME DEFAULT NULL,
	p_prix_prive FLOAT DEFAULT NULL
)
RETURNS VOID AS $$
DECLARE
    v_id_offre INT;
    v_id_image INT;
    v_id_horaire_matin INT;
    v_id_horaire_apres_midi INT;
    v_id_adresse INT;
    v_id_ville INT;
	v_id_jour INT;
    v_id_professionnel_prive INT;
    v_id_professionnel_public INT;
    v_id_tag INT;
    v_id_tag_commun INT;
	v_id_prestation_incluse INT;
	v_id_prestation_non_incluse INT;
	v_jour TEXT;
    v_tag TEXT;
	v_prestation_incluse TEXT;
	v_prestation_non_incluse TEXT;
    v_offre_activite_existante INT;
BEGIN
    SELECT id_ville INTO v_id_ville FROM tripenazor.ville
    WHERE nom_ville = p_nom_ville AND
        code_postal = p_code_postal;

    IF v_id_ville IS NULL THEN
        -- Insère la ville
        INSERT INTO tripenazor.ville(nom_ville, code_postal)
        VALUES (
            p_nom_ville,
            p_code_postal
        )
        RETURNING id_ville INTO v_id_ville;
    END IF;

    SELECT id_adresse INTO v_id_adresse FROM tripenazor.adresse 
    WHERE voie = p_voie AND
        numero_adresse = p_numero_adresse AND
        complement_adresse = p_complement_adresse AND
        id_ville = v_id_ville;

    IF v_id_adresse IS NULL THEN
        INSERT INTO tripenazor.adresse(voie, numero_adresse, complement_adresse, id_ville)
        VALUES (
            p_voie, 
            p_numero_adresse, 
            p_complement_adresse, 
            v_id_ville
        )
        RETURNING id_adresse INTO v_id_adresse;
    ELSE 
        -- Update dans adresse
        UPDATE tripenazor.adresse
        SET voie = p_voie, 
            numero_adresse = p_numero_adresse, 
            complement_adresse = p_complement_adresse, 
            id_ville = v_id_ville
        WHERE id_adresse = v_id_adresse;
    END IF;

    -- Update image
    SELECT id_image INTO v_id_image FROM tripenazor.image 
    WHERE titre_image = p_titre_image AND 
        chemin = p_chemin_image;

    IF v_id_image IS NULL THEN
        INSERT INTO tripenazor.image (titre_image, chemin)
        VALUES (p_titre_image, p_chemin_image)
        RETURNING id_image INTO v_id_image;

        INSERT INTO tripenazor.image_illustre_offre (id_offre, id_image)
        VALUES (p_id_offre, v_id_image);
    ELSE
        UPDATE tripenazor.image
        SET titre_image = p_titre_image,
            chemin = p_chemin_image
        WHERE id_image = v_id_image;
    END IF;

    -- Update de l'offre
    SELECT id_offre FROM tripenazor.offre INTO v_id_offre
    WHERE id_offre = p_id_offre;

    IF v_id_offre IS NOT NULL THEN
        UPDATE tripenazor.offre
        SET titre_offre = p_titre_offre,
            en_ligne = p_en_ligne,
            resume = p_resume,
            description = p_description,
            accessibilite = p_accessibilite,
            type_offre = p_type_offre,
            prix_TTC_min = p_prix_TTC_min,
            id_adresse = v_id_adresse,
            id_image_couverture = v_id_image
        WHERE id_offre = v_id_offre;
    ELSE 
        RAISE EXCEPTION 'L''offre n''existe pas';
    END IF;

    -- Jour et horaire de l'activité
    FOREACH v_jour IN ARRAY p_jours
    LOOP
        v_id_jour := NULL;

        -- Récupère l'ID du jour correspondant au libellé
        SELECT id_jour INTO v_id_jour
        FROM tripenazor.jour
        WHERE libelle = v_jour;

        IF v_id_jour IS NOT NULL THEN
            -- Vérifie si l'association existe déjà
            IF EXISTS (
                SELECT 1 FROM tripenazor.jour_ouverture
                WHERE id_offre = v_id_offre
            ) THEN
                -- Mise à jour de l'ID du jour pour l'offre
                UPDATE tripenazor.jour_ouverture
                SET id_jour = v_id_jour
                WHERE id_offre = v_id_offre;
            ELSE
                -- Sinon, insertion de la nouvelle association
                INSERT INTO tripenazor.jour_ouverture(id_jour, id_offre)
                VALUES (v_id_jour, v_id_offre);
            END IF;
        END IF;
    END LOOP;

    -- Insertion des horaires
    SELECT id_horaire INTO v_id_horaire_matin FROM tripenazor.horaire 
    WHERE debut = p_matin_heure_debut AND fin = p_matin_heure_fin;

    IF v_id_horaire_matin IS NULL THEN
        INSERT INTO tripenazor.horaire(debut, fin)
        VALUES (
            p_matin_heure_debut, 
            p_matin_heure_fin
        ) RETURNING id_horaire INTO v_id_horaire_matin;

        INSERT INTO tripenazor.horaire_ouverture(id_horaire, id_offre)
        VALUES (v_id_horaire_matin, v_id_offre);
    ELSE
        UPDATE tripenazor.horaire
        SET debut = p_matin_heure_debut,
            fin = p_matin_heure_fin
        WHERE id_horaire = v_id_horaire_matin;
    END IF;

    IF p_apres_midi_heure_debut IS NOT NULL AND p_apres_midi_heure_fin IS NOT NULL THEN
        SELECT id_horaire INTO v_id_horaire_apres_midi FROM tripenazor.horaire 
        WHERE debut = p_apres_midi_heure_debut AND
        fin = p_apres_midi_heure_fin;

        IF v_id_horaire_apres_midi IS NULL THEN
            INSERT INTO tripenazor.horaire(debut, fin)
            VALUES (
                p_apres_midi_heure_debut, 
                p_apres_midi_heure_fin
            ) RETURNING id_horaire INTO v_id_horaire_apres_midi;

            INSERT INTO tripenazor.horaire_ouverture(id_horaire, id_offre)
            VALUES (v_id_horaire_apres_midi, v_id_offre);
        ELSE
            UPDATE tripenazor.horaire
            SET debut = p_apres_midi_heure_debut,
                fin = p_apres_midi_heure_fin
            WHERE id_horaire = v_id_horaire_apres_midi;
        END IF;
    END IF;

    -- Insertion du professionnel
    SELECT id_utilisateur INTO v_id_professionnel_prive 
    FROM tripenazor.professionnel_prive
    WHERE id_utilisateur = p_id_professionnel;

    SELECT id_utilisateur INTO v_id_professionnel_public 
    FROM tripenazor.professionnel_public
    WHERE id_utilisateur = p_id_professionnel;

    IF v_id_professionnel_prive IS NOT NULL THEN
        IF EXISTS (
            SELECT 1
            FROM tripenazor.abonnement
            WHERE id_offre = v_id_offre
            AND id_utilisateur_prive = v_id_professionnel_prive
        ) THEN
            UPDATE tripenazor.abonnement
            SET prix = p_prix_prive,
                id_utilisateur_prive = v_id_professionnel_prive
            WHERE id_offre = v_id_offre
            AND id_utilisateur_prive = v_id_professionnel_prive;
        ELSE
            INSERT INTO tripenazor.abonnement (id_offre, id_utilisateur_prive, prix)
            VALUES (v_id_offre, v_id_professionnel_prive, p_prix_prive);
        END IF;
    ELSIF v_id_professionnel_public IS NOT NULL THEN
        IF EXISTS (
            SELECT 1
            FROM tripenazor.pro_public_propose_offre
            WHERE id_offre = v_id_offre
            AND id_utilisateur_public = v_id_professionnel_public
        ) THEN
            UPDATE tripenazor.pro_public_propose_offre
            SET id_utilisateur_public = v_id_professionnel_public
            WHERE id_offre = v_id_offre
            AND id_utilisateur_public = v_id_professionnel_public;
        ELSE
            INSERT INTO tripenazor.pro_public_propose_offre (id_offre, id_utilisateur_public)
            VALUES (v_id_offre, v_id_professionnel_public);
        END IF;
    ELSE
        RAISE EXCEPTION 'Le professionnel avec l''ID % n''existe pas dans les tables professionnel_prive ou professionnel_public', p_id_professionnel;
    END IF;

    -- ///////// Partie différente /////////
    -- Update dans offre_activite
    SELECT id_offre INTO v_offre_activite_existante 
    FROM tripenazor.offre_activite
    WHERE id_offre = p_id_offre;
    
    IF v_offre_activite_existante IS NULL THEN
        INSERT INTO tripenazor.offre_activite (id_offre, duree, age)
        VALUES (v_id_offre, p_duree, p_age)
        RETURNING id_offre INTO v_offre_activite_existante;
    ELSE 
        UPDATE tripenazor.offre_activite
        SET duree = p_duree,
            age = p_age
        WHERE id_offre = v_offre_activite_existante;
    END IF;

    -- Update des tags
        FOREACH v_tag IN ARRAY p_tags
    LOOP
        v_id_tag := NULL;
        v_id_tag_commun := NULL;

        -- Chercher le tag dans la table "tag"
        SELECT id_tag INTO v_id_tag
        FROM tripenazor.tag
        WHERE libelle_tag = v_tag;

        -- Si le tag n'existe pas, on l'insère, puis on le marque comme commun
        IF v_id_tag IS NULL THEN
            INSERT INTO tripenazor.tag (libelle_tag)
            VALUES (v_tag)
            RETURNING id_tag INTO v_id_tag;

            INSERT INTO tripenazor.tag_commun (id_tag)
            VALUES (v_id_tag);
        END IF;

        -- Vérifie que ce tag est bien commun
        SELECT id_tag INTO v_id_tag_commun
        FROM tripenazor.tag_commun
        WHERE id_tag = v_id_tag;

        -- Si c'est bien un tag commun, lier à l'offre si pas déjà lié
        IF v_id_tag_commun IS NOT NULL THEN
            IF NOT EXISTS (
                SELECT 1 FROM tripenazor.offre_activite_possede_tag
                WHERE id_offre = v_id_offre AND id_tag = v_id_tag
            ) THEN
                INSERT INTO tripenazor.offre_activite_possede_tag (id_offre, id_tag)
                VALUES (v_id_offre, v_id_tag);
            END IF;
        END IF;
    END LOOP;

    -- Prestation incluses
    FOREACH v_prestation_incluse IN ARRAY p_prestations_incluses
    LOOP
        v_id_prestation_incluse = NULL;

        SELECT id_prestation INTO v_id_prestation_incluse FROM tripenazor.prestation
        WHERE libelle_prestation = v_prestation_incluse;

        IF v_id_prestation_incluse IS NULL THEN
            INSERT INTO tripenazor.prestation (libelle_prestation)
            VALUES (v_prestation_incluse)
            RETURNING id_prestation INTO v_id_prestation_incluse;

            INSERT INTO tripenazor.activite_inclus_prestation (id_offre, id_prestation)
            VALUES (v_id_offre, v_id_prestation_incluse);
        ELSE 
            UPDATE tripenazor.prestation
            SET libelle_prestation = v_prestation_incluse
            WHERE id_prestation = v_id_prestation_incluse;

            UPDATE tripenazor.activite_inclus_prestation
            SET id_offre = p_id_offre, id_prestation = v_id_prestation_incluse
            WHERE id_offre = v_id_offre AND id_prestation = v_id_prestation_incluse;
        END IF;
    END LOOP;

    -- Prestation non incluses
    FOREACH v_prestation_non_incluse IN ARRAY p_prestations_non_incluses
    LOOP
        v_id_prestation_non_incluse = NULL;

        SELECT id_prestation INTO v_id_prestation_non_incluse FROM tripenazor.prestation
        WHERE libelle_prestation = v_prestation_non_incluse;

        IF v_id_prestation_non_incluse IS NULL THEN
            INSERT INTO tripenazor.prestation (libelle_prestation)
            VALUES (v_prestation_non_incluse)
            RETURNING id_prestation INTO v_id_prestation_non_incluse;

            INSERT INTO tripenazor.activite_non_inclus_prestation (id_offre, id_prestation)
            VALUES (v_id_offre, v_id_prestation_non_incluse);
        ELSE 
            UPDATE tripenazor.prestation
            SET libelle_prestation = v_prestation_non_incluse
            WHERE id_prestation = v_id_prestation_non_incluse;

            UPDATE tripenazor.activite_non_inclus_prestation
            SET id_offre = p_id_offre, id_prestation = v_id_prestation_non_incluse
            WHERE id_offre = v_id_offre AND id_prestation = v_id_prestation_non_incluse;
        END IF;
    END LOOP;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION tripenazor.update_offre_parc_attraction(
    p_id_offre INT,
    
    -- Paramètres de l'offre
    p_nom_ville TEXT,
    p_code_postal TEXT,

    p_titre_offre TEXT,
	p_en_ligne BOOLEAN,
    p_resume TEXT,
    p_description TEXT,
    p_accessibilite TEXT,
    p_type_offre tripenazor.type_activite,
    p_prix_TTC_min FLOAT,
    p_tags TEXT[],

    -- Adresse
    p_voie TEXT,
    p_numero_adresse INT,
    p_complement_adresse TEXT,
    
    -- Image
    p_titre_image TEXT,
    p_chemin_image TEXT,

    -- Jour de l'activité
    p_jours NUMERIC[],
    p_matin_heure_debut TIME,
    p_matin_heure_fin TIME,

    -- Professionnel
    p_id_professionnel INT,

    -- Paramètres spécifiques à l'activité
    p_nb_attractions INT,
    p_age_min INT,
    p_titre_image_parc TEXT,
    p_chemin_image_parc TEXT,

    p_apres_midi_heure_debut TIME DEFAULT NULL,
    p_apres_midi_heure_fin TIME DEFAULT NULL,
    p_prix_prive INT DEFAULT NULL
)
RETURNS VOID AS $$
DECLARE
    v_id_offre INT;
    v_id_image INT;
    v_id_horaire_matin INT;
    v_id_horaire_apres_midi INT;
    v_id_adresse INT;
    v_id_ville INT;
	v_id_jour INT;
    v_id_professionnel_prive INT;
    v_id_professionnel_public INT;
    v_id_tag INT;
    v_id_tag_commun INT;
	v_id_prestation_incluse INT;
	v_id_prestation_non_incluse INT;
	v_jour TEXT;
    v_tag TEXT;
    v_offre_parc_attraction_existante INT;

    v_id_image_parc INT;
BEGIN
    SELECT id_ville INTO v_id_ville FROM tripenazor.ville
    WHERE nom_ville = p_nom_ville AND
        code_postal = p_code_postal;

    IF v_id_ville IS NULL THEN
        -- Insère la ville
        INSERT INTO tripenazor.ville(nom_ville, code_postal)
        VALUES (
            p_nom_ville,
            p_code_postal
        )
        RETURNING id_ville INTO v_id_ville;
    END IF;

    SELECT id_adresse INTO v_id_adresse FROM tripenazor.adresse 
    WHERE voie = p_voie AND
        numero_adresse = p_numero_adresse AND
        complement_adresse = p_complement_adresse AND
        id_ville = v_id_ville;

    IF v_id_adresse IS NULL THEN
        INSERT INTO tripenazor.adresse(voie, numero_adresse, complement_adresse, id_ville)
        VALUES (
            p_voie, 
            p_numero_adresse, 
            p_complement_adresse, 
            v_id_ville
        )
        RETURNING id_adresse INTO v_id_adresse;
    ELSE 
        -- Update dans adresse
        UPDATE tripenazor.adresse
        SET voie = p_voie, 
            numero_adresse = p_numero_adresse, 
            complement_adresse = p_complement_adresse, 
            id_ville = v_id_ville
        WHERE id_adresse = v_id_adresse;
    END IF;

    -- Update image
    SELECT id_image INTO v_id_image FROM tripenazor.image 
    WHERE titre_image = p_titre_image AND 
        chemin = p_chemin_image;

    IF v_id_image IS NULL THEN
        INSERT INTO tripenazor.image (titre_image, chemin)
        VALUES (p_titre_image, p_chemin_image)
        RETURNING id_image INTO v_id_image;

        INSERT INTO tripenazor.image_illustre_offre (id_offre, id_image)
        VALUES (p_id_offre, v_id_image);
    ELSE
        UPDATE tripenazor.image
        SET titre_image = p_titre_image,
            chemin = p_chemin_image
        WHERE id_image = v_id_image;
    END IF;

    -- Update de l'offre
    SELECT id_offre FROM tripenazor.offre INTO v_id_offre
    WHERE id_offre = p_id_offre;

    IF v_id_offre IS NOT NULL THEN
        UPDATE tripenazor.offre
        SET titre_offre = p_titre_offre,
            en_ligne = p_en_ligne,
            resume = p_resume,
            description = p_description,
            accessibilite = p_accessibilite,
            type_offre = p_type_offre,
            prix_TTC_min = p_prix_TTC_min,
            id_adresse = v_id_adresse,
            id_image_couverture = v_id_image
        WHERE id_offre = v_id_offre;
    ELSE 
        RAISE EXCEPTION 'L''offre n''existe pas';
    END IF;

    -- Jour et horaire de l'activité
    FOREACH v_jour IN ARRAY p_jours
    LOOP
        v_id_jour := NULL;

        -- Récupère l'ID du jour correspondant au libellé
        SELECT id_jour INTO v_id_jour
        FROM tripenazor.jour
        WHERE libelle = v_jour;

        IF v_id_jour IS NOT NULL THEN
            -- Vérifie si l'association existe déjà
            IF EXISTS (
                SELECT 1 FROM tripenazor.jour_ouverture
                WHERE id_offre = v_id_offre
            ) THEN
                -- Mise à jour de l'ID du jour pour l'offre
                UPDATE tripenazor.jour_ouverture
                SET id_jour = v_id_jour
                WHERE id_offre = v_id_offre;
            ELSE
                -- Sinon, insertion de la nouvelle association
                INSERT INTO tripenazor.jour_ouverture(id_jour, id_offre)
                VALUES (v_id_jour, v_id_offre);
            END IF;
        END IF;
    END LOOP;

    -- Insertion des horaires
    SELECT id_horaire INTO v_id_horaire_matin FROM tripenazor.horaire 
    WHERE debut = p_matin_heure_debut AND fin = p_matin_heure_fin;

    IF v_id_horaire_matin IS NULL THEN
        INSERT INTO tripenazor.horaire(debut, fin)
        VALUES (
            p_matin_heure_debut, 
            p_matin_heure_fin
        ) RETURNING id_horaire INTO v_id_horaire_matin;

        INSERT INTO tripenazor.horaire_ouverture(id_horaire, id_offre)
        VALUES (v_id_horaire_matin, v_id_offre);
    ELSE
        UPDATE tripenazor.horaire
        SET debut = p_matin_heure_debut,
            fin = p_matin_heure_fin
        WHERE id_horaire = v_id_horaire_matin;
    END IF;

    
    IF p_apres_midi_heure_debut IS NOT NULL AND p_apres_midi_heure_fin IS NOT NULL THEN
        SELECT id_horaire INTO v_id_horaire_apres_midi FROM tripenazor.horaire 
        WHERE debut = p_apres_midi_heure_debut AND
        fin = p_apres_midi_heure_fin;

        IF v_id_horaire_apres_midi IS NULL THEN
            INSERT INTO tripenazor.horaire(debut, fin)
            VALUES (
                p_apres_midi_heure_debut, 
                p_apres_midi_heure_fin
            ) RETURNING id_horaire INTO v_id_horaire_apres_midi;

            INSERT INTO tripenazor.horaire_ouverture(id_horaire, id_offre)
            VALUES (v_id_horaire_apres_midi, v_id_offre);
        ELSE
            UPDATE tripenazor.horaire
            SET debut = p_apres_midi_heure_debut,
                fin = p_apres_midi_heure_fin
            WHERE id_horaire = v_id_horaire_apres_midi;
        END IF;
    END IF;

    -- Insertion du professionnel
    SELECT id_utilisateur INTO v_id_professionnel_prive 
    FROM tripenazor.professionnel_prive
    WHERE id_utilisateur = p_id_professionnel;

    SELECT id_utilisateur INTO v_id_professionnel_public 
    FROM tripenazor.professionnel_public
    WHERE id_utilisateur = p_id_professionnel;

    IF v_id_professionnel_prive IS NOT NULL THEN
        IF EXISTS (
            SELECT 1
            FROM tripenazor.abonnement
            WHERE id_offre = v_id_offre
            AND id_utilisateur_prive = v_id_professionnel_prive
        ) THEN
            UPDATE tripenazor.abonnement
            SET prix = p_prix_prive,
                id_utilisateur_prive = v_id_professionnel_prive
            WHERE id_offre = v_id_offre
            AND id_utilisateur_prive = v_id_professionnel_prive;
        ELSE
            INSERT INTO tripenazor.abonnement (id_offre, id_utilisateur_prive, prix)
            VALUES (v_id_offre, v_id_professionnel_prive, p_prix_prive);
        END IF;
    ELSIF v_id_professionnel_public IS NOT NULL THEN
        IF EXISTS (
            SELECT 1
            FROM tripenazor.pro_public_propose_offre
            WHERE id_offre = v_id_offre
            AND id_utilisateur_public = v_id_professionnel_public
        ) THEN
            UPDATE tripenazor.pro_public_propose_offre
            SET id_utilisateur_public = v_id_professionnel_public
            WHERE id_offre = v_id_offre
            AND id_utilisateur_public = v_id_professionnel_public;
        ELSE
            INSERT INTO tripenazor.pro_public_propose_offre (id_offre, id_utilisateur_public)
            VALUES (v_id_offre, v_id_professionnel_public);
        END IF;
    ELSE
        RAISE EXCEPTION 'Le professionnel avec l''ID % n''existe pas dans les tables professionnel_prive ou professionnel_public', p_id_professionnel;
    END IF;


    -- ///////// Partie différente /////////
    -- Image carte du parc
    SELECT id_image INTO v_id_image_parc FROM tripenazor.image
    WHERE titre_image = p_titre_image_parc AND chemin = p_chemin_image_parc;

    IF v_id_image_parc IS NULL THEN
        INSERT INTO tripenazor.image (titre_image, chemin)
        VALUES (p_titre_image_parc, p_chemin_image_parc)
        RETURNING id_image INTO v_id_image_parc;

        INSERT INTO tripenazor.image_illustre_offre (id_offre, id_image)
        VALUES (v_id_offre, v_id_image_parc);
    ELSE
        UPDATE tripenazor.image
        SET titre_image = p_titre_image_parc,
            chemin = p_chemin_image_parc
        WHERE id_image = v_id_image_parc;
    END IF;

    -- Update dans offre_parc_attraction
    SELECT id_offre INTO v_offre_parc_attraction_existante 
    FROM tripenazor.offre_parc_attraction
    WHERE id_offre = p_id_offre;
    
    IF v_offre_parc_attraction_existante IS NULL THEN
        INSERT INTO tripenazor.offre_parc_attraction (id_offre, id_image, nb_attraction, age_min)
        VALUES (v_id_offre, v_id_image_parc, p_nb_attractions, p_age_min)
        RETURNING id_offre INTO v_offre_parc_attraction_existante;
    ELSE 
        UPDATE tripenazor.offre_parc_attraction
        SET id_image = v_id_image_parc, 
            nb_attraction = p_nb_attractions, 
            age_min = p_age_min
        WHERE id_offre = v_offre_parc_attraction_existante;
    END IF;

    -- Insert des tags
    FOREACH v_tag IN ARRAY p_tags
    LOOP
        v_id_tag_commun = null;
        v_id_tag = null;

        SELECT id_tag FROM tripenazor.tag INTO v_id_tag
        WHERE libelle_tag = v_tag;

        IF v_id_tag IS NOT NULL THEN
            SELECT id_tag FROM tripenazor.tag_commun INTO v_id_tag_commun
            WHERE id_tag = v_id_tag;

            IF v_id_tag_commun IS NOT NULL THEN
                INSERT INTO tripenazor.offre_parc_attraction_possede_tag(id_offre, id_tag)
                VALUES (v_id_offre, v_id_tag);
            ELSE
                UPDATE tripenazor.offre_parc_attraction_possede_tag
                SET id_tag = v_tag
                WHERE id_offre = p_id_offre;
            END IF;
        END IF;
    END LOOP;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION tripenazor.update_offre_restaurant(
    p_id_offre INT,
    
    -- Paramètres de l'offre
    p_nom_ville TEXT,
    p_code_postal TEXT,

    p_titre_offre TEXT,
	p_en_ligne BOOLEAN,
    p_resume TEXT,
    p_description TEXT,
    p_accessibilite TEXT,
    p_type_offre tripenazor.type_activite,
    p_prix_TTC_min FLOAT,
    p_tags TEXT[],

    -- Adresse
    p_voie TEXT,
    p_numero_adresse INT,
    p_complement_adresse TEXT,
    
    -- Image
    p_titre_image TEXT,
    p_chemin_image TEXT,

    -- Jour de l'activité
    p_jours NUMERIC[],
    p_matin_heure_debut TIME,
    p_matin_heure_fin TIME,

    -- Professionnel
    p_id_professionnel INT,

    -- Paramètres spécifiques à l'activité
    p_titre_image_carte TEXT,
    p_chemin_image_carte TEXT,
    p_libelle_gamme_prix TEXT,

    p_apres_midi_heure_debut TIME DEFAULT NULL,
    p_apres_midi_heure_fin TIME DEFAULT NULL,
	p_prix_prive INT DEFAULT NULL
)
RETURNS VOID AS $$
DECLARE
    v_id_offre INT;
    v_id_image INT;
    v_id_horaire_matin INT;
    v_id_horaire_apres_midi INT;
    v_id_adresse INT;
    v_id_ville INT;
	v_id_jour INT;
    v_id_professionnel_prive INT;
    v_id_professionnel_public INT;
    v_id_tag INT;
    v_id_tag_restauration INT;
	v_id_image_carte INT;
	v_id_gamme_prix INT;
	v_jour TEXT;
    v_tag TEXT;
BEGIN
    SELECT id_ville INTO v_id_ville FROM tripenazor.ville
    WHERE nom_ville = p_nom_ville AND
        code_postal = p_code_postal;

    IF v_id_ville IS NULL THEN
        -- Insère la ville
        INSERT INTO tripenazor.ville(nom_ville, code_postal)
        VALUES (
            p_nom_ville,
            p_code_postal
        )
        RETURNING id_ville INTO v_id_ville;
    END IF;

    SELECT id_adresse INTO v_id_adresse FROM tripenazor.adresse 
    WHERE voie = p_voie AND
        numero_adresse = p_numero_adresse AND
        complement_adresse = p_complement_adresse AND
        id_ville = v_id_ville;

    IF v_id_adresse IS NULL THEN
        INSERT INTO tripenazor.adresse(voie, numero_adresse, complement_adresse, id_ville)
        VALUES (
            p_voie, 
            p_numero_adresse, 
            p_complement_adresse, 
            v_id_ville
        )
        RETURNING id_adresse INTO v_id_adresse;
    ELSE 
        -- Update dans adresse
        UPDATE tripenazor.adresse
        SET voie = p_voie, 
            numero_adresse = p_numero_adresse, 
            complement_adresse = p_complement_adresse, 
            id_ville = v_id_ville
        WHERE id_adresse = v_id_adresse;
    END IF;

    -- Update image
    SELECT id_image INTO v_id_image FROM tripenazor.image 
    WHERE titre_image = p_titre_image AND 
        chemin = p_chemin_image;

    IF v_id_image IS NULL THEN
        INSERT INTO tripenazor.image (titre_image, chemin)
        VALUES (p_titre_image, p_chemin_image)
        RETURNING id_image INTO v_id_image;

        INSERT INTO tripenazor.image_illustre_offre (id_offre, id_image)
        VALUES (p_id_offre, v_id_image);
    ELSE
        UPDATE tripenazor.image
        SET titre_image = p_titre_image,
            chemin = p_chemin_image
        WHERE id_image = v_id_image;
    END IF;

    -- Update de l'offre
    SELECT id_offre FROM tripenazor.offre INTO v_id_offre
    WHERE id_offre = p_id_offre;

    IF v_id_offre IS NOT NULL THEN
        UPDATE tripenazor.offre
        SET titre_offre = p_titre_offre,
            en_ligne = p_en_ligne,
            resume = p_resume,
            description = p_description,
            accessibilite = p_accessibilite,
            type_offre = p_type_offre,
            prix_TTC_min = p_prix_TTC_min,
            id_adresse = v_id_adresse,
            id_image_couverture = v_id_image
        WHERE id_offre = v_id_offre;
    ELSE 
        RAISE EXCEPTION 'L''offre n''existe pas';
    END IF;

    -- Jour et horaire de l'activité
    FOREACH v_jour IN ARRAY p_jours
    LOOP
        v_id_jour := NULL;

        -- Récupère l'ID du jour correspondant au libellé
        SELECT id_jour INTO v_id_jour
        FROM tripenazor.jour
        WHERE libelle = v_jour;

        IF v_id_jour IS NOT NULL THEN
            -- Vérifie si l'association existe déjà
            IF EXISTS (
                SELECT 1 FROM tripenazor.jour_ouverture
                WHERE id_offre = v_id_offre
            ) THEN
                -- Mise à jour de l'ID du jour pour l'offre
                UPDATE tripenazor.jour_ouverture
                SET id_jour = v_id_jour
                WHERE id_offre = v_id_offre;
            ELSE
                -- Sinon, insertion de la nouvelle association
                INSERT INTO tripenazor.jour_ouverture(id_jour, id_offre)
                VALUES (v_id_jour, v_id_offre);
            END IF;
        END IF;
    END LOOP;

    -- Insertion des horaires
    SELECT id_horaire INTO v_id_horaire_matin FROM tripenazor.horaire 
    WHERE debut = p_matin_heure_debut AND fin = p_matin_heure_fin;

    IF v_id_horaire_matin IS NULL THEN
        INSERT INTO tripenazor.horaire(debut, fin)
        VALUES (
            p_matin_heure_debut, 
            p_matin_heure_fin
        ) RETURNING id_horaire INTO v_id_horaire_matin;

        INSERT INTO tripenazor.horaire_ouverture(id_horaire, id_offre)
        VALUES (v_id_horaire_matin, v_id_offre);
    ELSE
        UPDATE tripenazor.horaire
        SET debut = p_matin_heure_debut,
            fin = p_matin_heure_fin
        WHERE id_horaire = v_id_horaire_matin;
    END IF;

    
    IF p_apres_midi_heure_debut IS NOT NULL AND p_apres_midi_heure_fin IS NOT NULL THEN
        SELECT id_horaire INTO v_id_horaire_apres_midi FROM tripenazor.horaire 
        WHERE debut = p_apres_midi_heure_debut AND
        fin = p_apres_midi_heure_fin;

        IF v_id_horaire_apres_midi IS NULL THEN
            INSERT INTO tripenazor.horaire(debut, fin)
            VALUES (
                p_apres_midi_heure_debut, 
                p_apres_midi_heure_fin
            ) RETURNING id_horaire INTO v_id_horaire_apres_midi;

            INSERT INTO tripenazor.horaire_ouverture(id_horaire, id_offre)
            VALUES (v_id_horaire_apres_midi, v_id_offre);
        ELSE
            UPDATE tripenazor.horaire
            SET debut = p_apres_midi_heure_debut,
                fin = p_apres_midi_heure_fin
            WHERE id_horaire = v_id_horaire_apres_midi;
        END IF;
    END IF;

    -- Insertion du professionnel
    SELECT id_utilisateur INTO v_id_professionnel_prive 
    FROM tripenazor.professionnel_prive
    WHERE id_utilisateur = p_id_professionnel;

    SELECT id_utilisateur INTO v_id_professionnel_public 
    FROM tripenazor.professionnel_public
    WHERE id_utilisateur = p_id_professionnel;

    IF v_id_professionnel_prive IS NOT NULL THEN
        IF EXISTS (
            SELECT 1
            FROM tripenazor.abonnement
            WHERE id_offre = v_id_offre
            AND id_utilisateur_prive = v_id_professionnel_prive
        ) THEN
            UPDATE tripenazor.abonnement
            SET prix = p_prix_prive,
                id_utilisateur_prive = v_id_professionnel_prive
            WHERE id_offre = v_id_offre
            AND id_utilisateur_prive = v_id_professionnel_prive;
        ELSE
            INSERT INTO tripenazor.abonnement (id_offre, id_utilisateur_prive, prix)
            VALUES (v_id_offre, v_id_professionnel_prive, p_prix_prive);
        END IF;
    ELSIF v_id_professionnel_public IS NOT NULL THEN
        IF EXISTS (
            SELECT 1
            FROM tripenazor.pro_public_propose_offre
            WHERE id_offre = v_id_offre
            AND id_utilisateur_public = v_id_professionnel_public
        ) THEN
            UPDATE tripenazor.pro_public_propose_offre
            SET id_utilisateur_public = v_id_professionnel_public
            WHERE id_offre = v_id_offre
            AND id_utilisateur_public = v_id_professionnel_public;
        ELSE
            INSERT INTO tripenazor.pro_public_propose_offre (id_offre, id_utilisateur_public)
            VALUES (v_id_offre, v_id_professionnel_public);
        END IF;
    ELSE
        RAISE EXCEPTION 'Le professionnel avec l''ID % n''existe pas dans les tables professionnel_prive ou professionnel_public', p_id_professionnel;
    END IF;

    -- ///////// Partie différente /////////
    -- Image carte du parc
    SELECT id_image INTO v_id_image_carte FROM tripenazor.image
    WHERE titre_image = p_titre_image_carte AND chemin = p_chemin_image_carte;

    IF v_id_image_carte IS NULL THEN
        INSERT INTO tripenazor.image (titre_image, chemin)
        VALUES (p_titre_image_carte, p_chemin_image_carte)
        RETURNING id_image INTO v_id_image_carte;

        INSERT INTO tripenazor.image_illustre_offre (id_offre, id_image)
        VALUES (v_id_offre, v_id_image_carte);
    ELSE
        UPDATE tripenazor.image
        SET titre_image = p_titre_image_carte,
            chemin = p_chemin_image_carte
        WHERE id_image = v_id_image_carte;
    END IF;

    -- Gamme de prix
    SELECT id_gamme_prix INTO v_id_gamme_prix FROM tripenazor.gamme_prix
    WHERE libelle_gamme_prix = p_libelle_gamme_prix;

    IF v_id_gamme_prix IS NULL THEN
        INSERT INTO tripenazor.gamme_prix(id_gamme_prix, libelle_gamme_prix)
        VALUES(v_id_gamme_prix, p_libelle_gamme_prix)
        RETURNING id_gamme_prix INTO v_id_gamme_prix;
    ELSE
        UPDATE tripenazor.gamme_prix
        SET libelle_gamme_prix = p_libelle_gamme_prix
        WHERE id_gamme_prix = v_id_gamme_prix;
    END IF;

    -- Insertion dans offre_parc_attraction
    UPDATE tripenazor.offre_restauration
    SET id_offre = p_id_offre,
        id_image = v_id_image_carte,
        id_gamme_prix = v_id_gamme_prix
    WHERE id_offre = p_id_offre;

    -- Insert des tags
    FOREACH v_tag IN ARRAY p_tags
    LOOP
        v_id_tag := NULL;
        v_id_tag_restauration := NULL;

        -- Chercher le tag dans la table "tag"
        SELECT id_tag INTO v_id_tag
        FROM tripenazor.tag
        WHERE libelle_tag = v_tag;

        -- Si le tag n'existe pas, on l'insère, puis on le marque comme commun
        IF v_id_tag IS NULL THEN
            INSERT INTO tripenazor.tag (libelle_tag)
            VALUES (v_tag)
            RETURNING id_tag INTO v_id_tag;

            INSERT INTO tripenazor.tag_commun (id_tag)
            VALUES (v_id_tag);
        END IF;

        -- Vérifie que ce tag est bien commun
        SELECT id_tag INTO v_id_tag_restauration 

        FROM tripenazor.tag_restauration
        WHERE id_tag = v_id_tag;

        -- Si c'est bien un tag restauration, lier à l'offre si pas déjà lié
        IF v_id_tag_restauration IS NOT NULL THEN
            IF NOT EXISTS (
                SELECT 1 FROM tripenazor.offre_restauration_possede_tag
                WHERE id_offre = v_id_offre AND id_tag = v_id_tag
            ) THEN
                INSERT INTO tripenazor.offre_restauration_possede_tag (id_offre, id_tag)
                VALUES (v_id_offre, v_id_tag);
            END IF;
        END IF;
    END LOOP;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION tripenazor.update_offre_spectacle(
    p_id_offre INT,
    
    -- Paramètres de l'offre
    p_nom_ville TEXT,
    p_code_postal TEXT,

    p_titre_offre TEXT,
	p_en_ligne BOOLEAN,
    p_resume TEXT,
    p_description TEXT,
    p_accessibilite TEXT,
    p_type_offre tripenazor.type_activite,
    p_prix_TTC_min FLOAT,
    p_tags TEXT[],

    -- Adresse
    p_voie TEXT,
    p_numero_adresse INT,
    p_complement_adresse TEXT,
    
    -- Image
    p_titre_image TEXT,
    p_chemin_image TEXT,

    -- Jour de l'activité
    p_jours NUMERIC[],
    p_matin_heure_debut TIME,
    p_matin_heure_fin TIME,

    -- Professionnel
    p_id_professionnel INT,

    -- Paramètres spécifiques à l'activité
    p_duree TIME,
    p_capacite_accueil FLOAT,

    p_apres_midi_heure_debut TIME DEFAULT NULL,
    p_apres_midi_heure_fin TIME DEFAULT NULL,
    p_prix_prive INT DEFAULT NULL
)
RETURNS VOID AS $$
DECLARE
    v_id_offre INT;
    v_id_image INT;
    v_id_horaire_matin INT;
    v_id_horaire_apres_midi INT;
    v_id_adresse INT;
    v_id_ville INT;
	v_id_jour INT;
    v_id_professionnel_prive INT;
    v_id_professionnel_public INT;
    v_id_tag INT;
    v_id_tag_commun INT;
	v_id_image_parc INT;
	v_jour TEXT;
    v_tag TEXT;
BEGIN
SELECT id_ville INTO v_id_ville FROM tripenazor.ville
    WHERE nom_ville = p_nom_ville AND
        code_postal = p_code_postal;

    IF v_id_ville IS NULL THEN
        -- Insère la ville
        INSERT INTO tripenazor.ville(nom_ville, code_postal)
        VALUES (
            p_nom_ville,
            p_code_postal
        )
        RETURNING id_ville INTO v_id_ville;
    END IF;

    SELECT id_adresse INTO v_id_adresse FROM tripenazor.adresse 
    WHERE voie = p_voie AND
        numero_adresse = p_numero_adresse AND
        complement_adresse = p_complement_adresse AND
        id_ville = v_id_ville;

    IF v_id_adresse IS NULL THEN
        INSERT INTO tripenazor.adresse(voie, numero_adresse, complement_adresse, id_ville)
        VALUES (
            p_voie, 
            p_numero_adresse, 
            p_complement_adresse, 
            v_id_ville
        )
        RETURNING id_adresse INTO v_id_adresse;
    ELSE 
        -- Update dans adresse
        UPDATE tripenazor.adresse
        SET voie = p_voie, 
            numero_adresse = p_numero_adresse, 
            complement_adresse = p_complement_adresse, 
            id_ville = v_id_ville
        WHERE id_adresse = v_id_adresse;
    END IF;

    -- Update image
    SELECT id_image INTO v_id_image FROM tripenazor.image 
    WHERE titre_image = p_titre_image AND 
        chemin = p_chemin_image;

    IF v_id_image IS NULL THEN
        INSERT INTO tripenazor.image (titre_image, chemin)
        VALUES (p_titre_image, p_chemin_image)
        RETURNING id_image INTO v_id_image;

        INSERT INTO tripenazor.image_illustre_offre (id_offre, id_image)
        VALUES (p_id_offre, v_id_image);
    ELSE
        UPDATE tripenazor.image
        SET titre_image = p_titre_image,
            chemin = p_chemin_image
        WHERE id_image = v_id_image;
    END IF;

    -- Update de l'offre
    SELECT id_offre FROM tripenazor.offre INTO v_id_offre
    WHERE id_offre = p_id_offre;

    IF v_id_offre IS NOT NULL THEN
        UPDATE tripenazor.offre
        SET titre_offre = p_titre_offre,
            en_ligne = p_en_ligne,
            resume = p_resume,
            description = p_description,
            accessibilite = p_accessibilite,
            type_offre = p_type_offre,
            prix_TTC_min = p_prix_TTC_min,
            id_adresse = v_id_adresse,
            id_image_couverture = v_id_image
        WHERE id_offre = v_id_offre;
    ELSE 
        RAISE EXCEPTION 'L''offre n''existe pas';
    END IF;

    -- Jour et horaire de l'activité
    FOREACH v_jour IN ARRAY p_jours
    LOOP
        v_id_jour := NULL;

        -- Récupère l'ID du jour correspondant au libellé
        SELECT id_jour INTO v_id_jour
        FROM tripenazor.jour
        WHERE libelle = v_jour;

        IF v_id_jour IS NOT NULL THEN
            -- Vérifie si l'association existe déjà
            IF EXISTS (
                SELECT 1 FROM tripenazor.jour_ouverture
                WHERE id_offre = v_id_offre
            ) THEN
                -- Mise à jour de l'ID du jour pour l'offre
                UPDATE tripenazor.jour_ouverture
                SET id_jour = v_id_jour
                WHERE id_offre = v_id_offre;
            ELSE
                -- Sinon, insertion de la nouvelle association
                INSERT INTO tripenazor.jour_ouverture(id_jour, id_offre)
                VALUES (v_id_jour, v_id_offre);
            END IF;
        END IF;
    END LOOP;

    -- Insertion des horaires
    SELECT id_horaire INTO v_id_horaire_matin FROM tripenazor.horaire 
    WHERE debut = p_matin_heure_debut AND fin = p_matin_heure_fin;

    IF v_id_horaire_matin IS NULL THEN
        INSERT INTO tripenazor.horaire(debut, fin)
        VALUES (
            p_matin_heure_debut, 
            p_matin_heure_fin
        ) RETURNING id_horaire INTO v_id_horaire_matin;

        INSERT INTO tripenazor.horaire_ouverture(id_horaire, id_offre)
        VALUES (v_id_horaire_matin, v_id_offre);
    ELSE
        UPDATE tripenazor.horaire
        SET debut = p_matin_heure_debut,
            fin = p_matin_heure_fin
        WHERE id_horaire = v_id_horaire_matin;
    END IF;

    
    IF p_apres_midi_heure_debut IS NOT NULL AND p_apres_midi_heure_fin IS NOT NULL THEN
        SELECT id_horaire INTO v_id_horaire_apres_midi FROM tripenazor.horaire 
        WHERE debut = p_apres_midi_heure_debut AND
        fin = p_apres_midi_heure_fin;

        IF v_id_horaire_apres_midi IS NULL THEN
            INSERT INTO tripenazor.horaire(debut, fin)
            VALUES (
                p_apres_midi_heure_debut, 
                p_apres_midi_heure_fin
            ) RETURNING id_horaire INTO v_id_horaire_apres_midi;

            INSERT INTO tripenazor.horaire_ouverture(id_horaire, id_offre)
            VALUES (v_id_horaire_apres_midi, v_id_offre);
        ELSE
            UPDATE tripenazor.horaire
            SET debut = p_apres_midi_heure_debut,
                fin = p_apres_midi_heure_fin
            WHERE id_horaire = v_id_horaire_apres_midi;
        END IF;
    END IF;

    -- Insertion du professionnel
    SELECT id_utilisateur INTO v_id_professionnel_prive 
    FROM tripenazor.professionnel_prive
    WHERE id_utilisateur = p_id_professionnel;

    SELECT id_utilisateur INTO v_id_professionnel_public 
    FROM tripenazor.professionnel_public
    WHERE id_utilisateur = p_id_professionnel;

    IF v_id_professionnel_prive IS NOT NULL THEN
        IF EXISTS (
            SELECT 1
            FROM tripenazor.abonnement
            WHERE id_offre = v_id_offre
            AND id_utilisateur_prive = v_id_professionnel_prive
        ) THEN
            UPDATE tripenazor.abonnement
            SET prix = p_prix_prive,
                id_utilisateur_prive = v_id_professionnel_prive
            WHERE id_offre = v_id_offre
            AND id_utilisateur_prive = v_id_professionnel_prive;
        ELSE
            INSERT INTO tripenazor.abonnement (id_offre, id_utilisateur_prive, prix)
            VALUES (v_id_offre, v_id_professionnel_prive, p_prix_prive);
        END IF;
    ELSIF v_id_professionnel_public IS NOT NULL THEN
        IF EXISTS (
            SELECT 1
            FROM tripenazor.pro_public_propose_offre
            WHERE id_offre = v_id_offre
            AND id_utilisateur_public = v_id_professionnel_public
        ) THEN
            UPDATE tripenazor.pro_public_propose_offre
            SET id_utilisateur_public = v_id_professionnel_public
            WHERE id_offre = v_id_offre
            AND id_utilisateur_public = v_id_professionnel_public;
        ELSE
            INSERT INTO tripenazor.pro_public_propose_offre (id_offre, id_utilisateur_public)
            VALUES (v_id_offre, v_id_professionnel_public);
        END IF;
    ELSE
        RAISE EXCEPTION 'Le professionnel avec l''ID % n''existe pas dans les tables professionnel_prive ou professionnel_public', p_id_professionnel;
    END IF;

    -- ///////// Partie différente /////////
    UPDATE tripenazor.offre_spectacle 
    SET duree = p_duree,
        capacite_accueil = p_capacite_accueil
    WHERE id_offre = p_id_offre;

    -- Insert des tags
    FOREACH v_tag IN ARRAY p_tags
    LOOP
        v_id_tag := NULL;
        v_id_tag_commun := NULL;

        -- Chercher le tag dans la table "tag"
        SELECT id_tag INTO v_id_tag
        FROM tripenazor.tag
        WHERE libelle_tag = v_tag;

        -- Si le tag n'existe pas, on l'insère, puis on le marque comme commun
        IF v_id_tag IS NULL THEN
            INSERT INTO tripenazor.tag (libelle_tag)
            VALUES (v_tag)
            RETURNING id_tag INTO v_id_tag;

            INSERT INTO tripenazor.tag_commun (id_tag)
            VALUES (v_id_tag);
        END IF;

        -- Vérifie que ce tag est bien commun
        SELECT id_tag INTO v_id_tag_commun
        FROM tripenazor.tag_commun
        WHERE id_tag = v_id_tag;

        -- Si c'est bien un tag commun, lier à l'offre si pas déjà lié
        IF v_id_tag_commun IS NOT NULL THEN
            IF NOT EXISTS (
                SELECT 1 FROM tripenazor.offre_spectacle_possede_tag
                WHERE id_offre = v_id_offre AND id_tag = v_id_tag
            ) THEN
                INSERT INTO tripenazor.offre_spectacle_possede_tag (id_offre, id_tag)
                VALUES (v_id_offre, v_id_tag);
            END IF;
        END IF;
    END LOOP;
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION tripenazor.update_offre_visite_guidee(
    p_id_offre INT,
    
    -- Paramètres de l'offre
    p_nom_ville TEXT,
    p_code_postal TEXT,

    p_titre_offre TEXT,
	p_en_ligne BOOLEAN,
    p_resume TEXT,
    p_description TEXT,
    p_accessibilite TEXT,
    p_type_offre tripenazor.type_activite,
    p_prix_TTC_min FLOAT,
    p_tags TEXT[],

    -- Adresse
    p_voie TEXT,
    p_numero_adresse INT,
    p_complement_adresse TEXT,
    
    -- Image
    p_titre_image TEXT,
    p_chemin_image TEXT,

    -- Jour de l'activité
    p_jours NUMERIC[],
    p_matin_heure_debut TIME,
    p_matin_heure_fin TIME,

    -- Professionnel
    p_id_professionnel INT,

    -- Paramètres spécifiques à l'activité
    p_duree TIME,
    p_langues TEXT[],

    p_apres_midi_heure_debut TIME DEFAULT NULL,
    p_apres_midi_heure_fin TIME DEFAULT NULL,
    p_prix_prive INT DEFAULT NULL
)
RETURNS VOID AS $$
DECLARE
    v_id_offre INT;
    v_id_image INT;
    v_id_horaire_matin INT;
    v_id_horaire_apres_midi INT;
    v_id_adresse INT;
    v_id_ville INT;
	v_id_jour INT;
    v_id_professionnel_prive INT;
    v_id_professionnel_public INT;
    v_id_tag INT;
    v_id_tag_commun INT;
	v_jour TEXT;
    v_tag TEXT;
    v_langue TEXT;
    v_id_langue INT;
BEGIN
    SELECT id_ville INTO v_id_ville FROM tripenazor.ville
    WHERE nom_ville = p_nom_ville AND
        code_postal = p_code_postal;

    IF v_id_ville IS NULL THEN
        -- Insère la ville
        INSERT INTO tripenazor.ville(nom_ville, code_postal)
        VALUES (
            p_nom_ville,
            p_code_postal
        )
        RETURNING id_ville INTO v_id_ville;
    END IF;

    SELECT id_adresse INTO v_id_adresse FROM tripenazor.adresse 
    WHERE voie = p_voie AND
        numero_adresse = p_numero_adresse AND
        complement_adresse = p_complement_adresse AND
        id_ville = v_id_ville;

    IF v_id_adresse IS NULL THEN
        INSERT INTO tripenazor.adresse(voie, numero_adresse, complement_adresse, id_ville)
        VALUES (
            p_voie, 
            p_numero_adresse, 
            p_complement_adresse, 
            v_id_ville
        )
        RETURNING id_adresse INTO v_id_adresse;
    ELSE 
        -- Update dans adresse
        UPDATE tripenazor.adresse
        SET voie = p_voie, 
            numero_adresse = p_numero_adresse, 
            complement_adresse = p_complement_adresse, 
            id_ville = v_id_ville
        WHERE id_adresse = v_id_adresse;
    END IF;

    -- Update image
    SELECT id_image INTO v_id_image FROM tripenazor.image 
    WHERE titre_image = p_titre_image AND 
        chemin = p_chemin_image;

    IF v_id_image IS NULL THEN
        INSERT INTO tripenazor.image (titre_image, chemin)
        VALUES (p_titre_image, p_chemin_image)
        RETURNING id_image INTO v_id_image;

        INSERT INTO tripenazor.image_illustre_offre (id_offre, id_image)
        VALUES (p_id_offre, v_id_image);
    ELSE
        UPDATE tripenazor.image
        SET titre_image = p_titre_image,
            chemin = p_chemin_image
        WHERE id_image = v_id_image;
    END IF;

    -- Update de l'offre
    SELECT id_offre FROM tripenazor.offre INTO v_id_offre
    WHERE id_offre = p_id_offre;

    IF v_id_offre IS NOT NULL THEN
        UPDATE tripenazor.offre
        SET titre_offre = p_titre_offre,
            en_ligne = p_en_ligne,
            resume = p_resume,
            description = p_description,
            accessibilite = p_accessibilite,
            type_offre = p_type_offre,
            prix_TTC_min = p_prix_TTC_min,
            id_adresse = v_id_adresse,
            id_image_couverture = v_id_image
        WHERE id_offre = v_id_offre;
    ELSE 
        RAISE EXCEPTION 'L''offre n''existe pas';
    END IF;

    -- Jour et horaire de l'activité
    FOREACH v_jour IN ARRAY p_jours
    LOOP
        v_id_jour := NULL;

        -- Récupère l'ID du jour correspondant au libellé
        SELECT id_jour INTO v_id_jour
        FROM tripenazor.jour
        WHERE libelle = v_jour;

        IF v_id_jour IS NOT NULL THEN
            -- Vérifie si l'association existe déjà
            IF EXISTS (
                SELECT 1 FROM tripenazor.jour_ouverture
                WHERE id_offre = v_id_offre
            ) THEN
                -- Mise à jour de l'ID du jour pour l'offre
                UPDATE tripenazor.jour_ouverture
                SET id_jour = v_id_jour
                WHERE id_offre = v_id_offre;
            ELSE
                -- Sinon, insertion de la nouvelle association
                INSERT INTO tripenazor.jour_ouverture(id_jour, id_offre)
                VALUES (v_id_jour, v_id_offre);
            END IF;
        END IF;
    END LOOP;

    -- Insertion des horaires
    SELECT id_horaire INTO v_id_horaire_matin FROM tripenazor.horaire 
    WHERE debut = p_matin_heure_debut AND fin = p_matin_heure_fin;

    IF v_id_horaire_matin IS NULL THEN
        INSERT INTO tripenazor.horaire(debut, fin)
        VALUES (
            p_matin_heure_debut, 
            p_matin_heure_fin
        ) RETURNING id_horaire INTO v_id_horaire_matin;

        INSERT INTO tripenazor.horaire_ouverture(id_horaire, id_offre)
        VALUES (v_id_horaire_matin, v_id_offre);
    ELSE
        UPDATE tripenazor.horaire
        SET debut = p_matin_heure_debut,
            fin = p_matin_heure_fin
        WHERE id_horaire = v_id_horaire_matin;
    END IF;

    
    IF p_apres_midi_heure_debut IS NOT NULL AND p_apres_midi_heure_fin IS NOT NULL THEN
        SELECT id_horaire INTO v_id_horaire_apres_midi FROM tripenazor.horaire 
        WHERE debut = p_apres_midi_heure_debut AND
        fin = p_apres_midi_heure_fin;

        IF v_id_horaire_apres_midi IS NULL THEN
            INSERT INTO tripenazor.horaire(debut, fin)
            VALUES (
                p_apres_midi_heure_debut, 
                p_apres_midi_heure_fin
            ) RETURNING id_horaire INTO v_id_horaire_apres_midi;

            INSERT INTO tripenazor.horaire_ouverture(id_horaire, id_offre)
            VALUES (v_id_horaire_apres_midi, v_id_offre);
        ELSE
            UPDATE tripenazor.horaire
            SET debut = p_apres_midi_heure_debut,
                fin = p_apres_midi_heure_fin
            WHERE id_horaire = v_id_horaire_apres_midi;
        END IF;
    END IF;

    -- Insertion du professionnel
    SELECT id_utilisateur INTO v_id_professionnel_prive 
    FROM tripenazor.professionnel_prive
    WHERE id_utilisateur = p_id_professionnel;

    SELECT id_utilisateur INTO v_id_professionnel_public 
    FROM tripenazor.professionnel_public
    WHERE id_utilisateur = p_id_professionnel;

    IF v_id_professionnel_prive IS NOT NULL THEN
        IF EXISTS (
            SELECT 1
            FROM tripenazor.abonnement
            WHERE id_offre = v_id_offre
            AND id_utilisateur_prive = v_id_professionnel_prive
        ) THEN
            UPDATE tripenazor.abonnement
            SET prix = p_prix_prive,
                id_utilisateur_prive = v_id_professionnel_prive
            WHERE id_offre = v_id_offre
            AND id_utilisateur_prive = v_id_professionnel_prive;
        ELSE
            INSERT INTO tripenazor.abonnement (id_offre, id_utilisateur_prive, prix)
            VALUES (v_id_offre, v_id_professionnel_prive, p_prix_prive);
        END IF;
    ELSIF v_id_professionnel_public IS NOT NULL THEN
        IF EXISTS (
            SELECT 1
            FROM tripenazor.pro_public_propose_offre
            WHERE id_offre = v_id_offre
            AND id_utilisateur_public = v_id_professionnel_public
        ) THEN
            UPDATE tripenazor.pro_public_propose_offre
            SET id_utilisateur_public = v_id_professionnel_public
            WHERE id_offre = v_id_offre
            AND id_utilisateur_public = v_id_professionnel_public;
        ELSE
            INSERT INTO tripenazor.pro_public_propose_offre (id_offre, id_utilisateur_public)
            VALUES (v_id_offre, v_id_professionnel_public);
        END IF;
    ELSE
        RAISE EXCEPTION 'Le professionnel avec l''ID % n''existe pas dans les tables professionnel_prive ou professionnel_public', p_id_professionnel;
    END IF;

    -- ///////// Partie différente /////////
    -- Update dans offre_visite
    UPDATE tripenazor.offre_visite 
    SET duree = p_duree
    WHERE id_offre = v_id_offre;

    -- Les langues
    FOREACH v_langue IN ARRAY p_langues
    LOOP
        v_id_langue := NULL;

        SELECT id_langue INTO v_id_langue
        FROM tripenazor.langue
        WHERE libelle_langue = v_langue;

        -- Si la langue n'existe pas, on l'insère
        IF v_id_langue IS NULL THEN
            INSERT INTO tripenazor.langue (libelle_langue)
            VALUES (v_langue)
            RETURNING id_langue INTO v_id_langue;
        END IF;

        -- Vérifie si le lien existe déjà entre la visite et la langue
        IF NOT EXISTS (
            SELECT 1 FROM tripenazor.visite_guidee_disponible_en_langue
            WHERE id_visite = v_id_offre AND id_langue = v_id_langue
        ) THEN
            UPDATE tripenazor.langue 
            SET libelle_langue = v_langue
            WHERE id_langue = v_id_langue;
        END IF;
    END LOOP;

    -- Insert des tags
    FOREACH v_tag IN ARRAY p_tags
    LOOP
        v_id_tag := NULL;
        v_id_tag_commun := NULL;

        -- Chercher le tag dans la table "tag"
        SELECT id_tag INTO v_id_tag
        FROM tripenazor.tag
        WHERE libelle_tag = v_tag;

        -- Si le tag n'existe pas, on l'insère, puis on le marque comme commun
        IF v_id_tag IS NULL THEN
            INSERT INTO tripenazor.tag (libelle_tag)
            VALUES (v_tag)
            RETURNING id_tag INTO v_id_tag;

            INSERT INTO tripenazor.tag_commun (id_tag)
            VALUES (v_id_tag);
        END IF;

        -- Vérifie que ce tag est bien commun
        SELECT id_tag INTO v_id_tag_commun
        FROM tripenazor.tag_commun
        WHERE id_tag = v_id_tag;

        -- Si c'est bien un tag commun, lier à l'offre si pas déjà lié
        IF v_id_tag_commun IS NOT NULL THEN
            IF NOT EXISTS (
                SELECT 1 FROM tripenazor.offre_visite_possede_tag
                WHERE id_offre = v_id_offre AND id_tag = v_id_tag
            ) THEN
                INSERT INTO tripenazor.offre_visite_possede_tag (id_offre, id_tag)
                VALUES (v_id_offre, v_id_tag);
            END IF;
        END IF;
    END LOOP;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION tripenazor.update_offre_visite_non_guidee(
    p_id_offre INT,
    
    -- Paramètres de l'offre
    p_nom_ville TEXT,
    p_code_postal TEXT,

    p_titre_offre TEXT,
	p_en_ligne BOOLEAN,
    p_resume TEXT,
    p_description TEXT,
    p_accessibilite TEXT,
    p_type_offre tripenazor.type_activite,
    p_prix_TTC_min FLOAT,
    p_tags TEXT[],

    -- Adresse
    p_voie TEXT,
    p_numero_adresse INT,
    p_complement_adresse TEXT,
    
    -- Image
    p_titre_image TEXT,
    p_chemin_image TEXT,

    -- Jour de l'activité
    p_jours NUMERIC[],
    p_matin_heure_debut TIME,
    p_matin_heure_fin TIME,

    -- Professionnel
    p_id_professionnel INT,

    -- Paramètres spécifiques à l'activité
    p_duree TIME,

    p_apres_midi_heure_debut TIME DEFAULT NULL,
    p_apres_midi_heure_fin TIME DEFAULT NULL,
    p_prix_prive INT DEFAULT NULL
)
RETURNS VOID AS $$
DECLARE
    v_id_offre INT;
    v_id_image INT;
    v_id_horaire_matin INT;
    v_id_horaire_apres_midi INT;
    v_id_adresse INT;
    v_id_ville INT;
	v_id_jour INT;
    v_id_professionnel_prive INT;
    v_id_professionnel_public INT;
    v_id_tag INT;
    v_id_tag_commun INT;
	v_jour TEXT;
    v_tag TEXT;
BEGIN
    SELECT id_ville INTO v_id_ville FROM tripenazor.ville
    WHERE nom_ville = p_nom_ville AND
        code_postal = p_code_postal;

    IF v_id_ville IS NULL THEN
        -- Insère la ville
        INSERT INTO tripenazor.ville(nom_ville, code_postal)
        VALUES (
            p_nom_ville,
            p_code_postal
        )
        RETURNING id_ville INTO v_id_ville;
    END IF;

    SELECT id_adresse INTO v_id_adresse FROM tripenazor.adresse 
    WHERE voie = p_voie AND
        numero_adresse = p_numero_adresse AND
        complement_adresse = p_complement_adresse AND
        id_ville = v_id_ville;

    IF v_id_adresse IS NULL THEN
        INSERT INTO tripenazor.adresse(voie, numero_adresse, complement_adresse, id_ville)
        VALUES (
            p_voie, 
            p_numero_adresse, 
            p_complement_adresse, 
            v_id_ville
        )
        RETURNING id_adresse INTO v_id_adresse;
    ELSE 
        -- Update dans adresse
        UPDATE tripenazor.adresse
        SET voie = p_voie, 
            numero_adresse = p_numero_adresse, 
            complement_adresse = p_complement_adresse, 
            id_ville = v_id_ville
        WHERE id_adresse = v_id_adresse;
    END IF;

    -- Update image
    SELECT id_image INTO v_id_image FROM tripenazor.image 
    WHERE titre_image = p_titre_image AND 
        chemin = p_chemin_image;

    IF v_id_image IS NULL THEN
        INSERT INTO tripenazor.image (titre_image, chemin)
        VALUES (p_titre_image, p_chemin_image)
        RETURNING id_image INTO v_id_image;

        INSERT INTO tripenazor.image_illustre_offre (id_offre, id_image)
        VALUES (p_id_offre, v_id_image);
    ELSE
        UPDATE tripenazor.image
        SET titre_image = p_titre_image,
            chemin = p_chemin_image
        WHERE id_image = v_id_image;
    END IF;

    -- Update de l'offre
    SELECT id_offre FROM tripenazor.offre INTO v_id_offre
    WHERE id_offre = p_id_offre;

    IF v_id_offre IS NOT NULL THEN
        UPDATE tripenazor.offre
        SET titre_offre = p_titre_offre,
            en_ligne = p_en_ligne,
            resume = p_resume,
            description = p_description,
            accessibilite = p_accessibilite,
            type_offre = p_type_offre,
            prix_TTC_min = p_prix_TTC_min,
            id_adresse = v_id_adresse,
            id_image_couverture = v_id_image
        WHERE id_offre = v_id_offre;
    ELSE 
        RAISE EXCEPTION 'L''offre n''existe pas';
    END IF;

    -- Jour et horaire de l'activité
    FOREACH v_jour IN ARRAY p_jours
    LOOP
        v_id_jour := NULL;

        -- Récupère l'ID du jour correspondant au libellé
        SELECT id_jour INTO v_id_jour
        FROM tripenazor.jour
        WHERE libelle = v_jour;

        IF v_id_jour IS NOT NULL THEN
            -- Vérifie si l'association existe déjà
            IF EXISTS (
                SELECT 1 FROM tripenazor.jour_ouverture
                WHERE id_offre = v_id_offre
            ) THEN
                -- Mise à jour de l'ID du jour pour l'offre
                UPDATE tripenazor.jour_ouverture
                SET id_jour = v_id_jour
                WHERE id_offre = v_id_offre;
            ELSE
                -- Sinon, insertion de la nouvelle association
                INSERT INTO tripenazor.jour_ouverture(id_jour, id_offre)
                VALUES (v_id_jour, v_id_offre);
            END IF;
        END IF;
    END LOOP;

    -- Insertion des horaires
    SELECT id_horaire INTO v_id_horaire_matin FROM tripenazor.horaire 
    WHERE debut = p_matin_heure_debut AND fin = p_matin_heure_fin;

    IF v_id_horaire_matin IS NULL THEN
        INSERT INTO tripenazor.horaire(debut, fin)
        VALUES (
            p_matin_heure_debut, 
            p_matin_heure_fin
        ) RETURNING id_horaire INTO v_id_horaire_matin;

        INSERT INTO tripenazor.horaire_ouverture(id_horaire, id_offre)
        VALUES (v_id_horaire_matin, v_id_offre);
    ELSE
        UPDATE tripenazor.horaire
        SET debut = p_matin_heure_debut,
            fin = p_matin_heure_fin
        WHERE id_horaire = v_id_horaire_matin;
    END IF;

    
    IF p_apres_midi_heure_debut IS NOT NULL AND p_apres_midi_heure_fin IS NOT NULL THEN
        SELECT id_horaire INTO v_id_horaire_apres_midi FROM tripenazor.horaire 
        WHERE debut = p_apres_midi_heure_debut AND
        fin = p_apres_midi_heure_fin;

        IF v_id_horaire_apres_midi IS NULL THEN
            INSERT INTO tripenazor.horaire(debut, fin)
            VALUES (
                p_apres_midi_heure_debut, 
                p_apres_midi_heure_fin
            ) RETURNING id_horaire INTO v_id_horaire_apres_midi;

            INSERT INTO tripenazor.horaire_ouverture(id_horaire, id_offre)
            VALUES (v_id_horaire_apres_midi, v_id_offre);
        ELSE
            UPDATE tripenazor.horaire
            SET debut = p_apres_midi_heure_debut,
                fin = p_apres_midi_heure_fin
            WHERE id_horaire = v_id_horaire_apres_midi;
        END IF;
    END IF;

    -- Insertion du professionnel
    SELECT id_utilisateur INTO v_id_professionnel_prive 
    FROM tripenazor.professionnel_prive
    WHERE id_utilisateur = p_id_professionnel;

    SELECT id_utilisateur INTO v_id_professionnel_public 
    FROM tripenazor.professionnel_public
    WHERE id_utilisateur = p_id_professionnel;

    IF v_id_professionnel_prive IS NOT NULL THEN
        IF EXISTS (
            SELECT 1
            FROM tripenazor.abonnement
            WHERE id_offre = v_id_offre
            AND id_utilisateur_prive = v_id_professionnel_prive
        ) THEN
            UPDATE tripenazor.abonnement
            SET prix = p_prix_prive,
                id_utilisateur_prive = v_id_professionnel_prive
            WHERE id_offre = v_id_offre
            AND id_utilisateur_prive = v_id_professionnel_prive;
        ELSE
            INSERT INTO tripenazor.abonnement (id_offre, id_utilisateur_prive, prix)
            VALUES (v_id_offre, v_id_professionnel_prive, p_prix_);
        END IF;
    ELSIF v_id_professionnel_public IS NOT NULL THEN
        IF EXISTS (
            SELECT 1
            FROM tripenazor.pro_public_propose_offre
            WHERE id_offre = v_id_offre
            AND id_utilisateur_public = v_id_professionnel_public
        ) THEN
            UPDATE tripenazor.pro_public_propose_offre
            SET id_utilisateur_public = v_id_professionnel_public
            WHERE id_offre = v_id_offre
            AND id_utilisateur_public = v_id_professionnel_public;
        ELSE
            INSERT INTO tripenazor.pro_public_propose_offre (id_offre, id_utilisateur_public)
            VALUES (v_id_offre, v_id_professionnel_public);
        END IF;
    ELSE
        RAISE EXCEPTION 'Le professionnel avec l''ID % n''existe pas dans les tables professionnel_prive ou professionnel_public', p_id_professionnel;
    END IF;

    -- ///////// Partie différente /////////
    -- Update dans offre_visite
    UPDATE tripenazor.offre_visite 
    SET duree = p_duree
    WHERE id_offre = v_id_offre;

    -- Insert des tags
    FOREACH v_tag IN ARRAY p_tags
    LOOP
        v_id_tag := NULL;
        v_id_tag_commun := NULL;

        -- Chercher le tag dans la table "tag"
        SELECT id_tag INTO v_id_tag
        FROM tripenazor.tag
        WHERE libelle_tag = v_tag;

        -- Si le tag n'existe pas, on l'insère, puis on le marque comme commun
        IF v_id_tag IS NULL THEN
            INSERT INTO tripenazor.tag (libelle_tag)
            VALUES (v_tag)
            RETURNING id_tag INTO v_id_tag;

            INSERT INTO tripenazor.tag_commun (id_tag)
            VALUES (v_id_tag);
        END IF;

        -- Vérifie que ce tag est bien commun
        SELECT id_tag INTO v_id_tag_commun
        FROM tripenazor.tag_commun
        WHERE id_tag = v_id_tag;

        -- Si c'est bien un tag commun, lier à l'offre si pas déjà lié
        IF v_id_tag_commun IS NOT NULL THEN
            IF NOT EXISTS (
                SELECT 1 FROM tripenazor.offre_visite_possede_tag
                WHERE id_offre = v_id_offre AND id_tag = v_id_tag
            ) THEN
                INSERT INTO tripenazor.offre_visite_possede_tag (id_offre, id_tag)
                VALUES (v_id_offre, v_id_tag);
            END IF;
        END IF;
    END LOOP;
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION tripenazor.publication_offre(
    o_id_offre INT,
    en_relief BOOLEAN,
    a_la_une BOOLEAN,
    nb_semaines INT
)
RETURNS VOID AS $$
DECLARE
    v_id_souscription INT;
BEGIN
    -- Vérification de l'existence de l'offre
    IF NOT EXISTS (SELECT 1 FROM tripenazor.offre WHERE id_offre = o_id_offre) THEN
        RAISE EXCEPTION 'L''offre avec l''ID % n''existe pas', o_id_offre;
    END IF;

    -- Mise à jour de l'offre
    UPDATE tripenazor.offre
    SET en_ligne = TRUE
    WHERE id_offre = o_id_offre;

    -- Insertion dans la table relation des souscriptions aux options
    -- Si il y a une option en relief
    IF en_relief = 'on' THEN
        -- Creation d'une souscription
        INSERT INTO tripenazor.souscription(nb_semaine) 
        VALUES (nb_semaines)
        RETURNING id_souscription INTO v_id_souscription;
        INSERT INTO tripenazor.option_payante_offre(id_offre, id_option, id_souscription)
        VALUES (o_id_offre, 1, v_id_souscription);
    END IF;

    IF a_la_une = 'on' THEN
        -- Creation d'une souscription
        INSERT INTO tripenazor.souscription(nb_semaine) 
        VALUES (nb_semaines)
        RETURNING id_souscription INTO v_id_souscription;
        -- Si il y a une option à la une
        INSERT INTO tripenazor.option_payante_offre(id_offre, id_option, id_souscription)
        VALUES (o_id_offre, 2, v_id_souscription);
    END IF;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION tripenazor.update_professionnel_prive(
    -- Général
    p_id INT,
    p_nom TEXT,
    p_prenom TEXT, 
    p_email TEXT, 
    p_telephone TEXT,
    p_denomination TEXT,
    p_siren INT,
    p_iban TEXT,
    p_lien_site_web TEXT,

    -- Adresse
    p_numero_adresse INT,
    p_voie_entreprise TEXT,
    p_complement_adresse TEXT,

    -- Ville
    p_ville TEXT, 
    p_code_postal TEXT 
)
RETURNS VOID AS $$
DECLARE
    utilisateur_record RECORD;
    professionnel_record RECORD;
    professionnel_prive_record RECORD;

    adresse_record RECORD;
    ville_record RECORD;
BEGIN
    -- Table utilisateur 
    SELECT * INTO utilisateur_record 
    FROM tripenazor.utilisateur
    WHERE id_utilisateur = p_id;

    -- Table professionnel
    SELECT * INTO professionnel_record
    FROM tripenazor.professionnel
    WHERE id_utilisateur = p_id;

    -- Table adresse
    SELECT * INTO adresse_record
    FROM tripenazor.adresse 
    WHERE id_adresse = utilisateur_record.id_adresse;


    -- Utilisateur
    UPDATE tripenazor.utilisateur 
    SET 
        prenom = COALESCE(p_prenom, NULL),
        nom = COALESCE(p_nom, NULL),
        num_telephone = COALESCE(p_telephone, NULL),
        email = COALESCE(p_email, NULL)
    WHERE id_utilisateur = p_id;

    -- Professionnel
    UPDATE tripenazor.professionnel
    SET 
        lien_site_web = COALESCE(p_lien_site_web, NULL)
    WHERE id_utilisateur = p_id;

    -- Professionnel privé
    UPDATE tripenazor.professionnel_prive
    SET 
        denomination = COALESCE(p_denomination, NULL),
        siren = COALESCE(p_siren, NULL),
        iban = COALESCE(p_iban, NULL)
    WHERE id_utilisateur = p_id;

    -- Adresse
    UPDATE tripenazor.adresse 
    SET 
        voie = COALESCE(p_voie_entreprise, NULL),
        numero_adresse = COALESCE(p_numero_adresse, NULL),
        complement_adresse = COALESCE(p_complement_adresse, NULL)
    WHERE id_adresse = adresse_record.id_adresse;

    -- Ville (si liée par la table adresse)
    UPDATE tripenazor.ville 
    SET 
        nom_ville = COALESCE(p_ville, NULL),
        code_postal = COALESCE(p_code_postal, NULL)
    WHERE id_ville = adresse_record.id_ville;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION tripenazor.update_professionnel_prive(
    -- Général
    p_id INT,
    p_nom TEXT,
    p_prenom TEXT, 
    p_email TEXT, 
    p_telephone TEXT,
    p_denomination TEXT,
    p_siren INT,
    p_iban TEXT,
    p_lien_site_web TEXT,

    -- Adresse
    p_numero_adresse INT,
    p_voie_entreprise TEXT,
    p_complement_adresse TEXT,

    -- Ville
    p_ville TEXT, 
    p_code_postal TEXT 
)
RETURNS VOID AS $$
DECLARE
    utilisateur_record RECORD;
    professionnel_record RECORD;
    professionnel_prive_record RECORD;

    adresse_record RECORD;
    ville_record RECORD;
BEGIN
    -- Table utilisateur 
    SELECT * INTO utilisateur_record 
    FROM tripenazor.utilisateur
    WHERE id_utilisateur = p_id;

    -- Table professionnel
    SELECT * INTO professionnel_record
    FROM tripenazor.professionnel
    WHERE id_utilisateur = p_id;

    -- Table adresse
    SELECT * INTO adresse_record
    FROM tripenazor.adresse 
    WHERE id_adresse = utilisateur_record.id_adresse;


    -- Utilisateur
    UPDATE tripenazor.utilisateur 
    SET 
        prenom = COALESCE(p_prenom, NULL),
        nom = COALESCE(p_nom, NULL),
        num_telephone = COALESCE(p_telephone, NULL),
        email = COALESCE(p_email, NULL)
    WHERE id_utilisateur = p_id;

    -- Professionnel
    UPDATE tripenazor.professionnel
    SET 
        lien_site_web = COALESCE(p_lien_site_web, NULL)
    WHERE id_utilisateur = p_id;

    -- Professionnel privé
    UPDATE tripenazor.professionnel_prive
    SET 
        denomination = COALESCE(p_denomination, NULL),
        siren = COALESCE(p_siren, NULL),
        iban = COALESCE(p_iban, NULL)
    WHERE id_utilisateur = p_id;

    -- Adresse
    UPDATE tripenazor.adresse 
    SET 
        voie = COALESCE(p_voie_entreprise, NULL),
        numero_adresse = COALESCE(p_numero_adresse, NULL),
        complement_adresse = COALESCE(p_complement_adresse, NULL)
    WHERE id_adresse = adresse_record.id_adresse;

    -- Ville (si liée par la table adresse)
    UPDATE tripenazor.ville 
    SET 
        nom_ville = COALESCE(p_ville, NULL),
        code_postal = COALESCE(p_code_postal, NULL)
    WHERE id_ville = adresse_record.id_ville;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION tripenazor.update_professionnel_public(
    -- Général
    p_id INT,
    p_nom TEXT,
    p_prenom TEXT, 
    p_email TEXT, 
    p_telephone TEXT,
    p_raison_sociale TEXT,
    p_lien_site_web TEXT,

    -- Adresse
    p_numero_adresse INT,
    p_voie_entreprise TEXT,
    p_complement_adresse TEXT,

    -- Ville
    p_ville TEXT, 
    p_code_postal TEXT 
)
RETURNS VOID AS $$
DECLARE

    adresse_record RECORD;
    ville_record RECORD;
    utilisateur_record RECORD;
    professionnel_record RECORD;
    professionnel_prive_record RECORD;
BEGIN
    -- Table utilisateur 
    SELECT * INTO utilisateur_record 
    FROM tripenazor.utilisateur
    WHERE id_utilisateur = p_id;

    -- Table professionnel
    SELECT * INTO professionnel_record
    FROM tripenazor.professionnel
    WHERE id_utilisateur = p_id;
    -- Table utilisateur 
    SELECT * INTO utilisateur_record 
    FROM tripenazor.utilisateur
    WHERE id_utilisateur = p_id;

    -- Table professionnel
    SELECT * INTO professionnel_record
    FROM tripenazor.professionnel
    WHERE id_utilisateur = p_id;

    -- Table adresse
    SELECT * INTO adresse_record
    FROM tripenazor.adresse 
    WHERE id_adresse = utilisateur_record.id_adresse;
    -- Table adresse
    SELECT * INTO adresse_record
    FROM tripenazor.adresse 
    WHERE id_adresse = utilisateur_record.id_adresse;

    -- Utilisateur
    UPDATE tripenazor.utilisateur 
    SET 
        prenom = COALESCE(p_prenom, NULL),
        nom = COALESCE(p_nom, NULL),
        num_telephone = COALESCE(p_telephone, NULL),
        email = COALESCE(p_email, NULL)
    WHERE id_utilisateur = p_id;

    -- Professionnel
    UPDATE tripenazor.professionnel
    SET 
        lien_site_web = COALESCE(p_lien_site_web, NULL)
    WHERE id_utilisateur = p_id;

    -- Professionnel privé
    UPDATE tripenazor.professionnel_public
    SET 
        raison_sociale = COALESCE(p_raison_sociale, NULL)
    WHERE id_utilisateur = p_id;

    -- Adresse
    UPDATE tripenazor.adresse 
    SET 
        voie = COALESCE(p_voie_entreprise, NULL),
        numero_adresse = COALESCE(p_numero_adresse, NULL),
        complement_adresse = COALESCE(p_complement_adresse, NULL)
    WHERE id_adresse = adresse_record.id_adresse;

    -- Ville (si liée par la table adresse)
    UPDATE tripenazor.ville 
    SET 
        nom_ville = COALESCE(p_ville, NULL),
        code_postal = COALESCE(p_code_postal, NULL)
    WHERE id_ville = adresse_record.id_ville;
    -- Utilisateur
    UPDATE tripenazor.utilisateur 
    SET 
        prenom = COALESCE(p_prenom, NULL),
        nom = COALESCE(p_nom, NULL),
        num_telephone = COALESCE(p_telephone, NULL),
        email = COALESCE(p_email, NULL)
    WHERE id_utilisateur = p_id;

    -- Professionnel
    UPDATE tripenazor.professionnel
    SET 
        lien_site_web = COALESCE(p_lien_site_web, NULL)
    WHERE id_utilisateur = p_id;

    -- Professionnel privé
    UPDATE tripenazor.professionnel_public
    SET 
        raison_sociale = COALESCE(p_raison_sociale, NULL)
    WHERE id_utilisateur = p_id;

    -- Adresse
    UPDATE tripenazor.adresse 
    SET 
        voie = COALESCE(p_voie_entreprise, NULL),
        numero_adresse = COALESCE(p_numero_adresse, NULL),
        complement_adresse = COALESCE(p_complement_adresse, NULL)
    WHERE id_adresse = adresse_record.id_adresse;

    -- Ville (si liée par la table adresse)
    UPDATE tripenazor.ville 
    SET 
        nom_ville = COALESCE(p_ville, NULL),
        code_postal = COALESCE(p_code_postal, NULL)
    WHERE id_ville = adresse_record.id_ville;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION tripenazor.update_professionnel_prive(
    p_id_image INT DEFAULT NULL,
    p_chemin_image TEXT DEFAULT NULL
)
RETURNS VOID AS $$
DECLARE

BEGIN
    IF p_id_image IS NOT NULL AND p_chemin_image IS NOT NULL THEN
        UPDATE tripenazor.image
        SET chemin = p_chemin_image
        WHERE id_image = p_id_image;
    END IF;
END;
$$ LANGUAGE plpgsql;