<?php

/**
 * 报修模型
 * @author wanyun.liu <wanyun_liu@163.com>
 * 
 * This is the model class for table "{{repairs}}".
 *
 * The followings are the available columns in table '{{repairs}}':
 * @property string $id
 * @property string $merchant
 * @property string $address
 * @property string $mobile
 * @property string $content
 * @property integer $status
 * @property string $create_time
 */
class Repairs extends CActiveRecord {

    const STATUS_NEW = 0;
    const STATUS_PROCESING = 1;
    const STATUS_PROCESSED = 2;

    public static function getStatus() {
        return array(
            self::STATUS_NEW => '新故障',
            self::STATUS_PROCESING => '处理中',
            self::STATUS_PROCESSED => '已处理'
        );
    }

    public static function showStatus($var) {
        $datas = self::getStatus();
        return $datas[$var];
    }

    public function tableName() {
        return '{{repairs}}';
    }

    public function rules() {
        return array(
            array('merchant, address, mobile, content, status, create_time', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('merchant, address', 'length', 'max' => 128),
            array('mobile', 'length', 'max' => 45),
            array('create_time', 'length', 'max' => 11),
            array('id, merchant, address, mobile, content, status, create_time', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'merchant' => '商家名',
            'address' => '商家地址',
            'mobile' => '联系电话',
            'content' => '故障内容',
            'status' => '状态', // （0新故障、1跟进中、2已处理）
            'create_time' => '创建时间',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('merchant', $this->merchant, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('create_time', $this->create_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
