<?php

/**
 * This is the model class for table "{{franchisee_pre_consumption_record}}".
 *
 * The followings are the available columns in table '{{franchisee_consumption_record_goods}}':
 * @property int $id
 * @property string $franchisee_id
 */
class FranchiseeConsumptionRecordGoods extends CActiveRecord
{
    
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{franchisee_consumption_record_goods}}';
    }

}
