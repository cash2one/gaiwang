<?php

class AppBrandsGoodsController extends Controller
{
	/**
	 * 品牌馆商品列表
	 * @param brands_id 品牌馆id
	 */
	public function actionAdmin()
	{
		$brandsId = $this->getParam('brands_id');
		$model = new AppBrandsGoods('search');
		$model->brands_id = $brandsId;
		$this->render('index',array(
				'model'=>$model,
				"brands_id"=>$brandsId
		));
	}
	
	/**
	 * 删除品牌馆商品
	 * @param id 品牌馆商品表id
	 */
	public function actionDelete(){
		$id = $this->getParam('id');
		$model=$this->loadModel($id);
		$brandsId = $model->brands_id;
		Yii::app()->db->createCommand()
				->delete(AppBrandsGoods::model()->tableName(), "id=:id", array(
				':id' => $id,
		));
		$this->redirect(array('AppBrandsGoods/Admin','brands_id'=>$brandsId));
	}
	
	/**
	 * ajax更新商品排序
	 * @param id 品牌馆商品表主键ID
	 */
	public function actionUpdateSequence(){
		if ($this->isAjax() && $this->isPost()) {
			$id = $this->getPost('id');
			$sequence = $this->getPost('sequence');
			$model = $this->loadModel($id);
			$model->sequence = $sequence;
			if ($model->save(false)) {
				exit(json_encode(array('success' => '成功')));
			} else
				exit(json_encode(array('error' => '失败')));
		}
	}
	
	/**
	 * 绑定品牌馆商品动作
	 */
	public function actionAddGoods(){
		$id = $this->getParam('brands_id');
		$goodModel = new Goods();
		$appBrandsModel = AppBrands::model()->findByPk($id);
		//$appBrandsGoodsModel = new AppBrandsGoods();
		if(isset($_GET['AppBrands'])){
			if($_GET['AppBrands']['enTer'] == AppBrands::ENTER_ID){
				$goodModel->store_id = $_GET['AppBrands']['enTerTit'];
			}else{
				$memberId = Member::getUserInfoByGw($_GET['AppBrands']['enTerTit'],'id');
				if(!empty($memberId)) {
					$storeId = Yii::app()->db->createCommand()
					->select('id')
					->from(Store::model()->tableName())
					->where('member_id = :member_id', array(':member_id' => $memberId['id']))
					->queryScalar();
					if(!empty($storeId)){
						$model->store_id = $storeId;
					}
				}
			}
			//$goodModel->enTerTit = $_GET['AppBrands']['enTerTit'];
			if($_GET['AppBrands']['goods'] == AppBrands::GOODS_ID){
				$goodModel->id = $_GET['AppBrands']['goodsTit'];
			}else{
				$goodModel->name = $_GET['AppBrands']['goodsTit'];
			}
		}
		$this->render('goodslist',array(
				'goodModel'=>$goodModel,
				'appBrandsModel'=>$appBrandsModel,
				//'appBrandsGoodsModel'=>$appBrandsGoodsModel,
		));
	}
	
	public function actionAjaxAddGoods(){
		$report = 0;
		if ($this->isPost()) {
			$brandsId = $_POST['brandsId'];
			foreach ($_POST['ids'] as $v) {
				if (!AppBrandsGoods::checkBondGoods($brandsId, $v)) {
					$Appmodel = new AppBrandsGoods();
					$Appmodel->brands_id = $brandsId;
					$Appmodel->goods_id = $v;
					$Appmodel->sequence = 1;
					$Appmodel->type = 1;
					$Appmodel->save();
				} else {
					$report = 1;
				}
			}
			//AppTopicHouse::UdateGoodsNum($house_Posid);
		}
		echo $report;
	}
}