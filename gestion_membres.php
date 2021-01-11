<?php 
require_once("include/init.php");
?>


<!-------------------------------------------------------------------->
<!--------------------- afficher les membres ------------------------->
<!-------------------------------------------------------------------->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'afficher_membres' )) :

    if(!adminConnecte() && !superAdminConnecte())
    {
    header("Location:" . URL . "index.php"); exit;
    }


    if(isset($_GET['membre']) && $_GET['membre'] == 'supprime')
    {

        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                            Membre supprimé
                        </div>";
    }
    if(isset($_GET['membres']) && $_GET['membres'] == 'supprimes')
    {

        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                            Membres supprimés
                        </div>";
    }

    if(isset($_GET['membre']) && $_GET['membre'] == 'inscrit')
    {

        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                            Membre inscrit
                        </div>";
    }

    if(isset($_GET['motdepasse']) && $_GET['motdepasse'] == 'modifie')
    {

        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                            Mot de passe modifié
                        </div>";
    }

    if(isset($_GET['suppression']) && $_GET['suppression'] == 'impossible')
    {

        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                            Suppression impossible
                        </div>";
    }

    $pdoStatement = $pdoObject->query("SELECT * FROM membre");
    $membres = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    //echo "<pre>"; print_r($membres); echo "</pre>";die;

    if($_POST) 
    {
        //echo "<pre>"; print_r($_POST); echo "</pre>";die;
        if ($_POST['action'] == 'supprimer') 
        {
            if(!empty($_POST['delete']))
            {
                    //echo print_r($_POST['delete']);die;
                    
                        $counter = 0;
        
                        foreach($_POST['delete'] as $delete)
                        {
                            if($delete == 1)
                            {
                                
                                header("Location:". URL . "gestion_membres.php?action=afficher_membres&suppression=impossible");exit;
                            }
                            else
                            {
                                $pdoSupp = $pdoObject->prepare("DELETE FROM membre WHERE id_membre = :id_membre");
                                $pdoSupp->bindValue(':id_membre', $delete, PDO::PARAM_INT);
                                $pdoSupp->execute();
        
                                $counter++;
                            }
                        }
            
                        
                        if($counter > 1)
                        {
                            header("Location:". URL . "gestion_membres.php?action=afficher_membres&membres=supprimes");exit;
                        }
                        else
                        {
                            header("Location:". URL . "gestion_membres.php?action=afficher_membres&membre=supprime");exit;
                        }

                
        
            }
            else
            {
                $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>
                                    Vous n'avez rien sélectionné
                                </div>";
            }
        } 


    }

    require_once("include/headeradmin.php");
    ?>

    <div class="container page-bart-lord">

        <div class="retourBackOffice">
            <a class="btn" href="<?= URL ?>admin.php">Retour au back office</a>
        </div>

        <h1 class="display-3 text-center m-4">Liste des membres</h1>

        <div class="col-md-12">
            <?= $notification ?>
        </div>


        <h4 class="text-center">Nombre de membres : 
            <span class="badge badge-primary">
                <?= $pdoStatement->rowCount() ?>
            </span>
        </h4>

        <form method='post'>
            <table class='table  table-striped text-center mt-3 bgf7'>

                <tr>
                    <?php for($i=0; $i<$pdoStatement->columnCount()  ; $i++) :
                        $colonne = $pdoStatement->getColumnMeta($i); 
                        ?>

                            <?php if($colonne['name'] != "mdp" && $colonne['name'] != "id_membre" && $colonne['name'] != "token" && $colonne['name'] != "action") : ?>
                                <th class="text-center"><?=  $colonne['name'] ?></th>
                            <?php endif; ?>

                    <?php endfor; ?>
                        <?php if($_SESSION['membre']['statut'] == 2) : ?>
                        
                        <th style="width:50px" class="text-center">Supprimer</th>
                        <?php endif; ?>
                </tr>


                <?php foreach($membres as $arrayMembre): ?>
                    <tr>
                        <?php foreach($arrayMembre as $key => $value): ?>

                            <?php if($key != "mdp" && $key != "id_membre" && $key != "token" && $key != "action") : ?>

                                <?php if($key == "statut" && $value == 2) : ?>
                                        <td class="text-center">Proprio</td>
                                <?php elseif($key == "statut" && $value == 1) : ?>
                                        <td class="text-center">Admin</td>
                                <?php else: ?>
                                <td class="text-center"><?= $value ?></td>
                                <?php endif; ?>

                                

                            <?php endif; ?>

                        <?php endforeach; ?>

                            <?php if($_SESSION['membre']['statut'] == 2) : ?>

                                <td style='vertical-align: middle;' >
                                    <?php if($arrayMembre['statut']== 1 )  : ?>

                                    <div style='width:20px; margin : 0 auto'>
                                        <input type="checkbox" name='delete[]' class="checkbox" value='<?= $arrayMembre['id_membre'] ?>'>
                                    </div>
                                        
                                    <?php endif; ?>
                                </td>

                            <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                <?php if(superAdminConnecte()) : ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="paddingtd">
                        <div style='width:20px; margin : 0 auto 8px auto'>
                            <input class="checkbox m-0 " id="checker" type="checkbox">
                        </div>
                        <input type="submit" name="action" value="supprimer" class='btn btn-primary pr-0 pl-0' onclick="return confirm('Confirmez-vous la suppression ?')" />
                    </td>
                </tr>
                <?php endif; ?>
            </table>
        </form>

        <div class="row justify-content-end mt-4 ">

            <a class="btn btn-info m-1" href="<?= URL ?>gestion_membres.php?action=modifier_mot_de_passe">Modifier le mot de passe</a>

            <?php if(superAdminConnecte()) : ?>
                <a class="btn btn-warning m-1" href="<?= URL ?>gestion_membres.php?action=ajouter_admin">Créer un admin</a>
            <?php elseif(adminConnecte()) : ?>
                <a class="btn btn-warning m-1" href="<?= URL ?>gestion_membres.php?action=supprimer_compte">Supprimer le compte</a>
            <?php endif; ?>

        </div>


    </div>
    


