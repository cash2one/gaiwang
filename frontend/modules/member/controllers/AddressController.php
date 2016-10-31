<?php

/**
 * 会员收货地址控制器 
 * 操作 (添加,修改,删除)
 * @author  wencong.lin <183482670@qq.com>
 */
class AddressController extends MController {

    public function actionIndex() {
        $this->pageTitle = Yii::t('memberAddress', '收货地址_用户中心_') . Yii::app()->name;
        $model = new Address;
        $this->performAjaxValidation($model);
        if(isset($_POST['ajax']) && $_POST['ajax'] == 'address-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['Address'])) {
            $model->attributes = $this->magicQuotes($_POST['Address']);
            if ($this->params('maxAddress') <= $model->numCount())
                $this->setFlash('maxAddress', Yii::t('memberAddress', '最多可以添加' . $this->params('maxAddress') . '个收货地址!'));
            else {
                if ($model->default == Address::DEFAULT_YES)
                    $model->updateAll(array('default' => Address::DEFAULT_NO), 'member_id = :mid AND `default` = ' . Address::DEFAULT_YES, array('mid' => $this->getUser()->id));
                if ($model->save()) {
                    $this->setFlash('success', Yii::t('memberAddress', '添加收货地址成功！'));
                    //跳转
                    $this->turnback();
                    $this->redirect(array('/member/address'));
                }
            }
        }

        $this->render('index', array(
            'model' => $model,
            'address' => $this->_getAddress()
        ));
    }

    /**
     * dialog 添加收货地址
     */
    public function actionAdd(){
        $this->layout = false;
        $model = new Address;
        $this->performAjaxValidation($model);
        if (isset($_POST['Address'])) {
            $model->attributes = $this->magicQuotes($_POST['Address']);
            if ($this->params('maxAddress') <= $model->numCount())
                $this->setFlash('maxAddress', Yii::t('memberAddress', '最多可以添加' . $this->params('maxAddress') . '个收货地址!'));
            else {
                //如果添加为默认地址，将旧地址全部修改为非默认地址
                if ($model->default == Address::DEFAULT_YES) 
                    $model->updateAll(array('default' => Address::DEFAULT_NO), 'member_id = :mid', array('mid' => $this->getUser()->id));
                $trans = Yii::app()->db->beginTransaction();
                try{
                    if ($model->save()) {
                        $addId = Yii::app()->db->lastInsertID;
                        //if ($model->default == Address::DEFAULT_YES)
                        //    $model->updateAll(array('default' => Address::DEFAULT_NO), 'member_id = :mid AND `default` = ' . Address::DEFAULT_YES, array('mid' => $this->getUser()->id));
                        $this->setSession('select_address',array('id'=>$addId,'city_id'=>$model->city_id));
                        echo "<script> var success = '".Yii::t('memberAddress', '添加收货地址成功！')."'; </script>";
                    }else{
                        echo "<script> alert('".Yii::t('memberAddress', '添加收货地址失败！')."')</script>";
                    }
                    $trans->commit();
                } catch (CException $e) {
                    $trans->rollback();
                    echo "<script> alert('".Yii::t('memberAddress', '添加收货地址失败！')."')</script>";
                }
            }
        }
        if($this->isAjax()){
            $add = $this->renderPartial('_addaddress',array('model'=>$model),true,true);
            exit(json_encode(array('add'=>$add)));
        } else {
            $this->render('add', array('model' => $model,'address' => $this->_getAddress()));
        }
    }

