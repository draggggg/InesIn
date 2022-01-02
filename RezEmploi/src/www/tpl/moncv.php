<?php
if ((!defined("REZEMPLOIKEY")) || (REZEMPLOIKEY != "3f5gd4ng2h5j4gh24,gh2j54fd2g54fg2h45")) {
    header("location: index.php");
    exit;
}

require_once(__DIR__ . "/../" . ProtectedFolder . "/utilisateurs.php");
if (!isUtilisateurConnecteParticulier()) {
    header("location: login.php");
    exit;
} else {
    $UtilisateurConnecte = getUtilisateurConnecte();
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

// TODO : charger globalement des valeurs par défaut selon les rubriques
$titre = "";
$nom = "";
$prenom = "";
$datenaissance = "00/00/0000";
$niveauetudes = "aucun";

$mode = $op;
if (("chginfos" == $op) && $dsp) {
    // affichage de la page de cv_infos en ajout/modification
    $qry = $db->prepare("select * from cv_infos where utilisateur_code=:uc");
    $qry->execute(array(":uc" => $UtilisateurConnecte->code));
    if (false !== ($record = $qry->fetch(PDO::FETCH_OBJ))) {
        $priv_key = $record->priv_key;
        $titre = $record->titre;
        $nom = $record->nom;
        $prenom = $record->prenom;
        $dn_annee = $record->datenaissance_annee;
        $dn_mois = $record->datenaissance_mois;
        $dn_jour = $record->datenaissance_jour;
        $ne_code = $record->niveau_etude_code;
        $code = $record->code; // TODO : ajouter la récupération du Public/Non public de la date de naissance
    } else {
        $priv_key = "";
        $titre = "";
        $nom = "";
        $prenom = "";
        $dn_annee = 0;
        $dn_mois = 0;
        $dn_jour = 0;
        $ne_code = -1;
        $code = -1;
    }
} else if ("chginfos" == $op) {
    // traitement des infos passées en saisie pour cv_infos
    $code = intval(isset($_POST["code"]) ? $_POST["code"] : "-1");
    $titre = isset($_POST["titre"]) ? trim(strip_tags($_POST["titre"])) : "";
    $nom = isset($_POST["nom"]) ? trim(strip_tags($_POST["nom"])) : "";
    if (empty($nom)) {
        ajoute_erreur("Saisissez au moins votre nom.", "nom");
    }
    $prenom = isset($_POST["prenom"]) ? trim(strip_tags($_POST["prenom"])) : "";
    $dn_annee = 0; // TODO : à compléter
    $dn_mois = 0; // TODO : à compléter
    $dn_jour = 0; // TODO : à compléter
    $ne_code = -1; // TODO : à compléter
    if (empty($erreurs)) {
        if (-1 == $code) {
            // TODO : gérer ajout d'enregistrement
//            $qry = $db->prepare("select * from types_diplomes where code=:c");
            //         $qry->execute(array(":c" => $code));
        } else {
            // TODO : gérer modification d'enregistrement
            //      $qry = $db->prepare("select * from types_diplomes where code=:c");
            //    $qry->execute(array(":c" => $code));
        }
        if ((false !== ($record = $qry->fetch(PDO::FETCH_OBJ))) && checkVerifChecksum($verif, KEY_VERIF, $record->code, $record->priv_key)) {
            if ($libelle != $record->libelle) {
                $qry = $db->prepare("update types_diplomes set libelle=:l where code=:c");
                $qry->execute(array(":c" => $code, ":l" => $libelle));
            }
            $mode = "dsp";
        }
    }
} else if (("dlt" == $op) && $dsp) {
    // affichage de la page en suppression
    $code = intval(isset($_POST["code"]) ? $_POST["code"] : "-1");
    $qry = $db->prepare("select * from types_diplomes where code=:c");
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
    $qry = $db->prepare("select * from types_diplomes where code=:c");
    $qry->execute(array(":c" => $code));
    if ((false !== ($record = $qry->fetch(PDO::FETCH_OBJ))) && checkVerifChecksum($verif, KEY_VERIF, $record->code, $record->priv_key)) {
        $qry = $db->prepare("delete from types_diplomes where code=:c");
        $qry->execute(array(":c" => $code));
        $mode = "lst";
    } else {
        ajoute_erreur("Enregistrement inexistant, suppression impossible.");
        $mode = "lst";
    }
} else if (("dsp" == $op) && $dsp) {
    // affichage de la page en détail
    $code = intval(isset($_POST["code"]) ? $_POST["code"] : "-1");
    $qry = $db->prepare("select * from types_diplomes where code=:c");
    $qry->execute(array(":c" => $code));
    if (false !== ($record = $qry->fetch(PDO::FETCH_OBJ))) {
        $libelle = $record->libelle;
    } else {
        ajoute_erreur("Enregistrement inexistant, affichage impossible.");
        $mode = "lst";
    }
} else {
    // affichage de la liste
    $mode = "dsp";
    $code = -1;
}

$PageTitle = "Mon CV";
require_once(__DIR__ . "/_header.php");
require_once(__DIR__ . "/../" . ProtectedFolder . "/textesdusite.php"); ?>
    <form action="moncv.php" method="post" id="frm">
        <input type="hidden" name="op" id="op" value="<?php print(isset($mode) ? $mode : ""); ?>">
        <input type="hidden" name="dsp" id="dsp" value="0">
        <input type="hidden" name="v" id="v"
               value="<?php print(getVerifChecksum(KEY_VERIF, (isset($code) ? $code : -1), (isset($priv_key) ? $priv_key : ""))); ?>">
        <input type="hidden" name="code" id="code" value="<?php print(isset($code) ? $code : -1); ?>">
        <section class="fdb-block py-0">
            <div class="container py-5 my-5" style="background-image: url(imgs/shapes/9.svg);">
                <div class="row py-5">
                    <div class="col py-5">
                        <div class="fdb-box fdb-touch">
                            <div class="row text-center justify-content-center">
                                <div class="col-12 col-md-9 col-lg-7"><?php
                                    if (getTexteDuSite("moncv", $titre_page, $texte_page)) {
                                        if (!empty($titre_page)) print("<h1>" . $titre_page . "</h1>");
                                        print($texte_page);
                                    } else {
                                        require_once(__DIR__ . "/../" . ProtectedFolder . "/erreurs.php");
                                        ajoute_erreur("Page \"moncv\" non trouvée.");
                                    } ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="fdb-block pt-0">
            <div class="container">
                <div class="row text-center justify-content-center pt-5">
                    <div class="col-12 col-md-7">
                        <h1>Identification</h1>
                    </div>
                </div>
                <div class="row justify-content-center pt-4">
                    <div class="col-12 col-md-7">
                        <?php
                        if ("dsp" == $mode) { ?>
                            <div class="row">
                                <div class="col">
                                    Titre : <?php print(htmlentities($titre)); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    Nom : <?php print(htmlentities($nom)); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    Prénom : <?php print(htmlentities($prenom)); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    Date de naissance : <?php print(htmlentities($datenaissance)); ?> (publique / non
                                    publique)
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    Niveau d'études : <?php print(htmlentities($niveauetudes)); ?>
                                </div>
                            </div>
                            <?php
                        } else if ("chginfos" == $mode) { ?>
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Titre"
                                           id="titre"
                                           name="titre"
                                           value="<?php print(isset($titre) ? htmlentities($titre) : ""); ?>"
                                           autofocus>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Nom"
                                           id="nom"
                                           name="nom"
                                           value="<?php print(isset($nom) ? htmlentities($nom) : ""); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Prénom"
                                           id="prenom"
                                           name="prenom"
                                           value="<?php print(isset($prenom) ? htmlentities($prenom) : ""); ?>">
                                </div>
                            </div>
                        <?php } ?>
                        <div class="row mt-4">
                            <div class="col text-center">
                                <?php if ("chginfos" == $mode) { ?>
                                    <button type="submit" class="btn btn-success">Enregistrer</button>
                                    <button type="button" class="btn btn-warning" onclick="btnRetourClick();">
                                        Annuler
                                    </button>
                                <?php } else { ?>
                                    <button type="button" class="btn btn-primary" onclick="btnModifierInfosClick();">
                                        Modifier
                                    </button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-100"></div>
            </div>
        </section>
    </form>

    <script>
        function btnModifierInfosClick() {
            document.getElementById('code').value = -1;
            document.getElementById('op').value = 'chginfos';
            document.getElementById('dsp').value = '1';
            document.getElementById('frm').submit();
        }

        function btnRetourClick() {
            document.getElementById('code').value = -1;
            document.getElementById('op').value = '';
            document.getElementById('dsp').value = '1';
            document.getElementById('frm').submit();
        }
    </script><?php
require_once(__DIR__ . "/_erreur-formulaire.php");
require_once(__DIR__ . "/_footer.php");

// TODO : infos du CV

// TODO : ajouter date de naissance en saisie
// TODO : ajouter niveau d'études en saisie