<?php
/**
 * 店铺装修数据json格式化类
 *
 * @author zhenjun_xu <412530435@qq.com>
 */
class DesignFormat extends CComponent
{
    /**
     * @var array 总的json数据
     */
    private $_data = array();
    /** @var string 背景颜色 */
    public $BGColor = '#FFF';
    /** @var string 背景图片 */
    public $BGImg = null;
    /**
     * 相对位置 background-position
     * @var string left top|right top|center
     */
    public $BGPosition = 'left top';
    /**
     * 背景图片平铺方式 background-repeat
     * @var string repeat|repeat-x|repeat-y|no-repeat
     */
    public $BGRepeat = 'repeat';
    /**
     * @var string 店招图片(图片大小：990x100)
     */
    public $BannerImg = null;
    /**
     * @var bool 是否显示背景图片
     */
    public $DisplayBgImage = false;
    /**
     * @var array 装修数据模板
     */
    public $TemplateList = array();
    /**
     * @var array  0-14 装修位置的JsonData数据
     */
    private $_tmpData = array();
    /**
     * 店铺导航链接的类型id
     */
    const NAV_TYPE_INDEX = 0; //首页
    const NAV_TYPE_CAT = 1; //店铺自定义商品分类
    const NAV_TYPE_ARTICLE = 2; //店铺文章
    const NAV_TYPE_DIY = 3; //diy链接
    const NAV_TYPE_INFO = 4; //商家简介
    const NAV_TYPE_LIST = 5; //所有商品
    const NAV_TYPE_STORE = 6; //实体店
    /**
     * 导航链接的类型名称对应的id
     * @param $name
     * @return bool|int
     */
    public static function navType($name)
    {
        $arr = array(
            'TheStore'=>self::NAV_TYPE_STORE,
            'CompCat'=>self::NAV_TYPE_CAT,
            'CompArticle'=>self::NAV_TYPE_ARTICLE,
            'DiyLink'=>self::NAV_TYPE_DIY,
        );
        return isset($arr[$name]) ? $arr[$name] : false;
    }
    public static function navTypeName($k)
    {
        $arr = array(
            self::NAV_TYPE_STORE => 'TheStore',
            self::NAV_TYPE_CAT => 'CompCat',
            self::NAV_TYPE_ARTICLE => 'CompArticle',
            self::NAV_TYPE_DIY => 'DiyLink',
        );
        return isset($arr[$k]) ? $arr[$k] : false;
    }

    /**
     * 模板数据下标
     */
    const TMP_MAIN_BANNER = 0; //店铺横幅
    const TMP_MAIN_NAV = 1;  //导航条
    const TMP_MAIN_SLIDE = 2; //第一页广告幻灯片
    const TMP_MAIN_PROLIST = 3; //第一页推荐商品
    const TMP_LEFT_CONTACT = 4; //主体页面左侧,店铺联系方式
    const TMP_LEFT_CATEGORY = 5; //主体页面左侧,店铺商品分类
    const TMP_LEFT_PROLIST = 6; //主体页面左侧,店铺自定义商品列表
    const TMP_RIGHT_SLIDE = 7; //主体页面右侧,店铺自定义幻灯片
    const TMP_RIGHT_PROLIST = 8; //主体页面右侧,店铺自定义商品列表
    const TMP_RIGHT_SLIDE_2 = 9; //主体页面右侧,店铺自定义幻灯片
    const TMP_RIGHT_PROLIST_2 = 10; //主体页面右侧,店铺自定义商品列表,筛选,翻页
    const TMP_STORE_SYNOPSIS = 11; //实体店页面,店铺介绍
    const TMP_STORE_SLIDE = 12; //实体店页面,幻灯片
    const TMP_STORE_CONTACT = 13; //实体店页面,店铺联系方式
    const TMP_STORE_MAP = 14; //实体店页面,店铺地图
    const TMP_MAIN_AD = 15; //主体页面中部，幻灯片下面的三个图片的产品广告
    const TMP_MAIN_diy = 16; //主体diy部分
    
