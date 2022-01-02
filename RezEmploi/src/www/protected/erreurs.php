<?php
if ((!defined("REZEMPLOIKEY")) || (REZEMPLOIKEY != "3f5gd4ng2h5j4gh24,gh2j54fd2g54fg2h45")) {
    header("location: index.php");
    exit;
}

function ajoute_erreur($texte, $champ = "")
{
    global $erreurs;

    if ((!isset($erreurs)) || (!is_array($erreurs))) {
        $erreurs = array();
    }

    if (isset($texte) && (!empty($texte))) {
        $err = new stdClass();
        $err->texte = $texte;
        if (isset($champ) && (!empty($champ))) {
            $err->champ = $champ;
        } else {
            $err->champ = "";
        }
        $erreurs[] = $err;
    }
}
