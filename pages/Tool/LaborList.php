<?php
ini_set( 'display_errors', 1 );
$pageType = "laborList";?>
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
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">一覧</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <table id="LaborList" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>作業日</th>
                                                <th>作業者</th>
                                                <th>ステータス</th>
                                                <th>作業量</th>
                                                <th>ログファイル</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>2018/01/10</td>
                                                <td><a href="UsersLaborList.php">労務　管太郎</a></td>
                                                
                                                <td><span class="label label-success">success</span></td>
                                                <td>90000</td>
                                                <td>
                                                    <button type="btn" class="btn btn-info">CSV</button>
                                                    <button type="btn" class="btn btn-success">PCF</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2018/01/09</td>
                                                <td><a href="UsersLaborList.php">労務　管太郎</a></td>
                                                
                                                <td><span class="label label-default">unfinished</span></td>
                                                <td>1000</td>
                                                <td> 
                                                    <button type="btn" class="btn btn-info">CSV</button>
                                                    <button type="btn" class="btn btn-success">PCF</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>01/09</h3>
                                    <p>2018/01/09</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                               
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>労務　管太郎</h3>
                                    <p>作業者</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-user"></i>
                                </div>

                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>勤務</h3>
                                    <p>ステータス</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-briefcase"></i>
                                </div>
                               
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>2,000</h3>
                                    <p>作業量</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-signal"></i>
                                </div>
                               
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <div class="box box-default">
                                <div class="box-header with-border">
                                    <h3 class="box-title">円グラフ 午前（0-12）</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="chart-responsive">
                                                <canvas id="pieChart" height="150"></canvas>
                                            </div>
                                            <!-- ./chart-responsive -->
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    
                    <div class="col-sm-6 col-xs-12">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">円グラフ 午前（13-24）</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="chart-responsive">
                                            <canvas id="pieChartPm" height="150"></canvas>
                                        </div>
                                        <!-- ./chart-responsive -->
                                    </div>
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                    </div>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <?php include_once '../parts/footer.php'; ?>
        </div>
        <!-- ./wrapper -->

        <!-- jQuery 3 -->
        <script src="../../bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- FastClick -->
        <script src="../../bower_components/fastclick/lib/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="../../dist/js/adminlte.min.js"></script>
        <!-- Sparkline -->
        <script src="../../bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
        <!-- jvectormap  -->
        <script src="../../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="../../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <!-- SlimScroll -->
        <script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <!-- ChartJS -->
        <script src="../../bower_components/chart.js/Chart.js"></script>
        <!-- DataTables -->
        <script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="sample/LaborList.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="../../dist/js/demo.js"></script>
        <script>
            $(function () {
                $('#LaborList').DataTable({
                    'paging'      : true,
                    'lengthChange': false,
                    'searching'   : false,
                    'ordering'    : true,
                    'info'        : true,
                    'autoWidth'   : false,
                })
            })
        </script>
    </body>
</html>
