<?php 
require_once("include/init.php");


if(!adminConnecte() && !superAdminConnecte())
{
  header("Location:" . URL . "index.php"); exit;
}


?>


<!-------------------------------------------------------------------->
<!--------------------- Changer l'image 1 ---------------------------->
<!-------------------------------------------------------------------->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'changer_image1' )) :


    if(isset($_GET['modifier']) && ($_GET['modifier'] == 'texte')) 
    {
        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                Texte modifié
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
            $nomImage =  date("YmdHis") . $_FILES['image']['name']; 
            $dossierImage = RACINE_IMAGES. $nomImage; 
            copy($_FILES['image']['tmp_name'], $dossierImage); 


            $requete = $pdoObject->prepare("INSERT INTO images (titre, statut) VALUES (:titre, :statut)");
            $requete->bindValue(":titre", $nomImage, PDO::PARAM_STR);
            $requete->bindValue(":statut", 1, PDO::PARAM_INT);
            $requete->execute();
        
            header("Location:". URL . "gestion_accueil.php?action=changer_image1&image=ajoutee");exit;
        }
        else
        {
            header("Location:". URL . "gestion_accueil.php?action=changer_image1&image=aucune");exit;
        }
        
    }

    $pdoImages = $pdoObject->prepare("SELECT * FROM images WHERE statut = :statut");
    $pdoImages->bindValue(":statut", 1 , PDO::PARAM_INT);
    $pdoImages->execute();

    $images = $pdoImages->fetchAll(PDO::FETCH_ASSOC);

    $imageActuelle = $pdoObject->prepare("SELECT * FROM accueil WHERE id_accueil = :id_accueil");
    $imageActuelle->bindValue(":id_accueil", 1 , PDO::PARAM_INT);
    $imageActuelle->execute();
    $imageActuelle = $imageActuelle->fetch(PDO::FETCH_ASSOC);


    $pdoTextes = $pdoObject->query("SELECT titre, paragraphe1, paragraphe2, bouton FROM accueil WHERE id_accueil = 1");
    $textes = $pdoTextes->fetch(PDO::FETCH_ASSOC);
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
                    $requete = $pdoObject->prepare("UPDATE accueil SET image_id = :image_id WHERE id_accueil = :accueil_id");
                    $requete->bindValue(":image_id", $_POST['imageRadio'], PDO::PARAM_INT);
                    $requete->bindValue(":accueil_id", 1, PDO::PARAM_INT);
                    $requete->execute(); 
                    header("Location:". URL . "gestion_accueil.php?action=changer_image1&image=changee");exit;
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
                        header("Location:". URL . "gestion_accueil.php?action=changer_image1&image=supprimees");exit;
                    }
                    else
                    {
                        header("Location:". URL . "gestion_accueil.php?action=changer_image1&image=supprimee");exit;
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
            $requete = $pdoObject->prepare("UPDATE accueil SET " . $_POST['property'] . " =:nom WHERE id_accueil = :idAccueil ");
            $requete->bindValue(':idAccueil', 1, PDO::PARAM_INT);
            $requete->bindValue(':nom', $_POST['valeur'] , PDO::PARAM_STR);
            $requete->execute();

            header("Location:?action=changer_image1&modifier=texte");
        } 

    }

    require_once("include/headeradmin.php");
    ?>

    <div class="container page-bart-lord">

        <div class="retourBackOffice">
            <a class="btn" href="<?= URL ?>admin.php">Retour au back office</a>
        </div>

        <h1 class="display-3 text-center m-4">Image 1</h1>

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

        <h2 class="text-center">Modifier les textes</h2>


    <table class='table  table-striped text-center mt-3' style='background:#f7f7f7'>

                    <tr>
                        <td>Titre</td>
                        <td><?= $textes['titre']?></td>
                        <td>
                            <a href="?action=changer_image1&modifier=textes&valeur=titre">
                                <img style='width:25px' src="img/edit.png" alt='icone edit'>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>Paragraphe 1</td>
                        <td><?= $textes['paragraphe1']?></td>
                        <td>
                            <a href='?action=changer_image1&modifier=textes&valeur=paragraphe1'>
                                <img style='width:25px' src="img/edit.png" alt='icone edit'>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>Paragraphe 2</td>
                        <td><?= $textes['paragraphe2']?></td>
                        <td>
                            <a href='?action=changer_image1&modifier=textes&valeur=paragraphe2'>
                                <img style='width:25px' src="img/edit.png" alt='icone edit'>
                            </a>
                        </td>
                    </tr>


                    <tr>
                        <td>Bouton</td>
                        <td><?= $textes['bouton']?></td>
                        <td>
                            <a href='?action=changer_image1&modifier=textes&valeur=bouton'>
                                <img style='width:25px' src="img/edit.png" alt='icone edit'>
                            </a>
                        </td>
                    </tr>


    </table>


    <?php if(isset($_GET['action']) && ($_GET['action'] == 'changer_image1' ) && isset($_GET['modifier']) && $_GET['modifier'] == 'textes' ) :

        //echo "<pre>"; var_dump($_GET['valeur']); echo "</pre>";die;
        $pdoCoordonnee = $pdoObject->prepare("SELECT * FROM accueil WHERE id_accueil = :id_accueil");
        $pdoCoordonnee->bindValue(':id_accueil', 1, PDO::PARAM_INT);
        $pdoCoordonnee->execute();

        $coordonnee = $pdoCoordonnee->fetch(PDO::FETCH_ASSOC);
        ?>

        <form method="post" class="col-md-6 col-md-offset-3 ">

            <div class="form-group ">
                <input type="text" class="form-control " id='value1' name="valeur" value="<?= $coordonnee[$_GET['valeur']];?>"  >
                <input type="hidden" name="property" id='champ'  value="<?= $_GET['valeur'];?>" >
            </div>

            <div class="form-group text-center ">
                <input type="submit" name="action" id="modificationBtn" value="changer" class='btn btn-primary' disabled="disabled" />
            </div>



        </form>

    <?php endif;?>

    </div>
    


