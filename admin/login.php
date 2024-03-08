<?php
  include("../assets/includes/validacao.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SenacTAU | Log In</title>

  <?php include("../assets/includes/head.php"); ?>
</head>
<body class="hold-transition">
<div class="wrapper login-page" aria-hidden="true">
<div class="login-box">
  <div class="login-logo">
    <a href="<?php echo $path."/".$home_interno?>"><b>Senac</b>TAU</a>
  </div>

  <!-- /.login-logo -->

  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Faça seu login para iniciar a Sessão</p>

      <form action="valida_login.php" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="row">

          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Lembrar-se de mim
              </label>
            </div>
          </div>

          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Logar</button>
          </div>
          <!-- /.col -->

        </div>
      </form>

      <div class="social-auth-links text-center mb-3">
        <p>- OU -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Logar entrando o Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Logar entrando o Google+
        </a>
      </div>

      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="recover/forgot-password.php">Esqueci minha senha</a>
      </p>

      <p class="mb-0">
        <a href="register.html" class="text-center">Registrar um novo membro</a>
      </p>
    </div>
    <!-- /.login-card-body -->

  </div>
</div>
</div>
<!-- /.login-box -->

<?php include("../assets/includes/scripts.php"); ?>

</body>
</html>
