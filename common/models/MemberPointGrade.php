<?php

/**
 * This is the model class for table "{{member_point_grade}}".
 *
 * The followings are the available columns in table '{{member_point_grade}}':
 * @property string $id
 * @property string $grade_name
 * @property string $grade_point
 * @property string $day_usable_point
 * @property string $month_usable_point
 * @property string $create_time
 * @property string $update_time
 * @property integer $admin
 */
class MemberPointGrade extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{member_point_grade}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('grade_name', 'unique'),
			array('grade_name, grade_point, day_usable_point, month_usable_point', 'required'),
			array('admin', 'numerical', 'integerOnly'=>true),
			array('grade_point, day_usable_point, month_usable_point', 'numerical'),
			array('grade_point, day_usable_point, month_usable_point', 'match', 'message' => '只能为非负数字，保留两位小数', 'pattern' => '/^\d+\.*\d{0,2}$/'), //验证
			array('grade_name', 'length', 'max'=>64),
			array('grade_point, day_usable_point, month_usable_point', 'length', 'max'=>18),
			array('day_usable_point', 'verifyPoint'),
			array('create_time, update_time', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, grade_name, grade_point, day_usable_point, month_usable_point, create_time, update_time, admin', 'safe', 'on'=>'search'),
		);
	}

	
	
	/**
	 * 判断月可用不可小于日可用
	 * @param unknown $attribute
	 * @param unknown $params
	 */
	public  function verifyPoint($attribute, $params){
		if($this->month_usable_point!=''){
			if(bcsub($this->day_usable_point,$this->month_usable_point,2) > 0){
				$this->addError($attribute, Yii::t('memberPointGrade', '日可用额度不能大于月可用额度'));
			}
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
			'grade_name' => '会员等级名称',
			'grade_point' => '等级积分数',
			'day_usable_point' => '日可用额度',
			'month_usable_point' => '月可用额度',
			'create_time' => '创建时间',
			'update_time' => '最后更新时间',
			'admin' => '创建人',
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
		$criteria->compare('grade_name',$this->grade_name,true);
		$criteria->compare('grade_point',$this->grade_point,true);
		$criteria->compare('day_usable_point',$this->day_usable_point,true);
		$criteria->compare('month_usable_point',$this->month_usable_point,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('admin',$this->admin);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 根据会员所有积分得到积分限额等级
	 * @param decimal $money 会员所有积分数
	 */
     public static function getGradeInfo($money,$data=array()){
     	if(count($data) == 0){
     		$data=self::getAllGrade();
     	}  
      if(!empty($data)){
      	$dataRows=array();
      	$grade_point=array();
         foreach ($data as $k => $v){
             if($v['grade_point'] >= $money){ 
             	 $dataRows[]=$data[$k];
             	 $grade_point[] = $v['grade_point'];
             }else{
             	 continue;
               }
          }  
            array_multisort($grade_point,SORT_ASC, $dataRows);
            return isset($dataRows[0]) ? $dataRows[0] : end($data);
         }else{
         	return false;
         }
          
     } 
     
     /**
      * 根据等级ID得到等级名字
      * @param int $gradeId 等级ID
      */
    public static function getGradeName($gradeId,$field='grade_name'){
    	$res=Yii::app()->db->createCommand()
    	   ->select($field)
    	   ->from('{{member_point_grade}}')
    	   ->where('id=:id',array(':id'=>$gradeId))
    	   ->queryRow();
    	return $res;
    }
     
     
     /**
      * 得到所有的积分等级
      */
     
     public static function getAllGrade($field='*',$condtion=NULL){
     	$command = Yii::app()->db->createCommand();
     	$dataAll=$command->select($field)
            ->from('{{member_point_grade}}')
            ->order('grade_point asc')
            ->queryAll();
     	if($condtion!==NULL){
     		$command->where($condtion);
     	 }
     	
     	 return $dataAll;
     }
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GwMemberPointGrade the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
