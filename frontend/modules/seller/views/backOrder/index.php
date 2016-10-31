<?php
$exchangeType = $this->getParam('exchange_type',0);
    $orderCode = $this->getParam('order_code',0);
    $applyTime = $this->getParam('apply_time',0);
    $timeType = $this->getParam('time_type',0);
    $exchangeStatus = $this->getParam('exchange_status',-1);

$title = Yii::t('sellerGoods', '退换货列表');
$this->pageTitle = $title.'-'.$this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('sellerGoods', '退换货管理 '),
    $title,
);
?>
<div class="toolbar">
                <b><?php echo Yii::t('sellerOrder','退换货管理') ?></b>
                <span><?php echo Yii::t('sellerOrder','查询处理所有退货退款的订单') ?></span>
</div>
<div class="seachToolbar">
                <table width="95%" cellspacing="0" cellpadding="0" border="0" class="sellerT5">
                    <tbody>
                    <tr>
                        <form method="get" action="<?php echo Yii::app()->createAbsoluteUrl('/seller/backOrder/index'); ?>">
                        <th width="2.6%"><?php echo Yii::t('sellerOrder','订单编号：') ?></th>
                            <td width="1%"><input type="text" style="width:225px;" name="order_code" class="inputtxt1"></td>
                            <td width="16%"><input type="submit" class="sellerBtn06" value="搜索" /></td>
                        </form>
                    </tr>

                    </tbody>
                </table>
</div>
<div class="gateAssistant mt15 clearfix">
    <b class="black"><?php echo Yii::t('sellerOrder','盖网小助手：') ?></b>
    <a href="<?php echo Yii::app()->createAbsoluteUrl('/seller/backOrder/index',array('exchange_type'=>1)); ?>" class=" <?php echo $exchangeType ==1 ?  'sellerBtn05' : 'sellerBtn02'; ?> "><span>退货</span></a>
    <a href="<?php echo Yii::app()->createAbsoluteUrl('/seller/backOrder/index',array('exchange_type'=>2)); ?>" class="<?php echo $exchangeType ==2 ?  'sellerBtn05' : 'sellerBtn02'; ?>"><span>退款不退货</span></a>

    <b class="black"><?php echo Yii::t('sellerOrder','退换货单状态：') ?></b>
    <select class="inputtxt1" onchange="self.location.href=options[selectedIndex].value">
        <option value="<?php echo Yii::app()->createAbsoluteUrl('/seller/backOrder/index',array('exchange_type'=>$exchangeType,'time_type'=>$timeType)) ?>"><?php echo Yii::t('sellerOrder','全部状态：') ?></option>
        <?php foreach(Order::exchangeStatus() as $key => $value){
            ?>
                <option <?php if($exchangeStatus == $key) echo "selected='selected'"; ?> value="<?php echo Yii::app()->createAbsoluteUrl('/seller/backOrder/index',array('exchange_type'=>$exchangeType,'exchange_status'=>$key,'time_type'=>$timeType)) ?>"><?php echo Yii::t('sellerOrder',$value) ?></option>
        <?php
        } ?>
    </select>
    <span style="display: inline-block;margin-left: 10px;">
    <b class="black"><?php echo Yii::t('sellerOrder','申请时间：') ?></b>
    <select class="inputtxt1" onchange="self.location.href=options[selectedIndex].value">
        <option value="<?php echo Yii::app()->createAbsoluteUrl('/seller/backOrder/index',array('exchange_type'=>$exchangeType,'exchange_status'=>$exchangeStatus,'time_type'=>0)) ?>"><?php echo Yii::t('sellerOrder','全部时间：') ?></option>

        <option <?php if($timeType == 1) echo "selected='selected'"; ?> value="<?php echo Yii::app()->createAbsoluteUrl('/seller/backOrder/index',array('exchange_type'=>$exchangeType,'exchange_status'=>$exchangeStatus,'time_type'=>1)) ?>"><?php echo Yii::t('sellerOrder','三个月前') ?></option>
        <option <?php if($timeType == 2) echo "selected='selected'"; ?> value="<?php echo Yii::app()->createAbsoluteUrl('/seller/backOrder/index',array('exchange_type'=>$exchangeType,'exchange_status'=>$exchangeStatus,'time_type'=>2)) ?>"><?php echo Yii::t('sellerOrder','最近三个月') ?></option>

    </select></span>
</div>
<?php

$this->widget('GridView', array(
        'id' => 'goods-grid',
        'dataProvider' => $model->getBackGoods($exchangeType,$orderCode,$timeType,$exchangeStatus),
        'itemsCssClass' => 'mt15 sellerT3 goodsIndex',
        'cssFile'=>false,
        'pager'=>array(
            'class'=>'LinkPager',
            'htmlOptions'=>array('class'=>'pagination'),
        ),
        'pagerCssClass'=>'page_bottom clearfix',
        'columns' => array(
            //'exchange_id',
            array(
                'name'=>'exchange_id',
                'value'=>'$data->exchange_code',
                'type'=>'raw',
                //'headerHtmlOptions'=>array('width'=>'0%'),
            ),
            array(
                'name'=>'exchange_type',
                'value'=>'Order::exchangeType($data->exchange_type)',
                'type'=>'raw',
                //'headerHtmlOptions'=>array('width'=>'7%'),
            ),
            array(
                'name'=>'code',
                'value'=>'$data->code',
                'type'=>'raw',
                //'headerHtmlOptions'=>array('width'=>'15%'),
            ),
            array(
                'name'=>'商品名称',
                //'value'=>'$data->orderGoods[0]->goods_name',
                'value'=>'Order::setOrderGoodsList($data->orderGoods)',
                'type'=>'raw',
                //'headerHtmlOptions'=>array('width'=>'15%'),
            ),
            array(
                'name'=>'exchange_apply_time',
                'value'=>'Order::checkStatusTime($data->exchange_apply_time,$data->exchange_status)',
                'type'=>'raw',
                //'headerHtmlOptions'=>array('width'=>'15%'),
            ),
            array(
                'name'=>'exchange_status',
                'value'=>'Order::exchangeStatus($data->exchange_status)',
                'type'=>'raw',
                //'headerHtmlOptions'=>array('width'=>'15%'),
            ),
            'customCUButton'=>array(
                'class' => 'CButtonColumn',
                'header' => Yii::t('sellerGoods','操作'),
                'template' => '<p>{updateBase}</p>',
                'buttons'=>array(
                    'updateBase'=>array(
                        'label'=>Yii::t("sellerOrder","查看详情"),
                        'url'=>'Yii::app()->createAbsoluteUrl("/seller/backOrder/backGoodsInfo",array("order_id"=>$data->id,"exchange_id"=>$data->exchange_id))',
                    ),
                ),
            ),
        )
    )
);
?>
<script>
    function GetRTime(times,Element){
        var t = times;
        var d=Math.floor(t/60/60/24);
        var h=Math.floor(t/60/60%24);
        var m=Math.floor(t/60%60);
        var s=Math.floor(t%60);
        Element.html("仅剩：" + d + " 天 " + h + " 时 "+ m + " 分 " +  s + " 秒 ");

    }
    $(function(){

        var num = 1;
        if($('.ddtime') != undefined){
            setInterval(function(){
                $('.ddtime').each(function(){
                    if($(this).attr('values')-num > 0){
                        GetRTime($(this).attr('values')-num,$(this))
                        num++
                    }

                })
            },1000);
        }

    })
</script>
