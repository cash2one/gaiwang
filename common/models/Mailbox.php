<?php

/**
 * 会员信箱模型
 * @author wanyun.liu <wanyun_liu@163.com>
 *
 * @property string $id
 * @property integer $status
 * @property string $member_id
 * @property string $message_id
 *
 * The followings are the available model relations:
 * @property Member $member
 * @property Message $message
 */
class Mailbox extends CActiveRecord {

    const STATUS_UNRECEIVE = 0;
    const STATUS_RECEIVED = 1;

    public function tableName() {
        return '{{mailbox}}';
    }

    public function rules() {
        return array(
            array('member_id, message_id', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('member_id, message_id', 'length', 'max' => 11),
            array('id, status, member_id, message_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
            'message' => array(self::BELONGS_TO, 'Message', 'message_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => '主键',
            'status' => '状态', //（0未读、1已读）
            'member_id' => '所属会员',
            'message_id' => '所属信息',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('member_id', $this->member_id, true);
        $criteria->compare('message_id', $this->message_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getStatus() {
        return array(
            self::STATUS_UNRECEIVE => Yii::t('memberMessage', '未阅读'),
            self::STATUS_RECEIVED => Yii::t('memberMessage', '已阅读')
        );
    }

    public static function showStatus($key) {
        $status = self::getStatus();
        return $status[$key];
    }

    // 获取最新的未读站内信
    public static function newMessageCount() {
        return Mailbox::model()->with(
                        array('message' => array('condition' => 'receipt_time < ' . time()))
                )->count('status=' . self::STATUS_UNRECEIVE . ' and member_id = ' . Yii::app()->user->id);
    }

}
