<?php
    include("../connection/connection.php");
    // include("../valida_token.php");

    $method = $_SERVER['REQUEST_METHOD'];

    // echo $method;

    //COMEÇO do GET
    if($method=="GET"){
        if(isset($_GET["email"]) && 
        isset($_GET["password"]) && 
        !empty($_GET["email"]) &&
        !empty($_GET["password"])) {

            $email = $_GET["email"];
            $password = hash('sha256', $_GET["password"]);
            // $password = $_GET["password"];

            try{
                $sql = "SELECT * FROM usuario 
                WHERE email= :email 
                AND senha= :password
                AND habilita=1";
                $stmt = $conn->prepare($sql);

                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":password", $password);
                $stmt->execute();

                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if(!empty($row)){
                    echo json_encode(array("status"=>"success"));
                } 
                else{
                    echo json_encode(array("status"=>"fail"));
                }
            } 
            catch(PDOException $ex){
                die("ERROR: ". $ex->getMessage());
            }
        }
        
        else{
            //retornar erro (false)
            echo "Erro - Falta Informação";
        }
    }
    //FIM do GET
?>