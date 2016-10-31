<?php

$this->breadcrumbs = array(
    Yii::t('viewspot', '城市名片管理') => array('citycard/admin'),
    Yii::t('viewspot', '景点')
);
?>
    <div class="search-form"><?php $this->renderPartial('_search', array('model' => $model)); ?></div>
<?php if (Yii::app()->user->checkAccess('viewspot.Create')): ?>
    <a class="regm-sub"
       href="<?php echo Yii::app()->createAbsoluteUrl('travel/viewspot/create', array('cityCardId' => $cityCardId)) ?>"><?php echo Yii::t('viewspot', '+新增景点') ?></a>
    <div class="c10"></div>
<?php endif; ?>

<?php
$this->widget('GridView', array(
    'id' => 'viewSpot-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'summaryText' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'name',
        'name_en',
        array(
            'class' => 'CButtonColumn',
            'header' => '操作',
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('citycard', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('CityCard.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('citycard', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('CityCard.Delete')"
                ),
            ),
        ),
    ),
));
?>