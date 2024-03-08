<?php
    //RECEBER os dados do formulário login
    $email = $_POST["email"];
    $password = $_POST["password"];

    //VERIFICA se email OU password estão vazios
    if(empty($email) || empty($password)){

        //REDIRECIONA para a tela de login
        header("location: login.php");
        exit;
    }

    //UTILIZAÇÃO do hash para criptografar a senha

    //Endpoint da API
    $end_point = "http://localhost/api_back/login/get.php?email=$email&password=$password";

    //INICIALIZA o CURL 
    $curl = curl_init();

    //Configurações do CURL
    curl_setopt_array($curl,[
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $end_point
    ]);

    //ENVIO do comando CURL e armazenamento da resposta
    $response = curl_exec($curl);

    //Conversão do JSON para ARRAY
    $dado = json_decode($response, TRUE);

    //Testa o retorno da API. Se houver falha, redireciona para o login.php
    if ($dado["status"] == 'fail'){
        $msg = "Falha no processo de login. Tente novamente";
        $status = "fail";
        header("location: login.php?msg=$msg&status=$status");
        exit;
    }

    //Caso esteja tudo certo, redireciona para o index.php (painel Administrativo)
    session_start();
    $_SESSION["autentificacao"] = true;
    $_SESSION["email"] = $email;
    $msg = "Login efetuado com sucesso!";
    $status = "success";
    header("location: index.php?msg=$msg&status=$status");
    exit;
?>