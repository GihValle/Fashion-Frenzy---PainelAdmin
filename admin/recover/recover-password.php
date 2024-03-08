<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SenacTAU | Log In</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../vendor/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../../vendor/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../vendor/dist/css/adminlte.min.css">
  </head>

  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="/admin/login.php"><b>Senac</b>TAU</a>
      </div>

      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Você está apenas um passo da sua nova senha, recupere sua senha agora.</p>

          <form action="change-password.php" method="post">

            <div class="input-group mb-3">
              <input type="text" name="email" class="form-control" placeholder="Email">
              <div class="input-group-append">
                <div class="input-group-text">
                  <i class="fas fa-at"></i>
                </div>
              </div>
            </div>

            <div class="input-group mb-3">
              <input type="text" name="codigo" class="form-control" placeholder="Código">
              <div class="input-group-append">
                <div class="input-group-text">
                  <i class="fas fa-user-secret"></i>
                </div>
              </div>
            </div>

            <div class="input-group mb-3">
              <input type="password" name="senha" class="form-control" placeholder="Senha">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>

            <div class="input-group mb-3">
              <input type="password" name="confirmar_senha" class="form-control" placeholder="Confirmar Senha">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">Mudar senha</button>
              </div>
              <!-- /.col -->
            </div>

          </form>

          <p class="mt-3 mb-1">
            <a href="/admin/login.php">Login</a>
          </p>
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="../../vendor/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../vendor/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../vendor/dist/js/adminlte.min.js"></script>
  </body>
</html>
