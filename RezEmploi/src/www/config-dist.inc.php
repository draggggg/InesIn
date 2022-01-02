<?php
if ((!defined("REZEMPLOIKEY")) || (REZEMPLOIKEY != "3f5gd4ng2h5j4gh24,gh2j54fd2g54fg2h45")) {
    header("location: index.php");
    exit;
}

// Paramètres par défaut du logiciel
//
// NE MODIFIEZ JAMAIS CE FICHIER CAR CE SERA ECRASE LORS D'UNE MISE A JOUR DU SCRIPT !!!
//
// => personnalisez vos paramètres en DEV / TEST en créant un fichier config_dev.inc.php et y copiant les define à changer
//
// => personnalisez vos paramètres en PRODUCTION en créant un fichier config_prod.inc.php et y copiant les define à changer
// Le fichier "config_prod.inc.php" est par défaut désactivé dans .gitignore pour éviter de le rettrouver sur un dépôt de code public


// **********
// Paramètres de la base de données
// (remplissage obligatoire)
// **********

// serveur de la base de données (localhost par exemple)
if (!defined("DB_HOST"))
    define("DB_HOST", "");

// nom de la base de données
if (!defined("DB_NAME"))
    define("DB_NAME", "");

// utilisateur de la base de données
if (!defined("DB_USER"))
    define("DB_USER", "");

// mot de passe de la base de données
if (!defined("DB_PASS"))
    define("DB_PASS", "");

// **********
// Paramètres liés aux templates
// (à vous de voir)
// **********

// titre du site (utilisé en TITLE du header)
if (!defined("_TitreDuSite"))
    define("_TitreDuSite", "");

// URL du site (penser au "/" final)
if (!defined("_URLDuSite"))
    define("_URLDuSite", "");

// dossier contenant les templates de pages (et leur code)
if (!defined("TemplateFolder"))
    define("TemplateFolder", "tpl");

// dossier contenant les fichiers de fonctions diverses utilisées un peu partout et la connexion à la base de données
if (!defined("ProtectedFolder"))
    define("ProtectedFolder", "protected");

// éditeur du site
if (!defined("CopyrightEditeur"))
    define("CopyrightEditeur", "");

// URL de l'éditeur du site
if (!defined("CopyrightEditeurURL"))
    define("CopyrightEditeurURL", "");

// année de création du site
if (!defined("CopyrightAnnee"))
    define("CopyrightAnnee", "2021");

// **********
// Clés privées, tokens, ... pour signatures et accès divers
// **********

// KEY_SIGNUP : utilisée pour signer l'URL de validation d'inscription
if (!defined("KEY_SIGNUP"))
    define("KEY_SIGNUP", "");

// KEY_PASSWORD : utilisé pour signer les mots de passe dans la base
if (!defined("KEY_PASSWORD"))
    define("KEY_PASSWORD", "");

// KEY_SESSION : utilisé pour sécuriser l'ID de l'utilisateur connecté en session
if (!defined("KEY_SESSION"))
    define("KEY_SESSION", "");

// KEY_SESSION_DROITS : utilisé pour vérifier que les droits d'accès de l'utilisateur connecté n'ont pas été modifiés dans sa session
if (!defined("KEY_SESSION_DROITS"))
    define("KEY_SESSION_DROITS", "");

// KEY_VERIF : clé utilisée pour les calculs de checksum dans les écrans de mise à jour
if (!defined("KEY_VERIF"))
    define("KEY_VERIF", "");

// **********
// Paramètres divers
// **********

// mode débogage du site activé ?
if (!defined("_DEBUG"))
    define("_DEBUG", false);
