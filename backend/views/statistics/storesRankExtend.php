 <script type="text/javascript">
            document.domain = '<?php echo SHORT_DOMAIN ?>';
        </script>
    <?php 
	$baseUrl = Yii::app()->baseUrl;
	$cs = Yii::app()->clientScript;
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
        var search = function () {
            var startTime = $('#monthpicker').val();
            var endTime = $('#monthpicker1').val();
            if(startTime == undefined || startTime == ''){
                if(endTime != undefined && endTime != ''){
                    alert('请选择开始日期!');return;
                }
            }else{
                //没有设置结束时间默认为当天
                if(endTime == undefined || endTime == ''){
                    var now = new Date();
                    var year = now.getFullYear();       //年
                    var month = now.getMonth() + 1;     //月
                    var day = now.getDate();            //日
                    endTime = year+'-'+month+'-'+day;
                }
                //判断开始时间与结束时间范围是否大于30天
                var arr=startTime.split("-");    
                var start=new Date(arr[0],arr[1],arr[2]);    
                var starts=start.getTime();   
                var arrs=endTime.split("-");    
                var end=new Date(arrs[0],arrs[1],arrs[2]);    
                var ends=end.getTime();
                if((ends - starts) > 30*86400*1000){
                    alert('日期范围请不要超过30天!');return;
                }
            }
            var myUrl = "<?php echo urldecode(Yii::app()->createUrl('statistics/storesRankExtend', array('startTime' => '"+startTime+"','endTime' => '"+endTime+"'))); ?>"
            location.href = myUrl;
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
        <div class="unit title_onezi">商家销售额占比</div>
    </div>
    
    <?php if (Yii::app()->user->checkAccess('Statistics.RankExport')):?>
    <div class="t-sub">
         <a href="<?php echo Yii::app()->createUrl('statistics/rankExport',array('type'=>1,'startTime'=> isset($_GET['startTime'])?$_GET['startTime']:'','endTime'=>isset($_GET['endTime'])?$_GET['endTime']:''));?>" target="_blank" class="regm-sub">导出excel</a>
    </div>
    <br/><br/>
    <?php endif;?>
    <div class="line tjbox_nr">
        <div class="line tjbox2">
            <div class="line title_time">
                <div class="unit title_timeimg">
                    <img src="<?php echo Yii::app()->baseUrl?>/images/icon03.jpg" width="15" height="19" alt="time" /></div>
                <div class="unit title_timezi">
                    选择日期查看详细数据信息</div>
            </div>
            <div class="line tjbox_nr">
                <table cellpadding="0" cellspacing="0" class="searchTable">
                    <tr>
                        <th>
                            选择日期范围：<input type="text" class="text-input-bj  least" id="monthpicker" value="<?php echo isset($_GET['startTime'])?$_GET['startTime']:'';?>" />
                        </th>
                        <th>
                            至 <input type="text" class="text-input-bj  least" id="monthpicker1" value="<?php echo isset($_GET['endTime'])?$_GET['endTime']:'';?>" />
                        </th>
                    </tr>
                </table>
                <input type="button" class="reg-sub" value="搜索" onclick="search()" />
            </div>
        </div>
        <div class="c10"></div>
        <?php if(!empty($dataRes)): ?>
        <div class="line tjbox2">
            <div class="line title_two">
                <div class="unit title_twoimg">
                    <img src="<?php echo Yii::app()->baseUrl?>/images/icon02.jpg" width="18" height="13" alt="icon2" /></div>
                <div class="unit title_twozi">
                    商家销售额排名（总销售额：<?php echo $totalPrice;?>）</div>
                    
            </div>
            <div class="line tjbox_nr">
                <table width="100%" cellpadding="0" cellspacing="0" class="tab-tj">
                    <tbody>
                        <tr class="tab-tj-title">
                            <th>排行</th>
                            <th>商家</th>
                            <th>销售额</th>
                            <th>总销售占比</th>
                            <th></th>
                        </tr>
                        <?php $i=!empty($_GET['page'])?($_GET['page']-1)*$pagesize+1:1;?>
                        <?php foreach ($dataRes as $v):?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo CHtml::link($v['store_name'],DOMAIN."/shop/{$v['store_id']}.html",array('target'=>'_blank'))?></td>
                                <td><?php echo $v['sum_price']?></td>
                                <td><?php echo round(($v['sum_price']/$totalPrice*100),4);  ?>%</td>
                                <td><?php echo CHtml::link('消费者消费占比排行',Yii::app()->createUrl('statistics/storeCustomerRankExtend',array('store_id'=>$v['store_id'])),array("target"=>"_blank"));?></td>
                            </tr>
                            <?php $i++;?>
                            <?php endforeach;?>
                    </tbody>
                </table>
                <div id="pager" style="padding:10px;padding-top:20px;">
                <style>
                	ul.yiiPager .first, ul.yiiPager .last{ display:inline; }
                </style>    
                <?php    
                $this->widget('CLinkPager',array(    
                    'header'=>'',    
                    'firstPageLabel' => '首页',    
                    'lastPageLabel' => '末页',    
                    'prevPageLabel' => '上一页',    
                    'nextPageLabel' => '下一页',    
                    'pages' => $pages,    
                    'maxButtonCount'=>13));
                ?>    
                </div> 
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
</div>
    <script type="text/javascript">
        (function (global, document, $, undefined) {
            $('#monthpicker').datePicker({
                followOffset: [0, 24],
                altFormat: 'yyyy-mm-dd',
                showMode: 0,
                minDate: '2012-08-30',
                maxDate: '2016-01-06'
            });
        })(this, document, jQuery);
        (function (global, document, $, undefined) {
            $('#monthpicker1').datePicker({
                followOffset: [0, 24],
                altFormat: 'yyyy-mm-dd',
                showMode: 0,
                minDate: '2012-08-30',
                maxDate: '2016-01-06'
            });
        })(this, document, jQuery);
    </script>

