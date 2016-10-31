<?php

/**
 * This is the model class for table "{{franchisee_goods_category}}".
 *
 * The followings are the available columns in table '{{franchisee_goods_category}}':
 * @property string $id
 * @property string $franchisee_id
 * @property string $parent_id
 * @property string $name
 * @property string $tree
 * @property integer $sort
 *
 * The followings are the available model relations:
 * @property FranchiseeGoods[] $franchiseeGoods
 * @property Franchisee $franchisee
 */
class FranchiseeGoodsCategory extends CActiveRecord
{

    const SHOW_SELECT = '————请选择————';
    const SHOW_TOPCATGORY = '————顶级分类————';
    
    
    const PARENT_ID = 0; //顶级分类为0
    
    // 定义缓存键值常量
    const CACHEDIR = 'franchiseeGoodsCategory';  // 缓存目录
    const CK_ALLCATEGORY = 'allFranchiseeGoodsCategory';       // 所有分类数据
    const CK_TREECATEGORY = 'treeFranchiseeGoodsCategory';     // 分类树型数据
    const CK_CATEGORYINDEX = 'franchiseeGoodsCategoryIndex';   // 分类索引数据


    public function tableName() {
        return '{{franchisee_goods_category}}';
    }

    public function rules() {
        return array(
            array('name, franchisee_id,', 'required'),
            array('name', 'selfunique'),
            array('sort', 'numerical', 'integerOnly' => true),
            array('parent_id, franchisee_id', 'length', 'max' => 11),
            array('name', 'length', 'max' => 128),
            array('id, parent_id, name, franchisee_id,sort', 'safe', 'on' => 'search'),
        );
    }

    public function selfunique($attribute, $params) {
        if ($this->scenario == 'update') {
            $temp = self::find("name='{$this->name}' AND franchisee_id='{$this->franchisee_id}'");
            if (empty($temp))
                return true;

            if ($temp->id != $this->id) {
                $this->addError($attribute, Yii::t('scategory', '此分类已存在！'));
                return false;
            }
        } else {
            if (self::count("name='{$this->name}' AND franchisee_id='{$this->franchisee_id}'")) {
                $this->addError($attribute, Yii::t('scategory', '此分类已存在！'));
                return false;
            }
        }
        return true;
    }

