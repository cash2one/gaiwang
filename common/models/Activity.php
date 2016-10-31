<?php

/**
 * This is the model class for table "{{activity}}".
 *
 * The followings are the available columns in table '{{activity}}':
 * @property string $id
 * @property string $name
 * @property string $money
 * @property string $sendout
 * @property string $create_time
 * @property integer $mode
 * @property string $valid_end
 * @property integer $type
 * @property integer $status
 * @property string $valid_start
 * @property string $condition
 * @property string $excess
 * @property string $update_time
 * @property integer $check
 * @property string $store_id
 * @property string $thumbnail
 * @property string $start_time
 *
 * The followings are the available model relations:
 * @property Coupon[] $coupons
 */
class Activity extends CActiveRecord
{
    /** @var  string $storeName 店铺名称，搜索用 */
    public $storeName;
    public $gaiMoney,$shopMoney;		//授权金额，商家创建金额
    public $couponTotalStatus;
    //红包模式
    const ACTIVITY_MODE_RED = 1; //红包模式
    const ACTIVITY_MODE_COUPON = 2; //盖惠券模式
    //红包活动类型
    const TYPE_REGISTER = 1;//注册送红包
    const TYPE_SHARE = 2;//分享送红包
    const TYPE_RECHARGE = 3;//充值红包
    const TYPE_VOTE = 4;//投票红包
    const TPYE_SIGNIN = 5;//签到送红包

    const TPYE_LUCK_38 = 6;//抽奖送红包38
    const TPYE_LUCK_88 = 7;//抽奖送红包88
    const TPYE_LUCK_188 = 8;//抽奖送红包188
    const TPYE_LUCK_288 = 9;//抽奖送红包288
    const TPYE_LUCK_520 = 10;//抽奖送红包520
    const TPYE_LUCK_1314 = 11;//抽奖送红包1314
    const TPYE_LUCK_68 = 12;//抽奖送红包68

    //活动状态
    const STATUS_OFF = 0;//活动停止
    const STATUS_ON = 1;//活动开启
    // 审核状态
    const CHECK_WAIT = 0;
    const CHECK_PASSED = 1;
    const CHECK_FAILED = 1;
    
    const LUCK_CACHE_KEY_NAME = 'activity_luck_cache';//插入缓存的时候生成的redis;
    const LUCK_CACHE_BY_MEMBER = 'activity_luck_member';
    
    public function tableName()
    {
        return '{{activity}}';
    }

