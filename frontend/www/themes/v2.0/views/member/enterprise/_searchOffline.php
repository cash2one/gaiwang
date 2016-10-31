
 <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createAbsoluteUrl($this->route),
        'method' => 'get',
    ));
    ?>
<div class="withdraw-time">
                    	<span class="withdraw-left"><?php echo Yii::t('memberWealth', '申请日期') ?>：</span>
                        <div class="select-time">
                        	<?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'start_time',
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
                    	<span class="withdraw-left"><?php echo Yii::t('memberWealth', '状态') ?>：</span>
                        <div class="select-status">
                         <?php
                            $sourceArr = $model::getCheckStatus();
                        ?>
                            <?php foreach ($sourceArr as $k =>$v):?>
                        	     <span data-id="<?php echo $k;?>" class="statusOn <?php if ((string)($k)===$model->status):?> on <?php endif;?>"><?php echo $v; ?></span>
                        	  <?php endforeach;?>
                        	  <input type="hidden" value="<?php echo isset($_GET['FranchiseeConsumptionRecord']['status']) ? $_GET['FranchiseeConsumptionRecord']['status'] :''?>" id="statusValue" name="FranchiseeConsumptionRecord[status]">
                        </div>
                    </div>
                    <div class="withdraw-search">
                    	<span class="withdraw-left"><?php echo Yii::t('memberWealth', '账户名 ') ?> ：</span>
                        <div class="select-search">
                         <?php echo $form->textField($model, 'remark', array('class' => 'search-input')); ?>
                         <?php echo CHtml::submitButton(Yii::t('memberWealth', '搜索'), array('class' => 'search-btn')); ?>
                         <?php echo CHtml::button(Yii::t('memberWealth', '导出'), array('class' => 'input-send', "onclick" => "exportExcel()")); ?>
                        </div>
                    </div>
         <?php $this->endWidget(); ?>
         
  <?php 
		$params=$_GET;
		$goUrl='';
		$url=Yii::app()->createUrl($this->route);
		if(isset($params['FranchiseeConsumptionRecord']['start_time'])){
            unset($params['FranchiseeConsumptionRecord']['status']);
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
                window.location.href =url+"FranchiseeConsumptionRecord[status]="+value;
            });
        });
        
		})
</script>
    
<script>
//导出excel
    function exportExcel() {
        var franchiseeName = $('#FranchiseeConsumptionRecord_remark').val();
        var starTime = $('#date-start').val();
        var endTime = $('#date-end').val();
        var status = $('#statusValue').val();
        var url = createUrl("<?php echo $this->createUrl('enterprise/exportExcel') ?>", {"franchiseeName": franchiseeName, "starTime": starTime, "endTime": endTime, "status": status,"page":<?php echo $this->getParam('FranchiseeConsumptionRecord_page') ?$this->getParam('FranchiseeConsumptionRecord_page') :1 ?>});
        window.open(url);
    }
    /*
     * 生成url的js方法
     */
    function createUrl(route, param)
    {
        var urlFormat = "/";
        if (route.slice(-1) == urlFormat) {
            route = substr(0, length(route) - 1);
        }
        var i = 1;
        for (var key in param)
        {
            if (i > 1) {
                route += "&" + key + "=" + param[key];
            } else {
                route += "?" + key + "=" + param[key];
            }
            i++;
        }
        return route;
    }
</script>