<?php
if ((!defined("REZEMPLOIKEY")) || (REZEMPLOIKEY != "3f5gd4ng2h5j4gh24,gh2j54fd2g54fg2h45")) {
    header("location: index.php");
    exit;
}

http_response_code(404);

$PageTitle = "Page inconnue";
require_once(__DIR__ . "/_header.php");
require_once(__DIR__ . "/../" . ProtectedFolder . "/erreurs.php");
ajoute_erreur("Page non trouvée.");
require_once(__DIR__ . "/_erreur-bloc-html.php");
require_once(__DIR__ . "/_footer.php");
