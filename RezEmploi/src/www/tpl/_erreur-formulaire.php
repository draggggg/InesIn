<?php
if ((!defined("REZEMPLOIKEY")) || (REZEMPLOIKEY != "3f5gd4ng2h5j4gh24,gh2j54fd2g54fg2h45")) {
    header("location: index.php");
    exit;
}

if (isset($erreurs) && is_array($erreurs) && (count($erreurs) > 0)) {
    ?>
    <script language="JavaScript">
        erreurs = <?php print(json_encode($erreurs)); ?>;
        focus = false;
        for (let i = 0; i < erreurs.length; i++) {
            msgtraite = false;
            err = erreurs[i];
            if (err.champ.length > 0) {
                fld = $('#' + err.champ);
                if (fld) {
                    if (!focus) {
                        fld.focus();
                        focus = true;
                    }
                    if (err.texte != '') {
                        p = $('<p>').text(err.texte).addClass('erreur');
                        fld.after(p);
                        msgtraite = true;
                    }
                }
            }
            if (!msgtraite) {
                window.alert(err.texte);
            }
        }
    </script>
    <?php
}