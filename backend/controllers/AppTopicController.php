<?php

/**
 * 盖象APP主题控制器
 * @author shengjie.zhang
 */
class AppTopicController extends Controller {
	//权限控制
	public function filters() {
        return array(
            'rights',
        );
    }
    /**
     * 不作权限控制的action
     * @return string
     */
    public function allowedActions() {
        return 'chechkProductId';
    }
   // 臻致生活列表
	public function actionAdminLife(){
		$model = new AppTopic();
		$model->unsetAttributes();
		if (isset($_GET['AppTopic']))
			$model->attributes = $this->getParam('AppTopic');
		$this->render('adminLife',array(
			'model'=>$model
			));
	}
   //商务小礼列表
	public function actionAdminGift(){
		$model = new AppTopic();
		$model->unsetAttributes();
		if (isset($_GET['AppTopic']))
			$model->attributes = $this->getParam('AppTopic');
		$this->render('adminGift',array(
			'model'=>$model
			));
	}
	//盖鲜汇列表
	public function actionAdminFresh(){
		$model = new AppTopic();
		$model->unsetAttributes();
		if (isset($_GET['AppTopic']))
			$model->attributes = $this->getParam('AppTopic');
		$this->render('adminFresh',array(
			'model'=>$model
			));
	}
   // 添加主题专题
	public function actionCreate(){
		$model = new AppTopic('create');
		$categoryId = $this->getParam('id');
		$this->performAjaxValidation($model);
		// Tool::p($id);exit;
		if (isset($_POST['AppTopic'])){
			$appTopic = $this->getPost('AppTopic');
			$model->attributes = $appTopic;
			$saveDir = 'AppTopic/'. date('Y/n/j');
			$model = UploadedFile::uploadFile($model, 'main_img', $saveDir);
			$upload = false;
			$ImageSize = getimagesize($_FILES['AppTopic']['tmp_name']['main_img']);
			if($ImageSize[0] !=1242 || $ImageSize[1] !=650 ){
				$model->addError("main_img","请上传1242*650的图片");
				$upload = true;
			}
			$db = Yii::app()->db;
			
			if($categoryId==AppTopic::BUSINESS_GIFT || $categoryId == AppTopic::FRESH_COLLECTION )
			{
			    
				$data=array();
				$title=array();
				$goodsListId=array();
				$goodsListInfo=array();
				$goodsImgs=array();
				$title = $this->getParam('title');
				$goodsListId = $this->getParam('goodsIds');
				$goodsorder = $this->getParam('goodsorders');
				$goodsListInfo = $this->getParam('goodsIntro');
				$goodsImgs = $this->getParam('goodsImgs');
				if(empty($title))
				{
					$this->setFlash('error', Yii::t('AppTopic', '主题标题'));
					$this->redirect(array($this->action->id,'id'=>$categoryId));
				}
				$data['profile'] = $title;
				
				if(!empty($goodsListId) && !empty($_FILES['goodsImgs']) && (count($goodsListId)==count($_FILES['goodsImgs']['size'])) && count($goodsListId)!=0){
					foreach ($goodsListId as $k=>$val)
					{
						$goodsListId[$k] = intval($val);
						if($goodsListId[$k]<=0)continue;
						if($goodsListId[$k])
							$goods = $db->createCommand()
						->select("id,is_publish,status")
						->from('{{goods}}')
						->where('id = :id',array(":id"=>$goodsListId[$k]))->queryRow();;
						if(empty($goods))
						{
							$this->setFlash('error', Yii::t('AppTopic', '商品id'.$val.'不存在'));
							$this->redirect(array($this->action->id,'id'=>$categoryId));
						}
                        if ($goods['is_publish'] == Goods::PUBLISH_NO || $goods['status'] != Goods::STATUS_PASS) {
                            $this->setFlash('error', Yii::t('AppTopic', '商品id'.$val.'的该商品未上架或未通过审核，请重新选择商品！'));
                            $this->redirect(array($this->action->id,'id'=>$categoryId));
                        }
					}
					// Tool::P($_FILES['goodsImgs']);exit;
					foreach ($goodsListId as $k => $v) {
						if(!$v)continue;
						$data['goods'][$k]['id'] = $v;
						if(!empty($goodsListInfo[$k])){
							$data['goods'][$k]['profile'] = $goodsListInfo[$k];
							$data['goods'][$k]['orders'] = $goodsorder[$k];
						}else{
                            $this->setFlash('error', Yii::t('AppTopic', '商品详情没有'));
                            $this->redirect(array($this->action->id, 'id' =>$categoryId));
						}
						
						
						foreach ($_FILES['goodsImgs']['tmp_name'][$k] as $key => $url) {
							if(file_exists($_FILES['goodsImgs']['tmp_name'][$k][$key]) && getimagesize($_FILES['goodsImgs']['tmp_name'][$k][$key])){
								$fileName = Tool::generateSalt() . '.' . pathinfo($_FILES['goodsImgs']['name'][$k][$key], PATHINFO_EXTENSION);
								$filePath = $saveDir.'/'.$fileName;
								$ImageSize = getimagesize($_FILES['goodsImgs']['tmp_name'][$k][$key]);
								if($ImageSize[0] !=1180 || $ImageSize[1] !=500 ){
									$upload = true;
									$data['goods'][$k]['img'][]='';
									$data['goods'][$k]['error'] = true;
									continue;
							    }
								if(UploadedFile::upload_file($_FILES['goodsImgs']['tmp_name'][$k][$key],$filePath,'','att')){
									$data['goods'][$k]['img'][]=$filePath;
								}else{
									$data['goods'][$k]['img'][]='';
								}
							}						
						}
					}

				}else{
					$this->setFlash('error', Yii::t('AppTopic', '请填写一条商品信息'));
					$this->redirect(array($this->action->id,'id'=>$categoryId));
				}
				
				
				$model->detail_content = json_encode($data);

				// Tool::P($data);exit;
			}
            $model->create_time = time();
            $model->update_time = time();
		    if($upload){
				$detail_content = json_decode($model->detail_content,TRUE);
				$this->setFlash('error', Yii::t('AppTopicCar', '添加失败,请核对图片是否符合标准'));
				$this->render('_form',array(
						'model'=>$model,
						'categoryId'=>$categoryId,
						'detail_content'=>$detail_content,
						'error'=>true,
				));
				exit;
			}
			if($model->save()){
				UploadedFile::saveFile('main_img', $model->main_img);
				SystemLog::record($this->getUser()->name . "创建盖象APP主题专题：" . $model->title);
				$this->setFlash('success', Yii::t('category', '创建盖象APP主题专题') . '"' . $model->title . '"' . Yii::t('AppTopic', '成功'));
				// sleep(1);
				if($model->category == AppTopic::FINE_LIVING){
					$this->redirect(array('adminLife'));
				}
				if($model->category == AppTopic::BUSINESS_GIFT){
					$this->redirect(array('adminGift'));
				}
				if($model->category == AppTopic::FRESH_COLLECTION){
					$this->redirect(array('adminFresh'));
				}				
			}
		}
		$this->render('_form', array(
			'model' => $model,
			'categoryId' => $categoryId,
			));
	}

