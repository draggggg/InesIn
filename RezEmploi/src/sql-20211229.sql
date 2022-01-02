SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET
time_zone = "+00:00";

CREATE TABLE `langues`
(
    `code`     int(11) NOT NULL,
    `priv_key` char(10)     NOT NULL,
    `libelle`  varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `niveaux_etudes`
(
    `code`     int(11) NOT NULL,
    `priv_key` char(10)     NOT NULL,
    `libelle`  varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `pays`
(
    `code`     int(11) NOT NULL,
    `priv_key` char(10)     NOT NULL,
    `libelle`  varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `reseaux_sociaux`
(
    `code`     int(11) NOT NULL,
    `priv_key` char(10)     NOT NULL,
    `libelle`  varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `rubriquescv`
(
    `code`     int(11) NOT NULL,
    `priv_key` char(10)     NOT NULL,
    `libelle`  varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `textes`
(
    `code`     int(11) NOT NULL,
    `priv_key` char(10)     NOT NULL,
    `libelle`  varchar(255) NOT NULL,
    `titre`    varchar(255) NOT NULL DEFAULT '',
    `texte`    text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `types_contrats`
(
    `code`     int(11) NOT NULL,
    `priv_key` char(10)     NOT NULL,
    `libelle`  varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `types_diplomes`
(
    `code`     int(11) NOT NULL,
    `priv_key` char(10)     NOT NULL,
    `libelle`  varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `types_realisations`
(
    `code`     int(11) NOT NULL,
    `priv_key` char(10)     NOT NULL,
    `libelle`  varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `utilisateurs`
(
    `code`                 int(11) NOT NULL,
    `priv_key`             char(10)     NOT NULL,
    `pseudo`               varchar(255) NOT NULL,
    `motdepasse`           varchar(255) NOT NULL,
    `email`                varchar(255) NOT NULL,
    `actif`                bit(1)       NOT NULL DEFAULT b'0',
    `creation_IP`          varchar(255) NOT NULL DEFAULT '',
    `creation_timestamp`   int(10) UNSIGNED NOT NULL DEFAULT '0',
    `activation_IP`        varchar(255) NOT NULL DEFAULT '',
    `activation_timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `bloque`               bit(1)       NOT NULL DEFAULT b'0',
    `blocage_IP`           varchar(255) NOT NULL DEFAULT '',
    `blocage_timestamp`    int(10) UNSIGNED NOT NULL DEFAULT '0',
    `droit_superadmin`     bit(1)       NOT NULL DEFAULT b'0',
    `droit_admin`          bit(1)       NOT NULL DEFAULT b'0',
    `droit_moderation`     bit(1)       NOT NULL DEFAULT b'0',
    `droit_particulier`    bit(1)       NOT NULL DEFAULT b'1',
    `droit_entreprise`     bit(1)       NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `langues`
    ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `langues_par_libelle` (`libelle`,`code`);

ALTER TABLE `niveaux_etudes`
    ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `niveaux_etudes_par_libelle` (`libelle`,`code`);

ALTER TABLE `pays`
    ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `pays_par_libelle` (`libelle`,`code`);

ALTER TABLE `reseaux_sociaux`
    ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `reseaux_sociaux_par_libelle` (`libelle`,`code`);

ALTER TABLE `rubriquescv`
    ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `rubriquescv_par_libelle` (`libelle`,`code`);

ALTER TABLE `textes`
    ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `textes_par_libelle` (`libelle`,`code`);

ALTER TABLE `types_contrats`
    ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `types_contrats_par_libelle` (`libelle`,`code`);

ALTER TABLE `types_diplomes`
    ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `types_diplomes_par_libelle` (`libelle`,`code`);

ALTER TABLE `types_realisations`
    ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `types_realisations_par_libelle` (`libelle`,`code`);

ALTER TABLE `utilisateurs`
    ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `utilisateurs_par_pseudo` (`pseudo`,`code`),
  ADD UNIQUE KEY `utilisateurs_par_email` (`email`,`code`);

ALTER TABLE `langues`
    MODIFY `code` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `niveaux_etudes`
    MODIFY `code` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `pays`
    MODIFY `code` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `reseaux_sociaux`
    MODIFY `code` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rubriquescv`
    MODIFY `code` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `textes`
    MODIFY `code` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `types_contrats`
    MODIFY `code` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `types_diplomes`
    MODIFY `code` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `types_realisations`
    MODIFY `code` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `utilisateurs`
    MODIFY `code` int (11) NOT NULL AUTO_INCREMENT;

-- ajout du 29/12/2021

CREATE TABLE `cv_infos`
(
    `code`                  int(11) NOT NULL,
    `priv_key`              char(10)     NOT NULL,
    `titre`                 varchar(255) NOT NULL,
    `nom`                   varchar(255) NOT NULL,
    `prenom`                varchar(255) NOT NULL,
    `datenaissance_annee`   int(11) NOT NULL,
    `datenaissance_mois`    int(11) NOT NULL,
    `datenaissance_jour`    int(11) NOT NULL,
    `datenaissance_publiee` bit(1)       NOT NULL DEFAULT b'0',
    `utilisateur_code`      int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `cv_infos`
    ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `cv_infos_par_utilisateur` (`utilisateur_code`,`code`),
  ADD UNIQUE KEY `cv_infos_par_nom` (`nom`,`prenom`,`code`);

ALTER TABLE `cv_infos`
    MODIFY `code` int (11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `cv_langues`
(
    `langue_code`      int(11) NOT NULL,
    `priv_key`         char(10) NOT NULL,
    `utilisateur_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `cv_langues`
    ADD UNIQUE KEY `cv_langues_par_utilisateur` (`utilisateur_code`,`langue_code`),
    ADD UNIQUE KEY `cv_langues_par_langue` (`langue_code`,`utilisateur_code`);

ALTER TABLE `cv_infos`
    add `niveau_etude_code` int(11) NOT NULL,ADD UNIQUE KEY `cv_infos_par_niveau_etude` (`niveau_etude_code`,`code`);
