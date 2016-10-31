<?php

/**
 * 广告位管理模型
 * @author qinghao.ye <qinghaoye@sina.com>
 *
 * @property string $id
 * @property string $name
 * @property string $code
 * @property string $content
 * @property integer $type
 * @property integer $status
 * @property integer $width
 * @property integer $height
 * @property integer $direction
 * @property string $city_id
 * @property string $category_id
 * @property integer $franchisee_category_id
 * @property integer $is_mshop
 */
class Advert extends CActiveRecord
{

    const CACHEDIR = 'adverts'; // 广告缓存目录
    const HOME_NAV_CACHE_DIR = 'getHomepageCategoryData'; //分类导航广告缓存
    const STATUS_ENABLE = 1; //开启
    const STATUS_DISABLED = 0; //禁用
    // 类型常量
    const TYPE_IMAGE = 1;
    const TYPE_TEXT = 2;
    const TYPE_SLIDE = 3;
    const TYPE_FLASH = 4;
    const TYPE_GOODS = 5;
    // 投放定向常量
    const DIRECTION_NULL = 0;
    const DIRECTION_CITY = 1;
    const DIRECTION_CATEGORY = 2;
    const DIRECTION_HOTELCITY = 3;
    const DIRECTION_HOMEHOTSALE = 4;
    const DIRECTION_HOMERECOMMEND = 5;
    const DIRECTION_PRODUCTHOTSALE = 6;
    const DIRECTION_PRODUCTRECOMMEND = 7;
    const DIRECTION_PRODUCTHOTSEARCH = 8;
    const DIRECTION_SLIDES = 9; // 首页幻灯片定向常量
    const DIRECTION_FLOOR = 10; // 首页楼层定向常量
    const DIRECTION_GAI_GOODS = 11; //盖商品推荐商品

    //盖象2.0线下服务广告缓存
    const JMS_BANNER_MAIN = 'jms_banner_main';  //线下业务主广告
    const JMS_BANNER_WELCOME = 'jms_banner_welcome';//线下业务最受欢迎推荐
    const JMS_BANNER_BEST = 'jms_banner_best';//线下业务主广告配餐中心推荐
    const JMS_MAIN_A = 'jms_main_a';
    const JMS_MAIN_B = 'jms_main_b';
    const JMS_MAIN_C = 'jms_main_c';
    const JMS_MAIN_D = 'jms_main_d';
    const JMS_MAIN_E = 'jms_main_e';
    const JMS_MAIN_F = 'jms_main_f';
    const JMS_LIST_T = 'jms_list_top';
    const JMS_NOTICE = 'jms_notice';

    //盖象2.0手机数码频道分类
    const PHONE_NAV_CACHE = 'channel_phone_nav_cache';  //手机导航栏缓存
    const PHONE_CHANNEL_CODE = 'channel_phone'; // 手机首页轮播图CODE
    const FOCUS_PHONE_CODE = 'focus_phone';        //焦点图缓存CODE
    const CHANNELCACHE = 'channel_cahce';   //共用缓存
    const CHANNEL_PHONE_LEFT_TOP = 'channel_phone_left_top';    //手机左上方广告图标识
    const CHANNEL_PHONE_LEFT_DOWN = 'channel_phone_left_down';    //手机左下方广告图标识
    const CHANNEL_PHONE_LEFT_BIG = 'channel_phone_left_big';    //手机楼层主广告图
    const CHANNEL_PHONE_TEXT = 'channel_phone_text';    //手机频道手机楼层文字广告
    const CHANNEL_PHONE_TOP_TEXT = 'channel_phone_top_text';    //手机数码频道上头文字广告
    const CHANNEL_PHOTOGRAPHY_LEFT_TOP =  'channel_photography_left_top';//摄影左上方广告图标识
    const CHANNEL_PHOTOGRAPHY_LEFT_DOWN = 'channel_photography_left_down';    //摄影右方广告图标识
    const CHANNEL_PHOTOGRAPHY_LEFT_BIG = 'channel_photography_left_big';    //摄影楼层主广告图
    const CHANNEL_PHOTOGRAPHY_TEXT = 'channel_photography_text';    //手机频道摄影楼层文字广告
    const CHANNEL_PARTS_LEFT_TOP =  'channel_parts_left_top';//手机配件左上方广告图标识
    const CHANNEL_PARTS_LEFT_DOWN = 'channel_parts_left_down';    //手机配件左下方广告图标识
    const CHANNEL_PARTS_LEFT_BIG = 'channel_parts_left_big';    //手机配件楼层主广告图
    const CHANNEL_PARTS_TEXT = 'channel_parts_text';    //手机频道手机配件楼层文字广告


    const CHANNEL_DIGITAL_ASS_LEFT_TOP =  'channel_digital_left_top';//数码配件左上方广告图标识
    const CHANNEL_DIGITAL_ASS_LEFT_DOWN = 'channel_digital_left_down';    //数码配件右方广告图标识
    const CHANNEL_DIGITAL_ASS_LEFT_BIG = 'channel_digital_left_big';    //数码配件楼层主广告图
    const CHANNEL_DIGITAL_ASS_TEXT = 'channel_digital_text';    //手机频道数码配件楼层文字广告
    //手机数码频道分类结束

    //盖象2.0饮料食品频道分类
    const FOOD_NAV_CACHE = 'channel_food_nav_cache';  //饮料食品导航栏缓存
    const FOOD_CHANNEL_CODE = 'channel_food'; // 饮料食品首页轮播图CODE
    const FOCUS_FOOD_CODE = 'focus_food';        //饮料食品焦点图缓存CODE
    const CHANNEL_FOOD_TOP_TEXT = 'channel_food_top_text';    //饮料食品频道上头文字广告
    const CHANNEL_FOOD_NAV_ADVER = 'channel_food_nav_adver';    //二级栏目的分类广告