    public function relations() {
        return array(
            'parent' => array(self::BELONGS_TO, 'FranchiseeGoodsCategory', 'parent_id'),
            'childClass' => array(self::HAS_MANY, 'FranchiseeGoodsCategory', 'parent_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'parent_id' => Yii::t('scategory', '上级分类'),
            'name' => Yii::t('scategory', '分类名称'),
            'franchisee_id' => '加盟商',
            'sort' => Yii::t('scategory', '排序'),
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
        $criteria->compare('franchisee_id', $this->franchisee_id);
        $criteria->compare('sort', $this->sort);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getListData($franchisee_id) {
        return CHtml::listData(self::model()->findAll('parent_id = :pid And franchisee_id = :cid', array(':pid' => 0, ':cid' => $franchisee_id)), 'id', 'name');
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

    public function showAllSelectCategory($franchisee_id, $selectText = '') {
        $category = self::model()->select('id,name,parent_id')->order('sort desc')->findAll('franchisee_id = :cid', array(':cid' => $franchisee_id));
        $categoryList = array();
        $this->showAllCategory($categoryList, $category);
        if (!empty($selectText))
            $categorys = array('0' => $selectText);
        else
            $categorys = array('' => Yii::t('category',FranchiseeGoodsCategory::SHOW_SELECT));
        foreach ($categoryList as $v) {
            $categorys[$v['id']] = $v['name'];
        }
        return $categorys;
    }

    /**
     * 生成|获取 商家店铺分类缓存
     * @param $franchiseeId 店铺id
     * @param bool $cache 是否从缓存获取
     * @return array|bool|null
     */
    public static function scategoryInfo($franchiseeId, $cache = true) {
        //先从缓存获取
        if ($cache) {
            $info = Tool::cache('franchiseeGoodsCategory')->get($franchiseeId);
            return !$info ? self::scategoryInfo($franchiseeId, false) : $info;
        }

        //找不到就查数据库
        $info = array(); //缓存数组
        $data = FranchiseeGoodsCategory::model()->findAllByAttributes(array('franchisee_id' => $franchiseeId));
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
        Tool::cache('franchiseeGoodsCategory')->set($franchiseeId, $info);
        return $info;
    }

    /**
     * 保存后的操作
     * 更新商家店铺分类缓存
     */
    protected function afterSave() {
        parent::afterSave();
        self::scategoryInfo($this->franchisee_id, false);
    }

    /**
     * 删除后的操作
     * 更新商家店铺分类缓存
     */
    protected function afterDelete() {
        parent::afterDelete();
        self::scategoryInfo($this->franchisee_id, false);
    }

    /**
     * 获取指定父类ID分类树数据 
     * @param int $id   可指定父类ID，$id为Null则查询所有分类， "0" :则获取顶级分类
     * @return array
     */
    public function getTreeData($id = null, $franchisee_id) {
        $data = array();
        $command = Yii::app()->db->createCommand();
        if ($id !== null) // 如指定父类ID，则加条件
            $command->where('t.parent_id = :parent_id And t.franchisee_id = :cid', array('parent_id' => intval($id), ':cid' => $franchisee_id));
        $record = $command->from($this->tableName() . ' as t')
                ->select('t.id, t.name as name, t.parent_id,  (select b.id from ' . $this->tableName() . ' as b where b.parent_id = t.id limit 1) as state')
                ->order('sort desc, id asc')
                ->queryAll();
        foreach ($record as $k => $v) {
            $data[$k] = $v;
            $data[$k]['state'] = is_null($v['state']) ? 'open' : 'closed';
        }
        return $data;
    }
    
    /**
     * 取出所有顶级分类
     * @param int $topId category_id
     * @return array
     */
    public static function getTop($f_id,$topId = null) {
    	if (empty($topId)) {
    		$topData = FranchiseeGoodsCategory::model()->findAll('franchisee_id= '.$f_id.' AND parent_id=0 ');
    	} else {
    		$topData = FranchiseeGoodsCategory::model()->findAll('franchisee_id= '.$f_id.' AND parent_id=0 and id=' . $topId );
    	}
    	return $topData;
    }
	
    /**
     * 根据分类id,查找对应分类下的子分类.拼装好数据,生成json格式.给商品添加第一步选择分类的js用
     * @param int $cid 分类id
     * @param bool $json 是否返回json格式的数据
     * @return string
     */
    public static function getCategory($cid, $json = true) {
    	$cateData = FranchiseeGoodsCategory::model()->findAllByAttributes(array('parent_id' => $cid));
    	if (!empty($cateData)) {
    		$cateJson = array();
    		foreach ($cateData as $k => $v) {
    			$cateJson[$k]['id'] = $v->id;
    			$cateJson[$k]['name'] = Yii::t('category', $v->name);
    		}
    		return $json ? CJSON::encode($cateJson) : $cateJson;
    	} else {
    		return '';
    	}
    }
    
    
    /**
     * 所有分类数据
     * @param boolean $generate 是否生成缓存，默认为 true
     * @return array
     */
    public static function allCategoryData($generate = true) {
    	$data = array();
    	$categorys = Yii::app()->db->createCommand()->from(self::tableName())
    	->order('sort DESC, id ASC')->queryAll();
    	foreach ($categorys as $val) // 这里键原有的键值替换为分类自身ID
    		$data[$val['id']] = $val;
    	if ($generate === true) // 生成缓存
    		Tool::cache(self::CACHEDIR)->set(self::CK_ALLCATEGORY, $data);
    	return $data;
    }
    
    
    /**
     * 分类索引（包含自身、父级、爷级的分类数据）
     * @param boolean $generate 是否生成缓存，默认为 true
     * @return array 数据中的type代表分类层次 1：顶级分类、2：父级分类、3：三级分类
     */
    public static function categoryIndexing($generate = true) {
    	if (!$category = Tool::cache(self::CACHEDIR)->get(self::CK_ALLCATEGORY))
    		$category = self::allCategoryData();
    	$breadcrumbs = array();
    	foreach ($category as $k => $v) {
    		// 自身分类
    		$breadcrumbs[$k]['id'] = $v['id'];
    		$breadcrumbs[$k]['name'] = $v['name'];
    		$breadcrumbs[$k]['type'] = 1;
    		if ($v['parent_id'] == 0)
    			continue;
    		// 获取父级
    		if (isset($category[$v['parent_id']])) {
    			$parent = $category[$v['parent_id']];
    			$breadcrumbs[$k]['parentId'] = $parent['id'];
    			$breadcrumbs[$k]['parentName'] = $parent['name'];
    			$breadcrumbs[$k]['type'] = 2;
    			if ($parent['parent_id'] == 0)
    				continue;
    			// 获取爷级
    			if (isset($category[$parent['parent_id']])) {
    				$grandpa = $category[$parent['parent_id']];
    				$breadcrumbs[$k]['grandpaId'] = $grandpa['id'];
    				$breadcrumbs[$k]['grandpaName'] = $grandpa['name'];
    				$breadcrumbs[$k]['type'] = 3;
    			}
    		}
    	}
    	if ($generate === true)
    		Tool::cache(self::CACHEDIR)->set(self::CK_CATEGORYINDEX, $breadcrumbs);
    	return $breadcrumbs;
    }
    
    
    /**
     * 分类面包屑重组
     * @param int $catid 分类Id
     * @param mixed $url CHtml::normalizeUrl()
     * @return array
     */
    public static function categoryBreadcrumb($catid, $url = array()) {
    	if (!$bi = Tool::cache(self::CACHEDIR)->get(self::CK_CATEGORYINDEX))
    		$bi = self::categoryIndexing();
    	$bradcrumb = array();
    
    	if (isset($bi[$catid])) {
    		$bData = $bi[$catid];
    		switch ($bData['type']):
    		case '1':
    			$bradcrumb = array(Yii::t('category', $bData['name']) => array_merge($url, array('id' => $bData['id'])));
    		break;
    		case '2':
    			$bradcrumb = array(
    			Yii::t('category', $bData['parentName']) => array_merge($url, array('id' => $bData['parentId'])),
    			Yii::t('category', $bData['name']) => array_merge($url, array('id' => $bData['id']))
    			);
    			break;
    		case '3':
    			$bradcrumb = array(
    			Yii::t('category', $bData['grandpaName']) => array_merge($url, array('id' => $bData['grandpaId'])),
    			Yii::t('category', $bData['parentName']) => array_merge($url, array('id' => $bData['parentId'])),
    			Yii::t('category', $bData['name']) => array_merge($url, array('id' => $bData['id']))
    			);
    			break;
    			endswitch;
    	}
    	return $bradcrumb;
    }
	
}
