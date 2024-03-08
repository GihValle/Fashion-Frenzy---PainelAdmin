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
            $sql = "SELECT email, habilita FROM usuario WHERE email = :email AND senha= :password";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $password);

            $stmt->execute();

            $dado = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!empty($dado)){
                
                $result['login'] = $dado;
                $result["status"] = "success";
                echo json_encode($result);
                
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