<?php endif; ?>



<!-------------------------------------------------------------------->
<!--------------------- Inscrire un admin ---------------------------->
<!-------------------------------------------------------------------->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'ajouter_admin' )) : 



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

                    $mdp = password_hash("azerty2020", PASSWORD_DEFAULT); 

                    $pdoStatement = $pdoObject->prepare("INSERT INTO membre (email, mdp, statut, token, action) VALUES (:email, :mdp, :statut, :token, :action)");

                    $pdoStatement->bindValue(":email", $_POST['email'], PDO::PARAM_STR);
                    $pdoStatement->bindValue(":mdp", $mdp, PDO::PARAM_STR);
                    $pdoStatement->bindValue(":statut", 1, PDO::PARAM_INT);
                    $pdoStatement->bindValue(":token", 1, PDO::PARAM_INT);
                    $pdoStatement->bindValue(":action", 1, PDO::PARAM_INT);
                
                    $pdoStatement->execute(); 



                    $pdoStatement = $pdoObject->prepare("SELECT * FROM membre WHERE email = :email");
                    $pdoStatement->bindValue(':email', $_POST['email'], PDO::PARAM_STR); 
                    $pdoStatement->execute();

                    $membre = $pdoStatement->fetch(PDO::FETCH_ASSOC);
                    //echo '<pre>'; print_r($membre); echo '</pre>'; die;

                    $identification = generateToken();
                    /////////////// CONFIRMATION PAR EMAIL
                    $to      =  $_POST['email'];
                    $subject = 'Inscription sur le site bldlr';
                    $headers = 'From: bldlr170289@gmail.com';
                    $message = "
                                Bonjour,

                                Votre adresse email a été enregistrée sur le site www.bldlr.fr

                                Vous pouvez vous connecter dès à présenter en définissant un mot de passe : 
                                " . URL . "gestion_membres.php?action=definir_mot_de_passe&id_membre=" . $membre["id_membre"]  . "&identification=". $identification  . "

                                Si vous ne souhaitez pas être inscrit sur le site, cliquez sur :
                                " . URL . "gestion_membres.php?action=suppression_compte_mail&id_membre=" . $membre["id_membre"]  . "&identification=". $identification  . "

                                Pour vous connecter :
                                " . URL . "connexion.php
                                
                                A bientôt";
                
                    mail($to, $subject, $message, $headers);
            
                    header("Location:". URL . "gestion_membres.php?action=afficher_membres&membre=inscrit");exit;


        }
        else// else de la 1ere condition : l'email existe
        {
            $erreur .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>
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


<?php endif; ?>



<!-------------------------------------------------------------------->
<!--------------------- Modifier Mot de passe ------------------------>
<!-------------------------------------------------------------------->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'modifier_mot_de_passe' )) : 


    if(!adminConnecte() && !superAdminConnecte())
    {
    header("Location:" . URL . "index.php"); exit;
    }

    $idMembre = $_SESSION['membre']['id_membre'];

    if(isset($_GET['mot_de_passe']) && $_GET['mot_de_passe'] == 'change')
    {

        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'> 
                            Votre mot de passe a été changé
                            </div>";  
    }

    if($_POST) 
    {
        // Préparation de la requête de modification
        $requete = $pdoObject->prepare("UPDATE membre SET mdp=:mdp  WHERE id_membre = :idMembre ");
        $requete->bindValue(":idMembre", $idMembre, PDO::PARAM_INT);

        if(password_verify($_POST['mdp_old'], $_SESSION['membre']['mdp']))
        {

            if( ($_POST['mdp_new'] === $_POST['mdp_confirm']) && (!empty($_POST['mdp_new']) && !empty($_POST['mdp_confirm']) )  )
            {
                if($_POST['mdp_new'] !== $_POST['mdp_old'])
                {
                    $_POST['mdp_new'] = password_hash($_POST['mdp_new'], PASSWORD_DEFAULT); 
                    $requete->bindValue(":mdp", $_POST['mdp_new'], PDO::PARAM_STR);
                    $requete->execute(); 
                    
                    $_SESSION['membre']['mdp'] = $_POST['mdp_new'];
                    header("Location:" . URL . "gestion_membres.php?action=modifier_mot_de_passe&mot_de_passe=change"); exit; 
                }
                else
                {
                    $erreur .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>Inutile de changer pour le même</div>";
                }
                
            }
            else
            {
                $erreur .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>Les mots de passe ne sont pas identiques</div>";
            }
            
        }
        else
        {
            $erreur .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>Votre mot de passe n'est pas correct</div>";
        }

    }
    require_once("include/headeradmin.php");
    ?>

  <!------------------------------ PAGE NAVIGATEUR ----------------------------------->
  <div class="container page-bart-lord">

        <div class="retourBackOffice">
            <a class="btn" href="<?= URL ?>admin.php">Retour au back office</a>
        </div>

    <h1 class="display-5 text-center m-4">Modifier mot de passe</h1>

  <?= $notification ?>
  <?= $erreur ?>

  <!----------------------------- DEBUT DU FORMULAIRE  ------------------------------->
  <form method="post" class="col-md-6 col-md-offset-3">

      <div class="form-group">
          <label for="mdp_old">Ancien mot de passe</label>
          <input type="password" class="form-control" id="mdp_old" name="mdp_old" placeholder="Saisir votre ancien mot de passe">
      </div>

      <div class="form-group">
          <label for="mdp_new">Nouveau mot de passe</label>
          <input type="password" class="form-control" id="mdp_new" name="mdp_new" placeholder="Saisir votre nouveau mot de passe">
      </div>

      <div class="form-group">
          <label for="mdp_confirm">Confirmation du nouveau mot de passe</label>
          <input type="password" class="form-control" id="mdp_confirm" name="mdp_confirm" placeholder="Confirmer votre nouveau mot de passe">
      </div>
      
      <div class="form-group text-center">
            <button  id="testButton" type="submit" class="btn col-md-12 m-1">Modifier</button>
        </div>

  </form>
  <!----------------------------- FIN DU FORMULAIRE  ------------------------------->

