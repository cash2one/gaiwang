<div class="main">
    <div class="line tjbox">
        <div class="line title_one">
            <div class="unit title_oneimg">
                <img src="<?php echo Yii::app()->baseUrl?>/images/icon06.png" width="37" height="51" alt="icon1" /></div>
            <div class="unit title_onezi">盖机运行时间表</div>
        </div>

        <?php if (Yii::app()->user->checkAccess('WeeklyStatistics.MachineTimeExport')):?>
            <?php $form=$this->beginWidget('CActiveForm', array(
                'action'=>Yii::app()->createUrl('WeeklyStatistics/MachineTimeExport'),
                'method'=>'post',
            )); ?>
            <div class="line tjbox_nr">
                密码: <input type="text" maxlength="128" id="password" name="password" class="text-input-bj">
                <select name="limit">
                    <?php for($i =1;$i<=$pages;$i++): ?>
                        <option value="<?php echo $i?>">第<?php echo $i ?>页</option>
                    <?php endfor; ?>
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;<?php echo CHtml::submitButton('导出excel',array('class'=>'regm-sub')) ?>
                <span style=" color:red;">&nbsp;&nbsp;&nbsp;&nbsp;注：每一页导出10W条数据！<span>
            </div>
            <?php $this->endWidget() ?>
        <?php endif;?>
    </div>
</div>