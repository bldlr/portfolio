<?php
    require_once("include/init.php");


    if(adminConnecte())
    {
        header("Location:" . URL . "index.php");
    }




    //---------- MESSAGE EMAIL ENVOYÉ POUR CHANGER DE MOT DE PASSE
    if(isset($_GET['motdepasse_oublie']) && $_GET['motdepasse_oublie'] == 'email_envoye')
    {

        $email = $_GET['email'];
        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'> 
                            un email vous a été envoyé pour générer un nouveau mot de passe
                        </div>";

        $lien .= "<a class='col-md-12 text-center' href='motdepasseOublie.php?motdepasse=redemande&email="    . $email . "' >email non reçu ?</a>";
    }

    //---------- MESSAGE MOT DE PASSE CHANGÉ
    if(isset($_GET['motdepasse_oublie']) && $_GET['motdepasse_oublie'] == 'change')
    {

        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'> 
                            Votre mot de passe a bien été changé
                        </div>";

    }

    //---------- MESSAGE MOT DE PASSE CHANGÉ
    if(isset($_GET['motdepasse']) && $_GET['motdepasse'] == 'defini')
    {
    
        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'> 
                            Votre mot de passe a bien été défini, vous pouvez vous connecter
                        </div>";
    
    }

    //---------- MESSAGE COMPTE SUPPRIMÉ
    if(isset($_GET['compte']) && $_GET['compte'] == 'supprime')
    {

        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'> 
                            Vous avez supprimé votre compte 
                        </div>";
    }


    if($_POST) 
    {
        $pdoStatement = $pdoObject->prepare("SELECT * FROM membre WHERE email = :email");
        $pdoStatement->bindValue(':email', $_POST['email'], PDO::PARAM_STR); 
        $pdoStatement->execute();
        $membre = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        if(!empty($membre))// 1e condition
        {

                if(password_verify($_POST['mdp'], $membre['mdp'])) // 2e condititon
                {
                                foreach($membre as $key => $value)
                                {
                                        $_SESSION['membre'][$key] = $value; 
                                        //echo '<pre>'; print_r($_SESSION); echo '</pre>';

                                }
                                header("Location:" . URL . "admin.php?action=afficher");
                
                }
                else // else de la 2e condition
                {
                    // le mot de passe est faux
                    $erreur .= "<div class='col-md-6 col-md-offset-3  rounded alert alert-warning text-center'>
                    <strong>Mot de passe erroné </strong>
                    </div>";
                }

        }
        // sinon $membre est vide et ça signifie que l'email n'existe pas
        else // else de la 1e condition
        {
                    $erreur .= "<div class='col-md-6 col-md-offset-3 alert alert-danger text-center'>
                                    email inexistant
                                </div>";
        }



    }// Fermeture de la condition du $_POST


    require_once("include/headeradmin.php");
?>

<div class="container page-bart-lord">
<!------------------------------ PAGE NAVIGATEUR ----------------------------------->
    <h1 class="text-center m-4">Connexion</h1>


    <?= $erreur ?>
    <?= $notification ?>

<!----------------------------- DEBUT DU FORMULAIRE  ------------------------------->
    <form method="post" class="col-md-6 col-md-offset-3">

        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Saisir votre email">
        </div>

        <div class="form-group">
            <label for="mdp">Mot de passe</label>
            <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Saisir votre mot de passe">
        </div>
        

        <button type="submit" class="col-md-12 btn btn-dark mt-3">Connexion</button>

    </form>



        <div class="row justify-content-center">
      
            <?php if($_POST) : ?>
                <a class="col-md-12 text-center" href='motdepasseOublie.php?motdepasse=demande'>Mot de passe oublié ?</a>
            <?php endif; ?>
            <?= $lien ?>
        </div>
<!----------------------------- FIN DU FORMULAIRE  ------------------------------->





<?php
require_once("include/footer.php");