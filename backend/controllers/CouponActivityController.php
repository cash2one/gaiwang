<?php
/**
 * 
 * 盖惠券控制器
 * @author huabin.hong
 *
 */
class CouponActivityController extends Controller
{

    public function filters() {
        return array(
            'rights',
        );
    }

    public function actionUpdateStatus(){
        Yii::app()->db->createCommand()->update('{{store_account}}',array('status'=>StoreAccount::STATUS_OFF));
        $sqlFind = "SELECT sa.id,SUM(IF(a.valid_end>='".time()."' and a.`status`=".Activity::STATUS_ON." and a.excess>0,1,0)) as sum_on".
                    "FROM {{store_account}} as sa INNER JOIN {{activity}} as a on a.store_id=sa.store_id and a.`mode`=".Activity::ACTIVITY_MODE_COUPON.
                    "GROUP BY sa.store_id;";
        $command = Yii::app()->db->createCommand($sqlFind);
        $command->execute();
        $reader = $command->query();
        foreach ($reader as $row) {
            if(!empty($row) && $row['sum_on'] > 0){
                Yii::app()->db->createCommand()->update('{{store_account}}',array('status'=>StoreAccount::STATUS_ON),'id=:id',array(':id'=>$row['id']));
            }
        }
    }

    public function  actionCreditAdmin(){
        $model = new Store('search');
        $model->unsetAttributes();
        if (isset($_GET['Store'])){
            $storeParam = $this->getParam('Store');
            $model->attributes = $storeParam;
            if($storeParam['member_id']){
                $model->member_id = Yii::app()->db->createCommand()
                    ->select('id')->from('{{member}}')
                    ->where('gai_number=:gw',array(':gw'=>$storeParam['member_id']))
                    ->queryScalar();
            }
            if(isset($storeParam['c_status'])){
                $model->c_status = $storeParam['c_status'];
            }
        }

        $totalMoney = Yii::app()->db->createCommand()
            ->select('sum(money)')->from('{{store_account}}')
            ->queryScalar();
        $storeCount = Yii::app()->db->createCommand()
            ->select('count(id)')->from('{{store}}')
            ->queryScalar();
        $storeAccountCount = Yii::app()->db->createCommand()
            ->select('count(id)')->from('{{store_account}}')
            ->queryScalar();

        $this->render('creditIndex',array(
            'model' => $model,
            'totalMoney' => $totalMoney,
            'storeCount' => $storeCount,
            'storeAccountCount' => $storeAccountCount,
        ));
    }
    public function  actionCreditView(){
        $storeId = $this->getParam('id');
        if ($storeId){
            $storeName = '';
            $activity = $storeAccount = array();
            $storeAccount = StoreAccount::model()->find('store_id=:id',array(':id'=>$storeId));
            if(!empty($storeAccount)){
                $storeName = Yii::app()->db->createCommand()
                    ->select('name')->from('{{store}}')->where('id=:id',array(':id'=>$storeId))
                    ->queryScalar();
//                $activity = Activity::model()->find('store_id=:id and mode=:mode',array(':id'=>$storeId,':mode'=>Activity::ACTIVITY_MODE_COUPON));
                $activity = new Activity('search');
                $activity->unsetAttributes();
                if(isset($_GET['view_status'])){
                    $activity->couponTotalStatus = $this->getParam('view_status');
                }
                $activity->store_id = $storeId;
                $activity->mode = Activity::ACTIVITY_MODE_COUPON;

                $this->render('creditView',array(
                    'storeName' => $storeName,
                    'storeAccount' => $storeAccount,
                    'activity' => $activity
                ));return;
            }
        }
        $this->setFlash('error', Yii::t('couponActivity', '该商家还没被授信'));
        $this->redirect(array('creditAdmin'));
    }
    public function actionUpdateStoreAccount(){

    }

    /**
	 * 盖惠券入口
	 */
	public function actionAdmin()
	{
		$model = new Activity('search');
		$model->unsetAttributes();
		
		
		if (isset($_GET['CouponActivity']))
			$model->attributes = $_GET['CouponActivity'];
        $model->mode = Activity::ACTIVITY_MODE_COUPON;
		
		$this->render('index',array(
			'model' => $model,
		));
	}

	/**
	 * 审核盖惠券
	 */
	public function actionUpdate($id)
	{
		if($this->isAjax())
    	{
    		$status = $this->getParam('status');
    		if (!in_array($status, array(CouponActivity::COUPON_STATUS_PASS, CouponActivity::COUPON_STATUS_FAIL))){
    			echo false;
    			Yii::app()->end();
    		}
            /** @var CouponActivity $model */
			$model = $this->loadModel($id);
			$model->status = $status;
            $trans = Yii::app()->db->beginTransaction();
            try{
                $model->save(false);
                if($status==CouponActivity::COUPON_STATUS_PASS){
                    //审核通过，批量生成优惠券
                    if($model->valid_end <= time()) throw new Exception('该盖惠券已经过期');
//                    $sql = '';
//                    //生成优惠券
//                    for($i=1;$i<=$model->sendout;$i++){
//                        $sql .= "INSERT INTO gw_coupon (
//                                    price,
//                                    valid_start,
//                                    valid_end,
//                                    create_time,
//                                    coupon_activity_id
//                                )
//                                VALUES
//                                    (
//                                        '{$model-> price}',
//                                        {$model->valid_start},
//                                        {$model->valid_end},
//                                        ".time().",
//                                        {$model->id}
//                                    );";
//                    }
//                    Yii::app()->db->createCommand($sql)->execute();
                }
                $trans->commit();
                echo CouponActivity::getCouponStatus($model->status);
            }catch (Exception $e){
                $trans->rollback();
                echo 'error';
            }

    	}
	}
}
