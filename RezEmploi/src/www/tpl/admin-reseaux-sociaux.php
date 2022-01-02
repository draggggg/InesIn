<?php
if ((!defined("REZEMPLOIKEY")) || (REZEMPLOIKEY != "3f5gd4ng2h5j4gh24,gh2j54fd2g54fg2h45")) {
    header("location: index.php");
    exit;
}

require_once(__DIR__ . "/../" . ProtectedFolder . "/utilisateurs.php");
if ((!isUtilisateurConnecteAdmin()) && (!isUtilisateurConnecteSuperAdmin())) {
    header("location: login.php");
    exit;
}

// Opération demandée (CRUD)
$op = isset($_POST["op"]) ? $_POST["op"] : "";

// Affichage ("1") ou gestion du formulaire envoyé ("0" ou rien)
$dsp = (isset($_POST["dsp"]) ? $_POST["dsp"] : "0") == "1";

// checksum généré lors de l'appel précédent de la page
$verif = isset($_POST["v"]) ? $_POST["v"] : "";

require_once(__DIR__ . "/../" . ProtectedFolder . "/infos.php");
require_once(__DIR__ . "/../" . ProtectedFolder . "/erreurs.php");
require_once(__DIR__ . "/../" . ProtectedFolder . "/fonctions.php");

$mode = $op;
if (("add" == $op) && $dsp) {
    // affichage de la page en ajout
    $code = -1;
    $libelle = "";
} else if ("add" == $op) {
    // traitement des infos passées en ajout
    $libelle = isset($_POST["libelle"]) ? trim(strip_tags($_POST["libelle"])) : "";
    if (empty($libelle)) {
        ajoute_erreur("Libellé obligatoire.", "libelle");
    } else {
        $qry = $db->prepare("insert into reseaux_sociaux (priv_key, libelle) values (:pk, :l)");
        $qry->execute(array(":pk" => generer_identifiant(10), ":l" => $libelle));
        ajoute_info("\"" . $libelle . "\" ajouté.");
        $mode = "add";
        $libelle = "";
    }
} else if (("chg" == $op) && $dsp) {
    // affichage de la page en modification
    $code = intval(isset($_POST["code"]) ? $_POST["code"] : "-1");
    $qry = $db->prepare("select * from reseaux_sociaux where code=:c");
    $qry->execute(array(":c" => $code));
    if (false !== ($record = $qry->fetch(PDO::FETCH_OBJ))) {
        $libelle = $record->libelle;
        $priv_key = $record->priv_key;
    } else {
        ajoute_erreur("Enregistrement inexistant, modification impossible.");
        $mode = "lst";
    }
} else if ("chg" == $op) {
    // traitement des infos passées en modification
    $code = intval(isset($_POST["code"]) ? $_POST["code"] : "-1");
    $libelle = isset($_POST["libelle"]) ? trim(strip_tags($_POST["libelle"])) : "";
    if (empty($libelle)) {
        ajoute_erreur("Libellé obligatoire.", "libelle");
    } else {
        $qry = $db->prepare("select * from reseaux_sociaux where code=:c");
        $qry->execute(array(":c" => $code));
        if ((false !== ($record = $qry->fetch(PDO::FETCH_OBJ))) && checkVerifChecksum($verif, KEY_VERIF, $record->code, $record->priv_key)) {
            if ($libelle != $record->libelle) {
                $qry = $db->prepare("update reseaux_sociaux set libelle=:l where code=:c");
                $qry->execute(array(":c" => $code, ":l" => $libelle));
            }
            $mode = "lst";
        } else {
            ajoute_erreur("Enregistrement inexistant, modification impossible.");
            $mode = "lst";
        }
    }
} else if (("dlt" == $op) && $dsp) {
    // affichage de la page en suppression
    $code = intval(isset($_POST["code"]) ? $_POST["code"] : "-1");
    $qry = $db->prepare("select * from reseaux_sociaux where code=:c");
    $qry->execute(array(":c" => $code));
    if (false !== ($record = $qry->fetch(PDO::FETCH_OBJ))) {
        $libelle = $record->libelle;
        $priv_key = $record->priv_key;
    } else {
        ajoute_erreur("Enregistrement inexistant, suppression impossible.");
        $mode = "lst";
    }
} else if ("dlt" == $op) {
    // traitement des infos passées en suppression
    $code = intval(isset($_POST["code"]) ? $_POST["code"] : "-1");
    $qry = $db->prepare("select * from reseaux_sociaux where code=:c");
    $qry->execute(array(":c" => $code));
    if ((false !== ($record = $qry->fetch(PDO::FETCH_OBJ))) && checkVerifChecksum($verif, KEY_VERIF, $record->code, $record->priv_key)) {
        $qry = $db->prepare("delete from reseaux_sociaux where code=:c");
        $qry->execute(array(":c" => $code));
        $mode = "lst";
    } else {
        ajoute_erreur("Enregistrement inexistant, suppression impossible.");
        $mode = "lst";
    }
} else if (("dsp" == $op) && $dsp) {
    // affichage de la page en détail
    $code = intval(isset($_POST["code"]) ? $_POST["code"] : "-1");
    $qry = $db->prepare("select * from reseaux_sociaux where code=:c");
    $qry->execute(array(":c" => $code));
    if (false !== ($record = $qry->fetch(PDO::FETCH_OBJ))) {
        $libelle = $record->libelle;
    } else {
        ajoute_erreur("Enregistrement inexistant, affichage impossible.");
        $mode = "lst";
    }
} else {
    // affichage de la liste
    $mode = "lst";
    $code = -1;
    $libelle = "";
}

