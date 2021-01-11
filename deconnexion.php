<?php
require_once('include/init.php');
// on sécurise toujours les pages par rapport aux fonctions
if(adminConnecte())
{
        // on détruit la session, les informations sont supprimées
        session_destroy();

        // on redirige l'utilisateur vers la page connexion par exemple
        header("Location:" . URL . "connexion.php"); exit;
}
else
{
    header("Location:" . URL . "index.php");
}