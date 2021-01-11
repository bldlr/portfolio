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

    $pdoStatement = $pdoObject->prepare("SELECT * FROM formateur WHERE id_formateur = :id_formateur");
    $pdoStatement->bindValue('id_formateur', 1, PDO::PARAM_INT);
    $pdoStatement->execute();

    $produitExistant = $pdoStatement->fetch(PDO::FETCH_ASSOC);

    foreach($produitExistant as $key => $value)
    {
        $$key = (isset($produitExistant[$key])) ? $produitExistant[$key] : '';
    }

    //echo "<pre>"; print_r($textes); echo "</pre>";die;

    if($_POST) 
    {
        $requete = $pdoObject->prepare("UPDATE formateur SET titre1 = :titre1, titre2 = :titre2 WHERE id_formateur = :id_formateur ");
        $requete->bindValue(":id_formateur", 1, PDO::PARAM_INT);
        $requete->bindValue(":titre1", $_POST['titre1'], PDO::PARAM_STR); 
        $requete->bindValue(":titre2", $_POST['titre2'], PDO::PARAM_STR);
        $requete->execute(); 

        header("Location:". URL . "gestion_formateur.php?action=changer_titre&titre=modifie");exit;
    }

    require_once("include/headeradmin.php");
    ?>

    <div class="container page-bart-lord">

        <div class="retourBackOffice">
            <a class="btn" href="<?= URL ?>admin.php">Retour au back office</a>
        </div>

        <h1 class="display-3 text-center m-4">Formateur Titre</h1>

        <?= $notification ?>

            <form method="post"  class="col-md-6 col-md-offset-3">

                <div class="row">
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" id="valueTitreFormateur1" name="titre1" placeholder="titre noir" value="<?php if(isset($titre1)){ echo $titre1;}?>">
                    </div>

                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" id="valueTitreFormateur2" name="titre2" placeholder="titre jaune" value="<?php if(isset($titre2)){ echo $titre2;}?>">
                    </div>
                </div>

                <div class="row justify-content-center">
                    <button type="submit" id='modificationBtn'  class="col-md-12 btn btn-dark mb-4" disabled="disabled">Enregistrer</button>
                </div>

            </form>

    </div>



<?php endif; ?>


