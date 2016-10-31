     <script type="text/javascript">
            document.domain = '<?php echo SHORT_DOMAIN ?>';
        </script>
    <link href="http://restest.<?php echo SHORT_DOMAIN ?>/Res/BackOffice/backoffice/style/reg.css" rel="stylesheet" type="text/css" />
    <script src="http://restest.<?php echo SHORT_DOMAIN ?>/Res/global/libs/jquery/jquery-1.5.1.min.js" type="text/javascript"></script>
    <script src="http://restest.<?php echo SHORT_DOMAIN ?>/Res/global/JS/Tools.js" type="text/javascript"></script>
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
    
    <script src="http://restest.<?php echo SHORT_DOMAIN ?>/Res/global/libs/artdialog/jquery.artDialog.source.js?skin=default" type="text/javascript"></script>
    <script src="http://restest.<?php echo SHORT_DOMAIN ?>/Res/global/libs/artdialog/iframeTools.source.js" type="text/javascript"></script>
    <script type="text/javascript">
        var btnCancelClick = function () {
            art.dialog.close();
        };
    </script>

    <div class="main">
        
<div class="head-title">
    <div class="t-left">
    </div>
    <div class="t-com ws">
        <div class="t-sub">
        <input type="button" value="关闭" id="btnCancel" onclick="btnCancelClick()" class="reg-sub" />
        </div>
        <span class="ico_where">查看<?php echo $text;?>订单记录 - <?php echo $dateTime?></span>
    </div>
    <div class="t-right">
    </div>
</div>
<div class="com-box">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-reg">
        <tr class="tab-reg-title">
            <th style="width: 100px">
                订单编号
            </th>
            <th style="width: 150px">
                买家会员编号
            </th>
            <th style="width: 100px">
                商铺名称
            </th>
            <th style="width: 150px">
                总价格
            </th>
            <th>
                总供货价
            </th>
            <th style="width: 100px">
                运费
            </th>
        </tr>
        <tbody id="dMemlist">
            <?php foreach($resData as $v):?>
            <tr>
                <td><?php echo $v['code']?></td>
                <td><?php echo $v['gai_number']?></td>
                <td><?php echo $v['name']?></td>
                <td><?php echo $v['total_price']?></td>
                <td><?php echo $v['gai_price']?></td>
                <td><?php echo $v['freight']?></td>
            </tr>
            <?php endforeach;?>
            <tr>
                <td colspan="6" class="pag" style="text-align: center">
                     <?php    
                        $this->widget('CLinkPager',array(    
                            'header'=>'',    
                            'firstPageLabel' => '首页',    
                            'lastPageLabel' => '末页',    
                            'prevPageLabel' => '上一页',    
                            'nextPageLabel' => '下一页',    
                            'pages' => $pages,    
                            'maxButtonCount'=>13    
                            )    
                        );    
                        ?>  
                </td>
            </tr>
        </tbody>
    </table>
</div>
    </div>
    
<style>
    
    .com-box{padding: 0}
</style>
