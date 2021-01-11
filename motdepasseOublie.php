<?php 
require_once("include/init.php");

if(adminConnecte())
{
  header("Location:" . URL . "index.php"); exit;
}
?>

<!-- CONDITION POUR ENVOYER UN MAIL POUR LE MOT DE PASSE OUBLIÉ -->
<?php if(isset($_GET['motdepasse']) && $_GET['motdepasse'] == 'demande') :?>


        <?php if($_POST) // si l'utilisateur a cliqué sur le bouton submit du formulaire
        {

                if(!empty($_POST['email'])) // Si $_POST['email'] n'est pas vide 
                {
                    // requête de sélection
                    $pdoStatement = $pdoObject->prepare("SELECT * FROM membre WHERE email = :email");
                    $pdoStatement->bindValue(':email', $_POST['email'], PDO::PARAM_STR); 
                    $pdoStatement->execute();
                
                    $membre = $pdoStatement->fetch(PDO::FETCH_ASSOC);
                
                            if(!empty($membre)) // si $membre n'est pas vide, ça veut dire que l'email existe en BDD
                            {

                                    $pdoStatement = $pdoObject->prepare("UPDATE membre SET action =:action WHERE id_membre = :id_membre ");
                                    $pdoStatement->bindValue(":id_membre", $membre['id_membre'], PDO::PARAM_INT);
                                    $pdoStatement->bindValue(":action", generateToken(), PDO::PARAM_INT);
                                
                                    $pdoStatement->execute(); 

                                    $to      = $_POST['email'];
                                    $subject = "Changer votre mot de passe";
                                    $message = URL . "motdepasseOublie.php?motdepasse=effectue&email=" . $to . "&token=" . $membre['token'] ;
                                    $headers = 'From: bldlr170289@gmail.com';


                                    
                                    mail($to, $subject, $message, $headers);


                                    // une fois l'insertion executée, on redirige l'utilisateur vers la page connexion en ajoutant dans l'URL un paramètre : inscription avec la valeur enregistre
                                    // dans l'intérêt d'afficher sur la page connexion un message mentionnant que l'inscription a été enregistré.
                                    header("Location:". URL . "connexion.php?motdepasse_oublie=email_envoye&email=" . $_POST['email']);exit;

                            }
                            else // si $membre est vide, ça veut dire que l'email n'existe en BDD, message d'erreur
                            // car on ne va pas envoyer un email à une personne qui n'est pas du site
                            {
                                $erreur .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                                <strong>Adresse inexistante</strong>
                                            </div>";
                            }
                }
                else // si $_POST['email'] est vide message d'erreur : email inexistant
                {
                    $erreur .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                    Veuillez saisir votre adresse
                                </div>";
                }
            
        } // fin if($_POST) 
        require_once("include/headeradmin.php");
        ?>
        <div class="container page-bart-lord">
            <h1 class="text-center m-4">Mot de passe oublié</h1><hr>
            <?= $erreur ?>

            <form method="post" class="col-md-6 col-md-offset-3">

                <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Saisir votre email">
                </div>

                <div class="row justify-content-center">
                <button type="submit" class="col-md-12 btn btn-dark mt-2 mb-4">Envoyer</button>
                </div>
            </form>
        </div>

<?php endif; ?>

<!-- CONDITION POUR --R--ENVOYER UN MAIL POUR LE MOT DE PASSE OUBLIÉ -->
<?php if(isset($_GET['motdepasse']) && $_GET['motdepasse'] == 'redemande') 
    {
        $pdoStatement = $pdoObject->prepare("SELECT * FROM membre WHERE email = :email");
        $pdoStatement->bindValue(':email', $_GET['email'], PDO::PARAM_STR); 
        $pdoStatement->execute();
    
        $membre = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        $to      = $_GET['email'];
        $subject = "Changer votre mot de passe";
        $message = URL . "motdepasseOublie.php?motdepasse=effectue&email=" . $to . "&token=" . $membre['token'] ;
        $headers = 'From: bldlr170289@gmail.com';

                                
        mail($to, $subject, $message, $headers);


        // une fois l'insertion executée, on redirige l'utilisateur vers la page connexion en ajoutant dans l'URL un paramètre : inscription avec la valeur enregistre
        // dans l'intérêt d'afficher sur la page connexion un message mentionnant que l'inscription a été enregistré.
        header("Location:". URL . "connexion.php?motdepasse_oublie=email_envoye&email=" . $_GET['email']);exit;

    }
