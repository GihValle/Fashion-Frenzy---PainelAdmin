<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; chaset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With");

    $method = $_SERVER["REQUEST_METHOD"];
    include("../connection/connection.php");
    // include("../valida_token.php");

    if($method == "GET"){

        if(!isset($_GET["id"])){

            //  echo "<pre>";
            //  var_dump($_GET);
            //  echo "</pre>"; 
            //  exit;

            //Listar todos os registros
            try {
                if(isset($_GET["nome"])){
                    $sql = "SELECT pk_pedido, valor_total, cod_rastrea, data_pedido, tipo_pagamento, cod_promocao, cliente.nome 
                    FROM pedido 
                    JOIN cliente ON pk_cliente = pedido.fk_cliente";
                }

                else{
                     $sql = "SELECT pk_pedido, valor_total, cod_rastrea, data_pedido, tipo_pagamento, cod_promocao, fk_cliente, cliente.nome 
                     FROM pedido 
                     JOIN cliente ON pk_cliente = pedido.fk_cliente";
                }

                $stmt = $conn->prepare($sql);
                $stmt->execute();
                
                $dados = $stmt->fetchall(PDO::FETCH_OBJ);
                $result["pedidos"]=$dados;
                $result["status"] = "success";

                http_response_code(200);
            } 

            catch (PDOException $ex) {
                // echo "error: $ex->getMessage()";
                $result = ["status"=> "fail", "Error"=> $get->getMessage()];
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
                throw new ErrorException("Registro inválido", 1);
                }

                $id = $_GET["id"];

                $sql = "SELECT pk_pedido, valor_total, cod_rastrea, data_pedido, tipo_pagamento, cod_promocao, fk_cliente 
                        FROM pedido 
                        WHERE pk_pedido=:id";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->execute();

                $dado = $stmt->fetch(PDO::FETCH_OBJ);

                $result['pedidos'] = $dado;
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
            $valor_total = trim($dados->valor_total);
            $cod_rastrea = trim($dados->cod_rastrea); 
            $tipo_pagamento = trim($dados->tipo_pagamento);   //Acessa o valor de um OBJETO 
            $cod_promocao  = trim($dados->cod_promocao);
            $cliente = trim($dados->cliente); 

        try {
            if(empty($valor_total)){
                //Está vazio ou não é númerico: ERRO
                throw new ErrorException("Valor inválido", 1);
            }

            if(empty($cod_rastrea)){
                //Está vazio ou não é númerico: ERRO
                throw new ErrorException("Código inválido", 1);
            }

            if(empty($tipo_pagamento)){
                //Está vazio ou não é númerico: ERRO
                throw new ErrorException("Tipo de Pagamento inválido", 1);
            }

            if(empty($cliente)){
                //Está vazio ou não é númerico: ERRO
                throw new ErrorException("Cliente inválido", 1);
            }

            $sql = "INSERT INTO pedido(valor_total, cod_rastrea, data_pedido, tipo_pagamento, cod_promocao, fk_cliente) 
                    VALUES (:valor_total, :cod_rastrea, now(), :tipo_pagamento, :cod_promocao, :fk_cliente)";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":valor_total", $valor_total);
            $stmt->bindParam(":cod_rastrea", $cod_rastrea);
            $stmt->bindParam(":tipo_pagamento", $tipo_pagamento);
            $stmt->bindParam(":cod_promocao", $cod_promocao);
            $stmt->bindParam(":fk_cliente", $cliente);
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

            if(empty($dados->valor_total)){
                //Está vazio: ERRO
                throw new ErrorException("Valor é um campo obrigatório", 1);
            }

            if(empty($dados->cod_rastrea)){
                //Está vazio: ERRO
                throw new ErrorException("Código de Rastreamento é um campo obrigatório", 1);
            }

            if(empty($dados->tipo_pagamento)){
                //Está vazio: ERRO
                throw new ErrorException("Tipo de pagamento é um campo obrigatório", 1);
            }

            if(empty($dados->id)){
                //Está vazio: ERRO
                throw new ErrorException("ID inválido", 1);
            }

            //Função TRIM retira espaços que estão sobrando
            $valor_total = trim($dados->valor_total);  //Acessa o valor de um OBJETO 
            $cod_rastrea = trim($dados->cod_rastrea); 
            $tipo_pagamento = trim($dados->tipo_pagamento);  
            $cod_promocao  = trim($dados->cod_promocao); 
            $id = trim($dados->id);


            $sql = "UPDATE pedido 
                    SET valor_total=:valor_total, cod_rastrea=:cod_rastrea, data_pedido=now(), tipo_pagamento=:tipo_pagamento, cod_promocao=:cod_promocao 
                    WHERE pk_pedido=:id";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":valor_total", $valor_total);
            $stmt->bindParam(":cod_rastrea", $cod_rastrea);
            $stmt->bindParam(":tipo_pagamento", $tipo_pagamento);
            $stmt->bindParam(":cod_promocao", $cod_promocao);
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

                $sql = "DELETE FROM pedido 
                        WHERE pk_pedido=:id";

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