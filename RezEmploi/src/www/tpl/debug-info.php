<?php
if ((!defined("REZEMPLOIKEY")) || (REZEMPLOIKEY != "3f5gd4ng2h5j4gh24,gh2j54fd2g54fg2h45")) {
    header("location: index.php");
    exit;
}
// Interdit l'affichage de la page si le site n'est pas en mode débogage
if (!_DEBUG) {
    header("location: index.php");
    exit;
}

//$PageTitle = "RezEmploi";
require_once(__DIR__ . "/_header.php");
print('<h3>$_SESSION</h3>');
var_dump($_SESSION);
print("<h3>isUtilisateurConnecte</h3>");
var_dump(isUtilisateurConnecte());
print("<h3>isUtilisateurConnecteSuperAdmin</h3>");
var_dump(isUtilisateurConnecteSuperAdmin());
print("<h3>isUtilisateurConnecteAdmin</h3>");
var_dump(isUtilisateurConnecteAdmin());
print("<h3>isUtilisateurConnecteModeration</h3>");
var_dump(isUtilisateurConnecteModeration());
print("<h3>isUtilisateurConnecteParticulier</h3>");
var_dump(isUtilisateurConnecteParticulier());
print("<h3>isUtilisateurConnecteEntreprise</h3>");
var_dump(isUtilisateurConnecteEntreprise());
print("<h3>getUtilisateurConnecte</h3>");
var_dump(getUtilisateurConnecte());
print("<h3>Boutons mis en forme</h3>");
?>
    <button type="button" class="btn btn-primary">Primary</button>
    <button type="button" class="btn btn-secondary">Secondary</button>
    <button type="button" class="btn btn-success">Success</button>
    <button type="button" class="btn btn-danger">Danger</button>
    <button type="button" class="btn btn-warning">Warning</button>
    <button type="button" class="btn btn-info">Info</button>
    <button type="button" class="btn btn-light">Light</button>
    <button type="button" class="btn btn-dark">Dark</button>
    <button type="button" class="btn btn-link">Link</button><?php
require_once(__DIR__ . "/_footer.php");