    const TMP_V20_MAIN_AD = 17; //改版主体页面中部，本月新品广告大图和五张小图
    const TMP_V20_MAIN_PIC = 18; //改版主体一张大图

    /**
     * 平铺方式 background-repeat
     * @param null $k
     * @return array
     */
    public static function bgRepeat($k = null)
    {
        $arr = array(
            'repeat' => Yii::t('design', '默认平铺'),
            'repeat-x' => Yii::t('design', '水平平铺'),
            'repeat-y' => Yii::t('design', '垂直平铺'),
            'no-repeat' => Yii::t('design', '不平铺'),
        );
        return empty($k) ? $arr : (isset($arr[$k]) ? $arr[$k] : null);
    }

    /**
     * 相对位置
     * @param null $k
     * @return array|null
     */
    public static function bgPosition($k = null)
    {
        $arr = array(
            'left top' => Yii::t('design', '左'),
            'right top' => Yii::t('design', '右'),
            'center' => Yii::t('design', '居中'),
        );
        return empty($k) ? $arr : (isset($arr[$k]) ? $arr[$k] : null);
    }

    /**
     * 初始化赋值
     * @param string $data
     */
    public function __construct($data = null)
    {
        $this->_defaultTemplateList();
        if ($data) {
            $data = CJSON::decode($data);
            if (isset($data['TemplateList'])) {
                foreach ($data['TemplateList'] as $k => &$v) {
                    $v['JsonData'] = !empty($v['JsonData']) ? CJSON::decode($v['JsonData']) : '';
                    $this->_tmpData[$k] = $v['JsonData'];
                    $this->TemplateList[$k] = $v;
                }
                $this->_data = $data;
                $this->BGColor = $data['BGColor'];
                $this->BGImg = $data['BGImg'];
                $this->BGPosition = $data['BGPosition'];
                $this->BGRepeat = $data['BGRepeat'];
                $this->BannerImg = $data['BannerImg'];
                $this->DisplayBgImage = $data['DisplayBgImage'];
            }
        }

    }

    public function getData()
    {
        $this->_data['BGColor'] = $this->BGColor;
        $this->_data['BGImg'] = $this->BGImg;
        $this->_data['BGPosition'] = $this->BGPosition;
        $this->_data['BGRepeat'] = $this->BGRepeat;
        $this->_data['BannerImg'] = $this->BannerImg;
        $this->_data['DisplayBgImage'] = $this->DisplayBgImage;
        $this->_data['TemplateList'] = $this->TemplateList;
        return $this->_data;
    }

    /**
     * 0-14 装修位置的JsonData数据
     * @return array
     */
    public function getTmpData()
    {
        return $this->_tmpData;
    }

    /**
     * 设置装修位置的数据，并更新 TemplateList,data的值
     * @param $data
     */
    public function setTmpData($data)
    {
        $this->_tmpData = $data;
        foreach ($this->TemplateList as $k => &$v) {
            $v['JsonData'] = $this->_tmpData[$k];
        }
        $this->_data['TemplateList'] = $this->TemplateList;
    }

    /**
     * @return string 获取json格式数据
     */
    public function getJson()
    {
        $this->_data['BGColor'] = $this->BGColor;
        $this->_data['BGImg'] = $this->BGImg;
        $this->_data['BGPosition'] = $this->BGPosition;
        $this->_data['BGRepeat'] = $this->BGRepeat;
        $this->_data['BannerImg'] = $this->BannerImg;
        $this->_data['DisplayBgImage'] = $this->DisplayBgImage;
        $this->_data['TemplateList'] = $this->TemplateList;
        $data = $this->_data;
        foreach ($data['TemplateList'] as &$v) {
            $v['JsonData'] = !empty($v['JsonData']) ? CJSON::encode($v['JsonData']) : '';
        }
        return CJSON::encode($data);
    }

