<?php
if ((!defined("REZEMPLOIKEY")) || (REZEMPLOIKEY != "3f5gd4ng2h5j4gh24,gh2j54fd2g54fg2h45")) {
    header("location: index.php");
    exit;
}

if (isset($alertes) && is_array($alertes) && (count($alertes) > 0)) {
    ?>
    <section class="fdb-block" style="background-image: url(imgs/hero/yellow.svg);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <div class="fdb-box"><?php
                    for ($i = 0; $i < count($alertes); $i++) {
                        print("<p>" . nl2br(htmlentities($alertes[$i]->texte)) . "</p>");
                    }
                    ?></div>
            </div>
        </div>
    </div>
    </section><?php
}