?>


<!-- CONDITION POUR REDÉFINIR LE MOT DE PASSE -->
<?php if(isset($_GET['motdepasse']) && $_GET['motdepasse'] == 'effectue') :

    $pdoStatement = $pdoObject->prepare("SELECT * FROM membre WHERE email = :email");
    $pdoStatement->bindValue(':email', $_GET['email'], PDO::PARAM_STR); 
    $pdoStatement->execute();
                
    $membre = $pdoStatement->fetch(PDO::FETCH_ASSOC);
    

    if($membre['token'] == $_GET['token'])
    {
            
        if($membre['action'] > 1)
        {

                    if($_POST) 
                    {

                    
                        // Préparation de la requête de modification
                        $requete = $pdoObject->prepare("UPDATE membre SET mdp=:mdp, action=:action  WHERE email = :email ");

                            if( ($_POST['mdp_new'] === $_POST['mdp_confirm']) && (!empty($_POST['mdp_new']) && !empty($_POST['mdp_confirm']) )  )
                            {
                                $_POST['mdp_new'] = password_hash($_POST['mdp_new'], PASSWORD_DEFAULT); 
                                $requete->bindValue(":email", $_GET["email"], PDO::PARAM_STR);
                                $requete->bindValue(":mdp", $_POST['mdp_new'], PDO::PARAM_STR);
                                $requete->bindValue(":action", 1, PDO::PARAM_INT);
                                $requete->execute(); 
                                    
                                header("Location:" . URL . "connexion.php?motdepasse_oublie=change"); exit;

                            }
                            else
                            {
                                $erreur .= "<div class='col-md-6 mt-4 mx-auto alert alert-danger text-center disparition'>
                                                Les mots de passe ne sont pas identiques
                                            </div>";
                            }

                        
                    }// FIN DU IF($_POST) 
                    require_once("include/headeradmin.php")
                ?>

            <div class="container page-bart-lord">
                <!------------------------------ PAGE NAVIGATEUR ----------------------------------->
                <h1 class="text-center m-4">Modifier mot de passe</h1><hr>


                <?= $erreur ?>

                <!----------------------------- DEBUT DU FORMULAIRE  ------------------------------->
                <form method="post" class="col-md-6 col-md-offset-3">

                    <div class="form-group">
                        <label for="mdp_new">Nouveau mot de passe</label>
                        <input type="password" class="form-control" id="mdp_new" name="mdp_new" placeholder="Saisir votre nouveau mot de passe">
                    </div>

                    <div class="form-group">
                        <label for="mdp_confirm">Confirmation du nouveau mot de passe</label>
                        <input type="password" class="form-control" id="mdp_confirm" name="mdp_confirm" placeholder="Confirmer votre nouveau mot de passe">
                    </div>
                    
                    <div class="row justify-content-center">
                        <button type="submit" class="col-md-12 m-1 btn btn-dark">Modifier</button>
                    </div>

                </form>
                <!----------------------------- FIN DU FORMULAIRE  ------------------------------->
            </div>

            <?php

        }
        else
        {
            header("Location:". URL . "erreur.php?mdp=deja_change");
        } 
    }
    else
    {
        header("Location:". URL . "erreur.php?compte=different");
    }
    
    endif; 
?>



<?php require_once("include/footer.php"); ?>


