<?php

/**
 * 商家商品分类模型
 * @author wencong.lin <183482670@qq.com>
 *
 * @property string $id
 * @property string $parent_id
 * @property string $name
 * @property string $store_id
 * @property string $description
 * @property integer $sort
 * @property integer $status
 */
class Scategory extends CActiveRecord {

    const STATUS_BAN = 0;
    const STATUS_USING = 1;

    /**
     * 获取商品分类状态
     * @return array
     */
    public static function status() {
        return array(
            self::STATUS_BAN => Yii::t('scategory', '禁用'),
            self::STATUS_USING => Yii::t('scategory', '启用')
        );
    }

    const SHOW_SELECT = '————请选择————';
    const SHOW_TOPCATGORY = '————顶级分类————';

    public function tableName() {
        return '{{scategory}}';
    }

    public function rules() {
        return array(
            array('name, store_id, description', 'required'),
            array('name', 'selfunique'),
            array('sort, status', 'numerical', 'integerOnly' => true),
            array('parent_id, store_id', 'length', 'max' => 11),
            array('name', 'length', 'max' => 128),
            array('description', 'length', 'max' => 256),
            array('id, parent_id, name, store_id, description, sort, status', 'safe', 'on' => 'search'),
        );
    }

    public function selfunique($attribute, $params) {
        if ($this->scenario == 'update') {
            $temp = self::find("name='{$this->name}' AND store_id='{$this->store_id}'");
            if (empty($temp))
                return true;

            if ($temp->id != $this->id) {
                $this->addError($attribute, Yii::t('scategory', '此分类已存在！'));
                return false;
            }
        } else {
            if (self::count("name='{$this->name}' AND store_id='{$this->store_id}'")) {
                $this->addError($attribute, Yii::t('scategory', '此分类已存在！'));
                return false;
            }
        }
        return true;
    }

    public function relations() {
        return array(
            'parent' => array(self::BELONGS_TO, 'Scategory', 'parent_id'),
            'childClass' => array(self::HAS_MANY, 'Scategory', 'parent_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'parent_id' => Yii::t('scategory', '上级分类'),
            'name' => Yii::t('scategory', '分类名称'),
            'store_id' => 'Store',
            'description' => Yii::t('scategory', '说明'),
            'sort' => Yii::t('scategory', '排序'),
            'status' => Yii::t('scategory', '显示状态'),
        );
    }

    public function scopes() {
        return array(
            'scopes1' => array(
                'select' => 'id,name,parent_id',
                'order' => 'sort desc',
            ),
        );
    }

    public function select($select = '*') {

        $this->getDbCriteria()->mergeWith(array(
            'select' => $select,
        ));

        return $this;
    }

    public function order($order = 'recommend_level desc,id desc') {

        $this->getDbCriteria()->mergeWith(array(
            'order' => $order,
        ));

        return $this;
    }

    public function limit($limit) {

        $this->getDbCriteria()->mergeWith(array(
            'limit' => $limit,
        ));

        return $this;
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('parent_id', $this->parent_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('store_id', $this->store_id);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('sort', $this->sort);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getListData($store_id) {
        return CHtml::listData(self::model()->findAll('parent_id = :pid And store_id = :cid', array(':pid' => 0, ':cid' => $store_id)), 'id', 'name');
    }

    public function showAllCategory(&$categoryList, $category, $parent_id = 0, $separate = "") {
        foreach ($category as $k => $v) {
            if ($v['parent_id'] == $parent_id) {
                $v['name'] = $separate . Yii::t('category',$v['name']);
                $categoryList[] = $v;
                $this->showAllCategory($categoryList, $category, $v['id'], $separate . "--");
            }
        }
    }

    public function showAllSelectCategory($store_id, $selectText = '') {
        $category = self::model()->select('id,name,parent_id')->order('sort desc')->findAll('store_id = :cid', array(':cid' => $store_id));
        $categoryList = array();
        $this->showAllCategory($categoryList, $category);
        if (!empty($selectText))
            $categorys = array('0' => $selectText);
        else
            $categorys = array('' => Yii::t('category',Scategory::SHOW_SELECT));
        foreach ($categoryList as $v) {
            $categorys[$v['id']] = $v['name'];
        }
        return $categorys;
    }

    /**
     * 生成|获取 商家店铺分类缓存
     * @param $storeId 店铺id
     * @param bool $cache 是否从缓存获取
     * @return array|bool|null
     */
    public static function scategoryInfo($storeId, $cache = true) {
        //先从缓存获取
        if ($cache) {
            $info = Tool::cache('scategory')->get($storeId);
            return !$info ? self::scategoryInfo($storeId, false) : $info;
        }

        //找不到就查数据库
        $info = array(); //缓存数组
        $data = Scategory::model()->findAllByAttributes(array('store_id' => $storeId, 'status' => self::STATUS_USING));
        if (!$data)
            return null;
        //获取顶级分类信息
        foreach ($data as $v) {
            if ($v->parent_id == 0) {           
			 	$v->name = Yii::t('jf',$v->name);			 
          		$info[] = $v->attributes; 
            }
        }
        //获取子类信息
        foreach ($info as $k => &$v2) {
            foreach ($data as $v3) {
                if ($v2['id'] == $v3->parent_id) {
             		$v3->name = Yii::t('jf',$v3->name);
                    $info[$k]['child'][] = $v3->attributes;
                }
            }
        }
        Tool::cache('scategory')->set($storeId, $info);
        return $info;
    }

    /**
     * 保存后的操作
     * 更新商家店铺分类缓存
     */
    protected function afterSave() {
        parent::afterSave();
        self::scategoryInfo($this->store_id, false);
    }

    /**
     * 删除后的操作
     * 更新商家店铺分类缓存
     */
    protected function afterDelete() {
        parent::afterDelete();
        self::scategoryInfo($this->store_id, false);
    }

    /**
     * 获取指定父类ID分类树数据 
     * @param int $id   可指定父类ID，$id为Null则查询所有分类， "0" :则获取顶级分类
     * @return array
     */
    public function getTreeData($id = null, $store_id) {
        $data = array();
        $command = Yii::app()->db->createCommand();
        if ($id !== null) // 如指定父类ID，则加条件
            $command->where('t.parent_id = :parent_id And t.store_id = :cid', array('parent_id' => intval($id), ':cid' => $store_id));
        $record = $command->from($this->tableName() . ' as t')
                ->select('t.id, t.name as name, t.parent_id, t.description, (select b.id from ' . $this->tableName() . ' as b where b.parent_id = t.id limit 1) as state')
                ->order('sort desc, id asc')
                ->queryAll();
        foreach ($record as $k => $v) {
            $data[$k] = $v;
            $data[$k]['state'] = is_null($v['state']) ? 'open' : 'closed';
        }
        return $data;
    }

}
