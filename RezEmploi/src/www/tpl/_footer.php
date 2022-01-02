<?php
if ((!defined("REZEMPLOIKEY")) || (REZEMPLOIKEY != "3f5gd4ng2h5j4gh24,gh2j54fd2g54fg2h45")) {
    header("location: index.php");
    exit;
}

require_once(__DIR__ . "/../" . ProtectedFolder . "/utilisateurs.php");

?>
<footer class="fdb-block footer-small bg-dark">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-8">
                <ul class="nav justify-content-center justify-content-md-start">
                    <li class="nav-item">
                        <a class="nav-link active"
                           href="<?php print(isUtilisateurConnecte() ? "index-membre.php" : "index.php"); ?>">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cgu.php">CGU</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cgv.php">CGV</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="infoslegales.php">Mentions légales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Nous contacter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="apropos.php">A propos</a>
                    </li>
                </ul>
            </div>

            <div class="col-12 col-md-4 mt-4 mt-md-0 text-center text-md-right">
                &copy <?php print(("" != CopyrightEditeurURL) ? "<a href=\"" . CopyrightEditeurURL . "\">" : ""); ?><?php print(CopyrightEditeur); ?><?php print(("" != CopyrightEditeurURL) ? "</a>" : ""); ?> <?php print((CopyrightAnnee != ($annee = date("Y"))) ? CopyrightAnnee . "-" . $annee : CopyrightAnnee); ?>
            </div>
        </div>
    </div>
</footer>
</body>
</html>