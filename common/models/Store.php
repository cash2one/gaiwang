<?php

/**
 *  商家的信息表 模型
 * @author zhenjun.xu<412530435@qq.com>
 * 
 * @property string $id
 * @property string $name
 * @property string $province_id
 * @property string $city_id
 * @property string $district_id
 * @property string $street
 * @property string $mobile
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 * @property integer $sort
 * @property string $keywords
 * @property string $description
 * @property integer $order_reminder
 * @property string $views
 * @property string $description_match
 * @property string $serivice_attitude
 * @property string $speed_of_delivery
 * @property string $about_us
 * @property string $referrals_id
 * @property string $thumbnail
 * @property string $buy_knows
 * @property string $after_service
 * @property string $activites_collect
 * @property string $member_id
 * @property string $content
 * @property integer $comments
 * @property integer $sales
 * @property integer $category_id
 */
class Store extends CActiveRecord {

    const STATUS_APPLYING = 1;
    const STATUS_ON_TRIAL = 2;
    const STATUS_PASS = 3;
    const STATUS_REJECT = 4;
    const STATUS_CLOSE = 5;
    const MODE_FREE = 1;
    const MODE_CHARGE = 2;
    const MODE_NOT = 3;
    //网签 开店状态
    const STORE_STATUS_APPLYING = 1;
    const STORE_STATUS_ON_TRIAL = 2;
    const STORE_STATUS_PASS = 3;
    
    //是否是居间商
    const STORE_ISMIDDLEMAN_NO=0;
    const STORE_ISMIDDLEMAN_YES=1;
    

    public $endTime;
    //平均评分
    public $avg_score;
    public $username;
    
    ////下属商家列表属性
    public $categoryname;
    public $sales_goods;
    public $stote_id;
    public $gai_number;
    public $location;
    public $link_man;
    ///↓↓↓居间商属下↓↓↓ ///
    public $middlename; // 居间商名称
    public $exportLimit = 5000; //导出excel长度
    /// ↑↑↑居间商属下↑↑↑ ///
    ///下属商家列表属性

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
    
    /**
     * 商家状态
     * @param $key
     * @return array|null
     */
    public static function status($key = null) {
        $arr = array(
            self::STATUS_APPLYING => Yii::t('store', '申请中'),
            self::STATUS_ON_TRIAL => Yii::t('store', '试用中'),
            self::STATUS_PASS => Yii::t('store', '申请通过'),
            self::STATUS_REJECT => Yii::t('store', '申请被拒绝'),
            self::STATUS_CLOSE => Yii::t('store', '关闭'),
        );
        if (is_numeric($key)) {
            return isset($arr[$key]) ? $arr[$key] : null;
        } else {
            return $arr;
        }
    }

    /**
     * 开店模式数组
     * @param $key
     * @return array|null
     */
    public static function getMode($key = null) {
        $arr = array(
            self::MODE_FREE => Yii::t('store', '免费'),
            self::MODE_CHARGE => Yii::t('store', '收费'),
            self::MODE_NOT => Yii::t('store', '未确定'),
        );
        if (is_numeric($key)) {
            return isset($arr[$key]) ? $arr[$key] : null;
        } else {
            return $arr;
        }
    }

    public function tableName() {
        return '{{store}}';
    }