<!-------------------------------------------------------------------->
<!--------------------- Changer l'image  ----------------------------->
<!-------------------------------------------------------------------->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'changer_image' )) :


    if(isset($_GET['image']))
    {
        if($_GET['image'] == 'ajoutee')
        {
            $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                Nouvelle image ajoutée
                            </div>";
        }
        elseif($_GET['image'] == 'aucune')
        {
            $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>
                                Aucune image détectée
                            </div>";
        }
        elseif($_GET['image'] == 'changee')
        {
            $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                Image changée
                            </div>";
        }
        elseif($_GET['image'] == 'supprimee')
        {
            $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                Image supprimée
                            </div>";
        }
        elseif($_GET['image'] == 'supprimees')
        {
            $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                Images supprimées
                            </div>";
        }
        elseif($_GET['image'] == 'erreur')
        {
            $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                impossible
                            </div>";
        }

    }

    if(!empty($_FILES)) 
    {
        $nomImage  = ""; 


        if(!empty($_FILES['image']['name']))
        {
            $nomImage =  date("YmdHis") . $_FILES['image']['name']; 
            $dossierImage = RACINE_IMAGES. $nomImage; 
            copy($_FILES['image']['tmp_name'], $dossierImage); 


            $requete = $pdoObject->prepare("INSERT INTO images (titre, statut) VALUES (:titre, :statut)");
            $requete->bindValue(":titre", $nomImage, PDO::PARAM_STR);
            $requete->bindValue(":statut", 9, PDO::PARAM_INT);
            $requete->execute();
        
            header("Location:". URL . "gestion_formateur.php?action=changer_image&image=ajoutee");exit;
        }
        else
        {
            header("Location:". URL . "gestion_formateur.php?action=changer_image&image=aucune");exit;
        }
        
    }

    $pdoImages = $pdoObject->prepare("SELECT * FROM images WHERE statut = :statut");
    $pdoImages->bindValue(":statut", 9 , PDO::PARAM_INT);
    $pdoImages->execute();

    $images = $pdoImages->fetchAll(PDO::FETCH_ASSOC);

    $imageActuelle = $pdoObject->prepare("SELECT * FROM formateur WHERE id_formateur = :id_formateur");
    $imageActuelle->bindValue(":id_formateur", 1 , PDO::PARAM_INT);
    $imageActuelle->execute();
    $imageActuelle = $imageActuelle->fetch(PDO::FETCH_ASSOC);

    //echo "<pre>"; print_r($textes); echo "</pre>";die;

    if($_POST) 
    {
        //echo "<pre>"; print_r($_POST); echo "</pre>";die;
        if ($_POST['action'] == 'modifier')
        {
            if(isset($_POST['imageRadio'])) 
            {


                if($_POST['imageRadio'] != $imageActuelle['image_id'])
                {
                    $requete = $pdoObject->prepare("UPDATE formateur SET image_id = :image_id WHERE id_formateur = :id_formateur");
                    $requete->bindValue(":image_id", $_POST['imageRadio'], PDO::PARAM_INT);
                    $requete->bindValue(":id_formateur", 1, PDO::PARAM_INT);
                    $requete->execute(); 
                    header("Location:". URL . "gestion_formateur.php?action=changer_image&image=changee");exit;
                }
                else
                {
                    $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>
                                        Aucun changement
                                    </div>";
                }
            }
            else
            {
                $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>
                                    Aucune image sélectionnée
                                </div>";
            }
        } 
        elseif ($_POST['action'] == 'supprimer') 
        {
            if(!empty($_POST['delete']))
            {
                    //echo print_r($_POST['delete']);die;
                    
                    $counter = 0;
        
                    foreach($_POST['delete'] as $delete)
                    {
                        $pdoInfo = $pdoObject->prepare("SELECT * FROM images  WHERE id_image = :idImage");
                        $pdoInfo->bindValue(':idImage', $delete, PDO::PARAM_INT);
                        $pdoInfo->execute();
    
                        $infos = $pdoInfo->fetch(PDO::FETCH_ASSOC);
        
                        $pdoSupp = $pdoObject->prepare("DELETE FROM images WHERE id_image = :idImage");
                        $pdoSupp->bindValue(':idImage', $delete, PDO::PARAM_INT);
                        $pdoSupp->execute();
                        unlink(RACINE_IMAGES . $infos['titre']);
        
        
                        $counter++;
                    }
        
                    
                    if($counter > 1)
                    {
                        header("Location:". URL . "gestion_developpeur.php?action=changer_image&image=supprimees");exit;
                    }
                    else
                    {
                        header("Location:". URL . "gestion_developpeur.php?action=changer_image&image=supprimee");exit;
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

        <h1 class="display-3 text-center m-4">Image Formateur</h1>

        <?= $notification ?>

        <h2 class="text-center">Enregistrer une nouvelle image</h2>

            <form method="post" enctype="multipart/form-data" class="col-md-6 col-md-offset-3">

                <div class="form-group col-md-12">
                                

                    <div class="input-file-container " style='width:225px; margin : 0 auto;'>  
                        <input class="input-file" id="my-file" type="file" name="image" onchange="loadFile(event)">
                        <label tabindex="0" for="my-file" class="input-file-trigger">Sélectionner</label>
                    </div>

                    <div class="col-md-12 text-center">
                        <img id="image" style="width:300px">
                    </div>
                </div>

                
                <div class="row justify-content-center">
                    <button type="submit"  class="col-md-12 btn mb-3 ">Ajouter</button>
                </div>

            </form>

        <h2 class="text-center">Sélectionner une image</h2>
        
            <?php if(!empty($images)) : ?>

                <form action="" method='post'>
                        <table class='table  table-striped text-center mt-3 bgf7'>

                            <thead class="colorBlack">
                                <tr>
                                    <?php for($i=0; $i<$pdoImages->columnCount()  ; $i++) :
                                        $colonne = $pdoImages->getColumnMeta($i); 
                                    ?>
                                        <?php if($colonne['name'] != "statut" && $colonne['name'] != "id_image"): ?>
                                            <?php if($colonne['name'] == "titre"): ?>
                                                <th class="text-center">Image</th>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                    <?php endfor; ?>
                                                <th style="width:200px; text-align:center; padding-right:10px">
                                                    <img src="img/this.png" style="width:15px; margin: 0 auto;" alt="icône de localisation">
                                                </th>

                                                <th style="width:200px; text-align:center; padding-right:10px">
                                                    <img src="img/trash.png" style="width:20px; margin: 0 auto;" alt="icône de suppression">
                                                </th>

                                </tr>
                            </thead>

                            <?php foreach($images as $arrayImages): ?>
                                <tr>
                                    <?php foreach($arrayImages as $key => $value): ?>
                                        <?php if($key != 'statut' && $key != 'id_image'): ?>
                                            <td class="text-center">
                                                <img src="img/imagesUpload/<?= $arrayImages['titre'] ?>" alt="<?= $arrayImages['titre'] ?>" style='width:100px'>
                                            </td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                            <td style='vertical-align: middle;'>
                                                <input type="radio"  name="imageRadio" value="<?= $arrayImages['id_image'] ?>" <?php if($imageActuelle && $arrayImages['id_image'] == $imageActuelle['image_id']) echo 'checked="checked"'; ?> >
                                            </td>



                                            <td style='vertical-align: middle;' >
                                                <div style='width:20px; margin : 0 auto'>
                                                    <input type="checkbox" name='delete[]' class="checkbox" value='<?= $arrayImages['id_image'] ?>'>
                                                </div>
                                            </td>
                                </tr>
                            <?php endforeach; ?>

                                <tr >
                                    <td></td>
                                    <td class="paddingtd">
                                        <div style='margin-top:21px'>
                                            <input type="submit" name="action" value="modifier" class='btn btn-primary pr-0 pl-0' />
                                        </div>
                                    </td>
                                    <td class="paddingtd">
                                        <div style='width:20px; margin : 0 auto 8px auto'>
                                            <input class="checkbox m-0 " id="checker" type="checkbox">
                                        </div>
                                        <input type="submit" name="action" value="supprimer" class='btn btn-primary pr-0 pl-0' onclick="return confirm('Confirmez-vous la suppression ?')" />
                                    </td>
                                </tr>

                        </table>

                    </form>

            <?php else : ?>
                <h4 class='mt-4 text-center'>Il n'y a aucune image</h4>
            <?php endif; ?>



    </div>
    


<?php endif; ?>




<!-------------------------------------------------------------------->
<!--------------------- Gestion langages ----------------------------->
<!-------------------------------------------------------------------->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'gestion_langages' )) : 

    if(isset($_GET['notification']) && ($_GET['notification'] == 'connaissance_enregistree')) 
    {
        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                Connaissance enregistrée
                            </div>";
    }
    if(isset($_GET['notification']) && ($_GET['notification'] == 'connaissance_modifiee')) 
    {
        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                Connaissance modifiée
                            </div>";
    }
    if(isset($_GET['connaissance']) && ($_GET['connaissance'] == 'supprimee')) 
    {
        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                Connaissance supprimée
                            </div>";
    }
    if(isset($_GET['connaissances']) && ($_GET['connaissances'] == 'supprimees')) 
    {
        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                Connaissances supprimées
                            </div>";
    }

    if(isset($_GET['titre']) && ($_GET['titre'] == 'modifie')) 
    {
        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                Titre modifié
                            </div>";
    }

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
                        $pdoInfo = $pdoObject->prepare("SELECT * FROM langages WHERE id_langage = :id_langage");
                        $pdoInfo->bindValue(':id_langage', $delete, PDO::PARAM_INT);
                        $pdoInfo->execute();
    
                        $infos = $pdoInfo->fetch(PDO::FETCH_ASSOC);
        
                        $pdoSupp = $pdoObject->prepare("DELETE FROM langages WHERE id_langage = :id_langage");
                        $pdoSupp->bindValue(':id_langage', $delete, PDO::PARAM_INT);
                        $pdoSupp->execute();
                        unlink(RACINE_IMAGES . $infos['image']);
        
        
                        $counter++;
                    }
        
                    
                    if($counter > 1)
                    {
                        header("Location:". URL . "gestion_formateur.php?action=gestion_langages&connaissances=supprimees");exit;
                    }
                    else
                    {
                        header("Location:". URL . "gestion_formateur.php?action=gestion_langages&connaissance=supprimee");exit;
                    }
        
            }
            else
            {
                $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>
                                    Vous n'avez rien sélectionné
                                </div>";
            }
        
        }
        elseif ($_POST['action_langage'] == 'changer') 
        {

            $requete = $pdoObject->prepare("UPDATE formateur SET titre1 =:titre1 WHERE id_formateur = :id_formateur ");
            $requete->bindValue(':id_formateur', 2, PDO::PARAM_INT);
            $requete->bindValue('titre1', $_POST['valeur'] , PDO::PARAM_STR);
            $requete->execute();

            header("Location:?action=gestion_langages&titre=modifie");
        } 
        elseif ($_POST['action_framework'] == 'changer') 
        {

            $requete = $pdoObject->prepare("UPDATE formateur SET titre1 =:titre1 WHERE id_formateur = :id_formateur ");
            $requete->bindValue(':id_formateur', 3, PDO::PARAM_INT);
            $requete->bindValue('titre1', $_POST['valeur'] , PDO::PARAM_STR);
            $requete->execute();

            header("Location:?action=gestion_langages&titre=modifie");
        } 
        elseif ($_POST['action_cms'] == 'changer') 
        {

            $requete = $pdoObject->prepare("UPDATE formateur SET titre1 =:titre1 WHERE id_formateur = :id_formateur ");
            $requete->bindValue(':id_formateur', 4, PDO::PARAM_INT);
            $requete->bindValue('titre1', $_POST['valeur'] , PDO::PARAM_STR);
            $requete->execute();

            header("Location:?action=gestion_langages&titre=modifie");
        } 
        elseif ($_POST['action_logiciel'] == 'changer') 
        {

            $requete = $pdoObject->prepare("UPDATE formateur SET titre1 =:titre1 WHERE id_formateur = :id_formateur ");
            $requete->bindValue(':id_formateur', 5, PDO::PARAM_INT);
            $requete->bindValue('titre1', $_POST['valeur'] , PDO::PARAM_STR);
            $requete->execute();

            header("Location:?action=gestion_langages&titre=modifie");
        } 
       

    }

    $pdoLangages = $pdoObject->prepare("SELECT * FROM langages WHERE statut = :statut");
    $pdoLangages->bindValue(":statut", 1 , PDO::PARAM_INT);
    $pdoLangages->execute();

    $langages = $pdoLangages->fetchAll(PDO::FETCH_ASSOC);


    $pdoFrameworks = $pdoObject->prepare("SELECT * FROM langages WHERE statut = :statut");
    $pdoFrameworks->bindValue(":statut", 2 , PDO::PARAM_INT);
    $pdoFrameworks->execute();

    $frameworks = $pdoFrameworks->fetchAll(PDO::FETCH_ASSOC);

    $pdoCms = $pdoObject->prepare("SELECT * FROM langages WHERE statut = :statut");
    $pdoCms->bindValue(":statut", 3 , PDO::PARAM_INT);
    $pdoCms->execute();

    $cms = $pdoCms->fetchAll(PDO::FETCH_ASSOC);


    $pdoLogiciels = $pdoObject->prepare("SELECT * FROM langages WHERE statut = :statut");
    $pdoLogiciels->bindValue(":statut", 4 , PDO::PARAM_INT);
    $pdoLogiciels->execute();

    $logiciels = $pdoLogiciels->fetchAll(PDO::FETCH_ASSOC);


    $pdoFormateur = $pdoObject->query("SELECT * FROM formateur");
    $formateur = $pdoFormateur->fetchAll(PDO::FETCH_ASSOC);

    require_once("include/headeradmin.php");
    ?>

    <div class="container page-bart-lord">

        <div class="retourBackOffice">
            <a class="btn" href="<?= URL ?>admin.php">Retour au back office</a>
        </div>
        <div class="retourConnaissances mt-3">
            <a class="btn" href="<?= URL ?>gestion_formateur.php?action=ajouter">Nouvelle connaissance</a>
        </div>

            <h1 class="display-3 text-center m-4">Connaissances</h1>


            <div class="col-md-12">
                <?= $notification ?>
            </div>

            <h2 class="text-center">
                <a href="?action=gestion_langages&modifier=langage">
                    <?= $formateur[1]["titre1"] ?>
                </a>
            </h2>

            <?php if(isset($_GET['action']) && ($_GET['action'] == 'gestion_langages' ) && isset($_GET['modifier']) && $_GET['modifier'] == 'langage' ) :

                //echo "<pre>"; var_dump($_GET['valeur']); echo "</pre>";die;
                $pdoForma = $pdoObject->prepare("SELECT * FROM formateur WHERE id_formateur = :id_formateur");
                $pdoForma->bindValue(':id_formateur', 2, PDO::PARAM_INT);
                $pdoForma->execute();

                $forma = $pdoForma->fetch(PDO::FETCH_ASSOC);
                ?>

                    <form method="post" class="col-md-6 col-md-offset-3 ">

                        <div class="form-group ">
                            <input type="text" class="form-control " id='valueLangage' name="valeur" value="<?= $forma['titre1'];?>"  >
                        </div>

                        <div class="form-group text-center ">
                            <input type="submit" name="action_langage" id="modificationBtn" value="changer" class='btn btn-primary' disabled="disabled" />
                        </div>



                    </form>

            <?php endif;?>

            <?php if(!empty($langages)) : ?>

                <form action="" method='post'>
                        <table class='table  table-striped text-center mt-3 bgf7'>

                            <thead class="colorBlack">
                                <tr>
                                    <?php for($i=0; $i<$pdoLangages->columnCount()  ; $i++) :
                                        $colonne = $pdoLangages->getColumnMeta($i); 
                                    ?>
                                        <?php if($colonne['name'] != "statut" && $colonne['name'] != "id_langage"): ?>
                                            <?php if($colonne['name'] == "titre"): ?>
                                                <th style="width:25%;" class="text-center">Nom</th>
                                            <?php elseif($colonne['name'] == "image"): ?>
                                                <th style="width:25%;" class="text-center">Image</th>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                    <?php endfor; ?>
                                                <th style="width:25%; text-align:center; padding-right:10px">
                                                    <img src="img/setting.png" style="width:20px; margin: 0 auto;" alt="icône de localisation">
                                                </th>

                                                <th style="width:25%; text-align:center; padding-right:10px">
                                                    <img src="img/trash.png" style="width:20px; margin: 0 auto;" alt="icône de suppression">
                                                </th>

                                </tr>
                            </thead>

                            <?php foreach($langages as $arrayLangages): ?>
                                <tr>
                                    <?php foreach($arrayLangages as $key => $value): ?>
                                        <?php if($key == 'titre'): ?>
                                            <td class="text-center" style='vertical-align: middle;'>
                                                <?= $value ?>
                                            </td>
                                        <?php elseif($key == "image"): ?>
                                            <td class="text-center">
                                            <img src="img/imagesUpload/<?= $value ?>" alt="<?= $value ?>" style='width:40px'>
                                            
                                            </td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                            <td style='vertical-align: middle;'>
                                                <a href="?action=modifier&id_langage=<?= $arrayLangages['id_langage'] ?>">
                                                    <img src="img/setting.png" style="width:20px; margin: 0 auto;" alt="icône de localisation">
                                                </a>
                                            </td>



                                            <td style='vertical-align: middle;' >
                                                <div style='width:20px; margin : 0 auto'>
                                                    <input type="checkbox" name='delete[]' class="checkbox1" value='<?= $arrayLangages['id_langage'] ?>'>
                                                </div>
                                            </td>
                                </tr>
                            <?php endforeach; ?>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="paddingtd">
                                        
                                        <div style='width:20px; margin : 0 auto 8px auto'>
                                            <input class="checkbox1 m-0 " id="checker1" type="checkbox">
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan='2' class="paddingtd text-right">

                                        <input type="submit" name="action" value="supprimer" class='btn btn-primary pr-0 pl-0' onclick="return confirm('Confirmez-vous la suppression ?')" />
                                    </td>
                                </tr>

                        </table>

                    </form>

            <?php else : ?>
                <h4 class='mt-4 text-center'>Il n'y a aucun langage</h4>
            <?php endif; ?>


            <h2 class="text-center">
                <a href="?action=gestion_langages&modifier=framework">
                    <?= $formateur[2]["titre1"] ?>
                </a>
            </h2>

            <?php if(isset($_GET['action']) && ($_GET['action'] == 'gestion_langages' ) && isset($_GET['modifier']) && $_GET['modifier'] == 'framework' ) :

                //echo "<pre>"; var_dump($_GET['valeur']); echo "</pre>";die;
                $pdoForma = $pdoObject->prepare("SELECT * FROM formateur WHERE id_formateur = :id_formateur");
                $pdoForma->bindValue(':id_formateur', 3, PDO::PARAM_INT);
                $pdoForma->execute();

                $forma = $pdoForma->fetch(PDO::FETCH_ASSOC);
                ?>

                    <form method="post" class="col-md-6 col-md-offset-3 ">

                        <div class="form-group ">
                            <input type="text" class="form-control " id='valueFramework' name="valeur" value="<?= $forma['titre1'];?>"  >
                        </div>

                        <div class="form-group text-center ">
                            <input type="submit" name="action_framework" id="modificationBtn" value="changer" class='btn btn-primary' disabled="disabled" />
                        </div>



                    </form>

            <?php endif;?>

            <?php if(!empty($frameworks)) : ?>

                <form action="" method='post'>
                        <table class='table  table-striped text-center mt-3 bgf7'>

                            <thead class="colorBlack">
                                <tr>
                                    <?php for($i=0; $i<$pdoFrameworks->columnCount()  ; $i++) :
                                        $colonne = $pdoFrameworks->getColumnMeta($i); 
                                    ?>
                                        <?php if($colonne['name'] != "statut" && $colonne['name'] != "id_langage"): ?>
                                            <?php if($colonne['name'] == "titre"): ?>
                                                <th style="width:25%;" class="text-center">Nom</th>
                                            <?php elseif($colonne['name'] == "image"): ?>
                                                <th style="width:25%;" class="text-center">Image</th>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                    <?php endfor; ?>
                                                <th style="width:25%; text-align:center; padding-right:10px">
                                                    <img src="img/setting.png" style="width:20px; margin: 0 auto;" alt="icône de localisation">
                                                </th>

                                                <th style="width:25%; text-align:center; padding-right:10px">
                                                    <img src="img/trash.png" style="width:20px; margin: 0 auto;" alt="icône de suppression">
                                                </th>

                                </tr>
                            </thead>

                            <?php foreach($frameworks as $arrayFrameworks): ?>
                                <tr>
                                    <?php foreach($arrayFrameworks as $key => $value): ?>
                                        <?php if($key == 'titre'): ?>
                                            <td class="text-center" style='vertical-align: middle;'>
                                                <?= $value ?>
                                            </td>
                                        <?php elseif($key == "image"): ?>
                                            <td class="text-center">
                                            <img src="img/imagesUpload/<?= $value ?>" alt="<?= $value ?>" style='width:40px'>
                                            
                                            </td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                            <td style='vertical-align: middle;'>
                                                <a href="?action=modifier&id_langage=<?= $arrayFrameworks['id_langage'] ?>">
                                                    <img src="img/setting.png" style="width:20px; margin: 0 auto;" alt="icône de localisation">
                                                </a>
                                            </td>



                                            <td style='vertical-align: middle;' >
                                                <div style='width:20px; margin : 0 auto'>
                                                    <input type="checkbox" name='delete[]' class="checkbox2" value='<?= $arrayFrameworks['id_langage'] ?>'>
                                                </div>
                                            </td>
                                </tr>
                            <?php endforeach; ?>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="paddingtd">
                                        
                                        <div style='width:20px; margin : 0 auto 8px auto'>
                                            <input class="checkbox2 m-0 " id="checker2" type="checkbox">
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan='2' class="paddingtd text-right">

                                        <input type="submit" name="action" value="supprimer" class='btn btn-primary pr-0 pl-0' onclick="return confirm('Confirmez-vous la suppression ?')" />
                                    </td>
                                </tr>

                        </table>

                    </form>

            <?php else : ?>
                <h4 class='mt-4 text-center'>Il n'y a aucun framework</h4>
            <?php endif; ?>


            <h2 class="text-center">
                <a href="?action=gestion_langages&modifier=cms">
                    <?= $formateur[3]["titre1"] ?>
                </a>
            </h2>

            <?php if(isset($_GET['action']) && ($_GET['action'] == 'gestion_langages' ) && isset($_GET['modifier']) && $_GET['modifier'] == 'cms' ) :

                //echo "<pre>"; var_dump($_GET['valeur']); echo "</pre>";die;
                $pdoForma = $pdoObject->prepare("SELECT * FROM formateur WHERE id_formateur = :id_formateur");
                $pdoForma->bindValue(':id_formateur', 4, PDO::PARAM_INT);
                $pdoForma->execute();

                $forma = $pdoForma->fetch(PDO::FETCH_ASSOC);
                ?>

                    <form method="post" class="col-md-6 col-md-offset-3 ">

                        <div class="form-group ">
                            <input type="text" class="form-control " id='valueCms' name="valeur" value="<?= $forma['titre1'];?>"  >
                        </div>

                        <div class="form-group text-center ">
                            <input type="submit" name="action_cms" id="modificationBtn" value="changer" class='btn btn-primary' disabled="disabled" />
                        </div>



                    </form>

            <?php endif;?>

            <?php if(!empty($cms)) : ?>

                <form action="" method='post'>
                        <table class='table  table-striped text-center mt-3 bgf7'>

                            <thead class="colorBlack">
                                <tr>
                                    <?php for($i=0; $i<$pdoCms->columnCount()  ; $i++) :
                                        $colonne = $pdoCms->getColumnMeta($i); 
                                    ?>
                                        <?php if($colonne['name'] != "statut" && $colonne['name'] != "id_langage"): ?>
                                            <?php if($colonne['name'] == "titre"): ?>
                                                <th style="width:25%;" class="text-center">Nom</th>
                                            <?php elseif($colonne['name'] == "image"): ?>
                                                <th style="width:25%;" class="text-center">Image</th>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                    <?php endfor; ?>
                                                <th style="width:25%; text-align:center; padding-right:10px">
                                                    <img src="img/setting.png" style="width:20px; margin: 0 auto;" alt="icône de localisation">
                                                </th>

                                                <th style="width:25%; text-align:center; padding-right:10px">
                                                    <img src="img/trash.png" style="width:20px; margin: 0 auto;" alt="icône de suppression">
                                                </th>

                                </tr>
                            </thead>

                            <?php foreach($cms as $arrayCms): ?>
                                <tr>
                                    <?php foreach($arrayCms as $key => $value): ?>
                                        <?php if($key == 'titre'): ?>
                                            <td class="text-center" style='vertical-align: middle;'>
                                                <?= $value ?>
                                            </td>
                                        <?php elseif($key == "image"): ?>
                                            <td class="text-center">
                                            <img src="img/imagesUpload/<?= $value ?>" alt="<?= $value ?>" style='width:40px'>
                                            
                                            </td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                            <td style='vertical-align: middle;'>
                                                <a href="?action=modifier&id_langage=<?= $arrayCms['id_langage'] ?>">
                                                    <img src="img/setting.png" style="width:20px; margin: 0 auto;" alt="icône de localisation">
                                                </a>
                                            </td>



                                            <td style='vertical-align: middle;' >
                                                <div style='width:20px; margin : 0 auto'>
                                                    <input type="checkbox" name='delete[]' class="checkbox3" value='<?= $arrayCms['id_langage'] ?>'>
                                                </div>
                                            </td>
                                </tr>
                            <?php endforeach; ?>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="paddingtd">
                                        
                                        <div style='width:20px; margin : 0 auto 8px auto'>
                                            <input class="checkbox3 m-0 " id="checker3" type="checkbox">
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan='2' class="paddingtd text-right">

                                        <input type="submit" name="action" value="supprimer" class='btn btn-primary pr-0 pl-0' onclick="return confirm('Confirmez-vous la suppression ?')" />
                                    </td>
                                </tr>

                        </table>

                    </form>

            <?php else : ?>
                <h4 class='mt-4 text-center'>Il n'y a aucun cms</h4>
            <?php endif; ?>


            <h2 class="text-center">
                <a href="?action=gestion_langages&modifier=logiciel">
                    <?= $formateur[4]["titre1"] ?>
                </a>
            </h2>

            <?php if(isset($_GET['action']) && ($_GET['action'] == 'gestion_langages' ) && isset($_GET['modifier']) && $_GET['modifier'] == 'logiciel' ) :

                //echo "<pre>"; var_dump($_GET['valeur']); echo "</pre>";die;
                $pdoForma = $pdoObject->prepare("SELECT * FROM formateur WHERE id_formateur = :id_formateur");
                $pdoForma->bindValue(':id_formateur', 5, PDO::PARAM_INT);
                $pdoForma->execute();

                $forma = $pdoForma->fetch(PDO::FETCH_ASSOC);
                ?>

                    <form method="post" class="col-md-6 col-md-offset-3 ">

                        <div class="form-group ">
                            <input type="text" class="form-control " id='valueLogiciel' name="valeur" value="<?= $forma['titre1'];?>"  >
                        </div>

                        <div class="form-group text-center ">
                            <input type="submit" name="action_logiciel" id="modificationBtn" value="changer" class='btn btn-primary' disabled="disabled" />
                        </div>



                    </form>

            <?php endif;?>

            <?php if(!empty($logiciels)) : ?>

                <form action="" method='post'>
                        <table class='table  table-striped text-center mt-3 bgf7'>

                            <thead class="colorBlack">
                                <tr>
                                    <?php for($i=0; $i<$pdoLogiciels->columnCount()  ; $i++) :
                                        $colonne = $pdoLogiciels->getColumnMeta($i); 
                                    ?>
                                        <?php if($colonne['name'] != "statut" && $colonne['name'] != "id_langage"): ?>
                                            <?php if($colonne['name'] == "titre"): ?>
                                                <th style="width:25%;" class="text-center">Nom</th>
                                            <?php elseif($colonne['name'] == "image"): ?>
                                                <th style="width:25%;" class="text-center">Image</th>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                    <?php endfor; ?>
                                                <th style="width:25%; text-align:center; padding-right:10px">
                                                    <img src="img/setting.png" style="width:20px; margin: 0 auto;" alt="icône de localisation">
                                                </th>

                                                <th style="width:25%; text-align:center; padding-right:10px">
                                                    <img src="img/trash.png" style="width:20px; margin: 0 auto;" alt="icône de suppression">
                                                </th>

                                </tr>
                            </thead>

                            <?php foreach($logiciels as $arrayLogiciel): ?>
                                <tr>
                                    <?php foreach($arrayLogiciel as $key => $value): ?>
                                        <?php if($key == 'titre'): ?>
                                            <td class="text-center" style='vertical-align: middle;'>
                                                <?= $value ?>
                                            </td>
                                        <?php elseif($key == "image"): ?>
                                            <td class="text-center">
                                            <img src="img/imagesUpload/<?= $value ?>" alt="<?= $value ?>" style='width:40px'>
                                            
                                            </td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                            <td style='vertical-align: middle;'>
                                                <a href="?action=modifier&id_langage=<?= $arrayLogiciel['id_langage'] ?>">
                                                    <img src="img/setting.png" style="width:20px; margin: 0 auto;" alt="icône de localisation">
                                                </a>
                                            </td>



                                            <td style='vertical-align: middle;' >
                                                <div style='width:20px; margin : 0 auto'>
                                                    <input type="checkbox" name='delete[]' class="checkbox4" value='<?= $arrayLogiciel['id_langage'] ?>'>
                                                </div>
                                            </td>
                                </tr>
                            <?php endforeach; ?>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="paddingtd">
                                        
                                        <div style='width:20px; margin : 0 auto 8px auto'>
                                            <input class="checkbox4 m-0 " id="checker4" type="checkbox">
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan='2' class="paddingtd text-right">

                                        <input type="submit" name="action" value="supprimer" class='btn btn-primary pr-0 pl-0' onclick="return confirm('Confirmez-vous la suppression ?')" />
                                    </td>
                                </tr>

                        </table>

                    </form>

            <?php else : ?>
                <h4 class='mt-4 text-center'>Il n'y a aucun logiciel</h4>
            <?php endif; ?>
   


