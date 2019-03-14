<?php
require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// $response = json_encode(['response'=>' 1212']);
// echo $response;
// return;


$errorMSG = "";

// NAME
if (empty($_POST["name"])) {
    $errorMSG = "Name is required ";
} else {
    $name = $_POST["name"];
}

// EMAIL
if (empty($_POST["email"])) {
    $errorMSG .= "Email is required ";
} else {
    $email = $_POST["email"];
}

//tel
$tel = $_POST["tel"];


// MSG SUBJECT
if (empty($_POST["msg_subject"])) {
    $errorMSG .= "Subject is required ";
} else {
    $msg_subject = $_POST["msg_subject"];
}

// MESSAGE
if (empty($_POST["message"])) {
    $errorMSG .= "Message is required ";
} else {
    $message = $_POST["message"];
}



if ($errorMSG == "") {
      $newEmail = new PHPMailer();
			$newEmail->isSMTP();
			// $newEmail->SMTPDebug = 2;
      $newEmail->Host='mx1.hostinger.com.ar';
      $newEmail->Port = 587;
			$newEmail->SMTPAuth= true;
			// $newEmail->SMTPSecure ='ssl';
			$newEmail->isHTML();
			$newEmail->Username = 'contacto@reinicia.org.ar';
			$newEmail->Password = 'reiniciapassword';

			$newEmail->SetFrom('contacto@reinicia.org.ar');

      //for user
			$newEmail->Subject= 'Reinicia';
			$newEmail->Body = '
        <html>
        <head>
          <title>Reinicia Asociación Civil</title>
        </head>
        <body>
          <p>Hola '.$name.',</p><br>
          <p>Gracias por contactarte con Reinicia Asociación Civil.</p><br>
          <p>Nos pondremos en contacto con usted a la brevedad.</p><br>
          <br>
          <br>
          <h3>Reinicia Asociación Civil</h3>
          <h3><a href="mailto:contacto@reinicia.org.ar">contacto@reinicia.org.ar</a></h3>

          <table>
            <tr>
              <th> Nombre Completo </th><th>Tel</th><th>Email</th>
            </tr>
            <tr>
              <td>'.$name.'</td><td>'.$tel.'</td><td>'.$email.'</td>
            </tr>
          </table>
          <h3>Asunto: '.$msg_subject.'</h3>
          <h3>Mensaje: '.$message.'</h3>
        </body>
        </html>
        ';

		$newEmail->AddAddress($email);
			$sentUser = $newEmail->Send();

      //clear
			$newEmail->ClearAllRecipients( );

      //for admin
      $newEmail->Subject = $msg_subject;
      // $newEmail->Body = $message.$email.$tel;
      $newEmail->Body = '
        <html>
        <head>
          <title>Contacto</title>
        </head>
        <body>
          <p>La siguiente persona quiere contactarte</p>'.$email.'
          <table>
            <tr>
              <th> Nombre Completo </th><th>Tel</th><th>Email</th>
            </tr>
            <tr>
              <td>'.$name.'</td><td>'.$tel.'</td><td>'.$email.'</td>
            </tr>
          </table>
          <h3>Asunto: '.$msg_subject.'</h3>
          <h3>Mensaje: '.$message.'</h3>
        </body>
        </html>
        ';

      // $newEmail->AddAddress('asociacionreiniciaargentina@gmail.com');
      $newEmail->AddAddress('contacto@reinicia.org.ar');

    }

    $sentAdmin = $newEmail->Send();

// redirect to success page
if ($sentUser && $sentAdmin){
    // header('Location: ' . $_SERVER['HTTP_REFERER']);
    $response = json_encode('Gracias por comunicarte con nosotros');
    echo $response;

}else{
    // if($errorMSG == ""){
    // echo "Something went wrong :(";
    // } else {
    // echo $errorMSG;
    // }
    $response = json_encode('Hubo un error');
    echo $response;

}

?>
