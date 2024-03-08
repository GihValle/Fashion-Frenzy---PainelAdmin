<?php
  include("../../assets/includes/validacao.php");
  include("../valida_sessao.php");

  $id = "";
  $valor_total = "";
  $cod_rastrea = "";
  $tipo_pagamento = "";
  $cod_promocao = "";

  $end_point = "http://localhost/api_back/clientes/";
  $curl = curl_init();

    //Configurações do CURL
    curl_setopt_array($curl, [
        CURLOPT_URL => $end_point,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTPHEADER=> array(
          'Authorization:' . $token
        )
    ]);

    //ENVIO do comando CURL e armazenamento da resposta
    $response = curl_exec($curl);

    //Conversão do JSON para ARRAY
    $dado = json_decode($response, TRUE); //TRUE para um array associativo

    $arrClientes = $dado['clientes'];
  
  if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = $_GET['id'];

    //preparação da consulta no back-end
    $end_point = "http://localhost/api_back/unidades/?id=$id";

    //INICIALIZA o CURL 
    $curl = curl_init();

    //Configurações do CURL
    curl_setopt_array($curl, [
        CURLOPT_URL => $end_point,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTPHEADER=> array(
          'ACCESSTOKEN:'.$token,
          'Authorization:' . $token
        )
    ]);

    //ENVIO do comando CURL e armazenamento da resposta
    $response = curl_exec($curl);

    //Conversão do JSON para ARRAY
    $dado = json_decode($response, TRUE); //TRUE para um array associativo

    $arrPedidos = $dado['pedidos'];

    // echo "<pre>";
    // print_r($dado["unidades"]);
    // echo "</pre>";
    // exit;
    // echo $dado["unidades"]['unidade'];
    

    if($dado['status']=='success'){
      $valor_total = $arrPedidos["valor_total"];
      $cod_rastrea = $arrPedidos["cod_rastrea"];
      $tipo_pagamento = $arrPedidos["tipo_pagamento"];
      $cod_promocao = $arrPedidos["cod_promocao"];
    }
    else{
      $status = "fail";
      $msg = $dados["Error"];
      $registros = [];
    };
  
  }else 
  // }else {
  //   header("location: index.php");
  // }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pedidos</title>

  <?php include("../../assets/includes/head.php"); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="../../vendor/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo $path."/".$home_interno?>" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <?php include("../../assets/includes/right_menu.php"); ?>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include("../../assets/includes/menu.php"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pedidos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Inserir Pedido</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Pedidos</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="salvar.php" method="post">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="id">ID</label>
                      <input type="text" id="id" name="id" value="<?php echo $id!="" ? $id : "" ?>" class="form-control" placeholder="ID" readonly>
                    </div>

                    <div class="form-group">
                      <label for="id">Valor Total</label>
                      <input type="text" id="valor_total" name="valor_total" value="<?php echo $id!="" ? $valor_total : ""?>" class="form-control" placeholder="Valor Total">
                    </div>

                    <div class="form-group">
                      <label for="id">Código de Rastreamento</label>
                      <input type="text" id="cod_rastrea" name="cod_rastrea" value="<?php echo $id!="" ? $cod_rastrea : ""?>" class="form-control" placeholder="Cód Rastreamento">
                    </div>
                    <div class="form-group">

                      <label for="id">Tipo de Pagamento</label>
                      <!-- <input type="text" id="unidade" name="unidade" value="<?php echo $tipo_pagamento?>" class="form-control" placeholder="Unidade"> -->
                      <select id="tipo_pagamento" name="tipo_pagamento" value="<?php echo $id!="" ? $tipo_pagamento : ""?>" class="form-control">
                        <option value="pix">Pix</option>
                        <option value="crédito">Crédito</option>
                        <option value="débito">Débito</option>
                        <option value="carnê">Carnê</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="id">Código de Promoção</label>
                      <input type="text" id="cod_promocao" name="cod_promocao" value="<?php echo $id!="" ? $cod_promocao : ""?>" class="form-control" placeholder="Cód Promoção">
                    </div>

                    <div class="form-group">
                      <label for="cliente">Cliente</label>
                      <select class="form-control select2bs4" style="width: 100%;" id="cliente" name="cliente">

                      <?php foreach($arrClientes as $cliente){ ?>
                        <option value="<?php echo $cliente["pk_cliente"]?>"><?php echo $cliente["nome"] ?></option>
                        <?php } ?>
                      </select>

                    </div>

                  </div>

                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="index.php" class="btn btn-warning">Cancelar</a>
                  </div>

                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<?php include("../../assets/includes/scripts.php"); ?>

</body>
</html>
