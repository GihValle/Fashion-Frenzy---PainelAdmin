<?php
    include("../valida_sessao.php");
    if(!empty($_POST)){
        $cod_rastrea = $_POST["cod_rastrea"];
        $tipo_pagamento = $_POST["tipo_pagamento"];
        $cod_promocao = $_POST["cod_promocao"];
        $valor_total = $_POST["valor_total"];
        $cliente = $_POST["cliente"];

        if(empty($cod_rastrea)){
            $msg = "Campo Rastreamento é obrigatório";
            $status = 'fail';
            header("location: form.php?msg=$msg&status=$status");
            exit;
        }

        if(empty($tipo_pagamento)){
            $msg = "Campo Pagamento é obrigatório";
            $status = 'fail';
            header("location: form.php?msg=$msg&status=$status");
            exit;
        }

        if(empty($valor_total)){
            $msg = "Campo Valor é obrigatório";
            $status = 'fail';
            header("location: form.php?msg=$msg&status=$status");
            exit;
        }

        if(empty($cliente)){
            $msg = "Campo Cliente é obrigatório";
            $status = 'fail';
            header("location: form.php?msg=$msg&status=$status");
            exit;
        }

        //End-point da API
        $end_point = "http://localhost/api_back/unidades/";

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
            'cod_rastrea'=> $cod_rastrea,
            'tipo_pagamento'=> $tipo_pagamento,
            'cod_promocao'=> $cod_promocao,
            'valor_total'=> $valor_total,
            'cliente' => $cliente

        ]);

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