switch ($mode) {
    case    "add":
        $PageTitle = "Ajout d'un réseau social";
        break;
    case    "chg":
        $PageTitle = "Modification du réseau social";
        break;
    case    "dlt":
        $PageTitle = "Suppression du réseau social";
        break;
    case    "dsp":
        $PageTitle = "Détail du réseau social";
        break;
    case    "lst":
        $PageTitle = "Liste des réseaux sociaux";
        break;
    default:
        // TODO : envoyer en 404 not found
}
require_once(__DIR__ . "/_header.php");
?>
    <form action="admin-reseaux-sociaux.php" method="post" id="frm">
        <input type="hidden" name="op" id="op" value="<?php print($mode); ?>">
        <input type="hidden" name="dsp" id="dsp" value="0">
        <input type="hidden" name="v" id="v"
               value="<?php print(getVerifChecksum(KEY_VERIF, (isset($code) ? $code : -1), (isset($priv_key) ? $priv_key : ""))); ?>">
        <input type="hidden" name="code" id="code" value="<?php print(isset($code) ? $code : -1); ?>">
        <section class="fdb-block pt-0">
            <div class="container">
                <div class="row text-center justify-content-center pt-5">
                    <div class="col-12 col-md-7">
                        <h1><?php print($PageTitle); ?></h1>
                    </div>
                </div>
                <?php if ("lst" == $mode) {
                    $qry = $db->prepare("select * from reseaux_sociaux order by libelle");
                    $qry->execute(array());
                    ?>
                    <table class="table text-center mt-5 d-table">
                        <tbody>
                        <tr>
                            <th scope="col">Réseau social</th>
                            <th scope="col">
                                <button type="button" class="btn btn-primary" onclick="btnAjouterClick();">Ajouter
                                </button>
                            </th>
                        </tr>
                        <?php while (false !== ($record = $qry->fetch(PDO::FETCH_OBJ))) { ?>
                            <tr>
                                <td><?php print(htmlentities($record->libelle)); ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary"
                                            onclick="btnAfficherClick(<?php print($record->code); ?>);">Afficher
                                    </button>
                                    <button type="button" class="btn btn-primary"
                                            onclick="btnModifierClick(<?php print($record->code); ?>);">Modifier
                                    </button>
                                    <button type="button" class="btn btn-primary"
                                            onclick="btnSupprimerClick(<?php print($record->code); ?>)">Supprimer
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <div class="row justify-content-center pt-4">
                        <div class="col-12 col-md-7">
                            <?php if (("chg" == $mode) || ("dsp" == $mode) || ("dlt" == $mode)) { ?>
                                <div class="row">
                                    <div class="col">
                                        Code : <?php print($code); ?>
                                    </div>
                                </div>
                            <?php }
                            if (("dsp" == $mode) || ("dlt" == $mode)) { ?>
                                <div class="row">
                                    <div class="col">
                                        Réseau social : <?php print(htmlentities($libelle)); ?>
                                    </div>
                                </div>
                            <?php }
                            if (("add" == $mode) || ("chg" == $mode)) { ?>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Réseau social" id="libelle"
                                               name="libelle"
                                               value="<?php print(isset($libelle) ? htmlentities($libelle) : ""); ?>"
                                               autofocus>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="row mt-4">
                                <div class="col text-center">
                                    <?php if (("add" == $mode) || ("chg" == $mode)) { ?>
                                        <button type="submit" class="btn btn-success">Enregistrer</button>
                                    <?php }
                                    if ("dlt" == $mode) { ?>
                                        <button type="button" class="btn btn-danger"
                                                onclick="document.getElementById('frm').submit();">Supprimer
                                        </button>
                                    <?php }
                                    if (("chg" == $mode) || ("dlt" == $mode)) { ?>
                                        <button type="button" class="btn btn-warning" onclick="btnRetourListeClick();">
                                            Annuler
                                        </button>
                                    <?php }
                                    if (("add" == $mode) || ("dsp" == $mode)) { ?>
                                        <button type="button" class="btn btn-primary" onclick="btnRetourListeClick();">
                                            Retour
                                        </button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="row-100"></div>
            </div>
        </section>
    </form>
    <script>
        function btnAjouterClick() {
            document.getElementById('code').value = -1;
            document.getElementById('op').value = 'add';
            document.getElementById('dsp').value = '1';
            document.getElementById('frm').submit();
        }

        function btnModifierClick(code) {
            document.getElementById('code').value = code;
            document.getElementById('op').value = 'chg';
            document.getElementById('dsp').value = '1';
            document.getElementById('frm').submit();
        }

        function btnSupprimerClick(code) {
            document.getElementById('code').value = code;
            document.getElementById('op').value = 'dlt';
            document.getElementById('dsp').value = '1';
            document.getElementById('frm').submit();
        }

        function btnAfficherClick(code) {
            document.getElementById('code').value = code;
            document.getElementById('op').value = 'dsp';
            document.getElementById('dsp').value = '1';
            document.getElementById('frm').submit();
        }

        function btnRetourListeClick() {
            document.getElementById('code').value = -1;
            document.getElementById('op').value = 'lst';
            document.getElementById('dsp').value = '1';
            document.getElementById('frm').submit();
        }
    </script><?php
require_once(__DIR__ . "/_erreur-formulaire.php");
require_once(__DIR__ . "/_info-bloc-html.php");
require_once(__DIR__ . "/_footer.php");