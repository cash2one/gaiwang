<?php

/**
 * @author cong.zeng <zengcong220@qq.com>
 * This is the model class for table "{{franchisee_groupbuy_category}}".
 *
 * The followings are the available columns in table '{{franchisee_groupbuy_category}}':
 * @property string $id
 * @property string $parent_id
 * @property string $name
 * @property string $tree
 * @property integer $sort
 *
 */
class FranchiseeGroupbuyCategory extends CActiveRecord
{        
        //一级类目
        const ONE_PARENT_ID = 0;
        
        const CACHEDIR = 'groupCategory';  // 缓存目录
        const CK_ONEGROUPCATEGORY = 'oneGroupbuyCategory';       // 一级分类数据
        const CK_TWOGROUPCATEGORY = 'twoGroupbuyCategory';       // 二级级分类数据
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
            return '{{franchisee_groupbuy_category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('parent_id, name', 'required'),
                    array('name', 'unique'),
                    array('sort', 'numerical', 'integerOnly'=>true),
                    array('parent_id', 'length', 'max'=>11),
                    array('name', 'length', 'max'=>128),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, parent_id, name, tree, sort', 'safe', 'on'=>'search'),
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
                    'franchiseeGroupbuys' => array(self::HAS_MANY, 'FranchiseeGroupbuy', 'franchisee_groupbuy_category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                    'id' => 'ID',
                    'parent_id' => Yii::t('franchiseeGroupbuyeCategory','父类名称'),
                    'name' => Yii::t('franchiseeGroupbuyeCategory','类目名称'),
                    'tree' => Yii::t('franchiseeGroupbuyeCategory','节点'),
                    'sort' => Yii::t('franchiseeGroupbuyeCategory','排序'),
		);
	}

//        public function afterDelete() {
//            parent::afterDelete();
//            if(isset($this->parent_id))
//                self::model ()->delete('parent_id=:parent_id',array(':parent_id'=>$this->parent_id));
//        }

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
		$criteria->compare('parent_id',$this->parent_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('tree',$this->tree,true);
		$criteria->compare('sort',$this->sort);

		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'sort' => array(
                        'defaultOrder' => 'parent_id ASC,id ASC',
                    ),
		));
	}        
       
        /**
        * 检查添加分类是否合法
        */
       public function checkCreateCategory() {
           $raw = $this->find('id = :parent_id And parent_id = :id', array('parent_id' => $this->parent_id, 'id' => $this->id)); // 查询是否有自身子类记录
           if ($this->id == $this->parent_id or !is_null($raw)) // 判断选择父类是否是自身或自身子类的分类
               $this->addError('parent_id', Yii::t('franchiseeGroupbuyeCategory', '选择父类不合法，不可以自身类和自身子类作为父类！'));
       }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FranchiseeGroupbuyCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
         /**
        * 格式化分类数组
        * @param array $categories 格式化后数组
        * @param array $models 分类模型数组
        * @param int $parentId 顶级分类id值
        * @param string $seperate 子类用到的分隔符
        */
       private static function formatCategories(&$categories, $models, $parentId = 0, $seperate = '') {
           foreach ($models as $k => $v) {
               if ($v['parent_id'] == $parentId) {
                   $v['name'] = $seperate . $v['name'];
                   $categories[] = $v;
                   self::formatCategories($categories, $models, $v['id'], $seperate . "　");
               }
           }
       }
       
       /**
        * 获取分类树
        * @param boolean $flag 标记是否显示一级分类选项
        * @return array 返回分类数组树结构
        */
       public static function getTreeCategories($flag = false) {
           $models = self::model()->findAll();
           $categories = $finalCategories = array();
           self::formatCategories($categories, $models);
           if ($flag)
               $finalCategories[0] = '一级类目';
           foreach ($categories as $v)
               $finalCategories[$v['id']] = $v['name'];
           return $finalCategories;
       }
       
       /**
        * 获取一级分类数据
        * @param boolean $generate 是否生成缓存，默认为 true
        * @return array
        */
       public static function oneGroupbuyCategoryData($generate = true) {
           $data = array();
           $categorys = Yii::app()->db->createCommand()
                    ->from('{{franchisee_groupbuy_category}}')
                    ->where('parent_id = :parent_id',array(':parent_id' => FranchiseeGroupbuyCategory::ONE_PARENT_ID))
                    ->queryAll();           
           $data[0] = '一级类目';
           foreach ($categorys as $val) // 这里键原有的键值替换为分类自身ID
               $data[$val['id']] = $val['name'];
           if ($generate === true) // 生成缓存
               Tool::cache(self::CACHEDIR)->set(self::CK_ONEGROUPCATEGORY, $data);
           return $data;
       }
       
       /**
        * 获取二级和二级以上的分类数据
        * @param boolean $generate 是否生成缓存，默认为 true
        * @return array
        */
       public static function twoGroupbuyCategoryData($generate = true) {
           $data = array();
           $condtion = 'parent_id > '.FranchiseeGroupbuyCategory::ONE_PARENT_ID;
           $categorys = Yii::app()->db->createCommand()
                    ->from('{{franchisee_groupbuy_category}}')
                    ->where($condtion)
                    ->queryAll();
           foreach ($categorys as $val) // 这里键原有的键值替换为分类自身ID
               $data[$val['id']] = $val['name'];
           if ($generate === true) // 生成缓存
               Tool::cache(self::CACHEDIR)->set(self::CK_TWOGROUPCATEGORY, $data);
           return $data;
       }
       
       /**
        * parent_id 获取下面的区域数据
        * @param int $id
        * @return array 
        */
       public static function getFranchiseeGroupbuyCategoryByParentId($id) {
           $models = self::model()->findAll('parent_id = :pid ',array(':pid'=>$id));
           $cateArr = array();
           foreach ($models as $v) {
               $cateArr[$v['id']] = Yii::t('franchiseeGroupbuyCategory', $v['name']);
           }
           return $cateArr;
       }     
       
}