    public function rules() {
        return array(
            array('referrals_id', 'checkReferral', 'on' => 'updateRecommend'),
//            array('email','required','on'=>'updateImport'),
            array("email", "email", "message" => "邮箱格式不正确"),
            array('name, province_id, city_id, district_id, street, mobile,  member_id', 'required'),
            array('status, sort, order_reminder', 'numerical', 'integerOnly' => true),
            array('mobile', 'comext.validators.isMobile', 'errMsg' => Yii::t('store', '请输入正确的手机号码')),
            array('name', 'unique'),
            array('name, street, keywords, about_us, thumbnail, buy_knows, after_service, activites_collect', 'length', 'max' => 128),
            array('thumbnail', 'file', 'allowEmpty' => true, 'types' => 'jpg,jpeg,gif,png', 'maxSize' => 1024 * 1024 * 1, 'tooLarge' => '上传图片最大不能超过1Mb,请重新上传'),
			array('logo', 'file', 'allowEmpty' => true, 'types' => 'jpg,jpeg,gif,png', 'maxSize' => 1024 * 1024 * 1, 'tooLarge' => '上传图片最大不能超过1Mb,请重新上传'),
			array('slogan', 'file', 'allowEmpty' => true, 'types' => 'jpg,jpeg,gif,png', 'maxSize' => 1024 * 1024 * 1, 'tooLarge' => '上传图片最大不能超过1Mb,请重新上传'),
            array('province_id, city_id, district_id, create_time, update_time, views, referrals_id, member_id', 'length', 'max' => 11),
            array('mobile', 'length', 'max' => 16),
            array('description', 'length', 'max' => 256),
            array('description_match, serivice_attitude, speed_of_delivery', 'length', 'max' => 11),
            array('member_id, name, status, create_time, endTime', 'safe', 'on' => 'search'),
            array('endTime,category_id,mode,province_id,city_id,district_id,street', 'safe'),
            array('referrals_id', 'isBusiness', 'on' => 'updateRecommend'),
            array('email', 'safe'),
			array('bg_color', 'safe'),
			array('qualifications', 'length', 'max' => 100),
//            array('referrals_id', 'isBusiness'),
            array('name, province_id, city_id, district_id, street, category_id', 'required', 'on' => 'enterpriseLog,enterpriseCreate'),
            //店铺星星数限制
            //array('description_match,serivice_attitude,speed_of_delivery','numerical', 'max' => 5,'min'=>1,'on'=>'comment'),
            //array('description_match,serivice_attitude,speed_of_delivery', 'required','on'=>'comment'),
        );
    }

    /**
     * 验证店铺推荐者
     * @param $attribute
     * @param $params
     */
    public function checkReferral($attribute, $params) {
        $oldModel = self::model()->find(array(
            'select' => 'referrals_id',
            'condition' => 'id = :id',
            'params' => array(':id' => $this->id),
        ));
        //如果以前有设置过推荐者可以清空推荐者,保存数据.反之以前没有设置过推荐者那就要设置推荐者才能提交
        if ($oldModel->referrals_id == 0 && $this->referrals_id == 0) {
            $this->addError($attribute, Yii::t('store', '推荐人 不可为空白'));
        }
    }

    /**
     * 验证店铺的推荐会员是否为企业会员
     * @param $attribute
     * @param $params
     */
    public function isBusiness($attribute, $params) {
        $member = Member::model()->find(array(
            'select' => 'enterprise_id, gai_number',
            'condition' => 'id=:id',
            'params' => array(':id' => $this->referrals_id)
        ));
        if ($member && $member->enterprise_id == 0)
            $this->addError($attribute, Yii::t('store', '请输入企业会员的GW号'));
    }

