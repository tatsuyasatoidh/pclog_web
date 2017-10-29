<div class="row" id="1hourView">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>1時間別作業量</h3>
            </div>
            <div class="panel-body">
                <canvas id="canvas" style="height:20px"></canvas>
            </div>
        </div>
    </div>
</div>
<?php if($Graph->hourhMin($_POST)):?>
    <script>
    var $fifteenthjsondata ='<?= json_encode($Graph->getResult());?>';
    var $fifteenthdata =JSON.parse($fifteenthjsondata);
    var $workdata = $fifteenthdata["work"];
    var $timedata = $fifteenthdata["time"];
    var color = Chart.helpers.color;
    var horizontalBarChartData = {
        labels: $timedata,
        datasets: [{
            label: '作業量',
            backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
            borderColor: window.chartColors.red,
            borderWidth: 1,
            data: $workdata
        }, ],
        title: {
            display: true,
            text: '1時間別作業量'
        },
    };
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myHorizontalBar = new Chart(ctx, {
                type: 'bar',
                data: horizontalBarChartData,
                options: {
                    elements: {
                        rectangle: {
                            borderWidth: 2,
                        }
                    },
                    responsive: true,
                    legend: {
                        position: 'right',
                    },
                    height: 60,
                }
            });
    </script>
<?php else:?>
<script>
    $("#1hourView").children().remove();
    $("#1hourView").append('<div class="col-lg-12"><div class="panel panel-primary"><div class="panel-heading"><h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>1時間別作業量</h3></div><div class="panel-body">該当のデータはありません</div></div>');
</script>

<?php endif;?>
<script>
/* 検索日の総作業量 */
var $total_work = <?= $Graph->getTotalWork();?>;
$("#total_work").text("<?= $Graph->getTotalWork();?>");
</script>    
   