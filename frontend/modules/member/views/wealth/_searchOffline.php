<div class="upladaapBoxBg mgtop20 ">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createAbsoluteUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <div class="upladBox_1">
        <b class="mgleft20">
            <?php echo Yii::t('memberWealth', '加盟商名称'); ?>：</b>
        <?php echo $form->textField($model, 'remark', array('class' => 'integaralIpt4 mgright15')); ?>
        <b><?php echo Yii::t('memberWealth', '起止时期'); ?>：</b>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'start_time',
            'language' => 'zh_cn',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'changeMonth' => true,
            ),
            'htmlOptions' => array(
                'class' => 'integaralIpt5',
            )
        ));
        ?>  -  <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'end_time',
            'language' => 'zh_cn',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'changeMonth' => true,
            ),
            'htmlOptions' => array(
                'class' => 'integaralIpt5 mgright15',
            )
        ));
        ?>
        <?php echo CHtml::submitButton(Yii::t('memberWealth', '搜索'), array('class' => 'searchBtn searchBtnright')); ?>
        <select id="symbolChange"><option value='<?php echo Symbol::RENMINBI;?>' /><?php echo Yii::t('memberWealth', '人民币'); ?><option value='<?php echo Symbol::HONG_KONG_DOLLAR;?>' /><?php echo Yii::t('memberWealth', '港币'); ?></select>
        <?php echo CHtml::button(Yii::t('memberWealth', '导出'), array('class' => 'searchBtn searchBtnright', "onclick" => "exportExcel()")); ?>
          <input type="hidden" value='<?php echo Symbol::RENMINBI;?>' id="symbolId">
    </div>
    <div class="upladBox_1 mgtop10 mgleft20">
        <dt><?php echo Yii::t('memberWealth', '对账状态'); ?>：</dt>
        <dd>
            <?php
            $sourceArr = $model::getCheckStatus();
            $sourceArr = array_reverse($sourceArr, true);
            $sourceArr[''] = Yii::t('memberWealth', '全部');
            $sourceArr = array_reverse($sourceArr, true)
            ?>
            <?php echo $form->radioButtonList($model, 'status', $sourceArr, array('separator' => '', 'class' => 'mgleft14')); ?>
        </dd>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script>
            $(function(){
                $("#symbolChange").change(function(){
                        var bz=$(this).val();
                        $("#symbolId").val(bz);
                    })
                })
//导出excel
    function exportExcel() {
        var franchiseeName = $('#FranchiseeConsumptionRecord_remark').val();
        var starTime = $('#FranchiseeConsumptionRecord_start_time').val();
        var endTime = $('#FranchiseeConsumptionRecord_end_time').val();
        var status = $('input:radio[name="FranchiseeConsumptionRecord[status]"]:checked').val();
        var biz=$('#symbolId').val();
        var url = createUrl("<?php echo $this->createUrl('wealth/exportExcel') ?>", {"franchiseeName": franchiseeName, "starTime": starTime, "endTime": endTime, "status": status,'b':biz});
//        alert(url);
        window.open(url);
    }
    /*
     * 生成url的js方法
     */
    function createUrl(route, param)
    {
        var urlFormat = "/";

//	if(route.slice(-1)!=urlFormat) route = route+urlFormat;	
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