<?php
/* @var $this SeckillAuctionController */
/* @var $model SeckillAuction */
$this->breadcrumbs = array(
    Yii::t('auction', '拍卖活动商品') => array('admin'),
    Yii::t('auction', '修改'),
);
?>
<?php
$form = $this->beginWidget('ActiveForm', array(
	'id' => $this->id . '-form',
	'enableAjaxValidation' => true,
	'enableClientValidation' => true,
));
?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-come" >
	<tbody>
	
        <tr><th class="title-th even" colspan="2" style="text-align: center;"> <?php echo Yii::t('auction','修改拍卖活动商品');?></th></tr>

	    <tr id="confirmTR">
		    <th class="even">
			    <?php echo Yii::t('auction','编号');?>：
		    </th>
		    <td class="even" ><?php echo $data['id'];?></td>
	    </tr>

	    <tr id="confirmTR">
		    <th class="even">
			    <?php echo Yii::t('auction','商品名称');?>：
		    </th>
		    <td class="even" ><?php echo $data['goods_name'];?></td>
	    </tr>

	    <tr id="confirmTR">
		    <th class="even">
			    <?php echo Yii::t('auction','商品ID');?>：
		    </th>
		    <td class="even" ><?php echo $data['goods_id'];?></td>
        </tr>
		
	    <tr id="confirmTR">
		    <th class="even">
			    <?php echo Yii::t('auction','商家名称');?>：
		    </th>
		    <td class="even" ><?php echo $data['seller_name'];?></td>
	    </tr>

		<?php if ($rules_running['start_time'] > date("Y-m-d H:i:s")):?><!--未开启与未开始活动-->
		
	    <tr id="confirmTR" >
            <th class="even">
                <?php echo Yii::t('auction','起拍价');?>
            </th>
            <td class="even" >
                <?php echo $form->textField($model, 'start_price',array('id'=>'start_price')); ?>
                <?php echo $form->error($model, 'start_price'); ?>
            </td>
        </tr>

	    <tr id="confirmTR" >
            <th class="even">
                <?php echo Yii::t('auction','加价幅度');?>
            </th>
            <td class="even" >
                <?php echo $form->textField($model, 'price_markup',array('id'=>'price_markup')); ?>
                <?php echo $form->error($model, 'price_markup'); ?>
            </td>
        </tr>
		
		<tr id="confirmTR">
		    <th class="even">
			    <?php echo Yii::t('auction','保留价');?>：
		    </th>
		    <td class="even" >
			<?php if ($data['reserve_price'] == 0.00) :?>
			    <input type="text" name="reserve_price" id="reserve_price" value=" ">
			<?php else :?>
			    <input type="text" name="reserve_price" id="reserve_price" value="<?php echo $data['reserve_price'];?>">
			<?php endif ?>
			
		    </td>
	    </tr>
		
        <?php endif ?>
		
		<?php if($rules_running['end_time'] >= date("Y-m-d H:i:s") && $rules_running['start_time'] <= date("Y-m-d H:i:s")) :?><!--正在进行中的活动-->
		<tr id="confirmTR">
		    <th class="even">
			    <?php echo Yii::t('auction','起拍价');?>：
		    </th>
		    <td class="even" >
			    <?php echo $data['start_price'];?>
		    </td>
	    </tr>

	    <tr id="confirmTR">
		    <th class="even">
			    <?php echo Yii::t('auction','加价幅度');?>：
		    </th>
		    <td class="even" >
			    <?php echo $data['price_markup'];?>
		    </td>
	    </tr>
		
		<tr id="confirmTR">
		    <th class="even">
			    <?php echo Yii::t('auction','保留价');?>：
		    </th>
		    <td class="even" >
			    <?php echo $data['reserve_price'];?>
		    </td>
	    </tr>
		
		<?php endif ?>
		
		<?php if($rules_running['end_time'] < date("Y-m-d H:i:s") ):?><!--已结束活动-->
		<tr id="confirmTR">
		    <th class="even">
			    <?php echo Yii::t('auction','起拍价');?>：
		    </th>
		    <td class="even" >
			    <?php echo $data['start_price'];?>
		    </td>
	    </tr>

	    <tr id="confirmTR">
		    <th class="even">
			    <?php echo Yii::t('auction','加价幅度');?>：
		    </th>
		    <td class="even" >
			    <?php echo $data['price_markup'];?>
		    </td>
	    </tr>
		
		<tr id="confirmTR">
		    <th class="even">
			    <?php echo Yii::t('auction','保留价');?>：
		    </th>
		    <td class="even" >
			    <?php echo $data['reserve_price'];?>
		    </td>
	    </tr>
		
		<?php endif ?>
		
	    <?php if ($rules_running['start_time'] > date("Y-m-d H:i:s")):?><!--未开启与未开始活动-->
	    <tr id="confirmTR">
		    <th class="even">
			    <?php echo Yii::t('auction','所属活动');?>：
		    </th>
		    <td class="even" >
		        <?php echo $form->dropDownList($model, 'rules_setting_id', CHtml::listData($rules,'rules_seting_id','name'),array('class' => 'listbox','id'=>'rules_setting_id')); ?>
		        <?php echo $form->error($model, 'rules_setting_id'); ?>
		    </td>
        </tr>
        
        <tr id="confirmTR">
		    <th class="even">
			    <?php echo Yii::t('auction','状态');?>：
		    </th>
		    <td class="even" >
			    <?php echo $form->dropDownList($model, 'status', $model->getStatusArray(), array('class' => 'listbox')); ?>
			    <?php echo $form->error($model, 'status'); ?>
		    </td>
	    </tr>
        
	    <?php elseif($rules_running['end_time'] >= date("Y-m-d H:i:s") && $rules_running['start_time'] <= date("Y-m-d H:i:s")) :?><!--正在进行中的活动-->
		
		<tr id="confirmTR">
		    <th class="even">
			    <?php echo Yii::t('auction','状态');?>：
		    </th>
		    <td class="even" ><?php echo $model->getStatusArray($data['status']) ;?></td>
        </tr>
		
        <tr id="confirmTR">
			<th class="even">
				<?php echo Yii::t('auction','所属活动');?>：
			</th>
			<td class="even" ><?php echo $data['rules_name'];?></td>
		</tr>
		
	    <?php elseif ($rules_running['end_time'] < date("Y-m-d H:i:s") ):?><!--已结束活动-->
		
        <tr id="confirmTR">
		    <th class="even">
			    <?php echo Yii::t('auction','状态');?>：
		    </th>
		    <td class="even" ><?php echo $model->getStatusArray($data['status']) ;?></td>
        </tr>
           
	    <tr id="confirmTR">
		    <th class="even">
			    <?php echo Yii::t('auction','所属活动');?>：
		    </th>
		    <td class="even" ><?php echo $data['rules_name'];?></td>
	    </tr>
	    <?php endif ?>

	    <tr id="confirmTR">
		    <th class="even">
			    <?php echo Yii::t('auction','创建者');?>：
		    </th>
		    <td class="even" ><?php echo $data['create_user'];?></td>
	    </tr>

	    <tr id="confirmTR">
		    <th class="even">
			    <?php echo Yii::t('auction','创建时间');?>：
		    </th>
		    <td class="even" ><?php echo $data['create_time'];?></td>
	    </tr>
        
		<?php if ($rules_running['start_time'] > date("Y-m-d H:i:s")):?><!--未开启与未开始活动-->
        <tr id="confirmTR" style="text-align: center;">
			<td colspan="10"><input type="submit" class ="reg-sub" value="保存" id="Btn_Update"/></td>
	    </tr>
		<?php endif ?>
		
	</tbody>
