<?php

/**
 * 合约机预约活动页面
 * @author binbin.liao <277250538@qq.com>
 */
class HeyuejiController extends Controller
{

    public $defaultAction = '4g';
    // 合约机类型
    public $type;
    // 配置中的合约机列表
    public $heyueList = array();
    // 合约机商品
    public $goods;
    // 会员id
    public $uid;
    // 会员默认收货地址
    public $address;
    //运费
    public $freight;

    // action执行前
    public function beforeAction($action)
    {
//        die('合约机接口升级中,暂停使用');
        $actionId = $action->id;
        if ($actionId != '3g' && $actionId != '4g') {
            $url = Yii::app()->request->hostInfo . Yii::app()->request->url;
            $this->uid = $this->getUser()->id;
            if (!$this->getUser()->id) {
                $this->getUser()->setReturnUrl(str_replace('createOrder', 'xuanhao', $url));
                $this->redirect(array('/member/home/login'));
            }
            // 取出配置的合约机列表
            $this->heyueList = array('3g' => Heyue::get3G(), '4g' => Heyue::get4G());
            if (!$this->address = Address::getDefault($this->uid)) {
                $this->getUser()->setReturnUrl($url);
                $this->setFlash('error', Yii::t('member', '请先设置默认收货地址'));
                $this->redirect(array('/member/address'));
            }
            return parent::beforeAction($action);
        }
        return parent::beforeAction($action);
    }

    /**
     * 4g合约机专题页面
     * @author binbin.liao <277250538@qq.com>
     */
    public function action4g()
    {
        $this->pageTitle = '超值天翼4G套餐--合约机' . $this->pageTitle;
        $this->render("4g");
    }

    /**
     * 3g合约机专题页面
     * @author binbin.liao <277250538@qq.com>
     */
    public function action3g()
    {
        die('取消3G合约机');
        $this->pageTitle = '电信合约机_' . $this->pageTitle;
        $this->render("3g");
    }

    /**
     * 选择号码
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    public function actionXuanhao($id, $spec_id)
    {
        $this->pageTitle = Yii::t('heyue', '选择号码和套餐_') . $this->pageTitle;
        // 验证合约机
        $this->_checkHeyue($id);
        $cartInfo = Cart::getCartInfo(array($id . '-' . $spec_id));
        if (empty($cartInfo['cartInfo'])) $this->redirect(array('/heyueji'));
        // 合约机号码列表
        $model = new Heyue('searchList');
        $model->unsetAttributes();
        $model->number_type = $this->type;
        if (isset($_GET['Heyue']))
            $model->attributes = $this->getParam('Heyue');
        $heyue = $model->searchList();
        $phones = $heyue->getData();
        $pages = $heyue->getPagination();
        $pages->itemCount = $heyue->getTotalItemCount();
        if ($this->isAjax()) {
            $this->renderPartial('_number', array('phones' => $phones, 'pages' => $pages));
            Yii::app()->end();
        }

        $heyueji = new HeyuejiForm;
        $taocan = $this->_getTaocan($id);
        $freight = $this->_calFreight($id, $this->address['city_id']);
        $this->freight = ($freight) ? $freight[1]['fee'] : 0;
        $this->render('xuanhao', array(
            'cartInfo' => $cartInfo,
            'phones' => $phones,
            'pages' => $pages,
            'model' => $model,
            'heyueji' => $heyueji,
            'taocan' => $taocan,
        ));
    }

    /**
     * ajax提交选择套餐
     * @author binbin.liao
     */
    public function actionShowTaocan()
    {
        if ($this->isAjax()) {
            $key = $this->getParam('key');
            $id = $this->getParam('id');
            $this->_checkHeyue($id);
            $arr = $this->_getTaocan($id);
            echo CJSON::encode($arr[$key]);
        }
    }

