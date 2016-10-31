<?php

/**
 * 商品控制器
 * @author xiaoyan.luo<xiaoyan.luo@gatewang.com>
 */
class GoodsController extends WController
{

    public $top = true;
    public $cart = true; //加入购物车模块是否显示

    /**
     * 商品基本信息
     */
    public function actionIndex()
    {
        $this->footer = true;
        $this->pageTitle = '盖象微商城_商品信息';
        // 检查是否有该商品存在
        if (!$g = Goods::getGoodsDetail($this->getParam('id'))) {
            throw new CHttpException(404, Yii::t('goods', '没有找到相关商品！'));
        }
        if ($g['status'] != Goods::STATUS_PASS || $g['is_publish'] == Goods::PUBLISH_NO || $g['life'] == Goods::LIFE_YES) {
            throw new CHttpException(404, Yii::t('goods', '很抱歉，您查看的商品不存在，可能已下架或者被转移！'));
        }
        if (!empty($g['store_id'])) {
            $store = Store::model()->findByPk($g['store_id'], array('select' => 'name'))->name;
        }
        $this->showTitle = Tool::truncateUtf8String($g['name'], 10);
        $pictureModel = GoodsPicture::model()->findAll(array(
            'select' => 'path',
            'condition' => 'goods_id = :id',
            'params' => array(':id' => $g['id']),
        ));
        // 根据当前的商品查找规格值.为js生成数据准备
        $goodsSpec = GoodsSpec::getGoodsSpec($g['id']);
        $specArr = $defaultSpec = $newSpec = array();
        $defaultStock = $g['stock'];
        if (!empty($g['goods_spec_id'])) { //商品默认规格
            $specModel = GoodsSpec::model()->findByPk($g['goods_spec_id'], array('select' => 'spec_value,stock'));
            if (!empty($specModel)) {
                $defaultSpec['default'] = $specModel->spec_value;
                if (isset($specModel->stock)) {
                    $defaultStock = $specModel->stock; //默认规格库存
                }
            }
        }
        if (!empty($g['spec_name']) && !empty($g['goods_spec'])) {
            foreach ($g['spec_name'] as $k => $v){
                if (!isset($g['goods_spec'][$k])) continue;
                $specArr[$v] = $g['goods_spec'][$k];
            }
        }
        if ($goodsSpec && $defaultSpec) {
            $newSpec = array_merge($specArr, $defaultSpec);
        } else if ($specArr && empty($defaultSpec)) {
            $newSpec = $specArr;
        }
        if ($g['freight_template_id']) {
            $template = FreightTemplate::model()->findByPk($g['freight_template_id'], array('select' => 'name'));
            if (!empty($template)) {
                $express = $template->name; //物流公司名称
            }
            $typeModel = FreightType::model()->findAll(array(
                'select' => 'id',
                'condition' => 'freight_template_id = :id',
                'params' => array(':id' => $g['freight_template_id']),
            ));
            $types = array();
            if(!empty($typeModel)){
                foreach ($typeModel as $value) {
                    $types[] = $value->id;
                }
            }
            $criteria = new CDbCriteria;
            $criteria->select = 't.location_id,t.default,t.default_freight';
            $criteria->addInCondition('t.freight_type_id', $types);
            $area = FreightArea::model()->findAll($criteria);
        }
        // 记录浏览历史
        $this->_setMBrowseHistory($g['id']);
        $this->render('proMsg', array(
            'id' => $g['id'],
            'data' => $g,
            'store' => isset($store) ? $store : '',
            'newSpec' => $newSpec,
            'express' => isset($express) ? $express : '',
            'area' => isset($area) ? $area : '',
            'picture' => $pictureModel,
            'goodsSpec' => $goodsSpec,
            'defaultStock' => $defaultStock,
        ));
    }

