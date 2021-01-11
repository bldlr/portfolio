<?php 
require_once("include/init.php");


if(!adminConnecte() && !superAdminConnecte())
{
  header("Location:" . URL . "index.php"); exit;
}


?>

<!-------------------------------------------------------------------->
<!--------------------- Changer Titre -------------------------------->
<!-------------------------------------------------------------------->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'changer_titre' )) :


    if(isset($_GET['titre']) && ($_GET['titre'] == 'modifie')) 
    {
        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                Titre modifié
                            </div>";
    }

    $pdoStatement = $pdoObject->prepare("SELECT * FROM coordonnee WHERE id_coordonnee = :id_coordonnee");
    $pdoStatement->bindValue('id_coordonnee', 6, PDO::PARAM_INT);
    $pdoStatement->execute();

    $produitExistant = $pdoStatement->fetch(PDO::FETCH_ASSOC);

    foreach($produitExistant as $key => $value)
    {
        $$key = (isset($produitExistant[$key])) ? $produitExistant[$key] : '';
    }

    //echo "<pre>"; print_r($textes); echo "</pre>";die;

    if($_POST) 
    {
        $requete = $pdoObject->prepare("UPDATE coordonnee SET titre = :titre, nom = :nom WHERE id_coordonnee = :id_coordonnee ");
        $requete->bindValue(":id_coordonnee", 6, PDO::PARAM_INT);
        $requete->bindValue(":titre", $_POST['titre'], PDO::PARAM_STR); 
        $requete->bindValue(":nom", $_POST['nom'], PDO::PARAM_STR);
        $requete->execute(); 

        header("Location:". URL . "gestion_contact.php?action=changer_titre&titre=modifie");exit;
    }

    require_once("include/headeradmin.php");
    ?>

    <div class="container page-bart-lord">

        <div class="retourBackOffice">
            <a class="btn" href="<?= URL ?>admin.php">Retour au back office</a>
        </div>

        <h1 class="display-3 text-center m-4">contact Titre</h1>

        <?= $notification ?>

            <form method="post"  class="col-md-6 col-md-offset-3">

                <div class="row">
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" id="valueTitreContact1" name="titre" placeholder="titre noir" value="<?php if(isset($titre)){ echo $titre;}?>">
                    </div>

                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" id="valueTitreContact2" name="nom" placeholder="titre jaune" value="<?php if(isset($nom)){ echo $nom;}?>">
                    </div>
                </div>

                <div class="row justify-content-center">
                    <button type="submit" id='modificationBtn'  class="col-md-12 btn btn-dark mb-4" disabled="disabled">Enregistrer</button>
                </div>

            </form>

    </div>



<?php endif; ?>

