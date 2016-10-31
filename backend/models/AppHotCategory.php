<?php

/**
 * This is the model class for table "{{app_hot_category}}".
 *
 * The followings are the available columns in table '{{app_hot_category}}':
 * @property integer $id
 * @property integer $category_id
 * @property string $order
 * @property integer $type
 * @property integer $is_publish
 * @property string $create_time
 * @property string $update_time
 * @property string $picture
 */
class AppHotCategory extends CActiveRecord
{
    const IS_PUBLISH_TRUE = 1;									//已发布
    const IS_PUBLISH_FALSE = 0;									//未发布

    public $name;                                               //分类名

    public $depthZero;                                          //顶级分类
    public $depthOne;                                           //二级分类
    public $depthTwo;                                           //三级分类

    /**
     * 是否发布
     * @param null $key
     * @return array
     */
    public static function getPublish($key = null){
        $data = array(
            self::IS_PUBLISH_FALSE => Yii::t('AppHotCategory','未发布'),
            self::IS_PUBLISH_TRUE => Yii::t('AppHotCategory','已发布'),
        );
        return $key === null ? $data : $data[$key];
    }

    /**
     * 是否发布类型值
     * @param null $key
     * @return array
     */
    public static function getPublishKey($key = null){
        $data = array(
            self::IS_PUBLISH_FALSE=>'IS_PUBLISH_FALSE',
            self::IS_PUBLISH_TRUE=>  'IS_PUBLISH_TRUE',
        );
        return $key === null ? $data : $data[$key];
    }

    /**
     * 时间戳转换为日期函数
     */
    public static function stampToDate($stamp,$format='Y-m-d H:i:s'){
        if(empty($stamp)) return '';
        else return date($format,$stamp);
    }
    
    /**
     * 根据id获取分类名
     */
    public static function getCategoryName($category_id){
    	$category_name = Yii::app()->db->createCommand()
						    	->select('name')
						    	->from(Category::model()->tableName())
						    	->where('id='.$category_id)
						    	->queryScalar();
    	return empty($category_name) ? '' : $category_name;
    }
    
    /**
     * 删除后的操作(删除文件)
     */
    protected function afterDelete() {
    	parent::afterDelete();
    	if ($this->picture)
    		UploadedFile::delete(Yii::getPathOfAlias('att') . DS . $this->picture);
    }
    
    /**
     * 根据id获取所有的上级分类id(编辑热卖分类时使用)
     */
    public static function getParentCategory($category_id){
    	static $result = array();
    	$categoryModel = Category::model()->findByPk($category_id);
        $result[$categoryModel->depth] = $categoryModel->id;
        if($categoryModel->depth == Category::DEPTH_ZERO){
            return $result;
        }else
    	    return self::getParentCategory($categoryModel->parent_id);

    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{app_hot_category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id', 'required'),
			array('category_id, type, is_publish', 'numerical', 'integerOnly'=>true),
			array('order', 'length', 'max'=>11),
			array('create_time, update_time', 'length', 'max'=>10),
			array('picture', 'length', 'max'=>128),
            array('explain', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, category_id, order, type, is_publish, create_time, update_time, picture', 'safe', 'on'=>'search'),
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
			'category_id' => Yii::t('AppHotCategory','分类ID'),
			'order' => Yii::t('AppHotCategory','排序'),
			'type' => Yii::t('AppHotCategory','类型'),
			'is_publish' => Yii::t('AppHotCategory','是否发布'),
			'create_time' => Yii::t('AppHotCategory','创建时间'),
			'update_time' => Yii::t('AppHotCategory','更新时间'),
			'picture' => Yii::t('AppHotCategory','图片'),
            'explain' => Yii::t('AppHotCategory','分类说明'),
            'name' => Yii::t('AppHotCategory','分类名'),
            'depthZero'=>Yii::t('AppHotCategory','顶级分类'),
            'depthOne'=>Yii::t('AppHotCategory','二级分类'),
            'depthTwo'=>Yii::t('AppHotCategory','三级分类'),
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
        $criteria->select = 't.id,c.name,t.order,t.is_publish,t.picture,t.create_time,t.update_time';
        $criteria->join = 'left join ' .Category::model()->tableName(). ' as c on t.category_id = c.id ';
        $criteria->addCondition('c.status = ' .Category::STATUS_ENABLE);
        $criteria->order = 't.order desc';
		$criteria->compare('id',$this->id);
        $criteria->compare('c.name',$this->name,true);
		$criteria->compare('t.order',$this->order);
		$criteria->compare('t.is_publish',$this->is_publish);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('picture',$this->picture,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>20,
            ),
            'sort' => false
        ));
	}

    /**
     * 根据父类ID获取子级分类
     * @param $parentId 父级ID
     */
    public static function getChildCategory($parentId = 0){
        $childCategory = Yii::app()->db->createCommand()
        					->select('id,name,parent_id,depth')
        					->from(Category::model()->tableName())
        					->where('parent_id = ' .$parentId . ' and status='.Category::STATUS_ENABLE)
        					->queryAll();
        if(!empty($childCategory)){
            $list = array();
            foreach($childCategory as $key => $val){
                //处理脏数据
                if($val['depth']==0 && $val['parent_id'] != 0)
                    continue;
                $list[$val['id']] = $val['name'];
            }
            return $list;
        }else
            return array('无下级分类');
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AppHotCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
