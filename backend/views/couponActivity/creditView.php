<?php
/** @var $model CouponActivity */
	$baseUrl = Yii::app()->baseUrl;
	$cs = Yii::app()->clientScript;

	$this->breadcrumbs = array(
	    Yii::t('couponActivity', '盖惠券商家管理') => array('creditAdmin'), Yii::t('couponActivity', '商家详情')
	);
?>



<script type="text/javascript">
    function showMoneyForm() {
        art.dialog({
            content: $("#update-money-form").html(),
            title: '<?php echo Yii::t('couponActivity', '更改授信额') ?>'
        });
    }
    function showRatioForm() {
        art.dialog({
            content: $("#update-ratio-form").html(),
            title: '<?php echo Yii::t('couponActivity', '更改活动支持比例') ?>'
        });
    }
</script>
<link href="/css/reg.css" rel="stylesheet" type="text/css">
<div  id="update-money-form" class="pager" style="display:none;">
    <div class="pager">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'action' => Yii::app()->createUrl('couponActivity/updateStoreAccount'),
            'method' => 'post',
            'id' => 'update_store_account'
        ));
        ?>
        <div>
            <input type="hidden" name="StoreAccount[id]" value="<?php echo $storeAccount->id;?>">
            <input type="hidden" name="StoreAccount[field]" value="money">
            <?php echo Yii::t('couponActivity','授信金额') ?>
            :<input type="text" maxlength="11" name="StoreAccount[money]" value="<?php echo $storeAccount->money;?>" class="text-input-bj">
        </div>
        <div class="aui_buttons" ><button type="submit">修改</button></div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<div  id="update-ratio-form" class="pager" style="display:none;">
    <div class="pager">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'action' => Yii::app()->createUrl('couponActivity/updateStoreAccount'),
            'method' => 'post',
            'id' => 'update_store_account'
        ));
        ?>
        <div>
            <input type="hidden" name="StoreAccount[id]" value="<?php echo $storeAccount->id;?>">
            <input type="hidden" name="StoreAccount[field]" value="ratio">
            <?php echo Yii::t('couponActivity','活动支持比例') ?>
            :<input type="text" maxlength="11" name="StoreAccount[ratio]" value="<?php echo $storeAccount->ratio;?>" class="text-input-bj">
        </div>
        <div class="aui_buttons" ><button type="submit">修改</button></div>
        <?php $this->endWidget(); ?>
    </div>
</div>


<div class="border-info clearfix search-form">
    <table class="searchTable" cellspacing="0" cellpadding="0">
        <tr style="height: 40px;">
            <td>商家名称：</td><td><?php echo $storeName;?></td>
        </tr>
        <tr style="height: 40px;">
            <td>授信额：</td><td><?php echo $storeAccount->money;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="#" onclick="javascript:showMoneyForm()" style="color:blue;">更改授信额</a></td>
        </tr>
        <tr style="height: 40px;">
            <td>剩余授信额：</td><td><?php echo $storeAccount->surplus_money;?></td>
        </tr>
        <tr style="height: 40px;">
            <td>盖网支持比例：</td><td><?php echo $storeAccount->ratio;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="#" onclick="javascript:showRatioForm()" style="color:blue;">更改比例</a></td>
        </tr>
        <tr style="height: 40px;">
            <td>状态：</td><td><?php echo StoreAccount::getStatus($storeAccount->status);?></td>
        </tr>
    </table>
</div>

<div class="ctxTable" id="dListTable">
<?php
$couponForm = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'view_coupon'
));
echo $couponForm->hiddenField($storeAccount, 'store_id',array('name'=>'id'));
?>
<?php
	$this->widget('GridView',array(
		'id'=>'coupon-activity-grid',
		'itemsCssClass'=>'tab-reg',
		'dataProvider'=>$activity->search(),
		'enableSorting' => false,
		'cssFile'=>false,
		'pager'=>array(
			'class'=>'LinkPager',
			'htmlOptions'=>array('class'=>'pagination'),
		),
		'columns'=>array(
			array(
				'headerHtmlOptions'=>array('width'=>'10%'),
				'name'=>'update_time',
				'value'=>'$data->update_time',
			),
            array(
				'headerHtmlOptions'=>array('width'=>'10%'),
				'name'=>'thumbnail',
				'value'=>'$data->thumbnail',
			),
            array(
				'headerHtmlOptions'=>array('width'=>'10%'),
				'name'=>'name',
				'value'=>'$data->name',
			),
            array(
                'headerHtmlOptions'=>array('width'=>'8%'),
                'name'=>'money',
                'value'=>'$data->money',
                'htmlOptions' => array('align' => 'center'),
            ),
			array(
				'headerHtmlOptions'=>array('width'=>'8%'),
				'name'=>'condition',
				'value'=>'$data->condition',
				'htmlOptions' => array('align' => 'center'),

			),
			array(
				'headerHtmlOptions' => array('width' => '17%'),
				'name' => 'valid_start',
				'value' => 'str_replace(array("s1","s2"),array(date("Y-m-d",$data->valid_start),date("Y-m-d",$data->valid_start)),"s1 '.Yii::t('couponActivity',"至").' s2")'
			),
			array(
				'headerHtmlOptions' => array('width' => '8%'),
				'name' => 'sendout',
				'value' => 'str_replace(array("s1","s2"),array($data->excess,$data->sendout),"s1/s2");'
			),
            array(
				'headerHtmlOptions' => array('width' => '8%'),
				'name' => 'sendout',
                'header' => $couponForm->dropDownList($activity, 'couponTotalStatus', Activity::getActivityCouponStatus(),array('name'=>'view_status','separator' => ' ','onchange' => 'javascript:$("#view_coupon").submit()')),
				'value' => '$data->getActivityCouponStatusString();'
			),
		),
	));
?>
<?php $this->endWidget(); ?>
</div>