<?php

/**
 * 商品分类模型
 * @author jianlin_lin <hayeslam@163.com>
 *
 * @property string $id
 * @property string $parent_id
 * @property string $name
 * @property string $short_name
 * @property string $alias
 * @property integer $status
 * @property integer $sort
 * @property string $keywords
 * @property string $description
 * @property string $type_id
 * @property string $thumbnail
 * @property string $picture
 * @property string $recommend
 * @property string $rate
 * @property integer $fee
 * @property string $tree
 * @property int $depth
 */
class Category extends CActiveRecord
{

    /**
     * 需要上传相关证书的顶级分类id
     */
    const TOP_APPLIANCES = 1; //家电
    const TOP_COSMETICS = 3; //化妆
    const TOP_DIGITAL = 4; // 手机数码
    const TOP_FOOD = 8; //食品
    const TOP_JEWELRY = 10; //珠宝

    public static $children = array();
    public $applyToChilden;

    const PARENT_ID = 0; //顶级分类为0
    const STATUS_DISABLE = 0;
    const STATUS_ENABLE = 1;
    const RECOMMEND_NO = 0;
    const RECOMMEND_YES = 1;
    // 定义缓存键值常量
    const CACHEDIR = 'category'; // 缓存目录
    const CK_ALLCATEGORY = 'allCategoryOnline'; // 所有分类数据
    const CK_TREECATEGORY = 'treeCategory'; // 分类树型数据
    const CK_CATEGORYINDEX = 'categoryIndex'; // 分类索引数据
    const CK_MAINCATEGORY = 'mainCategory'; // 首页分类数据
    // depth常量
    const DEPTH_ZERO = 0; //顶级分类
    const DEPTH_ONE = 1; //二级分类
    const DEPTH_TWO = 2; //三级分类
    // 联动变量
    public $sec_parent;
    public $thr_parent;

    public static function getStatus()
    {
        return array(
            self::STATUS_ENABLE => Yii::t('category', '显示'),
            self::STATUS_DISABLE => Yii::t('category', '禁用')
        );
    }

    public static function showStatus($key)
    {
        $options = self::getStatus();
        return $options[$key];
    }

    public static function getRecommend()
    {
        return array(
            self::RECOMMEND_NO => Yii::t('category', '否'),
            self::RECOMMEND_YES => Yii::t('category', '是')
        );
    }

    public static function showRecommend($key)
    {
        $options = self::getRecommend();
        return $options[$key];
    }

    public function tableName()
    {
        return '{{category}}';
    }

    public function rules()
    {
        return array(
            array('name, fee', 'required'),
            array('name, alias, short_name', 'unique'),
            array('thumbnail, picture', 'required', 'on' => 'insert'),
            array('status, sort', 'numerical', 'integerOnly' => true),
            array('fee', 'match', 'pattern' => '/^[0-9]\\d*$/'),
            array('parent_id, type_id', 'length', 'max' => 11),
            array('name, alias, keywords, short_name,title', 'length', 'max' => 128),
            array('description', 'length', 'max' => 256),
            array('fee', 'validateRate'), // 不得超出 "100"
            array('status, recommend', 'in', 'range' => array(0, 1)),
            array('parent_id', 'checkCreateCategory', 'on' => 'update'),
            array('thumbnail, picture', 'file', 'types' => 'jpg,gif,png', 'maxSize' => 1024 * 1024 * 1, 'allowEmpty' => true,
                'tooLarge' => Yii::t('category', '{attribute}最大不超过1MB，请重新上传!')),
            array('applyToChilden', 'boolean')
        );
    }

    /**
     * 验证分类费率
     * @param type $attribute
     * @param type $params
     */
    public function validateRate($attribute, $params)
    {
        if ($this->$attribute > 100)
            $this->addError($attribute, $this->getAttributeLabel($attribute) . '值不能超出"100"');
    }