    /**
     * ajax选择号码,更新选择号码时间
     * @author binbin.liao
     */
    public function actionShowNumber($id)
    {
        if ($this->isAjax()) {
            $model = Heyue::model()->find(array(
                'select' => 'number,hasfee,price,member_id',
                'condition' => 'id=:id',
                'params' => array(':id' => $id),
            ));
            if ($model->member_id && $model->member_id != $this->uid)
                $msg['error'] = '号码已经被占用,请选择其它号码';
            else {
                $msg['success'] = true;
                $msg['number'] = $model->number;
                $msg['hasFee'] = $model->hasfee;
                $msg['price'] = $model->price;
                //更新选择号码时间
                Heyue::model()->updateAll(
                    array('create_time' => 0, 'member_id' => 0), 'member_id=:member_id AND is_lock=:is_lock', array(
                    ':member_id' => $this->uid, ':is_lock' => Heyue::NOT_LOCK
                ));
                Heyue::model()->updateByPk($id, array('create_time' => time(), 'member_id' => $this->uid));
            }
            echo CJSON::encode($msg);
        }
    }

    /**
     * 创建订单
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    public function actionCreateOrder($id, $spec_id)
    {
        // 验证合约机
        $this->_checkHeyue($id);
        $cartInfo = Cart::getCartInfo(array($id . '-' . $spec_id));
        if (empty($cartInfo['cartInfo'])) throw new CHttpException(404);

        // 验证合约机表单信息
        $model = new HeyuejiForm;
        $this->performAjaxValidation($model);
        if (isset($_POST['HeyuejiForm'])) {
            $model->attributes = $this->getPost('HeyuejiForm');
            if ($model->validate()) {
                // 创建订单并录入信息到合约机号码表
                $orderFlow = new OrderFlow();
                $goodsIds = $orderFlow->checkCart($cartInfo['cartInfo']);
                $transaction = Yii::app()->db->beginTransaction();
                $taocan = $this->_getTaocan($id);
                //添加选中的号码到订单表
                $key = key($cartInfo['cartInfo']);
                $cartInfo['cartInfo'][$key]['extend'] = $this->_getNumber($model->phone);
                //组合运费数据
                $freight = $this->_calFreight($id, $this->address['city_id']);
                $freight_array = $this->_createFreightInfo($id, $spec_id, $freight);
                //上传身份证图片
                $saveDir = 'ID/' . date('Y/n/j');
                $model = UploadedFile::uploadFile($model, 'idPicture1', $saveDir, Yii::getPathOfAlias('att'));
                UploadedFile::uploadFile($model, 'idPicture2', $saveDir, Yii::getPathOfAlias('att'));
                UploadedFile::uploadFile($model, 'idPicture3', $saveDir, Yii::getPathOfAlias('att'));
                try {
                    //创建订单
                    $info = array('freight_array' => $freight_array['freightArr'], 'freight' => $freight_array['freight'], 'message' => $this->getPost('message'));
                    $orderCode = $orderFlow->createOrder($cartInfo, $this->address, $info, false);
                    $array = array(
                        'member_id' => $this->uid,
                        'order_id' => implode(',', array_keys($orderCode)),
                        'name' => $model->username,
                        'cardNumber' => $model->identityCard,
                        'is_lock' => Heyue::LOCK,
                        'type' => ($this->type == Heyue::NUMBER_3G ? '元乐享3G套餐' : '新4G乐享套餐') . $taocan[$model->taocan]['fee'] . '套餐',
                        'idPicture1' => $model->idPicture1,
                        'idPicture2' => $model->idPicture2,
                        'idPicture3' => $model->idPicture3
                    );
                    //保存图片
                    UploadedFile::saveFile('idPicture1', $model->idPicture1);
                    UploadedFile::saveFile('idPicture2', $model->idPicture2);
                    UploadedFile::saveFile('idPicture3', $model->idPicture3);
                    if (!Yii::app()->db->createCommand()->update('{{heyue}}', $array, 'id=:id', array(':id' => $model->phone)))
                        throw new Exception('合约机号码表信息更新错误');
                    //减少库存
                    $orderFlow->subStock($goodsIds);
                    $transaction->commit();
                    Cart::delCart($this->getUser()->id, array($id . '-' . $spec_id)); //提交订单成功后删除购物车里的数据
                    $this->redirect(array('/order/pay', 'code' => implode(',', $orderCode)));
                } catch (Exception $e) {
                    $transaction->rollBack();
                    $this->setFlash('warning', '生成订单失败，请重新选择套餐及号码');
                }
            } else {
                $str = $this->getErr($model->getErrors());
                $this->setFlash('warning', $str);
                $this->redirect(array('/heyueji/xuanhao', 'id' => $id, 'spec_id' => $spec_id));
            }
        }
        $this->redirect(array('/heyueji/xuanhao', 'id' => $id, 'spec_id' => $spec_id));
    }

    /**
     * 显示入网协议
     * @author binbin.liao
     */
    public function actionShowProtocol()
    {
        $this->renderPartial('_showprotocol');
    }

