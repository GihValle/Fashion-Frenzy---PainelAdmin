<?php
// include("../connection/connection.php");

if(!isset($_SERVER['HTTP_ACCESSTOKEN']) || empty($_SERVER['HTTP_ACCESSTOKEN'])){
        //trata o erro
        //Se a variável HTTP_ACCESSTOKEN não existe ou está vazia
        $result = ["status"=> "fail", "Error"=> "Token Error"];
        http_response_code(200);
        echo json_encode($result);
        exit;
    }

    $acess_token = $_SERVER['HTTP_ACCESSTOKEN'];

    //Passo 1 - Consultar banco verifica se token existe
    $sql = "SELECT pk_id, email, cpf 
            FROM token 
            WHERE token= :token";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":token", $acess_token);
    $stmt->execute();

    $dado = $stmt->fetch(PDO::FETCH_OBJ);

    if(!$dado){
        //Erro - Não veio informação sobre o Token pesquisado
        $result = ["status"=> "fail", "Error"=> "Token não existe"];
        http_response_code(200);
        echo json_encode($result);
        exit;
    }

?>