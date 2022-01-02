<?php
if ((!defined("REZEMPLOIKEY")) || (REZEMPLOIKEY != "3f5gd4ng2h5j4gh24,gh2j54fd2g54fg2h45")) {
    header("location: index.php");
    exit;
}

require_once(__DIR__ . "/../" . ProtectedFolder . "/utilisateurs.php");
if (!isUtilisateurConnecteEntreprise()) {
    header("location: login.php");
    exit;
}

$PageTitle = "Mes entreprises";
require_once(__DIR__ . "/_header.php");
?><?php
require_once(__DIR__ . "/_footer.php");

// TODO : CRUD sur les entreprises gérées par l'utilisateur connecté
// TODO : CRUD sur les offres d'emploi de chaque entreprise gérée
// TODO : gestion des contacts liés aux offres d'emploi