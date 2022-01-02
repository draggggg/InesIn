<?php
if ((!defined("REZEMPLOIKEY")) || (REZEMPLOIKEY != "3f5gd4ng2h5j4gh24,gh2j54fd2g54fg2h45")) {
    header("location: index.php");
    exit;
}

require_once(__DIR__ . "/../" . ProtectedFolder . "/utilisateurs.php");

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php print(isset($PageTitle) && ("" != $PageTitle) ? htmlentities($PageTitle) : _TitreDuSite); ?></title>
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link type="text/css" rel="stylesheet" href="css/froala_blocks.min.css">
    <link type="text/css" rel="stylesheet" href="css/styles.css">
    <style>
        .fdb-block {
            border-bottom: 1px solid var(--light);
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>
<body>
<header class="bg-dark">
    <div class="container">
        <nav class="navbar navbar-expand-md">
            <a class="navbar-brand" href="<?php print(isUtilisateurConnecte() ? "index-membre.php" : "index.php"); ?>">
                <img src="./imgs/logo.png" height="30" alt="image">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav11"
                    aria-controls="navbarNav11" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav11">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link"
                           href="<?php print(isUtilisateurConnecte() ? "index-membre.php" : "index.php"); ?>">Accueil</a>
                    </li><?php if (isUtilisateurConnecteParticulier()) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="moncompte.php">Mon compte</a>
                        </li><?php }
                    if (isUtilisateurConnecteParticulier()) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="moncv.php">Mon CV</a>
                        </li><?php }
                    if (isUtilisateurConnecteEntreprise()) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="mesentreprises.php">Mes entreprises</a>
                        </li><?php }
                    if (isUtilisateurConnecteModeration()) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="moderation.php">Moderation</a>
                        </li><?php }
                    if (isUtilisateurConnecteAdmin() || isUtilisateurConnecteSuperAdmin()) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="admin.php"> Administration</a>
                        </li><?php }
                    if (_DEBUG) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="debug-info.php">DEBUG</a>
                        </li><?php } ?>
                </ul>
                <?php
                if (isUtilisateurConnecte()) {
                    ?><a class="btn btn-outline-light ml-md-3" href="logout.php">Déconnexion</a><?php
                } else {
                    ?><a class="btn btn-outline-light ml-md-3" href="signup.php">Inscription</a>
                    <a class="btn btn-outline-light ml-md-3" href="login.php">Connexion</a><?php } ?>
            </div>
        </nav>
    </div>
</header>