	public function actionUpdate($id){
//	    try{
		$model = $this->loadModel($id);

		$categoryId = $model->category;
		// Tool::p($model);exit;
		$this->performAjaxValidation($model);
		$detail_content = json_decode($model->detail_content,true);
		if(isset($_POST['AppTopic']))
		{
			$oldFile = $model->main_img;
			// Tool::p($oldFile);exit;
			$model->attributes = $this->getParam('AppTopic');
			$saveDir = 'AppTopic/'.date('Y/n/j');
		    $db = Yii::app()->db;
		    
		    if($categoryId==AppTopic::BUSINESS_GIFT || $categoryId == AppTopic::FRESH_COLLECTION )
		    {
		        $data=array();
		        $title=array();
		        $goodsListId=array();
		        $goodsListInfo=array();
		        $goodsImgs=array();
		        $title = $this->getParam('title');
		        $goodsListId = $this->getParam('goodsIds');
				$goodsListInfo = $this->getParam('goodsIntro');
				$goodsorder = $this->getParam('goodsorders');
				$goodsImgs = $this->getParam('goodsImgs');
		        
		        if(empty($title))
		        {
		            $this->setFlash('error', Yii::t('AppTopic', '主题标题'));
		            $this->redirect(array($this->action->id,'id'=>$model->id));
		        }
		        $data['profile'] = $title;
		        if(!empty($goodsListId) && !empty($_FILES['goodsImgs']) && (count($goodsListId)==count($_FILES['goodsImgs']['size'])) && count($goodsListId)!=0){
		            foreach ($goodsListId as $k=>$val)
		            {
		                $goodsListId[$k] = intval($val);
		                if($goodsListId[$k]<=0)continue;
		                if($goodsListId[$k])
		                    $goods = $db->createCommand()
		                    ->select("id,is_publish,status")
		                    ->from('{{goods}}')
		                    ->where('id = :id',array(":id"=>$goodsListId[$k]))->queryRow();;

		                if(empty($goods))
		                {
		                    $this->setFlash('error', Yii::t('AppTopic', '商品id'.$val.'不存在'));
		                    $this->redirect(array($this->action->id,'id'=>$model->id));
		                }
                        if ($goods['is_publish'] == Goods::PUBLISH_NO || $goods['status'] != Goods::STATUS_PASS) {
                            $this->setFlash('error', Yii::t('AppTopic', '商品id'.$val.'的该商品未上架或未通过审核，请重新选择商品！'));
                            $this->redirect(array($this->action->id,'id'=>$model->id));
                        }
		            }
		             //Tool::P($_FILES['goodsImgs']);exit;
		            
		            foreach ($goodsListId as $k => $v) {
		                if(!$v)continue;
		                $data['goods'][$k]['id'] = $v;
		                if(!empty($goodsListInfo[$k])){
		                    $data['goods'][$k]['profile'] = $goodsListInfo[$k];
		                    $data['goods'][$k]['orders'] = $goodsorder[$k];
		                }else{
                            $this->setFlash('error', Yii::t('AppTopic', '商品详情没有'));
                            $this->redirect(array($this->action->id, 'id' =>$model->id));
		                }
		                foreach ($_FILES['goodsImgs']['tmp_name'][$k] as $key => $url) {
		                    if(isset($detail_content['goods'][$k]['img'][$key]) && $_FILES['goodsImgs']['tmp_name'][$k][$key]=='' && $_POST['goodsImageListVal'][$k][$key]==$detail_content['goods'][$k]['img'][$key])
		                    {
		                        $data['goods'][$k]['img'][$key] = $detail_content['goods'][$k]['img'][$key];
		                    }elseif(file_exists($_FILES['goodsImgs']['tmp_name'][$k][$key]) && getimagesize($_FILES['goodsImgs']['tmp_name'][$k][$key])){
		                        $fileName = Tool::generateSalt() . '.' . pathinfo($_FILES['goodsImgs']['name'][$k][$key], PATHINFO_EXTENSION);
		                        $filePath = $saveDir.'/'.$fileName;
		                        if(UploadedFile::upload_file($_FILES['goodsImgs']['tmp_name'][$k][$key],$filePath,'','att')){
		                            $data['goods'][$k]['img'][$key]=$filePath;
		                        }else{
		                            $data['goods'][$k]['img'][$key]='';
		                        }
		                    }else{
		                         if($k==0)
		                         {
		                             $this->setFlash('error', Yii::t('AppTopic', '请填写一条完整的商品信息'));
		                             $this->redirect(array($this->action->id,'id'=>$model->id));
		                         }else{
		                             unset($data['goods'][$k]);
		                             continue;
		                         }
		                    }
		                }
		            }
		            	
		        }else{
		            $this->setFlash('error', Yii::t('AppTopic', '请填写一条商品信息'));
		            $this->redirect(array($this->action->id,'id'=>$model->id));
		        }
		        $model->detail_content = json_encode($data);
		    }
		    
		    if(empty($_FILES['AppTopic']['name']['main_img'])){
		        $model->main_img = $oldFile;
		    }else{
		        $model = UploadedFile::uploadFile($model, 'main_img', $saveDir);
		       
		    }
            $model->update_time = time();
			if ($model->save()) {

			    UploadedFile::saveFile('main_img', $model->main_img, $oldFile, true); // 保存并删除旧文件
                @SystemLog::record(Yii::app()->user->name . "更新盖象APP主题专题：{$model->title}");
                $this->setFlash('success', Yii::t('AppTopic', "更新{$model->title}盖象APP主题专题成功！"));
                if($model->category == AppTopic::FINE_LIVING){
                	$this->redirect(array('adminLife'));
                }
                if($model->category == AppTopic::BUSINESS_GIFT){
                	$this->redirect(array('adminGift'));
                }
                if($model->category == AppTopic::FRESH_COLLECTION){
                	$this->redirect(array('adminFresh'));
                }
            }
        }
        $this->render('_form',array(
        	   'model'=>$model,
        	   'categoryId' => $categoryId,
               'detail_content'=>$detail_content
        	));
//	    }catch (Exception $e){
//            $this->setFlash('error', $e->getMessage());
//            $this->redirect(array($this->action->id));
//        }
    }

