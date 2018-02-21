<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>LaborManageTool| 労務一覧画面</title>
        <?php include_once 'parts/head.php';?>
    </head>
    <body class="hold-transition skin-black sidebar-mini">
        <div class="wrapper">
            <?php include_once 'parts/ToolHeader.php';?>
            <?php include_once 'parts/SideMenu.php';?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-lg-6">
                                <div class="box ">
                                    <div class="box-body">
                                        <p class="box-msg">パスワードの変更</p>
                                        <form action="#" method="post">
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
                                            <div class="form-group has-feedback">
                                                <button type="submit" class="btn btn-default">キャンセル</button>
                                                <button type="submit" class="btn btn-info pull-right">変更</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.form-box -->
                                </div>
                        </div>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <?php include_once '../parts/footer.php'; ?>
        </div>
        <?php include_once 'parts/importJs.php'; ?>
        <script>
            $(function () {
                $('#example1').DataTable()
                $('#example2').DataTable({
                    'paging'      : true,
                    'lengthChange': false,
                    'searching'   : false,
                    'ordering'    : true,
                    'info'        : true,
                    'autoWidth'   : false
                })
            })
        </script>
    </body>
</html>
