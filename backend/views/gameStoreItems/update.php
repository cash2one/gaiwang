<?php
$this->breadcrumbs = array(
    Yii::t('gameStore', '游戏配置管理') => array('gameStore/admin'),
    Yii::t('gameStoreItems', $model->flag == GameStoreItems::FLAG_ITEMS_YES ? '修改特殊商品' : '修改商品')
);
?>
<?php $this->renderPartial('_form',array('model'=>$model,'flag'=>$flag,'items' =>$items))?>