    public function actionDelete($id){
    	$model = $this->loadModel($id);
    	$categoryId = $model->category;
    	$detail_content = json_decode($model->detail_content,true);
    	if($categoryId==1 && !empty($detail_content))
    	{
    	    foreach($detail_content['image'] as $key=>$val){
    	        @UploadedFile::delete($detail_content['image'][$key]);
    	    }
    	    foreach($detail_content['imgGoods'] as $key=>$val){
    	        @UploadedFile::delete($detail_content['imgGoods'][$key]['image']);
    	    }
    	}
    	if ($model->delete()){
    		SystemLog::record($this->getUser()->name . '删除盖象APP主题专题' . $model->title . '，ID为：' . $model->id);
            $this->setFlash('success', Yii::t('category', '删除盖象APP主题专题') . '"' . $model->title . '"' . Yii::t('AppTopic', '成功'));
    	}

    }
    //    AJAX验证商品ID是否是上架产品
    public function actionChechkProductId() {
        if ($this->isAjax() && $this->isPost()) {
            $id = $this->getPost('id');
            if(!is_numeric($id)){
                exit(json_encode(array('error' => '商品ID只能填写数字！')));
            }
            if (empty($id)) {
                exit(json_encode(array('error' => '商品ID不能为空！')));
            }
//            $goods = Goods::model()->findByPk(array('id' => $id));
            $goods =Yii::app()->db->createCommand()->select('id,is_publish,status')->from('{{goods}}')->where('id = :id',array(":id"=>$id))->queryRow();
            if (empty($goods)) {
                exit(json_encode(array('error' => '该商品不存在，请重新选择商品！')));
            }
            if ($goods['is_publish'] == Goods::PUBLISH_NO || $goods['status'] != Goods::STATUS_PASS) {
                exit(json_encode(array('error' => '该商品未上架或未通过审核，请重新选择商品！')));
            }
            if ($goods['is_publish'] == Goods::PUBLISH_YES) {
                $msg['success'] = TRUE;
                exit(json_encode($msg));
            }


        }
    }
}