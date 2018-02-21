<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Registration Page</title>
  <!-- Tell the browser to be responsive to screen width -->
    <?php include_once 'parts/head.php'; ?>
</head>
<body class="hold-transition skin-black sidebar-mini register-page">
<div class="wrapper" style="background-color:initial">
<?php include_once 'parts/header.php'; ?>
<div class="row">
<div class="register-box col-lg-offset-6">
  <div class="register-logo">
    <a href="#"><b>L</b>abor<b>M</b>anage<b>T</b>ool</a>
  </div>

  <div class="register-box-body">
    <p class="register-box-msg">メールアドレスを登録</p>

    <form action="PasswordChange.php" method="post">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4 col-xs-offset-4 center">
          <button type="submit" class="btn btn-primary btn-block btn-flat">登録</button>
        <!-- /.col -->
      </div>
    </form><br>
  </div>
  <a href="#" class="text-center">利用規約</a>
  <!-- /.form-box -->
</div>
</div>
<!-- /.register-box -->

<!-- jQuery 3 -->
<script src="../../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="../../../plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
