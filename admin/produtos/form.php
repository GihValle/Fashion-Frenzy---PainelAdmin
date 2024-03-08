<?php
  include("../../assets/includes/validacao.php");
  include("../valida_sessao.php");

  $id = ""; 
  $nome = ""; 
  $desc_produto = ""; 
  $valor = ""; 
  $img = "";

  if (isset($_GET['id']) && !empty($_GET['id'])){
   
    $id = $_GET['id'];
    
    $end_point_produto = "http://localhost/api_back/produtos/?id=$id";
    $ch_produto = curl_init();
    
    curl_setopt_array($ch_produto, [
      CURLOPT_URL => $end_point_produto,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER=> array(
        'Authorization:' . $token
      )
    ]);
    $resultado_produto = curl_exec($ch_produto);

    curl_close($ch_produto);

    $dados_produto = json_decode($resultado_produto, TRUE);

    //     echo"<pre>";
    // var_dump($dados_produto);
    // echo "</pre>";
    // exit;
      
    $produto = $dados_produto['produtos'];
    $nome = $produto['nome'];
    $desc_produto = $produto['desc_produto'];
    $valor = $produto['valor'];
  }

// ----------------------------------------
  $end_point_genero = "http://localhost/api_back/produtos/genero/";
    $ch_genero = curl_init();
    
    curl_setopt_array($ch_genero, [
      CURLOPT_URL => $end_point_genero,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER=> array(
        'Authorization:' . $token
      )
    ]);
    $resultado_genero = curl_exec($ch_genero);

    curl_close($ch_genero);

    $dados_genero = json_decode($resultado_genero, TRUE);

    // echo"<pre>";
    // var_dump($dados_genero);
    // echo "</pre>";
    // exit;    
    $generos = $dados_genero['genero'];
  
// ----------------------------------------
  $end_point_cor = "http://localhost/api_back/produtos/cor/";
  $ch_cor = curl_init();
  
  curl_setopt_array($ch_cor, [
    CURLOPT_URL => $end_point_cor,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER=> array(
      'Authorization:' . $token
    )
  ]);
  $resultado_cor = curl_exec($ch_cor);

  curl_close($ch_cor);

  $dados_cor = json_decode($resultado_cor, TRUE);

  // echo"<pre>";
  // var_dump($dados_genero);
  // echo "</pre>";
  // exit;    
  $cores = $dados_cor['cor'];

// ----------------------------------------
  $end_point_tamanho = "http://localhost/api_back/produtos/tamanho/";
    $ch_tamanho = curl_init();
    
    curl_setopt_array($ch_tamanho, [
      CURLOPT_URL => $end_point_tamanho,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER=> array(
        'Authorization:' . $token
      )
    ]);
    $resultado_tamanho = curl_exec($ch_tamanho);

    curl_close($ch_tamanho);

    $dados_tamanho = json_decode($resultado_tamanho, TRUE);

    // echo"<pre>";
    // var_dump($dados_genero);
    // echo "</pre>";
    // exit;    
    $tamanhos = $dados_tamanho['tamanho'];

// ----------------------------------------
  $end_point_marca = "http://localhost/api_back/produtos/marca/";
    $ch_marca = curl_init();
    
    curl_setopt_array($ch_marca, [
      CURLOPT_URL => $end_point_marca,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER=> array(
        'Authorization:' . $token
      )
    ]);
    $resultado_marca = curl_exec($ch_marca);

    curl_close($ch_marca);

    $dados_marca = json_decode($resultado_marca, TRUE);

    // echo"<pre>";
    // var_dump($dados_marca);
    // echo "</pre>";
    // exit;
    $marcas = $dados_marca['marca'];

// ----------------------------------------
 $end_point_categoria = "http://localhost/api_back/produtos/categoria/";
  $ch_categoria = curl_init();
  
    curl_setopt_array($ch_categoria, [
      CURLOPT_URL => $end_point_categoria,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER=> array(
        'Authorization:' . $token
      )
    ]);
    $resultado_categoria = curl_exec($ch_categoria);

    curl_close($ch_categoria);

    $dados_categoria = json_decode($resultado_categoria, TRUE);

    // echo"<pre>";
    // var_dump($dados_categoria);
    // echo "</pre>";
    // exit;
    $categorias = $dados_categoria['categoria'];

// ----------------------------------------
  $end_point_subcategoria = "http://localhost/api_back/produtos/sub_categoria/";
    $ch_subcategoria = curl_init();
    
    curl_setopt_array($ch_subcategoria, [
      CURLOPT_URL => $end_point_subcategoria,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER=> array(
        'Authorization:' . $token
      )
    ]);
    $resultado_subcategoria = curl_exec($ch_subcategoria);

    curl_close($ch_subcategoria);

    $dados_subcategoria = json_decode($resultado_subcategoria, TRUE);

    // echo"<pre>";
    // var_dump($dados_marca);
    // echo "</pre>";
    // exit;
    $subcategorias = $dados_subcategoria['sub_categoria'];

