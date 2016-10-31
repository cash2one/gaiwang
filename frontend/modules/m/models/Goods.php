<?php

/**
 * 商品模型
 * @author binbin.liao <277250538@qq.com>
 * The followings are the available columns in table '{{goods}}':
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
 * @property string $avg_score
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
 * @property string $good_spec
 * @property string $life
 * @property integer $fee
 * @property integer $ratio
 * @property string $goods_spec
 * @property string $publisher
 * @property string $join_activity
 * @property string $activity_tag_id
 *
 */
class Goods extends CActiveRecord {

    const GAI_INCOME = 50; //盖网收入,暂时固定
    //是否删除，删除商品只是做标记处理
    const LIFE_YES = 1;  //删除
    const LIFE_NO = 0;   //默认
    const STATUS_AUDIT = 0;
    const STATUS_PASS = 1;
    const STATUS_NOPASS = 2;
    const IS_SCORE_EXCHANGE = 1;
    const SCORE_UNIT = 10; // 评论分数单位为10

    public $categoryName;
    public $at_status; //关联参加活动的状态

    /**
     * 审核状态用文字标示
     * @param null|int $status 查询出来的审核状态(0 审核中,1 审核通过 2 未通过)
     * @return array|null
     */
    public static function getStatus($status = null) {
        $arr = array(
            self::STATUS_AUDIT => Yii::t('goods', '审核中'),
            self::STATUS_PASS => Yii::t('goods', '审核通过'),
            self::STATUS_NOPASS => Yii::t('goods', '审核未通过'),
        );
        if (is_numeric($status)) {
            return isset($arr[$status]) ? $arr[$status] : null;
        } else {
            return $arr;
        }
    }

    public $spec_id;
    public $pic;
    public $brand_name;

    const PUBLISH_NO = 0;
    const PUBLISH_YES = 1;
    const AD_GOODS_NO = 0;
    const AD_GOODS_YES = 1;

    const JOIN_ACTIVITY_NO=0; //没有参与红包活动
    const JOIN_ACTIVITY_YES =1; //参加红包活动
    /**
     * 广告商品状态
     * @param null $key
     * @return array|bool
     */
    public static function adGoodsStatus($key = null) {
        $arr = array(
            self::AD_GOODS_NO => Yii::t('goods', '否'),
            self::AD_GOODS_YES => Yii::t('goods', '是'),
        );
        if (is_numeric($key)) {
            return isset($arr[$key]) ? $arr[$key] : false;
        } else {
            return $arr;
        }
    }

    /**
     * 是否发布，上架
     * @param null $key
     * @return array|bool
     */
    public static function publishStatus($key = null) {
        $arr = array(
            self::PUBLISH_NO => Yii::t('goods', '否'),
            self::PUBLISH_YES => Yii::t('goods', '是'),
        );
        if (is_numeric($key)) {
            return isset($arr[$key]) ? $arr[$key] : false;
        } else {
            return $arr;
        }
    }

    // 作了下修改。lwy，原来是0，1，2。现在修改为1，2，3

    const FREIGHT_TYPE_SELLER_BEAR = 1; //包邮
    const FREIGHT_TYPE_CASH_ON_DELIVERY = 2; //运费到付
    const FREIGHT_TYPE_MODE = 3; //运费模板

    /**
     * 运费支付方式
     * @param $k
     * @return array|null
     */

    public static function freightPayType($k = null) {
        $arr = array(
            self::FREIGHT_TYPE_SELLER_BEAR => Yii::t('goods', '包邮'),
            self::FREIGHT_TYPE_CASH_ON_DELIVERY => Yii::t('goods', '运费到付'),
            self::FREIGHT_TYPE_MODE => Yii::t('goods', '运费模板'),
        );
        if (is_numeric($k)) {
            return isset($arr[$k]) ? $arr[$k] : null;
        } else {
            return $arr;
        }
    }

    /**
     * 是否删除，删除商品只是做标记处理
     * @param null $k
     * @return array|null
     */
    public static function deleteStatus($k = null) {
        $arr = array(
            self::LIFE_YES => '是',
            self::LIFE_NO => '否',
        );
        if (is_numeric($k)) {
            return isset($arr[$k]) ? $arr[$k] : null;
        } else {
            return $arr;
        }
    }

