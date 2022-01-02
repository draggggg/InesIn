<?php
define("REZEMPLOIKEY", "3f5gd4ng2h5j4gh24,gh2j54fd2g54fg2h45");

if (("127.0.0.1" == $_SERVER["SERVER_ADDR"]) || ("::1" == $_SERVER["SERVER_ADDR"])) {
    /* accès en local (dev, test) */
    @include_once(__DIR__ . "/config-dev.inc.php");
} else {
    /* accès sur serveur (production) */
    @include_once(__DIR__ . "/config-prod.inc.php");
}
require_once(__DIR__ . "/config-dist.inc.php");

require_once(__DIR__ . "/" . ProtectedFolder . "/db_inc.php");

if (is_object($db)) {

    // On récupère l'URL
    if (isset($_SERVER["REDIRECT_URL"])) {
        $page_demandee = $_SERVER["REDIRECT_URL"];
    } elseif (isset($_SERVER["REQUEST_URI"])) {
        $page_demandee = $_SERVER["REQUEST_URI"];
    } else {
        $page_demandee = "inconnue";
    }
    //print($page_demandee . "<br>");

    // On retire les paramètres de l'url récupérée
    if (false !== ($pos = strpos($page_demandee, '?'))) {
        $page_demandee = substr($page_demandee, 0, $pos);
    }

    // On retire le chemin vers le fichier (donc théoriquement on n'a plus que le fichier demandé à la fin)
    while (false !== ($pos = strrpos($page_demandee, '/'))) {
        $page_demandee = substr($page_demandee, $pos + 1);
    }
//    print("x" . $page_demandee . "x");

    // Si pas de fichier demandé ou fchier index.php, on bascule sur la page "index-public.php" qui correspond au template de l'accueil du site
    if (("" == $page_demandee) || ("index.php" == $page_demandee)) $page_demandee = "index-public.php";

    // On retire les caractères "douteux" du nom du fichier demandé pour être sereins lors de l'accès au disque dur
    for ($i = 0; $i < strlen($page_demandee) - 1; $i++) {
        $c = substr($page_demandee, $i, 1);
        if (!((($c >= 'a') && ($c <= 'z')) || (($c >= '0') && ($c <= '9')) || ('.' == $c) || ('-' == $c) || ('_' == $c))) {
            $page_demandee = "";
        }
    }
    //print($page_demandee . "<br>");

    // Initialisation des variables globales utilisées au niveau des templates
    $PageTitle = ""; // Titre de la page utilisé dans l'entête
    $erreurs = array(); // messages d'erreur à afficher (formulaires ou blocs HTML)
    $infos = array(); // messages d'info à afficher (blocs HTML)
    $alertes = array();// messages d'alertes à afficher (blocs HTML) => sert par exemple pour signaler qu'une opération reste à faire lors d'un process

    // Appel de la page demandée ou sortie en erreur
    if ((!empty($page_demandee)) && file_exists(__DIR__ . "/" . TemplateFolder . "/" . $page_demandee)) {
        require_once(__DIR__ . "/" . TemplateFolder . "/" . $page_demandee);
    } elseif (file_exists(__DIR__ . "/" . TemplateFolder . "/404notfound.php")) {
        require_once(__DIR__ . "/" . TemplateFolder . "/404notfound.php");
    } else {
        http_response_code(404);
    }
} else {
    http_response_code(404);
}