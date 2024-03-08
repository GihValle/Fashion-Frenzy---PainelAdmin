<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; chaset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With");

    $method = $_SERVER["REQUEST_METHOD"];
    include("../connection/connection.php");
    include("../valida_token.php");

    if($method == "GET"){

        //Validar o Login do cliente
        if(!empty($_GET["email"]) && !empty($_GET["senha"])){
            
            $email = trim($_GET["email"]);
            $senha = hash("sha256",base64_decode(trim($_GET["senha"])));
            
            try{
                $sql = "SELECT pk_cliente, nome 
                FROM cliente 
                WHERE email = :email 
                AND senha = :senha";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":senha", $senha);
                $stmt->execute();

                $dados = $stmt->fetch(PDO::FETCH_OBJ);

                if($dados){
                    $result["clientes"]=$dados;
                    $result["status"] = "success";
                } else{
                    $result = ["status"=> "fail", "Error"=> "E-mail e/ou senha inválidos"];
                    http_response_code(200);
                }

            } catch(Exception $ex){
                $result = ["status"=> "fail", "Error"=> $ex->getMessage()];
                http_response_code(200);
            }
            finally{
                $conn = null;
                echo json_encode($result);
            }
        }

        elseif(!isset($_GET["id"])){

            //Listar todos os registros
            try {
                $sql = "SELECT pk_cliente, nome, cpf, tel, endereco, nascimento, email, senha 
                        FROM cliente";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                
                $dados = $stmt->fetchall(PDO::FETCH_OBJ);
                // echo "<pre>";
                // var_dump($dados);
                // echo "</pre>"; 

                $result["clientes"]=$dados;
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
                throw new ErrorException("Valor inválido", 1);
                }

                $id = $_GET["id"];

                $sql = "SELECT pk_cliente, nome, cpf, tel, endereco, nascimento, email, senha 
                        FROM cliente 
                        WHERE pk_cliente=:id";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->execute();

                $dado = $stmt->fetch(PDO::FETCH_OBJ);

                $result['clientes'] = $dado;
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

        // echo "<pre>";
        // print_r($dados);
        // echo "</pre>";
        // exit;

        //Função TRIM retira espaços que estão sobrando
        $nome = trim($dados->nome);
        $cpf = trim($dados->cpf);
        $tel = trim($dados->tel);
        $endereco = trim($dados->endereco);
        $email = trim($dados->email);
        $senha = hash("sha256", trim($dados->senha));
        //Acessa o valor de um OBJETO 

        try {
            if(empty($nome)){
                //Está vazio ou não é númerico: ERRO
                throw new ErrorException("Nome inválido", 1);
            }

            if(empty($cpf)){
                //Está vazio ou não é númerico: ERRO
                throw new ErrorException("CPF inválido", 1);
            }

            if(empty($tel)){
                //Está vazio ou não é númerico: ERRO
                throw new ErrorException("Telefone inválido", 1);
            }

            if(empty($endereco)){
                //Está vazio ou não é númerico: ERRO
                throw new ErrorException("Endereço inválido", 1);
            }

            if(empty($email)){
                //Está vazio ou não é númerico: ERRO
                throw new ErrorException("Email inválido", 1);
            }

            if(empty($senha)){
                //Está vazio ou não é númerico: ERRO
                throw new ErrorException("Senha inválida", 1);
            }

            $sql = "INSERT INTO cliente(nome, cpf, tel, endereco) 
                    VALUES (:nome, :cpf, :tel, :endereco)";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":cpf", $cpf);
            $stmt->bindParam(":tel", $tel);
            $stmt->bindParam(":endereco", $endereco);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":senha", $senha);
            $stmt->execute();

            $result = array("status"=>"success");
        } 
        
 
            catch (PDOException $ex) {
                $err = $ex->errorInfo[1];

                if($err == 1062){
                    $result = ["status"=> "fail", "error"=> "Não permitido: E-mail ou CPF duplicados."];
                }
                else{
                    $result = ["status"=> "fail", "Error"=> $ex->getMEssage()];
                }
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
            if(empty($dados->nome)){
                //Está vazio: ERRO
                throw new ErrorException("Nome é um campo obrigatório", 1);
            }

            if(empty($dados->cpf)){
                //Está vazio: ERRO
                throw new ErrorException("CPF é um campo obrigatório", 1);
            }

            if(empty($dados->tel)){
                //Está vazio: ERRO
                throw new ErrorException("Telefone é um campo obrigatório", 1);
            }

            if(empty($dados->endereco)){
                //Está vazio: ERRO
                throw new ErrorException("Endereço é um campo obrigatório", 1);
            }

            if(empty($dados->nascimento)){
                //Está vazio: ERRO
                throw new ErrorException("Data de nascimento é um campo obrigatório", 1);
            }

            if(empty($dados->id)){
                //Está vazio: ERRO
                throw new ErrorException("ID inválido", 1);
            }

            //Função TRIM retira espaços que estão sobrando   
            $nome = trim($dados->nome); //Acessa o valor de um OBJETO 
            $cpf = trim($dados->cpf); 
            $tel = trim($dados->tel); 
            $endereco = trim($dados->endereco); 
            $nascimento = trim($dados->nascimento); 
            $id = trim($dados->id);


            $sql = "UPDATE cliente 
                    SET nome=:nome, cpf=:cpf, tel=:tel, endereco=:endereco, nascimento=:nascimento 
                    WHERE pk_cliente=:id";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":cpf", $cpf);
            $stmt->bindParam(":tel", $tel);
            $stmt->bindParam(":endereco", $endereco);
            $stmt->bindParam(":nascimento", $nascimento);
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

                $sql = "DELETE FROM cliente 
                        WHERE pk_cliente=:id";

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