<!-------------------------------------------------------------------->
<!--------------------- Changer coordonnées -------------------------->
<!-------------------------------------------------------------------->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'changer_coordonnees' )) :


    if(isset($_GET['coordonnee']) && ($_GET['coordonnee'] == 'modifier')) 
    {
        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                            la coordonnée a bien été modifiée
                        </div>";
    }


    $pdoCoordonnee = $pdoObject->query("SELECT * FROM coordonnee WHERE id_coordonnee IN (1,2,3,4) ");
    $coordonnees = $pdoCoordonnee->fetchAll(PDO::FETCH_ASSOC);


    if($_POST)
    {
        $requete = $pdoObject->prepare("UPDATE coordonnee SET nom =:nom WHERE id_coordonnee = :idCoordonnee ");
        $requete->bindValue(':idCoordonnee', $_POST['id_coordonnee'], PDO::PARAM_INT);
        $requete->bindValue(':nom', $_POST['nom'] , PDO::PARAM_STR);
        $requete->execute();

        header("Location:?action=changer_coordonnees&id_coordonnee=" . $_GET['id_coordonnee'] . "&coordonnee=modifier");
    }
    require_once("include/headeradmin.php");
    ?>

    <!------------------------------ PAGE NAVIGATEUR ----------------------------------->

        <div class="container page-bart-lord">

            <div class="retourBackOffice">
                <a class="btn" href="<?= URL ?>admin.php">Retour au back office</a>
            </div>

        <h1 class="display-3 text-center m-4">Gestion des coordonnées</h1>

        <?= $erreur ?>
        <?= $notification ?>

        <table class='table  table-striped text-center mt-3' style='background:#f7f7f7'>
                <thead style='color:#272727'>
                    <tr>

                        <?php for($i=0; $i<$pdoCoordonnee->columnCount()  ; $i++) :
                            $colonne = $pdoCoordonnee->getColumnMeta($i); ?>

                                <?php if($colonne['name'] != "id_coordonnee"): ?>

                                        <th class="text-center"><?= $colonne['name'] ?></th>

                                <?php endif; ?>

                        <?php endfor; ?>

                        <th class="text-center ">Modifier</th>
                    </tr>
                </thead>


            <?php foreach($coordonnees as $coordonnee): ?>

                <tr>

                    <?php foreach($coordonnee as $key => $value): ?>

                            <?php if($key != "id_coordonnee"): ?>

                                <td class="text-center text-dark"><?= $value ?></td>

                            <?php endif; ?>
                        
                    <?php endforeach; ?>

                    <td class="text-center">
                        <a href='?action=changer_coordonnees&modifier=coordonnee&id_coordonnee=<?=$coordonnee['id_coordonnee']?>'>
                            <img style='width:25px' src="img/edit.png" alt='icone edit'>
                        </a>
                    </td>
                </tr>

            <?php endforeach; ?>

        </table>


        <?php if(isset($_GET['modifier']) && $_GET['modifier'] == 'coordonnee') : 

            $pdoCoordonnee = $pdoObject->prepare("SELECT * FROM coordonnee WHERE id_coordonnee = :id_coordonnee");
            $pdoCoordonnee->bindValue(':id_coordonnee', $_GET['id_coordonnee'], PDO::PARAM_INT);
            $pdoCoordonnee->execute();

            $coordonnee = $pdoCoordonnee->fetch(PDO::FETCH_ASSOC);
            ?>

            <form method="post" class="col-md-6 col-md-offset-3 ">

                <div class="form-group ">
                    <input type="text" class="form-control " id="valueCoordonne" name="nom" value="<?= $coordonnee['nom'];?>" >
                    <input type="hidden" name="id_coordonnee" id="id_coordonnee" value="<?= $coordonnee['id_coordonnee'];?>" >
                </div>

                <div class="form-group text-center">
                    <button  id="modificationBtn" type="submit" class="btn col-md-12 m-1" disabled="disabled">Modifier</button>
                </div>

            </form>

        <?php endif;?>


    


<?php endif; ?>

