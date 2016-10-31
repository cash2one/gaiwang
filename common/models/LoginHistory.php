<?php

/**
 * 会员登录记录
 *
 * The followings are the available columns in table '{{login_history}}':
 * @property string $member_id
 * @property string $create_time
 * @property string $ip
 * @author huabin_hong
 */
class LoginHistory extends CActiveRecord
{
	
	public $gai_number,$username;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{login_history}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id, create_time, ip', 'required'),
			array('member_id, create_time, ip', 'length', 'max'=>11),
			array('member_id, create_time, ip', 'safe', 'on'=>'search'),
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
			'member_id' => Yii::t('LoginHistory','会员编号'),
			'gai_number' => Yii::t('LoginHistory','会员编码'),
			'username' => Yii::t('LoginHistory','登录名称'),
			'create_time' => Yii::t('LoginHistory','登陆时间'),
			'ip' => 'IP',
		);
	}

	/**
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$memberTable = Member::model()->tableName();
		$criteria->select = "b.username,b.gai_number,FROM_UNIXTIME(t.create_time,'%Y-%m-%d %H:%i:%s') as create_time,t.ip";
		$criteria->join = "left join $memberTable b on b.id = t.member_id";
		$criteria->compare('create_time',">=".$this->create_time);
		$criteria->compare('create_time',"<=".($this->create_time+86399));

		return new CActiveDataProvider($this,array(
    		'criteria' => $criteria,
    	 	'pagination' => array(
                'pageSize' => 9, //分页
            ),
            'sort' => false,
    	));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LoginHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * 添加登录记录
     * @param null $memberId
     * @return bool
     */
    public static function create($memberId = null){
        $model = self::model();
        $model->isNewRecord = true;
        $model->create_time = time();
        $model->ip = Tool::ip2int(Yii::app()->request->userHostAddress);
        $model->member_id = !empty($memberId) ? $memberId : Yii::app()->user->id;
        return $model->save();
    }

}
