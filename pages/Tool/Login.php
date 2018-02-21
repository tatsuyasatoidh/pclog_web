<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>LaborManageTool| ログイン画面</title>
        <?php include_once 'parts/head.php'; ?>
    </head>
    <body class="hold-transition skin-black passwordchange-page">
        <div class="wrapper" style="background-color:initial">
            <?php include_once 'parts/header.php'; ?>
            <div class="box  center small-form-box">
                    <div class="form-box-body">
                        <p class="box-msg">ログイン</p>
                        <form action="LaborList.php" method="post">
                            <div class="form-group has-feedback">
                                <input type="text" class="form-control" placeholder="ユーザーID">
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="password" class="form-control" placeholder="パスワード">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>
                            <div class="row">
                                <button type="submit" class="btn btn-info pull-right">ログイン</button>
                            </div>
                        </form>
                    </div>
            </div>
            <!-- /.passwordchange-box -->
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
        <style>
            footer {
                position: absolute;
            }
        </style>
        <?php include_once '../parts/footer.php'; ?>
        </html>
