<?php

class ProductAgentController extends Controller{
    
    public function actionIndex(){
        exit('error');
        $model = new ProductAgent('search');
        $this->breadcrumbs = array(Yii::t('Product','盖网通商城'),Yii::t('Product','盖网通商城'));
        
        $model->unsetAttributes();
        
        $typeData = Yii::app()->gt->createCommand()
                        ->select('id,pid,name')
                        ->from($model->tableNameCategory())
                        ->where('is_visible = 1 and type = 2 and pid = 0')
                        ->queryAll();
                        
		$power = $this->getPowerAear(false);
		$model->provinceStr = $power['provinceId'];
        $model->cityStr = $power['cityId'];
        $model->districtStr = $power['districtId'];
                        
        if(isset($_GET['ProductAgent'])){
            $model->attributes = $this->getQuery('ProductAgent');
            $model->category_pid = $_GET['ProductAgent']['category_pid'];
        }
        
        $this->render('index',array(
            'model' => $model,
            'typeData' => $typeData,
        ));
    }

    /**
     * 新增商品
     */
    public function actionCreate(){
		$model = new ProductAgent();  

		//获取商品类型
		$adTypeData = self::getAdvertData();
		
		$this->performAjaxValidation($model);
		
		if(isset($_POST['ProductAgent'])){
                        $model->attributes = $this->getPost('ProductAgent');
			
			//获取后台设定的线下盖网收益
			$file = Yii::getPathOfAlias('common') . DS . 'webConfig' . DS . 'allocation' . '.config.inc';
	        if (!file_exists($file)) {
	            $model->gw_rate = 0;
	        }else{
                    $array = Tool::getConfig($name = 'allocation');
//	        $content = file_get_contents($file);
//	        $array = unserialize(base64_decode($content));
	        	$model->gw_rate = $array['gaiIncome'];
	        }
	        
			if($model->save()){
				@SystemLogAgent::saveSystemLog(SystemLogAgent::MachineProduct, '{username}{type}{table}{key}', SystemLogAgent::DO_INSERT, $model);
				Yii::app()->user->setState($this->params('msgSessionKey'),array('img'=>'succeed','content'=>'添加成功!'));
				$this->redirect(array('index'));
			}
		}
		
		$this->render('create',array(
			'model' => $model,
			'adTypeData' => $adTypeData,
		));
    }
    
    /**
     * 编辑商品 
     */
    public function actionUpdate(){
    	$id = $_GET['id'];				//商品编号
    	
    	$model = $this->loadModel($id);
    	$this->checkAreaAuth($model->province_id,$model->city_id,$model->district_id);
    	
    	$this->performAjaxValidation($model);

		if(isset($_POST['ProductAgent']))
		{
			$isSave = false;
			$oldModel_attrs = array();
			foreach ($_POST['ProductAgent'] as $key=>$val){
				if($model->$key!=$val){
					$isSave = true;
					$oldModel_attrs[$key] = $model->$key;
//					break;
				}
			}
			
			$model->attributes=$_POST['ProductAgent'];
			
			if ($isSave){
				if($model->save()){
					Yii::app()->user->setState($this->params('msgSessionKey'),array('img'=>'succeed','content'=>Yii::t('Public','保存成功!')));
					@SystemLogAgent::saveSystemLogInfo(SystemLogAgent::MachineProduct, '盖网通商城-产品管理：{username}{type}{table}{key}', SystemLogAgent::DO_UPDATE, $model, $oldModel_attrs);
					$this->redirect(array('index'));
				}
			}else{
				Yii::app()->user->setState($this->params('msgSessionKey'),array('img'=>'succeed','content'=>'没有数据变更!'));
				$this->redirect(array('index'));
			}
		}
		
		$this->breadcrumbs = array(Yii::t('Product','盖网通商城'),Yii::t('Product','商品管理'),Yii::t('Product','编辑产品'));

		//获取商品类型
		$adTypeData = self::getAdvertData();	
		
		$this->render('update',array(
			'model'=>$model,
			'adTypeData' => $adTypeData,
		));
    }
    
