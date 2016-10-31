<?php

/**
 * This is the model class for table "{{gft_menu_config}}".
 *
 * The followings are the available columns in table '{{gft_menu_config}}':
 * @property string $id
 * @property string $title
 * @property string $icon
 * @property string $flag
 * @property integer $status
 * @property integer $sort
 * @property string $create_time
 * @property string $update_time
 */
class GftMenuConfig extends CActiveRecord
{

	const GFT_MENU_STATUS_NO	=	0;	//关闭
	const GFT_MENU_STATUS_YES	=	1;	//开启

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{gft_menu_config}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title,flag','required'),
			array('icon', 'required','on'=>'insert'),
			array('title,flag','unique'),
			array('status, sort', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>50),
			array('icon', 'length', 'max'=>255),
			array('flag', 'length', 'max'=>32),
			array('create_time, update_time', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, icon, flag, status, sort, create_time, update_time', 'safe', 'on'=>'search'),
		);
	}

	protected function beforeSave()
	{
		if(!parent::beforeSave()) return false;
		if($this->isNewRecord){
			$this->create_time = time();
		}
		$this->update_time = time();
		return true;
	}

	/**
     * 删除之后的操作
     */
    protected function afterDelete() 
    {
        parent::afterDelete();
        if (isset($this->icon) && !empty($this->icon)){
            UploadedFile::delete(Yii::getPathOfAlias('att') . DS . $this->icon);
        }
        return true;
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
			'icon' => '菜单icon',
			'flag' => '标志，APP端使用',
			'status' => '是否开启',
			'sort' => '排序',
			'create_time' => '创建时间',
			'update_time' => '更新时间',
		);
	}

	/**
	 * [showStatus description]
	 * 
	 * @param  string    $status 
	 * @return mixed  
	 */
	public static function showStatus($status=null)
	{
		$map = array(
			self::GFT_MENU_STATUS_NO	=>	'关闭',
			self::GFT_MENU_STATUS_YES	=>	'开启',
		);

		if($status===null) return $map;
		return isset($map[$status]) ? $map[$status] : '未知状态';
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
		// $criteria->compare('title',$this->title,true);
		// $criteria->compare('icon',$this->icon,true);
		// $criteria->compare('flag',$this->flag,true);
		// $criteria->compare('status',$this->status);
		// $criteria->compare('sort',$this->sort);
		// $criteria->compare('create_time',$this->create_time,true);
		// $criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GftMenuConfig the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
