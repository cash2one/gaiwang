<?php

/**
 * This is the model class for table "{{category}}".
 *
 * The followings are the available columns in table '{{category}}':
 * @property integer $id
 * @property integer $pid
 * @property string $name
 * @property string $description
 * @property integer $is_visible
 * @property integer $sort
 * @property string $tree_path
 * @property string $icon_normal_file_id
 * @property string $icon_selected_file_id
 * @property integer $type
 */
class CategoryAgent extends CActiveRecord
{       
        const IS_VISIBLE = 1;
        const UN_VISIBLE = 0;

        const TYPE_ADVERT = 1;  //广告分类
        const TYPE_PRODUCT = 2;  //商品分类
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, sort, is_visible,type', 'required'),
                        array('pid, sort, type', 'numerical', 'integerOnly' => true),
                        array('name', 'length', 'max' => 50, 'min' => 2),
                        array('description', 'length', 'max' => 255, 'min' => 2),
                        array('name, sort, is_visible,type','safe', 'on'=>'search'),
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
			'pid' => 'Pid',
			'name' => '标题',
			'description' => '描述',
			'is_visible' => '是否显示',
			'sort' => '顺序',
			'tree_path' => 'Tree Path',
			'icon_normal_file_id' => 'Icon Normal File',
			'icon_selected_file_id' => 'Icon Selected File',
			'type' => 'Type',
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

		$criteria = new CDbCriteria;
                $criteria->addCondition('is_visible=' . self::IS_VISIBLE );
                $criteria->compare('id', $this->id);
                $criteria->compare('pid', $this->pid);
                $criteria->compare('name', $this->name, true);
                $criteria->compare('description', $this->description);
                $criteria->compare('sort', $this->sort);
                $criteria->compare('type', $this->type);
                $criteria->compare('is_visible', $this->is_visible);
                $criteria->order = "`tree_path` asc";

                return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => 20,
                    ),
                ));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->gt;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CategoryAgent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
         public static function judgeClass($pid, $name, $id) {
            if ($pid == 0) {
                //return $name;
                return '<span style="font-size:28px;">&nbsp' . CHtml::link(CHtml::encode($name), array('update', 'id' => $id)) . '</span>';
            } else {
                return '<span class="child_path" style="font-size:28px;">' . CHtml::link(CHtml::encode($name), array('update', 'id' => $id)) . '</span>';
            }
        }
}
