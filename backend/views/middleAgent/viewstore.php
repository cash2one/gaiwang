<?php
	$this->breadcrumbs = array(
		Yii::t('store','居间商列表') =>array('middleAgent/admin'),
		Yii::t('store','商家信息详情'),
	);
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
        <tr><th colspan="2" style="text-align: center" class="title-th"><?php echo Yii::t('store', '商家信息'); ?></th></tr>
        <tr>
            <th style="width: 220px"></th>
            <td>
                <?php echo Yii::t('store','商家编号：') ?>
                <?php echo $model->member->gai_number ?>
            </td>
        </tr>
        <tr>
            <th style="width: 220px"></th>
            <td>
                <?php echo Yii::t('store','商家名称：') ?>
                <?php echo CHtml::tag('a',array('href'=>DOMAIN . '/shop/'.$model->id .'.html','target'=>'_blank'),$model->name)  ?>
            </td>
        </tr>
        <tr>
            <th style="width: 220px"></th>
            <td>
                <?php echo Yii::t('store','店铺开启状态：') ?>
                <?php echo Store::status($model->status) ?>
            </td>
        </tr>
        <tr>
            <th style="width: 220px"></th>
            <td>
                <?php echo Yii::t('store','开店时间：') ?>
                <?php echo date('Y-m-d H:i:s',$model->create_time) ?>
            </td>
        </tr>
        <tr>
            <th style="width: 220px"></th>
            <td>
                <?php echo Yii::t('store','开店模式：') ?>
                <?php echo Store::getMode($model->mode) ?>
            </td>
        </tr>
        <tr>
            <th style="width: 220px"></th>
            <td>
                <?php echo Yii::t('store','经营类目：') ?>
                <?php echo $model->categoryname ?>
            </td>
        </tr>
        <tr>
            <th style="width: 220px"></th>
            <td>
                <?php echo Yii::t('store','在售商品数：') ?>
                <?php echo $model->sales_goods ?>
            </td>
        </tr>
    </tbody>
</table>