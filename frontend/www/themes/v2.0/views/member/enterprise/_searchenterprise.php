
    <?php
    $form = $this->beginWidget('ActiveForm', array(
        'action' => Yii::app()->createAbsoluteUrl($this->route),
        'method' => 'get',
        'htmlOptions'=>array(         
        'class'=>'withdraw-time clearfix'        
        )
    ));
    ?>
     <div class="keyword-area clearfix">
         <label for="keyword" class="withdraw-left"><?php echo Yii::t('memberWealth', '关键词'); ?>：</label>
         <?php echo $form->textField($model, 'remark', array('class' => 'keyword-input')); ?>
      </div> 
       <div class="time-range clearfix">
          <label class="withdraw-left"><?php echo Yii::t('memberWealth', '起止时期'); ?>：</label>
         <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'create_time',
            'language' => 'zh_cn',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'changeMonth' => true,
                'changeYear' => true,
            ),
            'htmlOptions' => array(
                'id' => 'date-start',
            )
        ));
        ?>--<?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'endTime',
            'language' => 'zh_cn',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'changeMonth' => true,
                'changeYear' => true,
            ),
            'htmlOptions' => array(
                'id' => 'date-end',
            )
        ));
        ?> 
         <input type="hidden" value="<?php echo isset($_GET['AccountFlow']['operate_type']) ? $_GET['AccountFlow']['operate_type'] :''?>" id="statusValue" name="AccountFlow[operate_type]">   
    </div>
    <?php echo CHtml::submitButton(Yii::t('memberWealth','搜索'), array('class' => 'search-btn')); ?>
      <?php $this->endWidget(); ?>
    <div class="integral-source clearfix">
    <span class="withdraw-left"><?php echo Yii::t('memberWealth', '积分来源'); ?>：</span>
        <div class="select-status">
            <?php
            $sourceArr = $model::getOperateType();
            $sourceArr = array_reverse($sourceArr,true);
            $sourceArr[''] = Yii::t('memberWealth','全部');
            $sourceArr = array_reverse($sourceArr,true)
            ?>
            <?php foreach($sourceArr as $k=> $v):?>
               <span data-id="<?php echo $k;?>" class ="statusOn <?php if($k==$model->operate_type):?> on <?php endif;?>"><?php echo $v; ?></span>
             <?php endforeach;?>
        </div>
    </div>
     <?php 
			$params=$_GET;
			$goUrl='';
			$url=Yii::app()->createUrl($this->route);
			if(isset($params['AccountFlow']['create_time'])){
                unset($params['AccountFlow']['operate_type']);
			    $urlStr=http_build_query($params);
			    $goUrl=urldecode($url.'?'.$urlStr."&");
			   }else{
			    $goUrl=urldecode($url)."?";
			  }
	?>
<script>
    $(function(){
		$('.statusOn').each(function(i){
			var url="<?php echo $goUrl;?>"; 
            $(this).click(function(){
                var value = $(this).attr('data-id');
                window.location.href =url+"AccountFlow[operate_type]="+value;
            });
        });
        
		})
</script>