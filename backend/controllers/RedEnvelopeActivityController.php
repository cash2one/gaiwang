<?php

/**
 * 红包后台
 * @author lhao
 */
class RedEnvelopeActivityController extends Controller
{


    public function filters()
    {
        return array(
            'rights',
        );
    }

    /**
     * 专题活动列表
     */
    public function actionAdmin()
    {
        $model = new Activity('search');
        $model->unsetAttributes();
        $model -> mode = Activity::ACTIVITY_MODE_RED;
        if (isset($_GET['Activity']))
            $model->attributes = $this->getParam('Activity');
        $surplusMoney = AccountManage::getSurplusMoney();  //积分红包剩余金额
        $sentTotalMoney = Coupon::getSentTotalMoney();  //送出总金额
        $totalMoney = CommonAccountLog::getTotalMoney();    //获取总投入金额

        $this->render('admin', array(
            'model' => $model,
            'sentTotalMoney' => $sentTotalMoney,//送出总金额
            'surplusMoney' => $surplusMoney,
            'totalMoney' => $totalMoney,
            'is_neeed_recharge' => $totalMoney == 0 || ($sentTotalMoney / $totalMoney) > 0.9 ? true : false,
        ));
    }

    /**
     * 创建专题活动
     * @author binbin.liao
     */
    public function actionCreate()
    {
        $model = new Activity();
        $this->performAjaxValidation($model);

        if (isset($_POST['Activity'])) {
            $model -> attributes = $this->getPost('Activity');
            $model -> mode = Activity::ACTIVITY_MODE_RED;
            $model -> create_time  = time();
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if ($model->save()) {
                    if($model->status == Activity::STATUS_ON) {
                        $rs = null;
                        $rs = Yii::app()->db->createCommand()->update('{{activity}}', array('status'=>Activity::STATUS_OFF), 'id <> :id and type=:type', array(':id'=>$model->id,':type'=>$model->type));
                        if($rs === null)
                            throw new Exception(Yii::t('Activity', "更新同类型活动状态失败！"));
                    }
                    $transaction -> commit();
                    @SystemLog::record(Yii::app()->user->name . "添加红包活动：{$model->name}");
                    $this->setFlash('success', Yii::t('Activity', "添加{$model->name}成功！"));
                    $this->redirect(array('admin'));
                }
            }catch (Exception $e){
                $transaction -> rollback();
                $model -> valid_end = date('Y-m-d',$model->valid_end);
                $this->setFlash('error', CHtml::errorSummary($model).Yii::t('Activity', "添加{$model->name}失败！"));
            }
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }


