<?php
/**
 * @var AdvertPictureController $this
 * @var AdvertPicture $model
 */
?>
<?php $this->breadcrumbs = array(Yii::t('advert', '广告位图片') => array('advertPicture/admin', 'aid' => $model->advert_id), Yii::t('advertPicture', '列表')); ?>


<?php if ($this->getUser()->checkAccess('AdvertPicture.Create')): ?>
    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('travel/advertPicture/create',array('aid'=>Yii::app()->request->getParam('aid'))) ?>"><?php echo '添加广告' ?></a>
<?php endif; ?>


<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'advertPicture-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'ajaxUpdate' => false,
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => 'advert_id',
            'value' => '$data->advert->name'
        ),
        'title',
        array(
            'type' => 'datetime',
            'name' => 'start_time',
            'value' => '$data->start_time'
        ),
        array(
            'type' => 'raw',
            'name' => 'end_time',
            'value' => 'empty($data->end_time) ? "<font color=\'green\'>永不过期</font>" : date("Y-m-d H:i:s", $data->end_time)'
        ),
        array(
            'type' => 'raw',
            'name' => 'status',
            'value' => '!empty($data->end_time) && $data->end_time < time() ? "<font color=\'red\'>过期</font>" : AdvertPicture::getStatus($data->status)',
        ),
        'sort',
        array(
            'name' => 'target',
            'value' => 'AdvertPicture::getTarget($data->target)'
        ),
        array(
            'type' => 'raw',
            'name' => 'link',
            'value' => '$data->link ? CHtml::link(Yii::t("advertPicture", "查看链接"), $data->link, array("target" => "_blank")) : ""'
        ),
        'creater',
        array(
            'name' => 'created_at',
            'type' => 'dateTime',
        ),
        'updater',
        array(
            'name' => 'updated_at',
            'type' => 'dateTime',
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('user', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('AdvertPicture.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('AdvertPicture.Delete')"
                ),
            )
        )
    ),
));
?>