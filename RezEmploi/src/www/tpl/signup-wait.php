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

$PageTitle = "Inscription en attente";
require_once(__DIR__ . "/_header.php");
if (isset($erreurs) && is_array($erreurs) && (count($erreurs) > 0)) {
    // Des erreurs par rapport à l'email, l'URL de validation ou ses paramètres
    require_once(__DIR__ . "/_erreur-bloc-html.php");
} else {
    // Pas d'erreur, on affiche un écran de confirmation d'inscription
    require_once(__DIR__ . "/../" . ProtectedFolder . "/alertes.php");
    ajoute_alerte("Inscription en attente.\n\nVeuillez cliquer sur le lien reçu par email.");
    require_once(__DIR__ . "/_alerte-bloc-html.php");
}
require_once(__DIR__ . "/_footer.php");
