<?php

/**
 * 后台商品模型
 * @author wanyun.liu <wanyun_liu@163.com>
 * 
 * @property string $id
 * @property string $name
 * @property string $code
 * @property string $store_id
 * @property string $category_id
 * @property string $scategory_id
 * @property string $brand_id
 * @property string $sn
 * @property string $content
 * @property string $thumbnail
 * @property string $views
 * @property integer $is_publish
 * @property string $create_time
 * @property string $update_time
 * @property string $size
 * @property string $weight
 * @property integer $is_score_exchange
 * @property string $market_price
 * @property string $gai_price
 * @property string $price
 * @property string $discount
 * @property string $stock
 * @property integer $status
 * @property integer $show
 * @property string $return_score
 * @property string $fail_cause
 * @property string $sales_volume
 * @property integer $freight_template_id
 * @property integer $freight_payment_type
 * @property string $gai_income
 * @property integer $sort
 * @property string $keywords
 * @property string $description
 * @property string $sign_integral
 * @property string $type_id
 * @property string $attribute
 * @property string $goods_spec_id
 * @property string $spec_picture
 * @property string $spec_name
 * @property string $goods_spec
 * @property integer $ratio
 * @property integer $fee
 */
class Product extends CActiveRecord {

    protected static $floor = array(4, 1, 11, 9, 8);  // 首页楼层产品展示ID

    const SHOW_YES = 1;
    const SHOW_NO = 0;

    public $endGaiPrice;
    public $endPrice;
    public $endStock;
    public $cat_name;
    public $oldThumbnail;  //	旧缩略图
    public $path;    //图片列表
    public $brand_name;   //品牌名称
    public $isExport;   //是否导出excel
    public $exportPageName = 'page'; //导出excel时的分页参数名
    public $exportLimit = 5000; //导出excel长度
    public $active_status; //活动审核状态
    public $end_time;
    public $date_end;
    //开始与结束时间，用于搜索
    public $time_start;
    public $time_end;

    public static function getShow() {
        return array(
            self::SHOW_NO => '否',
            self::SHOW_YES => '是'
            );
    }
    /**
     * 设置数据库，如果场景是 DbCommand::DB 则使用从库
     * @return mixed
     */
    public function getDbConnection() {
        if($this->getScenario()==DbCommand::DB){
            return Yii::app()->db1;
        }else{
            return Yii::app()->db;
        }
    }

    public function tableName() {
        return '{{goods}}';
    }

    public function rules() {
        return array(
            array('name, code, market_price, price, gai_income, sign_integral, discount, category_id, is_publish, is_score_exchange, fee', 'required'),
            array('fee', 'validateFee'), // 服务费比率不得超出 "100"
            array('price', 'compare', 'compareAttribute' => 'gai_price', 'operator' => '>'), //零售价必须大于供货价
            array('gai_price', 'compare', 'compareAttribute' => 'market_price', 'operator' => '<'), //供货价必须小于市场价
            array('price', 'compare', 'compareAttribute' => 'market_price', 'operator' => '<='), // 零售价必须小于市场价
            array('content, life', 'safe'),
            array('stock', 'compare', 'compareValue' => '0', 'operator' => '>', 'message' => '必须大于0'),
            array('stock, is_publish, is_score_exchange, status, show, freight_template_id, freight_payment_type, sort', 'numerical', 'integerOnly' => true),
            array('name, thumbnail, fail_cause, keywords,brand_name', 'length', 'max' => 128),
            array('code, sn', 'length', 'max' => 64),
            array('store_id, category_id, scategory_id, views, create_time, update_time,brand_id, market_price, gai_price, price, discount, stock, return_score, sales_volume, gai_income, sign_integral, type_id, goods_spec_id', 'length', 'max' => 11),
            array('size, weight', 'length', 'max' => 8),
            array('description', 'length', 'max' => 256),
            array('path', 'length', 'max' => 1000),
            array('price', 'comparePrice'),
            array('id,endPrice, code, endStock, endGaiPrice, name, store_id, gai_price, price, is_publish, status,active_status,end_time,date_time,time_end,time_start,change_field', 'safe', 'on' => 'search'),
            );
}

