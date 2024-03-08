<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; chaset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With");

    $method = $_SERVER["REQUEST_METHOD"];

    include("../.././connection/connection.php");
    include("../../valida_token.php");

    if($method == "GET"){
        // echo "GET";

        if(!isset($_GET["id"])){

            //Listar todos os registros
            try {
                $sql = "SELECT pk_genero, genero
                        FROM genero";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                
                $dados = $stmt->fetchall(PDO::FETCH_OBJ);
                // echo "<pre>";
                // var_dump($dados);
                // echo "</pre>"; 


                $result["genero"]=$dados;
                $result["status"] = "success";

                http_response_code(200);
            } 

            catch (PDOException $ex) {
                // echo "error: $ex->getMessage()";
                $result = ["status"=> "fail", "Error"=> $ex->getMessage()];
                http_response_code(200);
            }

            finally{
                $conn = null;
                echo json_encode($result);
            }
        }
        else{
            //Listar um registro
            try{
                if(empty($_GET["id"]) || !is_numeric($_GET["id"])){
                //Está vazio ou não é númerico: ERRO
                throw new ErrorException("Valor inválido", 1);
                }

                $id = $_GET["id"];

                $sql = "SELECT pk_genero, genero
                        FROM genero 
                        WHERE pk_genero=:id";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->execute();

                $dado = $stmt->fetch(PDO::FETCH_OBJ);

                $result['genero'] = $dado;
                $result["status"] = "success";
            }
            
            catch (PDOException $ex) {
                $result = ["status"=> "fail", "Error"=> $ex->getMessage()];
                http_response_code(200);
            }

            catch(Exception $ex){
                $result = ["status"=> "fail", "Error"=> $ex->getMessage()];
                http_response_code(200);
            }

            finally{
                $conn = null;
                echo json_encode($result);
            }
        }

    }


?>