    public function tableName() {
        return '{{goods}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('spec_picture', 'file', 'types' => 'jpg,gif,png', 'maxSize' => 1024 * 1024 * 1,
                'tooLarge' => Yii::t('goods', '颜色图片文件大于1M，上传失败！请上传小于1M的文件！'), 'on' => 'insert', 'allowEmpty' => true),
            array('name, code,stock,category_id,scategory_id,content,market_price, price,freight_payment_type,thumbnail', 'required'),
            array('name','match','pattern' => '/([\s]+)/', 'not' => true, 'message'=>Yii::t('goods', '商品名不能有空格！')),
            array('brand_id', 'required', 'message' => '没有该品牌，请创建'),
            array('stock', 'compare', 'compareValue' => '0', 'operator' => '>=', 'message' => '必须大于等于0', 'on' => 'insert,update'),
            array('freight_template_id', 'validateFreightTemplate'),
//            array('price', 'compare', 'compareAttribute' => 'gai_price', 'operator' => '>'), //零售价必须大于供货价
            array('gai_price', 'compare', 'compareAttribute' => 'market_price', 'operator' => '<'), //供货价必须小于市场价
            array('price', 'compare', 'compareAttribute' => 'market_price', 'operator' => '<='), // 零售价必须小于市场价
       //     array('gai_sell_price','compare','compareAttribute'=>'price','operator'=>'>','on'=>'updateBack'), //盖网提供的售价必须大于商家提供的售价
        //    array('gai_sell_price','compare','compareAttribute'=>'market_price','operator'=>'<=','on'=>'updateBack'), //盖网提供的售价必须小于市场价
            array('gai_sell_price,price,market_price','numerical'),
            array('stock, is_publish, is_score_exchange, status, show, freight_template_id, freight_payment_type, sort,join_activity,activity_tag_id', 'numerical', 'integerOnly' => true),
            array('scategory_id', 'compare', 'operator' => '>', 'compareValue' => 0, 'message' => Yii::t('goods', '分类不能为空')),
            array('name, thumbnail, fail_cause, keywords', 'length', 'max' => 128),
            array('code, sn', 'length', 'max' => 64),
            array('store_id, category_id, scategory_id, brand_id, views, create_time, update_time,  stock, sales_volume, type_id, goods_spec_id', 'length', 'max' => 11),
            array('market_price, price,return_score,gai_income,gai_price,gai_sell_price', 'length', 'max' => 14),//要考虑小数点，不能限制到11位
            array('size, weight', 'length', 'max' => 8),
            array('size,weight', 'match', 'message' => '只能为非负数字，保留两位小数', 'pattern' => '/^\d+\.*\d{0,2}$/'), //验证 
            array('description', 'length', 'max' => 256),
            array('id, name, code, store_id, category_id, scategory_id, brand_id, sn, content, thumbnail,
             views, is_publish, create_time, update_time, size, weight, is_score_exchange,
             market_price, gai_price, price, discount, stock, status, show, return_score, fail_cause,
             sales_volume, freight_template_id, freight_payment_type, gai_income, sort, keywords,
             description, sign_integral, type_id, attribute, goods_spec_id, spec_picture, spec_name,
             goods_spec,life,join_activity', 'safe', 'on' => 'search'),
            array('name,code,keywords,description,sn', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('join_activity','validateActivity','allowEmpty'=>true),//参加了专题活动商品,合约机,大额商品就不能参加红包活动
         //   array('gai_sell_price','comext.validators.requiredExt','allowEmpty'=>!$this->checkHasRedActivity(),'on'=>'updateBack'),
            array('gai_sell_price','checkHasRedActivity','on'=>'updateBack'),

        );
    }

    /**
     * 如果参加了活动,盖网销售价必须填
     * @return bool
     * @author binbin.liao
     */
    public function checkHasRedActivity($attribute, $params)
    {
        if ($this->join_activity == self::JOIN_ACTIVITY_YES) {
            if ($this->gai_sell_price <= $this->price)
                $this->addError($attribute, Yii::t('goods', '盖网提供的售价必须大于商家提供的售价'));
            elseif ($this->gai_sell_price > $this->market_price)
                $this->addError($attribute, Yii::t('goods', '盖网提供的售价必须小于市场价'));
        }
    }


    /**
     * 运费模板检查
     * @param $attribute
     * @param $params
     */
    public function validateFreightTemplate($attribute, $params) {
        if ($this->freight_payment_type == self::FREIGHT_TYPE_MODE && empty($this->$attribute)) {
            $this->addError($attribute, Yii::t('goods', '请选择运费模板'));
        }
    }

