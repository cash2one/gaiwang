<?php
$this->breadcrumbs = array(
    Yii::t('sellerStore', '返回列表') =>array('/seller/middleAgent/list'),
    Yii::t('sellerStore', '商家信息') => array('detail')   
);
?>
<div class="toolbar">
    <span><?php echo Yii::t('sellerStore', '商家信息详情'); ?></span>
</div>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt15 sellerT3">
    <tbody>
        <tr>
			 <th colspan="2" style="font-size: 20px">商家详情</th>			
		</tr>
        <tr>
            <th width="120px">
                <?php echo Yii::t('sellerStore', '商家编号'); ?>
            </th>
            <td>
                <?php echo $model->username;?>
            </td>
        </tr>
        <tr>
            <th><?php echo $model->getAttributeLabel('name') ?></th>
            <td><a href="<?php echo Yii::app()->createAbsoluteUrl('shop/view',array('id'=>$model->id))?>" target="_black"><?php echo $model->name?></a></td>
        </tr>
        <tr>
            <th><?php echo $model->getAttributeLabel('mobile') ?></th>
            <td><?php echo $model->mobile?></td>
        </tr>
        <tr>
            <th><?php echo $model->getAttributeLabel('status') ?></th>
            <td><?php echo Store::status($model->status)?></td>
        </tr>
        <tr>
            <th><?php echo Yii::t('sellerStore', '开店时间'); ?></th>
            <td><?php echo date("Y-m-d G:i:s",$model->create_time);?></td>
        </tr>
        <tr>
            <th><?php echo $model->getAttributeLabel('mode') ?></th>
            <td><?php echo Store::getMode($model->mode)?></td>
        </tr>
        <tr>
            <th><?php echo $model->getAttributeLabel('category_id') ?></th>
            <td><?php echo (!empty($model->category_id)) ? $model->category_id : '/' ?></td>
        </tr>
        <tr>
            <th><?php echo Yii::t('sellerStore', '在售商品'); ?></th>
            <td><?php echo Goods::CountSalesGoods($model->id) ?></td>
        </tr>

    </tbody>
</table>