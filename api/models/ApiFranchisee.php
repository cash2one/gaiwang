<?php
class ApiFranchisee extends ApiModel{

    public $tableName = '{{franchisee}}';
    public $primaryKey = 'id';
    
    public static function getFranchisee($franchiseeId){
        $franchisee = Yii::app()->db->createCommand()
                ->from('{{franchisee}}')->where('id=:fid', array(':fid'=>$franchiseeId))
                ->queryRow();
        return $franchisee;
    }
    
    
}

?>