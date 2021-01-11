<?php                          // A
function inclusionAutomatique($nomDeLaClasse)
{               // A
    include_once($nomDeLaClasse . '.class.php');
    //echo "On passe dans inclusionAutomatique!<hr>";
    //echo "include_once($nomDeLaClasse.class.php);<hr>";
}

spl_autoload_register('inclusionAutomatique');

/*
    spl_autoload_register() : permet d'executer une fonction lorsque l'interpreteur voit passer le mot clé "new" dans le code
    Le nom à côté du 'new' est recupéré et transmit automatiquement à la fonction inclusionAutomatique() (un peu à la manière d'une méthode magique)
    Il est indispensable de respecter une convention de nommage sur ses fichiers pour que l'autoload fonctionne 

    L'avantage avec l'autoload est qu'il permet d'inclure nos classes automatiquement
*/
