<?php

/**
 * This is the model class for table "{{agent_maintenance}}".
 *
 * The followings are the available columns in table '{{agent_maintenance}}':
 * @property string $id
 * @property string $password
 * @property string $parent_member_id
 * @property integer $create_time
 */
class AgentMaintenance extends CActiveRecord
{
	public $GWnumber;
	public $username;
	public $mobile;
	protected static $prefix = 'GXA';//token缓存前缀 (这里的前缀是包括所有的，redis存放，checkcode前缀，不要改超过5字库的)
	protected static $cache = 'redis'; //token缓存类型
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{agent_maintenance}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('member_id, password, parent_member_id, create_time', 'required'),
			array('member_id, create_time', 'numerical', 'integerOnly'=>true),
			array('password', 'length', 'max'=>32),
			array('member_id', 'unique', 'message' => Yii::t('AgentMaintenance', '该GW号已被绑定！')),
			array('parent_member_id', 'length', 'max'=>11),
			array('id, member_id, password, parent_member_id, create_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @param $GWNo 盖网号
	 * 判断盖网号是否已绑定
	 */
	public static function isBindMember($GWNo){
		$result = Yii::app()->db->createCommand()
						->select('m.gai_number')
						->from(AgentMaintenance::model()->tableName() . ' as am')
						->leftJoin(Member::model()->tableName() . ' as m', ' am.member_id = m.id')
						->where('m.gai_number = :GWNo',array(':GWNo'=>$GWNo))
						->queryScalar();
		if(empty($result)) return true;
		else return false;
	}
	
	/**
	 * 判断盖网号是否存在、状态是否正常
	 */
	public static function isGwNumber($GWNo){
		$result = Yii::app()->db->createCommand()
						->select('id,username,mobile')
						->from(Member::model()->tableName())
						->where('gai_number = :GWNo' , array(':GWNo' => $GWNo))
						->queryRow();
		if(!empty($result)) return $result;
		else return false;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'member_id' => 'Member',
			'GWnumber' => Yii::t('AgentMaintenance','盖网号'),
			'username' => Yii::t('AgentMaintenance','用户名'),
			'password' => Yii::t('AgentMaintenance','密码'),
			'mobile' => Yii::t('AgentMaintenance','联系电话'),
			'parent_member_id' => 'Parent Member',
			'create_time' => Yii::t('AgentMaintenance','创建时间'),
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
		$criteria=new CDbCriteria;
		$criteria->select = 'm.gai_number as GWnumber,m.mobile,m.username,t.id,t.create_time';
		$criteria->join = ' left join ' . Member::model()->tableName() . ' as m on t.member_id = m.id';
		$criteria->addCondition('t.parent_member_id = ' . $this->parent_member_id);
		$criteria->order = 't.create_time desc';
		$criteria->compare('m.username',$this->username,true);
		$criteria->compare('m.gai_number',$this->GWnumber);
		$criteria->compare('m.mobile',$this->mobile,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
				'pageSize' => 10
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AgentMaintenance the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 创建重设密码，解绑按钮
	 */
	public static function createButtons($id) {
		$string = "";
		$string .= "<a class='tc' href='javascript:resetPwd(" . $id . ")'>【重设密码】</a>";
//		$string .= "<a class='tc' href='javascript:resetBind(" . $id . ")'>【解除绑定】</a>";
		return $string;
	}

	/**
	 * 删除token
	 * @param $memberId
	 * @return bool
	 */
	public static function deleteToken($tokenId) {
		$memberIdKey = self::$prefix . ':tokenId:' . $tokenId . ':memberId';
		if($memberId = self::getCache($memberIdKey)){
			$tokenIdKey = self::$prefix . ':memberId:' . $memberId . ':tokenId';
			self::delCache($tokenIdKey);
		}
		self::delCache($memberIdKey);
		Yii::app()->db->createCommand()->delete('{{member_token}}','token=:token',array(':token'=>$tokenId));
		return true;
	}

	/**
	 * 获取缓存
	 * @param str $key
	 * @return Ambigous <mixed, boolean, string>
	 */
	protected static function getCache($key)
	{
		$cache = self::$cache;
		return Yii::app()->$cache->get($key);
	}

	/**
	 * 删除缓存
	 * @param str $key
	 * @return boolean
	 */
	protected static function delCache($key)
	{
		$cache = self::$cache;
		return Yii::app()->$cache->delete($key);
	}
}
