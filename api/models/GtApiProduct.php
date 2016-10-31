<?php
class GtApiProduct extends ApiModel {

    public $tableName = 'gatetong.gt_product';
    public $primaryKey = 'id';

    const STATUS_WAIT = 0;
    const STATUS_PASS = 1;
    const STATUS_NO = 2;

    public static function getProductByPk($productId,$field=array('*')){
        return Yii::app()->db->createCommand()->select($field)
                ->from('gatetong.gt_product')->where('id=:id', array(':id'=>$productId))
                ->queryRow();
    }
    
    

}

?>