    /**
     * 删除专题活动专
     * @param integer $id 专题ID
     */
    public function actionStop($id)
    {
        die();
        $this->loadModel($id)->delete();
        @SystemLog::record(Yii::app()->user->name . "删除专题：" . $id);
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * 红包状态修改
     * @param int $id
     * @param int $status
     */
    public function actionStatusChange($id, $status)
{
    $status = intval($status);
    if (!in_array($status, array(Activity::STATUS_OFF))) {
        $this->setFlash('error', Yii::t('activity', '参数错误!'));
        $this->redirect(array('admin'));
    }

    $model  = Activity::model()->find(array('select'=>'id,type,status','condition'=>'id=:id','params'=>array(':id'=>$id)));
    $model -> status = $status;
    $model -> update_time = time();
    if ($model->save(true,array('status','update_time')))
        Yii::app()->user->setFlash('success', Yii::t('redEnvelopeActivity', '更新状态成功！'));
    else
        Yii::app()->user->setFlash('error', Yii::t('redEnvelopeActivity', '更新状态失败！'.CHtml::errorSummary($model)));
    $this->redirect(array('admin'));
}

    /**
     * 红包添加历史记录
     */
    public function actionCommonAccountlog()
    {
        $model = new CommonAccountLog('search');
        $model->unsetAttributes();
        if (isset($_GET['CommonAccountLog']))
            $model->attributes = $this->getParam('CommonAccountLog');
        $this->render('commonAccountLog', array(
            'model' => $model,

        ));
    }

    /**
     * 红包金钱增加
     */
    public function actionAddHongBaoAmount()
    {
        $model = AccountManage::model()->find(array('select'=>'id,money','condition'=>'type=:type','params'=>array(':type'=>AccountManage::ACCOUNT_MANAGE_RED)));
        if(!$model) {
            $model = new AccountManage();
            $redCommonAccount = CommonAccount::getHongbaoAccount();
            $model -> gai_number = $redCommonAccount['gai_number'];
            $model -> type = AccountManage::ACCOUNT_MANAGE_RED;
            $model -> create_time = time();
            $model -> money = 0;
        }
        $this->performAjaxValidation($model);
        if (isset($_POST['AccountManage'])) {
            $user = Yii::app()->db->createCommand()
                ->select('username,real_name')
                ->from("{{user}}")
                ->where("id = :id",array(':id'=>$this->getUser()->id))
                ->queryRow();
            if (empty($user)) Yii::app()->user->setFlash('error', Yii::t('redEnvelopeActivity', '登陆信息有误'));

            $arr  = $this->getParam('AccountManage');
            $money = floatval(isset($arr['money'])?$arr['money']:0);
            if($money == 0) {
                Yii::app()->user->setFlash('error',Yii::t("RedEnvelopeActivity", '添加金额不能为 0'));
            }else {
                $model->money += $money;
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if (($model->isNewRecord ? $model->save() : $model->update(array('money'))) && $model->addHongBaoAmount($money, $user['username'], $user['real_name'])) {
                        @SystemLog::record(Yii::app()->user->name . "添加积分金额成功");
                        $transaction->commit();
                        $this->setFlash('success', Yii::t('RedEnvelopeActivity', "添加积分金额成功"));
                        $this->redirect(array('admin'));
                    } else {
                        throw new Exception(Yii::t("RedEnvelopeActivity", '添加金额失败'));
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    @SystemLog::record(Yii::app()->user->name . "添加积分金额失败");
                    Yii::app()->user->setFlash('error', CHtml::errorSummary($model) . $e->getMessage());
                }
            }
        }
        $model->unsetAttributes(array('money'));
        $this->render('addHongBaoAmount', array(
            'model' => $model,
        ));
    }

    /**
     * 更新日期
     * @param $id
     */
    public function actionUpdateValidEnd($id)
    {
        $model = Activity::model()->find(array('select'=>'id,valid_end,type','condition'=>'id=:id','params'=>array(':id'=>$id)));
        $this->performAjaxValidation($model);

        if (isset($_POST['Activity'])) {
            $model->attributes = $this->getParam('Activity');
            $status = $this->getParam('status');    //取得状态
            if (!in_array($status, array(Activity::STATUS_OFF,Activity::STATUS_ON))) {
                $this->setFlash('error', Yii::t('activity', '参数错误!'));
                $this->redirect(array('admin'));
            }
            if($status == Activity::STATUS_ON)
                $model->status = Activity::STATUS_ON;
            $model->update_time = time();
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if (!($status?$model->save(true, array('valid_end','status','update_time')):$model->save(true, array('valid_end','update_time')))) {
                    throw new Exception(Yii::t('RedEnvelopeActivity', '更新充值红包活动结束时间失败'));
                }
                if($status == Activity::STATUS_ON){
                    $rs = null;
                    $rs = Yii::app()->db->createCommand()->update('{{activity}}', array('status' => Activity::STATUS_OFF,'update_time'=>time()), 'id <> :id and type=:type', array(':id' => $id, ':type' => $model->type));
                    if ($rs === null)
                        throw new Exception(Yii::t('Activity', "更新同类型活动状态失败！"));
                }
                $transaction->commit();
                if($status){
                    @SystemLog::record(Yii::app()->user->name . "开启充值红包活动结束时间和更新时间成功！");
                    $this->setFlash('success', Yii::t('RedEnvelopeActivity', '开启充值红包活动结束时间和更新时间成功！'));
                }
                @SystemLog::record(Yii::app()->user->name . "更新充值红包活动结束时间成功！");
                $this->setFlash('success', Yii::t('RedEnvelopeActivity', '更新充值红包活动结束时间成功！'));
                $this->redirect(array('admin'));
            }catch (Exception $e){
                $transaction->rollback();
                $this->setFlash('error', CHtml::errorSummary($model)."<br />".$e->getMessage());
            }
        }
        $model -> valid_end = date('Y-m-d',$model->valid_end);
        $this->render('updateValidEnd', array(
            'model' => $model,
        ));
    }

}
