<?php
// include("../connection/connection.php");
$headers = apache_request_headers();

// if(!isset($_SERVER['HTTP_ACCESSTOKEN']) || empty($_SERVER['HTTP_ACCESSTOKEN'])){
if(!isset($headers["Authorization"]) || empty($headers["Authorization"])){
        //trata o erro
        //Se a variável HTTP_ACCESSTOKEN não existe ou está vazia
        $result = ["status"=> "fail", "Error"=> "Token Error"];
        http_response_code(200);
        echo json_encode($result);
        exit;
    }

    $acess_token = $headers["Authorization"];

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