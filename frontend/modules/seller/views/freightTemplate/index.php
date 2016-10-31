<?php
/* @var $this FreightTemplateController */
/* @var $v FreightTemplate */
/** @var $v2 FreightType */
$title = Yii::t('sellerFreightTemplate', '运费模版');
$this->pageTitle = $title . '-' . $this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('sellerFreightTemplate', '交易管理 '),
    $title,
);
?>

<div class="toolbar">
    <b><?php echo Yii::t('sellerFreightTemplate', '运费模版'); ?></b>
    <span><?php echo Yii::t('sellerFreightTemplate', '添加或修改商品运费公司和方式。'); ?></span>
</div>
<?php echo CHtml::link(Yii::t('sellerFreightTemplate', '运费模板'), array('/seller/freightTemplate/create'), array('class' => 'mt15 btnSellerAdd')); ?>
<?php foreach ($model as $v): ?>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt15 sellerT3">
        <tbody>
            <tr>
                <th colspan="6">
        <div class="fl">
            <?php echo Yii::t('sellerFreightTemplate',$v->name); ?>　　
            <?php $address = $v->StoreAddress ; /** @var $address StoreAddress*/ ?>
            <?php if(!$address) $address = new StoreAddress(); ?>
            (<?php echo Yii::t('sellerFreightTemplate', '发货地：'); ?><?php echo Region::getName($address->province_id,$address->city_id,$address->city_id,$address->district_id)?>)
        </div>
        <div class="fr"><?php echo $v->getAttributeLabel('create_time') ?>：<?php echo date('Y-m-d G:i:s',$address->create_time);?>
            <?php echo CHtml::link(Yii::t('sellerFreightTemplate', '修改'), array('/seller/freightTemplate/update/', 'id' => $v->id));
            ?>
            <?php echo CHtml::ajaxLink(Yii::t('sellerFreightTemplate', '删除'),array('/seller/freightTemplate/delete'),array(
                    'type'=>'POST',
                    'data'=>array('id'=>$v->id,'YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken),
                    'dataType'=>'json',
                    'success'=>'function(data){
                        alert(data.msg);
                        if(data.status=="success"){
                            location.reload();
                        }
                    }',
            ),array('confirm'=>Yii::t('sellerFreightTemplate', '确定要删除这个运费模板？'))) ?>
        </div>
    </th>
    </tr>
    <tr>
        <td width="12%"><b><?php echo Yii::t('sellerFreightTemplate', '运送方式'); ?></b></td>
        <td width="40%"><b><?php echo Yii::t('sellerFreightTemplate', '运送到'); ?></b></td>
        <td width="12%">
            <b>
                <?php echo Yii::t('sellerFreightTemplate', '首量'); ?>
                (<?php echo $v->unit($v->valuation_type) ?>)
            </b>
        </td>
        <td width="12%"><b><?php echo Yii::t('sellerFreightTemplate','运费'); echo Yii::t('sellerFreightTemplate', '（{0}）',array('{0}'=>HtmlHelper::formatPrice(''))); ?></b></td>
        <td width="12%">
            <b>
                <?php echo Yii::t('sellerFreightTemplate', '续量'); ?>
                (<?php echo $v->unit($v->valuation_type) ?>)
            </b>
        </td>
        <td width="12%"><b><?php echo Yii::t('sellerFreightTemplate','运费'); echo Yii::t('sellerFreightTemplate', '（{0}）',array('{0}'=>HtmlHelper::formatPrice(''))); ?></b></td>
    </tr>
    <?php foreach ($v->freightType as $v2): ?>
        <!--默认全国-->
        <tr>
            <td><?php echo $v2::mode($v2->mode) ?></td>
            <td>
                <?php echo Yii::t('sellerFreightTemplate', '全国') ?>
            </td>
            <td><span class="red"><?php echo $v2['default'] ?></span></td>
            <td><span class="red"><?php echo Common::rateConvert($v2['default_freight']) ?></span></td>
            <td><span class="red"><?php echo $v2['added'] ?></span></td>
            <td><span class="red"><?php echo Common::rateConvert($v2['added_freight']) ?></span></td>
        </tr>
        <?php $groupArea = FreightArea::groupArea($v2->id) ?>
        <?php foreach ($groupArea as $v3): ?>
            <tr>
                <td><?php echo $v2::mode($v2->mode) ?></td>
                <td>
                    <?php echo implode(',', Region::getNameArray($v3['location_ids'])) ?>
                </td>
                <td><span class="red"><?php echo $v3['default'] ?></span></td>
                <td><span class="red"><?php echo Common::rateConvert($v3['default_freight']) ?></span></td>
                <td><span class="red"><?php echo $v3['added'] ?></span></td>
                <td><span class="red"><?php echo Common::rateConvert($v3['added_freight']) ?></span></td>
            </tr>
        <?php endforeach ?>
    <?php endforeach; ?>
    </tbody>
    </table>
<?php endforeach; ?>

<div class="page_bottom clearfix">
    <div class="pagination">
        <?php
        $this->widget('LinkPager', array(
            'pages' => $pages,
            'htmlOptions' => array('class' => 'pagination'),
            'ajax'=>false,
        ))
        ?>
    </div>
</div>