<?php endif; ?>



<!-------------------------------------------------------------------->
<!--------------------- Ajouter ou modifier un langage --------------->
<!-------------------------------------------------------------------->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'ajouter' ||  $_GET['action'] == 'modifier' )) :

    if(isset($_GET['id_langage']))
    {
            $pdoStatement = $pdoObject->prepare("SELECT * FROM langages WHERE id_langage = :id_langage");
            $pdoStatement->bindValue('id_langage', $_GET['id_langage'], PDO::PARAM_INT);
            $pdoStatement->execute();

            $produitExistant = $pdoStatement->fetch(PDO::FETCH_ASSOC);
            //echo '<pre>'; print_r($produitExistant); echo '</pre>'; die;
    }

    if(isset($_GET['action']) && ($_GET['action'] == 'modifier'))
    {
        foreach($produitExistant as $key => $value)
        {
            $$key = (isset($produitExistant[$key])) ? $produitExistant[$key] : '';

        }
    }


    if($_POST) // si les données d'un formulaire ont bien été envoyées
    {
        //echo "<pre>";print_r($_POST); "</pre>"; die;
        if( ($_POST['titre'] == NULL || strlen($_POST['titre'] ) < 2 ) )
        {
            $erreur .= "<div class='col-md-6 mt-4 mx-auto alert alert-danger text-center disparition'>
                            Le titre doit contenir 2 caractères minimum
                        </div>";

            $_SESSION['inputs'] = $_POST;
        }
        else
        {
            $nomImage  = ""; // variable existante mais vide du nom de l'image (et pas l'image elle-même)

            if(isset($_GET['action']) && $_GET['action'] == 'modifier')
            {
                $nomImage  = $_POST['imageActuelle'];
            }
            if(!empty($_FILES['image']['name']))
            {
                $nomImage =  date("YmdHis") . $_FILES['image']['name']; 
                $dossierImage = RACINE_IMAGES. $nomImage; 
                copy($_FILES['image']['tmp_name'], $dossierImage); 
            }
        

        if(isset($_GET['action']) && $_GET['action'] == 'ajouter')
        {   

            $requete = $pdoObject->prepare("INSERT INTO langages (titre, image, statut) VALUES (:titre, :image, :statut)");

            $action = "enregistre";
    
        }
        else
        {
            $requete = $pdoObject->prepare("UPDATE langages SET titre=:titre, image=:image, statut=:statut  WHERE id_langage = :id_langage ");
            $requete->bindValue(":id_langage", $_GET['id_langage'], PDO::PARAM_INT);

            $action = "modifie";

        }
        
        
        foreach($_POST as $key => $value)
        // En bouclant la superglobale $_POST, (les données du formulaire) on génère les insertions dans les marqueurs
        {
            if(gettype($value) == 'string') // Si le type de la valeur est STRING 
                $type = PDO::PARAM_STR;
            else // Si le type de la valeur est INTEGER
                $type = PDO::PARAM_INT;

                //-----------------------------------------
            if($key != 'imageActuelle') // On éjecte la variable $imageActuelle car elle est à part, sa valeur vient de notre variable $nomImage
            {
                $requete->bindValue(":$key", $value, $type); // les marqueurs reçoivent leurs variables
            }  
        }
                $requete->bindValue(":image", $nomImage, PDO::PARAM_STR); // le marqueur de l'image reçoit sa variable $nomImage

            $requete->execute(); 

            if(isset($_GET['action']) && $_GET['action'] == 'ajouter')
            { 

                header("Location: ?action=gestion_langages&notification=connaissance_" . $action );
            }
            else
            {
                header("Location: ?action=gestion_langages&notification=connaissance_" . $action );
            }
        }

    }
    require_once("include/headeradmin.php");
    ?>


    <div class="container page-bart-lord">

        <div class="retourBackOffice">
            <a class="btn" href="<?= URL ?>admin.php">Retour au back office</a>
        </div>

        <div class="retourConnaissances mt-3">
            <a class="btn" href="<?= URL ?>gestion_formateur.php?action=gestion_langages">Voir les connaissances</a>
        </div>
        
        <?php 

            if($_GET['action'] == "ajouter")
            {
                echo '<h1 class=" text-center m-4">Ajouter un produit</h1><hr>';
            }
            elseif($_GET['action'] == "modifier")
            {
                echo '<h1 class=" text-center m-4">Modifier : '. $titre .'</h1><hr>';
            }  

        ?>
            <?= $erreur ?>

        <form method="post" enctype="multipart/form-data" class="col-md-6 col-md-offset-3">

            <div class="form-group">
                <label for="titre">Titre</label>
                <input type="text" class="form-control" id="titre" name="titre" placeholder="Saisir le titre" value="<?php 
                if(isset($titre)){ echo $titre;} elseif(isset($_SESSION['inputs']['titre'])){echo $_SESSION['inputs']['titre'];} ?>">
            </div>

            <div class="form-group">
                <select class="form-control" name="statut">
                    <option value="" selected disabled>Choisir</option>
                    <option value="1" <?php if(isset($statut) &&( $statut == 1)){echo "selected";} ?>>Langage</option>
                    <option value="2" <?php if(isset($statut) &&( $statut == 2)){echo "selected";} ?>>Framework</option>
                    <option value="3" <?php if(isset($statut) &&( $statut == 3)){echo "selected";} ?>>CMS</option>
                    <option value="4" <?php if(isset($statut) &&( $statut == 4)){echo "selected";} ?>>Logiciel</option>
                </select>
            </div>


            <div class="form-group">

                <div class="input-file-container " style='width:225px; margin : 0 auto;'>  
                    <input class="input-file" id="my-file" type="file" name="image" onchange="loadFile(event)">
                    <label tabindex="0" for="my-file" class="input-file-trigger">Sélectionner</label>
                </div>
   
                <input type="hidden" id="imageActuelle" name="imageActuelle" value="<?php if(isset($image)) echo $image ?>">   

                <?php if(!empty($image)): ?>

                    <div class="col-md-12 text-center">
                        <img style="width:80px" id="image" src="img/imagesUpload/<?= $image ?>" alt="<?php if(isset($titre)) echo $titre; ?>">
                    </div>

                <?php else : ?>

                    <div class="col-md-12 text-center">
                        <img id="image" style="width:80px">
                    </div>

                <?php endif; ?>

                
            </div>



            
            <div class="row justify-content-center">
                <button type="submit"  class="col-md-12 btn btn-dark mb-4 mt-4 "><?= $_GET['action'] ?></button>
            </div>

        </form>

    </div>

