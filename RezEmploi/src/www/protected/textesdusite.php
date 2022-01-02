<?php
if ((!defined("REZEMPLOIKEY")) || (REZEMPLOIKEY != "3f5gd4ng2h5j4gh24,gh2j54fd2g54fg2h45")) {
    header("location: index.php");
    exit;
}

function getTexteDuSite($emplacement, &$titre, &$texte)
{
    global $db;

    $titre = "";
    $texte = "";

    if (empty(trim($emplacement))) {
        return false;
    } else {
        $qry = $db->prepare("select * from textes where libelle=:e");
        $qry->execute(array(":e" => $emplacement));
        if (false !== ($record = $qry->fetch(PDO::FETCH_OBJ))) {
            $titre = $record->titre;
            $texte = $record->texte;
            return true;
        } else {
            return false;
        }
    }
}
