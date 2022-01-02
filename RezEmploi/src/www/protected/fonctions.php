<?php
if ((!defined("REZEMPLOIKEY")) || (REZEMPLOIKEY != "3f5gd4ng2h5j4gh24,gh2j54fd2g54fg2h45")) {
    header("location: index.php");
    exit;
}

function generer_identifiant($taille = 10)
{
    $id = "";
    for ($j = 0; $j < $taille / 5; $j++) {
        $num = mt_rand(0, 99999);
        for ($i = 0; $i < 5; $i++) {
            $id = ($num % 10) . $id;
            $num = floor($num / 10);
        }
    }
    return (substr($id, 0, $taille));
}

function addlog($msg)
{
    if (_DEBUG) {
        $f = fopen(__DIR__ . "/../temp/log-" . date("Ymd") . ".txt", "a");
        fwrite($f, date("YmdHis") . " " . $msg);
        fwrite($f, "------------------------------");
        fclose($f);
    }
}

// Fonctions de calcul de checksum et de contrôle du résultat
// https://trucs-de-developpeur-web.fr/p/_3002-calculer-et-verifier-un-checksum-pour-dialoguer-avec-l-exterieur.html

// return a checksum value for "verif" URL param
function getVerifChecksum($param, $key1 = "", $key2 = "", $key3 = "", $key4 = "", $key5 = "", $public = true)
{
    $verif = "";
    if (is_array($param)) {
        $par = "";
        foreach ($param as $value) {
            $par .= $value;
        }
        $verif = md5($par . $key1 . $key2 . $key3 . $key4 . $key5);
    } else {
        $verif = md5($param . $key1 . $key2 . $key3 . $key4 . $key5);
    }
    return ($public) ? substr($verif, mt_rand(0, strlen($verif) - 10), 10) : $verif;
}

// check a "verif" checksum value
// return TRUE if ok, FALSE if not
function checkVerifChecksum($verif, $param, $key1 = "", $key2 = "", $key3 = "", $key4 = "", $key5 = "")
{
    if ((strlen($verif) < 1) && isset($_POST["verif"])) {
        $verif = $_POST["verif"];
    }
    if ((strlen($verif) < 1) && isset($_GET["verif"])) {
        $verif = $_GET["verif"];
    }
    return (false !== strpos(getVerifChecksum($param, $key1, $key2, $key3, $key4, $key5, false), $verif));
}