    /**
     * 生成40位的唯一id
     * @return string
     */
    public static function generateId()
    {
        return str_pad(mt_rand(11111111, 99999999) . strtoupper(md5(time())), 40);
    }

    /**
     * 生成默认的店铺装修数据
     */
    private function _defaultTemplateList()
    {
        // 店铺横幅
        $this->TemplateList[0] = array
        (
            'Code' => '_main_banner_1',
            'DataSource' => 6,
            'ID' => self::generateId(),
            'IsSystem' => true,
            'JsonData' => '',
            'TypeArea' => 1,
        );
        // 导航条
        $this->TemplateList[1] = array
        (
            'Code' => '_main_nav_1',
            'DataSource' => 2,
            'ID' => self::generateId(),
            'IsSystem' => true,
            'JsonData' => '',
            'TypeArea' => 1,
        );
        // 第一页广告幻灯片
        $this->TemplateList[2] = array(
            'Code' => '_main_slide_1',
            'DataSource' => 4,
            'ID' => self::generateId(),
            'IsSystem' => false,
            'JsonData' => '',
            'TypeArea' => 1,
        );
        // 第一页推荐商品
        $this->TemplateList[3] = array(
            'Code' => '_main_proList_1',
            'DataSource' => 1,
            'ID' => self::generateId(),
            'IsSystem' => false,
            'JsonData' =>
                array(
                    'IsEditNum' => false,
                    'CatId' => NULL,
                    'Keywords' => NULL,
                    'MaxMoney' => NULL,
                    'MinMoney' => NULL,
                    'OrderMode' => 1,
                    'ProCount' => 12,
                    'TypeChildTitle' => 'RECOMMENDED PRODUCTS',
                    'TypeTitle' => '精品推荐',
                ),
            'TypeArea' => 1,
        );
        //主体页面左侧,店铺联系方式
        $this->TemplateList[4] = array(
            'Code' => '_left_Contact_1',
            'DataSource' => 3,
            'ID' => self::generateId(),
            'IsSystem' => false,
            'JsonData' => '',
            'TypeArea' => 2,
        );
        //主体页面左侧,店铺商品分类
        $this->TemplateList[5] = array(
            'Code' => '_left_category_1',
            'DataSource' => 5,
            'ID' => self::generateId(),
            'IsSystem' => false,
            'JsonData' => '',
            'TypeArea' => 2,
        );
        //主体页面左侧,店铺自定义商品列表
        $this->TemplateList[6] = array(
            'Code' => '_left_proList_1',
            'DataSource' => 1,
            'ID' => self::generateId(),
            'IsSystem' => false,
            'JsonData' =>
                array(
                    'IsEditNum' => true,
                    'CatId' => NULL,
                    'Keywords' => NULL,
                    'MaxMoney' => NULL,
                    'MinMoney' => NULL,
                    'OrderMode' => 1,
                    'ProCount' => 3,
                    'TypeChildTitle' => '',
                    'TypeTitle' => '人气商品',
                ),
            'TypeArea' => 2,
        );
        //主体页面右侧,店铺自定义幻灯片
        $this->TemplateList[7] = array(
            'Code' => '_right_slide_1',
            'DataSource' => 4,
            'ID' => self::generateId(),
            'IsSystem' => false,
            'JsonData' => '',
            'TypeArea' => 3,
        );
        //主体页面右侧,店铺自定义商品列表
        $this->TemplateList[8] = array(
            'Code' => '_right_proList_1',
            'DataSource' => 1,
            'ID' => self::generateId(),
            'IsSystem' => false,
            'JsonData' =>
                array(
                    'IsEditNum' => true,
                    'CatId' => NULL,
                    'Keywords' => NULL,
                    'MaxMoney' => NULL,
                    'MinMoney' => NULL,
                    'OrderMode' => 1,
                    'ProCount' => 4,
                    'TypeChildTitle' => 'HOT PRODUCTS',
                    'TypeTitle' => '热卖商品',
                ),
            'TypeArea' => 3,
        );
        //主体页面右侧,店铺自定义幻灯片
        $this->TemplateList[9] = array(
            'Code' => '_right_slide_1',
            'DataSource' => 4,
            'ID' => self::generateId(),
            'IsSystem' => false,
            'JsonData' => '',
            'TypeArea' => 3,
        );
        //主体页面右侧,店铺自定义商品列表,筛选,翻页
        $this->TemplateList[10] = array(
            'Code' => '_right_proList_1',
            'DataSource' => 1,
            'ID' => self::generateId(),
            'IsSystem' => false,
            'JsonData' =>
                array(
                    'IsEditNum' => true,
                    'CatId' => NULL,
                    'Keywords' => NULL,
                    'MaxMoney' => NULL,
                    'MinMoney' => NULL,
                    'OrderMode' => 1,
                    'ProCount' => 8,
                    'TypeChildTitle' => 'NEW PRODUCTS',
                    'TypeTitle' => '新品上架',
                ),
            'TypeArea' => 3,
        );
        // 实体店页面,店铺介绍
        $this->TemplateList[11] = array(
            'Code' => '_the_store_synopsis_1',
            'DataSource' => 7,
            'ID' => self::generateId(),
            'IsSystem' => false,
            'JsonData' => '',
            'TypeArea' => 4,
        );
        // 实体店页面,幻灯片
        $this->TemplateList[12] = array(
            'Code' => '_the_store_slide_1',
            'DataSource' => 7,
            'ID' => self::generateId(),
            'IsSystem' => false,
            'JsonData' => '',
            'TypeArea' => 4,
        );
        // 实体店页面,店铺联系方式
        $this->TemplateList[13] = array(
            'Code' => '_the_store_contact_1',
            'DataSource' => 7,
            'ID' => self::generateId(),
            'IsSystem' => false,
            'JsonData' => '',
            'TypeArea' => 4,
        );
        // 实体店页面,店铺地图
        $this->TemplateList[14] = array(
            'Code' => '_the_store_map_1',
            'DataSource' => 7,
            'ID' => self::generateId(),
            'IsSystem' => false,
            'JsonData' => '',
            'TypeArea' => 4,
        );
        // 主体页面中部，幻灯片下面的三个图片的产品广告
        $this->TemplateList[15] = array(
            'Code' => '_main_ad_1',
            'DataSource' => 4,
            'ID' => self::generateId(),
            'IsSystem' => false,
            'JsonData' => '',
            'TypeArea' => 1,
        );
        // 主体页面自定义区域
        $this->TemplateList[16] = array(
            'Code' => '_main_diy',
            'DataSource' => 4,
            'ID' => self::generateId(),
            'IsSystem' => false,
            'JsonData' => '',
            'TypeArea' => 1,
        );
        
        // 改版v.20主体页面中部，幻灯片下面的五个图片的产品广告
        $this->TemplateList[17] = array(
                'Code' => '_the_store_pic_1',
                'DataSource' => 4,
                'ID' => self::generateId(),
                'IsSystem' => false,
                'JsonData' => '',
                'TypeArea' => 1,
        );
        
        // 改版v.20主体页面中部，一张广告图
        $this->TemplateList[18] = array(
                'Code' => '_the_store_adv_1',
                'DataSource' => 4,
                'ID' => self::generateId(),
                'IsSystem' => false,
                'JsonData' => '',
                'TypeArea' => 1,
        );

        foreach ($this->TemplateList as $v) {
            $this->_tmpData[] = $v['JsonData'];
        }
        $this->_data['BGColor'] = $this->BGColor;
        $this->_data['BGImg'] = $this->BGImg;
        $this->_data['BGPosition'] = $this->BGPosition;
        $this->_data['BGRepeat'] = $this->BGRepeat;
        $this->_data['BannerImg'] = $this->BannerImg;
        $this->_data['DisplayBgImage'] = $this->DisplayBgImage;
        $this->_data['TemplateList'] = $this->TemplateList;

    }


}

?>