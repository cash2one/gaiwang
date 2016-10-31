<?php

/**
 * This is the model class for table "{{app_home_picture}}".
 *
 * The followings are the available columns in table '{{app_home_picture}}':
 * @property string $id
 * @property string $title
 * @property string $image
 * @property integer $start_time
 * @property integer $end_time
 * @property integer $admin
 * @property string $update_time
 */
class AppHomePicture extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{app_home_picture}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, start_time, end_time, admin, update_time', 'required'),
			array('start_time, end_time, admin', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>100),
			array('image', 'length', 'max'=>128),
			array('image','required','on'=>'create'),
			array('update_time', 'length', 'max'=>11),
			array('start_time,end_time', 'CheckTime'),
			array('image', 'file', 'types' => 'jpg,gif,png', 'maxSize' => 1024*1024*0.5, 'tooLarge' => Yii::t('partner', '文件大于500K，上传失败！请上传小于500K的文件！'), 'allowEmpty' => true, 'safe' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, image, start_time, end_time, admin, update_time', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'title' => '标题',
			'image' => '主题图片',
			'start_time' => '开始时间',
			'end_time' => '结束时间',
			'admin' => '管理员',
			'update_time' => '更新时间',
			'version'=>'版本号'
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
		$this->start_time = strtotime($this->start_time);
		$this->end_time = strtotime($this->end_time);
		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('start_time',">=".$this->start_time);
		$criteria->compare('end_time',"<=".$this->end_time);
		$criteria->compare('admin',$this->admin);
		$criteria->compare('update_time',$this->update_time,true);

		//var_dump($criteria);die();
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AppHomePicture the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * 判断时间段是否重复
	 * @param unknown $attribute
	 * @param unknown $params
	 */
	public function CheckTime($attribute,$params){
		$db = Yii::app()->db1;
		if($this->end_time <= $this->start_time){
			$this->addError('start_time',"开始时间必须小于结束时间");
			$this->addError('end_time',"结束时间必须大于开始时间");
		}
		$where = "start_time < {$this->end_time} and end_time > {$this->start_time}";
		if(!($this->isNewRecord)){
			$where .= " and id <> {$this->id}";
		}
		
		$data = $db->createCommand()->select()->from(self::model()->tableName())
		        ->where($where)->queryAll();
		if($data){
			$this->addError('start_time',"请检查此时间段内是否已存在主题");
			$this->addError('end_time',"请检查此时间段内是否已存在主题");
		}
	}
}
