<?php
    include("../valida_sessao.php");

    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        $id = $_GET["id"];

        //End-point da API
        $end_point = "http://localhost/api_back/produtos/sub_categoria/?id=$id";

        //INICIALIZA o CURL 
        $curl = curl_init();

        //Configurações do CURL
        curl_setopt_array($curl, [
            CURLOPT_URL => $end_point,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER=> array(
                'Authorization:' . $token
            ),
            CURLOPT_SSL_VERIFYPEER => false,
        ]);

        //ENVIO do comando CURL e armazenamento da resposta
        $response = curl_exec($curl);

        //Conversão do JSON para ARRAY
        $dado = json_decode($response, TRUE);

        //Tetar o retorno da API
        if ($dado["status"] == 'fail'){
            $msg = "Erro ao excluir o registro";
            $status = 'fail';
            header("location: index.php?msg=$msg&status=$status");
            exit;
        }

        //tudo OK - inseriu informação com sucesso
        $msg = "Registro excluído com sucesso";
        $status = 'success';
        header("location: index.php?msg=$msg&status=$status");
        exit;

    } else{
        $msg = "Valor inválido!";
        $status = 'fail';
        header("location: index.php?msg=$msg&status=$status");
        exit;
    }
?>