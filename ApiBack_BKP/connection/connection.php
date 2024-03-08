<?php

    $host = "localhost"; //Onde está o banco de dados
    $db_name = "projeto_int"; //Nome do banco de dados
    $user = "root"; //Usuário de conexão ao banco de dados
    $password = ""; //Senha de conexão para o banco de dados

    try{
        $conn = new PDO("mysql:host={$host};dbname={$db_name}", $user, $password);
        // echo "Connection Successfuly";
    }

    catch(\PDOException $ex){
        die("Connection error: " . $ex->getMessage());
    }
?>