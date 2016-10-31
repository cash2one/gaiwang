<?php

/**
 *  商家店铺装修表 模型
 * @author zhenjun_xu <412530435@qq.com>
 *
 * The followings are the available columns in table '{{design}}':
 * @property string $id
 * @property string $store_id
 * @property string $data
 * @property integer $status
 * @property string $remark
 * @property string $create_time
 * @property string $update_time
 */
class Design extends CActiveRecord
{

    const STATUS_EDITING = 1;
    const STATUS_AUDITING = 2;
    const STATUS_PASS = 3;
    const STATUS_NOT_PASS = 4;
    const STATUS_HISTORY = 5;

    public $storeName;


    /**
     *  店铺装修状态
     * @param null $k
     * @return array|null
     */
    public static function status($k = null)
    {
        $arr = array(
            self::STATUS_EDITING => Yii::t('design', '编辑中'),
            self::STATUS_AUDITING => Yii::t('design', '审核中'),
            self::STATUS_PASS => Yii::t('design', '审核通过'),
            self::STATUS_NOT_PASS => Yii::t('design', '审核不通过'),
            self::STATUS_HISTORY => Yii::t('design', '历史'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }

    public function tableName()
    {
        return '{{design}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('data', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('store_id, create_time, update_time', 'length', 'max' => 11),
            array('id, store_id, data, status, remark, create_time, end_time, update_time,username,gw,mobile', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('design', '主键'),
            'store_id' => Yii::t('design', '所属商家'),
            'data' => Yii::t('design', '数据'),
            'status' => Yii::t('design', '状态'),
            'remark' => Yii::t('design', '备注'),
            'create_time' => Yii::t('design', '创建时间'),
            'update_time' => Yii::t('design', '更新时间'),
        	'storeName' => Yii::t('design', '店铺名称'),
        	'mobile' => Yii::t('design', '手机号码'),
        );
    }

    public $end_time; //时间区间，搜索用
    public $mobile; //联系电话，连表搜索用
    public $gw; //搜索使用 盖网编号
    public $username; //用户名 搜索使用
    public function search()
    {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('c.name', $this->store_id, true);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('m.username', $this->username,true);
        $criteria->compare('c.mobile', $this->mobile,true);
        $criteria->compare('m.gai_number', $this->gw,true);
        $criteria->select = 't.*,c.name as storeName,c.mobile,m.gai_number as gw,m.username';
        $criteria->join = 'left join {{store}} as c on c.id=t.store_id left join {{member}} as m on c.member_id = m.id';
        $searchDate = Tool::searchDateFormat($this->create_time, $this->end_time);
        $criteria->compare('t.create_time', '>=' . $searchDate['start']);
        $criteria->compare('t.create_time', '<' . $searchDate['end']);
        
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20, //分页
            ),
            'sort' => array('defaultOrder' => 'id DESC', //设置默认排序
            ),
        ));
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    const ORDER_VIEW_DESC = 1;
    const ORDER_VIEW_ASC = 2;
    const ORDER_PRICE_DESC = 3;
    const ORDER_PRICE_ASC = 4;
    const ORDER_NEW = 5;
    const ORDER_SALE_DESC = 6;

