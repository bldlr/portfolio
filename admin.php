<?php 
require_once("include/init.php");

if(!adminConnecte() && !superAdminConnecte())
{
  header("Location:" . URL . "index"); exit;
}
require_once("include/headeradmin.php");
?>

<div class="container page-bart-lord" >

  <h1 class="text-center mt-3 mb-5">Back Office</h1>



  <div class="row backoffice" >

      <div class=" admin_partie text-center">
        <h4 class="text-center">Accueil</h4>
        <ul>
          <li>
            <a href="<?= URL ?>gestion_accueil.php?action=changer_color">Color</a>
          </li>
          <li>
            <a href="<?= URL ?>gestion_accueil.php?action=changer_image1">Image 1</a>
          </li>
          <li>
            <a href="<?= URL ?>gestion_accueil.php?action=changer_image2">Image 2</a>
          </li>
          <li>
            <a href="<?= URL ?>gestion_accueil.php?action=changer_image3">Image 3</a>
          </li>
        </ul>
      </div>

      <div class=" admin_partie text-center">
        <h4 class="text-center">Développeur</h4>
        <ul>
          <li>
            <a href="<?= URL ?>gestion_developpeur.php?action=changer_experience">Expérience</a>
          </li>
          <li>
            <a href="<?= URL ?>gestion_developpeur.php?action=changer_textes">Textes</a>
          </li>
          <li>
            <a href="<?= URL ?>gestion_developpeur.php?action=gestion_specialisations">Spécialisations</a>
          </li>
          <li>
            <a href="<?= URL ?>gestion_developpeur.php?action=changer_image">Image</a>
          </li>
        </ul>
      </div>

      <div class=" admin_partie text-center">
        <h4 class="text-center">Formateur</h4>
        <ul>
          <li>
            <a href="<?= URL ?>gestion_formateur.php?action=changer_titre">Titre</a>
          </li>
          <li>
            <a href="<?= URL ?>gestion_formateur.php?action=changer_image">Image</a>
          </li>
          <li>
            <a href="<?= URL ?>gestion_formateur.php?action=gestion_langages">Langages</a>
          </li>
        </ul>
      </div>


      <div class=" admin_partie text-center">
        <h4 class="text-center">Services</h4>
        <ul>
          <li>
            <a href="<?= URL ?>gestion_services.php?action=changer_titre">Titre</a>
          </li>
          <li>
            <a href="<?= URL ?>gestion_services.php?action=changer_partie1">Partie 1</a>
          </li>
          <li>
            <a href="<?= URL ?>gestion_services.php?action=changer_partie2">Partie 2</a>
          </li>
          <li>
            <a href="<?= URL ?>gestion_services.php?action=changer_partie3">Partie 3</a>
          </li>
        </ul>
      </div>

      <div class=" admin_partie text-center">
        <h4 class="text-center">Contact</h4>
        <ul>
        <li>
            <a href="<?= URL ?>gestion_contact.php?action=changer_titre">Titre</a>
          </li>
          <li>
            <a href="<?= URL ?>gestion_contact.php?action=changer_coordonnees">Coordonnées</a>
          </li>
          <li>
            <a href="<?= URL ?>gestion_contact.php?action=changer_email">Email</a>
          </li>
        </ul>
      </div>

      <div class=" admin_partie text-center">
        <h4 class="text-center">Membres</h4>
        <ul>
          <li>
            <a href="<?= URL ?>gestion_membres.php?action=afficher_membres">Membres</a>
          </li>
          <li>
            <a href="<?= URL ?>gestion_membres.php?action=ajouter_admin">Nouvel admin</a>
          </li>
          <li>
            <a href="<?= URL ?>gestion_membres.php?action=modifier_mot_de_passe">Mot de passe</a>
          </li>
        </ul>
      </div>

  </div>

</div>


<?php
require_once("include/footer.php");