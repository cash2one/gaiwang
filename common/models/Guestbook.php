<?php

/**
 * This is the model class for table "{{guestbook}}".
 *
 * The followings are the available columns in table '{{guestbook}}':
 * @property string $id
 * @property string $pid
 * @property string $owner
 * @property string $owner_id
 * @property string $email
 * @property string $content
 * @property string $member_id
 * @property string $gai_number
 * @property string $ip
 * @property string $create_time
 * @property string $reply_content
 * @property string $reply_id
 * @property string $reply_username
 * @property string $reply_ip
 * @property string $reply_time
 * @property integer $status
 * @property string $description
 */
class Guestbook extends CActiveRecord {

    public $reply;
    public $goodsName;
    public $template = '会员{0}咨询商品{1}相关信息';
    public $verifyCode; // 验证码

/////////////////////旧////////////////

    const STATUS_NOT_READ = 0;      //未读
    const STATUS_READED = 1;        //已读
    const STATUS_NOT_CONFIRM = 2;   //未审核
    const STATUS_PASS_CONFIRM = 3;  //审核通过
    const STATUS_FAIL_CONFIRM = 4;  //审核未通过
//////////////////////////////////////
    const OWNER_FRANCHISEE = 0; //  加盟商
    const OWNER_GOODS = 1;  // 商品
    const STATUS_UNREAD = 0; // 未读
    const STATUS_READ = 1;  // 已读
    const STATUS_AUDIT = 2; // 未审核
    const STATUS_THROUGH = 3;   // 审核通过   
    const STATUS_NOTTHROUGH = 4;    // 审核不通过
    const STATUS_ALL = 5;    // 全部

    /**
     * 留言状态
     * 0未读，1已读，2未审核,3审核通过,4审核不通过
     * @param null $k
     * @return array|null
     */

    public static function status($k = null) {
        $arr = array(
            self::STATUS_ALL => Yii::t('guestbook', '全部'),
            self::STATUS_UNREAD => Yii::t('guestbook', '未读'),
            self::STATUS_READ => Yii::t('guestbook', '已读'),
            self::STATUS_AUDIT => Yii::t('guestbook', '未审核'),
            self::STATUS_THROUGH => Yii::t('guestbook', '审核通过'),
            self::STATUS_NOTTHROUGH => Yii::t('guestbook', '审核不通过'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }

    const UNREPLY = 0; // 未回复
    const REPLY = 1;  // 已回复
    const ALL = 2;  // 全部

    /**
     * 是否回复
     * 0未回复，1已回复
     * @param null $k
     * @return array|null
     */

    public static function isReply($k = null) {
        $arr = array(
            self::ALL => Yii::t('guestbook', '全部'),
            self::UNREPLY => Yii::t('guestbook', '未回复'),
            self::REPLY => Yii::t('guestbook', '已回复'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{guestbook}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('content', 'required', 'on' => 'insert,validationCode'),
            array('content', 'safe'),
            array('reply_content, status', 'required', 'on' => 'update'),
            array('status', 'numerical', 'integerOnly' => true),
            array('pid, owner, owner_id, member_id, ip, create_time, reply_id, reply_ip, reply_time', 'length', 'max' => 11),
            array('email, reply_username', 'length', 'max' => 128),
            array('gai_number', 'length', 'max' => 32),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, pid, owner, owner_id, email, content, member_id, gai_number, ip, create_time, reply_content, reply_id, reply_username, reply_ip, reply_time, status, description', 'safe', 'on' => 'search'),
            // 留言验证
            array('verifyCode', 'comext.validators.requiredExt', 'allowEmpty' => !CCaptcha::checkRequirements(),
                'message' => Yii::t('guestbook', '{attribute} 不能为空！'), 'on' => 'validationCode'),
            array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements(), 'on' => 'validationCode'),
            array('content,reply_content','filter','filter'=>array($ogj=new CHtmlPurifier(),'purify')),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'goods' => array(self::BELONGS_TO, 'Goods', 'owner_id'),
            'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'pid' => 'Pid',
            'owner' => 'Owner',
            'owner_id' => Yii::t('guestbook', '商品'),
            'email' => 'Email',
            'content' => Yii::t('guestbook', '咨询内容'),
            'member_id' => 'Member',
            'gai_number' => Yii::t('guestbook', '留言者'),
            'ip' => 'Ip',
            'create_time' => Yii::t('guestbook', '时间'),
            'reply_content' => Yii::t('guestbook', '回复内容'),
            'reply_id' => 'Reply',
            'reply_username' => 'Reply Username',
            'reply_ip' => 'Reply Ip',
            'reply_time' => 'Reply Time',
            'status' => Yii::t('guestbook', '状态'),
            'description' => Yii::t('guestbook', '标题'),
            'reply' => Yii::t('guestbook', '是否回复'),
            'goodsName' => Yii::t('guestbook', '商品名称'),
            'verifyCode' => Yii::t('guestbook', '验证码'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->condition = 't.owner = ' . self::OWNER_GOODS;
        $criteria->compare('t.gai_number', $this->gai_number, false);

        if ($this->status != self::STATUS_ALL) {
            $criteria->compare('t.status', $this->status);
        }

        if ($this->reply != self::ALL) {
            $symbol = $this->reply == self::REPLY ? '<>' : '=';
            $criteria->condition .= " AND t.reply_content {$symbol} ''";
        }


        if (isset($this->goodsName)) {
            $criteria->with = 'goods';
            $criteria->compare('goods.name', $this->goodsName, true);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.create_time DESC', // 设置质询时间为倒序
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Guestbook the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

//    protected function beforeSave() {
//
//        if (parent::beforeSave()) {
//            
//            $this->reply_id = Yii::app()->user->id;
//            $this->reply_username = Yii::app()->user->name;
//            $this->reply_ip = Tool::ip2int(Yii::app()->request->userHostAddress);
//            $this->reply_time = time();
//
//            return true;
//        }
//    }

    protected function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {


                if (Yii::app()->user->id) {
                    $this->member_id = Yii::app()->user->id;
                    $this->gai_number = Yii::app()->user->getState('gw');
                } else {
                    $this->gai_number = '游客';
                }

                $this->ip = Tool::ip2int(Yii::app()->request->userHostAddress);
                $this->create_time = time();
            } else {
                $this->reply_id = Yii::app()->user->id;
                $this->reply_username = Yii::app()->user->name;
                $this->reply_ip = Tool::ip2int(Yii::app()->request->userHostAddress);
                $this->reply_time = time();
            }
            return true;
        }
        else
            return false;
    }

}
