
<style type="text/css">
#GftNopwdPayLimitSetting-grid_c5{
    padding: 0px 8px;
}
</style>
<?php 
$this->breadcrumbs = array(Yii::t('home','网站配置管理'),Yii::t('home','盖付通免密金额设置'));

if (Yii::app()->user->checkAccess('GftNopwdPayLimitSetting.Create')): 
?>
    <a class="regm-sub" href="<?php echo $this->createAbsoluteUrl('/gft-nopwd-pay-limit-setting/create') ?>"><?php echo Yii::t('GftNopwdPayLimitSetting', '新建') ?></a>
<?php endif; ?>
<div class="c10"></div>

<?php
$this->widget('GridView', array(
    'id' => 'GftNopwdPayLimitSetting-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'name' => Yii::t('GftNopwdPayLimitSetting', '免密支付额度'),
            'value' => '$data->pay_limit'
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('GftNopwdPayLimitSetting', '操作'),
            'template' => '{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                // 'update' => array(
                //     'label' => Yii::t('GftNopwdPayLimitSetting', '编辑'),
                //     'visible' => 'Yii::app()->user->checkAccess("GftNopwdPayLimitSetting.Update")',
                //     'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");'),
                // ),
                'delete' => array(
                    'label' => Yii::t('GftNopwdPayLimitSetting', '删除'),
                    'visible' => 'Yii::app()->user->checkAccess("GftNopwdPayLimitSetting.Delete")',
                ),
            )
        )
    ),
));
?>