<?php endif; ?>




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
    var checker1 = document.getElementById("checker1");
    var checkboxs1 = document.getElementsByClassName("checkbox1");

    checker1.addEventListener("click", function(event) {

        if(!checker1.checked) {
        Array.prototype.forEach.call(checkboxs1, function(checkbox) {
                checkbox.checked = false;
            });
    } else {
        Array.prototype.forEach.call(checkboxs1, function(checkbox) {
                checkbox.checked = true;
            });
    }
    
    });

</script>

<script>
    var checker2 = document.getElementById("checker2");
    var checkboxs2 = document.getElementsByClassName("checkbox2");

    checker2.addEventListener("click", function(event) {

        if(!checker2.checked) {
        Array.prototype.forEach.call(checkboxs2, function(checkbox) {
                checkbox.checked = false;
            });
    } else {
        Array.prototype.forEach.call(checkboxs2, function(checkbox) {
                checkbox.checked = true;
            });
    }
    
    });

</script>

<script>
    var checker3 = document.getElementById("checker3");
    var checkboxs3 = document.getElementsByClassName("checkbox3");

    checker3.addEventListener("click", function(event) {

        if(!checker3.checked) {
        Array.prototype.forEach.call(checkboxs3, function(checkbox) {
                checkbox.checked = false;
            });
    } else {
        Array.prototype.forEach.call(checkboxs3, function(checkbox) {
                checkbox.checked = true;
            });
    }
    
    });

