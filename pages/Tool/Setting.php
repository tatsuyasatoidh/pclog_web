<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>LaborManageTool| 設定画面</title>
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
                    <form action="#" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box ">
                                <div class="box-header with-border">
                                    <h3 class="box-title">勤怠管理設定</h3>
                                </div>
                                <div class="box-body">
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <label>勤怠締め日</label>：
                                            <div class="form-group has-feedback  pull-right">
                                                <input type="text" class="form-contro"><b>日</b>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <label>勤務最低作業数</label>：
                                            <div class="form-group has-feedback  pull-right">
                                                <input type="text" placeholder="900" class="form-contro"><b>回</b>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box ">
                                <div class="box-header with-border">
                                    <h3 class="box-title">労務管理者承認の有無</h3>
                                </div>
                                <div class="box-body">
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <label>労務管理者承認の設定</label>：
                                            <label>
                                                <input type="radio" name="r3" class="flat-red" checked>有
                                            </label>
                                            <label>
                                                <input type="radio" name="r3" class="flat-red">無
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box ">
                                <div class="box-header with-border">
                                    <h3 class="box-title">一覧画面設定</h3>
                                </div>
                                <div class="box-body">
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <label>
                                                <input type="checkbox" name="r3" class="flat-red" checked>　退職者の勤怠も表示する
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="box">
                            <!-- /.box-header -->
                            <div class="box-body">
                                <button type="submit" class="btn btn-info pull-right">変更を保存する</button>
                            </div>
                        </div>
                    </div>
                    </form>
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