    /**
     * 获取指定的合约机商品
     * 验证是否合约机商品
     * @param int $id 商品主键
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    private function _checkHeyue($id)
    {
        $array = $this->heyueList;
        if (in_array($id, $array['3g']))
            $this->type = Heyue::NUMBER_3G;
        elseif (in_array($id, $array['4g']))
            $this->type = Heyue::NUMBER_4G;
        else
            throw new CHttpException(404, '请求的页面不存在.');
    }

    /**
     * 获取套餐
     * @param $id 商品id
     * @return array
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    private function _getTaocan($id = null)
    {
        if ($this->type == Heyue::NUMBER_4G) {
            /* 这是号码卡套餐 */
            if ($id == 58198) {
                return array(
                    array('fee' => 59, 'give' => '1500元', 'real_pay' => '31元', 'retCallRules' => Yii::t('Heyue', '实际消费金额的30%'), 'duration' => 100, 'msgNum' => '无', 'flow' => '500MB'),
                );
            }
            if ($id == 58199) {
                return array(
                    array('fee' => 79, 'give' => '1500元', 'real_pay' => '35元', 'retCallRules' => Yii::t('Heyue', '实际消费金额的30%'), 'duration' => 200, 'msgNum' => '无', 'flow' => '700MB'),
                );
            }
            if ($id == 58200) {
                return array(
                    array('fee' => 99, 'give' => '3000元', 'real_pay' => '49元', 'retCallRules' => Yii::t('Heyue', '实际消费金额的30%'), 'duration' => 300, 'msgNum' => '无', 'flow' => '1GB'),
                );
            }
            return array(
                array('fee' => 59, 'give' => '1500元', 'real_pay' => '31元', 'retCallRules' => Yii::t('Heyue', '实际消费金额的30%'), 'duration' => 100, 'msgNum' => '无', 'flow' => '500MB'),
                array('fee' => 79, 'give' => '1500元', 'real_pay' => '35元', 'retCallRules' => Yii::t('Heyue', '实际消费金额的30%'), 'duration' => 200, 'msgNum' => '无', 'flow' => '700MB'),
                array('fee' => 99, 'give' => '3000元', 'real_pay' => '49元', 'retCallRules' => Yii::t('Heyue', '实际消费金额的30%'), 'duration' => 300, 'msgNum' => '无', 'flow' => '1GB'),
                array('fee' => 129, 'give' => '5000元', 'real_pay' => '70元', 'retCallRules' => Yii::t('Heyue', '实际消费金额的30%'), 'duration' => 500, 'msgNum' => '无', 'flow' => '1GB'),
                array('fee' => 169, 'give' => '5000元', 'real_pay' => '98元', 'retCallRules' => Yii::t('Heyue', '实际消费金额的30%'), 'duration' => 700, 'msgNum' => '无', 'flow' => '2GB'),
                array('fee' => 199, 'give' => '5000元', 'real_pay' => '119元', 'retCallRules' => Yii::t('Heyue', '实际消费金额的30%'), 'duration' => 700, 'msgNum' => '无', 'flow' => '3GB'),
                array('fee' => 299, 'give' => '5000元', 'real_pay' => '189元', 'retCallRules' => Yii::t('Heyue', '实际消费金额的30%'), 'duration' => 1500, 'msgNum' => '无', 'flow' => '4GB'),
                array('fee' => 399, 'give' => '5000元', 'real_pay' => '259元', 'retCallRules' => Yii::t('Heyue', '实际消费金额的30%'), 'duration' => 2000, 'msgNum' => '无', 'flow' => '6GB'),
                array('fee' => 599, 'give' => '5000元', 'real_pay' => '399元', 'retCallRules' => Yii::t('Heyue', '实际消费金额的30%'), 'duration' => 3000, 'msgNum' => '无', 'flow' => '11GB'),
            );
        }

        if ($this->type == Heyue::NUMBER_3G)
            return array(
                array('fee' => 99, 'give' => '630元', 'retCallRules' => Yii::t('Heyue', '开通次月始起前23个月每月返还25元话费，第24个月返还55元话费，实际每月缴费74元！'), 'duration' => 240, 'msgNum' => '30', 'flow' => '2.3G'),
                array('fee' => 139, 'give' => '930元', 'retCallRules' => Yii::t('Heyue', '开通次月始起前23个月每月返还37元话费，第24个月返还79元话费，实际每月缴费102元！'), 'duration' => 330, 'msgNum' => '60', 'flow' => '2.7G'),
                array('fee' => 169, 'give' => '1130元', 'retCallRules' => Yii::t('heyue', '开通次月始起前23个月每月返还45元话费，第24个月返还95元话费，实际每月缴费124元！'), 'duration' => 450, 'msgNum' => '60', 'flow' => '3G'),
                array('fee' => 199, 'give' => '1330元', 'retCallRules' => Yii::t('heyue', '开通次月始起前23个月每月返还52元话费，第24个月返还134元话费，实际每月缴费147元！'), 'duration' => 600, 'msgNum' => '60', 'flow' => '3.5G'),
                array('fee' => 239, 'give' => '1630元', 'retCallRules' => Yii::t('heyue', '开通次月始起前23个月每月返还63元话费，第24个月返还181元话费，实际每月缴费176元！'), 'duration' => 800, 'msgNum' => '60', 'flow' => '3.9G'),
                array('fee' => 299, 'give' => '2100元', 'retCallRules' => Yii::t('heyue', '开通次月始起前23个月每月返还83元话费，第24个月返还191元话费，实际每月缴费216元！'), 'duration' => 990, 'msgNum' => '180', 'flow' => '4.5G'),
                array('fee' => 399, 'give' => '2800元', 'retCallRules' => Yii::t('heyue', '开通次月始起前23个月每月返还110元话费，第24个月返还270元话费，实际每月缴费289元！'), 'duration' => 1290, 'msgNum' => '180', 'flow' => '5.5G'),
            );
    }

    /**
     * 获取号码
     * @param type $id
     * @return type
     */
    private function _getNumber($id)
    {
        $model = Heyue::model()->find(array(
            'select' => 'number',
            'condition' => 'id =:id',
            'params' => array(':id' => $id),
        ));
        return $model->number;
    }

    /**
     *计算合约机的运费
     * @author binbin.liao
     * @param $id
     * @param $city_id
     * @return mixed
     */
    private function _calFreight($id, $city_id)
    {
        //商品信息
        $goods = Goods::getGoodsDetail($id);
        if ($goods['freight_payment_type'] == Goods::FREIGHT_TYPE_MODE) {
            //计算运费
            $fee = ComputeFreight::compute($goods['freight_template_id'], $goods['size'], $goods['weight'], $city_id, $goods['valuation_type'], 1);
        } else {
            $fee = 0;
        }
        return $fee;
    }

    private function _createFreightInfo($id, $spec_id, $freight)
    {
        $freightArr['freightArr'] = array();
        $freightArr['freight'] = array();
        if ($freight) {
            foreach ($freight as $k2 => $v2) {
                $fid = $id . '-' . $spec_id;
                $freightArr['freightArr'][$fid][$k2 . '|' . $v2['fee'] . '|' . Common::rateConvert($v2['fee'])] = $v2['name'];
                $freightArr['freight'][$fid] = $k2 . '|' . $v2['fee'] . '|' . Common::rateConvert($v2['fee']);
            }
        }
        return $freightArr;
    }

    public function getErr($errs)
    {
        $str = "请解决以下问题<br/>";
        foreach ($errs as $v) {
            $str .= $v[0] . '<br/>';
        }
        return $str;
    }
}
