<?php
class PosInformation extends CActiveRecord
{
    public function tableName()
    {
        return self::getTableName();
    }

    public static function getTableName()
    {
        return '{{pos_information}}';   
    }
    
    public static function checkCardNum($num)
    {
        if(is_numeric($num))
            return true;
        else
            return false;
    }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return OfflineSignStoreExtend the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    /**
     * 检测post消费，补录是否大于等于5笔，
     *     tips: 如果大于等于五笔不进行自动对账
     *     
     * @param  integer    $machineId 
     * @return integer               
     */
    public static function checkSupplyCustomIsAutoCheck($machineId)
    {
        $beginTime = strtotime(date('Y-m-d'));
        $endTime = strtotime('+1 day',$beginTime);

        $where = " where machine_id =".$machineId." and is_supply=1 ";
        $where .= " and  transaction_time >= ".$beginTime." and transaction_time < ".$endTime;
        $sql = "select count(*) from ".self::getTableName().$where;
        $num = Yii::app()->db->createCommand($sql)->queryScalar();
        return $num>=5 ? true: false;
    }
}