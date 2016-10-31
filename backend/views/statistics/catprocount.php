 <script type="text/javascript">
            document.domain = '<?php echo SHORT_DOMAIN ?>';
        </script>
    <?php 
	$baseUrl = Yii::app()->baseUrl;
	$cs = Yii::app()->clientScript;
	$cs->registerScriptFile($baseUrl . "/js/highcharts/highcharts.js");
	$cs->registerScriptFile($baseUrl . "/js/highcharts/HighChartsOption.js");
        $cs->registerScriptFile($baseUrl . "/js/iframeTools.js");
        $cs->registerScriptFile($baseUrl . "/js/jquery.DatePicker.min.js");
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            var bodyWidth = $(".main").width();
            var ws = bodyWidth - 9;
            $(".t-com").width(ws);
            $(window).resize(function () {
                var bodyWidth = $(".main").width();
                var ws = bodyWidth - 9;
                $(".ws").width(ws);
            });
        });
     
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.tab-come ').each(function () {
                $(this).find('tr:even td').addClass('even');
                $(this).find('tr:odd td').addClass('odd');
                $(this).find('tr:even th').addClass('even');
                $(this).find('tr:odd th').addClass('odd');
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.tab-reg ').each(function () {
                $(this).find('tr:even td').css("background", "#eee");
                $(this).find('tr:odd td').css("background", "#fff");
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            var $thi = $('body,html').find("#u_title li");
            $($thi).hover(function () {
                $(this).addClass("cur").siblings().removeClass("cur");
                var $as = $("#con .con_listbox").eq($("#u_title li").index(this));
                $as.show().siblings().hide();
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.tab-reg2').find('.info').hover(function () {
                $(this).find('td').css({ "background": "rgba(255, 184, 0, 0.2)" });
                $(this).next('.user').find('td').css({ "background": "rgba(255, 184, 0, 0.2)" });
            }, function () {
                $(this).find('td').removeAttr("style");
                $(this).next('.user').find('td').removeAttr("style");
            });

            $('.tab-reg2').find('.user').hover(function () {
                $(this).find('td').css({ "background": "rgba(255, 184, 0, 0.2)" });
                $(this).prev().find('td').css({ "background": "rgba(255, 184, 0, 0.2)" });
            }, function () {
                $(this).find('td').removeAttr("style");
                $(this).prev().find('td').removeAttr("style");
            });
        });
    </script>
    

    <script type="text/javascript">
        var search = function (catId, catName) {
            var charProCount;
            var title = "分类：" + catName + "商品分布统计";
            $('#catChildTitle').text(title);
            var optionsProCount = getColumnChartOption("divCartProCount", title);
            var getUrl = "<?php echo Yii::app()->createUrl('statistics/getCatAjax')?>";
            jQuery.getJSON(getUrl, { CatId: catId },
                function (data, state, xhr) {
                   // alert(data);
                   var data = eval(data);
                    var CountData = [];
                    var CategoriesData = [];
                    try {
                        $.each(data, function (i, line) {
                            //alert(line.ProCount);
                            CategoriesData.push(line.CatName);
                            CountData.push(line.ProCount);
                        });
                       
                        optionsProCount.xAxis.categories = CategoriesData;
                        optionsProCount.series.push({ type: "column", name: catName, data: CountData });
                        charProCount = new Highcharts.Chart(optionsProCount);
                    }
                    finally {
                        delete CountData;
                    }
                });
        }; 
    </script>
    <script type="text/javascript">
        var rowChangeColor = function () {
            $('.tab-tj ').each(function () {
                $(this).find('tr:even td').css("background", "#fafafa");
                $(this).find('tr:odd td').css("background", "#fff");
            });
        };

        $(document).ready(function () {
            rowChangeColor();
        });
    </script>


    <div class="main">
        
<div class="line tjbox">
    <div class="line title_one">
        <div class="unit title_oneimg">
            <img src="<?php echo Yii::app()->baseUrl?>/images/icon06.png" width="37" height="51" alt="icon1" /></div>
        <div class="unit title_onezi">商品分类统计</div>
    </div>
    <div class="line tjbox_nr">
        <div class="line tjbox2">
            <div class="line title_two">
                <div class="unit title_twoimg">
                    <img src="<?php echo Yii::app()->baseUrl?>/images/icon02.jpg" width="18" height="13" alt="icon2" /></div>
                <div class="unit title_twozi">
                    商品数量概述</div>
            </div>
            <div class="line tjbox_nr">
                <table width="100%" cellpadding="0" cellspacing="0" class="tab-tj">
                    <thead>
                        <tr class="tab-tj-title">
                            <th>
                                分类
                            </th>
                            <th>
                                分类名
                            </th>
                            <th>
                                商品数量
                            </th>
                            <th>
                                操作
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($catData as $v):?>
                            <tr>
                                <td>
                                    <img src="<?php echo Tool::showImg($v["thumbnail"])?>"  alt="<?php echo $v['name']?>" />
                                </td>
                                <td>
                                    <?php echo $v['name']?>
                                </td>
                                <td class="jf">
                                   <?php echo $v['num']?>
                                </td>
                                <td>
                                    <a href="javascript:search(<?php echo $v['id']?>,'<?php echo $v["name"]?>')">【详情】</a>
                                </td>
                            </tr>
                           <?php endforeach;?> 
                    </tbody>
                </table>
            </div>
        </div>
        <div class="c10"></div>
        <div class="line tjbox2">
            <div class="line title_two">
                <div class="unit title_twoimg">
                    <img src="<?php echo Yii::app()->baseUrl?>/images/icon02.jpg" width="18" height="13" alt="icon2" /></div>
                <div class="unit title_twozi" id="catChildTitle">
                    商品数量统计曲线表</div>
            </div>
            <div class="us-log clearfix" id="divCartProCount" style="min-width: 300px; height: 350px;
                margin: 0 auto;">
            </div>
        </div>
    </div>
</div>


    </div>
    
    <script type="text/javascript">        search(1,'家用电器'); </script>