    public function relations()
    {
        return array(
            'type' => array(self::BELONGS_TO, 'Type', 'type_id'),
            'parentClass' => array(self::BELONGS_TO, 'Category', 'parent_id'),
            'childClass' => array(self::HAS_MANY, 'Category', 'parent_id', 'order' => 'sort desc'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('category', 'ID'),
            'parent_id' => Yii::t('category', '所属父类'),
            'name' => Yii::t('category', '名称'),
            'short_name' => Yii::t('category', '简写'),
            'alias' => Yii::t('category', '别名'),
            'status' => Yii::t('category', '状态'),
            'sort' => Yii::t('category', '排序'),
            'title'=>  Yii::t('category','标题'),
            'keywords' => Yii::t('category', '关键词'),
            'description' => Yii::t('category', '描述'),
            'type_id' => Yii::t('category', '类型'),
            'thumbnail' => Yii::t('category', '小图'),
            'picture' => Yii::t('category', '大图'),
            'recommend' => Yii::t('category', '推荐'),
            'rate' => Yii::t('category', '费率'),
            'fee' => Yii::t('category', '服务费'),
            'tree' => Yii::t('category', '树'),
            'depth' => Yii::t('category', '级'),
            'applyToChilden' => Yii::t('category', '应用于所有子类')
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('parent_id', $this->parent_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('short_name', $this->name, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('sort', $this->sort);
        $criteria->compare('keywords', $this->keywords, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('type_id', $this->type_id);
        $criteria->compare('thumbnail', $this->thumbnail, true);
        $criteria->compare('picture', $this->picture, true);
        $criteria->compare('recommend', $this->recommend, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * 保存后的操作
     * 更新自身，父级，爷级下的tree值
     * 更新子孙级下的type数据
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    public function afterSave()
    {
        parent::afterSave();
        $this->_updateTree();
        $this->_updateFeeAndType();
    }

    /**
     * 保存前的操作
     * 设定depth值
     * @return boolean
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    public function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord)
                $this->depth = $this->_getDepth();
            return true;
        }
        return false;
    }

    public function afterDelete()
    {
        parent::afterSave();
        if ($this->thumbnail)
            UploadedFile::delete(Yii::getPathOfAlias('att') . DS . $this->thumbnail);
        if ($this->picture)
            UploadedFile::delete(Yii::getPathOfAlias('att') . DS . $this->picture);
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 获取depth深度值
     * @return int
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    private function _getDepth()
    {
        if ($this->parent_id == 0)
            return self::DEPTH_ZERO;
        $parent = $this->_getParent($this->parent_id);
        return $parent->depth + 1;
    }

    /**
     * 获取父级分类
     * @param int $id
     * @return CModel
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    private function _getParent($id)
    {
        return $this->find(array(
            'select' => 'id, depth, parent_id',
            'condition' => 'id=:id',
            'params' => array(':id' => $id),
        ));
    }

    /**
     * 更新分类下的tree值
     * tree值存储当前分类下的所有子孙分类ID
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    private function _updateTree()
    {
        if ($this->parent_id) {
            array_push(self::$children, $this->parent_id);
            self::getChildren($this->parent_id, false);
            $this->updateByPk($this->parent_id, array('tree' => implode(',', self::$children)));
            if ($this->depth == self::DEPTH_TWO) {
                $parent = $this->parentClass;
                array_push(self::$children, $parent->parent_id);
                self::getChildren($parent->parent_id, false);
                $tree = implode(',', array_unique(self::$children));
                $this->updateByPk($parent->parent_id, array('tree' => $tree));
            }
        }
        if ($this->isNewRecord)
            $this->updateByPk($this->id, array('tree' => $this->id));
    }

    /**
     * 获取某分类的下所有子孙分类ID
     * @param int $id 分类ID
     * @param boolean $filter 是否过滤状态
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    public static function getChildren($id = 0, $filter = true)
    {
        $condition = $filter ? 'parent_id=:pid AND status=:status' : 'parent_id=:pid';
        $params = $filter ? array(':pid' => $id, ':status' => Category::STATUS_ENABLE) : array(':pid' => $id);
        $categories = Yii::app()->db->createCommand()->select('id, name, depth')->from('{{category}}')->where($condition, $params)->queryAll();
        foreach ($categories as $category) {
            array_push(self::$children, $category['id']);
            if ($category['depth'] != self::DEPTH_TWO)
                self::getChildren($category['id'], $filter);
        }
    }

    /**
     * 为当前分类下的子孙分类操作
     * 1、更新fee服务费
     * 2、更新type类型值
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    private function _updateFeeAndType()
    {
        if (self::DEPTH_TWO == $this->depth)
            return true;
        self::$children = array();
        self::getChildren($this->id, false);
        $result = array('type_id' => $this->type_id);
        $criteria = new CDbCriteria();
        $criteria->addInCondition('id', self::$children);
        if (true == $this->applyToChilden)
            $result['fee'] = $this->fee;
        $this->updateAll($result, $criteria);
    }

    /**
     * 检查添加分类是否合法
     */
    public function checkCreateCategory()
    {
        $raw = $this->find('id = :parent_id And parent_id = :id', array('parent_id' => $this->parent_id, 'id' => $this->id)); // 查询是否有自身子类记录
        if ($this->id == $this->parent_id or !is_null($raw)) // 判断选择父类是否是自身或自身子类的分类
            $this->addError('parent_id', Yii::t('category', '选择父类不合法，不可以自身类和自身子类作为父类！'));
    }

    /**
     * 获取指定父类ID分类树数据
     * @param int $id 可指定父类ID，$id为Null则查询所有分类， "0" :则获取顶级分类
     * @return array
     */
    public function getTreeData($id = null, $max_depth = null)
    {
        $data = array();
        $command = Yii::app()->db->createCommand();

        // 如指定父类ID，则加条件
        if ($id !== null && $max_depth == null) {
            $command->where('t.parent_id = :parent_id', array('parent_id' => intval($id)));
        }
        if ($id !== null && $max_depth !== null) {
            $command->where('t.parent_id = :parent_id AND t.depth < :depth', array('parent_id' => intval($id), 'depth' => intval($max_depth)));
        }
        if ($id == null && $max_depth !== null) {
            $command->where('t.depth < :depth', array('depth' => intval($max_depth)));
        }

        $record = $command->from(self::tableName() . ' as t') // type.name as typename,
            ->select('t.id, t.name as text, t.parent_id, t.status, t.sort, t.recommend, t.fee, (select b.id from ' . self::tableName() . ' as b where b.parent_id = t.id limit 1) as state') // name 字段别名了 text
            ->order('sort desc, id asc')
            ->leftJoin('{{type}} as type', 't.type_id = type.id')
            ->queryAll();
        foreach ($record as $k => $v) {
            $data[$k] = $v;
            $data[$k]['state'] = is_null($v['state']) ? 'open' : 'closed';
        }
        return $data;
    }

    /**
     * 取分类tree数据
     * Enter description here ...
     */
    static function getCatTreeData($id)
    {
        $cat = self::model()->findByPk($id);
        return unserialize($cat->tree);
    }

    /**
     * 获取指定ID分类树数据
     * @param int $id 指定ID
     * @return array
     */
    static function searchCatTreeData($id,$is_back=true)
    {
        $data = array();
        $command = Yii::app()->db->createCommand();
        if($is_back){
            $command->where('t.parent_id = :parent_id', array('parent_id' => intval($id)));
        } else {
            $command->where('t.parent_id = :parent_id AND status = :s', array('parent_id' => intval($id),':s'=>  self::STATUS_ENABLE)); 
        }
        $record = $command->from(self::model()->tableName() . ' as t') // type.name as typename,
            ->select('t.id, t.name as text, t.parent_id, t.status, t.sort, t.recommend, t.fee,t.depth, (select b.id from ' . self::model()->tableName() . ' as b where b.parent_id = t.id limit 1) as state') // name 字段别名了 text
            ->order('sort desc, id asc')
            ->leftJoin('{{type}} as type', 't.type_id = type.id')
            ->queryAll();
        foreach ($record as $k => $v) {
            $data[$k] = $v;
            $data[$k]['state'] = is_null($v['state']) ? 'open' : 'closed';
        }

        return $data;
    }

    /**
     * 向下更新分类及其子类的tree数据
     * Enter description here ...
     * @param unknown_type $id
     */
    static function updateCatTreeData($id)
    {
        $tree_data = self::searchCatTreeData($id);
        if (empty($tree_data))
            $tree_data = array();

        foreach ($tree_data as $key => $val) {
            $tree_data[$key]['sons'] = self::searchCatTreeData($val['id']);
        }

        $updateCommand = Yii::app()->db->createCommand();
        $updateCommand->update(self::model()->tableName(), array('tree' => serialize($tree_data)), 'id = :id', array(':id' => $id * 1));

        return $tree_data;
    }

    /**
     * 向上更新本家族的的treeData
     * Enter description here ...
     */
    static function UpdateParentCatTreeData($id)
    {
        $cat = self::model()->findByPk($id);
        self::updateCatTreeData($id);

        if (!empty($cat->parent_id)) {
            self::UpdateParentCatTreeData($cat->parent_id);
        }

        return true;
    }

    /**
     * 递归更新分类深度
     * Enter description here ...
     */
    static function updateCatDepth($id, $depth = 0)
    {
        $cat = self::model()->findByPk($id);
        $depth = $depth ? $depth : $cat->depth;


        //取子分类
        $sons = unserialize($cat->tree);
        if (!empty($sons)) {
            foreach ($sons as $son) {
                self::updateCatDepth($son['id'], $depth + 1);
            }
        }

        $updateCommand = Yii::app()->db->createCommand();
        $updateCommand->update(self::model()->tableName(), array('depth' => $depth), 'id = :id', array(':id' => $id * 1));

        return $depth;
    }

    /**
     * csj end
     */

    /**
     * 所有分类数据
     * @param boolean $generate 是否生成缓存，默认为 true
     * @return array
     */
    public static function allCategoryData($generate = true)
    {
        $data = array();
        $categorys = Yii::app()->db->createCommand()->from('{{category}}')
            ->where('status = :status', array(':status' => Category::STATUS_ENABLE))
            ->order('sort DESC, id ASC')->queryAll();
        foreach ($categorys as $val) // 这里键原有的键值替换为分类自身ID
            $data[$val['id']] = $val;
        if ($generate === true) // 生成缓存
            Tool::cache(self::CACHEDIR)->set(self::CK_ALLCATEGORY, $data);
        return $data;
    }

    /**
     * 所有分类数据 用于商城优化
     * @return array
     * @author xiaoyan.luo
     */
    public static function allMainCategoryData()
    {
        $data = array();
        $categorys = Yii::app()->db->createCommand()->select('id,name,parent_id')->from('{{category}}')
            ->where('status = :status', array(':status' => Category::STATUS_ENABLE))
            ->order('sort DESC, id ASC')->queryAll();
        foreach ($categorys as $val) // 这里键原有的键值替换为分类自身ID
            $data[$val['id']] = $val;
        return $data;
    }

    /**
     * 树型分类数据
     * @param boolean $generate 是否生成缓存，默认为 true
     * @return array
     */
    public static function treeCategory($generate = true)
    {
        if (!$categorys = Tool::cache(self::CACHEDIR)->get(self::CK_ALLCATEGORY))
            $categorys = self::allCategoryData();
        $tree = array();
        $tempData = $categorys;
        foreach ($categorys as $val) {
            if (isset($tempData[$val['parent_id']])) {
                $tempData[$val['parent_id']]['childClass'][$val['id']] = & $tempData[$val['id']];
            } else {
                if ($val['parent_id'] == '0') {
                    $tree[$val['id']] = & $tempData[$val['id']];
                }
            }
        }
        if ($generate === true)
            Tool::cache(self::CACHEDIR)->set(self::CK_TREECATEGORY, $tree);
        return $tree;
    }

    /**
     * 获取树型分类数据 用于商城优化
     * @return array
     * @author xiaoyan.luo
     */
    public static function treeCategoryData()
    {
        $categorys = self::allMainCategoryData();
        $tree = array();
        $tempData = $categorys;
        foreach ($categorys as $val) {
            if (isset($tempData[$val['parent_id']])) {
                $tempData[$val['parent_id']]['childClass'][$val['id']] = & $tempData[$val['id']];
            } else {
                if ($val['parent_id'] == '0') {
                    $tree[$val['id']] = & $tempData[$val['id']];
                }
            }
        }
        return $tree;
    }

    /**
     * 分类索引（包含自身、父级、爷级的分类数据）
     * @param boolean $generate 是否生成缓存，默认为 true
     * @return array 数据中的type代表分类层次 1：顶级分类、2：父级分类、3：三级分类
     */
    public static function categoryIndexing($generate = true)
    {
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
     * 生成前台主要分类数据
     * @return array
     */
    public static function generateMainCategoryData()
    {
        if (!$tree = Tool::cache(self::CACHEDIR)->get(self::CK_TREECATEGORY))
            $tree = self::treeCategory();
        foreach ($tree as $k => $v) {
            // 推荐分类
            $tree[$k]['recommends'] = self::findRecommendCategory($v['id']);
            $brands = Yii::app()->db->createCommand()->from('{{brand}}')
                ->where('category_id = :catid And status = :status', array(':catid' => $v['id'], ':status' => Brand::STATUS_THROUGH))
                ->order('sort DESC')
                ->limit(6)
                ->queryAll(); // 关联品牌
            $tree[$k]['brands'] = $brands;
            $adverts = array();
            $adp = Yii::app()->db->createCommand()->from('{{advert}}') // 关联广告位
                ->where('category_id = :catid And status = :status And type = :type And direction = :direction', array(
                        ':catid' => $v['id'], ':status' => Advert::STATUS_ENABLE, ':type' => Advert::TYPE_IMAGE, ':direction' => Advert::DIRECTION_CATEGORY)
                )->queryRow();
            if ($adp != false) { // 关联广告
                $adverts = Yii::app()->db->createCommand()->from('{{advert_picture}}')
                    ->where('advert_id = :aid And status = :status ', array(':aid' => $adp['id'], ':status' => AdvertPicture::STATUS_ENABLE))
                    ->order('sort DESC, start_time DESC, id DESC')->queryRow();
            }
            $tree[$k]['adverts'] = $adverts;
        }
        Tool::cache(self::CACHEDIR)->set(self::CK_MAINCATEGORY, $tree); // 生成缓存
        return $tree;
    }

    /**
     * 查找推荐分类 只查找三级的推荐分类
     * @param int $tCid 顶级分类ID
     * @param int $offer 限制条数
     * @return array
     */
    public static function findRecommendCategory($tCid)
    {
        if (!$categorys = Tool::cache(self::CACHEDIR)->get(self::CK_ALLCATEGORY))
            $categorys = self::allCategoryData();
        if (!$tree = Tool::cache(self::CACHEDIR)->get(self::CK_TREECATEGORY))
            $tree = self::treeCategory();
        $rCategory = $childClass = array();
        if (is_numeric($tCid)) {
            if (isset($categorys[$tCid]) && $categorys[$tCid]['parent_id'] == '0') {
                if (isset($tree[$tCid]['childClass'])) {
                    $childs = array_keys($tree[$tCid]['childClass']);
                    foreach ($categorys as $id => $val) {
                        if ($val['parent_id'] != 0 && in_array($val['parent_id'], $childs) && $val['recommend'] == 1) {
                            $rCategory[$id] = $val;
                            if (count($rCategory) == 4)
                                break;
                        }
                    }
                }
            }
        }
        return $rCategory;
    }

    /**
     * 查找所属所有子类元素节点
     * @param mixed $categoryId 分类ID
     * @return array
     */
    public static function findChildCategoryElement($categoryId)
    {
        if (!$categorys = Tool::cache(self::CACHEDIR)->get(self::CK_ALLCATEGORY))
            $categorys = self::allCategoryData();
        $data = array();
        if (isset($categorys[$categoryId])) {
            if ($categorys[$categoryId]['parent_id'] == 0) {
                $data = self::treeCategory($categoryId, false);
            } else {
                foreach ($categorys as $k => $item) {
                    if ($k == $categoryId)
                        $data[$categoryId] = $item;
                    if ($item['parent_id'] == $categoryId)
                        $data[$categoryId]['childClass'][] = $item;
                }
            }
        }
        return $data;
    }

    /**
     * 生成所有分类相应缓存
     */
    public static function generateCategoryCacheFiles()
    {
        self::allCategoryData(); // 生成分类数据缓存文件
        self::treeCategory(); // 生成树形分类数据文件
        self::categoryIndexing(); // 生成分类索引
        self::generateMainCategoryData(); // 生成前台主要分类数据
    }

    /**
     * 继承父类的服务费比率
     * @param null $categorys
     * @return mixed
     */
    public function inheritParentCategoryFee($categorys = null)
    {
        $categorys = !is_array($categorys) ? array($this->id) : $categorys;
        $ids = Yii::app()->db->createCommand()->select('id')->from('{{category}}')->where(array('IN', 'parent_id', $categorys))->queryColumn();
        if (!empty($ids)) {
            Yii::app()->db->createCommand()->update('{{category}}', array('fee' => $this->fee), array('IN', 'id', $ids));
            return $this->inheritParentCategoryFee($ids);
        }
    }

    /**
     * 获取顶级分类
     * @return array
     */
    public static function getTopCategory()
    {
        if (!$categorys = Tool::cache(self::CACHEDIR)->get(self::CK_ALLCATEGORY))
            $categorys = self::allCategoryData();
        $topCategory = array();
        foreach ($categorys as $val) {
            if ($val['parent_id'] == 0)
                $topCategory[$val['id']] = $val;
        }
        return $topCategory;
    }

    /**
     * 获取分类名称
     * @param int $name 分类ID
     * @return string 返回分类名称
     */
    public static function getCategoryName($id)
    {
        if (!$categorys = Tool::cache(self::CACHEDIR)->get(self::CK_ALLCATEGORY))
            $categorys = self::allCategoryData();
        return isset($categorys[$id]) ? $categorys[$id]['name'] : '';
    }

    /**
     * 根据分类id,查找对应分类下的子分类.拼装好数据,生成json格式.给商品添加第一步选择分类的js用
     * @param int $cid 分类id
     * @param bool $json 是否返回json格式的数据
     * @return string
     */
    public static function getCategory($cid, $json = true)
    {
        $cateData = Category::model()->findAllByAttributes(array('parent_id' => $cid, 'status' => Category::STATUS_ENABLE));
        if (!empty($cateData)) {
            $cateJson = array();
            foreach ($cateData as $k => $v) {
                $cateJson[$k]['id'] = $v->id;
                $cateJson[$k]['name'] = Yii::t('category', $v->name);
                $cateJson[$k]['type_id'] = $v->type_id;
            }
            return $json ? CJSON::encode($cateJson) : $cateJson;
        } else {
            return '';
        }
    }

    /**
     * 取出所有顶级分类
     * @param int $topId category_id
     * @return array
     */
    public static function getTop($topId = null)
    {
        if (empty($topId)) {
            $topData = Category::model()->findAll('parent_id=0 and status=' . Category::STATUS_ENABLE);
        } else {
            $topData = Category::model()->findAll('parent_id=0 and id=' . $topId . ' and status=' . Category::STATUS_ENABLE);
        }
        return $topData;
    }

    /**
     * 获取分类服务费比率
     * @param $category
     * @return mixed
     */
    public static function getCategoryServiceFeeRate($category)
    {
        $fee = 0;
        $sql = "SELECT id, parent_id, fee FROM {{category}} WHERE id = :cid";
        $row = Yii::app()->db->createCommand($sql)->bindValue(':cid', $category)->queryRow();
        if (!empty($row)) {
            $fee = $row['fee'];
        }
        return $fee;
    }

    /*
     * @param array $floor 指定的分类ID
     * 红包首页指定分类ID查询分类的名称
     * @return array
     */

    public static function getCategoryNameByIds($ids)
    {
        return Yii::app()->db->createCommand()
            ->select('id, name')
            ->from('{{category}}')
            ->where(array('in', 'id', $ids))
            ->queryAll();
    }

    /**
     * 格式化分类
     * 提取出分类下的所有子分类
     * @param array $category
     * @return array
     */
    public static function formatCategory($category)
    {
        $cate = array();
        if (isset($category['childClass'])) {
            foreach ($category['childClass'] as $value) {
                array_push($cate, $value['id']);
                if (isset($value['childClass'])) {
                    foreach ($value['childClass'] as $v)
                        array_push($cate, $v['id']);
                }
            }
        }
        return $cate;
    }

    /**
     * 首页线下活动分类数据 父级
     * @return array $data
     * @author wencong.lin <183482670@qq.com>
     */
    public static function getOnlineCategoryParent()
    {
        $category = Tool::cache(FranchiseeCategory::CACHEDIR)->get(FranchiseeCategory::CK_INDEXOFFLINECATEGORY);
        $data = array();
        if (!empty($category)) {
            $categoryArr = array_slice($category, 3);

            foreach ($categoryArr as $key => $val) {
                $data[$key]['id'] = $val['id'];
                $data[$key]['name'] = $val['name'];
                $data[$key]['content'] = $val['content'];
            }
        }
        return $data;
    }

    /**
     * 首页线下活动分类数据 (用于商城优化)
     * @return array
     * @author xiaoyan.luo
     */
    public static function getOfflineCategoryParentData()
    {
        $categoryData = $tree = $data = array();
        $categorys = Yii::app()->db->createCommand()->from('{{franchisee_category}}')
            ->where('status = :status', array(':status' => FranchiseeCategory::STATUS_ENABLE))
            ->order('sort DESC, id ASC')->queryAll();

        foreach ($categorys as $val) // 这里键原有的键值替换为分类自身ID
            $categoryData[$val['id']] = $val;

        $tempData = $categoryData;

        foreach ($categoryData as $val) {
            if (isset($tempData[$val['parent_id']])) {
                $tempData[$val['parent_id']]['childClass'][$val['id']] = & $tempData[$val['id']];
            } else {
                if ($val['parent_id'] == '0') {
                    $tree[$val['id']] = & $tempData[$val['id']];
                }
            }
        }

        foreach ($tree as $id => $val) {
            if ($val['show'] == FranchiseeCategory::INDEX_SHOW_YES)
                $data[$id] = $val;
        }
        $parentCategory = self::getCategoryParentData($data);
        return $parentCategory;
    }

    /**
     * 获取首页线下活动分类数据(用于优化)
     * @param $categoryData
     * @return array
     * @author xiaoyan.luo
     */
    public static function getCategoryParentData($categoryData)
    {
        $data = array();
        if (!empty($categoryData) && count($categoryData) >= 4) {
            //$categoryArr = array_slice($categoryData, 0, 4);
            foreach ($categoryData as $key => $val) {
                $data[$key]['id'] = $val['id'];
                $data[$key]['name'] = $val['name'];
                $data[$key]['content'] = $val['content'];
            }
        }
        return $data;
    }

    /**
     * 查找线下活动子分类数据
     * @param $parent array 父分类数据
     * @return array
     * @author xiaoyan.luo
     */
    public static function getOfflineCategoryChildData($parent)
    {
        if (empty($parent)) return array();
        $categorys = Yii::app()->db->createCommand()->select('id,parent_id,name')->from('{{franchisee_category}}')
            ->where('`status` = :status and `show` = :show', array(
                ':status' => FranchiseeCategory::STATUS_ENABLE, ':show' => FranchiseeCategory::INDEX_SHOW_YES))
            ->order('sort DESC, id ASC')->queryAll();

        $categoryData = $tree = array();
        foreach ($categorys as $val) // 这里键原有的键值替换为分类自身ID
            $categoryData[$val['id']] = $val;

        $tempData = $categoryData;
        foreach ($categoryData as $val) {
            if (isset($tempData[$val['parent_id']])) {
                $tempData[$val['parent_id']]['childClass'][$val['id']] = & $tempData[$val['id']];
            } else {
                if ($val['parent_id'] == '0') {
                    $tree[$val['id']] = & $tempData[$val['id']];
                }
            }
        }

        $intersectArr = array_intersect_key($tree, $parent); //数组key的交集
        $childCategory = self::getCategoryChildData($intersectArr);
        return $childCategory;
    }

    /**
     * 首页线下活动子分类数据 (用于商城优化)
     * @param $intersectArr array 分类数组
     * @return array
     * @author xiaoyan.luo
     */
    public static function getCategoryChildData($intersectArr)
    {
        $arr1 = $arr2 = $data = array();
        if (!empty($intersectArr)) {
            foreach ($intersectArr as $key => $val) {
                if (isset($val['childClass'])) {
                    $arr1[$key] = $val['childClass'];
                } else {
                    $arr1[$key] = array();
                }
            }
        }
        if (!empty($arr1)) {
            foreach ($arr1 as $key => $val) {
                if (count($arr1[$key]) <= 4) {
                    $data[$key] = $val;
                } else {
                    $data[$key] = $val;
                    $arr2 = array_slice($arr1[$key], 1, 4, true);
                    $data[$key] = $arr2;
                }
            }
        }

        return $data;
    }

    /**
     * 获取首页的分类数据 用于商城优化
     * @return array
     * @author xiaoyan.luo
     */
    public static function getHomepageCategoryData()
    {
        $tree = Category::treeCategoryData();
        $tree = array_slice($tree, 0, 14); //取数组前14位
        foreach ($tree as $k => $v) {
            //$tree[$k]['recommends'] = self::findRecommendCategory($v['id']);// 推荐分类
            $brands = Yii::app()->db->createCommand()->select('logo,name')->from('{{brand}}')
                ->where('category_id = :catid And status = :status', array(':catid' => $v['id'], ':status' => Brand::STATUS_THROUGH))
                ->order('sort DESC')
                ->limit(6)
                ->queryAll(); // 关联品牌
            $tree[$k]['brands'] = $brands;
            /**
             * 关联定向投放图片广告
             */
            $adverts = array();
            $adp = Yii::app()->db->createCommand()->from('{{advert}}') // 关联广告位
                ->where('category_id = :catid And status = :status And type = :type And direction = :direction and code like "index_category_img%"', array(
                        ':catid' => $v['id'], ':status' => Advert::STATUS_ENABLE, ':type' => Advert::TYPE_SLIDE, ':direction' => Advert::DIRECTION_CATEGORY)
                )->queryRow();
            if ($adp != false) { // 关联广告
                $adverts = Yii::app()->db->createCommand()->select('link,title,picture,target,group')->from('{{advert_picture}}')
                    ->where('advert_id = :aid And status = :status and start_time<=:time and (end_time >= :time or end_time=0) ', array(
                        ':aid' => $adp['id'],
                        ':status' => AdvertPicture::STATUS_ENABLE,
                        ':time'=>time(),
                    ))
                    ->order('sort DESC, start_time DESC, id DESC');
                $adverts = $adverts->queryAll();
//                if(Yii::app()->theme){
//                    $adverts = $adverts->queryAll();
//                }else{
//                    $adverts = $adverts->queryRow();
//                }
            }
            $tree[$k]['adverts'] = $adverts;
            //关联定向投放文字广告
            $adverts_txt = array();
            $ad = Yii::app()->db->createCommand()->from('{{advert}}') // 关联广告位
            ->where('category_id = :catid And status = :status And type = :type And direction = :direction and code like "index_category%"', array(
                    ':catid' => $v['id'], ':status' => Advert::STATUS_ENABLE, ':type' => Advert::TYPE_TEXT, ':direction' => Advert::DIRECTION_CATEGORY)
            )->queryRow();
            if ($ad != false) { // 关联广告
                $adverts_txt = Yii::app()->db->createCommand()->select('link,title,target')->from('{{advert_picture}}')
                    ->where('advert_id = :aid And status = :status and start_time<=:time and (end_time >= :time or end_time=0)', array(
                        ':aid' => $ad['id'],
                        ':status' => AdvertPicture::STATUS_ENABLE,
                        ':time'=>time(),
                    ))
                    ->order('sort DESC, start_time DESC, id DESC')->queryAll();
            }
            $tree[$k]['adverts_txt'] = $adverts_txt;

        }
        Tool::cache(Advert::CACHEDIR)->set(Advert::HOME_NAV_CACHE_DIR,$tree);
        return $tree;
    }

    /**
     * 首页线下活动分类数据 子级
     * @return array $data
     * @author wencong.lin <183482670@qq.com>
     */
    public static function getOnlineCategoryChild()
    {
        $category = Tool::cache(FranchiseeCategory::CACHEDIR)->get(FranchiseeCategory::CK_INDEXOFFLINECATEGORY);
        $arr1 = $arr2 = $data = array();
        if (!empty($category)) {
            $categoryArr = array_slice($category, 3);
            if (!empty($categoryArr)) {
                foreach ($categoryArr as $key => $val) {
                    if (isset($val['childClass']))
                        $arr1[$key] = $val['childClass'];
                }

                foreach ($arr1 as $key => $val) {
                    if (count($arr1[$key]) <= 4) {
                        $data[$key] = $val;
                    } else {
                        $data[$key] = $val;
                        $arr2 = array_slice($arr1[$key], 1, 4, true);
                        $data[$key] = $arr2;
                    }
                }
            }
        }
        return $data;
    }

    /**
     * 首页楼层分类的父级信息
     * @param int $categoryId 顶级分类ID
     * @return array $data
     * @author wencong.lin <183482670@qq.com>
     */
    public static function getFloorCategoryParent($categoryId)
    {
        $data = Yii::app()->db->createCommand()
            ->select('short_name, alias')
            ->from('{{category}}')
            ->where('id=:id And status=:status', array(':id' => $categoryId, ':status' => Category::STATUS_ENABLE))
            ->queryRow();
        if (empty($data))
            $data = array();
        return $data;
    }

    /**
     * 首页楼层分类的子级信息
     * @param int $categoryId 顶级分类ID
     * @return array $data
     * @author wencong.lin <183482670@qq.com>
     */
    public static function getFloorCategoryChild($categoryId)
    {
        $data = Yii::app()->db->createCommand()
            ->select('id, name')
            ->from('{{category}}')
            ->where('parent_id=:pid And status=:status', array(':pid' => $categoryId, ':status' => Category::STATUS_ENABLE))
            ->order('sort DESC')
            ->limit(8)
            ->queryAll();
        if (empty($data))
            $data = array();
        return $data;
    }

    /**
     * 首页楼层分类的子级ID
     * @param int $categoryId 顶级分类ID
     * @return array $data
     * @author wencong.lin <183482670@qq.com>
     */
    public static function getFloorCategoryChildId($categoryId)
    {
        $childIdArr = Yii::app()->db->createCommand()
            ->select('id')
            ->from('{{category}}')
            ->where('parent_id=:pid', array(':pid' => $categoryId))
            ->queryAll();
        if (empty($childIdArr))
            $data = array();
        foreach ($childIdArr as $val) {
            $data[] = $val['id'];
        }
        return $data;
    }

    /**
     * 首页楼层分类的孙级ID
     * @param array $categoryId 子级分类ID
     * @return array $data
     * @author wencong.lin <183482670@qq.com>
     */
    public static function getFloorCategoryGrandsonId($categoryId)
    {
        //SELECT id FROM `gw_category` where parent_id IN(21,96,97,98,99,103) AND depth = 2
        $grandsonIdArr = Yii::app()->db->createCommand()
            ->select('id')
            ->from('{{category}}')
            ->andWhere(array('in', 'parent_id', $categoryId))
            ->queryAll();
        if (empty($grandsonIdArr))
            $data = array();
        foreach ($grandsonIdArr as $val) {
            $data[] = $val['id'];
        }
        $data = array_merge($data, $categoryId);
        return $data;
    }


    public static function getChildCategory($parent_category){
        $result = array();
        $result = Yii::app()->db->createCommand()->select("id")->from("{{category}}")
            ->where("parent_id in ('{$parent_category}')")->queryAll();

        return $result;
    }

    /**
     * 根据栏目ID获取到顶级的栏目的ID
     * @param int $id 栏目ID
     * @return int|array
     */
    public static function getTreeById($id)
    {
        static $list =array();
        if (!$categorys = Tool::cache(self::CACHEDIR)->get(self::CK_ALLCATEGORY))
            $categorys = self::allCategoryData();
        if($c = $categorys[$id]){
            if($c['parent_id'] != self::PARENT_ID){
                $list[] = $id;
                self::getTreeById($c['parent_id']); 
            } else {
                $list[] = $id;
            }
            return $list;
        }
        return null;
    }

}