    /**
     * 参加活动之前的检查
     * @param $attribute
     * @param $params
     */
    public function validateActivity($attribute, $params)
    {
        if (!empty($this->$attribute)) {
            $special = SpecialTopicGoods::hasActive($this->id);
            if ($special) {
                $this->addError($attribute, Yii::t('goods', '已经参加了专题优惠活动'));
            }

            $goodsArr = Heyue::getHeyueList();
            if(in_array($this->id,$goodsArr)){
                $this->addError($attribute, Yii::t('goods', '合约机不能参加红包活动'));
            }

            $goodsArr = explode(',',Tool::getConfig('order','specialGoods'));
            if(in_array($this->id,$goodsArr)){
                $this->addError($attribute, Yii::t('goods', '大宗金额商品不能参加红包活动'));
            }
        }
    }
    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'goods2spec_id' => array(self::HAS_MANY, 'GoodsSpec', 'goods_id'), //商品与规格
            'goodsPicture' => array(self::HAS_MANY, 'GoodsPicture', 'goods_id'), //商品与多图片
            'store' => array(self::BELONGS_TO, 'Member', 'store_id'), //所属商家
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'), //所属分类
            'freightTemplate' => array(self::BELONGS_TO, 'FreightTemplate', 'freight_template_id'),
            'brand' => array(self::BELONGS_TO, 'Brand', 'brand_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('goods', '主键'),
            'name' => Yii::t('goods', '商品名称'),
            'code' => Yii::t('goods', '编号'),
            'store_id' => Yii::t('goods', '所属商家'),
            'category_id' => Yii::t('goods', '商城分类'),
            'scategory_id' => Yii::t('goods', '本店分类'),
            'brand_id' => Yii::t('goods', '品牌名称'),
            'sn' => Yii::t('goods', '库号'),
            'content' => Yii::t('goods', '内容'),
            'thumbnail' => Yii::t('goods', '封面图片'),
            'views' => Yii::t('goods', '浏览数'),
            'is_publish' => Yii::t('goods', '是否发布'),
            'create_time' => Yii::t('goods', '创建时间'),
            'update_time' => Yii::t('goods', '更新时间'),
            'size' => Yii::t('goods', '体积'),
            'weight' => Yii::t('goods', '重量'),
            'is_score_exchange' => Yii::t('goods', '是否参加积分兑换'),
            'market_price' => Yii::t('goods', '市场价'),
            'gai_price' => Yii::t('goods', '供货价'),
            'price' => Yii::t('goods', '零售价'),
            'discount' => Yii::t('goods', '折扣积分'),
            'stock' => Yii::t('goods', '库存'),
            'status' => Yii::t('goods', '审核状态'),
            'show' => Yii::t('goods', '首页推荐'),
            'return_score' => Yii::t('goods', '返还积分'),
            'fail_cause' => Yii::t('goods', '下架原因'),
            'sales_volume' => Yii::t('goods', '销量'),
            'freight_template_id' => Yii::t('goods', '运费模板'),
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
            'brand_name' => Yii::t('goods', '品牌名称'),
            'join_activity'=>Yii::t('goods', '是否参加红包活动'),
            'activity_tag_id'=>Yii::t('goods', '红包活动'),
            'gai_sell_price'=>Yii::t('goods','盖网售价'),
        );
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('store_id', $this->store_id, true);
        $criteria->compare('category_id', $this->category_id, true);
        $criteria->compare('scategory_id', $this->scategory_id, true);
        $criteria->compare('brand_id', $this->brand_id, true);
        $criteria->compare('sn', $this->sn, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('thumbnail', $this->thumbnail, true);
        $criteria->compare('views', $this->views, true);
        $criteria->compare('is_publish', $this->is_publish);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('size', $this->size, true);
        $criteria->compare('weight', $this->weight, true);
        $criteria->compare('is_score_exchange', $this->is_score_exchange);
        $criteria->compare('market_price', $this->market_price, true);
        $criteria->compare('gai_price', $this->gai_price, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('discount', $this->discount, true);
        $criteria->compare('stock', $this->stock, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('show', $this->show);
        $criteria->compare('return_score', $this->return_score, true);
        $criteria->compare('fail_cause', $this->fail_cause, true);
        $criteria->compare('sales_volume', $this->sales_volume, true);
        $criteria->compare('freight_template_id', $this->freight_template_id);
        $criteria->compare('freight_payment_type', $this->freight_payment_type);
        $criteria->compare('gai_income', $this->gai_income, true);
        $criteria->compare('sort', $this->sort);
        $criteria->compare('keywords', $this->keywords, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('sign_integral', $this->sign_integral, true);
        $criteria->compare('type_id', $this->type_id, true);
        $criteria->compare('attribute', $this->attribute, true);
        $criteria->compare('goods_spec_id', $this->goods_spec_id, true);
        $criteria->compare('spec_picture', $this->spec_picture, true);

        if (Yii::app()->request->getParam('store_id')) {
            $criteria->compare('store_id', Yii::app()->request->getParam('store_id'));
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20, //分页
            ),
            'sort' => array(//'defaultOrder'=>' DESC', //设置默认排序
            ),
        ));
    }

    /**
     * 卖家平台的商品列表
     * @param $storeId
     * @return CActiveDataProvider
     */
    public function sellerSearch($storeId) {
        $criteria = new CDbCriteria;
        $criteria->addCondition('store_id=' . $storeId . ' and life=' . self::LIFE_NO);
//零售价区间
        $price_start = intval(Yii::app()->request->getParam('price_start'));
        $price_end = intval(Yii::app()->request->getParam('price_end'));
        if ($price_end > $price_start) {
            $criteria->addBetweenCondition('price', $price_start, $price_end);
        }
//库存区间
        $stock_start = intval(Yii::app()->request->getParam('stock_start'));
        $stock_end = intval(Yii::app()->request->getParam('stock_end'));
        if ($stock_end > $stock_start) {
            $criteria->addBetweenCondition('stock', $stock_start, $stock_end);
        }
//供货价区间
        $gai_price_start = intval(Yii::app()->request->getParam('gai_price_start'));
        $gai_price_end = intval(Yii::app()->request->getParam('gai_price_end'));
        if ($gai_price_end > $gai_price_start) {
            $criteria->addBetweenCondition('gai_price', $gai_price_start, $gai_price_end);
        }
        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('code', $this->code, true);

        $criteria->compare('category_id', $this->category_id, true);
        $criteria->compare('scategory_id', $this->scategory_id, true);
        $criteria->compare('brand_id', $this->brand_id, true);
        $criteria->compare('sn', $this->sn, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('thumbnail', $this->thumbnail, true);
        $criteria->compare('views', $this->views, true);
        $criteria->compare('is_publish', $this->is_publish);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('size', $this->size, true);
        $criteria->compare('weight', $this->weight, true);
        $criteria->compare('is_score_exchange', $this->is_score_exchange);
        $criteria->compare('market_price', $this->market_price, true);
        $criteria->compare('gai_price', $this->gai_price, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('discount', $this->discount, true);
        $criteria->compare('stock', $this->stock, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('show', $this->show);
        $criteria->compare('return_score', $this->return_score, true);
        $criteria->compare('fail_cause', $this->fail_cause, true);
        $criteria->compare('sales_volume', $this->sales_volume, true);
        $criteria->compare('freight_template_id', $this->freight_template_id);
        $criteria->compare('freight_payment_type', $this->freight_payment_type);
        $criteria->compare('gai_income', $this->gai_income, true);
        $criteria->compare('sort', $this->sort);
        $criteria->compare('keywords', $this->keywords, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('sign_integral', $this->sign_integral, true);
        $criteria->compare('type_id', $this->type_id, true);
        $criteria->compare('attribute', $this->attribute, true);
        $criteria->compare('goods_spec_id', $this->goods_spec_id, true);
        $criteria->compare('spec_picture', $this->spec_picture, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20, //分页
            ),
            'sort' => array(
                'defaultOrder' => 'create_time DESC', //设置默认排序
            ),
        ));
    }

    /**
     * 选择商品
     * @return \CActiveDataProvider
     */
    public function selectGoods() {
        $criteria = new CDbCriteria;
        $criteria->with = array();
        $criteria->compare('t.stock', '<> 0');
        $criteria->compare('t.name', $this->name, true);
        $categoryName = Tool::magicQuotes(Yii::app()->request->getParam('categoryName', null));
        if (isset($categoryName)) { // 分类
            $criteria->with += array('category');
            $criteria->compare('category.name', $categoryName, true);
        }
        // 零售价区间
        $minPrice = intval(Yii::app()->request->getParam('minPrice'));
        $maxPrice = intval(Yii::app()->request->getParam('maxPrice'));
        if ($maxPrice > $minPrice) {
            $criteria->addBetweenCondition('price', $minPrice, $maxPrice);
        }
        // 查找所有专题商品ID
        $sql = "SELECT `goods_id` FROM {{special_topic_goods}}";
        $sgid = Yii::app()->db->createCommand($sql)->queryColumn();
        // 查询的商品不等于已存在的专题商品
        $criteria->addNotInCondition('t.id', $sgid);
        $criteria->compare('t.status', self::STATUS_PASS);
        $criteria->compare('t.is_publish', self::PUBLISH_YES);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20, // 分页
            ),
            'sort' => array(
                'defaultOrder' => 't.id DESC', // 设置默认排序
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->create_time = time();
                $this->gai_income = self::GAI_INCOME;
            } else {
                $this->update_time = time();
            }

            //序列化数组字段
            if (is_array($this->goods_spec))
                $this->goods_spec = serialize($this->goods_spec);
            if (is_array($this->attribute))
                $this->attribute = serialize($this->attribute);
            if (is_array($this->spec_name))
                $this->spec_name = serialize($this->spec_name);
            if (is_array($this->spec_picture))
                $this->spec_picture = serialize($this->spec_picture);

            return true;
        } else {
            return false;
        }
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
     * 验证之后
     */
    public function afterValidate() {
        parent::afterValidate();
    }

    /**
     * 显示首页推荐显示链接
     * @param  $show 状态 1为显示已推荐,0为显示未推荐
     */
    public static function getShowLink($show = 0, $id = 0) {
        if ($show == 1) {
            echo '<a href="javascript:Cancel(' . $id . ', \'cancel_\')" id="cancel_' . $id . '">取消推荐</a>';
            echo CHtml::link('取消推荐', 'javascript:Cancel(' . $id . ', \'cancel_\')', array('id' => 'cancel_' . $id));
        } else {
            echo CHtml::link('设为推荐', 'javascript:show(' . $id . ', \'cancel_\')', array('id' => 'cancel_' . $id, 'style' => 'color:red'));
        }
    }

    /**
     * 查询指定商品数据
     * @param $goods_id 商品id
     * @param $field 要查询的字段
     * @return array
     */
    public static function getGoodsData($goods_id, array $field) {
        $fields = implode(',', $field);
        return Yii::app()->db->createCommand()->select($fields)->from('{{goods}}')->where('id=:goods_id', array(':goods_id' => $goods_id))->queryRow();
    }

    /**
     * 关联规格值查询数据
     */
    public static function goodsSpec($goods_id, $spec_id) {
        $data = Yii::app()->db->createCommand()->select('g.name,g.thumbnail,sp.price')->from('{{goods g}}')->leftjoin('{{goods_spec}} sp', 'ON sp.goods_id=g.id')->where('g.id=:goods_id AND sp.id=:spec_id', array(':goods_id' => $goods_id, ':spec_id' => $spec_id))->queryRow();
        return $data;
    }

    /**
     * 根据商品id集合，获取数据,并按照id排序
     * @param string $ids 多个商品id,逗号分隔
     * @param string $fields 需要返回的字段，逗号分隔
     * @return array
     */
    public static function getGoodsByIds($ids, $fields = 'id,name,price,thumbnail') {
        $idArray = explode(',', $ids);
        return Yii::app()->db->createCommand()
        ->select($fields)
        ->from('{{goods}}')
        ->where(array('in', 'id', $idArray))
        ->order('field(id, \'' . implode("','", $idArray) . '\')')
        ->queryAll();
    }

    /**
     * 店铺本周热销商品排行，暂时显示总销量排行
     * @param int $storeId 店铺id
     * @param int $num 个数
     * @param string $fields 字段
     * @return array
     */
    public static function hotSales($storeId, $num, $fields = 'id,name,price,thumbnail,sales_volume') {
        return Yii::app()->db->createCommand()
        ->select($fields)
        ->from('{{goods}}')
        ->limit($num)
        ->order('sales_volume DESC')
        ->where('store_id=:store_id and status=' . self::STATUS_PASS)
        ->bindParam(':store_id', $storeId)
        ->queryAll();
    }

    /**
     * 获取商品，根据自定义排序，店铺id
     * @param $storeId 店铺id
     * @param $num
     * @param string $fields
     * @param string $order
     * @return array
     */
    public static function getGoodsOrder($storeId, $num, $order = 'id DESC', $fields = 'id,name,price,thumbnail,create_time,goods_spec_id') {
        return Yii::app()->db->createCommand()
        ->select($fields)
        ->from('{{goods}}')
        ->limit($num)
        ->order($order)
        ->where('store_id=:store_id and status=' . self::STATUS_PASS)
        ->bindParam(':store_id', $storeId)
        ->queryAll();
    }

    /**
     * 商品页面，获取商品详情
     * @param $id
     * @return mixed
     */
    public static function getGoodsDetail($id) {
        $sql = "SELECT b.name AS bname, g.*, r1.short_name AS city,r2.short_name as province,f.valuation_type,at.status AS at_status  FROM `gw_goods` AS g
                LEFT JOIN `gw_freight_template` AS f ON g.freight_template_id = f.id
                LEFT JOIN `gw_store_address` AS c ON f.store_address_id = c.id
                LEFT JOIN `gw_region` AS r1 ON r1.id = c.city_id
                LEFT JOIN `gw_region` AS r2 ON r2.id = c.province_id
                LEFT JOIN `gw_brand` AS b ON b.id = g.brand_id
                LEFT JOIN `gw_activity_tag` AS at ON g.activity_tag_id = at.id
                WHERE  g.id=:id";
        $goods = Yii::app()->db->createCommand($sql)->bindValues(array(':id' => $id))->queryRow();
        if ($goods) {
            //将相关字段反序列化
            $goods['spec_picture'] = empty($goods['spec_picture']) ? array() : unserialize($goods['spec_picture']);
            $goods['spec_name'] = empty($goods['spec_name']) ? array() : unserialize($goods['spec_name']);
            $goods['goods_spec'] = empty($goods['goods_spec']) ? array() : unserialize($goods['goods_spec']);
            $goods['attribute'] = empty($goods['attribute']) ? array() : unserialize($goods['attribute']);
            //该商品是否有参与优惠活动,如果有，则使用优惠活动的价格
            $special = SpecialTopicGoods::hasActive($goods['id']);
            if ($special) {
                $goods = array_merge($goods, $special);
            } else {
                $goods['special_name'] = null;
                $goods['special_topic_id'] = null;
            }
            //该商品是否有参加红包活动,如果有参加,则使用盖网提供的售价
            if ($goods['join_activity'] == self::JOIN_ACTIVITY_YES && !empty($goods['activity_tag_id']) && $goods['at_status'] ==ActivityTag::STATUS_ON) {
                $goods['price'] = $goods['gai_sell_price'];
            }
        }
        return $goods;
    }

    /**
     * 购物车获取单个商品详情
     * @param $id
     * @return array|mixed
     */
    public static function getCartGoodsDetail($id) {
        $sql = "SELECT g.id, g.price,g.life,g.is_publish,g.status,g.store_id,g.join_activity,g.gai_sell_price,g.activity_tag_id,at.status AS at_status  FROM `gw_goods` AS g LEFT JOIN `gw_activity_tag` AS at ON g.activity_tag_id = at.id WHERE  g.id=:id";
        $goods = Yii::app()->db->createCommand($sql)->bindValues(array(':id' => $id))->queryRow();
        if ($goods) {
            //该商品是否有参与优惠活动,如果有，则使用优惠活动的价格
            $special = SpecialTopicGoods::hasActive($goods['id']);
            if ($special) {
                $goods = array_merge($goods, $special);
            }
            //该商品是否有参与红包活动,如果有,则使用盖网提供的销售价
            if($goods['join_activity'] == self::JOIN_ACTIVITY_YES && !empty($goods['activity_tag_id']) && $goods['at_status'] == ActivityTag::STATUS_ON){
                $goods['price'] = $goods['gai_sell_price'];
            }
        }
        return $goods;
    }

    /**
     * 获取购物车的商品详情，网页右上角
     * @param string $ids
     * @return array
     */
    public static function getGoodsDetails($ids) {
        $idArr = explode(',', $ids);
        $idArr = array_diff($idArr, ShopCart::checkSpecialGoods()); //取差集，过滤掉特殊商品
        $ids = implode("','", $idArr);
        $sql = "SELECT
                id,
                id as goods_id,
                name,
                thumbnail
            FROM  {{goods}}
            WHERE
             id IN ('{$ids}')
            order by freight_template_id asc
            ";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    /*
     * 商品统计，每天运行一次
     */

    public static function staticGoods() {
        $startDay = strtotime(date('Y-m-d 00:00:00')) - 86400; //昨天的开始时间
        $endDay = $startDay + 86399; //昨天的结束时间
        //昨天新增商品数量 昨天发布商品数量 
        $goodsAdd = Yii::app()->db->createCommand()
        ->select("count(1) as num")
        ->from('{{goods}}')
        ->where("create_time between $startDay and $endDay")
        ->queryScalar();

        //昨天下单商品数量 
        $sql = "select sum(t.quantity) from {{order_goods}} t left join {{order}} o " .
        "on o.id=t.order_id where o.create_time between $startDay and $endDay";
        $orderGoods = Yii::app()->db->createCommand($sql)->queryScalar();


        //昨天支付商品的数量
        $sqlPay = "select IFNULL(sum(t.quantity),0) from {{order_goods}} t left join {{order}} o" .
        " on o.id = t.order_id where o.pay_time between $startDay and $endDay";
        $payGoods = Yii::app()->db->createCommand($sqlPay)->queryScalar();


        //昨天签收商品数量
//        $sqlSign = "select count(distinct t.goods_id) from {{order_goods}} t left join {{order}} o".
//                " on o.id=t.order_id where o.sign_time between $startDay and $endDay";//关联2个表
        $sqlSign = "select count(distinct g.id) from {{order_goods}} og left join {{order}} o on o.id=og.order_id " .
        "left join {{goods}} g on g.id=og.goods_id where o.sign_time between $startDay and $endDay"; //关联3个表
        $signGoods = Yii::app()->db->createCommand($sqlSign)->queryScalar();


        //转化率 :下单商品总量/商品点击量*100%  暂时不清楚
        //$sql2 = "select page_view from {{product_item}} where statistics_date < $startDay";
        //$twoCount = Yii::app()->st->createCommand($sql)->queryScalar();//前天之前的点击量
        // $sql3 = "select sum(views) as total from {{goods}}";
        //$total = Yii::app()->db->createCommand($sql)->queryScalar();
        //$zhuan = $orderGoods / $total;
        $zhuan = ''; //转化率   暂是不清楚如何做
        //$sql = "select views from {{goods}} where ";
        //插入数据
        $time = time(); //创建日期
        $staticTime = strtotime('-1 day'); //统计日期 统计的是昨天的数据，所以写统计日期是昨天，创建日期是今天
        $insertSql = "insert into {{product_day}} (`id`,`new_product_count`,`publish_product_count`,`sign_product_count`,`ordered_product_count`,`payed_product_count`,`conversionrate_avg`,`statistics_date`,`create_time`)" .
        " values ('','$goodsAdd','$goodsAdd','$signGoods','$orderGoods','$payGoods','$zhuan','$staticTime','$time')";

        if (Yii::app()->st->createCommand($insertSql)->execute()) {
            echo date('Y-m-d', $startDay) . ' 记录插入成功';
        }
    }

    /**
     * 统计店铺在售的通过审核的商品数量
     * @param $storeId
     * @return mixed
     */
    public static function CountSalesGoods($storeId) {
        $sql = "SELECT COUNT(*) FROM {{goods}} WHERE `store_id` = {$storeId} AND life=" . Goods::LIFE_NO . " and `is_publish` = " . Goods::PUBLISH_YES . " AND `status` = " . Goods::STATUS_PASS;
        return Yii::app()->db->createCommand($sql)->queryScalar();
    }

    /**
     * 批量插入商品图片数据表
     * @param array $data
     * @return bool
     *  @author zhenjun_xu <412530435@qq.com>
     */
    public function addGoodsPicture(Array $data) {
        return GoodsPicture::addArray($data, $this->id);
    }

    /**
     * 批量添加商品规格对应数据
     * @param array $spec_val
     * @return bool
     *  @author zhenjun_xu <412530435@qq.com>
     */
    public function addSpecIndex(Array $spec_val) {
        return GoodsSpecIndex::addArray($spec_val, $this->type_id, $this->category_id, $this->id);
    }

    /**
     * 批量添加商品规格
     *
     * 如果没有商品规格，或者添加失败，则插入一条默认数据
     * @param array $spec
     * @return int
     *  @author zhenjun_xu <412530435@qq.com>
     */
    public function addSpec(Array $spec) {
        if (!GoodsSpec::addArray($spec, $this->spec_name, $this->price, $this->id)) {
            $goodsSpec = new GoodsSpec();
            $goodsSpec->goods_id = $this->id;
            $goodsSpec->price = $this->price;
            $goodsSpec->stock = $this->stock;
            $goodsSpec->save(false);
        }
        return Yii::app()->db->lastInsertID;
    }

    /**
     * 批量添加商品属性值
     * @param array $att
     * @return bool
     * @author zhenjun_xu <412530435@qq.com>
     */
    public function addAttributeIndex(Array $att) {
        if (empty($att))
            return false;
        AttributeIndex::addArray($att, $this->type_id, $this->category_id, $this->id);
        return true;
    }

    /**
     * 查找后的相关操作，主要是将一些数据反序列化
     */
    public function afterFind() {
        parent::afterFind();
        if ($this->goods_spec)
            $this->goods_spec = unserialize($this->goods_spec);
        if ($this->attribute)
            $this->attribute = unserialize($this->attribute);
        if ($this->spec_name)
            $this->spec_name = unserialize($this->spec_name);
        if ($this->spec_picture)
            $this->spec_picture = unserialize($this->spec_picture);
    }

    /**
     * 首页楼层某顶级分类ID下的商品
     * @param array $categoryId 孙子级分类ID
     * @return array $data
     * @author wencong.lin <183482670@qq.com>
     */
    public static function getFloorGoods($categoryId) {
        $data = Yii::app()->db->createCommand()
        ->select('id, name, thumbnail, description')
        ->from('{{goods}}')
        ->where('status=:status And is_publish=:publish', array(':status' => Goods::STATUS_PASS, ':publish' => Goods::PUBLISH_YES))
        ->andWhere(array('in', 'category_id', $categoryId))
        ->order('sort asc')
        ->limit(8)
        ->queryAll();

        if (empty($data))
            $data = array();
        return $data;
    }

    /**
     * 直接购买时获取商品详细信息（微商城用）
     * @param array $goodsId 过滤商品
     * @param int $quantity 商品数量
     * @param int $specId 商品属性id
     * @param string $forUpdate 加 for update 查询
     * @return array
     * @throws Exception
     */
    public static function getGoodsInfo($goodsId,$quantity,$specId,$forUpdate='')
    {
        $sql = 'SELECT
                    g.price,
                    g.thumbnail,
                    g.`name`,
                    g.gai_income,
                    g.gai_price,
                    g.freight_payment_type,
                    g.freight_template_id,
                    g.size,
                    g.weight,
                    g.store_id,
                    g.status,
                    g.is_publish,
                    g.life,
                    g.fee,
                    g.ratio,
                    g.category_id AS g_category_id,
                    g.gai_sell_price,
                    g.activity_tag_id,
                    g.join_activity,
                    g.activity_ratio,
                    g.jf_pay_ratio,
                    g.seckill_seting_id,
                    f.valuation_type,
                    s.`name` AS store_name,
                    et.signing_type,
                    at.status AS at_status,
                    at.name AS at_name
                FROM
                    gw_goods AS g
                LEFT JOIN gw_freight_template AS f ON g.freight_template_id = f.id
                LEFT JOIN gw_store AS s ON s.id = g.store_id
                LEFT JOIN gw_member AS m ON s.member_id = m.id
                LEFT JOIN gw_enterprise AS et ON m.enterprise_id = et.id
                LEFT JOIN `gw_activity_tag` AS at ON g.activity_tag_id = at.id
                WHERE
                    g.id =:id';
        $data = Yii::app()->db->createCommand($sql)->bindValue(':id', $goodsId)->queryAll();
        $goodsInfo = array(); //重新格式化、按照店铺id组装数据
        $freightInfo = array(); //运费模板信息
        if (!$data) return array('goodsCount' => 0, 'goodsInfo' => array(), 'freightInfo' => array());
        $quantity=intval($quantity);
        $goodsCount = $quantity; //商品个数统计
        $specialTopicNum= SpecialTopic::effectiveTopicNum(); //当前未结束的专题个数
        foreach ($data as &$v) {
            //查找库存相关
            $sql = 'select id AS spec_id,goods_id,spec_name,spec_value,stock from gw_goods_spec where id=:id';
            $goodsSpec = Yii::app()->db->createCommand($sql.$forUpdate)->bindValue(':id',$specId)->queryRow();
            if($goodsSpec){
                $v = array_merge($v,$goodsSpec);
            }else{
                $v['status'] = Goods::STATUS_AUDIT;
                $v['spec_value'] = $v['spec_name'] = null;
                $v['stock'] = 0;
            }
            $goodsKey = $goodsId . '-' . $specId;
            //反序列化规格数据
            !empty($v['spec_name']) && $v['spec_name'] = unserialize($v['spec_name']);
            !empty($v['spec_value']) && $v['spec_value'] = unserialize($v['spec_value']);
            $spec = is_array($v['spec_name']) && is_array($v['spec_value']) ? array_combine($v['spec_name'], $v['spec_value']) : array();
            $v['spec'] = '';
            foreach ($spec as $ks => $vs) {
                $v['spec'] .= $ks . ':' . $vs . ' ';
            }
            //该商品是否有参与优惠活动,如果有，则使用优惠活动的价格
            if($specialTopicNum){
                $special = SpecialTopicGoods::hasActive($v['goods_id']);
                if ($special) {
                    $v = array_merge($v, $special);
                }
            }
            $v=array_merge($v,array('original_price'=>$v['price']));
            //店铺商品(原始价格)、不包含运费
            $goodsInfo['originalPrice'][$goodsKey] = $v['price']*$quantity;
            //该商品是否有参与红包活动,如果有,则使用盖网提供的售价
            if($v['join_activity'] == Goods::JOIN_ACTIVITY_YES && !empty($v['activity_tag_id']) && $v['at_status'] == ActivityTag::STATUS_ON){
                $v=array_merge($v,array('price'=>$v['gai_sell_price']));
            }
            //返还积分
            $v['returnScore'] = Common::convertReturn($v['gai_price'], $v['price'], $v['gai_income'] / 100)*$quantity;
            //店铺名称
            $goodsInfo['storeName'] = $v['store_name'];
            //签约类型
            $goodsInfo['serviceType'] = $v['signing_type'];
            //店铺商品集合
            $goodsInfo['goods'][$goodsKey] = $v;
            //店铺商品价格集合、不包含运费
            $goodsInfo['storeAllPrice'][$goodsKey] = $v['price']*$quantity;

            //店铺商品返还积分集合
            $goodsInfo['Return'][$goodsKey] = $v['returnScore'];
            //所有的运费模板
            if ($v['freight_payment_type'] == Goods::FREIGHT_TYPE_MODE) {
                $freightInfo[] = array(
                    'goods_id' => $goodsId,
                    'size' => $v['size'],
                    'weight' => $v['weight'],
                    'quantity' => $quantity,
                    'freight_template_id' => $v['freight_template_id'],
                    'valuation_type' => $v['valuation_type'],
                    'spec_id' => $specId,
                );
            }
        }
        return array('goodsInfo' => $goodsInfo, 'freightInfo' => $freightInfo, 'goodsCount' => $goodsCount);
    }
    
    /**
     * 获取专题活动活动价格
     * @param $goods
     * @return array $data
     * @author binbin.liao
     */
    public static function  getZtPrice($goods)
    {
        $speciaPrice = 0;
        $data = array();
        $speciaData = Yii::app()->db->createCommand()
        ->select('stg.*,st.id,st.start_time,st.end_time,g.price')
        ->from('{{goods}} g')
        ->leftJoin('{{special_topic_goods}} stg', 'stg.goods_id = g.id')
        ->leftJoin('{{special_topic}} st', 'st.id=stg.special_topic_id')
        ->where('g.id = :gid', array(':gid' => $goods->id))
        ->queryRow();
        if ($speciaData['end_time'] < time()) {
            return $data = array('isOk' => false, 'price' => $speciaData['price']);
        }
        $speciaPrice = $speciaData['special_price'];
        return $data = array('isOk' => true, 'price' => $speciaPrice);
    }
}