    //盖象2.0特产
    const CHANNEL_NATIVE_TEXT = 'channel_native_text';    //饮料食品频道特产楼层文字广告
    const CHANNEL_NATIVE_LEFT_TOP = 'channel_native_left_top';  //左侧广告

    //盖象2.0粮油
    const CHANNEL_GRAIN_TEXT = 'channel_grain_text';    //饮料食品频道粮油楼层文字广告
    const CHANNEL_GRAIN_LEFT_TOP = 'channel_grain_left_top';  //左侧广告

    //盖象2.0饮料调冲
    const CHANNEL_DRINK_TEXT = 'channel_drink_text';
    const CHANNEL_DRINK_LEFT_TOP = 'channel_drink_left_top';

    //盖象2.0休闲食品Snacks
    const CHANNEL_SNACKS_TEXT = 'channel_snacks_text';
    const CHANNEL_SNACKS_LEFT_TOP = 'channel_snacks_left_top';
    
    //盖象自营品牌
    const AUTOTROPHY_CHANNEL_CODE = 'channel_autotrophy'; //自营首页轮播图
    const OWN_AUTOTROPHY_ADVER = 'own_autotrophy'; //自有品牌图
    const CHANNEL_RECOMMEND_LEFT_TOP = 'channel_recommend_left_top'; //推荐左上方广告
    const CHANNEL_RECOMMEND_LEFT_UNDER = 'channel_recommend_left_under'; //推荐左下方广告
    const CHANNEL_RECOMMEND_MIDDLE_TOP = 'channel_recommend_middle_top'; //推荐中上方广告
    const CHANNEL_RECOMMEND_RIGHT_TOP = 'channel_recommend_right_top'; //推荐右上方广告
    const CHANNEL_CZ_LEFT_TOP = 'channel_cz_left_top'; //超值左上方广告
    const CHANNEL_CZ_LEFT_UNDER = 'channel_cz_left_under'; //超值左下方广告
    const CHANNEL_CZ_MIDDLE_TOP = 'channel_cz_middle_top'; //超值中上方广告
    const CHANNEL_CZ_RIGHT_TOP = 'channel_cz_right_top'; //超值右上方广告
    const CHANNEL_TM_LEFT_TOP = 'channel_tm_left_top'; //特卖左上方广告
    const CHANNEL_TM_MIDDLE_TOP = 'channel_tm_middle_top'; //特卖中上方广告
    const CHANNEL_TM_RIGHT_TOP = 'channel_tm_right_top'; //特卖右上方广告
    const CHANNEL_MS_LEFT_TOP = 'channel_ms_left_top'; //美食左上方广告
    const CHANNEL_MS_MIDDLE_TOP = 'channel_ms_middle_top'; //美食中上方广告
    const CHANNEL_MS_RIGHT_TOP = 'channel_ms_right_top'; //美食右上方广告
    const AUTOTROPHY_CHANNEL_GOODS = 'channel_autotrophy_goods'; //自营首页的商品广告图
   
    
    //广告平台分类
    const SHOPAD = 1; //商城广告
    const MSHOPAD = 2; //微商城广告

    public $shortcutCode;
    public function tableName()
    {
        return '{{advert}}';
    }

    public function rules()
    {
        return array(
            array('name, code, type', 'required'),
            array('type, status, width, height, direction', 'numerical', 'integerOnly' => true),
            array('name, code, shortcutCode', 'length', 'max' => 128),
            array('content', 'length', 'max' => 256),
            array('city_id, category_id, franchisee_category_id', 'length', 'max' => 11),
            array('direction', 'checkDirection'),
//            array('code', 'comext.validators.requiredExt', 'allowEmpty' => !empty($this->shortcutCode)),
            array('code', 'unique', 'caseSensitive' => false, 'message' => '编码 "{value}" 已经被注册，请更换'),
            array('name, code, shortcutCode, is_mshop', 'safe', 'on' => 'search'),
        );
    }

    /**
     * 检查投放定向
     * @param type $attribute
     * @param type $params
     */
    public function checkDirection($attribute, $params)
    {
        if ($this->direction == Advert::DIRECTION_CITY) {
            if (empty($this->city_id)) {
                $this->addError('city_id', Yii::t('advert', '不能为空！'));
            } elseif (empty($this->franchisee_category_id)) {
                $this->addError('franchisee_category_id', Yii::t('advert', '不能为空！'));
            }
        }
        if ($this->direction == Advert::DIRECTION_CATEGORY && empty($this->category_id))
            $this->addError('category_id', Yii::t('advert', '必须选择一个顶级分类！'));
    }

