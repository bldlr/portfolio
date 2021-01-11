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

    $pdoStatement = $pdoObject->prepare("SELECT * FROM services WHERE id_service = :id_service");
    $pdoStatement->bindValue('id_service', 4, PDO::PARAM_INT);
    $pdoStatement->execute();

    $produitExistant = $pdoStatement->fetch(PDO::FETCH_ASSOC);

    foreach($produitExistant as $key => $value)
    {
        $$key = (isset($produitExistant[$key])) ? $produitExistant[$key] : '';
    }

    //echo "<pre>"; print_r($textes); echo "</pre>";die;

    if($_POST) 
    {
        $requete = $pdoObject->prepare("UPDATE services SET paragraphe1 = :paragraphe1, paragraphe2 = :paragraphe2 WHERE id_service = :id_service ");
        $requete->bindValue(":id_service", 4, PDO::PARAM_INT);
        $requete->bindValue(":paragraphe1", $_POST['paragraphe1'], PDO::PARAM_STR); 
        $requete->bindValue(":paragraphe2", $_POST['paragraphe2'], PDO::PARAM_STR);
        $requete->execute(); 

        header("Location:". URL . "gestion_services.php?action=changer_titre&titre=modifie");exit;
    }

    require_once("include/headeradmin.php");
    ?>

    <div class="container page-bart-lord">

        <div class="retourBackOffice">
            <a class="btn" href="<?= URL ?>admin.php">Retour au back office</a>
        </div>

        <h1 class="display-3 text-center m-4">Service Titre</h1>

        <?= $notification ?>

            <form method="post"  class="col-md-6 col-md-offset-3">

                <div class="row">
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" id="valueTitreService1" name="paragraphe1" placeholder="titre jaune" value="<?php if(isset($paragraphe1)){ echo $paragraphe1;}?>">
                    </div>

                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" id="valueTitreService2" name="paragraphe2" placeholder="titre noir" value="<?php if(isset($paragraphe2)){ echo $paragraphe2;}?>">
                    </div>
                </div>

                <div class="row justify-content-center">
                    <button type="submit" id='modificationBtn'  class="col-md-12 btn btn-dark mb-4" disabled="disabled">Enregistrer</button>
                </div>

            </form>

    </div>



<?php endif; ?>


