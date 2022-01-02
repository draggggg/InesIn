<?php
if ((!defined("REZEMPLOIKEY")) || (REZEMPLOIKEY != "3f5gd4ng2h5j4gh24,gh2j54fd2g54fg2h45")) {
    header("location: index.php");
    exit;
}

function ajoute_alerte($texte)
{
    global $alertes;

    if ((!isset($alertes)) || (!is_array($alertes))) {
        $alertes = array();
    }

    if (isset($texte) && (!empty($texte))) {
        $alerte = new stdClass();
        $alerte->texte = $texte;
        $alertes[] = $alerte;
    }
}
