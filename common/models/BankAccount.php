<?php

/**
 *  会员银行账号 模型
 *  @author zhenjun_xu <412530435@qq.com>
 * The followings are the available columns in table '{{bank_account}}':
 * @property string $id
 * @property string $member_id
 * @property string $account_name
 * @property string $province_id
 * @property string $city_id
 * @property string $district_id
 * @property string $street
 * @property string $bank_name
 * @property string $account
 * @property string $licence_image
 *
 */
class BankAccount extends CActiveRecord {

    public function tableName() {
        return '{{bank_account}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('account_name, bank_code,bank_name, account,licence_image', 'required', 'on' => 'insert'),
            array('account_name, bank_code,bank_name, account', 'required', 'on' => 'enterpriseLog,enterpriseLog2'),
            array('licence_image','required','on'=>'enterpriseLog'),
            array('account_name, bank_code, bank_name, account', 'required', 'on' => 'update'),
            //不做限制了
//                        array('account_name','match','pattern'=>'/([\s]+)/','message'=>'含有非法字符'),
//            array('bank_name', 'match', 'pattern' => '/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u'),
//            array('bank_name', 'match', 'pattern' => '/[\(|（][\s|\S]+[\)|）]/'),  //匹配含有括号、带中文输入法括号的字符  
//            array('account_name', 'match', 'pattern' => '/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u'),
//            array('account_name', 'match', 'pattern' => '/[\(|（][\s|\S]+[\)|）]/'),
            array('account', 'match', 'pattern' => '/^[0-9]*[0-9]*$/'),
            array('member_id', 'length', 'max' => 11),
            array('account_name, bank_name, account', 'length', 'max' => 128),
            array('licence_image,province_id,city_id,district_id', 'safe'),
            array('id, member_id, account_name,  bank_code, bank_name, account,licence_image', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'Member' => array(self::BELONGS_TO, 'Member', 'member_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('bankAccount', '主键'),
            'member_id' => Yii::t('bankAccount', '所属会员'),
            'account_name' => Yii::t('bankAccount', '银行开户名'),
            'province_id' => Yii::t('bankAccount', '省份'),
            'city_id' => Yii::t('bankAccount', '城市'),
            'district_id' => Yii::t('bankAccount', '区/县'),
//			'street' => Yii::t('bankAccount','详细地址'),del
            'bank_name' => Yii::t('bankAccount', '开户银行支行名称'),
        	'bank_code' => Yii::t('bankAccount', '开户所属银行'),	
            'account' => Yii::t('bankAccount', '公司银行账号'),
            'licence_image' => Yii::t('bankAccount', '开户银行许可证电子版'),
//			'sister_bank_number' => Yii::t('bankAccount','支行联行号'), delete
        );
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('member_id', $this->member_id, true);
        $criteria->compare('account_name', $this->account_name, true);
        $criteria->compare('province_id', $this->province_id, true);
        $criteria->compare('city_id', $this->city_id, true);
        $criteria->compare('district_id', $this->district_id, true);
        $criteria->compare('street', $this->street, true);
        $criteria->compare('bank_name', $this->bank_name, true);
        $criteria->compare('account', $this->account, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20, //分页
            ),
            'sort' => array(
            //'defaultOrder'=>' DESC', //设置默认排序
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * 银行列表
     */
    public static function bankList($key=''){
    	$bankList=array(
    			'102'=>'中国工商银行',
    			'103'=>'中国农业银行',
    			'105'=>'中国建设银行',
    			'104'=>'中国银行',
    			'308' =>'招商银行',
    			'303' =>'中国光大银行',
    			'301'=>'交通银行',
    			'302'=> '中信银行',
    			'304' =>'华夏银行',
    			'305' =>'中国民生银行',
    			'306' =>'广东发展银行',
    			'307' =>'深圳发展银行',
    			'309' =>'兴业银行',
    			'310' =>'上海浦东发展',
    			'317' =>'农村合作银行',
    			'315' =>'恒丰银行',
    			'313' =>'城市商业银行',
    			'403' =>'中国邮政储蓄银行',
    			'401' =>'城市信用社',
    			'402' =>'农村信用社（含北京农村商业银行）',
    			'501' =>'汇丰银行',
    			'502' =>'东亚银行',
    			'503' =>'南洋商业银行',
    			'504' =>'恒生银行(中国)有限公司',
    			'505' =>'中国银行（香港）有限公司',
    	);
    	if($key){
    		return $bankList[$key];
    	}else{
    		return $bankList;
    	}
    }

}
