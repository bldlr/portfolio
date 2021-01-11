<?php 
require_once("include/init.php");


//---------- MESSAGE ERREUR CONFIRMATION DEJA FAITE
if(isset($_GET['confirmation']) && $_GET['confirmation'] == 'existante')
{
    $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>
                        Vous avez déjà cliqué sur le lien <br>
                        Vous pouvez vous connecter <br>
                        <a href='connexion.php'>Connexion</a>
                    </div>";
}


//---------- MESSAGE ERREUR CONFIRMATION DEJA FAITE
if(isset($_GET['mdp']) && $_GET['mdp'] == 'deja_defini')
{
    $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>
                        Vous avez déjà déjà défini votre mot de passe
                    </div>";
}

//---------- MESSAGE ERREUR CONFIRMATION DEJA FAITE
if(isset($_GET['mdp']) && $_GET['mdp'] == 'deja_change')
{
    $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>
                        Vous avez déjà déjà changer votre mot de passe
                    </div>";
}

//---------- MAUVAIS COMPTE
if(isset($_GET['compte']) && $_GET['compte'] == 'different')
{
    $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>
                        Ce n'est pas votre compte
                    </div>";
}

//---------- SUPRESSION IMPOSSIBLE
if(isset($_GET['suppression']) && $_GET['suppression'] == 'impossible')
{
    $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>
                        Suppression impossible
                    </div>";
}

//---------- COMPTE DEJA SUPPRIMÉ
if(isset($_GET['compte']) && $_GET['compte'] == 'supprime')
{
    $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>
                        Vous avez déjà supprimé votre compte
                    </div>";
}

//---------- MESSAGE ERREUR PAGE INEXISTANTE
if(isset($_GET['page']) && $_GET['page'] == 'inexistante')
{
    $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>
                        Cette page n'existe pas
                    </div>";
}


//---------- ACCES INTERDIT
if(isset($_GET['acces']) && $_GET['acces'] == 'interdit')
{
    $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>
                        Accès interdit
                    </div>";
}

//---------- ACCES INTERDIT
if(isset($_GET['activation']) && $_GET['activation'] == 'existante')
{
    $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>
                        Vous avez déjà activé votre compte
                    </div>";
}

require_once("include/headeradmin.php");
?>
    <div class="container page-bart-lord">
        <h1 class="text-center m-4">ERREUR</h1><hr>


        <div class="col-md-12">
            <?= $notification ?>
        </div>

        <div class="text-center">
            <img style="width:300px" src="img/oops.png" alt="icône oops">
        </div>
    </div>

<?php
require_once("include/footer.php");