    /**
     * 删除
     */
	public function actionDelete($id)
	{
		$operateModels = ProductAgent::model()->findAll("id in ($id)");
		foreach ($operateModels as $model)
		{
			$this->checkAreaAuth($model->province_id,$model->city_id,$model->district_id);			
		}
//		ProductAgent::model()->deleteAll("id in ($id)");
		ProductAgent::model()->updateAll(array('status'=>ProductAgent::STATUS_DEL),"id in ($id)");
		@SystemLogAgent::saveSystemLog(SystemLogAgent::MachineProduct, '{username}{type}{table}{key}', SystemLogAgent::DO_DELETE, $operateModels);
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])){
			Yii::app()->user->setState($this->params('msgSessionKey'),array('img'=>'succeed','content'=>'删除成功!'));
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
	}
    
	/**
	 * 复制
	 */
	public function actionCopy(){
		$id = $_GET['id'];
		$model = $this->loadModel($id);
		$this->checkAreaAuth($model->province_id,$model->city_id,$model->district_id);
		
		$model->id = '';
		$model->name = '';
		$model->number = '';
		$model->content = '';
		$model->thumbnail_id = '';
		$model->image_list_id = '';
		$model->isNewRecord = true;
		
		$this->performAjaxValidation($model);
		
		if(isset($_POST['ProductAgent']))
		{
			$newmodel = new ProductAgent();
			$newmodel->attributes = $model->attributes;
			$newmodel->attributes = $_POST['ProductAgent'];
			$newmodel->sales_volume = $model->sales_volume;
			$newmodel->status = $model->status;
			if($newmodel->save())
			{
				@SystemLogAgent::saveSystemLog(SystemLogAgent::MachineProduct, '{username}{type}{table}{key}', SystemLogAgent::DO_INSERT, $newmodel);
				$this->redirect(array('index'));
			}
		}
	
		$this->breadcrumbs = array('盖网通商城','商品管理','添加产品');
		
		//获取商品类型
		$adTypeData = self::getAdvertData();	
				
		$this->render('create',array(
			'model'=>$model,
			'adTypeData' => $adTypeData,
		));
	}
	
	/**
	 * 添加盖机
	 */
	public function actionAddMachine(){
		$this->layout = "left";
		$id = $_GET['id'];
		$machineModel = $this->loadModel($id);
		$this->checkAreaAuth($machineModel->province_id,$machineModel->city_id,$machineModel->district_id);
		$machineModel = new MachineAgent();
		$machineModel->productid = $id;
		$this->breadcrumbs = array(Yii::t('Product','盖网通商城'),Yii::t('Product','商品管理'),Yii::t('Product','添加盖机'));
		
                $agent_region = $this->getPowerAear(false);
                $machineModel->agent_ss = $agent_region;
                
		if(isset($_GET['MachineAgent'])){
			$machineModel->attributes = $_GET['MachineAgent'];
			$machineModel->biz_name = $_GET['MachineAgent']['biz_name'];
		}
		
		$this->render('addmachine',
			array(
				'model' => $machineModel,
			)
		);
	}
	
	/**
	 * 绑定盖机
	 */
	public function actionBindMachine(){
		$id = $_GET['id'];			//广告编号
		
		$machineModel = $this->loadModel($id);
		$this->checkAreaAuth($machineModel->province_id,$machineModel->city_id,$machineModel->district_id);
		
		$machineModel = new Machine2ProductAgent;
		
		$machineModel->product_id = $id;
		
                //代理地区session
                $agent_region = $this->getPowerAear(false);
                $machineModel->agent_ss = $agent_region;
                
                
		$this->breadcrumbs = array(Yii::t('Product','盖网通商城'),Yii::t('Product','商品管理'),Yii::t('Product','绑定盖机'));
		
		if(isset($_POST['addid'])){			//如果是表单提交
			$deleteid = isset($_POST['delid'])?$_POST['delid']:"";		//删除数据
			
			$addid = $_POST['addid'];		//添加数据
			
			if(!empty($addid)){				//如果有添加盖机
				$idArr = explode(",",$addid);
				
				$userip = Tool::ip2int(self::clientIP());
				$userid = Yii::app()->User->id;
				foreach ($idArr as $key=>$val){
					$machineModel->machine_id = $val;
					$machineModel->user_ip = $userip;
					$machineModel->user_id = $userid;			
					$machineModel->create_time = time();
					$machineModel->isNewRecord = true;
					$machineModel->save();
					$machineModel->log_source_id = $val;
					$operateModels[] = $machineModel;
				}
				$log_title = '编号为'.$id.'的商品绑定上了编号为'.$addid."的盖机";
				@SystemLogAgent::saveSystemLog(SystemLogAgent::MachineProduct, $log_title, SystemLogAgent::DO_INSERT, $operateModels);
			}
			
			if(!empty($deleteid)){			//如果有删除盖机
				$operateModels = array();
				foreach ($deleteid as $keyDel=>$valDel){
					$operateModel = Machine2ProductAgent::model()->findByAttributes(array(
						'machine_id'=>$valDel,'product_id'=>$id
					));
					Machine2ProductAgent::model()->deleteAll("machine_id = $valDel and product_id = $id");
					$operateModel->log_source_id = $valDel;
					$operateModels[] = $operateModel;
				}
				$log_title = '编号'.$id."的商品解除了在编号为".implode(",",$deleteid)."上的盖机的绑定";
				SystemLogAgent::saveSystemLog(SystemLogAgent::MachineProduct, $log_title, SystemLogAgent::DO_DELETE, $operateModels);
			}
			$this->redirect(Yii::app()->createURL('productAgent/bindMachine',array('id'=>$id)));
		}
		$this->render('machine',array(
			'model' => $machineModel,
			'dataProvider' => $machineModel->search(),
		));
	}
	
    /**
     * 显示加盟商
     */
    public function actionShowBiz(){
    	$this->layout = "left";
    	
    	$model = new FranchiseeAgent();
    	
    	$model->unsetAttributes();  // clear any default values
    	
    	//代理地区session
        $agent_region = $this->getPowerAear(false);
        $model->agent_ss = $agent_region;
        
        if(isset($_GET['FranchiseeAgent'])){
            $model->attributes=$_GET['FranchiseeAgent'];
            $model->gai_number=$_GET['FranchiseeAgent']['gai_number'];
        }
            
    	$this->render('bizinfo',array(
    		'model' => $model,
    	));
    }
    
    /**
     * 获取加盟商数据
     */
    public function actionGetBizInfo(){
    	if($this->isAjax()){
    		$id = $this->getPost('id');
    		if($id){
    			$data = Yii::app()->db->createCommand()
    						->select("name,province_id,city_id,district_id,street,lng,lat")
    						->from(Franchisee::model()->tableName())
    						->where("id=$id")
    						->queryRow();
    			echo json_encode($data);
    		}
    	}
    	Yii::app()->end();
    }
    
    /**
     * 和页面显示有关
     * Enter description here ...
     * @param unknown_type $name
     */
    protected function setCurMenu($name) {
        $this->curMenu = Yii::t('main','盖网通商城');
    }
    
    public $curMenu = '盖网通管理'; 
    /**
	 * 获取json格式的广告数据,餐厅、广告、旅游等
	 */
	public static function getAdvertData(){
		$parentData = Yii::app()->gt->createCommand()
                        ->select('id,pid,name')
                        ->from(ProductAgent::model()->tableNameCategory())
                        ->where('is_visible = 1 and type = 2')
                        ->order('tree_path')
                        ->queryAll();
		$jsonData = "[";
		foreach ($parentData as $key=>$val){
			$nocheck = $val['pid'] == 0?", nocheck:true":"";
			$jsonData.= "{ id:".$val['id'].", pId:".$val['pid'].", name:'".$val['name']."'$nocheck},";
		}
		$jsonData = substr($jsonData, 0, -1)."]";
		return $jsonData;
	}

	/**
	 * 获取广告子类型
	 */
	public function actionGetChildType(){
		$pid = $_GET['pid'];		//父节点id
		$result = Yii::app()->gt->createCommand()
                        ->select('id,pid,name')
                        ->from(ProductAgent::model()->tableNameCategory())
                        ->where('is_visible = 1 and type = 2 and pid = '.$pid)
                        ->order('id')
                        ->queryAll();
                        
		$data = array();
		foreach ($result as $key=>$val){
			$data[] = $val;
		}
		echo CJSON::encode($data);
	}
	
	/**
	 * ajax计算返还积分
	 * @author LC
	 */
	public function actionAjaxReturnScore()
	{
		if($this->isAjax())
		{
			$back_rate = $this->getQuery('back_rate');
			$price = $this->getQuery('price');
			$machineIncome = $this->getQuery('machineIncome');
			$GWIncomeRate = ProductAgent::getGWIncomeRate();
			$BuyerIncomeRate = ProductAgent::getBuyerIncomeRate();
			$returnMoney = $price*$back_rate/100*(1-$GWIncomeRate/100)*(1-$machineIncome/100)*$BuyerIncomeRate/100;
			$score = Common::convertSingle($returnMoney, 'official');
			echo $score;
		}
		Yii::app()->end();
	}
    
}
?>