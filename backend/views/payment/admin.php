<?php
/* @var $this PrepaidCardController */
/* @var $model PrepaidCard */

$this->breadcrumbs = array(
    Yii::t('payment', '体现申请列表') => array('admin'),
    Yii::t('payment', '列表')
);
$batchId=$this->getParam('bid');
?>
<?php $batchArr=PaymentBatch::model()->findByPk($batchId);?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if ($this->checkAccess('PaymentBatch.ChangeStatus') && $batchArr->status < PaymentBatch::STATUS_PAYING): ?>
    <input  class="regm-sub Btn_change" data_id="1" type="button" value="<?php echo Yii::t('region', '审核通过'); ?>" >
<?php endif; ?>
<?php if ($this->checkAccess('PaymentBatch.ChangeStatus') && $batchArr->status < PaymentBatch::STATUS_PAYING): ?>
    <input  class="regm-sub Btn_change" data_id="2" type="button" value="<?php echo Yii::t('region', '审核不通过'); ?>" >
<?php endif; ?>

<?php if ($this->checkAccess('PaymentBatch.ChangePayStatus') && $batchArr->status==PaymentBatch::STATUS_PASS): ?>
    <input  class="regm-sub Btn_paychange" data_id="3" type="button" value="<?php echo Yii::t('region', '转账'); ?>" >
<?php endif; ?>

<!-- 
<?php if ($this->checkAccess('PaymentBatch.ChangeStatus') && $batchArr->status==PaymentBatch::STATUS_PASS): ?>
    <input class="regm-sub" id="Btn_doPay" type="button" value="<?php echo Yii::t('region', '确认批次转账'); ?>" >
<?php endif; ?>
 -->
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'payment-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'ajaxUpdate' => false,
    'columns' => array(
    	'batch_id',
        'member_id',
    	'account_name',
    	'bank_name',
    	'account',
    	'amount',
    	'req_id',	
        array(
            'name' => 'create_time',
            'value' => 'date("Y-m-d H:i:s", $data->create_time)'
        ),
        array(
            'name' => 'status',
            'value' => 'Payment::getStatus($data->status)'
        ),
    	array(
    		'name'=>'lock_status',
    		'value'=>'CHtml::link(Payment::getLockStatus($data->lock_status),"#",array("data-id"=>$data->id,"class"=>"is_show","style"=>"color:blue"))',
    		'type'=>'raw'
    	 ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{del}',
            'viewButtonLabel' => Yii::t('payment', '删除'),
            'viewButtonImageUrl' => false,
            'buttons' => array( 
            	'del' => array(
            		'label' => Yii::t('store', '删除'),
            		'url' => 'Yii::app()->createUrl("payment/delete",array("id"=>$data->id,"cid"=>$data->cash_id,"bid"=>$data->batch_id))',
            		'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");'),
            		'visible' => "Yii::app()->user->checkAccess('Payment.Delete')"
               ),
           )
        ),
    ),
));
?>

<?php
  $this->renderPartial('/layouts/_export', array(
    'model' => $model, 'exportPage' => $exportPage, 'totalCount' => $totalCount,
));
?>
<script src="<?php echo MANAGE_DOMAIN ?>/js/iframeTools.js"></script>
<script>
  $(function () {  
      $(".is_show").live('click',function () {
          var status = $(this).html();
          var id = $(this).attr("data-id");
          art.dialog.confirm(status=='活动'? '你确认锁定该代付？':"你确认开启该代付", function(){
            $.post("<?php echo $this->createAbsoluteUrl('payment/changeLock') ?>",{id:id},function (msg) {
                art.dialog.close();
                location.reload();
            });
          }, function(){
              art.dialog.tips('你取消了操作');
          });
          return false;
      });

      $(".Btn_change").live('click',function () {
          var id = <?php echo $this->getParam('bid');?>;
          var status=$(this).attr("data_id");
          art.dialog.confirm(status=='1'? '你确认该代付批次通过？':"你确认该代付批次不通过", function(){
            $.post("<?php echo $this->createAbsoluteUrl('paymentBatch/changeStatus') ?>",{id:id,st:status},function (data) {
                art.dialog({
                    icon: 'succeed',
                    content: data.msg,
                    ok: true,
                    drag:false
                });
                location.reload();
            },'json');
          },function(){
              art.dialog.tips('你取消了操作');
          });
          return false;
      });

      $(".Btn_paychange").live('click',function () {
          var id = <?php echo $this->getParam('bid');?>;
          var status=$(this).attr("data_id");
          art.dialog.confirm('你确认该代付批次转账？', function(){
            $.post("<?php echo $this->createAbsoluteUrl('paymentBatch/changePayStatus') ?>",{id:id,st:status},function (data) {
                art.dialog({
                    icon: 'succeed',
                    content: data.msg,
                    ok: true,
                    drag:false
                });
                location.reload();
            },'json');
          },function(){
              art.dialog.tips('你取消了操作');
          });
          return false;
      });

      $("#Btn_doPay").live('click',function () {
          var id = <?php echo $this->getParam('bid');?>;
          art.dialog.confirm("你确认执行该代付吗？", function(){
            $.post("<?php echo $this->createAbsoluteUrl('thirdPayment/ghtPay') ?>",{id:id},function (data) {
                art.dialog({
                    icon: 'succeed',
                    content: data.msg,
                    ok: true,
                    drag:false
                });
                location.reload();
            },'json');
          },function(){
              art.dialog.tips('你取消了操作');
          });
          return false;
      });
      
  });
</script>