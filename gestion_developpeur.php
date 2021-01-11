<?php 
require_once("include/init.php");


if(!adminConnecte() && !superAdminConnecte())
{
  header("Location:" . URL . "index.php"); exit;
}


?>


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
            $requete->bindValue(":statut", 4, PDO::PARAM_INT);
            $requete->execute();
        
            header("Location:". URL . "gestion_developpeur.php?action=changer_image&image=ajoutee");exit;
        }
        else
        {
            header("Location:". URL . "gestion_developpeur.php?action=changer_image&image=aucune");exit;
        }
        
    }

    $pdoImages = $pdoObject->prepare("SELECT * FROM images WHERE statut = :statut");
    $pdoImages->bindValue(":statut", 4 , PDO::PARAM_INT);
    $pdoImages->execute();

    $images = $pdoImages->fetchAll(PDO::FETCH_ASSOC);

    $imageActuelle = $pdoObject->prepare("SELECT * FROM developpeur WHERE id_developpeur = :id_developpeur");
    $imageActuelle->bindValue(":id_developpeur", 1 , PDO::PARAM_INT);
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
                    $requete = $pdoObject->prepare("UPDATE developpeur SET image_id = :image_id WHERE id_developpeur = :id_developpeur");
                    $requete->bindValue(":image_id", $_POST['imageRadio'], PDO::PARAM_INT);
                    $requete->bindValue(":id_developpeur", 1, PDO::PARAM_INT);
                    $requete->execute(); 
                    header("Location:". URL . "gestion_developpeur.php?action=changer_image&image=changee");exit;
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

        <h1 class="display-3 text-center m-4">Image Dévelloppeur</h1>

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
<!--------------------- Changer l'experience ------------------------->
<!-------------------------------------------------------------------->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'changer_experience' )) :

    if(isset($_GET['action_experience']) && ($_GET['action_experience'] == 'modifier')) 
    {
        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                Expérience modifiée
                            </div>";
    }
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
            $nomImage =  $_FILES['image']['name']; 
            $dossierImage = RACINE_IMAGES. $nomImage; 
            copy($_FILES['image']['tmp_name'], $dossierImage); 


            $requete = $pdoObject->prepare("INSERT INTO images (titre, statut) VALUES (:titre, :statut)");
            $requete->bindValue(":titre", $nomImage, PDO::PARAM_STR);
            $requete->bindValue(":statut", 5, PDO::PARAM_INT);
            $requete->execute();
        
            header("Location:". URL . "gestion_developpeur.php?action=changer_experience&image=ajoutee");exit;
        }
        else
        {
            header("Location:". URL . "gestion_developpeur.php?action=changer_experience&image=aucune");exit;
        }
        
    }

    $pdoImages = $pdoObject->prepare("SELECT * FROM images WHERE statut = :statut");
    $pdoImages->bindValue(":statut", 5 , PDO::PARAM_INT);
    $pdoImages->execute();

    $images = $pdoImages->fetchAll(PDO::FETCH_ASSOC);

    $imageActuelle = $pdoObject->prepare("SELECT * FROM developpeur WHERE id_developpeur = :id_developpeur");
    $imageActuelle->bindValue(":id_developpeur", 1 , PDO::PARAM_INT);
    $imageActuelle->execute();
    $imageActuelle = $imageActuelle->fetch(PDO::FETCH_ASSOC);


    $pdoTextes = $pdoObject->query("SELECT xp FROM developpeur WHERE id_developpeur = 1");
    $textes = $pdoTextes->fetch(PDO::FETCH_ASSOC);
    //echo "<pre>"; print_r($textes); echo "</pre>";die;

    if($_POST) 
    {
        //echo "<pre>"; print_r($_POST); echo "</pre>";die;
        if ($_POST['action'] == 'modifier')
        {
            if(isset($_POST['imageRadio'])) 
            {


                if($_POST['imageRadio'] != $imageActuelle['image_xp_id'])
                {
                    $requete = $pdoObject->prepare("UPDATE developpeur SET image_xp_id = :image_xp_id WHERE id_developpeur = :id_developpeur");
                    $requete->bindValue(":image_xp_id", $_POST['imageRadio'], PDO::PARAM_INT);
                    $requete->bindValue(":id_developpeur", 1, PDO::PARAM_INT);
                    $requete->execute(); 
                    header("Location:". URL . "gestion_developpeur.php?action=changer_experience&image=changee");exit;
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
                        header("Location:". URL . "gestion_developpeur.php?action=changer_experience&image=supprimees");exit;
                    }
                    else
                    {
                        header("Location:". URL . "gestion_developpeur.php?action=changer_experience&image=supprimee");exit;
                    }
        
            }
            else
            {
                $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>
                                    Vous n'avez rien sélectionné
                                </div>";
            }
        } 
        elseif ($_POST['action'] == 'changer') 
        {
            if(is_numeric($_POST['valeur']))
            {
                //echo "<pre>"; print_r($_POST); echo "</pre>";die;
                $requete = $pdoObject->prepare("UPDATE developpeur SET xp =:xp WHERE id_developpeur = :id_developpeur ");
                $requete->bindValue(':id_developpeur', 1, PDO::PARAM_INT);
                $requete->bindValue(':xp', $_POST['valeur'] , PDO::PARAM_INT);

                $requete->execute();

                header("Location:?action=changer_experience&action_experience=modifier");
            }
            else
            {
                $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>
                                    Sélectionnez un nombre
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

        <h1 class="display-3 text-center m-4">Image Expérience</h1>

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
                                                <input type="radio"  name="imageRadio" value="<?= $arrayImages['id_image'] ?>" <?php if($imageActuelle && $arrayImages['id_image'] == $imageActuelle['image_xp_id']) echo 'checked="checked"'; ?> >
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



        <h2 class="text-center">Modifier la durée d'expérience</h2>


        <table class='table  table-striped text-center mt-3' style='background:#f7f7f7'>

                <tr>
                    <td>Expérience</td>
                    <td><?= $textes['xp']?></td>
                    <td>
                        <a href="?action=changer_experience&modifier=experience">
                            <img style='width:25px' src="img/edit.png" alt='icone edit'>
                        </a>
                    </td>
                </tr>

        </table>


        <?php if(isset($_GET['action']) && ($_GET['action'] == 'changer_experience' ) && isset($_GET['modifier']) && $_GET['modifier'] == 'experience' ) :

            //echo "<pre>"; var_dump($_GET['valeur']); echo "</pre>";die;
            $pdoXp = $pdoObject->prepare("SELECT * FROM developpeur WHERE id_developpeur = :id_developpeur");
            $pdoXp->bindValue(':id_developpeur', 1, PDO::PARAM_INT);
            $pdoXp->execute();

            $xp = $pdoXp->fetch(PDO::FETCH_ASSOC);
            ?>

            <form method="post" class="col-md-6 col-md-offset-3 ">

                <div class="form-group ">
                    <input type="text" class="form-control " id='valueXp' name="valeur" value="<?= $xp['xp'];?>"  >
                    <!--<input type="hidden" name="property" id='champ'  value="" >-->
                </div>

                <div class="form-group text-center ">
                    <input type="submit" name="action" id="modificationBtn" value="changer" class='btn btn-primary' disabled="disabled" />
                </div>



            </form>

        <?php endif;?>



    </div>



<?php endif; ?>


<!-------------------------------------------------------------------->
<!--------------------- Changer textes ------------------------------->
<!-------------------------------------------------------------------->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'changer_textes' )) :

    if(isset($_GET['action_texte']) && ($_GET['action_texte'] == 'modifier')) 
    {
        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                Texte modifié
                            </div>";
    }


    $pdoTextes = $pdoObject->query("SELECT * FROM developpeur WHERE id_developpeur = 1");
    $textes = $pdoTextes->fetch(PDO::FETCH_ASSOC);
    //echo "<pre>"; print_r($textes); echo "</pre>";die;

    if($_POST) 
    {
        //echo "<pre>"; print_r($_POST); echo "</pre>";die;
        if ($_POST['action'] == 'modifier')
        {
            if(isset($_POST['imageRadio'])) 
            {


                if($_POST['imageRadio'] != $imageActuelle['image_xp_id'])
                {
                    $requete = $pdoObject->prepare("UPDATE developpeur SET image_xp_id = :image_xp_id WHERE id_developpeur = :id_developpeur");
                    $requete->bindValue(":image_xp_id", $_POST['imageRadio'], PDO::PARAM_INT);
                    $requete->bindValue(":id_developpeur", 1, PDO::PARAM_INT);
                    $requete->execute(); 
                    header("Location:". URL . "gestion_developpeur.php?action=changer_experience&image=changee");exit;
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
                        header("Location:". URL . "gestion_developpeur.php?action=changer_experience&image=supprimees");exit;
                    }
                    else
                    {
                        header("Location:". URL . "gestion_developpeur.php?action=changer_experience&image=supprimee");exit;
                    }
        
            }
            else
            {
                $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>
                                    Vous n'avez rien sélectionné
                                </div>";
            }
        } 
        elseif ($_POST['action'] == 'changer') 
        {

                //echo "<pre>"; print_r($_POST); echo "</pre>";die;
                $requete = $pdoObject->prepare("UPDATE developpeur SET " . $_POST['property'] . " =:txt WHERE id_developpeur = :id_developpeur ");
                $requete->bindValue(':id_developpeur', 1, PDO::PARAM_INT);
                $requete->bindValue(':txt', $_POST['valeur'] , PDO::PARAM_STR);

                $requete->execute();

                header("Location:?action=changer_textes&action_texte=modifier");
        } 

    }

    require_once("include/headeradmin.php");
    ?>

    <div class="container page-bart-lord">

        <div class="retourBackOffice">
            <a class="btn" href="<?= URL ?>admin.php">Retour au back office</a>
        </div>

        <h1 class="display-3 text-center m-4">Textes Développeur</h1>

        <?= $notification ?>


        <table class='table  table-striped text-center mt-3' style='background:#f7f7f7'>

                <tr>
                    <td style='width:200px'>Titre (noir)</td>
                    <td><?= $textes['titre1']?></td>
                    <td>
                        <a href="?action=changer_textes&modifier=textes&valeur=titre1">
                            <img style='width:25px' src="img/edit.png" alt='icone edit'>
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>Titre (jaune)</td>
                    <td><?= $textes['titre2']?></td>
                    <td>
                        <a href="?action=changer_textes&modifier=textes&valeur=titre2">
                            <img style='width:25px' src="img/edit.png" alt='icone edit'>
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>Titre Texte (noir)</td>
                    <td><?= $textes['titre_txt1']?></td>
                    <td>
                        <a href="?action=changer_textes&modifier=textes&valeur=titre_txt1">
                            <img style='width:25px' src="img/edit.png" alt='icone edit'>
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>Titre Texte (jaune)</td>
                    <td><?= $textes['titre_txt2']?></td>
                    <td>
                        <a href="?action=changer_textes&modifier=textes&valeur=titre_txt2">
                            <img style='width:25px' src="img/edit.png" alt='icone edit'>
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>1e paragraphe</td>
                    <td><?= $textes['texte1']?></td>
                    <td>
                        <a href="?action=changer_textes&modifier=textes&valeur=texte1">
                            <img style='width:25px' src="img/edit.png" alt='icone edit'>
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>2e paragraphe</td>
                    <td><?= $textes['texte2']?></td>
                    <td>
                        <a href="?action=changer_textes&modifier=textes&valeur=texte2">
                            <img style='width:25px' src="img/edit.png" alt='icone edit'>
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>3e paragraphe</td>
                    <td><?= $textes['texte3']?></td>
                    <td>
                        <a href="?action=changer_textes&modifier=textes&valeur=texte3">
                            <img style='width:25px' src="img/edit.png" alt='icone edit'>
                        </a>
                    </td>
                </tr>

        </table>


        <?php if(isset($_GET['modifier']) && $_GET['modifier'] == 'textes' ) :

            //echo "<pre>"; var_dump($_GET['valeur']); echo "</pre>";die;
            $pdoXp = $pdoObject->prepare("SELECT * FROM developpeur WHERE id_developpeur = :id_developpeur");
            $pdoXp->bindValue(':id_developpeur', 1, PDO::PARAM_INT);
            $pdoXp->execute();

            $txt = $pdoXp->fetch(PDO::FETCH_ASSOC);
            ?>

            <form method="post" class="col-md-6 col-md-offset-3 ">

                <div class="form-group ">
                    <?php if( $_GET['valeur'] == "titre1" || $_GET['valeur'] == "titre2" || $_GET['valeur'] == "titre_txt2" || $_GET['valeur'] == "titre_txt1") : ?>
                        <input type="text" class="form-control " id='valueTexte' name="valeur" value="<?= $txt[$_GET['valeur']];?>"  >
                        <input type="hidden" name="property" id='champ'  value="<?= $_GET['valeur'];?>" >
                    <?php else : ?>
                        <textarea id="valueTexte" style='padding:10px' name="story" rows="5" cols="50"><?= $txt[$_GET['valeur']]; ?></textarea>
                        <input type="hidden" name="property" id='champ'  value="<?= $_GET['valeur'];?>" >
                    <?php endif; ?>
                    

                </div>

                <div class="form-group text-center ">
                    <input type="submit" name="action" id="modificationBtn" value="changer" class='btn btn-primary' disabled="disabled" />
                </div>

            </form>


        <?php endif;?>



    </div>



<?php endif; ?>


<!-------------------------------------------------------------------->
<!--------------------- Gestion Spécialisations ---------------------->
<!-------------------------------------------------------------------->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'gestion_specialisations' )) :

    if(isset($_GET['notification']) && ($_GET['notification'] == 'specialisation_enregistree')) 
    {
        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                Spécialisation enregistrée
                            </div>";
    }
    if(isset($_GET['notification']) && ($_GET['notification'] == 'specialisation_modifiee')) 
    {
        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                Spécialisation modifiée
                            </div>";
    }
    if(isset($_GET['notification']) && ($_GET['notification'] == 'specialisation_supprimee')) 
    {
        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                Spécialisation supprimée
                            </div>";
    }
    if(isset($_GET['notification']) && ($_GET['notification'] == 'specialisations_supprimees')) 
    {
        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                Spécialisations supprimées
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
                        $pdoInfo = $pdoObject->prepare("SELECT * FROM specialisations WHERE id_specialisation = :id_specialisation");
                        $pdoInfo->bindValue(':id_specialisation', $delete, PDO::PARAM_INT);
                        $pdoInfo->execute();
    
                        $infos = $pdoInfo->fetch(PDO::FETCH_ASSOC);
        
                        $pdoSupp = $pdoObject->prepare("DELETE FROM specialisations WHERE id_specialisation = :id_specialisation");
                        $pdoSupp->bindValue(':id_specialisation', $delete, PDO::PARAM_INT);
                        $pdoSupp->execute();
                        unlink(RACINE_IMAGES . $infos['image']);
        
        
                        $counter++;
                    }
        
                    
                    if($counter > 1)
                    {
                        header("Location:". URL . "gestion_developpeur.php?action=gestion_specialisations&notification=specialisations_supprimees");exit;
                    }
                    else
                    {
                        header("Location:". URL . "gestion_developpeur.php?action=gestion_specialisations&notification=specialisation_supprimee");exit;
                    }
        
            }
            else
            {
                $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>
                                    Vous n'avez rien sélectionné
                                </div>";
            }
        
        }
        elseif ($_POST['action_titre'] == 'changer') 
        {

            $requete = $pdoObject->prepare("UPDATE developpeur SET titre_specialisation =:titre_specialisation WHERE id_developpeur = :id_developpeur ");
            $requete->bindValue(':id_developpeur', 1, PDO::PARAM_INT);
            $requete->bindValue('titre_specialisation', $_POST['valeur'] , PDO::PARAM_STR);
            $requete->execute();

            header("Location:?action=gestion_specialisations&titre=modifie");
        } 
       
       

    }


    $pdoSpecialisations = $pdoObject->query("SELECT * FROM specialisations");
    $specialisations = $pdoSpecialisations->fetchAll(PDO::FETCH_ASSOC);


    $pdoDeveloppeur = $pdoObject->query("SELECT * FROM developpeur WHERE id_developpeur = 1");
    $titreSpe = $pdoDeveloppeur->fetch(PDO::FETCH_ASSOC);

    require_once("include/headeradmin.php");
    ?>

    <div class="container page-bart-lord">

        <div class="retourBackOffice">
            <a class="btn" href="<?= URL ?>admin.php">Retour au back office</a>
        </div>
        <div class="retourConnaissances mt-3">
            <a class="btn" href="<?= URL ?>gestion_developpeur.php?action=ajouter">Nouvelle spécialisation</a>
        </div>





            <h1 class="text-center m-4">
                <a href="?action=gestion_specialisations&modifier=titre">
                    <?= $titreSpe["titre_specialisation"] ?>
                </a>
            </h1>

            <div class="col-md-12">
                <?= $notification ?>
            </div>

            <?php if(isset($_GET['action']) && ($_GET['action'] == 'gestion_specialisations' ) && isset($_GET['modifier']) && $_GET['modifier'] == 'titre' ) :

                //echo "<pre>"; var_dump($_GET['valeur']); echo "</pre>";die;
                $pdoTitre = $pdoObject->prepare("SELECT * FROM developpeur WHERE id_developpeur = :id_developpeur");
                $pdoTitre->bindValue(':id_developpeur', 1, PDO::PARAM_INT);
                $pdoTitre->execute();

                $titre = $pdoTitre->fetch(PDO::FETCH_ASSOC);
                ?>

                    <form method="post" class="col-md-6 col-md-offset-3 ">

                        <div class="form-group ">
                            <input type="text" class="form-control " id='valueSpecialisation' name="valeur" value="<?= $titre['titre_specialisation'];?>"  >
                        </div>

                        <div class="form-group text-center ">
                            <input type="submit" name="action_titre" id="modificationBtn" value="changer" class='btn btn-primary' disabled="disabled" />
                        </div>



                    </form>

            <?php endif;?>

            <?php if(!empty($specialisations)) : ?>

                <form action="" method='post'>
                        <table class='table  table-striped text-center mt-3 bgf7'>

                            <thead class="colorBlack">
                                <tr>
                                    <?php for($i=0; $i<$pdoSpecialisations->columnCount()  ; $i++) :
                                        $colonne = $pdoSpecialisations->getColumnMeta($i); 
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

                            <?php foreach($specialisations as $arraySpecialisations): ?>
                                <tr>
                                    <?php foreach($arraySpecialisations as $key => $value): ?>
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
                                                <a href="?action=modifier&id_specialisation=<?= $arraySpecialisations['id_specialisation'] ?>">
                                                    <img src="img/setting.png" style="width:20px; margin: 0 auto;" alt="icône de localisation">
                                                </a>
                                            </td>



                                            <td style='vertical-align: middle;' >
                                                <div style='width:20px; margin : 0 auto'>
                                                    <input type="checkbox" name='delete[]' class="checkbox1" value='<?= $arraySpecialisations['id_specialisation'] ?>'>
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
                <h4 class='mt-4 text-center'>Il n'y a aucune spécialisation</h4>
            <?php endif; ?>



   
