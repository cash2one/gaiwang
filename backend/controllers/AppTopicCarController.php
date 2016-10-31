<?php

class AppTopicCarController extends Controller
{


	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new AppTopicCar('create');
		
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		//$model->online_time =date('Y-m-d H:i:s');
		$model->subcontent = '';
		$subcontent = json_decode($model->subcontent,TRUE);
		if(isset($_POST['AppTopicCar']))
		{
			$appTopicCar = $this->getPost('AppTopicCar');
			$model->attributes = $appTopicCar;
			$model->content = stripslashes($model->content);

			$saveDir = 'AppTopicCar/'.time();
			$model = UploadedFile::uploadFile($model, 'image',$saveDir);
			$upload = false;
			$ImageSize = getimagesize($_FILES['AppTopicCar']['tmp_name']['image']);
			if($ImageSize[0] !=1080 || $ImageSize[1] !=628 ){
				$model->addError("image","请上传1080*628的图片");
				$upload = true;
			}
			$db = Yii::app()->db;
			$goodsData = array();
            //处理商品信息
			if(!empty($_POST['goodsIds'])){
				$goodsIds = $_POST['goodsIds'];
				$goodCategoryName = $_POST['goodCategoryName'];
				$goodCode = $_POST['goodCode'];
				$goodPrice = $_POST['goodPrice'];
			//	$goodPrice = $_POST['goodPrice'];
				$goodsImgs = $_FILES['goodsImgs'];
				$goodOrder = $_POST['goodOrder'];
				
				foreach ($_POST['goodsIds'] as $key=>$val){
					$tmepgoodsdata = array();
					$tmepgoodsdata['goodsIds'] = $val;
					$tmepgoodsdata['goodCategoryName'] = $goodCategoryName[$key];
					$tmepgoodsdata['goodCode'] = $goodCode[$key];
					$tmepgoodsdata['goodPrice'] = $goodPrice[$key];
					$tmepgoodsdata['goodOrder'] = $goodOrder[$key];
					//$tmepgoodsdata['goodsImgs'] = $goodsImgs[$key];
					$fileName = Tool::generateSalt(). '.'.pathinfo($goodsImgs['name'][$key],PATHINFO_EXTENSION);
					$filePath = $saveDir.'/'.$fileName;
					$tmepgoodsdata['goodsImgs'] = "";
					if($goodsImgs['name'][$key] == ''){
						$upload = true;
					}else{
						$ImageSize = getimagesize($goodsImgs['tmp_name'][$key]);
					}
					
					
					if(!$upload){
						if($ImageSize[0] !=560 || $ImageSize[1] !=560 ){
							$upload = true;
							$tmepgoodsdata['error'] = true;
						}
						if($upload){
							array_push($goodsData, $tmepgoodsdata);
							continue;
						}
						if(UploadedFile::upload_file($goodsImgs['tmp_name'][$key],$filePath,'','att')){
							$tmepgoodsdata['goodsImgs'] = $filePath;
						}
					}
					//if($upload)
					
					array_push($goodsData, $tmepgoodsdata);
				}
				
				
				$model->subcontent = json_encode($goodsData);
				
			}
			$model->online_time =strtotime($model->online_time);
			$model->update_time =time();
			$model->create_time =time();
			$model->admin_create =Yii::app()->user->id;
			$model->admin_update =Yii::app()->user->id;
			if($upload){
				$subcontent = json_decode($model->subcontent,TRUE);
				$this->setFlash('error', Yii::t('AppTopicCar', '添加失败,请核对图片是否符合标准'));
				$this->render('create',array(
						'model'=>$model,
						'subcontent'=>$subcontent,
						'error'=>true,
				));
				exit;
			}
			
			if($model->save()){
				UploadedFile::saveFile('image', $model->image);
				$this->setFlash('success', Yii::t('AppTopicCar', '创建盖象APP新动专题') . '"' . $model->title . '"' . Yii::t('AppTopicCar', '成功'));
				$this->redirect(array('admin'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'subcontent'=>$subcontent,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		
		$model=$this->loadModel($id);
		//初始化赋值
		//$model->online_time =date('Y-m-d',$model->online_time);
		$subcontent = json_decode($model->subcontent,TRUE);
		//$model->content = str_replace('\"', "", $model->content);
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model); 
		if(isset($_POST['AppTopicCar']))
		{
			$oldImage = $model->image;
			$appTopicCar = $this->getPost('AppTopicCar');
			$model->attributes = $appTopicCar;
			$model->content = stripslashes($model->content);
			$upload = false;
			$saveDir = 'AppTopicCar/'.time();
		    //处理专题图片
		    if(empty($_FILES['AppTopicCar']['name']['image'])){
		    	$model->image = $oldImage;
		    }else{
		    	$model = UploadedFile::uploadFile($model, 'image',$saveDir);
		    	$ImageSize = getimagesize($_FILES['AppTopicCar']['tmp_name']['image']);
		    	if($ImageSize[0] !=1080 || $ImageSize[1] !=628 ){
		    		$model->addError("image","请上传1080*628的图片");
		    		$upload = true;
		    	}
		    }
		    $db = Yii::app()->db;
		    $goodsData = array();
		    //商品信息
		    if(!empty($_POST['goodsIds'])){
		    	$goodsIds = $_POST['goodsIds'];
		    	$goodCategoryName = $_POST['goodCategoryName'];
		    	$goodCode = $_POST['goodCode'];
		    	$goodPrice = $_POST['goodPrice'];
		    //	$goodPrice = $_POST['goodPrice'];
		    	$goodsImgs = $_FILES['goodsImgs'];
		    	$goodOrder = $_POST['goodOrder'];
		    	$goodsImgsold = array();
		    	if(isset($_POST['goodsImgsold'])){
		    		$goodsImgsold = $_POST['goodsImgsold'];
		    	}
		    	
		    	foreach ($_POST['goodsIds'] as $key=>$val){
		    		$tmepgoodsdata = array();
		    		$tmepgoodsdata['goodsIds'] = $val;
		    		$tmepgoodsdata['goodCategoryName'] = $goodCategoryName[$key];
		    		$tmepgoodsdata['goodCode'] = $goodCode[$key];
		    		$tmepgoodsdata['goodPrice'] = $goodPrice[$key];
		    		$tmepgoodsdata['goodOrder'] = $goodOrder[$key];
		    		//$tmepgoodsdata['goodsImgs'] = $goodsImgs[$key];
		    		if($goodsImgs['name'][$key] == ''){
		    			$tmepgoodsdata['goodsImgs'] = $goodsImgsold[$key];
		    		}else{
		    			$fileName = Tool::generateSalt(). '.'.pathinfo($goodsImgs['name'][$key],PATHINFO_EXTENSION);
		    			$filePath = $saveDir.'/'.$fileName;
		    			$tmepgoodsdata['goodsImgs'] = "";
		    			$delete =  isset($goodsImgsold[$key]) ?  $goodsImgsold[$key] : '';
		    			if(!$upload){
		    				$ImageSize = getimagesize($goodsImgs['tmp_name'][$key]);
		    				if($ImageSize[0] !=560 || $ImageSize[1] !=560 ){
		    					$upload = true;
		    					$tmepgoodsdata['error'] = true;
		    				}
		    				if($upload){
		    					array_push($goodsData, $tmepgoodsdata);
		    					continue;
		    				}
		    				if(UploadedFile::upload_file($goodsImgs['tmp_name'][$key],$filePath,$delete,'att')){
		    					$tmepgoodsdata['goodsImgs'] = $filePath;
		    				}
		    			}
		    			
		    		}
		    		array_push($goodsData, $tmepgoodsdata);
		    	}
		    	$model->subcontent = json_encode($goodsData);
		    }
		    if($upload){
		    	$subcontent = json_decode($model->subcontent,TRUE);
		    	$model->online_time =strtotime($model->online_time);
		    	$this->setFlash('error', Yii::t('AppTopicCar', '更新失败,请核对图片是否符合标准'));
		    	$this->render('update',array(
		    			'model'=>$model,
		    			'subcontent'=>$subcontent,
		    			'error'=>true,
		    	));
		    	exit;
		    }
		    $model->online_time = strtotime($model->online_time);
		    $model->update_time = time();
		    $model->admin_update = Yii::app()->user->id;
		    if($model->save()){
		    	UploadedFile::saveFile('image', $model->image, $oldImage, true); // 保存并删除旧文件
		    	$this->setFlash('success', Yii::t('AppTopicCar', '修改盖象APP新动专题') . '"' . $model->title . '"' . Yii::t('AppTopicCar', '成功'));
		    	$this->redirect(array('admin')); 
		    }
		}

		$this->render('update',array(
			'model'=>$model,
			'subcontent'=>$subcontent
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		try {
			$db = Yii::app()->db;
			$sql = "DELETE FROM ".AppTopicCar::model()->tableName()." WHERE id = '{$id}'";
			$sqlCom = "DELETE FROM ".AppTopicCarComment::model()->tableName()." WHERE topic_id = '{$id}'";
			$transaction = $db->beginTransaction();
			$db->CreateCommand($sql)->execute();
			$db->createCommand($sqlCom)->execute();
			
			$transaction->commit();
			$this->setFlash('success',"删除成功！");
			$this->redirect(array('admin'));
		} catch (Exception $e) {
			$transaction->rollBack();
			$this->setFlash('error',$e->getMessage());
			$this->redirect(array('admin'));
		}
		
	}


	/**
	 * 新动列表
	 */
	public function actionAdmin()
	{
		$model=new AppTopicCar();
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AppTopicCar']))
			$model->attributes=$_GET['AppTopicCar'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	
	//AJAX验证商品ID是否是上架产品
	public function actionchechkGoods() {
		if ($this->isAjax() && $this->isPost()) {
			$id = $this->getPost('id');
			if(!is_numeric($id)){
				exit(json_encode(array('error' => '商品ID只能填写数字！')));
			}
			if (empty($id)) {
				exit(json_encode(array('error' => '商品ID不能为空！')));
			}

			$goods =Yii::app()->db->createCommand()
					->select('g.id,g.is_publish,g.status,g.price,g.code,c.name')
					->from('{{goods}} as g')
					->leftjoin('{{category}} as c','c.id = g.category_id')
					->where('g.id = :id',array(":id"=>$id))
					->queryRow();

			if (empty($goods)) {
				exit(json_encode(array('error' => '该商品不存在，请重新选择商品！')));
			}
			if ($goods['is_publish'] == Goods::PUBLISH_NO || $goods['status'] != Goods::STATUS_PASS) {
				exit(json_encode(array('error' => '该商品未上架或未通过审核，请重新选择商品！')));
			}
			if ($goods['is_publish'] == Goods::PUBLISH_YES) {
				exit(json_encode($goods));
			}
		}
	}

}
