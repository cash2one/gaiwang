<?php

/**
 * 商家分类模型
 * @author jianlin_lin <hayeslam@163.com>
 * 
 * @property string $id
 * @property string $parent_id
 * @property string $name
 * @property string $thumbnail
 * @property string $content
 * @property integer $status
 * @property integer $show
 * @property integer $sort
 * @property string $keywords
 * @property string $description
 * @property string $create_time
 * @property string $update_time
 */
class FranchiseeCategory extends CActiveRecord {

    public $parentName;


    const VISIBLE = 1;//显示
    const DISABLE = 0;//禁用 状态

    // 状态
    const STATUS_DISABLE = 0;
    const STATUS_ENABLE = 1;
    // 首页显示
    const INDEX_SHOW_NO = 0;
    const INDEX_SHOW_YES = 1;
    // 缓存常量
    const CACHEDIR = 'franchisee';  // 缓存目录
    const CK_ALLCATEGORY = 'allCategory';  // 加盟商所有分类
    const CK_TREECATEGORY = 'treeCategory';  // 加盟商树形分类
    const CK_INDEXOFFLINECATEGORY = 'indexOfflineCategory';  // 首页线下活动分类

    public static function getStatusOptions() {
        return array(
            self::STATUS_ENABLE => Yii::t('franchiseeCategory', '启用'),
            self::STATUS_DISABLE => Yii::t('franchiseeCategory', '禁用'),
        );
    }

    public static function getIndexShowOptions() {
        return array(
            self::INDEX_SHOW_NO => Yii::t('franchiseeCategory', '否'),
            self::INDEX_SHOW_YES => Yii::t('franchiseeCategory', '是'),
        );
    }

    public static function getStatusText($id) {
        $arr = self::getStatusOptions();
        return isset($arr[$id]) ? $arr[$id] : Yii::t('franchiseeCategory', '未知');
    }

    public static function getIndexShowText($id) {
        $arr = self::getIndexShowOptions();
        return isset($arr[$id]) ? $arr[$id] : Yii::t('franchiseeCategory', '未知');
    }

    public function tableName() {
        return '{{franchisee_category}}';
    }

    public function rules() {
        return array(
            array('parent_id, name', 'required'),
            array('status, show, sort', 'numerical', 'integerOnly' => true),
            array('name, thumbnail, keywords', 'length', 'max' => 128),
            array('content, description', 'length', 'max' => 256),
            array('create_time, update_time', 'length', 'max' => 11),
            array('name', 'unique'),
            array('parent_id', 'checkCreateCategory', 'on' => 'update'),
            array('status, show', 'in', 'range' => array(0, 1)),
//            array('sort', 'in', 'range' => array(1, 9)),
            array('thumbnail', 'file', 'types' => 'jpg,gif,png', 'allowEmpty' => true,
                'tooLarge' => Yii::t('franchiseeCategory', '图片最大不超过1MB，请重新上传!')),
//            array('thumbnail', 'checkFileSize','on'=>'insert'),
            array('create_time', 'default', 'value' => new CDbExpression('UNIX_TIMESTAMP()'), 'setOnEmpty' => false, 'on' => 'insert'),
            array('id, name, thumbnail, content, status, show, sort, keywords, description, create_time, update_time', 'safe', 'on' => 'search'),
            array('bgclass','length','max' => 20),
            array('bussbgclass','length','max' => 20),
        );
    }

    public function checkFileSize() {
        if (!isset($_FILES) || empty($_FILES))
            return true;
        list($width, $height, $type, $attr) = getimagesize($_FILES['FranchiseeCategory']['tmp_name']['thumbnail']);

        //去掉图片尺寸限制
//        if ($width != 25 && $height!= 25) // 判断选择父类是否是自身或自身子类的分类
//            $this->addError('thumbnail', Yii::t('franchiseeCategory', '图片尺寸不正确！'));
    }

