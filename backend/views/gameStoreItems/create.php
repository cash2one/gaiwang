<?php
$this->breadcrumbs = array(
    Yii::t('gameStore', '游戏配置管理') => array('gameStore/admin'),
    Yii::t('gameStoreItems', $flag == GameStore::FRANCHISE_STORES_IS ? '添加特殊商品' : '添加商品')
);
?>
<?php $this->renderPartial('_form',array('model'=>$model,'flag'=>$flag,'items' =>$items))?>