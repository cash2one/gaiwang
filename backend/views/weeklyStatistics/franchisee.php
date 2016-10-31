<div class="main">
    <div class="line tjbox">
        <div class="line title_one">
            <div class="unit title_oneimg">
                <img src="<?php echo Yii::app()->baseUrl?>/images/icon06.png" width="37" height="51" alt="icon1" /></div>
            <div class="unit title_onezi">加盟商数据</div>
        </div>

        <?php if (Yii::app()->user->checkAccess('WeeklyStatistics.FranchiseeExport')):?>
            <?php $form=$this->beginWidget('CActiveForm', array(
                'action'=>Yii::app()->createUrl('WeeklyStatistics/FranchiseeExport'),
                'method'=>'post',
            )); ?>
            <div class="line tjbox_nr">
                密码: <input type="text" maxlength="128" id="password" name="password" class="text-input-bj">
                &nbsp;&nbsp;&nbsp;&nbsp;<?php echo CHtml::submitButton('导出excel',array('class'=>'regm-sub')) ?>
            </div>
            <?php $this->endWidget() ?>
        <?php endif;?>


    </div>
</div>