<?php endif; ?>

<!-------------------------------------------------------------------->
<!--------------------- Définir un mot de passe ---------------------->
<!-------------------------------------------------------------------->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'definir_mot_de_passe' )) : 


    $idMembre = $_GET['id_membre'];

    $pdoStatement = $pdoObject->prepare("SELECT * FROM membre WHERE id_membre = :id_membre");
    $pdoStatement->bindValue(':id_membre', $idMembre, PDO::PARAM_INT); 
    $pdoStatement->execute();

    $membre = $pdoStatement->fetch(PDO::FETCH_ASSOC);

    if($membre['token'] == 1 )
    {
        if(isset($_GET['mot_de_passe']) && $_GET['mot_de_passe'] == 'change')
        {
    
            $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'> 
                                Votre mot de passe a été changé
                                </div>";  
        }
    
        if($_POST) 
        {
            // Préparation de la requête de modification
            $requete = $pdoObject->prepare("UPDATE membre SET mdp=:mdp, token=:token WHERE id_membre = :idMembre ");
            $requete->bindValue(":idMembre", $idMembre, PDO::PARAM_INT);
            $requete->bindValue(":token", generateToken(), PDO::PARAM_INT);
    
    
                if( ($_POST['mdp'] === $_POST['mdp_confirm']) && (!empty($_POST['mdp']) && !empty($_POST['mdp_confirm']) )  )
                {
    
                        $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT); 
                        $requete->bindValue(":mdp", $_POST['mdp'], PDO::PARAM_STR);
                        $requete->execute(); 
                        
                        header("Location:" . URL . "connexion.php?motdepasse=defini"); exit; 
    
                    
                }
                else
                {
                    $erreur .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>
                                    Les mots de passe ne sont pas identiques
                                </div>";
                }
    
        }
        require_once("include/headeradmin.php");
        ?>
    
      <!------------------------------ PAGE NAVIGATEUR ----------------------------------->
      <div class="container page-bart-lord">
    
        <h1 class="display-5 text-center m-4">Définir votre mot de passe</h1>
    
        <?= $notification ?>
        <?= $erreur ?>
    
        <!----------------------------- DEBUT DU FORMULAIRE  ------------------------------->
        <form method="post" class="col-md-6 col-md-offset-3">
    
            <div class="form-group">
                <label for="mdp">Mot de passe</label>
                <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Saisir votre mot de passe">
            </div>
    
            <div class="form-group">
                <label for="mdp_confirm">Confirmation du nouveau mot de passe</label>
                <input type="password" class="form-control" id="mdp_confirm" name="mdp_confirm" placeholder="Confirmer votre mot de passe">
            </div>
            
            <div class="form-group text-center">
                    <button  id="testButton" type="submit" class="btn col-md-12 m-1">Modifier</button>
                </div>
    
        </form>
        <!----------------------------- FIN DU FORMULAIRE  ------------------------------->
    
      </div>
    
    <?php
    }
    else
    {
        header("Location:". URL . "erreur.php?mdp=deja_defini");
    }
    ?>
    

