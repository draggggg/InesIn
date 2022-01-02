<?php
if ((!defined("REZEMPLOIKEY")) || (REZEMPLOIKEY != "3f5gd4ng2h5j4gh24,gh2j54fd2g54fg2h45")) {
    header("location: index.php");
    exit;
}

function ajoute_info($texte)
{
    global $infos;

    if ((!isset($infos)) || (!is_array($infos))) {
        $infos = array();
    }

    if (isset($texte) && (!empty($texte))) {
        $info = new stdClass();
        $info->texte = $texte;
        $infos[] = $info;
    }
}