<!-------------------------------------------------------------------->
<!--------------------- Changer email -------------------------------->
<!-------------------------------------------------------------------->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'changer_email' )) :

    if(isset($_GET['email']) && ($_GET['email'] == 'modifier')) 
    {
        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                            l'email du formlulaire a bien été modifié
                        </div>";
    }


    $pdoCoordonnee = $pdoObject->query("SELECT * FROM coordonnee WHERE id_coordonnee = 5");
    $coordonnees = $pdoCoordonnee->fetchAll(PDO::FETCH_ASSOC);


    if($_POST)
    {
        $requete = $pdoObject->prepare("UPDATE coordonnee SET nom =:nom WHERE id_coordonnee = :idCoordonnee ");
        $requete->bindValue(':idCoordonnee', $_POST['id_coordonnee'], PDO::PARAM_INT);
        $requete->bindValue(':nom', $_POST['nom'] , PDO::PARAM_STR);
        $requete->execute();

        header("Location:?action=changer_email&id_coordonnee=" . $_GET['id_coordonnee'] . "&email=modifier");
    }
    require_once("include/headeradmin.php");
    ?>

    <!------------------------------ PAGE NAVIGATEUR ----------------------------------->

    <div class="container page-bart-lord">

        <div class="retourBackOffice">
            <a class="btn" href="<?= URL ?>admin.php">Retour au back office</a>
        </div>

    <h1 class="text-center m-4">Gestion de l'email du formulaire</h1>

    <?= $erreur ?>
    <?= $notification ?>

    <table class='table  table-striped text-center mt-3' style='background:#f7f7f7'>
            <thead style='color:#272727'>
                <tr>

                    <?php for($i=0; $i<$pdoCoordonnee->columnCount()  ; $i++) :
                        $colonne = $pdoCoordonnee->getColumnMeta($i); ?>

                            <?php if($colonne['name'] != "id_coordonnee"): ?>

                                    <th class="text-center"><?= $colonne['name'] ?></th>

                            <?php endif; ?>

                    <?php endfor; ?>

                    <th class="text-center ">Modifier</th>
                </tr>
            </thead>


        <?php foreach($coordonnees as $coordonnee): ?>

            <tr>

                <?php foreach($coordonnee as $key => $value): ?>

                        <?php if($key != "id_coordonnee"): ?>

                            <td class="text-center text-dark"><?= $value ?></td>

                        <?php endif; ?>
                    
                <?php endforeach; ?>

                <td class="text-center">
                    <a href='?action=changer_email&modifier=coordonnee&id_coordonnee=<?=$coordonnee['id_coordonnee']?>'>
                        <img style='width:25px' src="img/edit.png" alt='icone edit'>
                    </a>
                </td>
            </tr>

        <?php endforeach; ?>

    </table>


    <?php if(isset($_GET['modifier']) && $_GET['modifier'] == 'coordonnee') : 

        $pdoCoordonnee = $pdoObject->prepare("SELECT * FROM coordonnee WHERE id_coordonnee = :id_coordonnee");
        $pdoCoordonnee->bindValue(':id_coordonnee', $_GET['id_coordonnee'], PDO::PARAM_INT);
        $pdoCoordonnee->execute();

        $coordonnee = $pdoCoordonnee->fetch(PDO::FETCH_ASSOC);
        ?>

            <form method="post" class="col-md-6 col-md-offset-3 ">

                    <div class="form-group ">
                        <input type="text" class="form-control " id="valueCoordonne" name="nom" value="<?= $coordonnee['nom'];?>" >
                        <input type="hidden" name="id_coordonnee" id="id_coordonnee" value="<?= $coordonnee['id_coordonnee'];?>" >
                    </div>
                

                <div class="form-group text-center">
                    <button  id="modificationBtn" type="submit" class="btn col-md-12 m-1" disabled="disabled">Modifier</button>
                </div>
            </form>

    <?php endif;?>
    


<?php endif; ?>








<?php 
require_once("include/footer.php");
?>



<script>
    var valueCoordonne = $('#valueCoordonne');
    var id_coordonnee = $('#id_coordonnee');


    valueCoordonne.change(function() {

    var url = "ajax.php";

    var data = {
    'valueCoordonne': valueCoordonne.val(),
    'id': id_coordonnee.val()
    };
    console.log(data);

    $.ajax({ 
        type: 'POST',
        dataType: 'json',
        url: url,
        data: data,

        success: function (responseText) {

            console.log(responseText);

            if(responseText != valueCoordonne.val() )
            {
                $('#modificationBtn').prop('disabled', false);
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

<script>
    var valueTitreContact1 = $('#valueTitreContact1');

    valueTitreContact1.change(function() {

    var url = "ajax.php";

    var data = {
    'valueTitreContact1': valueTitreContact1.val()
    };
    console.log(data);

    $.ajax({ 
        type: 'POST',
        dataType: 'json',
        url: url,
        data: data,

        success: function (response) {

            console.log(response);

            if(response != valueTitreContact1.val() )
            {
                $('#modificationBtn').prop('disabled', false);
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


<script>
    var valueTitreContact2 = $('#valueTitreContact2');

    valueTitreContact2.change(function() {

    var url = "ajax.php";

    var data = {
    'valueTitreContact2': valueTitreContact2.val()
    };
    console.log(data);

    $.ajax({ 
        type: 'POST',
        dataType: 'json',
        url: url,
        data: data,

        success: function (response) {

            console.log(response);

            if(response != valueTitreContact2.val() )
            {
                $('#modificationBtn').prop('disabled', false);
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