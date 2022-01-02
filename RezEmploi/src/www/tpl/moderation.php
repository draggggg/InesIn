<?php
if ((!defined("REZEMPLOIKEY")) || (REZEMPLOIKEY != "3f5gd4ng2h5j4gh24,gh2j54fd2g54fg2h45")) {
    header("location: index.php");
    exit;
}

require_once(__DIR__ . "/../" . ProtectedFolder . "/utilisateurs.php");
if (!isUtilisateurConnecteModeration()) {
    header("location: login.php");
    exit;
}

$PageTitle = "Modération";
require_once(__DIR__ . "/_header.php");
?><?php
require_once(__DIR__ . "/_footer.php");

// TODO : modération des offres d'emploi (avant mise en ligne)
// TODO : modération des actualités des membres (avant ou après mise en ligne)
// TODO : modération des photos des membres (avant mise en ligne)
// TODO : modération des logos d'entreprises (avant mise en ligne)
// TODO : modération des fiches (et modifications de fiches) d'entreprises (avant mise en ligne)
// TODO : modération des publicités (avant mise en ligne)
// TODO : modération des contenus signalés
