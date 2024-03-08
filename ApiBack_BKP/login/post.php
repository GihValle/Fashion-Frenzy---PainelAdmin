<?php
    include("../connection/connection.php");

    // if (isset($_POST["email"]) && 
    // isset($_PSOT["password"]) && 
    // !empty($_GET["email"]) && 
    // !empty($_GET["password"])) {

        $dados = file_get_contents("php://input");
        $dados = json_decode($dados,TRUE);
       
        $email = $dados["email"];
        $password = $dados["password"];

        // echo "<pre>";
        // print_r($dados);
        // echo "</pre>";

        try{
            $sql = "SELECT * FROM usuario WHERE email = :email AND senha= :password";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $password);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!empty($row)){
                echo json_encode(array("status"=>"success"));
            }else{
                echo json_encode(array("status"=>"fail"));
            }

            
        }catch(PDOException $ex){
            die("ERROR: ". $ex->getMessage());
        }

    // }else{
    //     // retornar erro (false)
    //     echo "erro falta informação";
    // }
    


?>