<?php $form = $this->beginWidget('CActiveForm', $formConfig); ?>
<script type="text/javascript" src="/js/EMSwitchBox.js"></script>
<script type="text/javascript">
    $(document).ready(
        function () {
            $('.show-checkbox').EMSwitchBox({ onLabel: '开', offLabel: '关' });
            $('.show-checkbox').val(1);
        });

</script>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
    <tr>
        <th style="width: 200px">
            <label class="required">三国跑跑<span class="required">*</span></label>
        </th>
        <td>
            <?php echo $form->hiddenField($model, 'app_type',array('value' => AppVersion::APP_TYPE_GAME_SWITCH)); ?>
            <?php echo $form->error($model, 'app_type'); ?>
            <?php echo $form->hiddenField($model, 'config_name',array('value' => 'switch')); ?>
            <?php echo $form->error($model, 'config_name'); ?>
            <?php echo $form->hiddenField($model, 'value',array('value' => '3')); ?>
            <?php echo $form->error($model, 'value'); ?>
<!--            --><?php //echo $form->checkBox($model,'value',array('class' => 'show-checkbox'))?>
<!--            <input type="radio" name="GameConfig[val]" checked='--><?php //echo $model->value==1?"checked":""?><!--'  class="show-checkbox"/>-->
            <input type="radio" name="Switch[sanguorun]" class="show-checkbox" <?php echo  isset($switch['sanguorun'])&&$switch['sanguorun']==1?"checked=checked":"" ?>/>
        </td>
    </tr>
    <tr>
        <th style="width: 200px">
            <label class="required">猴犀利<span class="required">*</span></label>
        </th>
        <td>
            <input type="radio" name="Switch[housailei]" class="show-checkbox" <?php echo  isset($switch['housailei'])&&$switch['housailei']==1?"checked=checked":"" ?>/>
        </td>
    </tr>
    <tr>
        <th style="width: 200px">
            <label class="required">绿光<span class="required">*</span></label>
        </th>
        <td>
            <input type="radio" name="Switch[lvguang]" class="show-checkbox" <?php echo  isset($switch['lvguang'])&&$switch['lvguang']==1?"checked=checked":"" ?>/>
        </td>
    </tr>
    <tr>
        <th style="width: 200px">
            <label class="required">超神特工<span class="required">*</span></label>
        </th>
        <td>
            <input type="radio" name="Switch[jump]" class="show-checkbox" <?php echo  isset($switch['jump'])&&$switch['jump']==1?"checked=checked":"" ?>/>
        </td>
    </tr>
    <tr>
        <th style="width: 200px">
            <label class="required">熊孩子逃学记<span class="required">*</span></label>
        </th>
        <td>
            <input type="radio" name="Switch[xionghaizi]" class="show-checkbox" <?php echo  isset($switch['xionghaizi'])&&$switch['xionghaizi']==1?"checked=checked":"" ?>/>
        </td>
    </tr>
    <tr>
        <th style="width: 200px">
            <label class="required">美女走钢丝<span class="required">*</span></label>
        </th>
        <td>
            <input type="radio" name="Switch[zougangsi]" class="show-checkbox" <?php echo  isset($switch['zougangsi'])&&$switch['zougangsi']==1?"checked=checked":"" ?>/>
        </td>
    </tr>

    <tr>
        <th style="width: 200px">
            <label class="required">狗狗别作死<span class="required">*</span></label>
        </th>
        <td>
            <input type="radio" name="Switch[gougou]" class="show-checkbox" <?php echo  isset($switch['gougou'])&&$switch['gougou']==1?"checked=checked":"" ?>/>
        </td>
    </tr>

    <tr>
        <th style="width: 200px">
            <label class="required">兽人来了<span class="required">*</span></label>
        </th>
        <td>
            <input type="radio" name="Switch[shourenlaile]" class="show-checkbox" <?php echo  isset($switch['shourenlaile'])&&$switch['shourenlaile']==1?"checked=checked":"" ?>/>
        </td>
    </tr>

    <tr>
        <th></th>
        <td>
            <?php echo CHtml::submitButton(Yii::t('home', '保存'), array('class' => 'reg-sub')) ?>
        </td>
    </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>