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

if ("login" == $op) {
    require_once(__DIR__ . "/../" . ProtectedFolder . "/erreurs.php");

    $pseudo = isset($_POST["pseudo"]) ? trim(strip_tags($_POST["pseudo"])) : "";
    if (empty($pseudo)) {
        ajoute_erreur("Veuillez saisir votre pseudo.\n", "pseudo");
    }

    $password = isset($_POST["pass"]) ? trim(strip_tags($_POST["pass"])) : "";
    if (empty($password)) {
        ajoute_erreur("Veuillez saisir votre mot de passe.\n", "pass");
    }

    if (count($erreurs) < 1) {
        require_once(__DIR__ . "/../" . ProtectedFolder . "/utilisateurs.php");
        $qry = $db->prepare("select * from utilisateurs where pseudo=:p");
        $qry->execute(array(":p" => $pseudo));
        if ((false !== ($res = $qry->fetch(PDO::FETCH_OBJ))) && (getMotDePasseChiffre($password, $res->priv_key) == $res->motdepasse) && (1 == $res->actif) && (0 == $res->bloque)) {
// connexion de l'utilisateur autorisée
            if (connexion_utilisateur($res)) {
                header("location: index-membre.php");
                exit;
            } else {
                ajoute_erreur("Erreur de connexion.");
            }
        } else {
// erreur à la connexion (enregistrement non trouvé, mot de passe erroné, utilisateur non activé ou bloqué)
            ajoute_erreur("Connexion refusée.", "pseudo");
        }
    } else {
        // TODO : s'assurer qu'on est pas victime d'un bot (vérifier que l'IP n'a pas déjà servi pour une création en moins de X jours/heures/minutes/secondes)
    }
}

require_once(__DIR__ . "/_header.php");
?>
    <form action="login.php" method="post">
        <input type="hidden" name="op" value="login">
        <section class="fdb-block">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-7 col-xl-5 text-center">
                        <div class="fdb-box fdb-touch">
                            <div class="row">
                                <div class="col">
                                    <h1>Log In</h1>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Pseudo" id="pseudo"
                                           name="pseudo"
                                           value="<?php print(isset($pseudo) ? htmlentities($pseudo) : ""); ?>"
                                           autofocus>
                                </div>
                            </div>
                            <div class=" row mt-4">
                                <div class="col">
                                    <input type="password" class="form-control mb-1" placeholder="Password"
                                           id="pass"
                                           name="pass">
                                    <p class="text-right"><a href="motdepasseoublie.php">Recover Password</a></p>
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
