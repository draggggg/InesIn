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

if ("recover" == $op) {
    require_once(__DIR__ . "/../" . ProtectedFolder . "/erreurs.php");

    $pseudo = isset($_POST["pseudo"]) ? trim(strip_tags($_POST["pseudo"])) : "";

    $email = isset($_POST["mail"]) ? trim(strip_tags($_POST["mail"])) : "";

    if (!empty($pseudo)) { // Regénération du mot de passe
        // TODO : contrôles du pseudo
        // TODO : recherche de l'utilisateur dans la base de données pour ce pseudo
        // TODO : si utilisateur ok (non bloqué), envoyer un email avec redirection vers page de changement de mot de passe
        // TODO : sinon afficher une erreur disant que l'utilisateur n'est pas accessible
    } else if (!empty($email)) { // Envoi du pseudo par email
        // TODO : contrôles de l'email
        // TODO : chercher l'utilisateur dans la base de données
        // TODO : si utilisateur ok, on envoi un email à son adresse avec son pseudo et un lien vers la page en cours
        // TODO : sinon afficher une erreur disant que l'email n'est pas accessible
    } else {
        ajoute_erreur("Indiquez votre pseudo (pour changer de mot de passe) ou votre email (pour retrouver votre pseudo).\n", "pseudo");
    }
}

require_once(__DIR__ . "/_header.php");
?>
    <form action="motdepasseoublie.php" method="post">
        <input type="hidden" name="op" value="recover">
        <section class="fdb-block">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-7 col-xl-5 text-center">
                        <div class="fdb-box fdb-touch">
                            <div class="row">
                                <div class="col">
                                    <h1>Recover password</h1>
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
