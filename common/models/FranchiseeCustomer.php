<?php

/**
 *  {{franchisee_customer}} 模型
 *
 * The followings are the available columns in table '{{franchisee_customer}}':
 * @property string $id
 * @property string $target_id
 * @property string $path
 * @property integer $sort
 */
class FranchiseeCustomer extends CActiveRecord {

	public $pageSize;		//分页大小
	/**
     * @var 确认密码
     */
    public $confirmPassword;
    /**
     * @var 旧密码
     */
    public $oldPassword;
    /** @var  新密码 */
    public $newPassword;
	
    public function tableName() {
        return '{{franchisee_customer}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('username, franchisee_id', 'required'),
            array('username', 'unique'),
            array('franchisee_id', 'numerical', 'integerOnly' => true),
            array('franchisee_id', 'length', 'max' => 11),
            array('mobile', 'length', 'max' => 16),
            array('remark', 'length', 'max' => 255),
            array('newPassword,confirmPassword,oldPassword','safe'),
            array('confirmPassword, password', 'required', 'on' => 'modify'),
            array('confirmPassword', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('franchiseeCustomer', '确认密码不正确')),
            array('id, username, franchisee_id, mobile', 'safe', 'on' => 'search'),
        );
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('franchiseeCustomer', '主键id'),
            'username' => Yii::t('franchiseeCustomer', '用户名'),
            'password' => Yii::t('franchiseeCustomer', '密码'),
        	'salt' => Yii::t('franchiseeCustomer','密钥'),
	        'franchisee_id' => Yii::t('franchiseeCustomer', '加盟商id'),
	        'mobile' => Yii::t('franchiseeCustomer', '手机号码'),
            'remark' => Yii::t('franchiseeCustomer', '备注'),
        	'confirmPassword' => Yii::t('franchiseeCustomer', '确认密码'),
        	
        );
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('franchisee_id', $this->franchisee_id);
        $criteria->compare('mobile', $this->mobile , true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => empty($this->pageSize)?20:$this->pageSize, //分页
            ),
            'sort' => array(
            //'defaultOrder'=>' DESC', //设置默认排序
            ),
        ));
    }
    
	public function searchAll() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('franchisee_id', $this->franchisee_id);
        $criteria->compare('mobile', $this->mobile , true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
            'sort' => array(
            //'defaultOrder'=>' DESC', //设置默认排序
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    

    
/**
     * 检测输入的密码是否正确
     * @param string $password
     * @return boolean
     */
    public function validatePassword($password) {
        return CPasswordHelper::verifyPassword($password . $this->salt, $this->password);
    }

    /**
     * 生成的密码哈希.
     * @param string $password
     * @return string $hash
     */
    public function hashPassword($password) {
        return CPasswordHelper::hashPassword($password . $this->salt);
    }

    public function afterFind(){
        $this->oldPassword = $this->password;
    }
    
    public function beforeSave(){
        if(parent::beforeSave()){
            if($this->isNewRecord){
                $this->salt = Tool::generateSalt();
                $this->password = self::hashPassword($this->password);
            }else{
                $this->password = empty($this->password) ? $this->oldPassword : self::hashPassword($this->password);
            }
            return true;
        }else{
            return false;
        }
    }
    
    
    
    
    

}
