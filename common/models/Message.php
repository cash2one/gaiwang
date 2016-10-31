<?php

/**
 * 站内信模型
 * @author wanyun.liu <wanyun_liu@163.com>
 * 
 * @property string $id
 * @property string $title
 * @property string $content
 * @property string $create_time
 * @property string $sender
 * @property string $sender_id
 * @property string $receipt_time
 *
 * The followings are the available model relations:
 * @property Mailbox[] $mailboxes
 */
class Message extends CActiveRecord {

    public $receiveId;

    public function tableName() {
        return '{{message}}';
    }

    public function rules() {
        return array(
            array('title, receiveId, content, receipt_time', 'required'),
            array('title', 'length', 'max' => 128),
            array('sender', 'length', 'max' => 64),
            array('receipt_time', 'comext.validators.compareDateTime', 'compareValue' => date('Y-m-d H:i:s'),
                'operator' => '>', 'message' => Yii::t('member', '{attribute}必须大于当前时间')),
            array('id, title, content, create_time, sender, sender_id, receipt_time', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'mailboxes' => array(self::HAS_MANY, 'Mailbox', 'message_id')
        );
    }

    public function attributeLabels() {
        return array(
            'id' => '主键',
            'title' => '标题',
            'content' => '内容',
            'create_time' => '创建时间',
            'sender' => '发送者名',
            'sender_id' => '发送者ID',
            'receipt_time' => '接收时间',
            'receiveId' => '接收者'
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('sender', $this->sender, true);
        $criteria->compare('sender_id', $this->sender_id, true);
        $criteria->compare('receipt_time', $this->receipt_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
