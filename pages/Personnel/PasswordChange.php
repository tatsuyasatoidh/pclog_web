<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>LaboranageTeool| パスワード変更画面</title>
        <!-- Tell the browser to be responsive to screen width -->
        <?php include_once 'parts/head.php'; ?>
    </head>
    <body class="hold-transition skin-black passwordchange-page">
        <div class="wrapper" style="background-color:initial">
            <?php include_once 'parts/header.php'; ?>
            <div class="Info-box center small-form-box">
                <div class="box  form-box">
                    <div class="box ">
                        <div class="box-body">
                            <p class="box-msg">新しいパスワードの登録</p>
                            <form action="RegisterCompanyInfo.php" method="post">
                                <div class="form-group has-feedback">
                                    <input type="password" class="form-control" placeholder="現在のパスワード">
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                </div>
                                <div class="form-group has-feedback">
                                    <input type="password" class="form-control" placeholder="新しいパスワード">
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                </div>
                                <div class="form-group has-feedback">
                                    <input type="password" class="form-control" placeholder="新しいパスワード（確認）">
                                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                                </div>
                                <div class="row">
                                    <button type="submit" class="btn btn-default">キャンセル</button>
                                    <button type="submit" class="btn btn-info pull-right">登録</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.form-box -->
                    </div>
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
        </html>
