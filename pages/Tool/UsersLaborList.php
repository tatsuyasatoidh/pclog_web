<?php
ini_set( 'display_errors', 1 );
$pageType = "UsersLaborList";?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>LaborManageTool| 労務管太郎の労務一覧画面</title>
        <?php include_once 'parts/head.php';?>
        <!--<link rel="stylesheet" href="../../plugins/CheckCalendar/css/CheckCalendar.css">-->
    </head>
    <body class="hold-transition skin-black sidebar-mini">
        <div class="wrapper">
            <?php include_once 'parts/ToolHeader.php';?>
            <?php include_once 'parts/SideMenu.php';?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <section class="content">
                        <div class="row">
                            <div class="col-md-12">
                            <div class="box ">
                                <div class="box-header with-border">
                                    <h3 class="box-title">2018年1月間 労務　管太郎</h3>
                                </div>
                                <div class="box-body">
                                    <div class="chart">
                                        <canvas id="LineChart" style="height:300px"></canvas>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                            </div>
                        </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <!-- /.box-body -->
                                        <table id="list" class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th>作業日</th>
                                                    <th>作業量</th>
                                                    <th>達成率</th>
                                                    <th>ステータス</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>2018/01/01</td>
                                                    <td>2000</td>
                                                    <td>
                                                        <div class="progress-bar progress-bar-green" style="width: 80%; height:10px"></div>
                                                    </td>
                                                    <td>
                                                        <span class="label label-success">successed</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2018/01/02</td>
                                                    <td>1000</td>
                                                    <td>
                                                        <div class="progress-bar progress-bar-yellow" style="width: 50%; height:10px"></div>
                                                    </td>
                                                    <td>
                                                        <span class="label label-warning">unfinished</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2018/01/03</td>
                                                    <td>3400</td>
                                                    <td>
                                                        <div class="progress-bar progress-bar-green" style="width: 90%; height:10px"></div>
                                                    </td>
                                                    <td>
                                                        <span class="label label-success">successed</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                            </div>
                        </div>
                            <!--　勤務カレンダー-->
                           <!-- <div class="col-md-6">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">勤務時間</h3>
                                    </div>
                                <div class="box-body">
                                    <div id="divCal"></div>
                                </div>
                                <div class="box-footer">
                                        <div class="col-lg-6 col-xs-6">
                                                <div class="inner">
                                                    <h5>勤務達成日</h5>
                                                    <p><span class="perfomanced">28</span>/20日</p>
                                                </div>
                                            </div>
                                        <div class="col-lg-6 col-xs-6">
                                                <div class="inner">
                                                    <h5>総勤務時間</h5>
                                                    <p><span class="perfomanced">238</span>時間</p>
                                                </div>
                                            </div>
                                    </div>
                              </div>
                        </div>
                        <div class="col-md-6">
                            <!--<div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">作業量Top 5 </h3>
                                </div>
                                <div class="box-body">
                                        <div class="progress-group">
                                            <span class="progress-text">2018/02/18</span>
                                            <span class="progress-number"><b>10000</b></span>

                                            <div class="progress sm">
                                                <div class="progress-bar progress-bar-aqua" style="width: 100%"></div>
                                            </div>
                                        </div>
                                        <div class="progress-group">
                                            <span class="progress-text">2018/02/21</span>
                                            <span class="progress-number"><b>9010</b></span>

                                            <div class="progress sm">
                                                <div class="progress-bar progress-bar-aqua" style="width: 90%"></div>
                                            </div>
                                        </div>
                                        <div class="progress-group">
                                            <span class="progress-text">2018/02/10</span>
                                            <span class="progress-number"><b>4800</b></span>

                                            <div class="progress sm">
                                                <div class="progress-bar progress-bar-yellow" style="width: 80%"></div>
                                            </div>
                                        </div>
                                       
                                        <div class="progress-group">
                                            <span class="progress-text">2018/02/08</span>
                                            <span class="progress-number"><b>4000</b></span>
                                            <div class="progress sm">
                                                <div class="progress-bar progress-bar-yellow" style="width: 70%"></div>
                                            </div>
                                        </div>
                                    <div class="progress-group">
                                        <span class="progress-text">2018/02/07</span>
                                        <span class="progress-number"><b>3700</b></span>
                                        <div class="progress sm">
                                            <div class="progress-bar progress-bar-yellow" style="width: 60%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-body">
                                    <button type="submit" class="btn btn-info pull-right">勤務を承認する</button>
                                </div>
                            </div>
                        </div>-->
                    </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box">
                                    <div class="box-body">
                                        <button type="submit" class="btn btn-info pull-right">勤務を承認する</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
            </div>
            <!-- /.content-wrapper -->
            <?php include_once '../parts/footer.php'; ?>
        </div>
        <?php include_once 'parts/importJs.php'; ?>
        <script src="sample/mounthData.js"></script>
        <script src="sample/UsersLaborList.js"></script>
        <script src="../../plugins/CheckCalendar/js/CheckCalendar.js"></script>
        <script>
            $(function () {
                $('#list').DataTable({
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
