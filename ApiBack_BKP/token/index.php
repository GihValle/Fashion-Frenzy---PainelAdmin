<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; chaset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With");

    $method = $_SERVER["REQUEST_METHOD"];

    include("../connection/connection.php");

    if($method == "GET"){
        //criar resposta para GET
    }

    if($method == "POST"){
        //Recupera dados do corpo (body) de uma requisição POST
        $dados = file_get_contents("php://input");

        //Decodifica JSON, sem opção TRUE
        $dados = json_decode($dados);  //Isso retorna um OBJETO

        try {
            if(empty($dados->email) || !isset($dados->email)){
                //Está vazio ou não é númerico: ERRO
                throw new ErrorException("E-mail inválido", 1);
            }

            if(empty($dados->cpf) || !isset ($dados->cpf)){
                //Está vazio ou não é númerico: ERRO
                throw new ErrorException("cpf inválido", 1);
            }


            if (!filter_var($dados->email, FILTER_VALIDATE_EMAIL)){
                //TESTE: validação do email(formato)
                throw new ErrorException("E-mail inválido", 1);
            }

            //Função TRIM retira espaços que estão sobrando
            //Recupera valores do objeto e atribui às variáveis
            $email = trim($dados->email); //Acessa valor de um OBJETO
            $cpf = trim($dados->cpf); 


            //Validar o CPF para saber se não é um zé ruela

            /** 
             * Passo 1 - consumir API de validação do CPF (cURL)
             * Passo 2 - se a resposta for FALSE levanta exceção de erro (CATCH)
            */

            $curl = curl_init();
            $cpf_token = '6707%7CycgcY5FwjgzsKdFraTx9wbtA9pNJoA9F';
            $end_point_cpf = 'https://api.invertexto.com/v1/validator';

            curl_setopt_array($curl, array(
            CURLOPT_URL => $end_point_cpf . '?token='. $cpf_token .'&value='. $cpf .'&type=cpf',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $response = json_decode($response);

            if(!$response->valid){
                //Se a condição for verdadeira
                throw new ErrorException("CPF inválido", 1);
            }

            //passo1:pensar em uma estratégia de criar um Token que nunca se repita
            //Token tem que ser único
            $temp = $email.$cpf.date('d/m/Y - H:i:s');
            $temp = hash("sha256", $temp);

            $token = substr($temp, 0, 6) . substr($temp, -6, 6);

            //passo2:criar uma nova tabela no banco de dados para armazenar os dados e o Token criado

            //passo3: continuar alterando o código abaixo
            $sql = "INSERT INTO token(email, cpf, token, data_criacao) 
                    VALUES (:email, :cpf, :token, now())";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":cpf", $cpf);
            $stmt->bindParam(":token", $token);
            $stmt->execute();

            $result = array("email"=>$email, "cpf"=>$cpf, "token"=>$token);
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
                $result = ["status"=> "fail", "Error"=> $ex->getMEssage()];
                http_response_code(200);
            }
            finally{
                $conn = null;
                echo json_encode($result);
            }
    }

    if($method == "PUT"){
        //criar resposta para PUT
    }

    if($method == "DELETE"){
        //criar resposta para DELETE
    }
?>