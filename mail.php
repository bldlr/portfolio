<?php
require_once("include/init.php");
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

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



$EmailTo = $pdoObject->query("SELECT * FROM coordonnee WHERE id_coordonnee = 5");
$EmailTo = $EmailTo->fetch(PDO::FETCH_ASSOC);


$Subject = "BART LORD : Nouveau message";

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

 try {
    //Server settings
    $mail->SMTPDebug = 0;                    // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.phpnet.org';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'contact@bldlr.fr';                     // SMTP username
    $mail->Password   = '***';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('contact@bldlr.fr', 'BLDLR');
    $mail->addAddress('contact@bldlr.fr');     // Add a recipient
    //$mail->addReplyTo('contact@bldlr.fr', 'Informations utilisateur BLDLR');
    //$mail->addCC('contact@bldlr.fr');
    // $mail->addBCC('bcc@example.com');

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'BART LORD : Nouveau message';

    // message HTML
    $message = 

    '<html>
        <body>

            ' . "Date du message : " . date("d/m/Y") . "<br> 
                 Nom : " . $name . " <br>
                 Email : " . $email . " <br>
                 Numero : " . $phone . " <br>
                 Entreprise : " . $company . " <br>
                 Message : <br>" . 
            
            nl2br(htmlentities($_POST["message"])) . '
        </body>
    </html>';

    $mail->Body = $message;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Le message a été envoyé';
} catch (Exception $e) {
    echo "Le message n'a pas pu être envoyé. Mailer Error: {$mail->ErrorInfo}";
}
