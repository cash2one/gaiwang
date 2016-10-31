<?php
/* @var $this EnterpriseApplyCashController */
/* @var $model CashHistory */
/* @var $form CActiveForm */

?>
 <?php $form=$this->beginWidget('ActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
    )); ?>
    <div class="withdraw-time">
    	<span class="withdraw-left"><?php echo $form->label($model,'apply_time'); ?>：</span>
        <div class="select-time">
      <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'apply_time',
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
            'attribute' => 'end_time',
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
              </div>
                   </div>
                    <div class="withdraw-status">
                    	<span class="withdraw-left"><?php echo Yii::t('memberWealth', '状    态') ?>：</span>
                        <div class="select-status">
                           <?php
                                //在状态数组头部，加入 “全部”，非0下标开始的数组，用radioButtonList 的 empty ，会导致下标改变
                                    $status = $model::status();
                                    $status = array_reverse($status,true);
                                    $status[''] = Yii::t('memberApplyCash','全部');
                                    $status = array_reverse($status,true);
                                ?>
                             <?php foreach($status as $k=> $v):?>
                        	     <span data-id="<?php echo $k;?>" class = "statusOn <?php if((string)($k)===$model->status):?> on <?php endif;?>"><?php echo $v; ?></span>
                        	  <?php endforeach;?>
                        	   <input type="hidden" value="<?php echo isset($_GET['CashHistory']['status']) ? $_GET['CashHistory']['status'] :''?>" name="CashHistory[status]">
                        </div>
                    </div>
                    <div class="withdraw-search">
                    	<span class="withdraw-left"><?php echo $form->label($model,'account_name'); ?>  ：</span>
                        <div class="select-search">
                        <?php echo $form->textField($model,'account_name',array("class"=>"search-input")) ?>
                         <input id="searchBtn" type="submit" class="search-btn" value="<?php echo Yii::t('memberApplyCash','搜索')?>" />
                        </div>
                    </div>
    <?php $this->endWidget(); ?>
    <?php 
			$params=$_GET;
			$goUrl='';
			$url=Yii::app()->createUrl($this->route);
			if(isset($params['CashHistory']['apply_time'])){
                unset($params['CashHistory']['status']);
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
                window.location.href =url+"CashHistory[status]="+value;
            });
        });
        
		})
</script>