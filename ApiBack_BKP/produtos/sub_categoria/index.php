<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; chaset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With");

    $method = $_SERVER["REQUEST_METHOD"];

    include("../../connection/connection.php");
    include("../../valida_token.php");

    if($method == "GET"){
        // echo "GET";

        if(!isset($_GET["id"])){

            //Listar todos os registros
            try {
                $sql = "SELECT pk_subcategoria, sub_categoria
                        FROM subcategoria";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                
                $dados = $stmt->fetchall(PDO::FETCH_OBJ);
                // echo "<pre>";
                // var_dump($dados);
                // echo "</pre>"; 


                $result["sub_categoria"]=$dados;
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

                $sql = "SELECT pk_subcategoria, sub_categoria 
                        FROM subcategoria 
                        WHERE pk_subcategoria=:id";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->execute();

                $dado = $stmt->fetch(PDO::FETCH_OBJ);

                $result['sub_categoria'] = $dado;
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

    if($method == "POST"){
        //Recupera dados do corpo (body) de uma requisição POST
        $dados = file_get_contents("php://input");

        //Decodifica JSON, sem opção TRUE
        $dados = json_decode($dados);  //Isso retorna um OBJETO

        //Função TRIM retira espaços que estão sobrando
        $sub_categoria = trim($dados->sub_categoria);   //Acessa o valor de um OBJETO 

        try {
            if(empty($sub_categoria)){
                //Está vazio ou não é númerico: ERRO
                throw new ErrorException("Valor inválido", 1);
            }

            $sql = "INSERT INTO subcategoria(sub_categoria) 
                    VALUES (:sub_categoria)";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":sub_categoria", $sub_categoria);
            $stmt->execute();

            $result = array("status"=>"success");
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

    if($method == "PUT"){
        //Recupera dados do corpo (body) de uma requisição PUT
        $dados = file_get_contents("php://input");

        //Decodifica JSON, sem opção TRUE
        $dados = json_decode($dados);
        //Isso retorna um OBJETO
        try {

            if(empty($dados->sub_categoria)){
                //Está vazio: ERRO
                throw new ErrorException("Nome de Sub_categoria é um campo obrigatório", 1);
            }

            if(empty($dados->id)){
                //Está vazio: ERRO
                throw new ErrorException("ID inválido", 1);
            }

            //Função TRIM retira espaços que estão sobrando
            $sub_categoria = trim($dados->sub_categoria);  //Acessa o valor de um OBJETO 
            $id = trim($dados->id);

            $sql = "UPDATE subcategoria 
                    SET sub_categoria=:sub_categoria 
                    WHERE pk_subcategoria=:id";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":sub_categoria", $sub_categoria);
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            $result = array("status"=>"success");
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

    if($method == "DELETE"){
            try{
                if(empty($_GET["id"]) || !is_numeric($_GET["id"])){
                //Está vazio ou não é númerico: ERRO
                throw new ErrorException("Valor inválido", 1);
                }

                $id = $_GET["id"];

                $sql = "DELETE FROM subcategoria 
                        WHERE pk_subcategoria=:id";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->execute();

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
?>