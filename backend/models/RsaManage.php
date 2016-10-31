<?php
class RsaManage extends CActiveRecord{
	/**
	 * @return string the associated database table name
	 */
	const Status_YES = 1;
	const Status_NO = 0;
	
	public $id;
	public $merchant_num;
	public $status;
	public $public_key;
	public $private_key;
	public $create_time;
	public $update;
	public $user_id;
	
	public function tableName()
	{
		return '{{rsa_manage}}';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('merchant_num, status,create_time,update', 'required'),
				array('merchant_num', 'length', 'max'=>32),
				array('status', 'length', 'max'=>2),
				array('create_time,update', 'length', 'max'=>11),
				// The following rule is used by search().
				// @todo Please remove those attributes that should not be searched.
				array('id, merchant_num, public_key,private_key,status,create_time,update', 'safe', 'on'=>'search'),
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
		);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'id' => '主键id',
				'merchant_num' => '商户号',
				'status' => '状态',
				'public_key' => '公钥',
				'private_key' => '私钥',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
	
		$criteria=new CDbCriteria;
		$criteria->select = 'id,merchant_num';
		$criteria->compare('id',$this->id);
		$criteria->compare('merchant_num',$this->merchant_num,true);

	
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RegionManage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	/**
	 * 创建按钮
	 */
	public static function createButtons($id) {
		$string = "";
		if (Yii::app()->user->checkAccess('RegionManage.Create'))
			$string .= "<a class=\"regm-sub\" href=\"javascript:CreateKey({$id})\">生成秘钥</a>";
		if (Yii::app()->user->checkAccess('RegionManage.Delete'))
			$string .= "<a class=\"regm-sub\" href=".Yii::app()->createUrl("/RsaManage/Delete",array("id"=>$id)).">删除</a>";
		if (Yii::app()->user->checkAccess('RegionManage.View'))
			$string .= "<a class=\"regm-sub\" href=".Yii::app()->createUrl("/RsaManage/View",array("id"=>$id)).">查看</a>";
		if (Yii::app()->user->checkAccess('RegionManage.Export'))
			$string .= "<a class=\"regm-sub\" href=".Yii::app()->createUrl("/RsaManage/Export",array("id"=>$id)).">导出秘钥</a>";
		return $string;
	}
	
	
	/**
	 * 创建rsa公钥和密钥
	 * return array 包含公钥和密钥的数组
	 */
	public static function createRsaKey(){
		//参数配置，不过感觉没用
		$config = array(
				'private_key_bits' => 2048,
				'private_key_type' => OPENSSL_KEYTYPE_RSA,
		);
	
		//创建公钥密钥中间变量
		$tmp = openssl_pkey_new($config);
	
		//如果中间变量生成成功
		if ($tmp) {
			//根据中间变量生成私钥
			openssl_pkey_export($tmp, $privateKey);
	
			//根据中间变量生成公钥
			$publicKey = openssl_pkey_get_details($tmp);
			$publicKey = $publicKey['key'];
		} else {
			var_dump(openssl_error_string());
			Yii::app()->end();
		}
	
		//去掉开头和结尾,根据实际情况截取
		$publicKeyApk = substr($publicKey, 27, -26);		//-----BEGIN PUBLIC KEY-----  和-----END PUBLIC KEY-----
		return array('privateKey'=>$privateKey, 'publicKey'=>$publicKey, 'publicKeyApk' => $publicKeyApk);
	}
}