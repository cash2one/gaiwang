<?php

/**
 * This is the model class for table "{{sms_log}}".
 *
 * The followings are the available columns in table '{{sms_log}}':
 * @property string $id
 * @property string $mobile
 * @property string $content
 * @property string $create_time
 * @property integer $status
 * @property integer $count
 * @property string $target_id
 * @property integer $type
 * @property string $send_time
 * @property integer $interface
 */
class EmailLog extends CActiveRecord {

    const EMAIL_SHOP = 1; // 商户开店
    const EMAIL_ORDER = 2; // 新订单


    /* 状态 */
    const STATUS_SUCCESS = 1; // 发送成功
    const STATUS_FAILD = 2; // 发送失败

    /*闪达代发商邮件发送类型*/
    const TEMPLATE_MAIL_LIST = 2;//批量发送
    const TEMPLATE_MAIL = 1;//模板发送
    const MAIL = 3;//普通发送

    public $create_end_time, $send_end_time;

    /**
     * 状态
     * @return array
     */
    public static function getStatus() {
        return array(
            self::STATUS_SUCCESS => '发送成功',
            self::STATUS_FAILD => '发送失败',
        );
    }

    /**
     * 显示状态
     * @param int $key
     * @return string
     */
    public static function showStatus($key) {
        $status = self::getStatus();
        return isset($status[$key]) ? $status[$key] : null;
    }

    /**
     * 类型
     * @return array
     */
    public static function getType() {
        return array(
            self::EMAIL_SHOP => '商户开店',
            self::EMAIL_ORDER => '新订单',
        );
    }

    /**
     * 显示类型
     * @param int $key
     * @return string
     */
    public static function showType($key) {
        $type = self::getType();
        return isset($type[$key]) ? $type[$key] : null;
    }

    public function tableName() {
        return '{{email_log}}';
    }

    public function rules() {
        return array(
            array('email, content, create_time, type,status', 'required'),
            array('status, count, send_time,create_end_time,send_end_time', 'safe'),
            array('status, count, type', 'numerical', 'integerOnly' => true),
//            array('mobile', 'length', 'max' => 64),
            array('create_time, target_id, send_time', 'length', 'max' => 11),
            array('id, mobile, content, create_time, status, count, target_id, type, send_time', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => '主键',
            'content' => '内容',
            'create_time' => '创建时间',
            'status' => '状态（1发送成功、2发送失败）',
            'count' => '发送次数',
            'type' => '类型（1线上订单、2线下订单、3卡充值、4酒店订单、5验证码）',
            'send_time' => '发送时间',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('count', $this->count);
        $criteria->compare('type', $this->type);


        if ($this->create_time) {
            $criteria->compare('t.create_time', ' >=' . strtotime($this->create_time));
        }
        if ($this->create_end_time) {
            $criteria->compare('t.create_time', ' <' . (strtotime($this->create_end_time)));
        }

        if ($this->send_time) {
            $criteria->compare('t.send_time', ' >=' . strtotime($this->send_time));
        }
        if ($this->send_end_time) {
            $criteria->compare('t.send_time', ' <' . (strtotime($this->send_end_time)));
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder'=>'id DESC', //设置默认排序
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 短信发送
     * @param string $mobile 手机号码
     * @param string $content 短信内容
     * @param int $target 对象
     * @param int $type 短信类型(1线上订单、2线下订单、3卡充值、4酒店订单、5验证码)
     * @return bool
     */
    /*  public static function addSmsLog1($mobile, $content, $target=0, $type=self::TYPE_CAPTCHA, $apiType = null) {
      $smsLog = new SmsLog();
      $smsLog->mobile = $mobile;
      $smsLog->content = $content;
      $smsLog->create_time = time();
      $smsLog->target_id = $target;
      $smsLog->type = $type;
      $result = false;
      if ($smsLog->save(false)) {
      if($apiType === null)
      {
      $apiType = Sms::getSmsApi($smsLog->mobile);			//默认使用短信配置
      }
      $arr = array('id' => $smsLog->id, 'mobile' => $smsLog->mobile, 'content' => $smsLog->content, 'api' => $apiType, 'type' => $type);
      if($type == self::TYPE_CAPTCHA)
      {
      $result = GWRedisList::sendSmsGTCode($arr);
      }
      else
      {
      $result = GWRedisList::sendSmsGT($arr);
      }
      }
      return $result;
      } */

    /*
     * @param string $email   收件人邮箱
     * @param string $content  邮件内容
     * @param string $subject  邮件主题
     * @param array $value  模板替换变量(当使用模板发送用作替换变量时必须为二维数组，当使用普通发送用作邮件正文可以为字符串)
     * @param string $template 模板名称
     * @param string $sendType 发送类型，1、模板，2、批量，3、普通
     * @param int $type     邮件类型
     * @return bool
     */
    public static function addEmailLog($email, $subject, $content,$value, $template, $sendType , $type = self::EMAIL_SHOP) {
        $emailLog = new EmailLog();
        $emailLog->email = $email;
        $emailLog->content = $content;
        $emailLog->create_time = time();
        $emailLog->type = $type;
        $emailLog->status = self::STATUS_FAILD;
        $result = false;
        if ($emailLog->save(false)) {
            $arr = array('id' => $emailLog->id, 'email' => $emailLog->email, 'content' => $emailLog->content, 'type' => $type, 'subject' => $subject, 'value' => $value, 'template' => $template, 'sendType' => $sendType);
            $result = GWRedisList::sendEmailGT($arr);
        }
        return $result;
    }

}
