<?php
if ((!defined("REZEMPLOIKEY")) || (REZEMPLOIKEY != "3f5gd4ng2h5j4gh24,gh2j54fd2g54fg2h45")) {
    header("location: index.php");
    exit;
}

require_once(__DIR__ . "/../" . ProtectedFolder . "/utilisateurs.php");
if (isUtilisateurConnecte()) {
    header("location: index-membre.php");
    exit;
}

$op = isset($_POST["op"]) ? $_POST["op"] : "";

if ("signup" == $op) {
    require_once(__DIR__ . "/../" . ProtectedFolder . "/erreurs.php");

    $pseudo = isset($_POST["pseudo"]) ? trim(strip_tags($_POST["pseudo"])) : "";
    if (empty($pseudo)) {
        ajoute_erreur("Veuillez saisir votre pseudo.\n", "pseudo");
    }
    // TODO : ajouter des contraintes sur le pseudo (longueur minimale par exemple)
    // TODO : s'assurer que le pseudo n'existe pas encore dans la base de données

    $email = isset($_POST["mail"]) ? trim(strip_tags($_POST["mail"])) : "";
    if (empty($email)) {
        ajoute_erreur("Veuillez saisir votre adresse mail.\n", "mail");
    }
    // TODO : vérifier cohérence de l'adresse email (est-ce vraiment une adresse, voir REGEX)
    // TODO : s'assurer que l'adresse email n'est pas déjà sur un compte utilisateur (voir le cas de l'utilisateur pas encore activé qui redemande une inscription)

    $password = isset($_POST["pass"]) ? trim(strip_tags($_POST["pass"])) : "";
    if (empty($password)) {
        ajoute_erreur("Veuillez saisir votre mot de passe.\n", "pass");
    }
    // TODO : ajouter des contraintes à la saisie du mot de passe (longueur, caractères minuscules, majuscules, ...)
    // TODO : vérifier que le mot de passe est différent du pseudo et de l'email

    if (count($erreurs) < 1) {
        require_once(__DIR__ . "/../" . ProtectedFolder . "/utilisateurs.php");
        ajoute_utilisateur($pseudo, $email, $password);
        header("location: signup-wait.php");
        exit;
    } else {
        // TODO : s'assurer qu'on est pas victime d'un bot (vérifier que l'IP n'a pas déjà servi pour une création en moins de X jours/heures/minutes/secondes)
    }
}

require_once(__DIR__ . "/_header.php");
?>
    <form action="signup.php" method="post">
        <input type="hidden" name="op" value="signup">
        <section class="fdb-block">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-7 col-md-5 text-center">
                        <div class="fdb-box fdb-touch">
                            <div class="row">
                                <div class="col">
                                    <h1>Register</h1>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-4">
                                    <input type="text" class="form-control" placeholder="Pseudo" id="pseudo"
                                           name="pseudo"
                                           value="<?php print(isset($pseudo) ? htmlentities($pseudo) : ""); ?>"
                                           autofocus>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col">
                                    <input type="email" class="form-control" placeholder="Email" id="mail" name="mail"
                                           value="<?php print(isset($email) ? htmlentities($email) : ""); ?>">
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col">
                                    <input type="password" class="form-control mb-1" placeholder="Password" id="pass"
                                           name="pass">
                                    <p class="text-right"><a href="login.php">Already have an account?</a></p>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
<?php
if (isset($erreurs) && is_array($erreurs) && (count($erreurs) > 0)) {
    require_once(__DIR__ . "/_erreur-formulaire.php");
}
require_once(__DIR__ . "/_footer.php");