<?php endif; ?>


<!-------------------------------------------------------------------->
<!--------------------- Supprimer le compte -------------------------->
<!-------------------------------------------------------------------->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'supprimer_compte' ))
{
    if($_SESSION["membre"]['id_membre'] != 1)
    {
        $requete = $pdoObject->prepare("DELETE FROM membre WHERE id_membre = :idMembre ");
        $requete->bindValue(":idMembre", $_SESSION["membre"]['id_membre'], PDO::PARAM_INT);
        $requete->execute(); 
       
        $to      = $_SESSION["membre"]['email'];
        $subject = "Compte supprimé";
        $message = "
                    Vous avez supprimé votre compte.
                    Si vous souhaitez récréer un compte, merci de contacter l'adminitrateur principal :
                    bldlr170289@gmail.com" ;
        $headers = 'From: bldlr170289@gmail.com';
       
        mail($to, $subject, $message, $headers);
       
       
        session_destroy();
    
        header("Location:". URL . "connexion.php?compte=supprime&email=" . $_SESSION["membre"]['email']);exit;
    }
    else
    {
        header("Location:". URL . "erreur.php?suppression=impossible");
    }


        
} ?>


<!-------------------------------------------------------------------->
<!--------------------- Supprimer le compte par email ---------------->
<!-------------------------------------------------------------------->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'suppression_compte_mail' ))
{
    $idMembre = $_GET['id_membre'];

    $pdoStatement = $pdoObject->prepare("SELECT * FROM membre WHERE id_membre = :id_membre");
    $pdoStatement->bindValue(':id_membre', $idMembre, PDO::PARAM_INT); 
    $pdoStatement->execute();

    $membre = $pdoStatement->fetch(PDO::FETCH_ASSOC);


    if($membre)
    {
        if($_SESSION["membre"]['id_membre'] != 1)
        {
            $requete = $pdoObject->prepare("DELETE FROM membre WHERE id_membre = :idMembre ");
            $requete->bindValue(":idMembre", $idMembre, PDO::PARAM_INT);
            $requete->execute(); 
        
            header("Location:". URL . "index.php");exit;
        }
        else
        {
            header("Location:". URL . "erreur.php?suppression=impossible");
        }
    }
    else
    {
        header("Location:". URL . "erreur.php?compte_supprime");
    }



        
} ?>




