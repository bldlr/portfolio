<?php
require_once("include/init.php");
if($_POST)
{
    if(isset($_POST['value1']))
    {
        $pdoStatement = $pdoObject->prepare("SELECT * FROM accueil WHERE id_accueil = :id_accueil ");
        $pdoStatement->bindValue(":id_accueil", 1 , PDO::PARAM_INT);
        $pdoStatement->execute();

        $stocker = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        $titre = $stocker[$_POST['champ']];


        echo json_encode($titre);
    }

    if(isset($_POST['value2']))
    {
        $pdoStatement = $pdoObject->prepare("SELECT * FROM accueil WHERE id_accueil = :id_accueil ");
        $pdoStatement->bindValue(":id_accueil", 2 , PDO::PARAM_INT);
        $pdoStatement->execute();

        $stocker = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        $titre = $stocker[$_POST['champ']];


        echo json_encode($titre);
    }

    if(isset($_POST['value3']))
    {
        $pdoStatement = $pdoObject->prepare("SELECT * FROM accueil WHERE id_accueil = :id_accueil ");
        $pdoStatement->bindValue(":id_accueil", 3 , PDO::PARAM_INT);
        $pdoStatement->execute();

        $stocker = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        $titre = $stocker[$_POST['champ']];


        echo json_encode($titre);
    }

    if(isset($_POST['id']))
    {
        $pdoStatement = $pdoObject->prepare("SELECT * FROM coordonnee WHERE id_coordonnee = :id_coordonnee ");
        $pdoStatement->bindValue(":id_coordonnee", $_POST['id'] , PDO::PARAM_INT);
        $pdoStatement->execute();

        $stocker = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        $titre = $stocker['nom'];

        

        echo json_encode($titre);
    }

    if(isset($_POST['valueXp']))
    {
        $pdoStatement = $pdoObject->prepare("SELECT * FROM developpeur WHERE id_developpeur = :id_developpeur ");
        $pdoStatement->bindValue(":id_developpeur", 1 , PDO::PARAM_INT);
        $pdoStatement->execute();

        $stocker = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        $xp = $stocker['xp'];


        echo json_encode($xp);
    }

    if(isset($_POST['valueTexte']))
    {
        $pdoStatement = $pdoObject->prepare("SELECT * FROM developpeur WHERE id_developpeur = :id_developpeur ");
        $pdoStatement->bindValue(":id_developpeur", 1 , PDO::PARAM_INT);
        $pdoStatement->execute();

        $stocker = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        $textes = $stocker[$_POST['champ']];


        echo json_encode($textes);
    }



    if(isset($_POST['valueService1']))
    {
        $pdoStatement = $pdoObject->prepare("SELECT * FROM services WHERE id_service = :id_service ");
        $pdoStatement->bindValue(":id_service", 1 , PDO::PARAM_INT);
        $pdoStatement->execute();

        $stocker = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        $titre = $stocker[$_POST['champ']];


        echo json_encode($titre);
    }

    if(isset($_POST['valueService2']))
    {
        $pdoStatement = $pdoObject->prepare("SELECT * FROM services WHERE id_service = :id_service ");
        $pdoStatement->bindValue(":id_service", 2 , PDO::PARAM_INT);
        $pdoStatement->execute();

        $stocker = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        $titre = $stocker[$_POST['champ']];


        echo json_encode($titre);
    }

    if(isset($_POST['valueService3']))
    {
        $pdoStatement = $pdoObject->prepare("SELECT * FROM services WHERE id_service = :id_service ");
        $pdoStatement->bindValue(":id_service", 3 , PDO::PARAM_INT);
        $pdoStatement->execute();

        $stocker = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        $titre = $stocker[$_POST['champ']];


        echo json_encode($titre);
    }



    if(isset($_POST['valueTitreService1']))
    {
        $pdoStatement = $pdoObject->prepare("SELECT * FROM services WHERE id_service = :id_service ");
        $pdoStatement->bindValue(":id_service", 4 , PDO::PARAM_INT);
        $pdoStatement->execute();

        $stocker = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        $titre = $stocker['paragraphe1'];


        echo json_encode($titre);
    }

    if(isset($_POST['valueTitreService2']))
    {
        $pdoStatement = $pdoObject->prepare("SELECT * FROM services WHERE id_service = :id_service ");
        $pdoStatement->bindValue(":id_service", 4 , PDO::PARAM_INT);
        $pdoStatement->execute();

        $stocker = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        $titre = $stocker['paragraphe2'];


        echo json_encode($titre);
    }

    if(isset($_POST['valueTitreContact1']))
    {
        $pdoStatement = $pdoObject->prepare("SELECT * FROM coordonnee WHERE id_coordonnee = :id_coordonnee ");
        $pdoStatement->bindValue(":id_coordonnee", 6 , PDO::PARAM_INT);
        $pdoStatement->execute();

        $stocker = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        $titre = $stocker['titre'];


        echo json_encode($titre);
    }

    if(isset($_POST['valueTitreContact2']))
    {
        $pdoStatement = $pdoObject->prepare("SELECT * FROM coordonnee WHERE id_coordonnee = :id_coordonnee ");
        $pdoStatement->bindValue(":id_coordonnee", 6 , PDO::PARAM_INT);
        $pdoStatement->execute();

        $stocker = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        $titre = $stocker['nom'];


        echo json_encode($titre);
    }


    if(isset($_POST['valueTitreFormateur1']))
    {
        $pdoStatement = $pdoObject->prepare("SELECT * FROM formateur WHERE id_formateur = :id_formateur ");
        $pdoStatement->bindValue(":id_formateur", 1 , PDO::PARAM_INT);
        $pdoStatement->execute();

        $stocker = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        $titre = $stocker['titre1'];


        echo json_encode($titre);
    }

    if(isset($_POST['valueTitreFormateur2']))
    {
        $pdoStatement = $pdoObject->prepare("SELECT * FROM formateur WHERE id_formateur = :id_formateur ");
        $pdoStatement->bindValue(":id_formateur", 1 , PDO::PARAM_INT);
        $pdoStatement->execute();

        $stocker = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        $titre = $stocker['titre2'];


        echo json_encode($titre);
    }

    if(isset($_POST['valueLangage']))
    {
        $pdoStatement = $pdoObject->prepare("SELECT * FROM formateur WHERE id_formateur = :id_formateur ");
        $pdoStatement->bindValue(":id_formateur", 2 , PDO::PARAM_INT);
        $pdoStatement->execute();

        $stocker = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        $titre = $stocker['titre1'];


        echo json_encode($titre);
    }

    if(isset($_POST['valueFramework']))
    {
        $pdoStatement = $pdoObject->prepare("SELECT * FROM formateur WHERE id_formateur = :id_formateur ");
        $pdoStatement->bindValue(":id_formateur", 3 , PDO::PARAM_INT);
        $pdoStatement->execute();

        $stocker = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        $titre = $stocker['titre1'];


        echo json_encode($titre);
    }

    if(isset($_POST['valueCms']))
    {
        $pdoStatement = $pdoObject->prepare("SELECT * FROM formateur WHERE id_formateur = :id_formateur ");
        $pdoStatement->bindValue(":id_formateur", 4 , PDO::PARAM_INT);
        $pdoStatement->execute();

        $stocker = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        $titre = $stocker['titre1'];


        echo json_encode($titre);
    }

    if(isset($_POST['valueLogiciel']))
    {
        $pdoStatement = $pdoObject->prepare("SELECT * FROM formateur WHERE id_formateur = :id_formateur ");
        $pdoStatement->bindValue(":id_formateur", 5 , PDO::PARAM_INT);
        $pdoStatement->execute();

        $stocker = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        $titre = $stocker['titre1'];


        echo json_encode($titre);
    }

    if(isset($_POST['valueSpecialisation']))
    {
        $pdoStatement = $pdoObject->prepare("SELECT * FROM developpeur WHERE id_developpeur = :id_developpeur ");
        $pdoStatement->bindValue(":id_developpeur", 1 , PDO::PARAM_INT);
        $pdoStatement->execute();

        $stocker = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        $titre = $stocker['titre_specialisation'];


        echo json_encode($titre);
    }


    

}



