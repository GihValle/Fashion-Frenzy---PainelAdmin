<?php
    include("../valida_sessao.php");

    if (!empty($_POST)){
        $cor = $_POST["cor"];

        if(empty($cor)){
            $msg = "Campo Cor é obrigatório";
            $status = 'fail';
            header("location: form.php?msg=$msg&status=$status");
            exit;
        }

        // endpoint da API
        $end_point = "http://localhost/api_back/produtos/cor/";

        // Inicializa o CURL
        $curl = curl_init();

        $id = "";
        if (empty($_POST["id"])){
            // se ID é vazio será realizado POST
            $method = "POST";
        }else{
            // se ID NÂO é vazio será realizado PUT
            $method = "PUT";
            $id = $_POST['id'];
        }

        $post_body = json_encode([
            'id' => $id,
            'cor' => $cor,
        ]);

        // configurações do CURL
        curl_setopt_array($curl,[            
            CURLOPT_URL => $end_point,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $post_body,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER=> array(
                'Authorization:' . $token
            ),
            CURLOPT_SSL_VERIFYPEER => false,
        ]);

        // envio do comando CURL e armazenamento da resposta
        $response = curl_exec($curl);

        // conersão do JSON para ARRAY
        $dado = json_decode($response, TRUE);

        // testar Retorno da API
        if ($dado["status"]=='fail'){
            $msg = "Erro ao inserir o registro";
            $status = 'fail';
            header("location: form.php?msg=$msg&status=$status");
            exit;
        }

        // tudo OK - inserio informação com sucesso
        $msg = "Registro inserido com sucesso";
        $status = 'success';
        header("location: index.php?msg=$msg&status=$status");
        exit;

    }else{
        $msg = "Padrão errado do protocolo de comuniação. Informe o Suporte!";
        $status = 'fail';
        header("location: index.php?msg=$msg&status=$status");
        exit;
    }


?>