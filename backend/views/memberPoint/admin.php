<?php
/* @var $this MemberGradeController */
/* @var $model MemberGrade */

$this->breadcrumbs = array(
    Yii::t('memberGrade', '会员积分额度管理 ') => array('admin'),
    Yii::t('memberGrade', '级别管理'),
);
?>

<?php
$this->renderPartial('_search', array(
    'model' => $model,
));
?>
<?php if (Yii::app()->user->checkAccess('MemberPoint.ResetGrade')): ?>
<a class="regm-sub" href="<?php  echo Yii::app()->createAbsoluteUrl('/memberPoint/create') ?>">添加积分额度</a> 
     <button class="regm-sub" id="reset">重置会员级别</button>
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'member-grade-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'id',
        'member_id',
        'grade_id',
    	'day_point',
    	'month_point',
    	'day_limit_point',
    	'month_limit_point',
    	array(
    		  'name' => 'special_type',
    		  'value' => 'MemberPoint::getType($data->special_type)',
    		),
    	array(
    		  'name' => 'update_time',
    		  'value' => 'date("Y-m-d H:i:s",$data->update_time)',
    		),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{update}',
            'updateButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('user', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('MemberPoint.Update')"
                ),
            )
        )
    ),
));
?>


<script type="text/javascript">
$('#reset').click('click',function(){
    if(confirm("确定要重置会员级别？")) {
    	 var GradeId =1;
    	 var url = '<?php  echo Yii::app()->createAbsoluteUrl('MemberPoint/ResetGrade') ?>';
	    $.ajax({
	        type: 'POST',
	        dataType: 'json',
	        url: url,
	        data: {'GradeId': GradeId},
	        error: function(data) {
	        	if(data.result){
		        	alert("重置成功");
		     
		        }else{
			        alert(data.message);
			    }
	        },
	        success: function(data) {
	        	if(data.result){
		        	alert("重置成功");
		        	location.reload();
		        }else{
			        alert(data.message);
			    }
		        
	        }
	       
	    });
    }
});
</script>