    /**
     * dialog 修改地址
     * @param $id
     */
    public function actionEdit($id){
        $this->layout = false;
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if (isset($_POST['Address'])) {
            $model->attributes = $this->magicQuotes($_POST['Address']);
            //如果当前修改的地址，是订单确认页中选择的地址，则修改session中的值
            $select_address = $this->getSession('select_address');
            if ($select_address['id'] == $model->id) {
                $select_address['city_id'] = $model->city_id;
                $this->setSession('select_address', $select_address);
            }
            if ($model->save()) {
                if ($model->default == Address::DEFAULT_YES)
                    $model->updateAll(array('default' => Address::DEFAULT_NO), 'member_id = :mid AND `default` = ' . Address::DEFAULT_YES, array('mid' => $this->getUser()->id));
                echo "<script> var success = '".Yii::t('memberAddress', '修改收货地址成功！')."'; </script>";
            }else{
                echo "<script> alert('".Yii::t('memberAddress', '修改收货地址失败！')."')</script>";
            }
        }
        $this->render('add', array(
            'model' => $model,
            'address' => $this->_getAddress()
        ));
    }
    /**
     * 修改会员收货地址
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if(isset($_POST['ajax']) && $_POST['ajax']=='address-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['Address'])) {			
            $model->attributes = $this->magicQuotes($_POST['Address']);
            //如果当前修改的地址，是订单确认页中选择的地址，则修改session中的值
            $select_address = $this->getSession('select_address');
            if ($select_address['id'] == $model->id) {
                $select_address['city_id'] = $model->city_id;
                $this->setSession('select_address', $select_address);
            }
            if ($model->default == Address::DEFAULT_YES)
                $model->updateAll(array('default' => Address::DEFAULT_NO), 'member_id = :mid AND `default` = ' . Address::DEFAULT_YES, array('mid' => $this->getUser()->id));
            if ($model->save()) {
                $this->setFlash('success', Yii::t('memberAddress', '收货地址修改成功！'));

                //跳转
				if(preg_match('/seckillFlow/i', $this->getParam('croute'))){
					header('Location: '.urldecode($_GET['croute']));
					exit;
				}else{
				    $this->turnback();
					return $this->redirect(array('/member/address'));
					
				}
            }
        }
        if($this->isAjax()){
            $ad = $this->renderPartial('_editaddress',array('model'=>$model),true,true);
            exit(json_encode(array('address'=>$ad)));
        } else {
            $this->render('index', array('model' => $model,'address' => $this->_getAddress()));
        }
    }

    /**
     * 设为默认地址
     * @param int $id
     */
    public function actionSet($id) {
        $model = $this->loadModel($id);
        $model->default = Address::DEFAULT_YES;
        $model->updateAll(array('default' => Address::DEFAULT_NO), 'member_id = :mid AND `default` = ' . Address::DEFAULT_YES, array('mid' => $this->getUser()->id));

        //ajax 设置
        if($this->getParam('callBack')){
            if ($model->save()) {
                exit('jsonpCallback({msg:"ok"})');
            } else {
                exit('jsonpCallback({msg:"error"})');
            }
        }else{
            //普通页面设置
            if ($model->save()) {
                $this->setFlash('success', Yii::t('memberAddress', '设定默认收货地址成功！'));
                $one = $this->loadModel($id);
                $this->setSession('select_address',array('id'=>$id,'city_id'=>$one['city_id']));
                $this->redirect(array('/member/address'));
            } else {
                $this->setFlash('warning', Yii::t('memberAddress', '当前地址信息不完整，请先修改！'));
                $this->redirect(array('/member/address'));
            }
        }

    }

    /**
     * 删除会员收货地址
     */
    public function actionDelete($id) {
        $addId = $this->getSession('select_address');
        $this->loadModel($id)->delete();
        //删除地址如果是选中的地址，选中地址改成默认地址
        if(isset($addId['id']) && $addId['id'] == $id){
            $address = Address::model()->find(
                    array(
                        'select'=>'id,city_id',
                        'condition'=>'member_id=:id AND `default`=:d',
                        'params'=>array(':id'=>$this->getUser()->id,':d'=>Address::DEFAULT_YES)
                    ));
            //若删除是默认地址，查找找第一个地址为选择地址
            if(empty($address)){
                $address = Address::model()->find(
                        array(
                            'select' => 'id,city_id',
                            'condition' => 'member_id=:id',
                            'params' => array(':id' => $this->getUser()->id),
                            'limit' => 1
                ));
            }
            // 当前用户只有一个地址是，则无默认地址
            if(!empty($address)){
                $this->setSession('select_address',array('id'=>$address->id,'city_id'=>$address->city_id));
            }
        }
        if(!$this->getParam('callBack')){
            $this->setFlash('success', Yii::t('memberAddress', '删除收货地址成功！'));
            //跳转
            $this->turnback();
            $this->redirect(array('/member/address'));
        }else{
            exit('jsonpCallback({msg:"ok"})');
        }
    }

    /**
     * 获取当前会员的收货地址信息列表
     */
    private function _getAddress() {
        $criteria = new CDbCriteria(array(
            'condition' => 'member_id =' . $this->getUser()->id,
            'order' => '`default` DESC'
        ));
        return Address::model()->findAll($criteria);
    }

    public function loadModel($id) {
        $model = Address::model()->findByPk($id, 'member_id = :mid', array(':mid' => $this->getUser()->id));
        if ($model === null)
            throw new CHttpException(404, Yii::t('memberAddress', '请求的页面不存在'));
        return $model;
    }

}