    /**
     * 验证比率 、 不得超出 100
     * @param type $attribute
     * @param type $params
     */
    public function validateFee($attribute, $params) {
        if ($this->$attribute > 100)
            $this->addError($attribute, $this->getAttributeLabel($attribute) . '值不能超出"100"');
    }

    public function relations() {
        return array(
            'store' => array(self::BELONGS_TO, 'Store', 'store_id'),
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
            'brand' => array(self::BELONGS_TO, 'Brand', 'brand_id'),

            );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('goods', '商品id'),
            'name' => Yii::t('goods', '商品名称'),
            'code' => Yii::t('goods', '编号'),
            'store_id' => Yii::t('goods', '所属商家'),
            'category_id' => Yii::t('goods', '商城分类'),
            'cat_name' => Yii::t('goods', '商城分类'),
            'scategory_id' => Yii::t('goods', '店内分类'),
            'brand_id' => Yii::t('goods', '品牌'),
            'sn' => Yii::t('goods', '库号'),
            'content' => Yii::t('goods', '内容'),
            'thumbnail' => Yii::t('goods', '缩略图'),
            'views' => Yii::t('goods', '浏览数'),
            'is_publish' => Yii::t('goods', '是否发布'),
            'create_time' => Yii::t('goods', '创建时间'),
            'update_time' => Yii::t('goods', '更新时间'),
            'size' => Yii::t('goods', '体积'),
            'weight' => Yii::t('goods', '重量'),
            'is_score_exchange' => Yii::t('goods', '是否参加积分兑换'),
            'market_price' => Yii::t('goods', '初始零售价'),
            'gai_price' => Yii::t('goods', '供货价'),
            'price' => Yii::t('goods', '零售价'),
            'discount' => Yii::t('goods', '折扣积分'),
            'stock' => Yii::t('goods', '库存'),
            'status' => Yii::t('goods', '商品审核'),
            'show' => Yii::t('goods', '首页推荐'),
            'return_score' => Yii::t('goods', '返还积分'),
            'fail_cause' => Yii::t('goods', '下架原因'),
            'sales_volume' => Yii::t('goods', '销量'),
            'freight_template_id' => Yii::t('goods', '运输方式'),
            'freight_payment_type' => Yii::t('goods', '运费支付方式'),
            'gai_income' => Yii::t('goods', '盖网收入'),
            'sort' => Yii::t('goods', '排序'),
            'keywords' => Yii::t('goods', '关键词'),
            'description' => Yii::t('goods', '说明'),
            'sign_integral' => Yii::t('goods', '签到积分'),
            'type_id' => Yii::t('goods', '所属类型'),
            'attribute' => Yii::t('goods', '属性'),
            'goods_spec_id' => Yii::t('goods', '默认的商品规格关联'),
            'spec_picture' => Yii::t('goods', '商品规格图片'),
            'brand_name' => Yii::t('goods', '品牌'),
            'life' => Yii::t('goods', '是否删除'),
            'fee' => Yii::t('goods', '服务费比率'),
            'ratio' => Yii::t('goods', '中奖金额区间'),
            'activity_tag_id'=>Yii::t('goods', '活动类型'),
            'gai_sell_price'=>Yii::t('goods', '盖网售价'),
            'active_status' =>Yii::t('goods','活动审核'),
            'change_field' =>Yii::t('goods','商品修改项')
            );
}