    /**
     * 商品详细信息
     */
    public function actionDetail()
    {
        $this->pageTitle = '盖象微商城_商品信息';
        // 检查是否有该商品存在
        if (!$g = Goods::getGoodsDetail($this->getParam('id'))) {
            throw new CHttpException(404, Yii::t('goods', '没有找到相关商品！'));
        }
        if ($g['status'] != Goods::STATUS_PASS || $g['is_publish'] == Goods::PUBLISH_NO || $g['life'] == Goods::LIFE_YES) {
            throw new CHttpException(404, Yii::t('goods', '很抱歉，您查看的商品不存在，可能已下架或者被转移！'));
        }
        $this->showTitle = Tool::truncateUtf8String($g['name'], 10);
        $pictureModel = GoodsPicture::model()->findAll(array(
            'select' => 'path',
            'condition' => 'goods_id = :id',
            'params' => array(':id' => $g['id']),
        ));
        // 根据当前的商品查找规格值.为js生成数据准备
        $goodsSpec = GoodsSpec::getGoodsSpec($g['id']);
        $specArr = $defaultSpec = $newSpec = array();
        $defaultStock = $g['stock'];
        if (!empty($g['goods_spec_id'])) { //商品默认规格
            $specModel = GoodsSpec::model()->findByPk($g['goods_spec_id'], array('select' => 'spec_value,stock'));
            if (!empty($specModel)) {
                $defaultSpec['default'] = $specModel->spec_value;
                if (isset($specModel->stock)) {
                    $defaultStock = $specModel->stock; //默认规格库存
                }
            }
        }
        if (!empty($g['spec_name']) && !empty($g['goods_spec'])) {
            foreach ($g['spec_name'] as $k => $v){
                if (!isset($g['goods_spec'][$k])) continue;
                $specArr[$v] = $g['goods_spec'][$k];
            }
        }
        if ($specArr && $defaultSpec) {
            $newSpec = array_merge($specArr, $defaultSpec);
        }
        $this->render('proDetail', array(
            'id' => $g['id'],
            'data' => $g,
            'newSpec' => $newSpec,
            'picture' => $pictureModel,
            'goodsSpec' => $goodsSpec,
            'defaultStock' => $defaultStock,
        ));
    }

    /**
     * 商品评论
     */
    public function actionComment()
    {
        $this->footer = false;
        $this->cart = true;
        $this->pageTitle = '盖象微商城_商品评论';
        $id = $this->getQuery('id');
        // 检查是否有该商品存在
        if (!$g = Goods::getGoodsDetail($id)) {
            throw new CHttpException(404, Yii::t('goods', '没有找到相关商品！'));
        }
        if ($g['status'] != Goods::STATUS_PASS || $g['is_publish'] == Goods::PUBLISH_NO || $g['life'] == Goods::LIFE_YES) {
            throw new CHttpException(404, Yii::t('goods', '很抱歉，您查看的商品不存在，可能已下架或者被转移！'));
        }
        // 根据当前的商品查找规格值.为js生成数据准备
        $goodsSpec = GoodsSpec::getGoodsSpec($g['id']);
        $specArr = $defaultSpec = $newSpec = array();
        $defaultStock = $g['stock'];
        if (!empty($g['goods_spec_id'])) { //商品默认规格
            $specModel = GoodsSpec::model()->findByPk($g['goods_spec_id'], array('select' => 'spec_value,stock'));
            if (!empty($specModel)) {
                $defaultSpec['default'] = $specModel->spec_value;
                if (isset($specModel->stock)) {
                    $defaultStock = $specModel->stock; //默认规格库存
                }
            }
        }
        if (!empty($g['spec_name']) && !empty($g['goods_spec'])) {
            foreach ($g['spec_name'] as $k => $v){
                if (!isset($g['goods_spec'][$k])) continue;
                $specArr[$v] = $g['goods_spec'][$k];
            }
        }
        if ($specArr && $defaultSpec) {
            $newSpec = array_merge($specArr, $defaultSpec);
        } else if ($specArr && empty($defaultSpec)) {
            $newSpec = $specArr;
        }
        $this->showTitle = Tool::truncateUtf8String($g['name'], 10);
        $criteria = new CDbCriteria;
        $criteria->with = 'member';
        $criteria->select = 't.member_id,t.score,t.content,t.create_time';
        $criteria->condition = 't.goods_id = :id and t.status = :status';
        $criteria->params = array(':id' => $id, ':status' => Comment::STATUS_SHOW);
        $count = Comment::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 6;
        $pages->applyLimit($criteria);
        $comment = Comment::model()->findAll($criteria);
        $this->showTitle = Tool::truncateUtf8String($g['name'], 10);
        $this->render('proComment', array(
            'id' => $id,
            'data' => $g,
            'newSpec' => $newSpec,
            'goodsSpec' => $goodsSpec,
            'defaultStock' => $defaultStock,
            'comment' => $comment,
            'pages' => $pages
        ));
    }

