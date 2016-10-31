<?php
class GtApiMachine extends ApiModel{

    public $tableName = 'gatetong.gt_machine';
    public $primaryKey = 'id';
    const STATUS_WAIT = 0;
    const STATUS_PASS = 1;
    const STATUS_NO = 2;
    


    public static function getProductByPk($productId,$field=array('*')){
        return Yii::app()->db->createCommand()->select($field)
                ->from('gatetong.gt_machine')
                ->where('id=:id', array(':id'=>$productId))
                ->queryRow();
    }
    
    

}

?>