    /**
     *  店铺装修状态
     * @param null $k
     * @return array|null
     */
    public static function orderMode($k = null)
    {
        $arr = array(
            self::ORDER_VIEW_DESC => Yii::t('design', '人气指数由高到低'),
            self::ORDER_VIEW_ASC => Yii::t('design', '人气指数由低到高'),
            self::ORDER_PRICE_DESC => Yii::t('design', '单价由高到低'),
            self::ORDER_PRICE_ASC => Yii::t('design', '单价由低到高'),
            self::ORDER_NEW => Yii::t('design', '最新发布'),
            self::ORDER_SALE_DESC => Yii::t('design', '销量由高到低'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }

    public static function getOrder($k = null)
    {
        $arr = array(
            self::ORDER_VIEW_DESC => 't.views DESC',
            self::ORDER_VIEW_ASC => 't.views ASC',
            self::ORDER_PRICE_DESC => 't.price DESC',
            self::ORDER_PRICE_ASC => 't.price ASC',
            self::ORDER_NEW => 't.create_time DESC',
            self::ORDER_SALE_DESC => 't.sales_volume DESC',
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }

    // 布局
    const PAGE_TOP = 1; //页面头部
    const PAGE_LEFT = 2; //页面左侧
    const PAGE_RIGHT = 3; //页面右侧
    const PAGE_STORE = 4; //实体店

    // 编码
    const CODE_BANNER = '_main_banner_1'; //横幅
    const CODE_NAV = '_main_nav_1'; //导航
    const CODE_SLIDE = '_main_slide_1'; //幻灯片
    const CODE_MAIN_PRODUCT = '_main_proList_1'; //推荐产品
    const CODE_CONTACT = '_left_Contact_1'; //联系客服
    const CODE_CATEGORY = '_left_category_1'; //商品分类
    const CODE_LEFT_PRODUCT = '_left_proList_1'; //左侧商品列
    const CODE_RIGHT_SLIDE = '_right_slide_1'; //右侧幻灯片
    const CODE_RIGHT_PRODUCT = '_right_proList_1'; //右侧商品
    const CODE_STORE_SYN = '_the_store_synopsis_1'; //实体店简介
    const CODE_STORE_SLIDE = '_the_store_slide_1'; //实体店幻灯片
    const CODE_STORE_CONTACT = '_the_store_contact_1'; //实体店联系
    const CODE_STORE_MAP = '_the_store_map_1'; //实体店地图


    public static $customerDesign = array();

    /**
     * 获取用户配置
     * @param $storeId
     * @param int $path
     * @return array
     * @deprecated 统一用 DesignFormat
     */
    public static function getDesign($storeId, $path = 0)
    {
        $newAry = array();
        if (empty(self::$customerDesign)) {
            $res = Yii::app()->db->createCommand()
                ->from('{{design}}')
                ->limit(1)
                ->order('id desc')
                ->where('store_id=:store_id and `status`=' . Design::STATUS_PASS)
                ->bindParam(':store_id', $storeId)
                ->queryRow();
            if (!empty($res)) {
                $array = CJSON::decode($res['data']);
                if (!empty($array)) {
                    $newAry[0] = $array;
                    unset($newAry[0]['TemplateList']);
                    foreach ($array['TemplateList'] as $val) {
                        $newAry[$val['TypeArea']][$val['Code']][] = $val['JsonData'] ? CJSON::decode($val['JsonData']) : $val['JsonData'];
                    }
                }
            }
        } else {
            $newAry = self::$customerDesign;
        }
        if (!empty($path) && isset($newAry[$path])) {
            return $newAry[$path];
        }
        return $newAry;
    }

    /**
     * 热销推荐
     * @param type $storeId
     * @return type
     * @deprecated
     */
    public static function shopHotSales($storeId)
    {
        // 个人设定
        $newAry = self::getDesign($storeId, self::PAGE_LEFT); //获取用户配置
        if (empty($newAry) || empty($newAry[self::CODE_LEFT_PRODUCT][0])) {
            return;
        }

        return self::getGoodsListByCondition($storeId, $newAry[self::CODE_LEFT_PRODUCT][0]);

    }

    /**
     * 通过用户设定查询商品
     * @param type $storeId
     * @param type $defined
     * @param type $orderBy
     * @param type $num
     * @return type
     */
    public static function getGoodsListByCondition($storeId, $defined = array(), $orderBy = 't.create_time DESC', $num = 5)
    {
        $childTitle = $title = '';
        $whereStr = 't.store_id=:store_id and t.life=:life and t.is_publish=:is_publish and t.status=:status';
        $whereAry = array(':store_id' => $storeId, ':life'=>Goods::LIFE_NO, ':is_publish' => Goods::PUBLISH_YES, ':status' => Goods::STATUS_PASS);
        if (!empty($defined)) {
            $childTitle = $defined['TypeChildTitle'];
            $title = $defined['TypeTitle'];
            if ($defined['OrderMode']) $orderBy = Design::getOrder($defined['OrderMode']);

            if ($defined['Keywords']) {
                $whereStr .= " and t.`name` like '%" . $defined['Keywords'] . "%'";
            }
            if ($defined['CatId']) {
                $scid = $defined['CatId'];
                $scategory = Yii::app()->db->createCommand()->select(array('id'))->from('{{scategory}}')
                    ->where('store_id=:store_id and parent_id=:pid and`status`=:status', array(':store_id' => $storeId, ':pid' => $defined['CatId'], ':status' => Scategory::STATUS_USING))
                    ->queryColumn();
                if (!empty($scategory)) {
                    $scategorySub = Yii::app()->db->createCommand()->select(array('id'))->from('{{scategory}}')
                        ->where('store_id=:store_id and `status`=:status', array(':store_id' => $storeId, ':status' => Scategory::STATUS_USING))
                        ->andWhere(array('in', 'parent_id', $scategory))
                        ->queryColumn();
                    if (!empty($scategorySub)) {
                        $scategory = array_merge($scategory, $scategorySub);
                    }
                    $scid .= ',' . implode(',', $scategory);
                }
                $whereStr .= " and t.scategory_id in(:scid)";
                $whereAry[':scid'] = $scid;
            }
            if ($defined['MinMoney']) {
                $whereStr .= " and t.price>=:minPrice";
                $whereAry[':minPrice'] = $defined['MinMoney'] * 0.9;
            }
            if ($defined['MaxMoney']) {
                $whereStr .= " and t.price<=:maxPrice";
                $whereAry[':maxPrice'] = $defined['MaxMoney'] * 0.9;
            }
            $num = $defined['ProCount'];
        }
        $goods = Yii::app()->db->createCommand()
            ->select('t.id,t.name,t.price,t.market_price,t.thumbnail,t.sales_volume,t.gai_sell_price,t.join_activity,t.return_score,t.goods_spec_id,t.activity_tag_id,at.status AS at_status,views')
            ->from('{{goods}} t')->where($whereStr, $whereAry)
            ->leftJoin('{{activity_tag}} at','t.activity_tag_id=at.id')
            ->limit($num)->order($orderBy)
            ->queryAll();
        //处理售价显示,如果参加红包活动，并且活动状态是有效的，则显示盖网提供的售价 binbin.liao
        foreach ($goods as &$g) {
            //如果参加红包活动,并且活动的是开启的.显示盖网的销售价,否则显示原来的售价
            if ($g['join_activity'] == Goods::JOIN_ACTIVITY_YES && !empty($g['activity_tag_id']) && $g['at_status'] == ActivityTag::STATUS_ON) {
                $g['price'] = $g['gai_sell_price'];
            }
        }
        $return['title'] = $title; //标题
        $return['childTitle'] = $childTitle; //副标题
        $return['goods'] = $goods; //商品列
        return $return;
    }

    const NAV_TYPE_HOME = 0; //首页
    const NAV_TYPE_CATEGORY = 1; //商品分类
    const NAV_TYPE_ARTICLE = 2; //文章
    const NAV_TYPE_URL = 3; //自定义链接
    const NAV_TYPE_DESC = 4; //商家简介
    const NAV_TYPE_ALL_GOODS = 5; //所有商品
    const NAV_TYPE_STORE = 6; //实体店
    /**
     * 获取导航链接
     * @param type $data
     * @param type $storeId
     * @return type
     */
    public static function getNavUrl($data, $storeId)
    {
        $array = array(
            self::NAV_TYPE_HOME => Yii::app()->createAbsoluteUrl('/shop/view', array('id' => $storeId)),
            self::NAV_TYPE_CATEGORY => Yii::app()->createAbsoluteUrl('/shop/product', array('id' => $storeId, 'cid' => $data['SourceId'])),
            self::NAV_TYPE_ARTICLE => Yii::app()->createAbsoluteUrl('/shop/article', array('id' => $storeId, 'aid' => $data['SourceId'])),
            self::NAV_TYPE_URL => $data['LinkUrl'],
            self::NAV_TYPE_DESC => Yii::app()->createAbsoluteUrl('/shop/info', array('id' => $storeId)),
            self::NAV_TYPE_ALL_GOODS => Yii::app()->createAbsoluteUrl('/shop/product', array('id' => $storeId)),
            self::NAV_TYPE_STORE => Yii::app()->createAbsoluteUrl('/shop/store', array('id' => $storeId)),
        );
        $url = '#';
        if ($array[$data['Type']]) {
            $url = $array[$data['Type']];
        }
        return $url;
    }

    public function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->status = self::STATUS_EDITING;
                $this->create_time = time();
                $this->store_id = Yii::app()->user->getState('storeId');
                $this->update_time = time();

            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * 根据storeId查找审核通过的装修模板
     * @param $storeId
     * @return mixed
     */
    public static function getPass($storeId)
    {
        return Yii::app()->db->createCommand()
            ->from('{{design}}')
            ->where('store_id=:store_id and `status`=:status', array(':store_id' => $storeId, ':status' =>Design::STATUS_PASS))
            ->queryRow();
    }

    /**
     * 根据最新一条装修数据，店铺装修状态提示
     * @param $storeId
     * @return array|null|string
     */
    public static function getTipsStatus($storeId)
    {
        $data = Yii::app()->db->createCommand()
            ->from('{{design}}')
            ->select('id,status')
            ->limit(1)->order('id desc')
            ->where('store_id=:store_id', array(':store_id' => $storeId))
            ->queryRow();
        if($data){
            return self::status($data['status']);
        }else{
            return Yii::t('design','新功能');
        }
    }
}
