<?php
/**
 * 
 * 盖惠券控制器
 * @author huabin.hong
 *
 */
class CouponActivityController extends SController
{

	/**
	 * 盖惠券入口
	 */
	public function actionIndex()
	{
		$model = new CouponActivity('search');
		$model->unsetAttributes();
		
		//获取盖网授权总派发金额
		$model->gaiMoney = 1000000;
		
		//获取已经已经创建的盖惠券金额
		$model->shopMoney = 500000;
		
		//获取会员领取的盖惠券金额
		$userMoney = 200000; 
		
		
		if (isset($_GET['CouponActivity']))
                        $model->attributes = $this->getQuery('CouponActivity');
		
		$this->render('index',array(
			'model' => $model,
			'userMoney' => $userMoney,
		));
	}
	
	/**
	 * 创建盖惠券
	 */
	public function actionCreate()
	{
		$model = new CouponActivity();

		// ajax验证填写是否正确
 		$this->performAjaxValidation($model);
		
		if(isset($_POST['CouponActivity']))
		{
			$model->attributes=$_POST['CouponActivity'];
			$model->store_id = $this->storeId;
			if($model->save())
				$this->redirect(array('index'));
		}
		
		//获取盖网授权总派发金额
		$model->gaiMoney = 1000000;
		
		//获取已经已经创建的盖惠券金额
		$model->shopMoney = 500000;

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * 编辑盖惠券
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		
		// ajax验证填写是否正确
		$this->performAjaxValidation($model);
		
		if(isset($_POST['CouponActivity']))
		{
			$model->attributes=$_POST['CouponActivity'];
			if($model->save())
				$this->redirect(array('index'));
		}
		
		//获取盖网授权总派发金额
		$model->gaiMoney = 1000000;
		
		//获取已经已经创建的盖惠券金额
		$model->shopMoney = 500000;

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * 删除盖惠券
	 */
	public function actionDelete($id)
	{
//		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}
	
	/**
	 * 开启或者暂停盖惠券
	 */
	public function actionOs($id){
		if ($this->isAjax()){		//防止页面修改url进来
			$state = $this->getParam('state');
			if (!in_array($state, array(CouponActivity::COUPON_STATE_NO,CouponActivity::COUPON_STATE_YES))){
				echo Yii::t('sellerCouponActivity','数据异常');
				Yii::app()->end();
			}
			
			$model = $this->loadModel($id);
			$model->state = $state;
			if($model->save(false)){
				echo true;
			} else {
				echo $state == CouponActivity::COUPON_STATE_NO ? Yii::t('sellerCouponActivity','暂停领取盖惠券失败') : Yii::t('sellerCouponActivity','开启领取盖惠券失败');
			}
		} else {
			echo Yii::t('sellerCouponActivity','非法访问');
		}
	}
}
