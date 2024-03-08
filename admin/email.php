<?php

require '../vendor/plugins/php_mailer/Exception.php';
require '../vendor/plugins/php_mailer/PHPMailer.php';
require '../vendor/plugins/php_mailer/SMTP.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
// require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output - SMTP::DEBUG_SERVER (ON)
    // SMTP::DEBUG_OFF (0): Desativar o debug (você pode deixar sem preencher este valor, uma vez que esta opção é o padrão).
    // SMTP::DEBUG_CLIENT (1): Imprimir mensagens enviadas pelo cliente.
    // SMTP::DEBUG_SERVER (2): similar ao 1, mais respostas recebidas dadas pelo servidor (esta é a opção mais usual).
    // SMTP::DEBUG_CONNECTION (3): similar ao 2, mais informações sobre a conexão inicial - este nível pode auxiliar na ajuda com falhas STARTTLS.
    // SMTP::DEBUG_LOWLEVEL (4): similar ao 3, mais informações de baixo nível, muito prolixo, não use para debugar SMTP, apenas em problemas de baixo nível.

    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.glaucosantos.com.br';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'ti_manha@glaucosantos.com.br';                     //SMTP username
    $mail->Password   = 'Senac2023';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('ti_manha@glaucosantos.com.br', 'Sistema');
    $mail->addAddress('givalle2005@gmail.com', 'Giovanna');     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);
    $mail->charset = "UTF-8";                                  //Set email format to HTML
    $mail->Subject = 'Teste de envio de e-mail';
    $mail->Body    = 'Testando o envio de e-mail com conteúdo <b>HTML</b>';
    $mail->AltBody = 'Testando o envio de e-mail com conteúdo para clientes que não interpretam HTML';

    $mail->send();
    echo '<h1>Message has been sent</h1>';
} catch (Exception $e) {
    echo "<h1>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</h1>";
}

?>