    public function relations() {
        return array(
            'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
            'referrals' => array(self::BELONGS_TO, 'Member', 'referrals_id'),
            //'enterprise' => array(self::HAS_ONE, 'Enterprise', 'member_id'),
            'goods' => array(self::HAS_MANY, 'Goods', 'store_id',
                'condition' => 'goods.status=' . Goods::STATUS_PASS . ' and goods.is_publish=' . Goods::PUBLISH_YES . ' and goods.life=' . Goods::LIFE_NO), //在售商品统计
            'province' => array(self::BELONGS_TO, 'Region', 'province_id'),
            'city' => array(self::BELONGS_TO, 'Region', 'city_id'),
            'district' => array(self::BELONGS_TO, 'Region', 'district_id'),
            'category' => array(self::BELONGS_TO, 'Category', 'category_id')
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('store', '主键'),
            'name' => Yii::t('store', '名称'),
            'province_id' => Yii::t('store', '省份'),
            'city_id' => Yii::t('store', '城市'),
            'district_id' => Yii::t('store', '区/县'),
            'street' => Yii::t('store', '详细地址'),
            'mobile' => Yii::t('store', '手机号码'),
            'status' => Yii::t('store', '状态'),
            'create_time' => Yii::t('store', '创建时间'),
            'update_time' => Yii::t('store', '更新时间'),
            'sort' => Yii::t('store', '排序'),
            'keywords' => Yii::t('store', '页面关键词'),
            'description' => Yii::t('store', '页面描述'),
            'order_reminder' => Yii::t('store', '新订单提醒时间'),
            'views' => Yii::t('store', '浏览量'),
            'description_match' => Yii::t('store', '描述相符评分'),
            'serivice_attitude' => Yii::t('store', '服务态度评分'),
            'speed_of_delivery' => Yii::t('store', '发货速度评分'),
            'about_us' => Yii::t('store', '关于我们'),
            'referrals_id' => Yii::t('store', '推荐人'),
            'thumbnail' => Yii::t('store', '商铺图片'),
            'buy_knows' => Yii::t('store', 'BUY_KNOWS'),
            'after_service' => Yii::t('store', '售后服务'),
            'activites_collect' => Yii::t('store', 'ACTIVITES_COLLECT'),
            'member_id' => Yii::t('store', '所属会员'),
            'content' => Yii::t('store', '商家说明'),
            'endTime' => Yii::t('endTime', '到'),
            'comments' => Yii::t('store', '评论次数'),
            'category_id' => Yii::t('store', '经营类目'),
            'mode' => Yii::t('store', '开店模式'),
            'c_money' => Yii::t('c_money', '授信额'),
            'c_surplus_money' => Yii::t('c_surplus_money', '剩余授信额'),
            'c_ratio' => Yii::t('c_ratio', '盖网活动支持比例'),
            'c_status' => Yii::t('c_status', '活动状态'),
            'is_partner' => Yii::t('store', '是否合作伙伴'),
//            'sales_account' => Yii::t('store', '当月销售额（元）'),
            'gai_number' => Yii::t('store', '盖网编号'),
            'middlename' => Yii::t('member', '居间商名称'),
            'location' => Yii::t('member', '所在地区'),
//            'businesses' => Yii::t('member', '属下商家数'),
            'link_man' => Yii::t('member', '联系人'),
//            'partner' => Yii::t('member', '合作伙伴'),
            'logo' => '商铺logo',
			'slogan' => '商铺banner',
			'bg_color' => '商铺banner背景色',
			'qualifications' => '商铺资质',
        );
    }

