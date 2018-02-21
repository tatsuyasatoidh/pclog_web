
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>LaborManageTool| 退職者管理画面</title>
        <?php include_once 'parts/head.php';?>
    </head>
    <body class="hold-transition skin-black sidebar-mini">
        <div class="wrapper">
            <?php include_once 'parts/ToolHeader.php';?>
            <?php include_once 'parts/SideMenu.php';?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <section class="content">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="box ">
                                <div class="box-header with-border">
                                    <h3 class="box-title">従業員検索</h3>
                                </div>
                                <div class="box-body">
                                    <form action="#" method="post">
                                        <div class="form-group has-feedback">
                                            <input type="password" class="form-control" placeholder="従業員検索">
                                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <button type="submit" class="btn btn-info pull-right">検索</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="box ">
                                <div class="box-header with-border">
                                    <h3 class="box-title">検索結果</h3>
                                </div>
                                <div class="box-body">
                                    <div class="box-body">
                                        <table id="retireeTable" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>氏名</th>
                                                    <th>ステータス</th>
                                                    <th>従業員情報</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>仕事　辞太郎</td>
                                                    <td>退職者</td>
                                                    <td>従業員情報</td>
                                                </tr>
                                                <tr>
                                                    <td>仕事　辞太郎</td>
                                                    <td>退職者</td>
                                                    <td>従業員情報</td>
                                                </tr>
                                                <tr>
                                                    <td>仕事　辞太郎</td>
                                                    <td>退職者</td>
                                                    <td>従業員情報</td>
                                                </tr>
                                                <tr>
                                                    <td>仕事　辞太郎</td>
                                                    <td>退職者</td>
                                                    <td>従業員情報</td>
                                                </tr>
                                                <tr>
                                                    <td>仕事　辞太郎</td>
                                                    <td>退職者</td>
                                                    <td>従業員情報</td>
                                                </tr>
                                                <tr>
                                                    <td>仕事　辞太郎</td>
                                                    <td>退職者</td>
                                                    <td>従業員情報</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box ">
                                <div class="box-header with-border">
                                    <h3 class="box-title">従業員情報</h3>
                                </div>
                                <div class="box-body">
                                        <div class="box-body box-profile">
                                            <img class="profile-user-img img-responsive img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture">

                                            <h3 class="profile-username text-center">仕事　辞太郎</h3>

                                            <p class="text-muted text-center">シゴト　ヤメタロウ</p>

                                            <ul class="list-group list-group-unbordered">
                                                <li class="list-group-item">
                                                    <b>所属部門</b> <a class="pull-right">営業部</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>役職</b> <a class="pull-right">部長</a>
                                                </li>
                                            </ul>
                                            <div class="form-group has-feedback">
                                                <button type="submit" class="btn btn-danger pull-right">退職処理</button>
                                            </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- /.content-wrapper -->
            <?php include_once '../parts/footer.php'; ?>
        </div>
        <?php include_once 'parts/importJs.php'; ?>
    </body>
</html>