    public function rules()
    {
        return array(
            array('money, create_time, mode, valid_end, type, status ', 'required'),
            array('valid_start,sendout,condition,excess,check,store_id,thumbnail,start_time','required','on'=>'coupon'), // 盖惠券模式
            array('name','required','on'=>'coupon'),// 盖惠券模式
            array('update_time','required','on'=>'update'),
            array('mode, type, status, check', 'numerical', 'integerOnly' => true),
            array('name, thumbnail', 'length', 'max' => 128),
            array('money', 'numerical'),
            array('sendout, create_time, valid_end, valid_start, condition, excess, update_time, store_id, start_time', 'length', 'max' => 11),
            array('valid_end','checkValidEnd'),
            array('id, name, money, sendout, create_time, mode, valid_end, type, status, valid_start, condition, excess, update_time, check, store_id, thumbnail, start_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * 更新活动截止时间检查
     * @param $attribute
     * @param $params
     */
    public function checkValidEnd($attribute, $params){
        $valid_time = strtotime($this->valid_end);
        if($valid_time < time()){
            $this->addError($attribute,Yii::t('redEnvelopeActivity', '红包活动时间不能少于现在时间'));
        }
    }

    /**
     * 活动类型
     * 1:注册送红包,2:分享送红包
     * @param null $k
     * @return array|null
     */
    public static function getType($k = null)
    {
        $arr = array(
            self::TYPE_REGISTER => Yii::t('activity', '注册送红包'),
            self::TYPE_SHARE => Yii::t('activity', '分享送红包'),
             self::TYPE_RECHARGE => Yii::t('activity', '充值红包'),
             self::TYPE_VOTE => Yii::t('activity', '投票红包'),
            self::TPYE_SIGNIN=> Yii::t('activity', '签到红包'),
            self::TPYE_LUCK_38=> Yii::t('activity', '抽奖红包38'),
            self::TPYE_LUCK_68=> Yii::t('activity', '抽奖红包68'),
            self::TPYE_LUCK_88=> Yii::t('activity', '抽奖红包88'),
            self::TPYE_LUCK_188=> Yii::t('activity', '抽奖红包188'),
            self::TPYE_LUCK_288=> Yii::t('activity', '抽奖红包288'),
            self::TPYE_LUCK_520=> Yii::t('activity', '抽奖红包520'),
            self::TPYE_LUCK_1314=> Yii::t('activity', '抽奖红包1314'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }

    /**
     * 活动状态
     * @param null $k
     * @return array|null
     */
    public static function getStatus($k = null)
    {
        $arr = array(
            self::STATUS_ON => Yii::t('activity', '活动开启'),
            self::STATUS_OFF => Yii::t('activity', '活动停止'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }

    /**
     * 开启的红包活动
     * @param null $k
     * @return array|null
     */
    public static function getStartActivityType($k = null)
    {
        $arr = Yii::app()->db->createCommand()
            ->select('id,type')
            ->from('{{activity}} as t')
            ->where('mode=:mode and status=:status and valid_end>:valid_end',array(':mode'=>self::ACTIVITY_MODE_RED,':status'=>self::STATUS_ON,':valid_end'=>time()))
            ->queryAll();
        $newArr = array();
        if($arr){
            foreach($arr as $v){
                $val = self::getType($v['type']);
                if(!is_array($val))
                    $newArr[$v['type']] = $val;
            }
        }
        return is_numeric($k) ? (isset($newArr[$k]) ? $newArr[$k] : null) : $newArr;
    }


    /**
     * 审核状态
     * @param null $key
     * @return array
     */
    public static function getCheck($key = null){
        $arr = array(
            self::CHECK_WAIT => Yii::t('activity', '审核中'),
            self::CHECK_PASSED => Yii::t('activity', '审核通过'),
            self::CHECK_FAILED => Yii::t('activity', '审核不通过'),
        );
        return $key == null ? $arr : $arr[$key];
    }

    public function relations()
    {
        return array(
            'coupons' => array(self::HAS_MANY, 'Coupon', 'activity_id'),
            'store' => array(self::BELONGS_TO, 'Store', 'store_id'),
        );
    }

    protected  function  beforeSave(){
        if(parent::beforeSave()){
            $this -> valid_end = strtotime($this->valid_end);
            return true;
        }else
            return false;
    }

    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('activity',  '主键'),
            'name' => Yii::t('activity', '名称'),
            'money' => Yii::t('activity', '面值'),
            'sendout' => Yii::t('activity', '发行量'),
            'create_time' => Yii::t('activity', '创建时间'),
            'mode' => Yii::t('activity', '模式'),
            'valid_end' => Yii::t('activity', '派发截止时间'),
            'type' => Yii::t('activity', '类型'),
            'status' => Yii::t('activity', '状态'),
            'valid_start' => Yii::t('activity', '开始有效时间'),
            'condition' => Yii::t('activity', '使用条件'),
            'excess' => Yii::t('activity', '剩余量'),
            'update_time' => Yii::t('activity', '更新时间'),
            'check' => Yii::t('activity', '审核'),
            'store_id' => Yii::t('activity', '所属店铺'),
            'thumbnail' => Yii::t('activity', '代表图'),
            'start_time' => Yii::t('activity', '活动开始时间'),
            'storeName' => Yii::t('activity', '店铺名称')
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('money', $this->money);
        $criteria->compare('sendout', $this->sendout);
        $criteria->compare('create_time', $this->create_time);
        $criteria->compare('mode', $this->mode);
        $criteria->compare('type', $this->type);
        $criteria->compare('valid_start', $this->valid_start);
        $criteria->compare('condition', $this->condition);
        $criteria->compare('update_time', $this->update_time);
        $criteria->compare('check', $this->check);
        $criteria->compare('store_id', $this->store_id);
        $criteria->compare('thumbnail', $this->thumbnail);
        $criteria->compare('start_time', $this->start_time);

        if($this->couponTotalStatus === self::COUPON_TOTAL_STATUS_OFF){
            $criteria->addCondition('valid_end<' . time() .' OR status='. Activity::STATUS_OFF . ' OR excess<1');
        }elseif($this->couponTotalStatus == self::COUPON_TOTAL_STATUS_ON){
            $criteria->compare('valid_end', ">=" . time());
            $criteria->compare('status', Activity::STATUS_ON);
            $criteria->compare('excess', ">0");
        }else{
            $criteria->compare('excess', $this->excess);
            $criteria->compare('status', $this->status);
            $criteria->compare('valid_end', $this->valid_end);
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Activity the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    // 盖惠券状态
    const COUPON_TOTAL_STATUS_OFF = 0;
    const COUPON_TOTAL_STATUS_ON = 1;
    public static function getActivityCouponStatus($key = null){
        $arr = array(
            '' => Yii::t('activity', '全部'),
            self::COUPON_TOTAL_STATUS_OFF => Yii::t('activity', '已领完'),
            self::COUPON_TOTAL_STATUS_ON => Yii::t('activity', '领取中'),
        );
        return $key === null ? $arr : $arr[$key];
    }

    /**
     * 获取当前记录的盖惠券状态
     */
    public function getActivityCouponStatusString(){
        if($this->valid_end >= time() && $this->status == Activity::STATUS_ON && $this->excess){
            echo self::getActivityCouponStatus(self::COUPON_TOTAL_STATUS_ON);
        }else{
            echo self::getActivityCouponStatus(self::COUPON_TOTAL_STATUS_OFF);
        }
    }

}
