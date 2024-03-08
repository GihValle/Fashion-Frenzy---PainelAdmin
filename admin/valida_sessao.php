<?php

    session_start();

    $url = "http://localhost:8000/admin";

    if($_SESSION["autentificacao"] != true){
        header("location: $url/login.php");
        exit;
    }

    $token='77cbc1f93d7f';
?>