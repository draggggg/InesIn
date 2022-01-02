<?php
if ((!defined("REZEMPLOIKEY")) || (REZEMPLOIKEY != "3f5gd4ng2h5j4gh24,gh2j54fd2g54fg2h45")) {
    header("location: index.php");
    exit;
}

require_once(__DIR__ . "/../" . ProtectedFolder . "/utilisateurs.php");
if (isUtilisateurConnecte()) {
    header("location: index-membre.php");
    exit;
}

// appelé par http://localhost/RezEmploi/src/www/signup-go.php?e=emaildelutilisateuraactiver&k=73a8e35adb5e75b1b929d1e9f5a088c1a3968c61

require_once(__DIR__ . "/../" . ProtectedFolder . "/erreurs.php");

$email = isset($_GET["e"]) ? trim(strip_tags($_GET["e"])) : "";
if (empty($email)) {
    // TODO : pas d'email en paramètre => lien bidon => affichage d'une erreur
    ajoute_erreur("Veuillez saisir votre pseudo.\n", "pseudo");
}

$key = isset($_GET["k"]) ? trim($_GET["k"]) : "";
if (empty($key)) {
    // TODO : pas de clé en paramètre => lien bidon => affichage d'une erreur
    ajoute_erreur("Veuillez saisir votre pseudo.\n", "pseudo");
}

if (count($erreurs) < 1) {
    require_once(__DIR__ . "/../" . ProtectedFolder . "/utilisateurs.php");
    validation_utilisateur($email, $key);
}

require_once(__DIR__ . "/_header.php");
if (isset($erreurs) && is_array($erreurs) && (count($erreurs) > 0)) {
    // Des erreurs par rapport à l'email, l'URL de validation ou ses paramètres
    require_once(__DIR__ . "/_erreur-bloc-html.php");
} else {
    // Pas d'erreur, on affiche un écran de confirmation d'inscription
    require_once(__DIR__ . "/../" . ProtectedFolder . "/infos.php");
    ajoute_info("Utilisateur créé.\nVous pouvez vous connecter.");
    require_once(__DIR__ . "/_info-bloc-html.php");
}
require_once(__DIR__ . "/_footer.php");