    /**
     * 商品相册
     */
    public function actionPicture()
    {
        $this->pageTitle = '盖象微商城_商品相册';
        $id = isset($_GET['id']) ? $this->getQuery('id') : '';
        if (empty($id)) throw new CHttpException(404, Yii::t('goods', '没有找到该商品相册！'));
        $model = Goods::model()->findByPk($id, array('select' => 'name,description'));
        $this->showTitle = Tool::truncateUtf8String($model->name, 10);
        $criteria = new CDbCriteria;
        $criteria->select = 'path';
        $criteria->condition = 'goods_id = :id';
        $criteria->params = array(':id' => $id);
        $count = GoodsPicture::model()->count($criteria);
        $page = isset($_GET['page']) ? $this->getQuery('page') : '';
        if ($page < 1 || empty($page)) $page = 1;
        if ($page > $count) $page = $count;
        $picture = GoodsPicture::model()->findAll($criteria);
        $this->render('picture', array('model' => $model, 'picture' => $picture, 'count' => $count, 'currentPage' => $page));
    }

    /**
     * 商品搜索列表
     */
    public function actionSearch()
    {
        $this->pageTitle = '盖象微商城_商品搜索';
        $this->showTitle = isset($_GET['p']) ? $this->getQuery('p') : '';
        // 获取URI参数标准
        $args = $this->_uriParamsCriterion();
        $params = Tool::requestParamsDispose($args);
        $keyword = $params['p'] = $this->getQuery('p');
        $criteria = new CDbCriteria(array(
            'select' => 't.id, t.name, t.thumbnail, t.price, t.sales_volume, t.brand_id, t.category_id, t.goods_spec_id, t.return_score, t.gai_price, t.gai_income,t.gai_sell_price,t.join_activity,t.activity_tag_id,at.status AS at_status',
            'join' => 'LEFT JOIN {{activity_tag}} AS at ON t.activity_tag_id = at.id',
            'condition' => 't.status = :status And t.is_publish = :isp and t.life=:life',
            'order' => 't.create_time DESC',
            'params' => array(':status' => Goods::STATUS_PASS, ':isp' => Goods::PUBLISH_YES, ':life' => Goods::LIFE_NO),
        ));
        $criteria->addSearchCondition('t.name', $keyword);
        $criteria = $this->_criteriaDispose1($criteria, $params); // CDbCriteria 处理
        $count = Goods::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);
        $model = Goods::model()->findAll($criteria);
        //处理售价显示,如果参加红包活动，并且活动状态是有效的，则显示盖网提供的售价 binbin.liao
        foreach ($model as &$g) {
            //如果参加红包活动,并且活动的是开启的.显示盖网的销售价,否则显示原来的售价
            if ($g->join_activity == Goods::JOIN_ACTIVITY_YES && !empty($g->activity_tag_id) && $g->at_status == ActivityTag::STATUS_ON) {
                $g->price = $g->gai_sell_price;
            }
        }
        $this->render('search', array('model' => $model, 'pages' => $pages, 'params' => $params));
    }

    /**
     * 商品分享
     */
    public function actionShare()
    {
        $this->render('share');
    }

    /**
     * 商品添加到购物车处理
     */
    public function actionCart()
    {
        if ($this->isAjax()) {
            if (empty(Yii::app()->user->id)) {
                $message = '请先登录';
            } else {
                $goodsId = $this->getParam('goods_id'); //商品id
                $specId = $this->getPost('spec_id'); //商品属性id
                $number = $this->getParam('number'); //商品数量
                $memberId = Yii::app()->user->id; //用户id
                $model = Cart::model()->find(array(
                    'select' => 'id',
                    'condition' => 'member_id = :m_id and goods_id = :id and spec_id = :sid',
                    'params' => array(':m_id' => $memberId, ':id' => $goodsId, ':sid' => $specId),
                ));
                if (!empty($model)) {
                    //$message = '该商品已经在您的购物车中';
                    $message=Cart::model()->updateCounters(array('quantity'=>$number),'member_id = :m_id and goods_id = :id and spec_id = :sid',array(':m_id' => $memberId, ':id' => $goodsId, ':sid' => $specId));
                } else {
                    $data = Goods::getCartGoodsDetail($goodsId);
                    $cart = new Cart;
                    $cart->member_id = $memberId;
                    $cart->store_id = $data['store_id'];
                    $cart->goods_id = $goodsId;
                    $cart->spec_id = $specId;
                    $cart->price = !empty($data['price']) ? $data['price'] : 0.00;
                    $cart->quantity = $number;
                    $cart->create_time = time();
                    if ($cart->save()) {
                        $message = '商品成功加入购物车';
                    } else {
                        $message = '商品添加到购物车失败';
                    }
                }
            }
            echo $message;
        }
    }

    /**
     * 商品快捷购买，订单包含一个商品
     */
    public function actionBuy()
    {
        if ($this->isAjax()) {
            if (empty(Yii::app()->user->id)) {
                $message = '请先登录';
            } else {
                if (empty($_POST['spec'])) {
                    $goodsId = $this->getParam('goods_id'); //商品id
                    $exist = Goods::model()->findByPk($goodsId, array('select' => 'goods_spec'))->goods_spec; //检查一下该商品是否存在商品属性
                    if (!empty($exist)) {
                        $message = '请先选择商品属性';
                        $id = isset($orderId) ? $orderId : '';
                        $arr = compact('message', 'id');
                        echo CJSON::encode($arr);
                        exit;
                    }
                }
                $spec = $this->getParam('spec'); //商品属性值
                $specArr = explode('|', $spec);
                array_pop($specArr);
                $goods_id = $this->getParam('goods_id'); //商品id
                $number = $this->getParam('number'); //商品数量
                $member_id = Yii::app()->user->id; //用户id
                $position = Tool::getPosition(); //用户位置
                $city_id = $position['city_id']; //用户所在城市

                $data = Goods::getGoodsDetail($goods_id);
                if ($data['freight_payment_type'] === Goods::FREIGHT_TYPE_MODE && !empty($data['freight_template_id'])) {
                    $express = FreightTemplate::model()->findByPk($data['freight_template_id'], array('select' => 'name'))->name;
                    $fee = ComputeFreight::compute($data['freight_template_id'], $data['size'], $data['weight'], $city_id, $data['valuation_type'], $number);
                    foreach ($fee as &$v) {
                        $v['fee'] = Common::rateConvert($v['fee']);
                    }
                }

                $addressInfo = Address::model()->find(array(
                    'select' => 't.real_name,mobile,t.province_id,t.city_id,t.district_id,t.street,zip_code',
                    'condition' => 't.member_id = :id and t.default = :default',
                    'params' => array(':id' => $member_id, ':default' => Address::DEFAULT_YES)
                ));
                $freight = 0;
                if (empty($addressInfo)) {
                    $address = $consignee = $mobile = $zipCode = '';
                    $position = Tool::getPosition();
                    $fee = ComputeFreight::compute($data['freight_template_id'], $data['size'], $data['weight'], $position['city_id'], $data['valuation_type'], $number);
                } else {
                    $provinceName = Tool::getAreaName($addressInfo->province_id);
                    $cityName = Tool::getAreaName($addressInfo->city_id);
                    $districtName = Tool::getAreaName($addressInfo->district_id);
                    $streetName = $addressInfo->street;
                    $address = implode(' ', array($provinceName, $cityName, $districtName, $streetName));
                    $consignee = $addressInfo->real_name;
                    $mobile = $addressInfo->mobile;
                    $zipCode = $addressInfo->zip_code;
                    $fee = ComputeFreight::compute($data['freight_template_id'], $data['size'], $data['weight'], $addressInfo->city_id, $data['valuation_type'], $number);
                }
                if (!empty($fee)) {
                    foreach ($fee as $f) {
                        $freight = $f['fee'];
                    }
                }
                //计算用户可用红包金额
                $redAccount = RedEnvelopeTool::getRedAccount($this->getUser()->id); //获取会员红包金额
                $ratio = bcdiv($data['activity_ratio'], 100, 5); //活动支持比率
                $useRed = bcmul(bcmul($data['gai_sell_price'], $number, 2), $ratio, 2); //该订单可用红包金额
                $usedRedMoney = 0;
                if ($redAccount > 0) {
                    if ($useRed >= $redAccount) {
                        $usedRedMoney = $redAccount;
                    } else {
                        $usedRedMoney = $useRed;
                    }
                }
                $allPrice = bcadd(bcmul($data['price'], $number, 2), $freight, 2);
                $payPrice = bcsub($allPrice, $usedRedMoney, 2); //总价格减去可用的红包金额
                $originalPrice = bcadd(bcmul($data['price'], $number, 2), $freight, 2);
                $returnScore = Common::convertReturn($data['gai_price'], $data['price'], $data['gai_income'] / 100) * $number;
                $sourceType = (!empty($usedRedMoney)) ? Order::SOURCE_TYPE_HB : (ShopCart::checkSourceType($goods_id));
                //组装订单数据
                $orderData = array(
                    'code' => Tool::buildOrderNo(),
                    'member_id' => $member_id,
                    'consignee' => $consignee,
                    'address' => $address,
                    'mobile' => $mobile,
                    'zip_code' => $zipCode,
                    'status' => Order::STATUS_NEW,
                    'delivery_status' => Order::DELIVERY_STATUS_NOT,
                    'pay_status' => Order::PAY_STATUS_NO,
                    'pay_price' => $payPrice, //会员支付订单金额 加上运费 如果是红包订单减去红包金额
                    'real_price' => $allPrice, //实际订单金额 加上运费
                    'original_price' => $originalPrice, //原始订单金额,加上运费的
                    'return' => $returnScore, //返还积分
                    'create_time' => time(),
                    'auto_sign_date' => Tool::getConfig('site', 'automaticallySignTimeOrders'), //自动签收天数,
                    'delay_sign_count' => Tool::getConfig('site', 'extendMaximumNum'), //会员延迟签收次数,
                    'store_id' => $data['store_id'],
                    'order_type' => Order::ORDER_TYPE_JF,
                    'distribution_ratio' => CJSON::encode(Order::getOldIssueRatio()),
                    'source' => Order::ORDER_SOURCE_WAP, //订单类型
                    'freight' => $freight,
                    'freight_payment_type' => $data['freight_payment_type'],
                    'express' => isset($express) ? $express : '', //快递
                    'source_type' => $sourceType, //订单类型（1、【普通商品及专题商品】2、【大额商品（积分加现金）】3、【合约机商品】4、【红包订单】）
                    'other_price' => (!empty($usedRedMoney)) ? $usedRedMoney : 0, //使用红包金额
                );

                if (!empty($data['spec_name']) && !empty($specArr)) {
                    $specName = array();
                    foreach ($data['spec_name'] as $key => $value) {
                        $specName[$key] = $value;
                    }
                    $spec = serialize(array_combine($specName, $specArr));
                }

                $specModel = GoodsSpec::model()->findAll(array(
                    'select' => 'id,spec_value',
                    'condition' => 'goods_id = :id',
                    'params' => array(':id' => $goods_id),
                ));
                if (!empty($specModel)) {
                    foreach ($specModel as $value) {
                        if ($value->spec_value) {
                            if (!array_diff($specArr, $value->spec_value)) {
                                $specId = $value->id;
                            }
                        }
                    }
                }
                $transaction = Yii::app()->db->beginTransaction();
                $result = false;
                try {
                    //减少库存
                    $res1 = Goods::model()->updateCounters(array('stock' => -$number), 'id = :id and stock > 0', array(':id' => $goods_id));
                    $sid = isset($specId) ? $specId : $data['goods_spec_id'];
                    $sModel = GoodsSpec::model()->find(array(
                        'select' => 'spec_value',
                        'condition' => 'goods_id = :g_id and id = :id',
                        'params' => array(':id' => $sid, ':g_id' => $goods_id),
                    ));
                    if (!empty($sModel)) {
                        $res2 = GoodsSpec::model()->updateCounters(array('stock' => -$number), 'id = :id and stock > 0', array(':id' => $sid));
                    }
                    if (isset($res2) && !$res2) throw new Exception(Yii::t('goods', '减属性商品库存失败!'));
                    if (!$res1) throw new Exception(Yii::t('goods', '减商品库存失败，请重新确认或下单!'));

                    //创建订单
                    Yii::app()->db->createCommand()->insert('{{order}}', $orderData);
                    //插入订单商品信息表
                    $orderId = Yii::app()->db->lastInsertID;
                    if (!$orderId) throw new Exception(Yii::t('order', '创建订单失败'));
                    //组装订单商品数据
                    $goodsData = array(
                        'goods_id' => $goods_id,
                        'order_id' => $orderId,
                        'quantity' => $number,
                        'unit_score' => Common::convert($data['price']),
                        'total_score' => Common::convert($data['price']),
                        'gai_price' => $data['gai_price'],
                        'unit_price' => $data['price'],
                        'total_price' => bcmul($data['price'], $number, 2),
                        'original_price' => bcadd(bcmul($data['price'], $number, 2), $freight, 2),
                        'gai_income' => $data['gai_income'],
                        'spec_value' => isset($spec) ? $spec : '',
                        'spec_id' => isset($specId) ? $specId : $data['goods_spec_id'],
                        'goods_name' => $data['name'],
                        'goods_picture' => $data['thumbnail'],
                        'freight' => $freight,
                        'freight_payment_type' => $data['freight_payment_type'],
                    );
                    Yii::app()->db->createCommand()->insert('{{order_goods}}', $goodsData);
                    $goodsOrderId = Yii::app()->db->lastInsertID;
                    if (!$goodsOrderId) throw new Exception(Yii::t('order', '生成商品订单数据失败'));

                    $transaction->commit();
                    $result = true;
                } catch (Exception $e) {
                    $transaction->rollback();
                    $msg = $e->getMessage();
                }
                if ($result === false && !empty($msg)) {
                    $message = '抱歉，您提交订单不成功，请重新下单'; //提示用户重新下单
                } else {
                    $message = '您已经成功提交订单，请确认订单';
                }
            }
            $id = isset($orderId) ? $orderId : '';
            $arr = compact('message', 'id');
            echo CJSON::encode($arr);
        }
    }

    /**
     * 记录商品浏览历史cookie
     */
    private
    function _setMBrowseHistory($id)
    {
        $history = $this->getCookie('history');
        if (empty($history))
            $this->setCookie('history', $id, 3600 * 24 * 365);
        else {
            $array = explode(',', $history);
            if (!in_array($id, $array)) {
                if (count($array) >= 3) //微商城只取3条商品浏览历史
                    unset($array[0]);
                array_push($array, $id);
                $this->setCookie('history', implode(',', array_filter($array)), 3600 * 24 * 365);
            }
        }
    }

    /**
     * ajax 计算运费
     */
    public
    function actionComputeFreight()
    {
        if ($this->isAjax()) {
            $city_id = $this->getPost('city_id');
            $province_id = $this->getPost('province_id');
            $city_name = $this->getPost('city_name');
            $province_name = $this->getPost('province_name');
            $quantity = $this->getPost('quantity');
            $goods_id = $this->getPost('goods_id');
            //设置访客位置cookie
            $position = array(
                'city_id' => $city_id,
                'city_name' => $city_name,
                'province_id' => $province_id,
                'province_name' => $province_name,
            );
            $cookie = new CHttpCookie('position', $position);
            $cookie->expire = time() + 3600 * 24 * 360;
            Yii::app()->request->cookies['position'] = $cookie;
            $goods = Goods::getGoodsDetail($goods_id);
            //计算运费
            $fee = ComputeFreight::compute($goods['freight_template_id'], $goods['size'], $goods['weight'], $city_id, $goods['valuation_type'], $quantity);
            foreach ($fee as &$v) {
                $v['fee'] = Common::rateConvert($v['fee']);
            }
            echo CJSON::encode($fee);
        }
    }

    /**
     * ajax 显示不同属性的商品库存
     */
    public
    function actionStock()
    {
        if ($this->isAjax()) {
            $goodsId = $this->getParam('goods_id');
            $spec = $this->getParam('spec'); //商品属性值
            $specArr = explode('|', $spec);
            array_pop($specArr);
            $specModel = GoodsSpec::model()->findAll(array(
                'select' => 'id,spec_value',
                'condition' => 'goods_id = :id',
                'params' => array(':id' => $goodsId),
            ));
            $specId = 0;
            if (!empty($specModel)) {
                foreach ($specModel as $value) {
                    if ($value->spec_value) {
                        if (!array_diff($specArr, $value->spec_value)) {
                            $specId = $value->id;
                        }
                    }
                }
            }
            $stock = GoodsSpec::model()->findByPk($specId, array('select' => 'stock'))->stock;
            echo $stock;
        }
    }

    /**
     * ajax获取省份数据，用于商品信息页面选择运费模板
     * @author xiaoyan.luo
     */
    public
    function actionProvinces()
    {
        if ($this->isAjax()) {
            $model = Region::model()->findAll(array(
                'select' => 'id,name',
                'condition' => 'parent_id = :id',
                'params' => array(':id' => Region::PROVINCE_PARENT_ID),
            ));
            $arr = array();
            foreach ($model as $value) {
                $arr[$value->id] = $value->name;
            }
            echo CJSON::encode($arr);
        }
    }

    /**
     * ajax获取市数据，用于商品信息页面选择运费模板
     * @author xiaoyan.luo
     */
    public
    function actionCities()
    {
        if ($this->isAjax()) {
            $provinceId = $this->getPost('province');
            $model = Region::model()->findAll(array(
                'select' => 'id,name',
                'condition' => 'parent_id = :id',
                'params' => array(':id' => $provinceId),
            ));
            $arr = array();
            foreach ($model as $value) {
                $arr[$value->id] = $value->name;
            }
            echo CJSON::encode($arr);
        }
    }

    public
    function actionUpdateData()
    {
        if ($this->isAjax()) {
            $orderId = $this->getPost('order_id');
            $freight = $this->getPost('freight');
            $PayPrice = $this->getPost('total_price');
            $goodsPrice = $this->getPost('goods_price');
            $totalPrice = bcadd($goodsPrice, $freight, 2);
            Order::model()->updateAll(array(
                    'freight' => $freight, 'pay_price' => $PayPrice, 'real_price' => $totalPrice, 'total_price' => $totalPrice, 'original_price' => $totalPrice),
                'id = :id', array(':id' => $orderId));
            OrderGoods::model()->updateAll(array('freight' => $freight, 'original_price' => bcadd($goodsPrice, $freight, 2)), 'id = :id', array(':id' => $orderId));
            $arr = array();
            $arr['order_id'] = $orderId;
            echo CJSON::encode($arr);
        }
    }

    /**
     * 定义搜索商品URI参数标准
     * @return array    返回规范参数
     */
    public
    function _uriParamsCriterion()
    {
        return array(
            'order' => array(
                'sales_volume' => array(
                    'text' => Yii::t('category', '销量'),
                    'defaultValue' => 1,
                    1 => 'sales_volume DESC'
                ),
                'price' => array(
                    'defaultValue' => 3,
                    'text' => Yii::t('category', '价格'),
                    2 => 'price ASC',
                    3 => 'price DESC'
                ),
                'comments' => array(
                    'defaultValue' => 4,
                    'text' => Yii::t('category', '评论'),
                    4 => 'comments DESC'
                ),
            ),
        );
    }

    /**
     * CDbCriteria 处理
     * @param object $criteria
     * @param array $params
     * @return object CDbCriteria      CDbCriteria Object
     */
    private
    function _criteriaDispose1($criteria, $params)
    {
        if (!is_array($params) && empty($params))
            return $criteria;
        extract($params);

        $sort = Tool::findSortValue($this->_uriParamsCriterion1(), $order);
        if (!empty($sort))
            $criteria->order = $sort;
        return $criteria;
    }

    /**
     * 定义URI参数标准
     * @return array    返回规范参数
     */
    protected
    function _uriParamsCriterion1()
    {
        return array(
            'order' => array(
                'sales_volume' => array(
                    'text' => Yii::t('category', '销量'),
                    'defaultValue' => 1,
                    1 => 'sales_volume DESC'
                ),
                'price' => array(
                    'defaultValue' => 3,
                    'text' => Yii::t('category', '价格'),
                    2 => 'price ASC',
                    3 => 'price DESC'
                ),
                'comments' => array(
                    'defaultValue' => 4,
                    'text' => Yii::t('category', '评论'),
                    4 => 'comments DESC'
                ),
            ),
        );
    }
}
