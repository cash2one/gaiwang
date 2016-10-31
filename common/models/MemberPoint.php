<?php

/**
 * This is the model class for table "{{member_point}}".
 *
 * The followings are the available columns in table '{{member_point}}':
 * @property string $id
 * @property integer $member_id
 * @property integer $grade_id
 * @property string $day_limit_point
 * @property string $month_limit_point
 * @property string $create_time
 * @property string $update_time
 * @property integer $admin
 * @property integer $special_type
 */
class MemberPoint extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{member_point}}';
	}
	
	const SPECIAL_TYPE_AUTO = 0;  //自动生成
	const SPECIAL_TYPE_MANUAL = 1; //人工生成
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('month_point,day_point', 'required'),
			array('member_id', 'required','on'=>'create'),
			array('member_id', 'unique'),
			array('admin,special_type', 'numerical', 'integerOnly'=>true),
			array('day_point, month_point', 'length', 'max'=>11),
			array('day_limit_point, month_limit_point,month_point,day_point', 'numerical'),
			array('day_limit_point, month_limit_point,month_point,day_point', 'match', 'message' => '只能为非负数字，保留两位小数', 'pattern' => '/^\d+\.*\d{0,2}$/'), //验证			
			array('create_time, update_time', 'length', 'max'=>11),
			array('day_point', 'verifyPointMax'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, member_id, special_type,grade_id, day_limit_point, month_limit_point, create_time, update_time,day_point,month_point, admin', 'safe', 'on'=>'search'),
		);
	}
	
	
	
	/**
	 * 判断月可用不可小于日可用
	 * @param unknown $attribute
	 * @param unknown $params
	 */
	public  function verifyPointMax($attribute, $params){
		if($this->month_point!=''){
			if(bcsub($this->day_point,$this->month_point,2) > 0){
				$this->addError($attribute, Yii::t('memberPoint', '日额度不能大于月额度'));
			 }
		}
	}
	

	/**
	 * 
	 * @param unknown $k
	 */
	public static function getType($key){
		$arr = array(
				self::SPECIAL_TYPE_AUTO => Yii::t('memberPoint', '否'),
				self::SPECIAL_TYPE_MANUAL => Yii::t('memberPoint', '是'),
		);
		if (is_numeric($key)) {
			return isset($arr[$key]) ? $arr[$key] : null;
		} else {
			return $arr;
		}
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
			'id' => 'ID',
			'member_id' => '会员GW号',
			'grade_id' => '会员等级',
			'day_limit_point' => '日可用额度',
			'month_limit_point' => '月可用额度',
			'day_point' => '日额度',
			'month_point' => '月额度',
			'create_time' => '创建时间',
			'update_time' => '更新时间',
			'admin' => '创建人',
			'special_type' => '是否人工更改'
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
		//$criteria->compare('member_id',$this->member_id);
		$criteria->compare('t.grade_id',$this->grade_id);
		$criteria->compare('t.special_type',$this->special_type);
		$criteria->compare('day_limit_point',$this->day_limit_point,true);
		$criteria->compare('month_limit_point',$this->month_limit_point,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('admin',$this->admin);
		
		$criteria->select = 't.*,m.gai_number as member_id,p.grade_name as grade_id';
		$criteria->join = ' left join {{member}} as m ON (t.member_id=m.id)';
		$criteria->join .= ' left join {{member_point_grade}} as p ON (t.grade_id=p.id)';
		$criteria->compare('m.gai_number', $this->member_id,true);	
		//$criteria->compare('t.grade_id', $this->grade_id);

		//var_dump($criteria);die();
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}	
	
	/**
	 * 根据会员ID，得到一条数据
	 * @param int $mid 会员ID
	 */
	public static function getOneInfo($mid){
		return Yii::app()->db->createCommand()
		->select('*')
		->from('{{member_point}}')
		->where('member_id=:mid',array(':mid'=>$mid))
		->queryRow();
	}
	
	/**
	 * 根据会员ID和会员余额判断会员可用余额
	 * @param int $mid 会员ID
	 * @param decimal $memTotalMoney 会员余额
	 * @return Ambigous <unknown, mixed>
	 */
	public static function getMemberPoint($mid,$memTotalMoney){
		$dayLimitMoney='';
		$mouthLimitMoney='';
		$dataArr=array();
		$memberPointArr=self::getOneInfo($mid);
		$pointArr=MemberPointGrade::getGradeInfo($memTotalMoney);
		if(empty($pointArr)){
			$pointArr['dayLimitMoney']=$memTotalMoney;
			return $pointArr;
		}//如果没有配置信息，则积分配置不生效
		//if(isset($memberPointArr['special_type']) && $memberPointArr['special_type']==MemberPoint::SPECIAL_TYPE_MANUAL){//判断是否是特殊会员，手动改动的，不在配置内
        if(!empty($memberPointArr)){
		     $pointArr['month_usable_point']=$memberPointArr['month_point'];
			 $pointArr['day_usable_point']=$memberPointArr['day_point'];
		}
		if(empty($memberPointArr)){
			$dataArr['flag']=false;//不存在用户，需新插入
		    $dayLimitMoney=$pointArr['day_usable_point'];
		    $dataArr['info']=$pointArr;  
		    $dataArr['dayLimitMoney']=$dayLimitMoney;
		}else{
			$dataArr['flag']=true;//已存在用户，需更新
			$uptimeStr=$memberPointArr['update_time'];//最后一次数据更新的时间
			if(date('Y') == date('Y',$uptimeStr)){//同年时判断
			 if(date('m') > date('m',$uptimeStr)){//新月时，更新
		        $mouthLimitMoney=$pointArr['month_usable_point'];
		        $dayMoney=$pointArr['day_usable_point'];
			  }else{	
			    $mouthLimitMoney=$memberPointArr['month_limit_point'];
			    if(date('d') > date('d',$uptimeStr)){//新的一天更新
			       $dayMoney=$pointArr['day_usable_point'];
			     }else{
			       $dayMoney=$memberPointArr['day_limit_point'];
			     }
			   }
			 }else if(date('Y') > date('Y',$uptimeStr)){//新年时都更新
			 	$mouthLimitMoney=$pointArr['month_usable_point'];
			 	$dayMoney=$pointArr['day_usable_point'];
			 }else{//表示异常
			 	$mouthLimitMoney=0;
			 	$dayMoney=0;
			 }
			 $memberPointArr['day_limit_point']=$dayMoney;
			 $memberPointArr['month_limit_point']=$mouthLimitMoney;
		     $dataArr['info']=$memberPointArr;
		     if($mouthLimitMoney >= 0 && $dayMoney >= $mouthLimitMoney){
		        $dayMoney=$mouthLimitMoney;
		     }
		    $dataArr['dayLimitMoney']=$dayMoney;
		}
		return $dataArr;
	}
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GwMemberPoint the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
// 	public function beforeSave() {
// 	    if (parent::beforeSave()) {
	        
	    	
	    	
// 	    }}
}