// ----------------------------------------

  if(!empty($produto["img"])){
    $img = $comp."../".$produto["img"];
  }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Produtos</title>

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
            <h1>Produtos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Inserir Produtos</li>
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
                <h3 class="card-title">Produtos</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="salvar.php" method="post" enctype="multipart/form-data">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="id">ID</label>
                      <input type="text" id="id" name="id" value="<?php echo $id!="" ? $id : "" ?>" class="form-control" placeholder="ID" readonly>
                    </div>

                    <div class="form-group">
                      
                      <?php if ($img) { ?>
                        <div style="width: 200px; height: 200px;">
                          <img src="<?php echo $img; ?>" alt="" class="img-fluid">
                        </div>
                      <?php } ?>
                      
                      <label for="imagem">Imagens</label>
                      <input type="file" id="imagem" name="imagem" value="" class="form-control" placeholder="Imagem do Produto">
                    </div>

                    <div class="form-group">
                      <label for="id">Nome</label>
                      <input type="text" id="nome" name="nome" value="<?php echo $id!="" ? $nome : ""?>" class="form-control" placeholder="Nome">
                    </div>

                    <div class="form-group">
                      <label for="id">Descrição</label>
                      <input type="text" id="desc_produto" name="desc_produto" value="<?php echo $id!="" ? $desc_produto : ""?>" class="form-control" placeholder="Descrição">
                    </div>

                    <div class="form-group">
                      <label for="id">Valor</label>
                      <input type="text" id="valor" name="valor" value="<?php echo $id!="" ? $valor : ""?>" class="form-control" placeholder="Valor">
                    </div>

                    <div class="form-group">
                      <label for="id">Marca</label>
                      <select id="marca" name="marca" value="<?php echo $id!="" ? $marca : ""?>" class="form-control">
                      <?php 
                       foreach($marcas as $marca){
                        if($id==""){
                      ?>
                          <option value="<?php echo $marca["pk_marca"]?>"><?php echo $marca["marca"]?></option>

                          <?php } else {?>
                            <option value="<?php echo $marca["pk_marca"]?>"
                            <?php echo $marca["pk_marca"]==$produto["fk_marca"] ? "selected" : ""; ?>>
                            <?php echo $marca["marca"]?></option>
                          <?php } ?>

                      <?php } ?>
                      </select>
                    </div>

                    <div class="form-group">

                      <label for="id">Genêro</label>
                      <select id="genero" name="genero" value="<?php echo $id!="" ? $genero : ""?>" class="form-control">
                      <?php 
                        foreach($generos as $genero){
                          if($id==""){
                      ?>
                          <option value="<?php echo $genero["pk_genero"]?>"><?php echo $genero["genero"] ?></option>

                          <?php } else { ?>
                            <option value="<?php echo $genero["pk_genero"]?>"
                            <?php echo $genero["pk_genero"]==$produto["fk_genero"] ? "selected" : "";?>> 
                            <?php echo $genero["genero"] ?></option>
                          <?php } ?>

                      <?php } ?>  
                      </select>
                    </div>

                    <div class="form-group">

                      <label for="id">Cor</label>
                      <select id="cor" name="cor" value="<?php echo $id!="" ? $cor : ""?>" class="form-control">
                      <?php 
                        foreach($cores as $cor){
                          if($id==""){
                      ?>
                          <option value="<?php echo $cor["pk_cor"]?>"><?php echo $cor["cor"] ?></option>

                          <?php } else { ?>
                            <option value="<?php echo $cor["pk_cor"]?>"
                            <?php echo $cor["pk_cor"]==$produto["fk_cor"] ? "selected" : "";?>> 
                            <?php echo $cor["cor"] ?></option>
                          <?php } ?>

                      <?php } ?>  
                      </select>
                    </div>       

                    <div class="form-group">

                      <label for="id">Tamanho</label>
                      <select id="tamanho" name="tamanho" value="<?php echo $id!="" ? $tamanho : ""?>" class="form-control">
                      <?php 
                        foreach($tamanhos as $tamanho){
                          if($id==""){
                      ?>
                          <option value="<?php echo $tamanho["pk_tamanho"]?>"><?php echo $tamanho["tamanho"] ?></option>

                          <?php } else { ?>
                            <option value="<?php echo $tamanho["pk_tamanho"]?>"
                            <?php echo $tamanho["pk_tamanho"]==$produto["fk_tamanho"] ? "selected" : "";?>> 
                            <?php echo $tamanho["tamanho"] ?></option>
                          <?php } ?>

                      <?php } ?>  
                      </select>
                    </div>    

                    <div class="form-group">
                      <label for="id">Categoria</label>
                      <select id="categoria" name="categoria" value="<?php echo $id!="" ? $categoria : ""?>" class="form-control">
                      <?php
                       foreach($categorias as $categoria){
                        if($id==""){
                      ?>
                        <option value="<?php echo $categoria["pk_categoria"]?>"><?php echo $categoria["categoria"] ?></option>

                        <?php } else { ?>
                          <option value="<?php echo $categoria["pk_categoria"]?>" 
                          <?php echo $categoria["pk_categoria"]==$produto["fk_categoria"] ? "selected" : ""; ?>>
                          <?php echo $categoria["categoria"] ?></option>
                        <?php }?>

                     <?php } ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="id">Subcategoria</label>
                      <select id="sub_categoria" name="sub_categoria" value="<?php echo $id!="" ? $subcategoria : ""?>" class="form-control">
                      <?php 
                       foreach($subcategorias as $subcategoria){
                        if($id==""){
                      ?>
                          <option value="<?php echo $subcategoria["pk_subcategoria"]?>"><?php echo $subcategoria["sub_categoria"] ?></option>

                          <?php } else { ?>
                            <option value="<?php echo $subcategoria["pk_subcategoria"] ?>"
                            <?php echo $subcategoria["pk_subcategoria"]==$produto["fk_subcategoria"] ? "selected" : "";?>>
                            <?php echo $subcategoria["sub_categoria"] ?></option>
                          <?php } ?>

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