</table>
<?php $this->endWidget(); ?>

<script type="text/javascript">
$("#Btn_Update").click(function() {    
    var price_markup = $("#price_markup").val();//加价幅度
	var start_price = $("#start_price").val();//起拍价
	var reserve_price = $("#reserve_price").val();//保留价
	var number = parseFloat(document.getElementById('price_markup').value);//加价幅度
	var pnumber = parseFloat(document.getElementById('start_price').value);//起拍价
	var snumber = parseFloat(document.getElementById('reserve_price').value);//保留价
	
	if (!start_price) {
        alert("<?php echo Yii::t('sellerOrder', '起拍价不能为空！'); ?>");
		document.getElementById("start_price").focus();
        return false;
    }
				
    if(isNaN(document.getElementById('start_price').value)){
        alert("起拍价只能为数字！");
        document.getElementById("start_price").focus();
        return false;
    }
	
    if (pnumber<0) {
        alert("起拍价不能为负数！");
        document.getElementById("start_price").focus();
        return false;
    }
    if (pnumber==0) {
        alert("起拍价不能为0！");
        document.getElementById("start_price").focus();
        return false;
    }
	
    if (pnumber>99999999) {
        alert("起拍价已达上限！");
        document.getElementById("start_price").focus();
        return false;
    }
	
    if (!price_markup) {
        alert("<?php echo Yii::t('sellerOrder', '加价幅度不能为空！'); ?>");
	    document.getElementById("price_markup").focus();
        return false;
    }
	
    if(isNaN(document.getElementById('price_markup').value)){
        alert("加价幅度只能为数字！");
        document.getElementById("price_markup").focus();
        return false;
    }
	
    if (number<0) {
        alert("加价幅度不能为负数！");
        document.getElementById("price_markup").focus();
        return false;
    }
	
    if (number==0) {
        alert("加价幅度不能为0！");
        document.getElementById("price_markup").focus();
        return false;
    }
	if (number>99999999) {
        alert("加价幅度已达上限！");
        document.getElementById("price_markup").focus();
        return false;
    }
	
	if(isNaN(document.getElementById('reserve_price').value)){
        alert("保留价只能为数字！");
        document.getElementById("reserve_price").focus();
        return false;
    }
	
    if (snumber<0) {
		alert("保留价不能为负数！");
        document.getElementById("reserve_price").focus();
        return false;
    }
    if (snumber==0) {
		alert("保留价不能为0！");
        document.getElementById("reserve_price").focus();
        return false;
    }
	if (snumber<pnumber) {
		alert("保留价不能小于起拍价！");
        document.getElementById("reserve_price").focus();
        return false;
    }
});
</script>
