<script type="text/javascript">
function CreateKey(id){
	$.ajax({
		    type : "post",
		    async : false,
		    dataType : 'json',
		    timeout : 5000,
		    url : " <?php echo $this->createUrl("/RsaManage/Create")  ?>",
			data : {
				'id' : id,
				},
                success: function(data) {
                	art.dialog(data);
                },
                error: function(data) {
                	art.dialog(data);
                }
		});

}
</script>
<?php
/* @var $this RsaManageController */

$this->breadcrumbs=array(
	Yii::t('RsaManage','秘钥管理'),
	Yii::t('RsaManage','秘钥管理'),
);
$this->renderPartial('_search',array('model'=>$model));

$this->widget('GridView', array(
		'id' => 'Rsa-Manage-Index',
		'dataProvider' => $model->search(),
		'cssFile' => false,
		'itemsCssClass' => 'tab-reg',
		'columns' => array(
				array(
						'headerHtmlOptions' => array('width' => '15%'),
						'name'=>'id',
				),
				array(
						'headerHtmlOptions' => array('width' => '20%'),
						'name'=>'merchant_num',
				),
				array(
						'name' => Yii::t('RsaManage', '操作'),
						'type' => 'raw',
						'value' => 'RsaManage::createButtons($data->id)',
				),
 		),
));
?>



