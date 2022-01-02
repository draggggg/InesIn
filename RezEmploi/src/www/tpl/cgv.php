<?php
if ((!defined("REZEMPLOIKEY")) || (REZEMPLOIKEY != "3f5gd4ng2h5j4gh24,gh2j54fd2g54fg2h45")) {
    header("location: index.php");
    exit;
}

$PageTitle = "Conditions générales de vente de " . _TitreDuSite;
require_once(__DIR__ . "/_header.php");
require_once(__DIR__ . "/../" . ProtectedFolder . "/textesdusite.php"); ?>
    <section class="fdb-block py-0">
    <div class="container py-5 my-5" style="background-image: url(imgs/shapes/9.svg);">
        <div class="row py-5">
            <div class="col py-5">
                <div class="fdb-box fdb-touch">
                    <div class="row text-center justify-content-center">
                        <div class="col-12 col-md-9 col-lg-7"><?php
                            if (getTexteDuSite("cgv", $titre, $texte)) {
                                if (!empty($titre)) print("<h1>" . $titre . "</h1>");
                                print($texte);
                            } else {
                                require_once(__DIR__ . "/../" . ProtectedFolder . "/erreurs.php");
                                ajoute_erreur("Page \"cgv\" non trouvée.");
                            } ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div></section><?php
require_once(__DIR__ . "/_erreur-bloc-html.php");
require_once(__DIR__ . "/_footer.php");