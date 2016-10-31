<?php
/* @var $this FranchiseeController */
/* @var $model Franchisee */
$this->breadcrumbs = array(Yii::t('gftmenuconfig', '协议用户列表') => array('list-agreement'), Yii::t('gftmenuconfig', '列表'));
?>
<style type="text/css">
#gftmenuconfig-grid_c5{
    padding: 0px 8px;
}
</style>
<?php if (Yii::app()->user->checkAccess('GftMenuConfig.Create')): ?>
    <a class="regm-sub" href="<?php echo $this->createAbsoluteUrl('/gft-menu-config/create') ?>"><?php echo Yii::t('gftmenuconfig', '添加') ?></a>
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'gftmenuconfig-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'title',
        // 'icon',
        array(
            'name' => 'icon',
            'value' => 'CHtml::image(Tool::showImg(ATTR_DOMAIN . "/" . $data->icon, "c_fill,h_80,w_100"), $data->title, array("width" => 100, "height" => 80, "style" => "display: inline-block"))',
            'type' => 'raw', //这里是原型输出
        ),
        'flag',
        'sort',
        array(
            'name' => 'status',
            'value' => 'GftMenuConfig::showStatus($data->status)',
            'id' => 'confirm_statu',
        ),
        array(
            'name' => 'create_time',
            'value' => '!empty($data->create_time)?date("Y-m-d H:i:s",$data->create_time):""',
        ),
        array(
            'name' => 'update_time',
            'value' => '!empty($data->update_time)?date("Y-m-d H:i:s",$data->update_time):""',
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('gftmenuconfig', '操作'),
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('gftmenuconfig', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('GftMenuConfig.update')",
                    'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");'),
                ),
                'delete' => array(
                    'label' => Yii::t('gftmenuconfig', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('GftMenuConfig.delete')",
                ),
            )
        )
    ),
));
?>


