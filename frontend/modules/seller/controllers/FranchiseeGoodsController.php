<?php

/**
 * 加盟商线下商品控制器
 * 操作 添加线下商品，更新线下商品
 * @author csj
 */
class FranchiseeGoodsController extends SFController {

	/**
	 * 增加商品
	 */
	public function actionCreate(){
		$this->pageTitle = Yii::t('sellerFranchiseeGoods','添加商品').$this->pageTitle;
		$model = new FranchiseeGoods();
		$model ->franchisee_id = $this->curr_franchisee_id;
		$this->performAjaxValidation($model);
		
		$cate_id = isset($_GET['cate_id']) ? $this->getParam('cate_id') : $model->franchisee_goods_category_id;
		$model ->franchisee_goods_category_id = $cate_id;

		if(isset($_POST['FranchiseeGoods'])){
			$model->attributes = $this->getPost('FranchiseeGoods');
			$saveDir = 'FranchiseeGoods/'.date('Y/n/j');
			$model = UploadedFile::UploadFile($model,'thumbnail',$saveDir,Yii::getPathOfAlias('uploads')); //上传图片
			
			$model ->create_time = time();
			$model ->update_time = $model ->create_time;

		 	if ($model->save()){
            	//保存操作记录
        		$this->_saveLog(SellerLog::CAT_BIZ,SellerLog::logTypeInsert);
            	UploadedFile::saveFile('thumbnail', $model->thumbnail, '', true); // 更新图片
            	$this->setFlash('success',Yii::t('sellerFranchiseeGoods', '商品添加成功'));
            }
            $this->redirect(array('index'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}


	/**
		商品列表

	**/
	public function actionIndex(){
		$this->pageTitle = Yii::t('sellerFranchisee','线下商品列表 - ').$this->pageTitle;

		$franchisee_model = Franchisee::model()->findByPk($this->curr_franchisee_id);
		 
		$goods_model = new FranchiseeGoods('search');
		$goods_model->unsetAttributes();  // clear any default values
		$goods_model->franchisee_id = $this->curr_franchisee_id;
		 
		$lists = $goods_model->search();
		$goods_data = $lists->getData();
		$pager = $lists->pagination;
		
		$this->FRender('index', array(
				'franchisee_model' => $franchisee_model,
				'goods_data'=>$goods_data,
				'pager'=>$pager,
		));
	}
	
	/**
	 * 检查操作的加盟商线下商品是否属于当前用户
	 * @mid
	 * Enter description here ...
	 */
	private function _checkFranchisee($goods_obj){
		if (empty($goods_obj) || $goods_obj->franchisee_id !== $this->curr_franchisee_id){
			$this->setFlash('error',Yii::t('sellerFranchiseeGoods', '没有权限！'));
			$this->redirect( $this->createAbsoluteUrl('index'));
			exit();
		}
	}
	
	

	/**
	 * 查看当前线下商品
	 */
	public function actionInfo(){
		$this->pageTitle = Yii::t('sellerFranchiseeGoods','查看当前线下商品').$this->pageTitle;
		$model = $this->loadModel($this->curr_goods_id);
		$this->_checkFranchisee($model);

		$this->FRender('info',array(
			'model'=>$model,
		));
	}
	
	/**
	 * 更新商品
	 * Enter description here....
	 * @param unknown_type $id
	 */

	public function actionUpdate(){
		$this->pageTitle = Yii::t('sellerFranchiseeGoods','更新线下商品').$this->pageTitle;
		$model = FranchiseeGoods::model()->findByPk($this->getParam('id')*1);
		$this->_checkFranchisee($model);
		$this->performAjaxValidation($model);
		
		$cate_id = isset($_GET['cate_id']) ? $this->getParam('cate_id') : $model->franchisee_goods_category_id;
		$model ->franchisee_goods_category_id = $cate_id;

		if(isset($_POST['FranchiseeGoods'])){
			$model->attributes = $this->getPost('FranchiseeGoods');
			$model ->update_time = time();
			
			$oldImg = $this->getParam('oldImg');  // 旧图
			$saveDir = 'FranchiseeGoods/' . date('Y/n/j');
			if (!empty($_FILES['FranchiseeGoods']['name']['thumbnail'])){
				$model = UploadedFile::uploadFile($model, 'thumbnail', $saveDir, Yii::getPathOfAlias('uploads'));  // 上传图片
			}else{
				$model->thumbnail = $oldImg;
			}
			
		 	if ($model->save()){
		 		if (!empty($_FILES['FranchiseeGoods']['name']['thumbnail'])) UploadedFile::saveFile('thumbnail', $model->thumbnail, $oldImg, true); // 更新图片
            	//保存操作记录
        		$this->_saveLog(SellerLog::CAT_BIZ,SellerLog::logTypeUpdate);
            	$this->setFlash('success',Yii::t('sellerFranchiseeGoods', '商品更新成功'));
            }
            $this->redirect(array('index'));
		}
		
		//处理路径
		$pics = FranchiseeGoodsPicture::model()->findAll("franchisee_goods_id={$model->id}");
		$pic_arr = array();
		foreach ($pics as $val) {
			$pic_arr[] = $val->path;
		}
		$model->path = implode('|', $pic_arr);

		$this->FRender('update',array(
			'model'=>$model,
		));
	}
	
	


	/**
	 * 下架商品
	 * @author leo8705
	 * Enter description here ...
	 * @param unknown_type $id
	 */
	public function actionDisable($id){
		$model =  FranchiseeGoods::model()->findByPk($id);
		$this->_checkFranchisee($model);
	
		$model->scenario = 'updateStatus';
		$model->status = FranchiseeGoods::STATUS_DISABLE;
		$model->save();
		 
		//保存操作记录
		$this->_saveLog(SellerLog::CAT_BIZ,SellerLog::logTypeUpdate);
		$this->setFlash('success',Yii::t('sellerFranchiseeGoods', '设置成功'));
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	/**
	 * 商品上架
	 * @author leo8705
	 * Enter description here ...
	 * @param unknown_type $id
	 */
	public function actionEnable($id){
		$model =  FranchiseeGoods::model()->findByPk($id);
		$this->_checkFranchisee($model);
	
		$model->scenario = 'updateStatus';
		$model->status = FranchiseeGoods::STATUS_ENABLE;
		$model->save();
		 
		//保存操作记录
		$this->_saveLog(SellerLog::CAT_BIZ,SellerLog::logTypeUpdate);
		$this->setFlash('success',Yii::t('sellerFranchiseeGoods', '设置成功'));
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	/**
	 * 选择线下商品分类
	 */
	public function actionSelectCategory()
	{
		if ($this->getParam('class_id')) {
			if ($this->getParam('id') > 0) {
				$url = $this->createAbsoluteUrl('/seller/franchiseeGoods/update', array(
						'cate_id' => $this->getParam('class_id'),
						'id' => $this->getParam('id'),
				));
			} else {
				$url = $this->createAbsoluteUrl('/seller/franchiseeGoods/create', array(
						'cate_id' => $this->getParam('class_id'),
				));
			}
			$this->redirect($url);
		}

		$this->FRender('selectCategory');
	}
	
	
	/**
	 * ajax调用分类json数据
	 */
	public function actionGetJson()
	{
		if (!$this->isAjax()) die;
		$cid = $this->getParam('cid');
		exit(FranchiseeGoodsCategory::getCategory($cid));
	}
	
	
    
}