<?php endif; ?>

<!-------------------------------------------------------------------->
<!--------------------- Changer l'image 2 ---------------------------->
<!-------------------------------------------------------------------->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'changer_image2' )) :


    if(isset($_GET['modifier']) && ($_GET['modifier'] == 'texte')) 
    {
        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                Texte modifié
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
            $nomImage =  date("YmdHis") . $_FILES['image']['name']; 
            $dossierImage = RACINE_IMAGES. $nomImage; 
            copy($_FILES['image']['tmp_name'], $dossierImage); 


            $requete = $pdoObject->prepare("INSERT INTO images (titre, statut) VALUES (:titre, :statut)");
            $requete->bindValue(":titre", $nomImage, PDO::PARAM_STR);
            $requete->bindValue(":statut", 2, PDO::PARAM_INT);
            $requete->execute();
        
            header("Location:". URL . "gestion_accueil.php?action=changer_image2&image=ajoutee");exit;
        }
        else
        {
            header("Location:". URL . "gestion_accueil.php?action=changer_image2&image=aucune");exit;
        }
        
    }

    $pdoImages = $pdoObject->prepare("SELECT * FROM images WHERE statut = :statut");
    $pdoImages->bindValue(":statut", 2 , PDO::PARAM_INT);
    $pdoImages->execute();

    $images = $pdoImages->fetchAll(PDO::FETCH_ASSOC);

    $imageActuelle = $pdoObject->prepare("SELECT * FROM accueil WHERE id_accueil = :id_accueil");
    $imageActuelle->bindValue(":id_accueil", 2 , PDO::PARAM_INT);
    $imageActuelle->execute();
    $imageActuelle = $imageActuelle->fetch(PDO::FETCH_ASSOC);


    $pdoTextes = $pdoObject->query("SELECT titre, paragraphe1, paragraphe2, bouton FROM accueil WHERE id_accueil = 2");
    $textes = $pdoTextes->fetch(PDO::FETCH_ASSOC);
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
                    $requete = $pdoObject->prepare("UPDATE accueil SET image_id = :image_id WHERE id_accueil = :accueil_id");
                    $requete->bindValue(":image_id", $_POST['imageRadio'], PDO::PARAM_INT);
                    $requete->bindValue(":accueil_id", 2, PDO::PARAM_INT);
                    $requete->execute(); 
                    header("Location:". URL . "gestion_accueil.php?action=changer_image2&image=changee");exit;
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
                        header("Location:". URL . "gestion_accueil.php?action=changer_image2&image=supprimees");exit;
                    }
                    else
                    {
                        header("Location:". URL . "gestion_accueil.php?action=changer_image2&image=supprimee");exit;
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
            $requete = $pdoObject->prepare("UPDATE accueil SET " . $_POST['property'] . " =:nom WHERE id_accueil = :idAccueil ");
            $requete->bindValue(':idAccueil', 2, PDO::PARAM_INT);
            $requete->bindValue(':nom', $_POST['valeur'] , PDO::PARAM_STR);
            $requete->execute();

            header("Location:?action=changer_image2&modifier=texte");
        } 

    }

    require_once("include/headeradmin.php");
    ?>

    <div class="container page-bart-lord">

        <div class="retourBackOffice">
            <a class="btn" href="<?= URL ?>admin.php">Retour au back office</a>
        </div>

        <h1 class="display-3 text-center m-4">Image 2</h1>

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

                                <tr>
                                    <td></td>
                                    <td class="paddingtd">
                                        <div style='margin-top:21px'>
                                            <input type="submit" name="action" value="modifier" class='btn btn-primary' />
                                        </div>
                                    </td>
                                    <td class="paddingtd">
                                        <div style='width:20px; margin : 0 auto 8px auto'>
                                            <input class="checkbox m-0 " id="checker" type="checkbox">
                                        </div>
                                        <input type="submit" name="action" value="supprimer" class='btn btn-primary' onclick="return confirm('Confirmez-vous la suppression ?')" />
                                    </td>
                                </tr>

                        </table>

                    </form>

            <?php else : ?>
                <h4 class='mt-4 text-center'>Il n'y a aucune image</h4>
            <?php endif; ?>

        <h2 class="text-center">Modifier les textes</h2>


            <table class='table  table-striped text-center mt-3' style='background:#f7f7f7'>

                    <tr>
                        <td>Titre</td>
                        <td><?= $textes['titre']?></td>
                        <td>
                            <a href="?action=changer_image2&modifier=textes&valeur=titre">
                                <img style='width:25px' src="img/edit.png" alt='icone edit'>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>Paragraphe 1</td>
                        <td><?= $textes['paragraphe1']?></td>
                        <td>
                            <a href='?action=changer_image2&modifier=textes&valeur=paragraphe1'>
                                <img style='width:25px' src="img/edit.png" alt='icone edit'>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>Paragraphe 2</td>
                        <td><?= $textes['paragraphe2']?></td>
                        <td>
                            <a href='?action=changer_image2&modifier=textes&valeur=paragraphe2'>
                                <img style='width:25px' src="img/edit.png" alt='icone edit'>
                            </a>
                        </td>
                    </tr>


                    <tr>
                        <td>Bouton</td>
                        <td><?= $textes['bouton']?></td>
                        <td>
                            <a href='?action=changer_image2&modifier=textes&valeur=bouton'>
                                <img style='width:25px' src="img/edit.png" alt='icone edit'>
                            </a>
                        </td>
                    </tr>


            </table>


        <?php if(isset($_GET['action']) && ($_GET['action'] == 'changer_image2' ) && isset($_GET['modifier']) && $_GET['modifier'] == 'textes' ) :

            //echo "<pre>"; var_dump($_GET['valeur']); echo "</pre>";die;
            $pdoCoordonnee = $pdoObject->prepare("SELECT * FROM accueil WHERE id_accueil = :id_accueil");
            $pdoCoordonnee->bindValue(':id_accueil', 2, PDO::PARAM_INT);
            $pdoCoordonnee->execute();

            $coordonnee = $pdoCoordonnee->fetch(PDO::FETCH_ASSOC);
            ?>

            <form method="post" class="col-md-6 col-md-offset-3 ">

                <div class="form-group ">
                    <input type="text" class="form-control " id='value2' name="valeur" value="<?= $coordonnee[$_GET['valeur']];?>"  >
                    <input type="hidden" name="property" id='champ'  value="<?= $_GET['valeur'];?>" >
                </div>

                <div class="form-group text-center ">
                    <input type="submit" name="action" id="modificationBtn" value="changer" class='btn btn-primary' disabled="disabled" />
                </div>



            </form>

        <?php endif;?>

    </div>



