<?php
if ((!defined("REZEMPLOIKEY")) || (REZEMPLOIKEY != "3f5gd4ng2h5j4gh24,gh2j54fd2g54fg2h45")) {
    header("location: index.php");
    exit;
}

$PageTitle = "Contacter " . _TitreDuSite;
require_once(__DIR__ . "/_header.php");
require_once(__DIR__ . "/../" . ProtectedFolder . "/textesdusite.php");
?>
    <form action="contact.php" method="post" id="frm">
    <input type="hidden" name="op" id="op" value="contact">
    <section class="fdb-block py-0">
        <div class="container py-5 my-5" style="background-image: url(imgs/shapes/9.svg);">
            <div class="row py-5">
                <div class="col py-5">
                    <div class="fdb-box fdb-touch">
                        <div class="row text-center justify-content-center">
                            <div class="col-12 col-md-9 col-lg-7"><?php
                                if (getTexteDuSite("contact-haut", $titre, $texte)) {
                                    if (!empty($titre)) print("<h1>" . $titre . "</h1>");
                                    print($texte);
                                } else {
                                    require_once(__DIR__ . "/../" . ProtectedFolder . "/erreurs.php");
                                    ajoute_erreur("Page \"contact-haut\" non trouvée.");
                                } ?>
                            </div>
                        </div>

                        <div class="row justify-content-center pt-4">
                            <div class="col-12 col-md-8">
                                <div class="row">
                                    <div class="col-12 col-md">
                                        <input type="text" class="form-control" placeholder="Name">
                                    </div>
                                    <div class="col-12 col-md mt-4 mt-md-0">
                                        <input type="text" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col">
                                        <input type="email" class="form-control" placeholder="Subject">
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col">
                                            <textarea class="form-control" name="message" rows="3"
                                                      placeholder="How can we help?"></textarea>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col text-center">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div><?php
                                if (getTexteDuSite("contact-bas", $titre, $texte)) {
                                    if (!empty($titre)) print("<h1>" . $titre . "</h1>");
                                    print($texte);
                                } else {
                                    require_once(__DIR__ . "/../" . ProtectedFolder . "/erreurs.php");
                                    ajoute_erreur("Page \"contact-bas\" non trouvée.");
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section></form><?php
require_once(__DIR__ . "/_erreur-bloc-html.php");
require_once(__DIR__ . "/_footer.php");

// TODO : gérer le formulaire de contact