<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; chaset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With");

    $method = $_SERVER["REQUEST_METHOD"];
    include("../connection/connection.php");
    include("../valida_token.php");

    if($method == "GET"){

        if(!isset($_GET["id"]) && !isset($_GET["email"])){

            //não tem ID e lista todos os registros
            try {
                
                $sql = "SELECT pk_usuario, email, senha, habilita 
                        FROM usuario";

                $stmt = $conn->prepare($sql);
                $stmt->execute();
                
                $dados = $stmt->fetchall(PDO::FETCH_OBJ);
                $result["usuarios"]=$dados;
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

            if(isset($_GET["id"])){
                try{
                    if(empty($_GET["id"]) || !is_numeric($_GET["id"])){
                    //Está vazio ou não é númerico: ERRO
                    throw new ErrorException("Valor inválido", 1);
                    }

                    $id = $_GET["id"];

                    $sql = "SELECT pk_usuario, email, senha, habilita 
                            FROM usuario 
                            WHERE pk_usuario=:id";

                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":id", $id);
                    $stmt->execute();

                    $dado = $stmt->fetch(PDO::FETCH_OBJ);

                    $result['usuarios'] = $dado;
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

            if(isset($_GET["email"])){
                try{
                    if(empty($_GET["email"])){
                    //Está vazio ou não é númerico: ERRO
                    throw new ErrorException("Valor não inválido", 1);
                    }

                    $email = $_GET["email"];
                    $codigo = $_GET["codigo"];

                    $sql = "SELECT pk_usuario, email, habilita, codigo 
                            FROM usuario 
                            WHERE email=:email AND codigo=:codigo";

                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":codigo", $codigo);
                    $stmt->execute();

                    $dado = $stmt->fetch(PDO::FETCH_OBJ);

                    $result['usuarios'] = $dado;
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

    }

    if($method == "PUT"){
        //Recupera dados do corpo (body) de uma requisição PUT
        $dados = file_get_contents("php://input");

        //Decodifica JSON, sem opção TRUE
        $dados = json_decode($dados);
        //Isso retorna um OBJETO

        //Função TRIM retira espaços que estão sobrando
        $email = trim($dados->email);  //Acessa o valor de um OBJETO 
        $senha = trim($dados->senha); 
        $habilita = trim($dados->habilita);
        if(isset($dados->codigo)){
            $codigo = trim($dados->codigo);
        }else{
            $codigo = "";
        }
        $id = trim($dados->id);

        try {
            if(empty($dados->email)){
                //Está vazio: ERRO
                throw new ErrorException("Email é um campo obrigatório", 1);
            }

            // echo strlen($codigo);
            // exit;

            if(strlen($codigo)>0){
                $sql = "UPDATE usuario 
                SET codigo=:codigo 
                WHERE pk_usuario=:id";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":codigo", $codigo);
                $stmt->bindParam(":id", $id);
            }

            else if(!empty($dados->senha)){
                $sql = "UPDATE usuario 
                SET email=:email, senha=:senha, habilita=:habilita 
                WHERE pk_usuario=:id";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":senha", $senha);
                $stmt->bindParam(":habilita", $habilita);
                $stmt->bindParam(":id", $id);
            }

            else{
                $sql = "UPDATE usuario 
                SET email=:email, habilita=:habilita 
                WHERE pk_usuario=:id";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":habilita", $habilita);
                $stmt->bindParam(":id", $id);
            }

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

?>