<?php endif; ?>


<!-------------------------------------------------------------------->
<!--------------------- Changer l'image 3 ---------------------------->
<!-------------------------------------------------------------------->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'changer_image3' )) :


    if(isset($_GET['modifier']) && ($_GET['modifier'] == 'texte')) 
    {
        $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                Texte modifié
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
            $nomImage =  date("YmdHis") . $_FILES['image']['name']; 
            $dossierImage = RACINE_IMAGES. $nomImage; 
            copy($_FILES['image']['tmp_name'], $dossierImage); 


            $requete = $pdoObject->prepare("INSERT INTO images (titre, statut) VALUES (:titre, :statut)");
            $requete->bindValue(":titre", $nomImage, PDO::PARAM_STR);
            $requete->bindValue(":statut", 3, PDO::PARAM_INT);
            $requete->execute();
        
            header("Location:". URL . "gestion_accueil.php?action=changer_image3&image=ajoutee");exit;
        }
        else
        {
            header("Location:". URL . "gestion_accueil.php?action=changer_image3&image=aucune");exit;
        }
        
    }

    $pdoImages = $pdoObject->prepare("SELECT * FROM images WHERE statut = :statut");
    $pdoImages->bindValue(":statut", 3 , PDO::PARAM_INT);
    $pdoImages->execute();

    $images = $pdoImages->fetchAll(PDO::FETCH_ASSOC);

    $imageActuelle = $pdoObject->prepare("SELECT * FROM accueil WHERE id_accueil = :id_accueil");
    $imageActuelle->bindValue(":id_accueil", 3 , PDO::PARAM_INT);
    $imageActuelle->execute();
    $imageActuelle = $imageActuelle->fetch(PDO::FETCH_ASSOC);


    $pdoTextes = $pdoObject->query("SELECT titre, paragraphe1, paragraphe2, bouton FROM accueil WHERE id_accueil = 3");
    $textes = $pdoTextes->fetch(PDO::FETCH_ASSOC);
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
                    $requete = $pdoObject->prepare("UPDATE accueil SET image_id = :image_id WHERE id_accueil = :accueil_id");
                    $requete->bindValue(":image_id", $_POST['imageRadio'], PDO::PARAM_INT);
                    $requete->bindValue(":accueil_id", 3, PDO::PARAM_INT);
                    $requete->execute(); 
                    header("Location:". URL . "gestion_accueil.php?action=changer_image3&image=changee");exit;
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
                        header("Location:". URL . "gestion_accueil.php?action=changer_image3&image=supprimees");exit;
                    }
                    else
                    {
                        header("Location:". URL . "gestion_accueil.php?action=changer_image3&image=supprimee");exit;
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
            $requete = $pdoObject->prepare("UPDATE accueil SET " . $_POST['property'] . " =:nom WHERE id_accueil = :idAccueil ");
            $requete->bindValue(':idAccueil', 3, PDO::PARAM_INT);
            $requete->bindValue(':nom', $_POST['valeur'] , PDO::PARAM_STR);
            $requete->execute();

            header("Location:?action=changer_image3&modifier=texte");
        } 

    }

    require_once("include/headeradmin.php");
    ?>

    <div class="container page-bart-lord">

        <div class="retourBackOffice">
            <a class="btn" href="<?= URL ?>admin.php">Retour au back office</a>
        </div>

        <h1 class="display-3 text-center m-4">Image 3</h1>

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

                                <tr>
                                    <td></td>
                                    <td class="paddingtd">
                                        <div style='margin-top:21px'>
                                            <input type="submit" name="action" value="modifier" class='btn btn-primary' />
                                        </div>
                                    </td>
                                    <td class="paddingtd">
                                        <div style='width:20px; margin : 0 auto 8px auto'>
                                            <input class="checkbox m-0 " id="checker" type="checkbox">
                                        </div>
                                        <input type="submit" name="action" value="supprimer" class='btn btn-primary' onclick="return confirm('Confirmez-vous la suppression ?')" />
                                    </td>
                                </tr>

                        </table>

                    </form>

            <?php else : ?>
                <h4 class='mt-4 text-center'>Il n'y a aucune image</h4>
            <?php endif; ?>

        <h2 class="text-center">Modifier les textes</h2>


            <table class='table  table-striped text-center mt-3' style='background:#f7f7f7'>

                    <tr>
                        <td>Titre</td>
                        <td><?= $textes['titre']?></td>
                        <td>
                            <a href="?action=changer_image3&modifier=textes&valeur=titre">
                                <img style='width:25px' src="img/edit.png" alt='icone edit'>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>Paragraphe 1</td>
                        <td><?= $textes['paragraphe1']?></td>
                        <td>
                            <a href='?action=changer_image3&modifier=textes&valeur=paragraphe1'>
                                <img style='width:25px' src="img/edit.png" alt='icone edit'>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>Paragraphe 2</td>
                        <td><?= $textes['paragraphe2']?></td>
                        <td>
                            <a href='?action=changer_image3&modifier=textes&valeur=paragraphe2'>
                                <img style='width:25px' src="img/edit.png" alt='icone edit'>
                            </a>
                        </td>
                    </tr>


                    <tr>
                        <td>Bouton</td>
                        <td><?= $textes['bouton']?></td>
                        <td>
                            <a href='?action=changer_image3&modifier=textes&valeur=bouton'>
                                <img style='width:25px' src="img/edit.png" alt='icone edit'>
                            </a>
                        </td>
                    </tr>


            </table>


        <?php if(isset($_GET['action']) && ($_GET['action'] == 'changer_image3' ) && isset($_GET['modifier']) && $_GET['modifier'] == 'textes' ) :

            //echo "<pre>"; var_dump($_GET['valeur']); echo "</pre>";die;
            $pdoCoordonnee = $pdoObject->prepare("SELECT * FROM accueil WHERE id_accueil = :id_accueil");
            $pdoCoordonnee->bindValue(':id_accueil', 3, PDO::PARAM_INT);
            $pdoCoordonnee->execute();

            $coordonnee = $pdoCoordonnee->fetch(PDO::FETCH_ASSOC);
            ?>

            <form method="post" class="col-md-6 col-md-offset-3 ">

                <div class="form-group ">
                    <input type="text" class="form-control " id='value3' name="valeur" value="<?= $coordonnee[$_GET['valeur']];?>"  >
                    <input type="hidden" name="property" id='champ'  value="<?= $_GET['valeur'];?>" >
                </div>

                <div class="form-group text-center ">
                    <input type="submit" name="action" id="modificationBtn" value="changer" class='btn btn-primary' disabled="disabled" />
                </div>



            </form>

        <?php endif;?>

    </div>



