<?php
if ((!defined("REZEMPLOIKEY")) || (REZEMPLOIKEY != "3f5gd4ng2h5j4gh24,gh2j54fd2g54fg2h45")) {
    header("location: index.php");
    exit;
}

function getMotDePasseChiffre($password, $key)
{
    return sha1($password . $key . KEY_PASSWORD);
}

function ajoute_utilisateur($pseudo, $email, $password)
{
    global $db;
    require_once(__DIR__ . "/fonctions.php");
    $qry = $db->prepare("insert into utilisateurs (priv_key, pseudo, motdepasse, email, actif, creation_IP, creation_timestamp, bloque,droit_superadmin, droit_admin,droit_moderation, droit_particulier, droit_entreprise) values (:pk,:p,:mdp,:e,0,:ci,:cts,0,0,0,0,0,0)");
    $priv_key = generer_identifiant(10);
    $qry->execute(array(":pk" => $priv_key, ":p" => $pseudo, ":mdp" => getMotDePasseChiffre($password, $priv_key), ":e" => $email, ":ci" => $_SERVER["REMOTE_ADDR"], ":cts" => time()));
    $titre = _TitreDuSite . ": activez votre compte";
    $signature = sha1($email . $priv_key . KEY_SIGNUP);
    $msg = "Bonjour " . $pseudo . "\n\nPour activer votre compte, cliquez sur " . _URLDuSite . "signup-go.php?e=" . urlencode($email) . "&k=" . $signature . "\n\nA tout de suite\n";
    mail($email, $titre, $msg, "From: support@olfsoft.com\n");
    if (_DEBUG) addlog($msg);
}

function validation_utilisateur($email, $key)
{
    global $db;
    // recherche de cet utilisateur dans la base de données
    $qry = $db->prepare("select code, email, actif, bloque, priv_key from utilisateurs where email=:email limit 0,1");
    $qry->execute(array(":email" => $email));
    // si pas d'enregistrement => erreur
    if (false === ($res = $qry->fetch(PDO::FETCH_OBJ))) {
        ajoute_erreur("Utilisateur inconnu.");
    } else {
        // si signature de la ligne pas OK => erreur
        $signature = sha1($res->email . $res->priv_key . KEY_SIGNUP);
        if ($key != $signature) {
            ajoute_erreur("Accès refusé. (error 1)");
        } else if (1 == $res->actif) {
            // si utilisateur avec email déjà validé => erreur
            ajoute_erreur("Inscription impossible.");
        } else if (1 == $res->bloque) {
            // si utilisateur avec email déjà bloqué => erreur
            ajoute_erreur("Accès refusé. (error 2)");
        } else {
            // si pas d'erreur, on active l'utilisateur
            $qry = $db->prepare("update utilisateurs set actif=1, activation_IP=:ai, activation_timestamp=:ats, droit_particulier=1 where code=:code");
            $qry->execute(array(":ai" => $_SERVER["REMOTE_ADDR"], ":ats" => time(), ":code" => $res->code));
        }
    }
    return (!(isset($erreurs) && is_array($erreurs) && (count($erreurs) > 0))); // TRUE si ok, FALSE si erreurs
}

function isUtilisateurConnecte()
{
    return isset($_SESSION["utilisateur"]) && isset($_SESSION["key"]) && ($_SESSION["utilisateur"] > 0);
}

function isUtilisateurConnecteSuperAdmin()
{
    return isUtilisateurConnecte() && isset($_SESSION["droit_superadmin"]) && (true === $_SESSION["droit_superadmin"]) && (calculeSignatureDroitsSession($_SESSION["droit_superadmin"], $_SESSION["droit_admin"], $_SESSION["droit_moderation"], $_SESSION["droit_particulier"], $_SESSION["droit_entreprise"]) == $_SESSION["key2"]);
}

function isUtilisateurConnecteAdmin()
{
    return isUtilisateurConnecte() && isset($_SESSION["droit_admin"]) && (true === $_SESSION["droit_admin"]) && (calculeSignatureDroitsSession($_SESSION["droit_superadmin"], $_SESSION["droit_admin"], $_SESSION["droit_moderation"], $_SESSION["droit_particulier"], $_SESSION["droit_entreprise"]) == $_SESSION["key2"]);
}

function isUtilisateurConnecteModeration()
{
    return isUtilisateurConnecte() && isset($_SESSION["droit_moderation"]) && (true === $_SESSION["droit_moderation"]) && (calculeSignatureDroitsSession($_SESSION["droit_superadmin"], $_SESSION["droit_admin"], $_SESSION["droit_moderation"], $_SESSION["droit_particulier"], $_SESSION["droit_entreprise"]) == $_SESSION["key2"]);
}

function isUtilisateurConnecteParticulier()
{
    return isUtilisateurConnecte() && isset($_SESSION["droit_particulier"]) && (true === $_SESSION["droit_particulier"]) && (calculeSignatureDroitsSession($_SESSION["droit_superadmin"], $_SESSION["droit_admin"], $_SESSION["droit_moderation"], $_SESSION["droit_particulier"], $_SESSION["droit_entreprise"]) == $_SESSION["key2"]);
}