public function search() {
    $this->setScenario(DbCommand::DB);
    $criteria = new CDbCriteria;
	if( isset($this->active_status) && $this->active_status != '' ){
		$criteria->select='t.*,spr.status AS active_status,srs.end_time AS end_time,srm.date_end AS date_end ';
		$criteria->join="LEFT JOIN {{seckill_product_relation}} AS spr ON t.id=spr.product_id LEFT JOIN {{seckill_rules_seting}} AS srs ON srs.id=spr.rules_seting_id LEFT JOIN {{seckill_rules_main}} AS srm ON srm.id=srs.rules_id";
	}
    $criteria->compare('t.id', $this->id);
    $criteria->compare('t.name', $this->name);
    $criteria->compare('t.code', $this->code);
    $criteria->compare('t.is_publish', $this->is_publish);
    $criteria->compare('t.gai_price', '>=' . $this->gai_price);
    $criteria->compare('t.gai_price', '<' . $this->endGaiPrice);
    $criteria->compare('t.price', '>=' . $this->price);
    $criteria->compare('t.price', '<' . $this->endPrice);
    $criteria->compare('t.stock', '>=' . $this->stock);
    $criteria->compare('t.stock', '<' . $this->endStock);
    if($this->change_field) $criteria->addCondition('t.change_field <>""'); 
    
    $criteria->compare('t.show', $this->show);
    $criteria->compare('t.activity_tag_id', $this->activity_tag_id);
        // $criteria->compare('t.active_status', $this->active_status);
    //上传商品时间
    $searchDate = Tool::searchDateFormat($this->time_start, $this->time_end);
    $criteria->compare('t.create_time', ">=" . $searchDate['start']);
    $criteria->compare('t.create_time', "<=" . $searchDate['end']);

        // 品牌
    if ($this->brand_id) {
        $brand = Brand::model()->find('name=:name', array(':name' => $this->brand_id));
        if ($brand)
            $criteria->compare('t.brand_id', $brand->id);
        else
            $criteria->compare('t.brand_id', 0);
    }

        // 商家
    if ($this->store_id) {
        $store = Store::model()->find('name=:name', array(':name' => $this->store_id));
        if ($store)
            $criteria->compare('t.store_id', $store->id);
        else
            $criteria->compare('t.store_id', 0);
    }

    if(isset($_GET['Product'])){
        $status = $_GET['Product']['status'];
        if($status === (String)Goods::STATUS_AUDIT || $status == Goods::STATUS_AUDIT_SECOND){
            if($status == Goods::STATUS_AUDIT_SECOND){
                $sql = '0 < (SELECT count(au.add_time) FROM {{goods_audit}} as au WHERE au.goods_id=t.id) ';
            }else{
                $sql = '0 = (SELECT count(au.add_time) FROM {{goods_audit}} as au WHERE au.goods_id=t.id) ';
            }
            $criteria->addCondition('t.life<>'.Goods::LIFE_YES);
            $criteria->addCondition($sql);
            $this->status = $status;
            $criteria->compare('t.status', Goods::STATUS_AUDIT);

        }else{
            $criteria->compare('t.status', $this->status);
        }
    }

        // 是否参加活动    
    if(isset($this->active_status)){
        if($this->active_status != ''){
          $criteria->addCondition("spr.status = {$this->active_status}");
          $criteria->addCondition("concat(srm.date_end,' ',srs.end_time) > now()");
         $criteria->addNotInCondition('t.seckill_seting_id', array(0));

      }     

  }

        // 分类
  if ($this->category_id) {
    $categorys = Category::allCategoryData();
    $categoryIds = array();
    $cid = 0;
    foreach ($categorys as $c) {
        if ($c['name'] == $this->category_id) {
            $cid = $c['id'];
            array_push($categoryIds, $c['id']);
            break;
        }
    }
    $category = Category::findChildCategoryElement($cid);
    if (isset($category[$cid]['childClass'])) {
        foreach ($category[$cid]['childClass'] as $c) {
            array_push($categoryIds, $c['id']);
            if (isset($c['childClass'])) {
                foreach ($c['childClass'] as $child) {
                    array_push($categoryIds, $child['id']);
                }
            }
        }
    }
    $criteria->addInCondition('t.category_id', $categoryIds);
}

//        // 关联
//$criteria->with = array(
//    'store' => array(
//        'select' => 'store.*',
//        ),
//    'category' => array(
//        'select' => 'category.*'
//        ),
//
//
//    );


$pagination = array();

if (!empty($this->isExport)) {
    $pagination['pageVar'] = $this->exportPageName;
    $pagination['pageSize'] = $this->exportLimit;
}

return new CActiveDataProvider($this, array(
    'criteria' => $criteria,
    'pagination' => $pagination,
    'sort' => array(
        'defaultOrder' => 't.id DESC',
        ),
    ));
}

    /**
     * 对比入货价和销售价
     */
    public function comparePrice($attribute, $params) {
        if ($this->price < $this->gai_price) {
            $this->addError('price', Yii::t('product', '零售价必须大于供货价'));
            $this->addError('gai_price', Yii::t('product', '供货价必须小于零售价'));
        }
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 显示库存量
     * @param int $num
     * @return string
     */
    public static function showStock($num) {
        return ($num >= 10) ? '<span style="color:green">' . $num . '</span>' : '<span style="color:#FF3C3C;font-weight:bold;">' . $num . '</span>';
    }

    /**
     * 显示发布状态
     * @param int $status
     * @param int $time
     * @return string
     */
    public static function showPublished($status, $time) {
        if ($status)
            return '是' . "<br />(" . date('Y-m-d H:i:s', $time) . ')';
        return '否';
    }

    /**
     * 显示价格
     * @param float $price
     * @return string
     */
    public static function showPrice($price) {
        return '<span class="jf">¥' . $price . '</span>';
    }

    /**
     * 显示状态
     * @param int $status
     * @return string
     */
    public static function showStatus($status, $reviewer, $auditTime) {
        if ($status == Goods::STATUS_AUDIT)
            $string = '<span style="color: Blue">审核中</span>';
        elseif ($status == Goods::STATUS_PASS)
            $string = '<span style="color: Green">通过</span>' . ( $reviewer ? ('(' . $reviewer . ')<br />(' . date('Y-m-d H:i:s', $auditTime) . ')') : '');
        elseif ($status == Goods::STATUS_NOPASS)
            $string = '<span style="color: Red">不通过</span>' . ($reviewer ? ('(' . $reviewer . ')<br />(' . date('Y-m-d H:i:s', $auditTime) . ')') : '');
        return $string;
    }

    public static function showNewStatus($status, $reviewer, $auditTime,$goods_id) {
        if ($status == Goods::STATUS_AUDIT || $status == Goods::STATUS_AUDIT_SECOND){
            if(GoodsAudit::getGoodsAudit($goods_id)){
                $string = '<span style="color: Blue">二次审核中</span>';
            }else{
                $string = '<span style="color: Blue">初次审核中</span>';
            }
        }elseif ($status == Goods::STATUS_PASS){
            $string = '<span style="color: Green">通过</span>' . ( $reviewer ? ('(' . $reviewer . ')<br />(' . date('Y-m-d H:i:s', $auditTime) . ')') : '');
        }elseif ($status == Goods::STATUS_NOPASS){
            $string = '<span style="color: Red">不通过</span>' . ($reviewer ? ('(' . $reviewer . ')<br />(' . date('Y-m-d H:i:s', $auditTime) . ')') : '');
        }

        return $string;
    }

    /**
     * 后台推荐商品
     * 推荐的商品将展示在首页
     */
    public static function showHome($id, $status) {
        $type = $status ? 'cancel' : 'recommend';
        $image = $status ? '/images/tick_circle.png' : '/images/cross_circle.png';
        $string = CHtml::ajaxLink(CHtml::image($image), array('/product/setRecommend'), array(
            'type' => 'POST',
            'dataType' => 'json',
            'data' => array(
                'id' => $id,
                'type' => $type,
                'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                ), 'success' => 'function(res){if(res.status){$.fn.yiiGridView.update("product-grid")}}'), array(
        'style' => 'display:block;width:20px;margin:0 auto;'
        ));
        return $string;
    }

    /**
     * 获取建议商品名称
     * 后台搜索商品用（auto complete）
     * @param string $keyword 关键字
     * @param int $limit 数量
     * @return array
     */
    public function suggestProducts($keyword, $limit = 20) {
        $products = $this->findAll(array(
            'condition' => 'name LIKE :keyword',
            'order' => 'id DESC',
            'limit' => $limit,
            'params' => array(
                ':keyword' => '%' . strtr($keyword, array('%' => '\%', '_' => '\_', '\\' => '\\\\')) . '%',
                ),
            ));
        $result = array();
        foreach ($products as $product) {
            $result[] = array(
                'value' => $product->name,
                );
        }
        return $result;
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            if (!$this->isNewRecord) {
                $this->update_time = time();
            }


            //保存缩略图
            $paths = explode('|', $this->path);
            if (!empty($paths)) {
                //删除旧的缩略图关系    先找出所有图片 然后对比删除不存在的图片
                $all_paths_rs = GoodsPicture::model()->findAll("goods_id={$this->id}");

                $all_paths = array();
                foreach ($all_paths_rs as $path) {
                    $all_paths[] = $path->path;
                }

                foreach ($all_paths as $p) {
                    if (!in_array($p, $paths)) {
                        UploadedFile::delete(Yii::getPathOfAlias('uploads') . DS . $p);
                    }
                }


                if (!$this->isNewRecord)
                    GoodsPicture::model()->deleteAll("goods_id={$this->id}");
                foreach ($paths as $path) {
                    $gp = new GoodsPicture();
                    $gp->goods_id = $this->id;
                    $gp->path = $path;
                    $gp->save();
                }
            }
            $this->audit_time = time();
            $this->reviewer = Yii::app()->user->name;
            $this->publisher = Yii::app()->user->name;
            return true;
        } else
        return false;
    }

    protected function afterFind() {
        parent::afterFind();

        $pics = GoodsPicture::model()->findAll("goods_id={$this->id}");
        $pic_arr = array();
        foreach ($pics as $val) {
            $pic_arr[] = $val->path;
        }
        $this->path = implode('|', $pic_arr);
    }

    /**
     * 保存后的操作
     * 更新商品缓存
     */
    protected function afterSave() {
        parent::afterSave();
        Tool::cache('common')->delete('indexFloorGoods');
        Tool::cache('common')->delete('indexRecommendGoods');
    }

    /**
     * 删除后操作
     * 更新下缓存（首页楼层，首页推荐）
     */
    public function afterDelete() {
        parent::afterDelete();
        Tool::cache('common')->delete('indexFloorGoods');
        Tool::cache('common')->delete('indexRecommendGoods');
    }

    /**
     * 网站首页各楼层的商品数据缓存
     * @param array $floor 分类ID数组
     * @return array
     */
    public static function floorGoodsDispose($floor) {
        if (!$treeCategory = Tool::cache(Category::CACHEDIR)->get(Category::CK_TREECATEGORY))
            $treeCategory = Category::treeCategory();
        $data = array();
        foreach ($floor as $k => $v) {//第一级
            if (!isset($treeCategory[$v]))
                continue;
            $data[$k]['id'] = $treeCategory[$v]['id'];
            $data[$k]['name'] = $treeCategory[$v]['name'];
            if (!isset($treeCategory[$v]['childClass']))
                continue;
            $allSubClass = array();
            foreach ($treeCategory[$v]['childClass'] as $tk => $tv) {//第二级
                $data[$k]['childClass'][$tk]['id'] = $tv['id'];
                $data[$k]['childClass'][$tk]['name'] = $tv['name'];
                array_push($allSubClass, $tv['id']);
                if (isset($tv['childClass'])) {
                    foreach ($tv['childClass'] as $cv)
                        array_push($allSubClass, $cv['id']);
                }
            }
            $goods = Yii::app()->db->createCommand()->select('id, name, thumbnail, price, return_score, goods_spec_id, store_id, status,gai_price,gai_income')
            ->from('{{goods}}')
            ->where('status = :status And is_publish = :push And life=:life And `show` = :show', array(
                ':status' => Goods::STATUS_PASS, ':push' => Goods::PUBLISH_YES, ':life' => Goods::LIFE_NO, ':show' => Product::SHOW_YES
                ))->andWhere(array('in', 'category_id', $allSubClass))
            ->order('sort desc')
            ->limit(10)
            ->queryAll();
            $data[$k]['goods'] = $goods;
        }
        Tool::cache('common')->set('indexFloorGoods', $data, Yii::app()->params['cache']['indexFloorGoods']);
        return $data;
    }
    
    /**
     * 获取商品价格
     * @param type $id
     * @return boolean
     */
    public static function getGoodsPrice($id){
        if(is_numeric($id)){
            $model = self::model()->findByPk($id);
            if($model){
                return $model->price;
            }
        }
        return false;
    }
    /**
     * 
     * @param type $data
     */
    public static function getGoodsActivePrice($data){
        $price = self::getGoodsPrice($data->product_id);
        if($data->discount_price != 0){
            return $data->discount_price;
        } 
        if($data->discount_rate){
            if($data->category_id == 1){
                return  bcmul(bcdiv((100-$data->discount_rate),100,2),$price,2);//bcdiv(100-$data->discount_rate)/100)*$price, 1 );
            } else {
                return bcmul(bcdiv($data->discount_rate,100,2),$price,2);
            }
        }
        return $price;
    }
}