    public function relations() {
        return array(
            'parentClass' => array(self::BELONGS_TO, 'FranchiseeCategory', 'parent_id'),
            'childClass' => array(self::HAS_MANY, 'FranchiseeCategory', 'parent_id', 'order' => 'sort desc'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'parent_id' => Yii::t('franchiseeCategory', '父类'),
            'name' => Yii::t('franchiseeCategory', '分类名称'),
            'thumbnail' => Yii::t('franchiseeCategory', '缩略图'),
            'content' => Yii::t('franchiseeCategory', '说明'),
            'status' => Yii::t('franchiseeCategory', '状态'),
            'show' => Yii::t('franchiseeCategory', '首页显示'),
            'sort' => Yii::t('franchiseeCategory', '排序'),
            'keywords' => Yii::t('franchiseeCategory', '关键词'),
            'description' => Yii::t('franchiseeCategory', '描述'),
            'create_time' => Yii::t('franchiseeCategory', '创建时间'),
            'update_time' => Yii::t('franchiseeCategory', '最后修改时间'),
            'bgclass' => Yii::t('franchiseeCategory', '首页分类LOGO样式类'),
            'bussbgclass' => Yii::t('franchiseeCategory', '商家分类LOGO样式类'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('name', $this->name, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('show', $this->show);
        $criteria->compare('keywords', $this->keywords, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 检查添加分类是否合法
     */
    public function checkCreateCategory() {
        $raw = $this->find('id = :parent_id And parent_id = :id', array('parent_id' => $this->parent_id, 'id' => $this->id)); // 查询是否有自身子类记录
        if ($this->id == $this->parent_id or ! is_null($raw)) // 判断选择父类是否是自身或自身子类的分类
            $this->addError('parent_id', Yii::t('franchiseeCategory', '选择父类不合法，不可以自身类和自身子类作为父类！'));
    }

    /**
     * 获取指定父类ID分类树数据 
     * @param int $id   可指定父类ID，$id为Null则查询所有分类， "0" :则获取顶级分类
     * @return array
     */
    public function getTreeData($id = null) {
        $data = array();
        $command = Yii::app()->db->createCommand();
        if ($id !== null) // 如指定父类ID，则加条件
            $command->where('t.parent_id = :parent_id', array('parent_id' => intval($id)));
        $record = $command->from($this->tableName() . ' as t') // type.name as typename,
                ->select('t.id, t.name as text, t.parent_id, t.status, t.sort, t.show, (select b.id from ' . $this->tableName() . ' as b where b.parent_id = t.id limit 1) as state') // name 字段别名了 text
                ->order('sort desc, id asc')
                ->queryAll();
        foreach ($record as $k => $v) {
            $data[$k] = $v;
            $data[$k]['state'] = is_null($v['state']) ? 'open' : 'closed';
        }
        return $data;
    }

    /**
     * 保存之前操作
     * @return boolean
     */
    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                
            } else {
                $this->update_time = time();
            }
            return true;
        } else
            return false;
    }

    /**
     * 保存之后操作
     * @return boolean
     */
    public function afterSave() {
        parent::afterSave();
        self::generateCategoryCacheFiles(); // 生成所有分类
    }

    /**
     * 删除之后操作
     */
    public function afterDelete() {
        parent::afterDelete();
        if ($this->thumbnail)
            UploadedFile::delete(Yii::getPathOfAlias('att') . DS . $this->thumbnail);
    }

    /**
     * 获取加盟商分类名称
     * @return string
     */
    public static function getFanchiseeCategoryName($id) {
        $model = FranchiseeCategory::model()->findByPk($id);
        return !isset($model->name) ? '' : $model->name;
    }

    /**
     * 从缓存中读取数据 region.name
     * 
     * @param  integer $id 
     * @return string
     */
    public static function getFanchiseeCategoryNameFromCache($id){

        $model = self::getCategoryById($id);
        return !isset($model['name']) ? '' : $model['name'];
    }

    /**
     * 根据加盟商id获取加盟商所属分类名称
     * $id  加盟商id
     * @return string
     */
    public static function getFanchiseeCategoryAllName($id) {
        $data = Yii::app()->db->createCommand()
                ->select('franchisee_category_id')
                ->from('{{franchisee_to_category}}')
                ->where('franchisee_id=:franchisee_id', array(':franchisee_id' => $id))
                ->queryColumn();
        if (!empty($data)) {
            $sqlStr = "";
            foreach ($data as $value) {
                $sqlStr .= $sqlStr == "" ? $value : "," . $value;
            }
            $dataStr = Yii::app()->db->createCommand()
                    ->select('name')
                    ->from('{{franchisee_category}}')
                    ->where('id in(' . $sqlStr . ')')
                    ->queryColumn();
            if (!empty($dataStr)) {
                $strName = "";
                foreach ($dataStr as $v) {
                    $strName .= $strName == "" ? $v : "、" . $v;
                }
                return $strName;
            }
        }
    }

    /**
     * 所有加盟商分类数据
     * @return array
     */
    public static function allFranchiseeCategory($generate = true) {
        $data = array();
        $categorys = Yii::app()->db->createCommand()->from('{{franchisee_category}}')
                        ->where('status = :status', array(':status' => FranchiseeCategory::STATUS_ENABLE))
                        ->order('sort DESC, id ASC')->queryAll();
        foreach ($categorys as $val) // 这里键原有的键值替换为分类自身ID
            $data[$val['id']] = $val;
        if ($generate === true) // 生成缓存
            Tool::cache(self::CACHEDIR)->set(self::CK_ALLCATEGORY, $data);
        return $data;
    }

    /**
     * 根据id 拉取数据【优先从缓存中拿去数据】
     * 
     * @param  interge  $id    category ID
     * @param  boolean  $isClearCache 是否清除缓存，重新生成数据
     * @return array
     */
    public static function getCategoryById($id,$isClearCache=false){

        static $categorys = null;

        if($categorys===null){
            if($isClearCache){
                $categorys = self::allFranchiseeCategory();
            }else{
                $categorys = Tool::cache(self::CACHEDIR)->get(self::CK_ALLCATEGORY);
                if(empty($categorys)){
                    $categorys = self::allFranchiseeCategory();  
                } 
            }
        }

        return isset($categorys[$id]) ? $categorys[$id] : array();
    }

    /**
     * 加盟商树型分类数据 
     * @param boolean $generate 是否生成缓存，默认为 true
     * @return array
     */
    public static function franchiseeTreeCategory($generate = true) {
        if (!$categorys = Tool::cache(self::CACHEDIR)->get(self::CK_ALLCATEGORY))
            $categorys = self::allFranchiseeCategory();
        $tree = array();
        $tempData = $categorys;
        foreach ($categorys as $val) {
            if (isset($tempData[$val['parent_id']])) {
                $tempData[$val['parent_id']]['childClass'][$val['id']] = &$tempData[$val['id']];
            } else {
                if ($val['parent_id'] == '0') {
                    $tree[$val['id']] = &$tempData[$val['id']];
                }
            }
        }
        if ($generate === true)
            Tool::cache(self::CACHEDIR)->set(self::CK_TREECATEGORY, $tree);
        return $tree;
    }

    /**
     * 生成线下活动分类数据缓存
     */
    public static function generateOfflineCategoryData() {
        if (!$tree = Tool::cache(self::CACHEDIR)->get(self::CK_TREECATEGORY))
            $tree = self::franchiseeTreeCategory();
        $data = array();
        foreach ($tree as $id => $val) {
            if ($val['show'] == self::INDEX_SHOW_YES)
                $data[$id] = $val;
        }
        Tool::cache(self::CACHEDIR)->set(self::CK_INDEXOFFLINECATEGORY, $data);
        return $data;
    }

    /**
     * 生成所有加盟商分类相应缓存
     */
    public static function generateCategoryCacheFiles() {
        self::allFranchiseeCategory(); // 生成所有加盟商分类数据缓存文件
        self::franchiseeTreeCategory(); // 生成树形分类数据文件
        self::generateOfflineCategoryData(); // 生成线下活动分类数据缓存
    }

    /**
     * 获取加盟商分类列表
     * author:rdj
     */
    public static function getFranchiseeCategory(){
        static $allData = array();

        if (empty($allData)) {
            $tn = self::model()->tableName();
            $sql = 'select id,parent_id,name,thumbnail from ' . $tn . ' where status = ' . self::VISIBLE . ' order by sort desc';
            $data = Yii::app()->db->createCommand($sql)->queryAll();
            $tree = array(); //格式化的树
            $tmpMap = array();  //临时数据

            foreach ($data as $item) {
                $tmpMap[$item['id']] = $item;
            }

            foreach ($data as $key => $item) {
                if (isset($tmpMap[$item['parent_id']])) {
                    if ($tmpMap[$item['parent_id']]['id'] == $item['parent_id']) {
                        $tmpMap[$item['parent_id']]['children'][] = &$tmpMap[$item['id']];
                    }
                } else {
                    $tree[] = &$tmpMap[$item['id']];
                }
            }
            unset($data);
            unset($tmpMap);
            $allData = $tree;
        }

        $data = array();
        foreach($allData as $key=>$v){
            array_push($data,array(
                'typeId'=>$v['id'],
                'typeName'=>$v['name'],
                'mediaId'=>$v['thumbnail'],
                'version'=>'1',
                'itemCount'=>intval(self::getItemCount($v['id'])),
                'secondTypeList'=>array(),
            ));

            if(isset($v['children'])){
                foreach($v['children'] as $val){
                    array_push($data[$key]['secondTypeList'], array(
                        'secondTypeId'=>$val['id'],
                        'secondTypeName'=>$val['name'],
                        'mediaId'=>$val['thumbnail'],
                        'version'=>'1',
                        'itemCount'=> intval(self::getItemCount($val['id'])),
                    ));
                }
            }
        }

        return $data;

    }

    /**
     * 获取此分类下有多少商家
     * @param type $cid
     * author rdj
     */
    public static function getItemCount($cid){
        return Yii::app()->db->createCommand()->select(array('count(1) as num'))->from('{{franchisee_to_category}}')->where('franchisee_category_id='.$cid)->queryScalar();
    }


    public static function getCategoryAll(){
        $data = Yii::app()->db->createCommand()->select('id,name')->from(FranchiseeCategory::model()->tableName())->queryAll();
        $categoryArr = array();
        foreach($data as $value){
            $categoryArr[$value['id']] = $value['name'];
        }
        return $categoryArr;
    }

}
