<?php
    include("../valida_sessao.php");
    if(!empty($_POST)){
        $nome = $_POST['nome']; 
        $desc_produto = $_POST['desc_produto']; 
        $valor = $_POST['valor']; 
        $marca = $_POST['marca'];
        $genero = $_POST['genero'];
        $categoria = $_POST['categoria'];
        $cor = $_POST["cor"];
        $tamanho = $_POST["tamanho"];
        $subcategoria = $_POST['sub_categoria'];


        // echo "<pre>";
        // var_dump($_FILES["imagem"]);
        // echo "</pre>";

        // exit;

        $arquivo = $_FILES["imagem"];
        
        if(!empty($arquivo["name"])){
            
            $caminho_absoluto = $_SERVER["DOCUMENT_ROOT"]."\assets\img\produtos";
            $caminho_relativo = "assets/img/produtos/".$arquivo["name"];
                        
            // Move o arquivo da pasta temporaria de upload para a pasta de destino 
            if (move_uploaded_file($arquivo["tmp_name"], $caminho_absoluto."/".$arquivo["name"])) { 
                echo "Arquivo enviado com sucesso!"; 
            } 
            else { 
                echo "Erro, o arquivo n&atilde;o pode ser enviado."; 
            }        
        }else{
            $caminho_relativo="";
        }

        $img = $caminho_relativo;

        if(empty($nome)){
            $msg = "Campo Nome é obrigatório";
            $status = 'fail';
            header("location: form.php?msg=$msg&status=$status");
            exit;
        }

        if(empty($valor)){
            $msg = "Campo Valor é obrigatório";
            $status = 'fail';
            header("location: form.php?msg=$msg&status=$status");
            exit;
        }

        if(empty($marca)){
            $msg = "Campo Marca é obrigatório";
            $status = 'fail';
            header("location: form.php?msg=$msg&status=$status");
            exit;
        }

        if(empty($genero)){
            $msg = "Campo Gênero é obrigatório";
            $status = 'fail';
            header("location: form.php?msg=$msg&status=$status");
            exit;
        }

        if(empty($categoria)){
            $msg = "Campo Categoria é obrigatório";
            $status = 'fail';
            header("location: form.php?msg=$msg&status=$status");
            exit;
        }

        if(empty($cor)){
            $msg = "Campo Cor é obrigatório";
            $status = 'fail';
            header("location: form.php?msg=$msg&status=$status");
            exit;
        }

        if(empty($tamanho)){
            $msg = "Campo Tamanho é obrigatório";
            $status = 'fail';
            header("location: form.php?msg=$msg&status=$status");
            exit;
        }

        if(empty($subcategoria)){
            $msg = "Campo Sub_Categoria é obrigatório";
            $status = 'fail';
            header("location: form.php?msg=$msg&status=$status");
            exit;
        }

        //End-point da API
        $end_point = "http://localhost/api_back/produtos/";

        //INICIALIZA o CURL 
        $curl = curl_init();

        $id = "";
        if (empty($_POST["id"])){
            //Se ID é vazio será realizado POST
            $method = "POST";
        }
        else{
            //Se ID NÃO é vazio será realizado PUT
            $method = "PUT";
            $id = $_POST['id'];
        }

        $post_body = json_encode([
            'id' => $id,
            'img' => $img,
            'nome'=> $nome,
            'desc_produto'=> $desc_produto,
            'valor'=> $valor,
            'marca'=> $marca,
            'genero'=> $genero,
            'categoria'=> $categoria,
            'cor'=> $cor,
            'tamanho'=> $tamanho,
            'sub_categoria'=> $subcategoria
        ]);

        // echo "<pre>";
        // print_r(json_decode($post_body));
        // echo "</pre>";

        // echo $method;

        // exit;
        //Configurações do CURL
        curl_setopt_array($curl, [
            CURLOPT_URL => $end_point,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $post_body,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER=> array(
                'Authorization:' . $token
              )
        ]);

        //ENVIO do comando CURL e armazenamento da resposta
        $response = curl_exec($curl);

        //Conversão do JSON para ARRAY
        $dado = json_decode($response, TRUE);

        //Tetar o retorno da API
        if ($dado["status"] == 'fail'){
            $msg = $dado["Error"];
            $status = 'fail';
            header("location: index.php?msg=$msg&status=$status");
            exit;
        }

        //tudo OK - inseriu informação com sucesso
        $msg = "Registro inserido com sucesso";
        $status = 'success';
        header("location: index.php?msg=$msg&status=$status");
        exit;

    } else{
        $msg = "Padrão errado do protocolo de comunicação. Informe o Suporte!";
        $status = 'fail';
        header("location: index.php?msg=$msg&status=$status");
        exit;
    }
?>