<!-------------------------------------------------------------------->
<!--------------------- Changer Partie 1 ----------------------------->
<!-------------------------------------------------------------------->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'changer_partie1' )) :


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
            $requete->bindValue(":statut", 6, PDO::PARAM_INT);
            $requete->execute();
        
            header("Location:". URL . "gestion_services.php?action=changer_partie1&image=ajoutee");exit;
        }
        else
        {
            header("Location:". URL . "gestion_services.php?action=changer_partie1&image=aucune");exit;
        }
        
    }

    $pdoImages = $pdoObject->prepare("SELECT * FROM images WHERE statut = :statut");
    $pdoImages->bindValue(":statut", 6 , PDO::PARAM_INT);
    $pdoImages->execute();

    $images = $pdoImages->fetchAll(PDO::FETCH_ASSOC);

    $imageActuelle = $pdoObject->prepare("SELECT * FROM services WHERE id_service = :id_service");
    $imageActuelle->bindValue(":id_service", 1 , PDO::PARAM_INT);
    $imageActuelle->execute();
    $imageActuelle = $imageActuelle->fetch(PDO::FETCH_ASSOC);


    $pdoTextes = $pdoObject->query("SELECT titre, paragraphe1, paragraphe2, paragraphe3 FROM services WHERE id_service = 1");
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
                    $requete = $pdoObject->prepare("UPDATE services SET image_id = :image_id WHERE id_service = :service_id");
                    $requete->bindValue(":image_id", $_POST['imageRadio'], PDO::PARAM_INT);
                    $requete->bindValue(":service_id", 1, PDO::PARAM_INT);
                    $requete->execute(); 
                    header("Location:". URL . "gestion_services.php?action=changer_partie1&image=changee");exit;
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
                        header("Location:". URL . "gestion_services.php?action=changer_partie1&image=supprimees");exit;
                    }
                    else
                    {
                        header("Location:". URL . "gestion_services.php?action=changer_partie1&image=supprimee");exit;
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
            $requete = $pdoObject->prepare("UPDATE services SET " . $_POST['property'] . " =:nom WHERE id_service = :id_service ");
            $requete->bindValue(':id_service', 1, PDO::PARAM_INT);
            $requete->bindValue(':nom', $_POST['valeur'] , PDO::PARAM_STR);
            $requete->execute();

            header("Location:?action=changer_partie1&modifier=texte");
        } 

    }

    require_once("include/headeradmin.php");
    ?>

    <div class="container page-bart-lord">

        <div class="retourBackOffice">
            <a class="btn" href="<?= URL ?>admin.php">Retour au back office</a>
        </div>

        <h1 class="display-3 text-center m-4">Service Partie 1</h1>

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
                            <a href="?action=changer_partie1&modifier=textes&valeur=titre">
                                <img style='width:25px' src="img/edit.png" alt='icone edit'>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>Paragraphe 1</td>
                        <td><?= $textes['paragraphe1']?></td>
                        <td>
                            <a href='?action=changer_partie1&modifier=textes&valeur=paragraphe1'>
                                <img style='width:25px' src="img/edit.png" alt='icone edit'>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>Paragraphe 2</td>
                        <td><?= $textes['paragraphe2']?></td>
                        <td>
                            <a href='?action=changer_partie1&modifier=textes&valeur=paragraphe2'>
                                <img style='width:25px' src="img/edit.png" alt='icone edit'>
                            </a>
                        </td>
                    </tr>


                    <tr>
                        <td>paragraphe 3</td>
                        <td><?= $textes['paragraphe3']?></td>
                        <td>
                            <a href='?action=changer_partie1&modifier=textes&valeur=paragraphe3'>
                                <img style='width:25px' src="img/edit.png" alt='icone edit'>
                            </a>
                        </td>
                    </tr>


    </table>


    <?php if(isset($_GET['action']) && ($_GET['action'] == 'changer_partie1' ) && isset($_GET['modifier']) && $_GET['modifier'] == 'textes' ) :

        //echo "<pre>"; var_dump($_GET['valeur']); echo "</pre>";die;
        $pdoCoordonnee = $pdoObject->prepare("SELECT * FROM services WHERE id_service = :id_service");
        $pdoCoordonnee->bindValue(':id_service', 1, PDO::PARAM_INT);
        $pdoCoordonnee->execute();

        $coordonnee = $pdoCoordonnee->fetch(PDO::FETCH_ASSOC);
        ?>

        <form method="post" class="col-md-6 col-md-offset-3 ">

            <div class="form-group ">
                <input type="text" class="form-control " id='valueService1' name="valeur" value="<?= $coordonnee[$_GET['valeur']];?>"  >
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
<!--------------------- Changer Partie 2 ----------------------------->
<!-------------------------------------------------------------------->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'changer_partie2' )) :


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
            $requete->bindValue(":statut", 7, PDO::PARAM_INT);
            $requete->execute();
        
            header("Location:". URL . "gestion_services.php?action=changer_partie2&image=ajoutee");exit;
        }
        else
        {
            header("Location:". URL . "gestion_services.php?action=changer_partie2&image=aucune");exit;
        }
        
    }

    $pdoImages = $pdoObject->prepare("SELECT * FROM images WHERE statut = :statut");
    $pdoImages->bindValue(":statut", 7 , PDO::PARAM_INT);
    $pdoImages->execute();

    $images = $pdoImages->fetchAll(PDO::FETCH_ASSOC);

    $imageActuelle = $pdoObject->prepare("SELECT * FROM services WHERE id_service = :id_service");
    $imageActuelle->bindValue(":id_service", 2 , PDO::PARAM_INT);
    $imageActuelle->execute();
    $imageActuelle = $imageActuelle->fetch(PDO::FETCH_ASSOC);


    $pdoTextes = $pdoObject->query("SELECT titre, paragraphe1, paragraphe2, paragraphe3 FROM services WHERE id_service = 2");
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
                    $requete = $pdoObject->prepare("UPDATE services SET image_id = :image_id WHERE id_service = :service_id");
                    $requete->bindValue(":image_id", $_POST['imageRadio'], PDO::PARAM_INT);
                    $requete->bindValue(":service_id", 2, PDO::PARAM_INT);
                    $requete->execute(); 
                    header("Location:". URL . "gestion_services.php?action=changer_partie2&image=changee");exit;
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
                        header("Location:". URL . "gestion_services.php?action=changer_partie2&image=supprimees");exit;
                    }
                    else
                    {
                        header("Location:". URL . "gestion_services.php?action=changer_partie2&image=supprimee");exit;
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
            $requete = $pdoObject->prepare("UPDATE services SET " . $_POST['property'] . " =:nom WHERE id_service = :id_service ");
            $requete->bindValue(':id_service', 2, PDO::PARAM_INT);
            $requete->bindValue(':nom', $_POST['valeur'] , PDO::PARAM_STR);
            $requete->execute();

            header("Location:?action=changer_partie2&modifier=texte");
        } 

    }

    require_once("include/headeradmin.php");
    ?>

    <div class="container page-bart-lord">

        <div class="retourBackOffice">
            <a class="btn" href="<?= URL ?>admin.php">Retour au back office</a>
        </div>

        <h1 class="display-3 text-center m-4">Service Partie 2</h1>

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
                                <a href="?action=changer_partie2&modifier=textes&valeur=titre">
                                    <img style='width:25px' src="img/edit.png" alt='icone edit'>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>Paragraphe 1</td>
                            <td><?= $textes['paragraphe1']?></td>
                            <td>
                                <a href='?action=changer_partie2&modifier=textes&valeur=paragraphe1'>
                                    <img style='width:25px' src="img/edit.png" alt='icone edit'>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>Paragraphe 2</td>
                            <td><?= $textes['paragraphe2']?></td>
                            <td>
                                <a href='?action=changer_partie2&modifier=textes&valeur=paragraphe2'>
                                    <img style='width:25px' src="img/edit.png" alt='icone edit'>
                                </a>
                            </td>
                        </tr>


                        <tr>
                            <td>paragraphe 3</td>
                            <td><?= $textes['paragraphe3']?></td>
                            <td>
                                <a href='?action=changer_partie2&modifier=textes&valeur=paragraphe3'>
                                    <img style='width:25px' src="img/edit.png" alt='icone edit'>
                                </a>
                            </td>
                        </tr>


        </table>


        <?php if(isset($_GET['action']) && ($_GET['action'] == 'changer_partie2' ) && isset($_GET['modifier']) && $_GET['modifier'] == 'textes' ) :

            //echo "<pre>"; var_dump($_GET['valeur']); echo "</pre>";die;
            $pdoCoordonnee = $pdoObject->prepare("SELECT * FROM services WHERE id_service = :id_service");
            $pdoCoordonnee->bindValue(':id_service', 2, PDO::PARAM_INT);
            $pdoCoordonnee->execute();

            $coordonnee = $pdoCoordonnee->fetch(PDO::FETCH_ASSOC);
            ?>

            <form method="post" class="col-md-6 col-md-offset-3 ">

                <div class="form-group ">
                    <input type="text" class="form-control " id='valueService2' name="valeur" value="<?= $coordonnee[$_GET['valeur']];?>"  >
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
<!--------------------- Changer Partie 3 ----------------------------->
<!-------------------------------------------------------------------->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'changer_partie3' )) :


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
            $requete->bindValue(":statut", 8, PDO::PARAM_INT);
            $requete->execute();
        
            header("Location:". URL . "gestion_services.php?action=changer_partie3&image=ajoutee");exit;
        }
        else
        {
            header("Location:". URL . "gestion_services.php?action=changer_partie3&image=aucune");exit;
        }
        
    }

    $pdoImages = $pdoObject->prepare("SELECT * FROM images WHERE statut = :statut");
    $pdoImages->bindValue(":statut", 8 , PDO::PARAM_INT);
    $pdoImages->execute();

    $images = $pdoImages->fetchAll(PDO::FETCH_ASSOC);

    $imageActuelle = $pdoObject->prepare("SELECT * FROM services WHERE id_service = :id_service");
    $imageActuelle->bindValue(":id_service", 3 , PDO::PARAM_INT);
    $imageActuelle->execute();
    $imageActuelle = $imageActuelle->fetch(PDO::FETCH_ASSOC);


    $pdoTextes = $pdoObject->query("SELECT titre, paragraphe1, paragraphe2, paragraphe3 FROM services WHERE id_service = 3");
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
                    $requete = $pdoObject->prepare("UPDATE services SET image_id = :image_id WHERE id_service = :service_id");
                    $requete->bindValue(":image_id", $_POST['imageRadio'], PDO::PARAM_INT);
                    $requete->bindValue(":service_id", 3, PDO::PARAM_INT);
                    $requete->execute(); 
                    header("Location:". URL . "gestion_services.php?action=changer_partie3&image=changee");exit;
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
                        header("Location:". URL . "gestion_services.php?action=changer_partie3&image=supprimees");exit;
                    }
                    else
                    {
                        header("Location:". URL . "gestion_services.php?action=changer_partie3&image=supprimee");exit;
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
            $requete = $pdoObject->prepare("UPDATE services SET " . $_POST['property'] . " =:nom WHERE id_service = :id_service ");
            $requete->bindValue(':id_service', 3, PDO::PARAM_INT);
            $requete->bindValue(':nom', $_POST['valeur'] , PDO::PARAM_STR);
            $requete->execute();

            header("Location:?action=changer_partie3&modifier=texte");
        } 

    }

    require_once("include/headeradmin.php");
    ?>

    <div class="container page-bart-lord">

        <div class="retourBackOffice">
            <a class="btn" href="<?= URL ?>admin.php">Retour au back office</a>
        </div>

        <h1 class="display-3 text-center m-4">Service Partie 3</h1>

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
                                <a href="?action=changer_partie3&modifier=textes&valeur=titre">
                                    <img style='width:25px' src="img/edit.png" alt='icone edit'>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>Paragraphe 1</td>
                            <td><?= $textes['paragraphe1']?></td>
                            <td>
                                <a href='?action=changer_partie3&modifier=textes&valeur=paragraphe1'>
                                    <img style='width:25px' src="img/edit.png" alt='icone edit'>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>Paragraphe 2</td>
                            <td><?= $textes['paragraphe2']?></td>
                            <td>
                                <a href='?action=changer_partie3&modifier=textes&valeur=paragraphe2'>
                                    <img style='width:25px' src="img/edit.png" alt='icone edit'>
                                </a>
                            </td>
                        </tr>


                        <tr>
                            <td>paragraphe 3</td>
                            <td><?= $textes['paragraphe3']?></td>
                            <td>
                                <a href='?action=changer_partie3&modifier=textes&valeur=paragraphe3'>
                                    <img style='width:25px' src="img/edit.png" alt='icone edit'>
                                </a>
                            </td>
                        </tr>


        </table>


        <?php if(isset($_GET['action']) && ($_GET['action'] == 'changer_partie3' ) && isset($_GET['modifier']) && $_GET['modifier'] == 'textes' ) :

            //echo "<pre>"; var_dump($_GET['valeur']); echo "</pre>";die;
            $pdoCoordonnee = $pdoObject->prepare("SELECT * FROM services WHERE id_service = :id_service");
            $pdoCoordonnee->bindValue(':id_service', 3, PDO::PARAM_INT);
            $pdoCoordonnee->execute();

            $coordonnee = $pdoCoordonnee->fetch(PDO::FETCH_ASSOC);
            ?>

            <form method="post" class="col-md-6 col-md-offset-3 ">

                <div class="form-group ">
                    <input type="text" class="form-control " id='valueService3' name="valeur" value="<?= $coordonnee[$_GET['valeur']];?>"  >
                    <input type="hidden" name="property" id='champ'  value="<?= $_GET['valeur'];?>" >
                </div>

                <div class="form-group text-center ">
                    <input type="submit" name="action" id="modificationBtn" value="changer" class='btn btn-primary' disabled="disabled" />
                </div>



            </form>

        <?php endif;?>

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
    var valueService1 = $('#valueService1');
    var champ = $('#champ');


    valueService1.change(function() {

    var url = "ajax.php";

    var data = {
    'valueService1': valueService1.val(),
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

            if(response != valueService1.val() )
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
    var valueService2 = $('#valueService2');
    var champ = $('#champ');


    valueService2.change(function() {

    var url = "ajax.php";

    var data = {
    'valueService2': valueService2.val(),
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

            if(response != valueService2.val() )
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
    var valueService3 = $('#valueService3');
    var champ = $('#champ');


    valueService3.change(function() {

    var url = "ajax.php";

    var data = {
    'valueService3': valueService3.val(),
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

            if(response != valueService3.val() )
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
    var valueTitreService1 = $('#valueTitreService1');

    valueTitreService1.change(function() {

    var url = "ajax.php";

    var data = {
    'valueTitreService1': valueTitreService1.val()
    };
    console.log(data);

    $.ajax({ 
        type: 'POST',
        dataType: 'json',
        url: url,
        data: data,

        success: function (response) {

            console.log(response);

            if(response != valueTitreService1.val() )
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
    var valueTitreService2 = $('#valueTitreService2');

    valueTitreService2.change(function() {

    var url = "ajax.php";

    var data = {
    'valueTitreService2': valueTitreService2.val()
    };
    console.log(data);

    $.ajax({ 
        type: 'POST',
        dataType: 'json',
        url: url,
        data: data,

        success: function (response) {

            console.log(response);

            if(response != valueTitreService2.val() )
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