function isUtilisateurConnecteEntreprise()
{
    return isUtilisateurConnecte() && isset($_SESSION["droit_entreprise"]) && (true === $_SESSION["droit_entreprise"]) && (calculeSignatureDroitsSession($_SESSION["droit_superadmin"], $_SESSION["droit_admin"], $_SESSION["droit_moderation"], $_SESSION["droit_particulier"], $_SESSION["droit_entreprise"]) == $_SESSION["key2"]);
}

$UtilisateurConnecte_dkhdfklhj = false;
function getUtilisateurConnecte()
{
    global $db, $UtilisateurConnecte_dkhdfklhj;
    if (isUtilisateurConnecte()) {
        if (false !== $UtilisateurConnecte_dkhdfklhj) {
            if ($_SESSION["utilisateur"] == $UtilisateurConnecte_dkhdfklhj->code) {
                return $UtilisateurConnecte_dkhdfklhj;
            } else {
                $UtilisateurConnecte_dkhdfklhj = false;
            }
        }
        if (false == $UtilisateurConnecte_dkhdfklhj) {
            $qry = $db->prepare("select * from utilisateurs where code=:c");
            $qry->execute(array(":c" => $_SESSION["utilisateur"]));
            if ((false !== ($utilisateur = $qry->fetch(PDO::FETCH_OBJ))) && (sha1($utilisateur->code . $utilisateur->priv_key . KEY_SESSION) == $_SESSION["key"])) {
                // Vérification que les droits utilisateur sont toujours les bons par rapport à la session
                $sa = isset($utilisateur->droit_superadmin) ? (1 == $utilisateur->droit_superadmin) : false;
                $a = isset($utilisateur->droit_admin) ? (1 == $utilisateur->droit_admin) : false;
                $m = isset($utilisateur->droit_moderation) ? (1 == $utilisateur->droit_moderation) : false;
                $p = isset($utilisateur->droit_particulier) ? (1 == $utilisateur->droit_particulier) : false;
                $e = isset($utilisateur->droit_entreprise) ? (1 == $utilisateur->droit_entreprise) : false;
                if (!(calculeSignatureDroitsSession($sa, $a, $m, $p, $e) == $_SESSION["key2"])) {
                    deconnexion_utilisateur();
                    return false;
                } else {
                    // renvoi de l'utlisateur si tout est ok
                    $UtilisateurConnecte_dkhdfklhj = $utilisateur;
                    return $utilisateur;
                }
            } else {
                return false;
            }
        }
    } else {
        return false;
    }
}

function calculeSignatureDroitsSession($sa, $a, $m, $p, $e)
{
    if (isset($_SESSION["key"]) && ("" != $_SESSION["key"])) {
        return sha1($_SESSION["key"] . ($sa ? "SuperAdmin" : "") . ($a ? "Admin" : "") . ($m ? "Moderateur" : "") . ($p ? "Particulier" : "") . ($e ? "Entreprise" : "") . KEY_SESSION_DROITS);
    } else {
        return false;
    }
}

function connexion_utilisateur($utilisateur)
{
    if (is_object($utilisateur) && isset($utilisateur->code) && isset($utilisateur->priv_key) && ($utilisateur->code > 0)) {
        $_SESSION["utilisateur"] = $utilisateur->code;
        $_SESSION["key"] = sha1($utilisateur->code . $utilisateur->priv_key . KEY_SESSION);
        $sa = isset($utilisateur->droit_superadmin) ? (1 == $utilisateur->droit_superadmin) : false;
        $_SESSION["droit_superadmin"] = $sa;
        $a = isset($utilisateur->droit_admin) ? (1 == $utilisateur->droit_admin) : false;
        $_SESSION["droit_admin"] = $a;
        $m = isset($utilisateur->droit_moderation) ? (1 == $utilisateur->droit_moderation) : false;
        $_SESSION["droit_moderation"] = $m;
        $p = isset($utilisateur->droit_particulier) ? (1 == $utilisateur->droit_particulier) : false;
        $_SESSION["droit_particulier"] = $p;
        $e = isset($utilisateur->droit_entreprise) ? (1 == $utilisateur->droit_entreprise) : false;
        $_SESSION["droit_entreprise"] = $e;
        $_SESSION["key2"] = calculeSignatureDroitsSession($sa, $a, $m, $p, $e);
        return true;
    } else {
        return false;
    }
}

function deconnexion_utilisateur()
{
    if (isset($_SESSION["utilisateur"])) unset($_SESSION["utilisateur"]);
    if (isset($_SESSION["key"])) unset($_SESSION["key"]);
    if (isset($_SESSION["droit_superadmin"])) unset($_SESSION["droit_superadmin"]);
    if (isset($_SESSION["droit_admin"])) unset($_SESSION["droit_admin"]);
    if (isset($_SESSION["droit_moderation"])) unset($_SESSION["droit_moderation"]);
    if (isset($_SESSION["droit_particulier"])) unset($_SESSION["droit_particulier"]);
    if (isset($_SESSION["droit_entreprise"])) unset($_SESSION["droit_entreprise"]);
    if (isset($_SESSION["key2"])) unset($_SESSION["key2"]);
    session_destroy();
    @session_start();
}