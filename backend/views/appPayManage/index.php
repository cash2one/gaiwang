<?php
/* @var $this AppPayManageController */

$this->breadcrumbs=array(
	Yii::t('AppPayManage', '盖象优选配置管理'),
	Yii::t('AppPayManage', '支付渠道设置'),
);

Yii::app()->clientScript->registerScript('search', "
$('#AppPayManage-form').submit(function(){
	$('#AppPayManage-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
$form = $this->beginWidget('CActiveForm',array(
		'id'=>'appPayManage-form',
		'enableClientValidation' => true,
		'enableAjaxValidation'=>false,
		'clientOptions' => array(
				'validateOnSubmit' => true,
		),
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
    <?php foreach ($modelData as $key=>$val){
    	?>   
        <tr>
	        <td><?php  echo AppPayManage::getAppPayType($val['type']);?>：</td>
	        <td><span class="required">*</span>是否开启：<?php $model->status = $val['status']; 
	          echo $form->RadioButtonList($model,'status',AppPayManage::getAppPayTypeStatus(),
	        		                      array('separator'=>'',
	        		                      		'id'=>"AppPayManage_".$val['type'],
	        		                      		'name'=>"AppPayManageName_".$val['type'],
	        		                      		'dataId'=>$val['id'],
	        		                      		'onclick'=>"SetStatus(this)",
	                                            )
	          		); ?>
	        </td>
	        <td><?php if ($val['status'] == 1 && $val['type'] != AppPayManage::APP_PAY_TYPE_JF): ?>
	               <a class="regm-sub" href="<?php  echo Yii::app()->createAbsoluteUrl('/appSubPayManage/index',array('type'=>$val['type'])) ?>">查看</a> 
	            <?php endif; ?>
	        </td>	
        </tr>
     <?php }?>
    </tbody>
    <tfoot>
<!--       <tr> -->
<!--          <td colspan="3" class="odd"> -->
             <?php //echo CHtml::submitButton(Yii::t('AppPayManage', '保存'), array('class' => 'reg-sub','style')); ?>
<!--          </td> -->
<!--     </tr> -->
    </tfoot>
</table>
<script type="text/javascript">
	          function SetStatus(obj){
	        	  if(confirm('是否确定修改状态!')){
	        		  var IdName = obj.id;
			          IdName = "#"+IdName; //元素的id名
			          var DataId = $(IdName).attr('dataId'); //数据的主键Id
			          var StatusVal = $(IdName).val();
			          var url = '<?php echo Yii::app()->createAbsoluteUrl('/AppPayManage/Update') ?>';
			          $.ajax({
			        	  type: 'POST',
			              dataType: 'json',
			              url: url,
			              data: {'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken ?>', 
			            	     DataId: DataId,
				                 StatusVal,StatusVal
				                 },
			              success: function(data) {
					                  if(data.success){
					                	  alert("修改成功");
						                  window.location.reload();
						              }
					                  else{
							              alert("修改失败，请重试");
							              window.location.reload();
							          }	
			                      }
				          })
			          
	        	}else{
	        		window.location.reload();
		        }
		         
		      }
</script>
<?php $this->endwidget();?>

