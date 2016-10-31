<?php

/**
 * 品牌模型
 * @author wencong.lin <183482670@qq.com>
 *
 * @property integer $id
 * @property string $name
 * @property string $logo
 * @property integer $status
 * @property string $code
 * @property integer $store_id
 * @property integer $category_id 
 * @property string $content
 * @property integer $sort
 */
class Brand extends CActiveRecord {

    const STATUS_AUDIT = 0;
    const STATUS_THROUGH = 1;
    const STATUS_NOTTHROUGH = 2;

    public $storeName;
    public $mobile;
    public $cname;
    /**
     * 获取品牌状态
     * @return array
     */
    public static function status() {
        return array(
            self::STATUS_AUDIT => Yii::t('brand', '审核中'),
            self::STATUS_THROUGH => Yii::t('brand', '审核通过'),
            self::STATUS_NOTTHROUGH => Yii::t('brand', '审核不通过')
        );
    }

    public function tableName() {
        return '{{brand}}';
    }

    public function rules() {
        return array(
            array('name, code', 'required'),
            array('name', 'unique'),
            array('status, sort', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 20),
            array('code', 'length', 'max' => 32),
            array('content', 'length', 'max' => 512),
            array('sort', 'length', 'max' => 3),
            array('store_id, category_id', 'length', 'max' => 11),
            array('logo', 'file', 'allowEmpty' => true, 'types' => 'jpg,jpeg,gif,png', 'maxSize' => 1024 * 1024 * 1, 'tooLarge' => Yii::t('brand', '上传图片最大不能超过1Mb,请重新上传')),
            array('name, code,storeName,mobile', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'store' => array(self::BELONGS_TO, 'Store', 'store_id'),
            'category' => array(self::BELONGS_TO, 'Category', 'category_id')
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => Yii::t('brand', '品牌名称'),
            'logo' => Yii::t('brand', '品牌Logo'),
            'status' => Yii::t('brand', '品牌状态'),
            'code' => Yii::t('brand', '简码'),
            'store_id' => Yii::t('brand', '所属商家'),
            'category_id' => Yii::t('brand', '所属分类'),
            'content' => Yii::t('brand', '品牌说明'),
            'sort' => Yii::t('brand', '排序'),
            'storeName' => Yii::t('brand', '所属商家'),
            'mobile'=>Yii::t('brand', '手机号码'),
        );
    }

    /**
     * 后台列表
     * @return \CActiveDataProvider
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    public function search() {
        $criteria = new CDbCriteria;
        $criteria->select = 't.*,s.name as storeName,s.mobile,c.name as cname';
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('s.name', $this->storeName, true);
        $criteria->compare('s.mobile', $this->mobile, true);
        $criteria->compare('t.status', $this->status);
        $criteria->join = 'left join {{store}} as s on s.id=t.store_id left join {{category}} as c on t.category_id=c.id';
//        $criteria->with = array(
//            'category' => array('select' => 'name'),
//        );
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.id DESC',
            ),
        ));
    }

    /**
     * 获取分类品牌
     * @param int $categoryId
     * @param int $storeId
     * @return array
     */
    public function getCategoryBrands($categoryId, $storeId = null,$limit=null) {
        $brands = Yii::app()->db->createCommand()
                        ->from('{{brand}}')->where('status = :status And category_id = :catid', array(':status' => Brand::STATUS_THROUGH, 'catid' => $categoryId));
        if ($storeId !== null)
            $brands->where(array('and', "store_id = {$storeId}"));
        if($limit!==null){
            $brands->limit($limit);
        }
        return $brands->order('sort DESC')->queryAll();
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function showStatus($status) {
        switch ($status) {
            case self::STATUS_AUDIT:
                $status = Yii::t('brand', '审核中');

                break;
            case self::STATUS_THROUGH:
                $status = Yii::t('brand', '审核通过');
                break;
            default:
                $status = Yii::t('brand', '审核不通过');
                break;
        }
        return $status;
    }

    /**
     * 删除后的操作
     * 删除当前广告位下的的广告图片
     */
    protected function afterDelete() {
        parent::afterDelete();
        if (isset($this->logo))
            UploadedFile::delete(Yii::getPathOfAlias('uploads') . DS . $this->logo);
    }

    /**
     * 获取建议品牌名称
     * 后台搜索商品用（auto complete）
     * @param string $keyword 关键字
     * @param int $limit 数量
     * @return array
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    public function suggestBrands($keyword, $limit = 20) {
        $brands = $this->findAll(array(
            'condition' => 'name LIKE :keyword and status=:status',
            'order' => 'id DESC',
            'limit' => $limit,
            'params' => array(
                ':keyword' => '%' . strtr($keyword, array('%' => '\%', '_' => '\_', '\\' => '\\\\')) . '%',
                ':status'=>self::STATUS_THROUGH,
            ),
        ));
        $result = array();
        foreach ($brands as $brand) {
            if(!empty($brand->store_id) && $brand->store_id!=Yii::app()->user->getState('storeId')) continue;
            $result[] = array(
                'value' => $brand->name,
                'id' => $brand->id,
            );
        }
//        Tool::pr($result);die;
        return $result;
    }

    public static function getBrandsName($id) {
        $id = $id * 1;
        $brand = self::model()->find("id={$id}");
        if (!empty($brand)) {
            return $brand->name;
        } else {
            if($id==0) return Yii::t('brand',"无品牌");
            return false;
        }
    }
    /**
     * 根据栏目ID获取品牌
     * @param int $categoryId 栏目ID
     * @param int $limit 
     * @return array 品牌栏目信息
     */
    public static function getBrandInfo($categoryId,$brand=null,$limit=null)
    {
        $condition= array(
            'condition'=> '`category_id`=:cid AND status=:status AND `name` LIKE :brand',
            'params'=> array(':cid'=>$categoryId,':status'=> self::STATUS_THROUGH, ':brand'=>"%$brand%"),
        );
        if($limit) $condition['limit'] =$limit;
        return self::model()->findAll($condition);   
    }

    /**
     * 根据ID获取品牌
     * @param int $brand_id
     * @return string 品牌名
     */
    public static function getBrand($brand_id){
        $model = self::model()->findByPk($brand_id);
        return $model ? $model->name :null;
    }
}