<?php 
require_once("include/footer.php");
?>

<script>

    var loadFile = function(event) {
    
    var image = document.getElementById("image");

    image.src = URL.createObjectURL(event.target.files[0]);

    };
</script>


<script>
    var checker = document.getElementById("checker");
    var checkboxs = document.getElementsByClassName("checkbox");

    checker.addEventListener("click", function(event) {

        if(!checker.checked) {
        Array.prototype.forEach.call(checkboxs, function(checkbox) {
                checkbox.checked = false;
            });
    } else {
        Array.prototype.forEach.call(checkboxs, function(checkbox) {
                checkbox.checked = true;
            });
    }
    
    });

</script>

<script>
    document.querySelector("html").classList.add('js');

    var fileInput  = document.querySelector( ".input-file" ),  
        button     = document.querySelector( ".input-file-trigger" ),
        the_return = document.querySelector(".file-return");
        
    button.addEventListener( "keydown", function( event ) {  
        if ( event.keyCode == 13 || event.keyCode == 32 ) {  
            fileInput.focus();  
        }  
    });
    button.addEventListener( "click", function( event ) {
    fileInput.focus();
    return false;
    });  
    fileInput.addEventListener( "change", function( event ) {  
        the_return.innerHTML = this.value;  
    });  
</script>


<script>
    var valueXp = $('#valueXp');
    var champ = $('#champ');


    valueXp.change(function() {

    var url = "ajax.php";

    var data = {
    'valueXp': valueXp.val(),
    'champ': champ.val()
    };
    console.log(data);

    $.ajax({ 
        type: 'POST',
        dataType: 'json',
        url: url,
        data: data,

        success: function (response) {

            console.log(response);
            var d = new Date();
            var n = d.getFullYear();

            if(response != valueXp.val() )
            {
                if(isNaN(valueXp.val()))
                {
                    $('#modificationBtn').prop('disabled', true);
                }
                else
                {
                    if(valueXp.val() > n)
                    {
                        $('#modificationBtn').prop('disabled', true);
                    }
                    else
                    {
                        $('#modificationBtn').prop('disabled', false);
                    }
                    
                }
                
            }

            else{
                $('#modificationBtn').prop('disabled', true);
            }
                                


        },
        error: function (error) {
    
    console.log( error );
    
    alert("erreur");
    }

    });

    });
    
    
</script>

