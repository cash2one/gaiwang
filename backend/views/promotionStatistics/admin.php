<?php

/* @var $this PromotionStatisticsController */
/* @var $model PromotionStatistics */
$this->breadcrumbs = array(
    Yii::t('promotionStatistics', '统计管理'),
    Yii::t('promotionStatistics', ' 推广渠道列表') => array('admin'),
);
?>
<?php
    $this->renderPartial('_searchChannels', array(
            'model' => $model
        )); 
  ?>

<?php
    $this->widget('GridView', array(
        'id' => 'promotion-statistics-grid',
        'dataProvider' => $model->search(),
        'itemsCssClass' => 'tab-reg',
        'cssFile'   => false,
        'columns' => array(
            'name',
            'number',
            array( 
                'type' => 'raw',
                'name'=>Yii::t('promotionStatistics','引入新会员数'),
                'value' => 'CHtml::link( $data->new_members, array("/promotion-statistics/member","id"=>"$data->id") ,array("class"=>"reg-sub" ))',
            ),
            array(
                 'name'=>Yii::t('promotionStatistics','注册类型'),
                 'value' => 'PromotionChannels::getLoginType($data->register_type)',
                ),
           array(
                 'name'=>Yii::t('promotionStatistics','访问数（注册页面）'),
                 'value' => '$data->visits',
                ),
           array(
                'name'=>Yii::t('promotionStatistics','添加时间'),
                'value' => 'date("Y-m-d H:i:s",$data->create_time)',
                ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{views}{deletes}',
                'header' => Yii::t('home', '操作'),
                'updateButtonImageUrl' => false,
                'buttons' => array(
                   'views' => array(
                                'label' => Yii::t('user', '查看'),
                                'url' => 'Yii::app()->createUrl("PromotionStatistics/view",array("id"=>$data->id))',
                                'visible' => "Yii::app()->user->checkAccess('PromotionStatistics.view')"
                        ),
                    'deletes' => array(
                        'label' => Yii::t('promotionStatistics', '删除'),
                        'url' => 'Yii::app()->createUrl("PromotionStatistics/delete",array("id"=>$data->id))',
                        'options' => array(
                            'class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");',
                            'onclick'=> 'return confirm("确定删除该渠道信息？")'
                        ),
                        'visible' => 'Yii::app()->user->checkAccess("PromotionStatistics.delete")',
                    ),
                )
            ),
        ),
        )
    );
?>