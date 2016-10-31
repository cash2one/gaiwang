<?php
/** @var $this GameStoreController */
/** @var $model GameStore */
$title = Yii::t('gameStore', '查看游戏店铺');
$this->pageTitle = $title . '-' . $this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('gameStore', '游戏店铺管理') => array('view'),
    $title,
);
?>
<div class="toolbar">
    <b><?php echo $title ?></b>
    <span><?php echo Yii::t('gameStore', '查看游戏店铺基本信息'); ?></span>
</div>
<?php echo CHtml::link(Yii::t('gameStore', '编辑游戏店铺'), $this->createAbsoluteUrl('/seller/gameStore/update',array('id' => $model->id)), array('class' => 'mt15 btnSellerEditor2')); ?>
<?php echo CHtml::link(Yii::t('gameStore', '游戏店铺商品'), $this->createAbsoluteUrl('/seller/gameStoreItems/index',array('id' => $model->id)), array('class' => 'mt15 btnSellerEditor2')); ?>
<?php
       if($model->franchise_stores == GameStore::FRANCHISE_STORES_IS){
           echo CHtml::link(Yii::t('gameStore', '店铺用户列表'), $this->createAbsoluteUrl('/seller/gameStoreMember/index',array('id' => $model->id)), array('class' => 'mt15 btnSellerEditor2'));
       }
?>
<?php //echo CHtml::link(Yii::t('gameStore', '店铺发货列表'), $this->createAbsoluteUrl('/seller/gameStoreDelivery/index',array('id' => $model->id)), array('class' => 'mt15 btnSellerEditor2')); ?>
<?php
      if($model->franchise_stores == GameStore::FRANCHISE_STORES_IS){
          echo CHtml::link(Yii::t('gameStore', '游戏公告'), $this->createAbsoluteUrl('/seller/gameStore/gameNotice'), array('class' => 'mt15 btnSellerEditor2'));
      }
?>
<?php
if($model->franchise_stores == GameStore::FRANCHISE_STORES_IS){
    echo CHtml::link(Yii::t('gameStore', '店铺流水列表'), $this->createAbsoluteUrl('/seller/gameStore/shopflow'), array('class' => 'mt15 btnSellerEditor2'));
}
?>
<?php echo CHtml::link(Yii::t('gameStore', '游戏反馈'), $this->createAbsoluteUrl('/seller/gameStore/feedback/'), array('class' => 'mt15 btnSellerEditor2')); ?>
<?php echo CHtml::link(Yii::t('gameStore', '查看评价'), $this->createAbsoluteUrl('/seller/gameStore/commentList/'), array('class' => 'mt15 btnSellerEditor2')); ?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt15 sellerT3">
    <tbody>
    <tr>
        <th width="10%"><?php echo $model->getAttributeLabel('store_name') ?>：</th>
        <td>
                <?php echo $model->store_name; ?>
        </td>
    </tr>
    <tr>
        <th width="120px">
            <?php echo $model->getAttributeLabel('store_phone') ?>：
        </th>
        <td>
            <?php echo $model->store_phone;?>
        </td>
    </tr>
    <tr>
        <th width="120px">
            <?php echo $model->getAttributeLabel('store_address') ?>：
        </th>
        <td>
            <?php echo CHtml::encode($model->store_address);?>
        </td>
    </tr>
    <tr>
        <th width="120px">
            <?php echo $model->getAttributeLabel('store_status') ?>：
        </th>
        <td>
            <?php echo GameStore::status($model->store_status);?>
        </td>
    </tr>
    <tr>
        <th><?php echo $model->getAttributeLabel('limit_time_hour') ?></th>
        <td><b class="red"><?php echo $model->limit_time_hour;?><?php echo Yii::t('gameStore', '小时'); ?></b></td>
    </tr>
    <tr>
        <th><?php echo $model->getAttributeLabel('limit_time_minute') ?></th>
        <td><b class="red"><?php echo $model->limit_time_minute;?><?php echo Yii::t('gameStore', '分钟'); ?></b></td>
    </tr>
    <tr>
        <th><?php echo $model->getAttributeLabel('send_num') ?>：</th>
        <td><?php echo $model->send_num;?></td>
    </tr>
    </tbody>
</table>