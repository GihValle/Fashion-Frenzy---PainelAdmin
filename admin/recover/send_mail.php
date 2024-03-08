<?php
// Tela esquecia a senha: informar e-mail
//- verificar se e-mail foi digitado ou se existe an reguisição POST
//- verificar se e-mail  digitado é válido
// - verificar se e-mail existe; API consulta (GET)
// - se existir: criar código , salvar no banco (API-PUT), enviar e-mail com código
// - se não existir: restornar erro "E-mail não existe"
// - endpoint envolvido : USUARIO

//- verificar se e-mail foi digitado ou se existe an reguisição POST
if(!isset($_POST["email"]) || empty($_POST["email"])){
    // finalizar o que será feito quando entrar no erro
    echo "E-mail não informado!";
    exit;
}

//- verificar se e-mail  digitado é válido
if(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
    // finalizar o que será feito quando entrar no erro
    echo "E-mail inválido";
    exit;
}

$email = $_POST["email"];
$end_point = 'http://localhost/api_back/usuarios/';
$token = '77cbc1f93d7f';

// - verificar se e-mail existe no cadastro; API consulta (GET)
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $end_point.'?email='.$email,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization:' . $token
  ),
));

$response = curl_exec($curl);

curl_close($curl);

$dado = json_decode($response);
// echo "<pre>";
// var_dump($dado);
// echo "</pre>";
// exit;

$usuario = $dado->usuarios;

// - se não existir: restornar erro "E-mail não existe"
if(!$usuario){
     // finalizar o que será feito quando entrar no erro
     echo "E-mail não cadastrado!";
     exit;
}


// - se existir: criar código , salvar no banco (API-PUT), enviar e-mail com código
// criar código
$codigo = hash('sha256', $email.date('d/m/Y - H:i:s'));
$codigo = substr($codigo, -6, 6);
$id = $usuario->pk_usuario;

// montar body JSON
$post_body = json_encode([
    'id' => $id,
    'email' => $email, 
    'senha' => '', 
    'habilita' => '',
    'codigo'=> $codigo
]);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $end_point,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'PUT',
  CURLOPT_POSTFIELDS => $post_body,
  CURLOPT_HTTPHEADER => array(
    'Authorization:' . $token,
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);
$response = json_decode($response);

// curl_close($curl);
// echo $response;
// exit;

if($response->status != "success"){
    // finalizar o que será feito quando entrar no erro
    echo "Erro indefinido. Contate o administrador do sistema!";
    exit; 
}

    require '../../vendor/plugins/php_mailer/Exception.php';
    require '../../vendor/plugins/php_mailer/PHPMailer.php';
    require '../../vendor/plugins/php_mailer/SMTP.php';


    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings

    // SMTP::DEBUG_OFF (0): Desativar o debug (você pode deixar sem preencher este valor, uma vez que esta opção é o padrão).
    // SMTP::DEBUG_CLIENT (1): Imprimir mensagens enviadas pelo cliente.
    // SMTP::DEBUG_SERVER (2): similar ao 1, mais respostas recebidas dadas pelo servidor (esta é a opção mais usual).
    // SMTP::DEBUG_CONNECTION (3): similar ao 2, mais informações sobre a conexão inicial - este nível pode auxiliar na ajuda com falhas STARTTLS.
    // SMTP::DEBUG_LOWLEVEL (4): similar ao 3, mais informações de baixo nível, muito prolixo, não use para debugar SMTP, apenas em problemas de baixo nível.

        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output - SMTP::DEBUG_SERVER (ON)
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'mail.glaucosantos.com.br';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'ti_manha@glaucosantos.com.br';                     //SMTP username
        $mail->Password   = 'Senac2023';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('ti_manha@glaucosantos.com.br', 'Sistema');
        $mail->addAddress($email);     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);
        $mail->charset="UTF-8";                                 //Set email format to HTML
        $mail->Subject = 'Troca de senha - codigo';
        $mail->Body    = 'Segue código para troca de senha: <br> <strong>Código</strong> '.$codigo;
        $mail->AltBody = 'Segue código para troca de senha: '.$codigo;

        $mail->send();
        header("location: recover-password.php");
        exit;
    } catch (Exception $e) {
        echo "<h1>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</h1>";
    }



?>