<?php endif; ?>

<!-------------------------------------------------------------------->
<!--------------------- Ajouter ou modifier Spécialisations ---------->
<!-------------------------------------------------------------------->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'ajouter' ||  $_GET['action'] == 'modifier' )) :

    if(isset($_GET['id_specialisation']))
    {
            $pdoStatement = $pdoObject->prepare("SELECT * FROM specialisations WHERE id_specialisation = :id_specialisation");
            $pdoStatement->bindValue('id_specialisation', $_GET['id_specialisation'], PDO::PARAM_INT);
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

            $requete = $pdoObject->prepare("INSERT INTO specialisations (titre, image) VALUES (:titre, :image)");

            $action = "enregistre";

        }
        else
        {
            $requete = $pdoObject->prepare("UPDATE specialisations SET titre=:titre, image=:image WHERE id_specialisation = :id_specialisation ");
            $requete->bindValue(":id_specialisation", $_GET['id_specialisation'], PDO::PARAM_INT);

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

                header("Location: ?action=gestion_specialisations&notification=specialisation_" . $action );
            }
            else
            {
                header("Location: ?action=gestion_specialisations&notification=specialisation_" . $action );
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
            <a class="btn" href="<?= URL ?>gestion_developpeur.php?action=gestion_specialisations">Voir les specialisations</a>
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


<script>
    var valueTexte = $('#valueTexte');
    var champ = $('#champ');


    valueTexte.change(function() {

    var url = "ajax.php";

    var data = {
    'valueTexte': valueTexte.val(),
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


            if(response != valueTexte.val() )
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
    var valueSpecialisation = $('#valueSpecialisation');
    var champ = $('#champ');


    valueSpecialisation.change(function() {

    var url = "ajax.php";

    var data = {
    'valueSpecialisation': valueSpecialisation.val(),
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


            if(response != valueSpecialisation.val() )
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