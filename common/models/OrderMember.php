<?php

/**
 * This is the model class for table "{{order_member}}".
 *
 * The followings are the available columns in table '{{order_member}}':
 * @property string $id
 * @property string $member_id
 * @property string $code
 * @property string $real_name
 * @property integer $sex
 * @property integer $identity_type
 * @property string $identity_number
 * @property string $identity_front_img
 * @property string $identity_back_img
 * @property integer $mobile
 * @property string $street
 * @property string $create_time
 * 
 */
class OrderMember extends CActiveRecord
{
	
	
	public $isExport;   //是否导出excel
	public $exportPageName = 'page'; //导出excel时的分页参数名
	public $exportLimit = 5000; //导出excel长度
	
	
	const MEMBER_SEX_MAN = 1;
	const MEMBER_SEX_WOMAN = 2;
	
	const GOODS_ONE='2320716';
	const GOODS_TWO='2124502';
	const GOODS_THREE='2122140';

	/**
	 * 用户性别
	 * （1男，2女）
	 * @param null $k
	 * @return array|null
	 */
	public static function getMemberSex($k = null) {
	    $arr = array(
	            self::MEMBER_SEX_MAN => Yii::t('orderMember', '男'),
	            self::MEMBER_SEX_WOMAN => Yii::t('orderMember', '女'),
	    );
	    return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
	}
	
	
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{order_member}}';
    }
    

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('code, real_name, sex, identity_number, mobile, street', 'required'),
        	array('identity_front_img, identity_back_img', 'required', 'on' => 'add,insert'),
        	array('identity_number', 'match', 'pattern' => '/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/', 'message' => Yii::t('member', '请输入正确的{attribute}')),
            array('mobile', 'comext.validators.isMobile', 'errMsg' => Yii::t('member', '请输入正确的手机号码')),
            array('create_time', 'length', 'max' => 11),
        	array('member_id', 'required', 'on' => 'insert,update'),
            array('identity_front_img, identity_back_img', 'file', 'types' => 'jpg,gif,png', 'maxSize' => 1024 * 1024 * 1, 'allowEmpty' => true,
                'tooLarge' => Yii::t('orderMember', '{attribute}最大不超过1MB，请重新上传!')),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, code, member_id, sex, identity_number, identity_front_img, identity_back_img, mobile, street, identity_type, create_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        	'member' => array(self::BELONGS_TO, 'Member', 'member_id'),	
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => '主键',
        	'member_id' => 'GW号/手机号',
        	'code' => '订单号',
            'real_name' => '真实姓名',
            'sex' => '性别',
            'identity_number' => '身份证号',
            'identity_front_img' => '身份证正面',
            'identity_back_img' => '身份证反面',
            'mobile' => '联系方式',
            'street' => '联系地址',     
            'create_time' => '录入时间',
        );
    }

    /**
     * @var int 结束时间，搜索用
     */
    public $end_time;

    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.mobile', $this->mobile, true);
        $criteria->compare('t.code', $this->code, true);
        if (!empty($this->sex))   
              $criteria->compare('t.sex', $this->sex);
        $criteria->compare('t.real_name', $this->real_name, true);
        
        $dateTime = Tool::searchDateFormat($this->create_time, $this->end_time);
        $criteria->compare('t.create_time', '>=' . $dateTime['start']);
        $criteria->compare('t.create_time', '<' . $dateTime['end']); 
        $criteria->select = 't.*,m.gai_number as member_id';
        $criteria->join = 'left join {{member}} as m ON (t.member_id=m.id)';
        $criteria->compare('m.gai_number', $this->member_id);   
        
        $pagination = array(
                'pageSize' => 20, //分页
        );
        
        if (!empty($this->isExport)) {
            $pagination['pageVar'] = $this->exportPageName;
            $pagination['pageSize'] = $this->exportLimit;
        }
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        	'pagination' => $pagination,
            'sort' => array(
                'defaultOrder' => 't.id desc'
            ),
        ));
    }
    
    /**
     * 查找一个用户的订单信息
     */
    public function getAllCodeByMid($mid){
    	$criteria = new CDbCriteria(array(
    			'condition'=>'member_id=:mid',
    			'order' => 't.id DESC',
    			'params'=>array(':mid'=>$mid),
    	));
    	$dataProvider = new CActiveDataProvider($this,array(
    	        'criteria'=>$criteria,
    	        'pagination'=>array(
    	                'pageSize'=>20,
    	                'pageVar'=>'page',
    	        ),
    	));
    	return $dataProvider;
     }
     
    /**
     * 根据盖网号或者手机号得到member_id
     * @param string $gaiNumber
     */
    public static function getMemberId($gaiNumber){
    	$member = Member::model()->find(array(
    	        'select'=>'id',
    	        'condition'=>'gai_number=:params or mobile=:params',
    	        'params'=>array(':params'=>$gaiNumber),
    	));
    	if(empty($member)){
    	    return false;
    	}else{
    	    return $member->id;
    	}

    }
    
    /**
     * 检验是否有订单数据
     * @param string $code
     * @param int $mid
     */
    public static function checkCode($code,$mid){       
    	 $orderArr = Order::model()->find(array(
    	        'select'=>'id',
    	        'condition'=>'member_id=:mid AND code=:code AND pay_status=:pstatus',
    	        'params'=>array(':mid'=>$mid,':code'=>$code,':pstatus'=>Order::PAY_STATUS_YES),
    	));
    	return $orderArr;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Cityshow the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
