<?php

/**
 * This is the model class for table "{{offline_sign_machine_belong}}".
 *
 * The followings are the available columns in table '{{offline_sign_machine_belong}}':
 * @property string $id
 * @property string $belong_to
 * @property string $number
 * @property string $create_time
 * @property string $update_time
 */
class OfflineSignMachineBelong extends CActiveRecord
{
    public $extendId;
	/**
	 * 如果该机器归属方存在则返回id，不存在则创建
	 * @param $name
	 * @return string
	 */
	public static function createBelong($name){
		$model = OfflineSignMachineBelong::model()->findByAttributes(array('belong_to'=>$name));
		if($model)
			return $model->id;
		else{
			$model = new OfflineSignMachineBelong();
			$model->belong_to = $name;
			$model->create_time = time();
			$model->update_time = time();
			$model->save();
			return $model->id;
		}
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{offline_sign_machine_belong}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('belong_to, create_time, update_time', 'required'),
			array('belong_to', 'length', 'max'=>128),
            array('belong_to', 'unique','message'=>'归属方已存在'),
			array('number', 'length', 'max'=>11),
			array('create_time, update_time', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, belong_to, number, create_time, update_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * before validate todo...
	 */
	public function beforeValidate(){
		parent::beforeValidate();
		if($this->isNewRecord){
			$this->number = $this->number===null ? 0 : $this->number;
			$this->create_time = time();
		}
		$this->update_time = time();
		return true;
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('offlinesignmachinebelong','ID'),
			'belong_to' => Yii::t('offlinesignmachinebelong','机器归属方'),
			'number' => Yii::t('offlinesignmachinebelong','机器数量'),
			'create_time' => Yii::t('offlinesignmachinebelong','创建时间'),
			'update_time' => Yii::t('offlinesignmachinebelong','更新时间'),
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
		$criteria->compare('belong_to',$this->belong_to,true);
		// $criteria->compare('number',$this->number,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OfflineSignMachineBelong the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