    /**
     * 后台店铺列表
     * @return \CActiveDataProvider
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    public function search() {
        $criteria = new CDbCriteria;
        $criteria->select = 't.name, t.mobile, t.status, t.create_time, t.referrals_id,t.is_middleman';
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.status', $this->status);
        $searchDate = Tool::searchDateFormat($this->create_time, $this->endTime);
        $criteria->compare('t.create_time', ">=" . $searchDate['start']);
        $criteria->compare('t.create_time', "<" . $searchDate['end']);
        $criteria->with = array('member' => array('select' => 'gai_number'));
        $criteria->compare('member.gai_number', $this->member_id);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 15,
            ),
            'sort' => array(
                'defaultOrder' => 't.id DESC'
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 模型保存前的操作
     * 新增商家信息，修改其添加时间
     * 编辑商家信息，修改其更新时间
     * @return boolean
     */
    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord)
                $this->create_time = $this->update_time = time();
            return true;
        } else
            return true;
    }

    /**
     * 模型保存后的操作
     * 商家关闭，申请中，或申请失败，将其下的商品作下架处理
     */
    public function afterSave() {
        parent::afterSave();
        if ($this->status * 1 === self::STATUS_APPLYING || $this->status * 1 === self::STATUS_CLOSE || $this->status * 1 === self::STATUS_REJECT)
            Goods::model()->updateAll(array('status' => Goods::STATUS_NOPASS, 'is_publish' => Goods::PUBLISH_NO), 'store_id=:cid', array(':cid' => $this->id));
    }

    /**
     * 查找后操作，计算平均评分
     */
    public function afterFind() {
        $total = $this->description_match + $this->serivice_attitude + $this->speed_of_delivery;
        $this->avg_score = (int) $total && (int) $this->comments ? sprintf('%0.2f', ($total / $this->comments) / 3) : 0;
    }

    /**
     * 获取建议商家名称
     * 后台搜索商品用（auto complete）
     * @param string $keyword 关键字
     * @param int $limit 数量
     * @return array
     */
    public function suggestStores($keyword, $limit = 20) {
        $stores = $this->findAll(array(
            'condition' => 'name LIKE :keyword',
            'order' => 'id DESC',
            'limit' => $limit,
            'params' => array(
                ':keyword' => '%' . strtr($keyword, array('%' => '\%', '_' => '\_', '\\' => '\\\\')) . '%',
            ),
        ));
        $result = array();
        foreach ($stores as $store) {
            $result[] = array(
                'value' => $store->name,
            );
        }
        return $result;
    }

    /**
     * 后台统计数据 商铺统计 每天运行一次 统计到昨天为止的各项数量
     */
    public static function staticStore() {
        $startDay = strtotime(date('Y-m-d 00:00:00')) - 86400; //昨天的开始时间
        $endDay = $startDay + 86399; //昨天的结束时间
        //昨天新增商家
        $newAdd = Yii::app()->db->createCommand()
            ->select("count(1)")
            ->from('{{store}}')
            ->where("create_time between $startDay and $endDay")
            ->queryScalar();

        $storeData = array(
            'totalCount' => 0, //商铺总量
            'applyCount' => 0, //申请中商品数量
            // 'shoppingCount' => 0, //经营中商铺数量
            'closeCount' => 0, //关闭商品数量
            'ontrialCount' => 0, //试用
            'passCount' => 0, //通过的
        );

        $storeArr = Yii::app()->db->createCommand()
            ->select("count(1) as num,status")
            ->from('{{store}}')
            ->group('status')
            ->queryAll();
        foreach ($storeArr as $row) {
            if ($row['status'] == Store::STATUS_APPLYING)
                $storeData['applyCount']+=$row['num'];

            if ($row['status'] == Store::STATUS_CLOSE)
                $storeData['closeCount']+=$row['num'];
            if ($row['status'] == Store::STATUS_ON_TRIAL) {
                $storeData['ontrialCount'] += $row['num'];
            }
            if ($row['status'] == Store::STATUS_PASS) {
                $storeData['passCount'] += $row['num'];
            }
            $storeData['totalCount']+=$row['num'];
        };

        $time = time(); //创建日期
        //插入数据表
        $insertSql = "insert into {{store_day}} (`id`,`new_store_count`,`total_store_count`,`applying_store_count`,`ontrial_store_count`,`pass_store_count`,`closed_store_count`,`statistics_date`,`create_time`)" .
            " values ('','$newAdd','" . $storeData['totalCount'] . "','" . $storeData['applyCount'] . "','" . $storeData['ontrialCount'] . "','" . $storeData['passCount'] . "','" . $storeData['closeCount'] . "','$startDay','$time')";
        if (Yii::app()->st->createCommand($insertSql)->execute()) {
            echo date('Y-m-d', $startDay) . ' 插入记录成功';
        }
    }

    //统计商铺排行 每天运行一次 统计到这个月到昨天为止的数据
    public static function staticStoreSort() {

        $startDay = strtotime(date('Y-m-d 00:00:00')) - 86400; //昨天的开始时间
        $endDay = $startDay + 86399; //昨天的结束时间
        //成交订单
        $sql = "select count(t.id) as num,sum(g.total_price) as total,sum(g.gai_price) as gai,c.name,t.store_id from {{order}} t" .
            " left join {{order_goods}} g on t.id=g.order_id" .
            " left join {{store}} c on t.store_id=c.id" .
            " where t.pay_time between $startDay and $endDay group by t.store_id" .
            " order by num desc,total desc,gai desc limit 20";
        $datas = Yii::app()->db->createCommand($sql)->queryAll();

//        $insertArr = array(
//            'payCount'=> 0 ,
//            'payGai'=>0,
//            'payPrice'=>0,
//        );
        $time = time(); //创建时间

        if (!empty($datas)) {
            $insertSql = "INSERT INTO {{shop_order_day}} (`store_id`,`store_name`,`pay_order_count`,`pay_order_gai_price`,`pay_order_price`,`statistics_date`,`create_time`) VALUES ";
            foreach ($datas as $row) {
//                    $insertArr['payCount'] += $row['pay_order_count'];
//                    $insertArr['payGai'] += $row['pay_order_gai_price'];
//                    $insertArr['payPrice'] += $row['pay_order_price'];
                $insertSql .= "('" . $row['store_id'] . "','" . $row['name'] . "','" . $row['num'] . "','" . $row['gai'] . "','" . $row['total'] . "','" . $startDay . "','" . $time . "'),";
            }
            $insertSql = substr($insertSql, 0, strlen($insertSql) - 1);

            if (Yii::app()->st->createCommand($insertSql)->execute()) {
                echo date('Y-m-d', $startDay) . ' 数据插入成功';
            }
        } else {
            echo '昨天没有数据';
        }
    }

    /**
     * 获取综合评分
     * @param int $description_match 描述相符评分
     * @param int $serivice_attitude 服务态度评分   
     * @param int $speed_of_delivery 发货速度评分
     * @param int $comments 评论次数
     * @return float $compositeScore 综合分数
     */
    public static function getCompositeScore($description_match = 0, $serivice_attitude = 0, $speed_of_delivery = 0, $comments = 0) {
        if ($comments == 0) {
            $compositeScore = 0;
        } else {
            $compositeScore = (($description_match + $serivice_attitude + $serivice_attitude) / $comments) / 3;
        }

        return number_format($compositeScore, 1, '.', '');
    }

    /**
     * 后台盖惠券授信列表
     * @return \CActiveDataProvider
     * @author qinghao.ye <qinghaoye@sina.com>
     */
    public $activtyStatus;
    public $c_money, $c_surplus_money, $c_ratio, $c_status;

    public function searchCouponCredit() {
        $criteria = new CDbCriteria;
        $criteria->select = 't.id,t.name,sa.money AS c_money,sa.surplus_money AS c_surplus_money,sa.ratio AS c_ratio,IF(sa.status,sa.status,' . StoreAccount::STATUS_OFF . ') AS c_status';
        $criteria->join = 'LEFT JOIN {{store_account}} sa ON t.id=sa.store_id';
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.member_id', $this->member_id);
        if ($this->c_status == StoreAccount::STATUS_OFF) {
            $criteria->addCondition("sa.status = :status OR sa.status IS NULL");
        } else {
            $criteria->addCondition("sa.status = :status");
        }
        $criteria->params[':status'] = $this->c_status;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 15,
            ),
            'sort' => array(
                'defaultOrder' => 't.id DESC'
            ),
        ));
    }

    /**
     * 下属商家列表  
     */
    public function businessStore($under = null) {
//        $a = $this->getAttributes();
//        var_dump($a);exit;
        $criteria = new CDbCriteria;
        $criteria->select = 't.id,t.create_time,t.status,t.is_partner,t.name,c.name as categoryname,m.gai_number,t.member_id,t.referrals_id';
        $criteria->join = 'LEFT JOIN {{category}} as c ON c.id=t.category_id
                           LEFT JOIN {{member}} as m ON m.id=t.member_id ';
        $criteria->compare("t.referrals_id ",$this->referrals_id);
        $criteria->compare('t.under_id', $under);
        $criteria->addSearchCondition('m.gai_number',  trim($this->gai_number));
        $criteria->addSearchCondition('t.name', $this->name);
//        $criteria->group = 't.id';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 15,
            ),
            'sort' => array(
                'defaultOrder' => 't.id DESC'
            ),
        ));
    }

    /*
     *  商家详细信息
     */

    public function viewStore() {
        $criteria = new CDbCriteria;
        $criteria->select = 't.id,t.create_time,t.referrals_id,t.name,t.status,t.mode,g.name as categoryname,count(s.id) as sales_goods';
        $criteria->join = ('LEFT JOIN {{category}} as g ON t.category_id = g.id
                            LEFT JOIN {{goods}} as s ON t.id=s.store_id');
        $criteria->compare('t.id', '=' . $this->id);
        $criteria->with = array(
            'member' => array('select' => 'gai_number'),
        );
        return $this->find($criteria);
    }

    /**
     * 商家某段时间内的总销售额
     * @param int $storeId 商家Id
     * @param string $startTime 查找开始时间  如：2015-4(2015-6-8 00:00:00)
     * @param string $endTime 查找结束时间 如：2015-5(2015-6-8 23:59:59)
     */
    public static function getAcount($storeId,$startTime=null,$endTime=null){
        $order = new Order();
        $criteria = new CDbCriteria;
        $criteria->compare('t.status', Order::STATUS_COMPLETE);
        if (!empty($startTime) && !empty($endTime)){
            $criteria->compare('t.pay_time', ">=" . $startTime);
            $criteria->compare('t.pay_time', "<=" . $endTime);
        }
        $criteria->compare('t.store_id',$storeId);
        $criteria->select = 'sum(t.real_price) as sum_price';
        $info = $order->find($criteria);
        return $info->sum_price ? number_format($info->sum_price,2) : 0;
    }

    /**
     * 某一月份或者某天的返还积分数
     * @param int $store_id 店铺ID
     * @param string $month 时间 月份格式：201506 日期格式：20150616
     * @param boolean $flag true是月份，false是日期
     * @return $ac
     */
    public static function getJF($store_id, $month,$flag=true) {
        // 获取积分，需要检查流水表是否存在。
        $memArr = Member::model()->find(array(
            'select' => 't.gai_number',
            'join' => 'LEFT JOIN {{store}} AS s ON t.id=s.member_id',
            'condition' => 's.id=:id',
            'params' => array(':id' => $store_id)
        ));
        $monthTable = 'account.gw_account_flow_'  . date('Ym',strtotime($month));
        $time = strtotime($month);
        $date = $flag ? 'MONTH' : 'DAY';
        $ac = yii::app()->db->createCommand()
            ->select('SUM(credit_amount) AS amount')
            ->from($monthTable)
            ->where("gai_number = :gw AND `type`=:type AND `operate_type`=:otype AND create_time >=:startime AND create_time <= UNIX_TIMESTAMP(DATE_ADD(:endtime,INTERVAL +1 $date))", array(
              ':gw' => $memArr->gai_number,
              ':type' => AccountFlow::TYPE_CONSUME,
              ':otype' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_SIGN,
              ':startime' => $time,
              ':endtime' => $month))
          ->queryRow();
        if (empty($ac['amount']))
            $ac['amount'] = '0';
        return $ac['amount'];
    }
    
    /**
     * 某一月份内按天返还积分数
     * @param int $store_id 店铺ID
     * @param string $mouth 月份
     * @return $ac
     */
    public static function getDayJF($store_id, $mouth) {
        $memArr = Member::model()->find(array(
                'select' => 't.gai_number',
                'join' => 'LEFT JOIN {{store}} AS s ON t.id=s.member_id',
                'condition' => 's.id=:id',
                'params' => array(':id' => $store_id)
        ));
        $monthTable = 'account.gw_account_flow_' . $mouth;
        $ac = yii::app()->db->createCommand()
        ->select('SUM(credit_amount) AS amount,FROM_UNIXTIME(create_time,"%Y-%m-%d") AS `create_time`')
        ->from($monthTable)
        ->where('gai_number = :gw AND `type`=:type AND `operate_type`=:otype', array(
            ':gw' => $memArr->gai_number, 
            ':type' => AccountFlow::TYPE_CONSUME, 
            ':otype' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_SIGN))
        ->group('create_time')
        ->queryAll();
        return $ac;
    }
    

   /**
     * 居间商下的商家
     * @param int $memId 用户ID
     */
    public function getMiddleAgent(){
        $criteria = new CDbCriteria;
        $criteria->select ='t.member_id,t.is_partner,t.province_id,t.city_id,t.id,t.create_time,cat.name as category_id,t.mobile,t.name,t.status,t.mode,m.gai_number AS username';
        $criteria->join ='LEFT JOIN {{member}} AS m ON m.id=t.member_id  LEFT JOIN {{category}} AS cat ON t.category_id=cat.id'; 
        $criteria->compare('t.referrals_id',$this->referrals_id);
        $criteria->compare('t.is_partner',$this->is_partner);
        $criteria->compare('t.under_id',$this->under_id);
        if($this->keywords) {
            $criteria->addCondition("(t.name like '%$this->keywords%' or m.gai_number like '%$this->keywords%')");
        }
        return new CActiveDataProvider($this, array(
                'criteria' =>$criteria,
                'pagination' => array(
                        'pageSize' => 10,
                ),
                'sort' => array(
                        'defaultOrder' => 't.id DESC'
                ),
        ));
    }
   

    /**
     *  合作伙伴列表 
     */
    public function partnerList()
    {
        $criteria = new CDbCriteria;
        $criteria->select = 't.is_partner,t.referrals_id,t.member_id,e.name,m.gai_number,CONCAT(r.name,l.name) as location,e.link_man,e.mobile';
        $criteria->join = 'LEFT JOIN {{member}} as m ON t.member_id = m.id
                           LEFT JOIN {{enterprise}} as e ON e.id = m.enterprise_id
                           LEFT JOIN {{region}} as r ON r.id = e.province_id 
                           LEFT JOIN {{region}} as l ON l.id = e.city_id';
        $criteria->compare('t.is_partner', $this->is_partner);
        $criteria->compare('t.referrals_id', $this->is_partner);
        $criteria->addSearchCondition('m.gai_number', $this->gai_number);
        $criteria->addSearchCondition('e.name', $this->name);
        
        return new CActiveDataProvider($this,array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>15
            ),
           'sort'=>array(
               'defaultOrder' => 't.id DESC'
           ),
        ));
    }
    
    /**
     * 合作伙伴推荐商家
     * @param int $under_id
     * @return int 
     */
   public static function getUnder($under_id,$memberId)
   {
       return self::model()->count('under_id=:under_id AND referrals_id=:mid', array(':under_id' => $under_id,':mid'=>$memberId));
   }
   
   /**
    * 居间商直属商家
    * @param int $memberId 推荐id
    * @return int
    */
   public static function getReferrals($memberId)
   {
       return self::model()->count('referrals_id=:mid', array(':mid'=>$memberId));
   }
   /**
    * 合作伙伴推荐商家
    * @param int $memberId 推荐id
    * @return int
    */
   public static function getPartnerRef($memberId)
   {
       return self::model()->count('referrals_id=:mid AND under_id=:uid', array(':mid'=>$memberId,':uid'=>Store::STORE_UNDER_YES));
   }
   /**
    * 获取居间商列表
    */
    public function getMiddleAgentList($limit=15)
    {
        $criteria = new CDbCriteria();
        $criteria->select = 't.id,t.member_id,m.gai_number,CONCAT(r.name,g.name) as location,e.link_man,t.mobile,e.name';
        $criteria->compare('t.is_middleman', self::STORE_ISMIDDLEMAN_YES);
        $criteria->join = 'LEFT JOIN {{member}} as m ON t.member_id = m.id 
                           LEFT JOIN {{enterprise}} as e ON e.id = m.enterprise_id 
                           LEFT JOIN {{region}} as r ON e.province_id = r.id 
                           LEFT JOIN {{region}} as g ON e.city_id = g.id';
        $criteria->addSearchCondition('m.gai_number', trim($this->gai_number));
        $criteria->addSearchCondition('e.mobile', $this->mobile);
        $criteria->addSearchCondition('e.name', $this->name);
        $criteria->addSearchCondition('e.link_man', $this->link_man);
        $criteria->compare('e.province_id', $this->province_id);
        $criteria->compare('e.city_id', $this->city_id);
        $criteria->compare('e.district_id', $this->district_id);
        return new CActiveDataProvider($this,array(
           'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>$limit
            ),
           'sort'=>array(
               'defaultOrder' => 't.id DESC'
           ),
       ));
    }
    
    /**
     * 获取居间商的合作伙伴或下属ID
     * @params int $referrals_id
     */
    public function getPartnerId($referrals_id,$under=null)
    {
        $condition = 'referrals_id=:referrals_id';
        $params = array(':referrals_id'=>$referrals_id);
        if($under){ 
            $condition .= ' AND under_id=:under'; 
            $params[':under'] = $under;
        }
        return self::model()->findAll(array(
            'condition'=>$condition,
            'params'=>$params
        ));
    }
    
    /**
     * 向上检查是否有居间商 及解除关系
     */
    public function hasMiddle()
    {
        if($this->under_id){ //则是属下商家的招入商家，简单解除关系
            $this->referrals_id = 0;
        } else {
            $store = self::model()->find('member_id=:id', array(':id'=>$this->referrals_id)); //是否是其推荐人成为居间商属下商家时招入
            if($store && $store->is_middleman == self::STORE_ISMIDDLEMAN_YES){
                //推荐人是居间商
                $this->_changeRef();
            } 
        }
//        return true;
    }
    /**
     * 修改推荐人
     */
    protected function _changeRef()
    {
        $referrals_id = $this->referrals_id;
        $stores = $this->getPartnerId($this->member_id,self::STORE_UNDER_YES); //查找该商家的推荐的商家。
        foreach($stores as $store){
            $store->referrals_id = $referrals_id;
            $store->under_id = self::STORE_UNDER_NO;
            if(!$store->save(false)){
                throw new Exception('属下商家净身出户错误');
            }
        }
        //脱离与原居间商关系，自己成为居间商
        $this->referrals_id = 0;
    }
    /**
     * 成为居间商后，最终的推荐人(修改)
     * @param int $referrals 修改为推荐人
     */
    public function updateStore()
    {
        $this->under_id = self::STORE_UNDER_NO;
        $this->is_middleman = self::STORE_ISMIDDLEMAN_YES;
        $this->is_partner = self::STORE_PARTNER_NO;
        if(!$this->save(false)){
            throw new Exception('添加居间商失败');
        }
    }
    /**
     * 下属商家是否有推荐人
     */
    public function hasAgent()
    {
        $agents = self::model()->findAll('referrals_id=:id and is_middleman=:is',array(':id'=>$this->member_id,':is'=>self::STORE_ISMIDDLEMAN_YES));
        if(!empty($agents)){
            foreach ($agents as $agent) {
                $agent->referrals_id = 0;
                if(!$agent->save(false)){
                    throw new Exception('属下商家含有居间商,但解除两者关系失败');
                }
            }
        }
    }

    public static function is_partner($is_partner=0)
    {
        if($is_partner == self::STORE_PARTNER_YES)
            return Yii::t('middleAgent','是');
        return Yii::t('middleAgent','否');  
    }
	
	/**
	*  商铺的资质数组,暂定以下几个
	*  return array
	*/
	public static function getQualifications(){
	    return array(1=>'金牌商家',
		             2=>'品牌直销',
					 3=>'助学店铺',
					 4=>'爱心店铺'
		);	
	}
}
