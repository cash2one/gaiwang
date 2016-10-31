<?php

/**
 * 加盟商线下订单控制器
 * 操作 添加线下商品，更新线下商品
 * @author csj
 */
class FranchiseeOrderController extends SFController {

	/**
		订单列表
	**/
	public function actionIndex(){
		$this->pageTitle = Yii::t('sellerFranchisee','线下订单列表 - ').$this->pageTitle;

		$franchisee_model = Franchisee::model()->findByPk($this->curr_franchisee_id);
		 
		$order_model = new FranchiseeGoodsOrder('search');
		$order_model->unsetAttributes();  // clear any default values
		$order_model->franchisee_id = $this->curr_franchisee_id;
		 
		$lists = $order_model->search();
		$order_data = $lists->getData();
		$pager = $lists->pagination;
		
		$this->FRender('index', array(
				'franchisee_model' => $franchisee_model,
				'order_data'=>$order_data,
				'pager'=>$pager,
		));
	}
	
	/**
	 * 检查操作的加盟商线下订单是否属于当前用户
	 * @mid
	 * Enter description here ...
	 */
	private function _checkFranchisee($order_obj){
		if (empty($order_obj) || $order_obj->franchisee_id !== $this->curr_franchisee_id){
			$this->setFlash('error',Yii::t('sellerFranchiseeGoods', '没有权限！'));
			$this->redirect( $this->createAbsoluteUrl('index'));
			exit();
		}
	}
	
	

	/**
	 * 查看当前线下商品
	 */
	public function actionInfo($code){
		$this->pageTitle = Yii::t('sellerFranchiseeGoods','查看当前线下订单详情').$this->pageTitle;
		$model = FranchiseeGoodsOrder::getDetails($code);
		$this->_checkFranchisee($model);

		$this->FRender('info',array(
			'model'=>$model,
		));
	}
	
    
}