<?php endif; ?>


<!-------------------------------------------------------------------->
<!--------------------- Couleur principale --------------------------->
<!-------------------------------------------------------------------->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'changer_color' )) :


    if(isset($_GET['couleur']))
    {
        if($_GET['couleur'] == 'ajoutee')
        {
            $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                Nouvelle Couleur ajoutée
                            </div>";
        }
        elseif($_GET['couleur'] == 'aucune')
        {
            $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>
                                Aucune Couleur détectée
                            </div>";
        }
        elseif($_GET['couleur'] == 'changee')
        {
            $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                Couleur changée
                            </div>";
        }
        elseif($_GET['couleur'] == 'supprimee')
        {
            $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                Couleur supprimée
                            </div>";
        }
        elseif($_GET['couleur'] == 'supprimees')
        {
            $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                Couleurs supprimées
                            </div>";
        }
        elseif($_GET['couleur'] == 'erreur')
        {
            $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-success text-center mt-4 disparition'>
                                impossible
                            </div>";
        }

    }

    $pdoColors = $pdoObject->query("SELECT * FROM colors");

    $colors = $pdoColors->fetchAll(PDO::FETCH_ASSOC);

    $colorActuelle = $pdoObject->prepare("SELECT * FROM color WHERE id_color = :id_color");
    $colorActuelle->bindValue(":id_color", 1 , PDO::PARAM_INT);
    $colorActuelle->execute();
    $colorActuelle = $colorActuelle->fetch(PDO::FETCH_ASSOC);

    //echo "<pre>"; print_r($textes); echo "</pre>";die;

    if($_POST) 
    {
        //echo "<pre>"; print_r($_POST); echo "</pre>";die;
        if ($_POST['action'] == 'modifier')
        {
            if(isset($_POST['colorRadio'])) 
            {


                if($_POST['colorRadio'] != $colorActuelle['color_id'])
                {
                    $requete = $pdoObject->prepare("UPDATE color SET color_id = :color_id WHERE id_color = :id_color");
                    $requete->bindValue(":color_id", $_POST['colorRadio'], PDO::PARAM_INT);
                    $requete->bindValue(":id_color", 1, PDO::PARAM_INT);
                    $requete->execute(); 
                    header("Location:". URL . "gestion_accueil.php?action=changer_color&couleur=changee");exit;
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
                        $pdoInfo = $pdoObject->prepare("SELECT * FROM colors WHERE id_colors = :id_colors");
                        $pdoInfo->bindValue(':id_colors', $delete, PDO::PARAM_INT);
                        $pdoInfo->execute();

                        $infos = $pdoInfo->fetch(PDO::FETCH_ASSOC);
        
                        $pdoSupp = $pdoObject->prepare("DELETE FROM colors WHERE id_colors = :id_colors");
                        $pdoSupp->bindValue(':id_colors', $delete, PDO::PARAM_INT);
                        $pdoSupp->execute();
        
        
                        $counter++;
                    }
        
                    
                    if($counter > 1)
                    {
                        header("Location:". URL . "gestion_accueil.php?action=changer_color&couleur=supprimees");exit;
                    }
                    else
                    {
                        header("Location:". URL . "gestion_accueil.php?action=changer_color&couleur=supprimee");exit;
                    }
        
            }
            else
            {
                $notification .= "<div class='col-md-6 col-md-offset-3 mx-auto alert alert-danger text-center mt-4 disparition'>
                                    Vous n'avez rien sélectionné
                                </div>";
            }
        } 
        else{
            $requete = $pdoObject->prepare("INSERT INTO colors (titre) VALUES (:titre)");
            $requete->bindValue(":titre", $_POST['titre'], PDO::PARAM_STR);
            $requete->execute();
        
            header("Location:". URL . "gestion_accueil.php?action=changer_color&couleur=ajoutee");exit;
        }


    }

    require_once("include/headeradmin.php");
    ?>

    <div class="container page-bart-lord">

        <div class="retourBackOffice">
            <a class="btn" href="<?= URL ?>admin.php">Retour au back office</a>
        </div>

        <h1 class="display-3 text-center m-4">Couleur</h1>

        <?= $notification ?>

        <h2 class="text-center">couleur principale</h2>

        <form method="post" class="col-md-6 col-md-offset-3">

            <div class="form-group m-4">
                <input  style="width:200px; margin : 0 auto; height: 100px!important" type="color" name="titre">
            </div>

                <br> 
                <div class="row justify-content-center m-4" style='margin-top:30px!important'>
                    <button type="submit"  class="col-md-12 btn mb-3 ">Ajouter</button>
                </div>

        </form>


            <h2 class="text-center">Sélectionner une couleur</h2>
            
                <?php if(!empty($colors)) : ?>

                    <form action="" method='post'>
                            <table class='table  table-striped text-center mt-3 bgf7'>

                                <thead class="colorBlack">
                                    <tr>
                                        <?php for($i=0; $i<$pdoColors->columnCount()  ; $i++) :
                                            $colonne = $pdoColors->getColumnMeta($i); 
                                        ?>
                                            <?php if($colonne['name'] != "id_colors"): ?>
                                                <?php if($colonne['name'] == "titre"): ?>
                                                    <th class="text-center">Couleur</th>
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

                                <?php foreach($colors as $arrayColors): ?>
                                    <tr>
                                        <?php foreach($arrayColors as $key => $value): ?>
                                            <?php if($key != 'id_colors'): ?>
                                                <td >
                                                    <div style="width:100%; height:50px; background: <?= $arrayColors['titre'] ?> ">

                                                    </div>
                                                    
                                                </td>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                                <td style='vertical-align: middle;'>
                                                    <input type="radio"  name="colorRadio" value="<?= $arrayColors['id_colors'] ?>" <?php if($colorActuelle && $arrayColors['id_colors'] == $colorActuelle['color_id']) echo 'checked="checked"'; ?> >
                                                </td>



                                                <td style='vertical-align: middle;' >
                                                    <div style='width:20px; margin : 0 auto'>
                                                        <input type="checkbox" name='delete[]' class="checkbox" value='<?= $arrayColors['id_colors'] ?>'>
                                                    </div>
                                                </td>
                                    </tr>
                                <?php endforeach; ?>

                                    <tr>
                                        <td></td>
                                        <td class="paddingtd">
                                            <div style='margin-top:21px'>
                                                <input type="submit" name="action" value="modifier" class='btn btn-primary' />
                                            </div>
                                        </td>
                                        <td class="paddingtd">
                                            <div style='width:20px; margin : 0 auto 8px auto'>
                                                <input class="checkbox m-0 " id="checker" type="checkbox">
                                            </div>
                                            <input type="submit" name="action" value="supprimer" class='btn btn-primary' onclick="return confirm('Confirmez-vous la suppression ?')" />
                                        </td>
                                    </tr>

                            </table>

                        </form>

                <?php else : ?>
                    <h4 class='mt-4 text-center'>Il n'y a aucune couleur</h4>
                <?php endif; ?>



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
    var value1 = $('#value1');
    var champ = $('#champ');


    value1.change(function() {

    var url = "ajax.php";

    var data = {
    'value1': value1.val(),
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

            if(response != value1.val() )
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
    var value2 = $('#value2');
    var champ = $('#champ');


    value2.change(function() {

    var url = "ajax.php";

    var data = {
    'value2': value2.val(),
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

            if(response != value2.val() )
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
    var value3 = $('#value3');
    var champ = $('#champ');


    value3.change(function() {

    var url = "ajax.php";

    var data = {
    'value3': value3.val(),
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

            if(response != value3.val() )
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