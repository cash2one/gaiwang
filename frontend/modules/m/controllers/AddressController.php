<?php

/**
 * 会员收货地址控制器
 * 操作 (添加,修改,删除)
 * @author wyee <yanjie@gatewang.com>
 */
class AddressController extends WController
{

    /**
     * 地址列表
     */
    public function actionIndex()
    {
        $this->layout = false;
        $this->showTitle = '收货地址';
        $orderId = isset($_GET['orderId']) ? $this->getQuery('orderId') : '';
        $cart = isset($_GET['cart']) ? $this->getQuery('cart') : '';
        $model = new Address;
        $this->performAjaxValidation($model);
        $criteria = new CDbCriteria(array(
            'condition' => 't.member_id =' . $this->uid,
            'order' => '`default` DESC'
        ));
        $this->render('index', array(
            'model' => $model,
            'address' => Address::model()->findAll($criteria),
            'orderId' => $orderId,
            'cart' => $cart,
        ));
    }

    /**
     * 新增地址
     */
    public function actionCreate()
    {
        $cart = isset($_GET['cart']) ? $this->getQuery('cart') : '';
        $this->showTitle = Yii::t('address', '添加收货地址');
        $this->pageTitle = $this->pageTitle . '_' . $this->showTitle;
        $goods = isset($_GET['goods']) ? $this->getQuery('goods') : '';
        $quantity = isset($_GET['quantity']) ? $this->getQuery('quantity') : '';
        $model = new Address;
        $this->performAjaxValidation($model);
        if (isset($_POST['Address'])) {
            $model->attributes = $this->magicQuotes($_POST['Address']);
            if ($model->default == Address::DEFAULT_YES)
                $model->updateAll(array('default' => Address::DEFAULT_NO), 'member_id = :mid AND `default` = ' . Address::DEFAULT_YES, array('mid' => $this->uid));
            if ($model->save()) {
                Yii::app()->user->setFlash('message', Yii::t('memberAddress', '添加收货地址成功！'));
                if(!empty($cart)){
                    $this->redirect(array('cart/confirm','cart'=>"1"));//跳转到确认订单页面
                }else if(!empty($goods) && !empty($quantity)){
                    $addressInfo = Address::model()->find(array(
                        'select' => 'real_name,mobile,province_id,city_id,district_id,street,zip_code',
                        'condition' => 'member_id = :m_id and id = :id',
                        'params' => array(':m_id' => $this->getUser()->id, ':id' => $model->id),
                    ));
                    $this->setSession('select_address', array('id' => $model->id, 'city_id' => $addressInfo->city_id));
                    $this->redirect(array('orderConfirm/index','goods' => $goods,'quantity' => $quantity));
                }else{
                    $this->redirect(array('index'));
                }
            } else {
                Yii::app()->user->setFlash('message', Yii::t('memberAddress', '添加收货地址失败！'));
            }
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     *三级联动 更新城市
     */
    public function actionUpdateCity()
    {
        if ($this->isPost()) {
            $province_id = isset($_POST['province_id']) ? (int)$_POST['province_id'] : "9999999";
            if ($province_id) {
                $data = Region::model()->findAll('parent_id=:pid', array(':pid' => $province_id));
                $data = CHtml::listData($data, 'id', 'name');
            }
            $dropDownCities = "<option value=''>" . Yii::t('memberRegion', '选择城市') . "</option>";
            if (isset($data)) {
                foreach ($data as $value => $name)
                    $dropDownCities .= CHtml::tag('option', array('value' => $value), CHtml::encode(Yii::t('region', $name)), true);
            }
            $dropDownCounties = "<option value='null'>" . Yii::t('memberRegion', '选择区/县') . "</option>";
            echo CJSON::encode(array(
                'dropDownCities' => $dropDownCities,
                'dropDownCounties' => $dropDownCounties
            ));
        }
    }

    /**
     *三级联动 更新地区
     */
    public function actionUpdateArea()
    {
        if ($this->isPost()) {
            $city_id = isset($_POST['city_id']) ? (int)$_POST['city_id'] : "9999999";
            if ($city_id) {
                $data = Region::model()->findAll('parent_id=:pid', array(':pid' => $city_id));
                $data = CHtml::listData($data, 'id', 'name');
            }
            echo "<option value=''>" . Yii::t('memberRegion', '选择区/县') . "</option>";
            if ($city_id) {
                foreach ($data as $value => $name)
                    echo CHtml::tag('option', array('value' => $value), CHtml::encode(Yii::t('region', $name)), true);
            }
        }
    }

    /**
     * ajax检查用户是否已经添加收货地址
     * @author xiaoyan.luo
     */
    public function actionCheck()
    {
        if ($this->isAjax()) {
            $address = Address::model()->find(array(
                'select' => 'id',
                'condition' => 'member_id = :id',
                'params' => array(':id' => $this->uid),
            ));
            if (empty($address->id)) {
                echo CJSON::encode('没有收货地址');
            } else {
                echo CJSON::encode($address->id);
            }

        }
    }

    /**
     * ajax设置默认收货地址
     */
    public function actionDefault()
    {
        if ($this->isAjax()) {
            $addressId = $this->getPost('address_id');
            $gs = empty($_POST['gs']) ? '' : $this->getPost('gs');
            $quantity = empty($_POST['quantity']) ? '' : $this->getPost('quantity');
            $message = ''; //错误信息
            //查找用户是否有默认收货地址
            $model = Address::model()->find(array(
                'select' => 't.id',
                'condition' => 't.member_id = :id and t.default = :default',
                'params' => array(':id' => $this->uid, ':default' => Address::DEFAULT_YES),
            ));
            if (!empty($model->id) && ($model->id === $addressId)) { //如果要修改原默认收货地址为非默认，而未对其他地址勾选默认
                //将原来默认收货地址改为非默认
                $result = Address::model()->updateByPk($model->id, array('default' => Address::DEFAULT_NO), 'member_id = :id', array(':id' => $this->uid));
                if (!$result) {
                    $message = array('tips'=>'1','msg'=>'默认收货地址设置失败');
                }else{
                    $message = array('tips'=>'2','msg'=>'默认收货地址设置成功');
                }
            }else if(!empty($model->id) && $model->id !== $addressId){
                //将原来默认收货地址改为非默认
                $result = Address::model()->updateByPk($model->id, array('default' => Address::DEFAULT_NO), 'member_id = :id', array(':id' => $this->uid));
                $result2 = Address::model()->updateByPk($addressId, array('default' => Address::DEFAULT_YES), 'member_id = :id', array(':id' => $this->uid));
                if (!$result2 || !$result) {
                    $message = array('tips'=>'1','msg'=>'默认收货地址设置失败');
                }else{
                    $message = array('tips'=>'2','msg'=>'默认收货地址设置成功');
                }
            }else{
                //把非默认地址变为默认地址
                $result2 = Address::model()->updateByPk($addressId, array('default' => Address::DEFAULT_YES), 'member_id = :id', array(':id' => $this->uid));
                if (!$result2) {
                    $message = array('tips'=>'1','msg'=>'默认收货地址设置失败');
                }else{
                    $message = array('tips'=>'2','msg'=>'默认收货地址设置成功');
                }
            }

            if (!empty($gs) && !empty($quantity)) {
                $addressInfo = Address::model()->findByPk($addressId, array(
                    'select' => 'real_name,mobile,province_id,city_id,district_id,street,zip_code',
                    'condition' => 'member_id = :id',
                    'params' => array(':id' => $this->uid),
                ));
                $this->setSession('select_address', array('id' => $addressId, 'city_id' => $addressInfo->city_id));
            }
            echo CJSON::encode($message);
        }
    }
}


?>