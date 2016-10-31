<?php
/**
 * @author zhenjun_xu <412530435@qq.com>
 * Date: 2015/4/27 0027
 * Time: 18:35
 */
$prices = array();
$date = array();
/** @var GoodsPrice $v */
foreach($data as $v){
    $prices[] = $v->price;
    $date[] = date('Y-m-d',$v->create_time);
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <script src="<?php echo DOMAIN ?>/js/Chart.min.js"></script>
</head>

<body>
<?php if(!empty($date)): ?>
    <canvas id="myChart" width="800" height="400"></canvas>
    <script>
        var ctx = document.getElementById("myChart").getContext("2d");
        var data = {
            labels: <?php echo json_encode($date); ?>,
            datasets: [
                {
                    label: "My Second dataset",
                    fillColor: "rgba(151,187,205,0.2)",
                    strokeColor: "rgba(151,187,205,1)",
                    pointColor: "rgba(151,187,205,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(151,187,205,1)",
                    data: <?php echo json_encode($prices); ?>
                }
            ]
        };
        var myNewChart = new Chart(ctx).Line(data);

    </script>
<?php else: ?>
    暂无数据
<?php endif; ?>
</body>
</html>