    public function relations()
    {
        return array(
            'picture' => array(self::MANY_MANY, 'AdvertPicture', 'advert_id'),
            'pictureCount' => array(self::STAT, 'AdvertPicture', 'advert_id'),
            'advertPictures' => array(self::HAS_MANY, 'AdvertPicture', 'advert_id',
                'condition' => 'advertPictures.status = :status',
                'params' => array(':status' => AdvertPicture::STATUS_ENABLE)
            ),
            'goods' => array(self::MANY_MANY, 'AdvertGoods', 'advert_id'),
            'goodsCount' => array(self::STAT, 'AdvertGoods', 'advert_id'),
            'advertGoods' => array(self::HAS_MANY, 'AdvertGoods', 'advert_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('advert', '主键'),
            'name' => Yii::t('advert', '名称'),
            'code' => Yii::t('advert', '编码'),
            'content' => Yii::t('advert', '说明'),
            'type' => Yii::t('advert', '类型'),
            'status' => Yii::t('advert', '状态'),
            'width' => Yii::t('advert', '宽度'),
            'height' => Yii::t('advert', '高度'),
            'direction' => Yii::t('advert', '定向投放'),
            'city_id' => Yii::t('advert', '城市'),
            'category_id' => Yii::t('advert', '分类'),
            'franchisee_category_id' => Yii::t('advert', '加盟商分类'),
            'is_mshop' => Yii::t('advert', '广告平台'),
        );
    }

    /**
     * 后台广告列表
     * @return \CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        $name = Yii::app()->controller->id;
        if($name=='advert'){
            $is_mshop=self::SHOPAD;
        }else{
            $is_mshop=self::MSHOPAD;
        }
        $criteria->compare('name', $this->name, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('is_mshop', $is_mshop, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10, //分页
            ),
            'sort' => array(
                'defaultOrder' => 'id DESC', //设置默认排序
            ),
        ));
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 获取状态
     * @return array
     */
    public static function getAdvertStatus($key = false)
    {
        $status = array(
            self::STATUS_ENABLE => Yii::t('advert', '启用'),
            self::STATUS_DISABLED => Yii::t('advert', '禁用')
        );
        if ($key === false)
            return $status;
        return $status[$key];
    }

    /**
     * 获取定向投放类型
     * @param int $key
     * @return string|array
     */
    public static function getAdvertDirection($key = false)
    {
        $direction = array(
            self::DIRECTION_NULL => Yii::t('advert', '无'),
            self::DIRECTION_CITY => Yii::t('advert', '线下城市'),
            self::DIRECTION_CATEGORY => Yii::t('advert', '商品分类'),
            self::DIRECTION_HOMERECOMMEND => Yii::t('advert', '首页推荐商品'),
            self::DIRECTION_GAI_GOODS => Yii::t('advert', '盖商品推荐商品'),
        );
        if ($key === false)
            return $direction;
        return $direction[$key];
    }

    /**
     * 获取广告类型
     * @param int $key
     * @return string|array
     */
    public static function getAdvertType($key = false)
    {
        $type = array(
            self::TYPE_IMAGE => Yii::t('advert', '单个图片'),
            self::TYPE_TEXT => Yii::t('advert', '文字'),
            self::TYPE_SLIDE => Yii::t('advert', '多图片'),
            self::TYPE_FLASH => 'FLASH',
            self::TYPE_GOODS => Yii::t('advert', '商品')
        );
        if ($key === false)
            return $type;
        return $type[$key];
    }

    /**
     * 获取活动城市
     * @return array
     */
    public function getActivityCity()
    {
        $activityCity = array();
        foreach (CHtml::listData(FranchiseeActivityCity::model()->findAll(), 'city_id', 'city_id') as $key => $val) {
            $activityCity[$key] = Region::getName($val);
        }
        return $activityCity;
    }

    /**
     * 根据广告位更新相应缓存
     * @param mixed $aid 对象实例或广告位ID
     */
    public static function generateRelevantCache($aid)
    {
        $advert = is_object($aid) && get_class($aid) == 'Advert' ? $aid : Advert::model()->findByPk($aid, 'status = :status', array(':status' => Advert::STATUS_ENABLE));
        if (!empty($advert)) {
            if ($advert->category_id > 0) // 生成前台主要分类数据
                Category::generateMainCategoryData();
            if ($advert->code == 'index-slide') // 生成首页幻灯广告
                self::generateIndexSlideAd();
            if (!empty($advert->city_id)) // 生成首页线下活动广告
                self::generateOfflineActiveAd();
            if ($advert->direction == Advert::DIRECTION_NULL && !in_array($advert->code, self::differenceCode())) // 生成常规广告
                self::generateConventionalAd($advert->code);
        }
    }

    /**
     * 生成所有广告缓存
     */
    public static function generateAllAdvertCache()
    {
        // 删除缓存
        Tool::cache(Category::CACHEDIR)->delete(Category::CK_MAINCATEGORY);
        Tool::cache(self::CACHEDIR)->delete('index-slide');
        Tool::cache(self::CACHEDIR)->delete('index-offline-active');

        // 重新生成缓存
        Category::generateMainCategoryData(); // 生成前台主要分类数据
        self::generateIndexSlideAd('index-slide'); // 生成首页幻灯广告缓存
        self::generateOfflineActiveAdNew(); // 生成线下活动广告
    }

    /**
     * 差异广告位编码
     * @return array
     */
    public static function differenceCode()
    {
        return array('index-slide', 'index-offline-active');
    }

    /**
     * 获取常规广告缓存数据
     * @param string $code 广告位编码
     */
    public static function getConventionalAdCache($code)
    {
        if (!$advert = Tool::cache(Advert::CACHEDIR)->get($code)) // 获取缓存数据
            $advert = Advert::generateConventionalAd($code);
        return $advert;
    }

    /**
     * 生成无定向投放常规广告
     * 常规广告缓存标识：根据广告位编码获取
     * @param string $code 广告位编码
     * @return string
     */
    public static function generateConventionalAd($code = null)
    {
       return self::generateConventionalAdData($code);
    }

    /**
     * 生成无定向投放常规广告数据
     * 常规广告缓存标识：根据广告位编码获取
     * @param string $code 广告位编码
     * @param int $limit 条数
     * @return array
     */
    public static function generateConventionalAdData($code = null,$limit=null)
    {
        $avoidCode = self::differenceCode(); // 避免不规则广告位
        $ap = Yii::app()->db->createCommand()->select('id,code')->from('{{advert}}')
            ->where('status = :status AND direction<>:direction', array(':status' => Advert::STATUS_ENABLE, ':direction' => Advert::DIRECTION_HOMERECOMMEND));
        if (is_null($code))
            $ap->andWhere(array('Not in', 'code', $avoidCode));
        else
            $ap->andWhere('code = :code', array(':code' => $code));
        $ap = $ap->queryAll();
        $data = array();
        foreach ($ap as $apv) {
            $ads = Yii::app()->db->createCommand()->select('title,picture,text,link,start_time,end_time,target,group,background')->from('{{advert_picture}}')
                ->where('status = :status And advert_id = :aid and start_time<=:time and (end_time >= :time or end_time=0)', array(
                    ':status' => AdvertPicture::STATUS_ENABLE,
                    ':aid' => $apv['id'],
                    ':time' => time(),
                ))
                ->order('sort DESC');
            if (!empty($limit)) {
                $ads->limit($limit);
            }
            $ads = $ads->queryAll();
            $data[trim($apv['code'])] = $ads;
            Tool::cache(self::CACHEDIR)->set(trim($apv['code']), $ads); // 生成缓存文件
        }
        if (isset($data[$code]))
            $data = $data[$code];
        return $data;
    }

    /**
     * 生成首页幻灯广告
     */
    public static function generateIndexSlideAd($code)
    {
        $ap = Yii::app()->db->createCommand()->from('{{advert}} as t')->select('ap.*')
            ->join('{{advert_picture}} as ap', 't.id = ap.advert_id')
            ->where('t.status = :status And t.code = :code And ap.status = :ap_status and start_time<=:time and (end_time >= :time or end_time=0)', array(
                ':status' => Advert::STATUS_ENABLE,
                ':code' => $code,
                ':ap_status' => AdvertPicture::STATUS_ENABLE,
                ':time'=>time(),
            ))
            ->order('ap.group, ap.seat, ap.sort DESC, ap.id DESC')
            ->queryAll();

//        Tool::pr($ap);
        $data = array();
        foreach ($ap as $k => $v) {
            if ($v['seat'] == 1) {
                if (!isset($data[$v['group']]['id']))
                    $data[$v['group']] = $v;
            } else {
                if (!empty($data[$v['group']]['cut'])) {
                    if (!array_key_exists($v['seat'], $data[$v['group']]['cut']))
                        $data[$v['group']]['cut'][$v['seat']] = $v;
                } else {
                    if (!empty($data[$v['group']]))
                        $data[$v['group']]['cut'][$v['seat']] = $v;
                }
            }
        }
        Tool::cache(self::CACHEDIR)->set($code, $data);
        return $data;
    }

    /**
     * 生成线下活动广告
     */
    public static function generateOfflineActiveAd()
    {
        if (!$fCategory = Tool::cache(self::CACHEDIR)->get(FranchiseeCategory::CK_INDEXOFFLINECATEGORY))
            $fCategory = FranchiseeCategory::generateOfflineCategoryData();
        $city = Yii::app()->db->createCommand()->from('{{franchisee_activity_city}}')->queryAll();
        $data = array();
        foreach ($city as $ck => $cv) {
            $adverts = array();
            foreach ($fCategory as $fcv) {
                $adverts = Yii::app()->db->createCommand()->select('ap.*')->from('{{advert}} a')
                    ->join('{{advert_picture}} as ap', 'a.id = ap.advert_id')
                    ->where('a.status = :status And a.direction = :direction And a.type = :type And a.franchisee_category_id = :fcid And a.city_id = :city_id And ap.status = :ap_status and start_time<=:time and (end_time >= :time or end_time=0)', array(
                        ':status' => Advert::STATUS_ENABLE,
                        ':direction' => Advert::DIRECTION_CITY,
                        ':type' => Advert::TYPE_IMAGE,
                        ':fcid' => $fcv['id'],
                        ':city_id' => $cv['city_id'],
                        ':ap_status' => AdvertPicture::STATUS_ENABLE,
                        ':time'=>time(),
                    ))
                    ->order('ap.seat ASC, ap.sort DESC, ap.id DESC')
                    ->queryAll();
                $data[$cv['city_id']][] = $adverts;
            }
        }
        Tool::cache(self::CACHEDIR)->set('index-offline-active', $data);
        return $data;
    }

    /**
     * 生成线下活动广告
     */
    public static function generateOfflineActiveAdNew()
    {
        $data = array(
            'de_city' => FranchiseeActivityCity::getOnlineDefaultCity(),
            'city' => FranchiseeActivityCity::getOnlineAllCity(),
            'ad' => Advert::getOnlineDefaultAdvert(Category::getOnlineCategoryParent(), FranchiseeActivityCity::getOnlineDefaultCity()),
        );
        Tool::cache(self::CACHEDIR)->set('index-offline-active', $data);
        return $data;
    }

    /**
     * 生成常规广告商品
     * 常规广告缓存标识：根据广告位编码获取
     * @param string $code 广告位编码
     * @author leo8705
     */
    public static function generateAdGoods($code = null)
    {
        $avoidCode = self::differenceCode(); // 避免不规则广告位
        $ap = Yii::app()->db->createCommand()->from('{{advert}}')
            ->where('status = :status AND (direction=:direction OR direction =:direction2) ', array(':status' => Advert::STATUS_ENABLE, ':direction' => Advert::DIRECTION_HOMERECOMMEND, ':direction2' => Advert::DIRECTION_GAI_GOODS));
        if (is_null($code))
            $ap->andWhere(array('Not in', 'code', $avoidCode));
        else
            $ap->andWhere('code = :code', array(':code' => $code));
        $ap = $ap->queryAll();
        $data = array();
        foreach ($ap as $apv) {
            $ads = Yii::app()->db->createCommand()
                ->select('ag.*,g.thumbnail,g.name,g.description')
                ->from('{{advert_goods}} as ag')
                ->join('{{goods}} as g', "g.id=ag.goods_id")
                ->where('ag.advert_id = :aid', array(':aid' => $apv['id']))
                ->order('ag.sort')
                ->queryAll();
            $data[$apv['code']] = $ads;
        }
        if (isset($data[$code]))
            $data = $data[$code];
        return $data;
    }

    public static function getAdGoods($code)
    {
        $Goods = Tool::cache(self::CACHEDIR)->get($code);
        if (!$Goods) {
            $Goods = self::generateAdGoods($code);
        }
        return $Goods;
    }

    /**
     * 删除后的操作
     * 删除当前广告位下的的广告图片数据
     * 删除当前广告缓存
     */
    protected function afterDelete()
    {
        parent::afterDelete();
        $advertPictures = AdvertPicture::model()->findAll('advert_id=:aid', array(':aid' => $this->id));
        foreach ($advertPictures as $ap)
            $ap->delete();
        Tool::cache(self::CACHEDIR)->delete(trim($this->code));
    }

    /**
     * 保存之后处理
     */
    protected function afterSave()
    {
        parent::afterSave();
        $this->setCache();
    }

    /**
     * 生成单个广告缓存
     */
    public function setCache()
    {
        if ($this->status == self::STATUS_DISABLED)
             Tool::cache(self::CACHEDIR)->delete($this->code);
        // 首页无定义广告缓存
        if ($this->direction == self::DIRECTION_NULL)
            $this->_setGeneralCache();
        // 首页商品分类广告缓存
        if ($this->direction == self::DIRECTION_CATEGORY)
            $this->_setCategoryCache();
        // 首页推荐广告缓存
        if ($this->direction == self::DIRECTION_HOMERECOMMEND)
            $this->_setGoodsCache();
        // 首页幻灯片缓存
        if ('index-slide' == $this->code)
            $this->_setSlidesCache();
        // 首页线下活动缓存
        if ($this->direction == self::DIRECTION_CITY)
            $this->_setCityCache();
        //分类导航广告缓存
        if(stripos($this->code,'index_category')!==false){
            Category::getHomepageCategoryData();
        }
        // 首页楼层缓存
//        if ($this->direction == self::DIRECTION_FLOOR)
//            $this->_setFloorCache($this->code);
    }

    /**
     * 首页幻灯片缓存
     * @return array $data
     * @author wencong.lin <183482670@qq.com>
     */
    private function _setSlidesCache()
    {
        $data = self::generateIndexSlideAd($this->code);
        Tool::cache(self::CACHEDIR)->set($this->code, $data);
    }

    /**
     * 首页商品分类广告缓存
     * @return array $data
     * @author wencong.lin <183482670@qq.com>
     */
    private function _setCategoryCache()
    {
        Category::generateMainCategoryData();
    }

    /**
     * 首页线下活动广告缓存
     * @return array $data
     * @author wencong.lin <183482670@qq.com>
     */
    private function _setCityCache()
    {
        self::generateOfflineActiveAdNew();
    }

    /**
     * 首页商品推荐缓存
     */
    private function _setGoodsCache()
    {
        if ($this->type == self::TYPE_GOODS)
            $data = $this->_getAdvertGoods();
        else
            $data = $this->_getAdvertPicture();
        $cacheData = array(
            'pic' => $data,
            'name' => $this->name,
            'content' => $this->content
        );
        Tool::cache(self::CACHEDIR)->set($this->code, $cacheData);
    }

    /**
     * 无定向的普通广告缓存
     */
    private function _setGeneralCache()
    {
        $data = $this->generateConventionalAd($this->code);
        Tool::cache(self::CACHEDIR)->set($this->code, $data);
    }

    /**
     * 获取广告图片
     * @return array
     */
    private function _getAdvertPicture()
    {
        $condition = 'status=:status AND advert_id=:aid and start_time<=:time and (end_time >= :time or end_time=0)';
        $params = array(
            ':status' => AdvertPicture::STATUS_ENABLE,
            ':aid' => $this->id,
            ':time'=>time(),
        );
        $pictures = array();
        $fields = 'title, start_time, end_time, link, picture, target';
        $command = Yii::app()->db->createCommand()->select($fields)->from('{{advert_picture}}')->where($condition, $params);
        if ($this->type == self::TYPE_IMAGE || $this->type == self::TYPE_FLASH) // 单个图片 及 单个FLASH
            $pictures = $command->queryRow();
        if ($this->type == self::TYPE_SLIDE || $this->type == self::TYPE_TEXT) // 多图片 及 文字列表
            $pictures = $command->queryAll();
        return $pictures;
    }

    /**
     * 获取广告商品
     * @return array
     */
    private function _getAdvertGoods()
    {
        $goods = Yii::app()->db->createCommand()->select('g.id, g.name, g.thumbnail')
            ->from('{{advert_goods}} ag')->join('{{goods}} g', 'ag.goods_id = g.id')
            ->where('advert_id=:aid', array(':aid' => $this->id))
            ->order('ag.sort DESC')->queryAll();
        return $goods;
    }

    /**
     * 获取红包首页头部缓存
     * @param string $code
     * @return bool|mixed
     */
    public static function getHongBaoCache($code)
    {
        $res = Tool::cache(self::CACHEDIR)->get($code);
        if (empty($res)) {
            $criteria = new CDbCriteria;
            $criteria->select = 'id,name,content,direction,status,type,code';
            $criteria->compare('code', $code);
            $criteria->compare('status', self::STATUS_ENABLE);
            $model = Advert::model()->find($criteria);
            if (!empty($model)) {
                $model->setCache();
                $res = Tool::cache(self::CACHEDIR)->get($code);
            }
        }
        return $res;
    }

    /**
     * 首页线下活动默认城市分类下的广告
     * @param  array $categoryIdArr 线下活动顶级分类ID
     * @param  array $cityIdArr 默认城市的城市ID
     * @return array $data
     * @author wencong.lin <183482670@qq.com>
     */
    public static function getOnlineDefaultAdvert($categoryIdArr, $cityIdArr)
    {
        $data = $advertArr = array();
        foreach ($categoryIdArr as $k => $v) {
            $advertId[$k] = Yii::app()->db->createCommand()
                ->select('id')
                ->from('{{advert}}')
                ->where('status=:status And `type`=:type And franchisee_category_id=:fid And city_id=:cid', array(':status' => Advert::STATUS_ENABLE, ':type' => Advert::TYPE_IMAGE, ':fid' => $v['id'], ':cid' => $cityIdArr['city_id']))
                ->limit(4)
                ->queryRow();
        }

        if (empty($advertId))
            $advertId = array();

        foreach ($advertId as $k => $v) {
            if (empty($v)) continue;
            $advertArr[$k] = $v;
        }

        if (count($advertArr) > 4) {
            $advertArr = array_slice($advertArr, 0, 4);
        }

        foreach ($advertArr as $k => $v) {
            $data[$k] = Yii::app()->db->createCommand()
                ->select('id,title,link,picture,target')
                ->from('{{advert_picture}}')
                ->where('status=:status And `advert_id`=:aid and start_time<=:time and (end_time >= :time or end_time=0)', array(
                    ':status' => AdvertPicture::STATUS_ENABLE,
                    ':aid' => $v['id'],
                    ':time'=>time(),
                ))
                ->limit(9)
                ->queryAll();
        }
        return $data;
    }

    /**
     * 前台首页获取楼层文字广告ID
     * @param string $code 广告编码
     * @return array $data
     * @author wencong.lin <183482670@qq.com>
     */
    public static function getFloorTextAdvertId($code)
    {
        $data = Yii::app()->db->createCommand()
            ->select('id')
            ->from('{{advert}}')
            ->where('code=:code And status=:status And type=:type', array(':code' => $code, ':status' => Advert::STATUS_ENABLE, ':type' => Advert::TYPE_TEXT))
            ->queryRow();
        return $data;
    }

    /**
     * 前台首页获取楼层文字广告
     * @param int $advertId 广告ID
     * @return array $data
     * @author wencong.lin <183482670@qq.com>
     */
    public static function getFloorTextAdvert($advertId,$limit = 5)
    {
        $data = Yii::app()->db->createCommand()
            ->select('link,text,target')
            ->from('{{advert_picture}}')
            ->where('advert_id=:aid And status=:status and start_time<=:time and (end_time >= :time or end_time=0)', array(
                ':aid' => $advertId,
                ':status' => AdvertPicture::STATUS_ENABLE,
                ':time'=>time(),
            ))->order('sort DESC')
            ->limit($limit)
            ->queryAll();
        if (empty($data))
            $data = array();
        return $data;
    }

    /**
     * 前台首页获取楼层图片广告ID
     * @param string $code 广告编码
     * @return array $data
     * @author wencong.lin <183482670@qq.com>
     */
    public static function getFloorImgAdvertId($code)
    {
        $data = Yii::app()->db->createCommand()
            ->select('id')
            ->from('{{advert}}')
            ->where('code=:code And status=:status And type=:type', array(':code' => $code, ':status' => Advert::STATUS_ENABLE, ':type' => Advert::TYPE_SLIDE))
            ->queryRow();
        return $data;
    }

    /**
     * 前台首页获取楼层底部图片广告ID
     * @param $code
     * @return mixed
     * @author xiaoyan.luo
     */
    public static function getFloorImgId($code)
    {
        $data = Yii::app()->db->createCommand()
            ->select('id')
            ->from('{{advert}}')
            ->where('code=:code And status=:status And type=:type', array(':code' => $code, ':status' => Advert::STATUS_ENABLE, ':type' => Advert::TYPE_IMAGE))
            ->queryRow();
        return $data;
    }

    /**
     * 前台首页获取楼层图片广告
     * @param int $advertId 广告ID
     * @return array $data
     * @author wencong.lin <183482670@qq.com>
     */
    public static function getFloorImgAdvert($advertId)
    {
        $data = Yii::app()->db->createCommand()
            ->select('link,picture,start_time,end_time,target,title')
            ->from('{{advert_picture}}')
            ->where('advert_id=:aid And status=:status and start_time<=:time and (end_time >= :time or end_time=0)', array(
                ':aid' => $advertId,
                ':status' => AdvertPicture::STATUS_ENABLE,
                ':time'=>time(),
            ))
            ->order('sort DESC')
            ->limit(3)
            ->queryAll();

        if (empty($data))
            $data = array();
        return $data;
    }

    /**
     * 获取楼层底部广告
     * @param int $advertId 广告id
     * @return array
     * @author xiaoyan.luo
     */
    public static function getFloorImgAdvertData($advertId)
    {
        $data = Yii::app()->db->createCommand()
            ->select('link,picture,title')
            ->from('{{advert_picture}}')
            ->where('advert_id=:aid And status=:status and start_time<=:time and (end_time >= :time or end_time=0)', array(
                ':aid' => $advertId,
                ':status' => AdvertPicture::STATUS_ENABLE,
                ':time'=>time()
            ))
            ->limit(1)
            ->queryRow();

        if (empty($data))
            $data = array();
        return $data;
    }

    /**
     * 获取首页幻灯片数据
     * @param $code string 广告位编码
     * @return array
     * @author xiaoyan.luo
     */
    public static function IndexSlideAdData($code)
    {
        $ap = Yii::app()->db->createCommand()->from('{{advert}} as t')->select('ap.title,ap.link,ap.picture,ap.start_time,ap.end_time,ap.background,ap.seat,ap.group,ap.target')
            ->join('{{advert_picture}} as ap', 't.id = ap.advert_id')
            ->where('t.status = :status And t.code = :code And ap.status = :ap_status and start_time<=:time and (end_time >= :time or end_time=0)', array(
                ':status' => Advert::STATUS_ENABLE,
                ':code' => $code,
                ':ap_status' => AdvertPicture::STATUS_ENABLE,
                ':time'=>time(),
            ))
            ->order('ap.group, ap.seat, ap.sort DESC, ap.id DESC')
            ->queryAll();
//        Tool::pr($ap);
        $data = array();
        foreach ($ap as $k => $v) {
            if ($v['seat'] == 1) {
                if (!isset($data[$v['group']]['id']))
                    $data[$v['group']]['title'] = $v['title'];
                $data[$v['group']]['link'] = $v['link'];
                $data[$v['group']]['picture'] = $v['picture'];
                $data[$v['group']]['start_time'] = $v['start_time'];
                $data[$v['group']]['end_time'] = $v['end_time'];
                $data[$v['group']]['background'] = $v['background'];
                $data[$v['group']]['target'] = $v['target'];
            } else {
                if (!empty($data[$v['group']]['cut'])) {
                    if (!array_key_exists($v['seat'], $data[$v['group']]['cut']))
                        $data[$v['group']]['cut'][$v['seat']]['title'] = $v['title'];
                    $data[$v['group']]['cut'][$v['seat']]['link'] = $v['link'];
                    $data[$v['group']]['cut'][$v['seat']]['picture'] = $v['picture'];
                    $data[$v['group']]['cut'][$v['seat']]['start_time'] = $v['start_time'];
                    $data[$v['group']]['cut'][$v['seat']]['end_time'] = $v['end_time'];
                    $data[$v['group']]['cut'][$v['seat']]['target'] = $v['target'];
                } else {
                    $data[$v['group']]['cut'][$v['seat']]['title'] = $v['title'];
                    $data[$v['group']]['cut'][$v['seat']]['link'] = $v['link'];
                    $data[$v['group']]['cut'][$v['seat']]['picture'] = $v['picture'];
                    $data[$v['group']]['cut'][$v['seat']]['start_time'] = $v['start_time'];
                    $data[$v['group']]['cut'][$v['seat']]['end_time'] = $v['end_time'];
                    $data[$v['group']]['cut'][$v['seat']]['target'] = $v['target'];
                }
            }
        }
        return $data;
    }

    /**
     * 首页线下活动默认城市分类下的广告(用于商城优化)
     * @param  array $cityIdArr 默认城市的城市ID
     * @return array $data
     * @author xiaoyan.luo
     */
    public static function getOfflineDefaultAdvert($cityIdArr,$code='%index-offline%')
    {
        $advertData = Yii::app()->db->createCommand()
            ->select('t.id as advert_id,f.parent_id,f.id,f.name,f.show,f.content,t.name as advert_name,')
            ->from('{{advert}} as t')
            ->leftJoin('{{franchisee_category}} as f', 'f.id = t.franchisee_category_id')
            ->where('t.city_id = :id and t.status = :status and f.status = :f_status and f.show = :show', array(
                ':id' => $cityIdArr['city_id'], ':status' => Advert::STATUS_ENABLE,
                ':f_status' => FranchiseeCategory::STATUS_ENABLE, ':show' => FranchiseeCategory::INDEX_SHOW_YES))
            ->andWhere(array('like', 'code', $code))
            ->limit(4)
            ->order('f.sort DESC, f.id ASC')
            ->queryAll();
        $pictureData = $advertArr = array();
        if (!empty($advertData)) {
            foreach ($advertData as $advert) {
                if(empty($advert['id']))continue;
                $advertArr[$advert['id']] = $advert;
            }
        }

        if (!empty($advertArr)) {
            foreach ($advertArr as $v) {
                $pictureData[$v['id']] = Yii::app()->db->createCommand()
                    ->select('id,title,link,picture,target,start_time,end_time')
                    ->from('{{advert_picture}}')
                    ->where('advert_id = :id and status = :status and start_time<=:time and (end_time >= :time or end_time=0)', array(
                        ':id' => $v['advert_id'],
                        ':status' => AdvertPicture::STATUS_ENABLE,
                        ':time'=>time(),
                    ))
                    ->limit(9)
                    ->queryAll();
            }
        }

        if (!empty($pictureData)) {
            foreach ($pictureData as $key => $value) {
                $advertArr[$key]['ad'] = $pictureData[$key];
            }
        }
        return $advertArr;
    }


    /**
     * 频道主页的广告获取
     * @param $code 广告的编码
     * @param $num 获取的条数
     * @param $sort int 排序类型
     * @return array|mixed
     * @author jiawei.liao 569114018@qq.com
     */
    public static function getChannelIndexAdver($code,$start = 0,$num = 5,$sort = 0){
        $channel_adver = array();

        //Tool::cache(self::CACHEDIR)->flush();
        $channel_adver = Tool::cache(self::CACHEDIR)->get($code);
        if(!is_array($channel_adver)) $channel_adver = unserialize($channel_adver);
        $now = time();

        if(empty($channel_adver)){
            $sortStr = ", ap.id DESC";
            if($sort > 0){
                $sortStr = ", ap.start_time ASC";
            }
            $ap = Yii::app()->db->createCommand()->select('ap.*')->from('{{advert}} as t')
                ->leftJoin('{{advert_picture}} as ap', 't.id = ap.advert_id')
                 ->where('t.status = :status And ap.status = :status And t.code = :code and start_time<=:time and (end_time >= :time or end_time=0)', array(
                    ':status' => self::STATUS_ENABLE,
                     ':code' => $code,
                     ':time'=>time(),
                 ))
                ->order('ap.sort DESC'.$sortStr)->limit($num)
                ->queryAll();
            foreach($ap as $key => $value){
                if($value['start_time'] <= $now && ($value['end_time'] > $now || $value['end_time'] == 0) ){
                        $channel_adver[] = $value;
                }
            }
            Tool::cache(self::CACHEDIR)->set($code,$channel_adver, 86400*7);
            return $channel_adver;
        }

        return $channel_adver;
    }

    /**
     * 楼层 栏目分类定向投放 品牌logo 图片轮播广告
     * @param int $cid 分类id
     * @return array
     */
    public static function getFloorBrandAdvertData($cid){
        $adverts = array();
        $adp = Yii::app()->db->createCommand()->from('{{advert}}') // 关联广告位
        ->where('category_id = :cid And status = :status And type = :type And direction = :direction and code like "index_category_brand%"',
            array(
                ':cid' => $cid,
                ':status' => Advert::STATUS_ENABLE,
                ':type' => Advert::TYPE_SLIDE,
                ':direction' => Advert::DIRECTION_CATEGORY
            )
        )->queryRow();
        if ($adp != false) { // 关联广告
            $adverts = Yii::app()->db->createCommand()->select('link,title,picture,target')->from('{{advert_picture}}')
                ->where('advert_id = :aid And status = :status and start_time<=:time and (end_time >= :time or end_time=0) ', array(
                    ':aid' => $adp['id'],
                    ':status' => AdvertPicture::STATUS_ENABLE,
                    ':time'=>time(),
                ))
                ->order('sort DESC, start_time DESC, id DESC')->queryAll();
        }
        return $adverts;
    }

    /**
     * 清除广告缓存，供盖象2.0使用
     * @author jiawei.liao 569114018@qq.com
     */
    public static function clearvpAdverCache(){

        //Tool::cache(self::CACHE_ACTIVITY_CONFIG)->flush();
        $city = FranchiseeActivityCity::fileCache();
        $franchisee = new FranchiseeCategory();
        $category = $franchisee->getTreeData(0);

        foreach($city as $key => $value){
            Tool::cache(self::CACHEDIR)->delete(self::JMS_BANNER_MAIN.'_'.$value['city_id']);
            Tool::cache(self::CACHEDIR)->delete(self::JMS_BANNER_WELCOME.'_'.$value['city_id']);
            Tool::cache(self::CACHEDIR)->delete(self::JMS_BANNER_BEST.'_'.$value['city_id']);
            Tool::cache(self::CACHEDIR)->delete(self::JMS_MAIN_A.'_'.$value['city_id']);
            Tool::cache(self::CACHEDIR)->delete(self::JMS_MAIN_B.'_'.$value['city_id']);
            Tool::cache(self::CACHEDIR)->delete(self::JMS_MAIN_C.'_'.$value['city_id']);
            Tool::cache(self::CACHEDIR)->delete(self::JMS_MAIN_D.'_'.$value['city_id']);
            Tool::cache(self::CACHEDIR)->delete(self::JMS_MAIN_E.'_'.$value['city_id']);
            Tool::cache(self::CACHEDIR)->delete(self::JMS_MAIN_F.'_'.$value['city_id']);
            Tool::cache(self::CACHEDIR)->delete(self::JMS_LIST_T.'_'.$value['city_id']);
            foreach($category as $k => $v){
                Tool::cache(self::CACHEDIR)->delete(self::JMS_LIST_T.'_'.$k.'_'.$value['city_id']);
            }
        }

        Tool::cache(self::CACHEDIR)->delete(self::FOCUS_PHONE_CODE);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_PHOTOGRAPHY_LEFT_BIG);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_PHOTOGRAPHY_LEFT_DOWN);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_PHOTOGRAPHY_LEFT_TOP);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_PHONE_TOP_TEXT);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_PHONE_TEXT);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_PHONE_LEFT_BIG);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_PHONE_LEFT_DOWN);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_PHONE_LEFT_TOP);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNELCACHE);
        Tool::cache(self::CACHEDIR)->delete(self::PHONE_NAV_CACHE);
        Tool::cache(self::CACHEDIR)->delete(self::PHONE_CHANNEL_CODE);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_SNACKS_LEFT_TOP);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_SNACKS_TEXT);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_DRINK_LEFT_TOP);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_DRINK_TEXT);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_GRAIN_LEFT_TOP);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_GRAIN_TEXT);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_NATIVE_LEFT_TOP);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_NATIVE_TEXT);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_FOOD_NAV_ADVER);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_FOOD_TOP_TEXT);
        Tool::cache(self::CACHEDIR)->delete(self::FOCUS_FOOD_CODE);
        Tool::cache(self::CACHEDIR)->delete(self::FOOD_CHANNEL_CODE);
        Tool::cache(self::CACHEDIR)->delete(self::FOOD_NAV_CACHE);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_DIGITAL_ASS_TEXT);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_DIGITAL_ASS_LEFT_BIG);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_DIGITAL_ASS_LEFT_DOWN);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_DIGITAL_ASS_LEFT_TOP);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_PARTS_TEXT);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_PARTS_LEFT_BIG);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_PARTS_LEFT_DOWN);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_PARTS_LEFT_TOP);
        Tool::cache(self::CACHEDIR)->delete(self::CHANNEL_PHOTOGRAPHY_TEXT);
        return true;
    }
}
