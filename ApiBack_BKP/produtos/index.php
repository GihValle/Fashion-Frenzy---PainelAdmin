<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; chaset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With");

    $method = $_SERVER["REQUEST_METHOD"];

    include("../connection/connection.php");
    include("../valida_token.php");

    if($method == "GET"){
        // echo "GET";

        if(!isset($_GET["id"])){

            //Listar todos os registros
            try {

                if(!isset($_GET["genero"])) {
                    $sql = "SELECT pk_produto, img, desc_produto, produto.nome, valor, marca.marca, cor.cor, tamanho.tamanho, genero.genero, categoria.categoria, 
                                subcategoria.sub_categoria, fk_marca, fk_categoria, fk_cor, fk_tamanho, fk_genero, fk_subcategoria 
                        FROM produto 
                        JOIN marca ON pk_marca = produto.fk_marca
                        JOIN genero ON pk_genero = produto.fk_genero
                        JOIN categoria ON pk_categoria = produto.fk_categoria
                        JOIN cor ON pk_cor = produto.fk_cor
                        JOIN tamanho ON pk_tamanho = produto.fk_tamanho
                        JOIN subcategoria ON pk_subcategoria = produto.fk_subcategoria";
            
                    // $sql = "SELECT pk_produto, img, produto.nome,desc_produto, valor, marca.nome marca, genero.genero, categoria.categoria, subcategoria.sub_categoria
                    // FROM produto
                    // JOIN marca ON fk_marca = pk_marca
                    // JOIN genero ON fk_genero = pk_genero
                    // JOIN categoria ON fk_categoria = pk_categoria
                    // JOIN subcategoria ON fk_subcategoria = pk_subcategoria;";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    
                    $dados = $stmt->fetchall(PDO::FETCH_OBJ);
                    // echo "<pre>";
                    // var_dump($dados);
                    // echo "</pre>"; 
                    // exit;
                    $result["produtos"]=$dados;
                    $result["status"] = "success";

                    http_response_code(200);
                } else {

                    $genero = $_GET["genero"];

                    $sql = "SELECT pk_produto, img, desc_produto, produto.nome, valor, marca.marca, cor.cor, tamanho.tamanho, genero.genero, categoria.categoria, 
                                subcategoria.sub_categoria, fk_marca, fk_categoria, fk_cor, fk_tamanho, fk_genero, fk_subcategoria 
                        FROM produto 
                        JOIN marca ON pk_marca = produto.fk_marca
                        JOIN genero ON pk_genero = produto.fk_genero
                        JOIN categoria ON pk_categoria = produto.fk_categoria
                        JOIN cor ON pk_cor = produto.fk_cor
                        JOIN tamanho ON pk_tamanho = produto.fk_tamanho
                        JOIN subcategoria ON pk_subcategoria = produto.fk_subcategoria
                        WHERE genero.genero = :genero
                        ";
            
                    // $sql = "SELECT pk_produto, img, produto.nome,desc_produto, valor, marca.nome marca, genero.genero, categoria.categoria, subcategoria.sub_categoria
                    // FROM produto
                    // JOIN marca ON fk_marca = pk_marca
                    // JOIN genero ON fk_genero = pk_genero
                    // JOIN categoria ON fk_categoria = pk_categoria
                    // JOIN subcategoria ON fk_subcategoria = pk_subcategoria;";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":genero", $genero);
                    $stmt->execute();
                    
                    $dados = $stmt->fetchall(PDO::FETCH_OBJ);
                    // echo "<pre>";
                    // var_dump($dados);
                    // echo "</pre>"; 
                    // exit;
                    $result["produtos"]=$dados;
                    $result["status"] = "success";

                    http_response_code(200);
                }

                
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

                // $sql = "SELECT pk_produto, img, desc_produto, nome, valor, fk_marca, fk_genero, fk_categoria, fk_cor, fk_tamanho, fk_subcategoria 
                //         FROM produto 
                //         WHERE pk_produto=:id";

                $sql = "SELECT pk_produto, img, desc_produto, produto.nome, valor, marca.marca, cor.cor, tamanho.tamanho, genero.genero, categoria.categoria, 
                                subcategoria.sub_categoria, fk_marca, fk_categoria, fk_cor, fk_tamanho, fk_genero, fk_subcategoria 
                        FROM produto 
                        JOIN marca ON pk_marca = produto.fk_marca
                        JOIN genero ON pk_genero = produto.fk_genero
                        JOIN categoria ON pk_categoria = produto.fk_categoria
                        JOIN cor ON pk_cor = produto.fk_cor
                        JOIN tamanho ON pk_tamanho = produto.fk_tamanho
                        JOIN subcategoria ON pk_subcategoria = produto.fk_subcategoria 
                        WHERE pk_produto=:id";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->execute();

                $dado = $stmt->fetch(PDO::FETCH_OBJ);

                $result['produtos'] = $dado;
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
        $img = trim($dados->img);
        $desc_produto = trim($dados->desc_produto); 
        $nome = trim($dados->nome);  
        $valor = trim($dados->valor); 
        $marca = trim($dados->marca);
        $genero = trim($dados->genero);
        $categoria = trim($dados->categoria);
        $cor = trim($dados->cor);
        $tamanho = trim($dados->tamanho);
        $sub_categoria = trim($dados->sub_categoria);
         
        try {
            $sql = "INSERT INTO produto(img, desc_produto, nome, valor, fk_marca, fk_genero, fk_categoria, fk_cor, fk_tamanho, fk_subcategoria) 
                    VALUES (:img, :desc_produto, :nome, :valor, :marca, :genero, :categoria, :cor, :tamanho, :sub_categoria)";
         
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":img", $img);
            $stmt->bindParam(":desc_produto", $desc_produto);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":valor", $valor);
            $stmt->bindParam(":marca", $marca);
            $stmt->bindParam(":genero", $genero);
            $stmt->bindParam(":categoria", $categoria);
            $stmt->bindParam(":cor", $cor);
            $stmt->bindParam(":tamanho", $tamanho);
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

            // if(empty($dados->img)){
            //     //Está vazio: ERRO
            //     throw new ErrorException("Imagem é um campo obrigatório", 1);
            // }

            if(empty($dados->nome)){
                //Está vazio: ERRO
                throw new ErrorException("Nome é um campo obrigatório", 1);
            }

            if(empty($dados->valor)){
                //Está vazio: ERRO
                throw new ErrorException("Valor é um campo obrigatório", 1);
            }

            if(empty($dados->marca)){
                //Está vazio: ERRO
                throw new ErrorException("Marca é um campo obrigatório", 1);
            }

            if(empty($dados->genero)){
                //Está vazio: ERRO
                throw new ErrorException("Gênero é um campo obrigatório", 1);
            }

            if(empty($dados->categoria)){
                //Está vazio: ERRO
                throw new ErrorException("Categoria é um campo obrigatório", 1);
            }

            if(empty($dados->cor)){
                //Está vazio: ERRO
                throw new ErrorException("Cor é um campo obrigatório", 1);
            }

            if(empty($dados->tamanho)){
                //Está vazio: ERRO
                throw new ErrorException("Tamanho é um campo obrigatório", 1);
            }

            if(empty($dados->sub_categoria)){
                //Está vazio: ERRO
                throw new ErrorException("Sub Categoria é um campo obrigatório", 1);
            }

            if(empty($dados->id)){
                //Está vazio: ERRO
                throw new ErrorException("ID inválido", 1);
            }

            //Função TRIM retira espaços que estão sobrando  //Acessa o valor de um OBJETO 
            $img = trim($dados->img);
            $desc_produto = trim($dados->desc_produto); 
            $nome = trim($dados->nome);  
            $valor = trim($dados->valor); 
            $marca =trim($dados->marca);
            $genero = trim($dados->genero);
            $categoria = trim($dados->categoria);
            $cor = trim($dados->cor);
            $tamanho = trim($dados->tamanho); 
            $sub_categoria = trim($dados->sub_categoria);
            $id = trim($dados->id);

            $sql = "UPDATE produto 
                    SET desc_produto=:desc_produto, nome=:nome, img=:img,valor=:valor, fk_marca=:marca, fk_genero=:genero, fk_categoria=:categoria, fk_cor=:cor, fk_tamanho=:tamanho, fk_subcategoria=:subcategoria 
                    WHERE pk_produto=:id";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(":img", $img);
            $stmt->bindParam(":desc_produto", $desc_produto);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":valor", $valor);
            $stmt->bindParam(":marca", $marca);
            $stmt->bindParam(":genero", $genero);
            $stmt->bindParam(":categoria", $categoria);
            $stmt->bindParam(":cor", $cor);
            $stmt->bindParam(":tamanho", $tamanho);
            $stmt->bindParam(":subcategoria", $sub_categoria);
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

            $sql = "DELETE FROM produto 
                    WHERE pk_produto=:id";

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