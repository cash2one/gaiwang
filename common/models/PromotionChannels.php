<?php

/**
 * This is the model class for table "gw_promotion_channels".
 *
 * The followings are the available columns in table 'gw_promotion_channels':
 * @property string $id
 * @property string $name
 * @property string $number
 * @property string $new_members
 * @property string $visits
 * @property string $remark
 * @property string $url
 * @property integer $register_type
 * @property string $create_time
 * @property string $update_time
 */

class PromotionChannels extends CActiveRecord
{
    /*
    **
    * 获取系统类型
    * @return array
    */
    const REGISTER_TYPE_NORMAL = 1;//普通注册
    const REGISTER_TYPE_RED = 2;//红包注册
    const REGISTER_TYPE_MSHOP_NORMAL = 4;//红包注册
    const REGISTER_TYPE_MSHOP_RED = 5;//红包注册
    
    public static function getLoginType($key = false) {
    $status = array(
                self::REGISTER_TYPE_NORMAL => '普通注册',
                self::REGISTER_TYPE_RED => '红包注册',
                self::REGISTER_TYPE_MSHOP_NORMAL => '普通注册-移动端',
                self::REGISTER_TYPE_MSHOP_RED => '红包注册-移动端',
		);
            if ($key === false)
                return $status;
    		return $status[$key];
    	}

    	/**
    	 * 推广注册类型
    	 * @param string $key
    	 * @return multitype:string |Ambigous <string>
    	 */
   public static function getRigisterType($key = false) {
    	    $status = array(
    	            self::REGISTER_TYPE_NORMAL => 'http://member.'.SHORT_DOMAIN.'/home/register',
    	            self::REGISTER_TYPE_RED => 'http://hongbao.'.SHORT_DOMAIN.'/site/registerCoupon',
    	            self::REGISTER_TYPE_MSHOP_NORMAL => 'http://m1.'.SHORT_DOMAIN.'/home/register',
    	            self::REGISTER_TYPE_MSHOP_RED => 'http://m1.'.SHORT_DOMAIN.'/home/receiveRedBag',
    	    );
    	    if ($key === false)
    	        return $status;
    	    return $status[$key];
    	}
    	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{promotion_channels}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, number,register_type, create_time, update_time', 'required'),
			array('register_type', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>128),
			array('number', 'length', 'max'=>8),
			array('new_members, visits,start_time,end_time,create_time, update_time', 'length', 'max'=>11),
			array('remark, url', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, number, new_members, visits, remark, url,start_time,end_time,register_type, create_time, update_time', 'safe', 'on'=>'search'),
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
			'id' => '主键',
			'name' => '渠道名称',
			'number' => '推广编号',
			'new_members' => '新会员数',
			'visits' => '访问数',
			'remark' => '渠道网址备注',
			'url' => '推广网址',
		    'start_time'=>'推广开始时间',
		    'end_time'=>'推广结束时间',
			'register_type' => '注册类型',
			'create_time' => '创建时间',
			'update_time' => '更新时间',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('number',$this->number,true);
		$criteria->compare('new_members',$this->new_members,true);
		$criteria->compare('visits',$this->visits,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('register_type',$this->register_type);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		    'sort' => array(
		            'defaultOrder'=>'id DESC', //设置默认排序
		        ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GwPromotionChannels the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * 创建会员加入会员渠道
	 */
	public static function addMemberFromPromotion($member_id,$number)
	{
	    $table = self::model()->tableName();
	    $db = Yii::app()->db;
	    $channel = $db->createCommand()
                    ->select('id')
                    ->from($table)
                    ->where('number=:number',array(':number'=>$number))
                    ->queryRow();
	    if(empty($channel)) return;
	    $insertSql = "insert into {{member_exten}} (`member_id`,`promotion_id`) value ( {$member_id} , {$channel['id']})";
	    $db->createCommand($insertSql)->execute();
	    $updateSql = "update {$table} set new_members = new_members+1 where id = {$channel['id']}";
	    $db->createCommand($updateSql)->execute();
	    return ;
	}
}