</script>

<script>
    var checker4 = document.getElementById("checker4");
    var checkboxs4 = document.getElementsByClassName("checkbox4");

    checker4.addEventListener("click", function(event) {

        if(!checker4.checked) {
        Array.prototype.forEach.call(checkboxs4, function(checkbox) {
                checkbox.checked = false;
            });
    } else {
        Array.prototype.forEach.call(checkboxs4, function(checkbox) {
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
    var valueTitreFormateur1 = $('#valueTitreFormateur1');

    valueTitreFormateur1.change(function() {

    var url = "ajax.php";

    var data = {
    'valueTitreFormateur1': valueTitreFormateur1.val()
    };
    console.log(data);

    $.ajax({ 
        type: 'POST',
        dataType: 'json',
        url: url,
        data: data,

        success: function (response) {

            console.log(response);

            if(response != valueTitreFormateur1.val() )
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
    var valueTitreFormateur2 = $('#valueTitreFormateur2');

    valueTitreFormateur2.change(function() {

    var url = "ajax.php";

    var data = {
    'valueTitreFormateur2': valueTitreFormateur2.val()
    };
    console.log(data);

    $.ajax({ 
        type: 'POST',
        dataType: 'json',
        url: url,
        data: data,

        success: function (response) {

            console.log(response);

            if(response != valueTitreFormateur2.val() )
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
    var valueLangage = $('#valueLangage');

    valueLangage.change(function() {

    var url = "ajax.php";

    var data = {
    'valueLangage': valueLangage.val()
    };
    console.log(data);

    $.ajax({ 
        type: 'POST',
        dataType: 'json',
        url: url,
        data: data,

        success: function (response) {

            console.log(response);

            if(response != valueLangage.val() )
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
    var valueFramework = $('#valueFramework');

    valueFramework.change(function() {

    var url = "ajax.php";

    var data = {
    'valueFramework': valueFramework.val()
    };
    console.log(data);

    $.ajax({ 
        type: 'POST',
        dataType: 'json',
        url: url,
        data: data,

        success: function (response) {

            console.log(response);

            if(response != valueFramework.val() )
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
    var valueCms = $('#valueCms');

    valueCms.change(function() {

    var url = "ajax.php";

    var data = {
    'valueCms': valueCms.val()
    };
    console.log(data);

    $.ajax({ 
        type: 'POST',
        dataType: 'json',
        url: url,
        data: data,

        success: function (response) {

            console.log(response);

            if(response != valueCms.val() )
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
    var valueLogiciel = $('#valueLogiciel');

    valueLogiciel.change(function() {

    var url = "ajax.php";

    var data = {
    'valueLogiciel': valueLogiciel.val()
    };
    console.log(data);

    $.ajax({ 
        type: 'POST',
        dataType: 'json',
        url: url,
        data: data,

        success: function (response) {

            console.log(response);

            if(response != valueLogiciel.val() )
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