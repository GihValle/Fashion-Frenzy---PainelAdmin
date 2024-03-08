<?php
// Tela de recuperação de senha: (e-mail, código, senha e confirma senha)
// - criar campo de e-mail e código
// - no campo e-mail, inserir o mesmo utilizado no login
// - no campo código, inserir o código enviado para o seu e-mail
// - inserir a nova senha
// - inserir a nova senha novamente; Confirmar se as senhas são iguais
// - se senhas iguais, e-mail e código existem, atualiza a senha
// - se NÃO forem iguais, vai continuar na tela de trocar senha, mas com um aviso de Erro ('As senhas não são identicas')
// - E-mail e código diferentes são inválidos/não foram encontrados
// - após atualizar a senha, voltar para a tela de login

// echo "<pre>";
// var_dump ($_POST);
// echo "</pre>";

//- verificar se todas as informações foram digitado
if(!isset($_POST["email"]) || !isset($_POST["codigo"]) ||
   !isset($_POST["senha"]) || !isset($_POST["confirmar_senha"])){
    echo "Informações incorretas!";
    exit;
   }

if(empty($_POST["email"]) || empty($_POST["codigo"]) || 
   empty($_POST["senha"]) || empty($_POST["confirmar_senha"])){
    echo "Informações não informadas!";
    exit;
   }

// - inserir a nova senha novamente; Confirmar se as senhas são iguais
if($_POST["senha"] != $_POST["confirmar_senha"]){
    // finalizar o que será feito quando entrar no erro
    echo "Senhas diferentes!";
    exit;
}

$email = $_POST["email"];
$codigo = $_POST["codigo"];
$senha = $_POST["senha"];
$confirmar_senha = $_POST["confirmar_senha"];

$end_point = 'http://localhost/api_back/recover/';
$token = '77cbc1f93d7f';

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $end_point.'?email='.$email. '&codigo='.$codigo,
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

$usuario = $dado->usuarios;
if(!$usuario){
    // finalizar o que será feito quando entrar no erro
    echo "E-mail ou códigos incorreto!";
    exit;
}

// montar body JSON
$id = $usuario->pk_usuario;
$post_body = json_encode([
    'id' => $id,
    'email' => $email, 
    'senha' => $senha, 
    'habilita' => ''
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

// print_r($response);
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
    $mail->Subject = 'Senha foi alterada';
    $mail->Body    = 'Sua senha foi alterada com<br> <strong>Sucesso!</strong> ';
    $mail->AltBody = 'Sua senha foi alterada com Sucesso!';

    $mail->send();
    header("location: /admin/login.php");
    exit;
} catch (Exception $e) {
    echo "<h1>Mensagem não pode ser enviada. Erro enviado: {$mail->ErrorInfo}</h1>";
}

?>