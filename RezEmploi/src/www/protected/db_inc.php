<?php
if ((!defined("REZEMPLOIKEY")) || (REZEMPLOIKEY != "3f5gd4ng2h5j4gh24,gh2j54fd2g54fg2h45")) {
    header("location: index.php");
    exit;
}

if ((!defined("DB_NAME")) || empty(DB_NAME)) {
    die("Veuillez configurer le script.");
}

try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=UTF8", DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
} catch (PDOException $e) {
    die("Problème de base de données. Contactez l'administrateur du site.");
}

session_start();
