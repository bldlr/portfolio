<?php
require_once("include/init.php");

if($_POST){
    function getCaptcha($SecretKey){
        $Response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".SECRET_KEY."&response={$SecretKey}");
        $Return = json_decode($Response);
        return $Return;
    }
    $Return = getCaptcha($_POST['g-recaptcha-response']);
    //var_dump($Return); die;
    if($Return->success == true && $Return->score > 0.5){
        $confirmation = true;
    }else{
        $confirmation = false;
    }
}

$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["telephone"];


if(empty($_POST["entreprise"]))
{
    $company = "non renseignée";
}
else
{
    $company = $_POST["entreprise"];
}

$message = $_POST["message"];

$EmailTo = $pdoObject->query("SELECT * FROM coordonnee WHERE id_coordonnee = 5");
$EmailTo = $EmailTo->fetch(PDO::FETCH_ASSOC);


$Subject = "BART LORD : Nouveau message";

// prepare email body text
$Fields .= "Nom: ";
$Fields .= $name;
$Fields .= "\n";

$Fields.= "Email: ";
$Fields .= $email;
$Fields .= "\n";

$Fields .= "Téléphone: ";
$Fields .= $phone;
$Fields .= "\n";

$Fields .= "Société: ";
$Fields .= $company;
$Fields .= "\n";

$Fields .= "Message: ";
$Fields .= $message;
$Fields .= "\n";


// send email
$success = mail($EmailTo['nom'],  $Subject,  $Fields, "From:".$email);



