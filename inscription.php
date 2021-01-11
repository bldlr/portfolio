<?php
require_once("include/init.php");



if(!superAdminConnecte())
{
  header("Location:" . URL . "index.php"); exit;
}

//echo '<pre>'; print_r($_POST); echo '</pre>';


if($_POST) // on rentre dans cette condition si on a soumis un formulaire
{

    $pdoStatement = $pdoObject->prepare("SELECT * FROM membre WHERE email = :email");
    $pdoStatement->bindValue(':email', $_POST['email'], PDO::PARAM_STR); 
    $pdoStatement->execute();

    $membreArray = $pdoStatement->fetch(PDO::FETCH_ASSOC);

    //1ere condition : vérification de l'email
    if(empty($membreArray))
    {

                $mdp = password_hash("azerty", PASSWORD_DEFAULT); 

                $pdoStatement = $pdoObject->prepare("INSERT INTO membre (email, mdp, statut) VALUES (:email, :mdp, :statut)");

                $pdoStatement->bindValue(":email", $_POST['email'], PDO::PARAM_STR);
                $pdoStatement->bindValue(":mdp", $mdp, PDO::PARAM_STR);
                $pdoStatement->bindValue(":statut", 1, PDO::PARAM_INT);
            
                $pdoStatement->execute(); 


                $membre = $pdoStatement->fetch(PDO::FETCH_ASSOC);
                $membreToken = $membre['token'];
                $membreId = $membre['id_membre'];
                
                /////////////// CONFIRMATION PAR EMAIL
                $to      =  $_POST['email'];
                $subject = 'Inscription sur le site bldlr';
                $headers = 'From: bldlr170289@gmail.com';
                $message = "Bonjour,

                            Votre adresse email a été enregistrée sur le site www.bldlr.fr

                            Vous pouvez vous connecter dès à présenter en définissant un mot de passe : 
                            " . URL . "gestion_admin.php?action=definir_motdepasse

                            Si vous ne souhaitez pas être inscrit sur le site, cliquez sur :
                            " . URL . "gestion_admin.php ?action=suppression_compte

                            Pour vous connecter :
                            " . URL . "connexion.php

                            A bientôt";
            
                mail($to, $subject, $message, $headers);
        
                header("Location:". URL . "gestion_membres.php?action=afficher_membres&membre=inscrit");exit;


    }
    else// else de la 1ere condition : l'email existe
    {
        $erreur .= "<div class='col-md-6 offset-md-3 alert alert-danger text-center disparition'>
            Email " . $_POST['email'] ."  existant
        </div> ";
    }


}// Fermeture de la condition du $_POST
require_once("include/headeradmin.php");
?>

<div class="container page-bart-lord">

        <div class="retourBackOffice">
        <a class="btn" href="<?= URL ?>gestion_membres.php?action=afficher_membres">Membres</a>
            <a class="btn" href="<?= URL ?>admin.php">Retour au back office</a>
            
        </div>

<!------------------------------ PAGE NAVIGATEUR ----------------------------------->
    <h1 class="display-5 text-center m-4">Inscription</h1>


    <?= $erreur ?>

<!----------------------------- DEBUT DU FORMULAIRE  ------------------------------->
    <form method="post" class="col-md-6 col-md-offset-3">

        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Saisir votre email">
        </div>
        
        <button type="submit" class="col-md-12 btn btn-dark">Inscription</button>

    </form>
<!----------------------------- FIN DU FORMULAIRE  ------------------------------->
</div>




<?php
require_once("include/footer.php");