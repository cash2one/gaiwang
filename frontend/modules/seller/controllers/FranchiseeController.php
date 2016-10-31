<?php

/**
 * 加盟商控制器
 * 操作(切换加盟商)
 * @author csj
 */
class FranchiseeController extends SFController {

	public function actionIndex(){
		$this->redirect($this->createUrl('change'));
	}
	
    /**
     * 切换加盟商
     */
    public function actionChange() {
    	$this->pageTitle = Yii::t('sellerFranchisee','切换加盟商 - ').$this->pageTitle;
        $model = new Franchisee;
        $model->unsetAttributes();
        $model->member_id = $this->user->id;
        $franchisees = Franchisee::getAllFranchiseeByMemberId($this->user->id);
        
        
        //判断店小二  过滤权限
        $assistant_id = Yii::app()->user->getState('assistantId');
        if (!empty($assistant_id)){
	        $franchisees_rs = $franchisees;
	        $franchisees = array();
	    	foreach ($franchisees_rs as $f){
		        $franchisees[$f->id] = $f;
		    }
        	
        	$franchisees_all = $franchisees;
        	$franchisees = array();
	        $permissions = AssistantPermission::model()->findAll("assistant_id = {$assistant_id} AND franchisee_id>0 GROUP BY assistant_id,franchisee_id");
	
	        foreach ($permissions as $p){
				if (!empty($franchisees_all[$p->franchisee_id])) $franchisees[] = $franchisees_all[$p->franchisee_id];
	        }
        }
        
    	if ($this->getParam('franchisee_id')){
    		$this->_setFranchiess($this->getParam('franchisee_id'));
        	$this->setFlash('success',Yii::t('sellerFranchisee', '切换成功'));
        	//保存操作记录
        	$this->_saveLog(SellerLog::CAT_BIZ,SellerLog::logTypeUpdate,$_REQUEST['franchisee_id']);
	    }
//        var_dump($this->curr_franchisee_id);exit;
        
	    $curr_franchiess = 0;
        if (!empty($franchisees)){
	        //默认取第一个为当前加盟商
	        if (empty($this->curr_franchisee_id)){
	        	$this->curr_franchisee_id = $franchisees[0]['id'];
                $this->_setFranchiess($franchisees[0]['id']);
	        }
	        $curr_franchiess = $model->find("id={$this->curr_franchisee_id}");
        }

        $this->render('change', array(
            'model' => $model,
        	'franchisees'=>$franchisees,
        	'curr_franchiess'=>$curr_franchiess,
        ));
    }

    /**
     * 查看加盟商
     * Enter description here ...
     * @param unknown_type $id
     */
    public function actionInfo(){
    	$this->pageTitle = Yii::t('sellerFranchisee','查看加盟商 - ').$this->pageTitle;
    	$this->_check($this->curr_franchisee_id);
    	$model = $this->loadModel($this->curr_franchisee_id);

        //补充协议相关展示数据
        $infos = FranchiseeContract::model()->getComfirmedContract(Yii::app()->user->id);
        $toUrl = empty($infos) ? '' : FranchiseeContract::createPrevoisvUrl($infos->id);

        $this->render('info', array(
            'model' => $model,
            'infos' => $infos,
            'toUrl' => $toUrl,
        ));
    }
    
	/**
     * 更新加盟商
     * Enter description here ...
     * @param unknown_type $id
     */
    public function actionUpdate(){
    	$this->pageTitle = Yii::t('sellerFranchisee','修改加盟商 - ').$this->pageTitle;
    	$this->_check($this->curr_franchisee_id);
    	$model = $this->loadModel($this->curr_franchisee_id);
        $model->unsetAttributes(array('password'));
        $this->performAjaxValidation($model);
        
        if (isset($_POST['Franchisee'])) {
            $oldLogo = $this->getParam('oldLogo');
            $model = UploadedFile::uploadFile($model, 'logo', 'franchisee',Yii::getPathOfAlias('uploads')); // 上传文件
            
            if (isset($_REQUEST['Franchisee'])){
            	$model->id = $this->curr_franchisee_id;
            	$form = $_REQUEST['Franchisee'];
            	unset($form['password']);
            	$model->attributes = $form;
            }
            
            if ($model->save()) {
                
                //先查出旧的  修改加盟商分类start-------------------
                $oldData = Yii::app()->db->createCommand()->select('franchisee_category_id')->from('{{franchisee_to_category}}')->where('franchisee_id=:fid', array(':fid'=>$model->id))->queryColumn();
                $arr_new = $form['categoryId'];
                
                if(!$arr_new){
                    $model->addError($model->category_id, Yii::t('franchisee','请选择加盟商分类'));
                }
                $intersect = array_intersect($oldData,$arr_new);//交集（需要保留的部分，不用处理）
                $result_del = array_diff($oldData, $intersect);//旧数据中需要删除的
                $result_add = array_diff($arr_new, $intersect);//新数据中需要增加的
                
                //添加新增数据
                if($result_add && is_array($result_add))
                {
                    foreach($result_add as $val)
                    {
                      $data_add = array('franchisee_id'=>$model->id, 'franchisee_category_id'=>$val);//数据
                      Yii::app()->db->createCommand()->insert('{{franchisee_to_category}}', $data_add);//添加
                    }
                }

                //删除需要清除的数据
                if($result_del && is_array($result_del))
                {
                    foreach($result_del as $val)
                    {
                        $sql = "delete from {{franchisee_to_category}} where franchisee_id=".$model->id." and franchisee_category_id=".$val;
                        Yii::app()->db->createCommand($sql)->execute();
                    }
                }//修改加盟商分类end------------------
                
                
                
                UploadedFile::saveFile('logo', $model->logo, $oldLogo, true); // 保存并删除旧文件
                $this->setFlash('success', Yii::t('sellerFranchisee', '修改加盟商') . $model->name . Yii::t('sellerFranchisee', '成功'));
                
                //保存操作记录
        		$this->_saveLog(SellerLog::CAT_BIZ,SellerLog::logTypeUpdate,$this->curr_franchisee_id);
        		
                $this->redirect(array('/seller/franchisee/info'));
            }
        }
        
        //处理路径
        $pics = FranchiseePicture::model()->findAll("franchisee_id={$model->id}");
        $pic_arr = array();
        foreach ($pics as $val) {
            $pic_arr[] = $val->path;
        }
        $model->path = implode('|', $pic_arr);
    	
        $this->render('update', array(
            'model' => $model,
        ));
    }
    
    
	/**
     * 修改密码
     */
    public function actionPwd() {
    	$this->pageTitle = Yii::t('sellerFranchisee','修改加盟商密码 - ').$this->pageTitle;
    	$this->_check($this->curr_franchisee_id);
        $model = $this->loadModel($this->curr_franchisee_id);
        $model->scenario = 'modify';

        $this->performAjaxValidation($model);
		$model->password = '';
        if (isset($_POST['Franchisee'])) {
            $model->originalPassword = $_POST['Franchisee']['originalPassword'];
            $model->password = $_POST['Franchisee']['password'];
            $model->confirmPassword = $_POST['Franchisee']['confirmPassword'];
            
            if ($model->save()) {
            	//保存操作记录
        		$this->_saveLog(SellerLog::CAT_MEMBERS,SellerLog::logTypeUpdate,$this->curr_franchisee_id);
        		
                $this->setFlash('success', Yii::t('sellerFranchisee', '密码修改成功'));
                $this->redirect(array('/seller/franchisee/info'));
            }
        }

        $this->render('pwd', array(
            'model' => $model,
        ));
    }
    
    
	/**
     * 加盟商文章管理
     */
    public function actionArtile() {
    	$this->pageTitle = Yii::t('sellerFranchisee','加盟商文章 - ').$this->pageTitle;
        $model = new FranchiseeArtile('search');
        $model->unsetAttributes();
        $model->franchisee_id = $this->curr_franchisee_id;
        
        if (isset($_GET['FranchiseeArtile']))
            $model->attributes = $this->getQuery('FranchiseeArtile');
            
            
        $lists = $model->search();
        $lists_data = $lists->getData();
        $pager = $lists->pagination;
            
            
        $this->render('artile', array(
            'model' => $model,
        	'lists_data'=>$lists_data,
        	'pager'=>$pager,
        ));
    }
    
    
    
	/**
     * 修改加盟商文章
     */
    public function actionArtileEdit($id) {
    	$this->pageTitle = Yii::t('sellerFranchisee','修改加盟商文章 - ').$this->pageTitle;
        $model = FranchiseeArtile::model()->find("id={$id}");
//        $this->performAjaxValidation($model);
    	if (isset($_POST['FranchiseeArtile'])) {
            $model->attributes = $this->getPost('FranchiseeArtile');
//            var_dump($model,$_POST['FranchiseeArtile']);exit();
            $oldImg = $this->getParam('oldImg');  // 旧图
            $saveDir = 'franchiseeArtile/' . date('Y/n/j');
            if (!empty($_FILES['FranchiseeArtile']['name']['thumbnail'])){
            	$model = UploadedFile::uploadFile($model, 'thumbnail', $saveDir, Yii::getPathOfAlias('att'));  // 上传图片
            }else{
            	$model->thumbnail = $oldImg;
            }
            if ($model->save()){
            	//保存操作记录
        		$this->_saveLog(SellerLog::CAT_BIZ,SellerLog::logTypeUpdate,$id);
            	if (!empty($_FILES['FranchiseeArtile']['name']['thumbnail'])) UploadedFile::saveFile('thumbnail', $model->thumbnail, $oldImg, true); // 更新图片
            	$this->setFlash('success',Yii::t('sellerFranchisee', '文章更新成功'));
            }
                
                $this->redirect(array('artile')); 
        }

        $this->render('artile_edit', array(
            'model' => $model,
        ));
    }
    
    
    
    
	/**
     * 添加加盟商文章
     */
    public function actionArtileAdd() {
    	$this->pageTitle = Yii::t('sellerFranchisee','添加加盟商文章 - ').$this->pageTitle;
        $model =  new FranchiseeArtile;
//        $this->performAjaxValidation($model);
    	if (isset($_POST['FranchiseeArtile'])) {
            $model->attributes = $this->getPost('FranchiseeArtile');
            $saveDir = 'franchiseeArtile/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'thumbnail', $saveDir, Yii::getPathOfAlias('att'));  // 上传图片
            $model->franchisee_id = $this->curr_franchisee_id;
            $model->author_id = $this->user->id;
			$model->create_time = time();
            
            if ($model->save()){
            	//保存操作记录
        		$this->_saveLog(SellerLog::CAT_BIZ,SellerLog::logTypeInsert);
            	UploadedFile::saveFile('thumbnail', $model->thumbnail, '', true); // 更新图片
            	$this->setFlash('success',Yii::t('sellerFranchisee', '文章添加成功'));
            }
                
            $this->redirect(array('artile')); 
        }

        $this->render('artile_add', array(
            'model' => $model,
        ));
    }
    
    
    
	/**
     * 加盟商文章管理
     */
    public function actionArtileDel($id) {
    	$id = $id*1;
        $rs = FranchiseeArtile::model()->deleteAllByAttributes(array('id'=>$id,'franchisee_id'=>$this->curr_franchisee_id));
        //保存操作记录
        $this->_saveLog(SellerLog::CAT_BIZ,SellerLog::logTypeDel,$id);
        $this->setFlash('success',Yii::t('sellerFranchisee', '删除成功'));
        $this->redirect($_SERVER['HTTP_REFERER']);
    }
    
    
    
    
    /**
     * 图片空间管理
     * Enter description here ...
     */
    public function actionImgList(){
    	$this->pageTitle = Yii::t('sellerFranchisee','图片空间 - ').$this->pageTitle;
    	$this->_check($this->curr_franchisee_id);
    	$model = $this->loadModel($this->curr_franchisee_id);
    	
    	$img_model = new FranchiseePicture();
    	$img_model->franchisee_id = $this->curr_franchisee_id;
    	
    	
    	$img_model->pageSize = 40;
    	$imgs = $img_model->search();
        $imgs_data = $imgs->getData();
        $pager = $imgs->pagination;
            
            

        $this->render('imgList', array(
            'model' => $model,
        	'img_model' => $img_model,
        	'imgs_data'=>$imgs_data,
        	'pager'=>$pager,
        ));
    }
    
    
    /**
     * 盖网机管理列表
     * Enter description here ...
     */
    public function actionMachineList(){
    	$this->pageTitle = Yii::t('sellerFranchisee','盖网机列表 - ').$this->pageTitle;
    	$this->_check($this->curr_franchisee_id);
    	$model = $this->loadModel($this->curr_franchisee_id);
    	
    	$machine_model = new Machine('search');
    	$machine_model->unsetAttributes();  // clear any default values
		$machine_model->biz_info_id = $this->curr_franchisee_id;
    	
		
		$lists = $machine_model->search();
        $machine_data = $lists->getData();
        $pager = $lists->pagination;

        $this->render('machineList', array(
            'model' => $model,
        	'machine_model' => $machine_model,
        	'machine_data'=>$machine_data,
        	'pager'=>$pager,
        ));
    }
    
    
    
    /**
     * 禁用机器
     * Enter description here ...
     * @param unknown_type $id
     */
    public function actionMachineStop($id){
    	$this->_check($this->curr_franchisee_id);
    	$model = $this->loadModel($this->curr_franchisee_id);
    	
    	$machine_model = Machine::model()->find("biz_info_id={$this->curr_franchisee_id} AND id={$id}");
    	$machine_model->status = 2;
    	$machine_model->save();
    	
    	$this->setFlash('success',Yii::t('sellerFranchisee', '设置成功'));
    	$this->redirect($_SERVER['HTTP_REFERER']);
    }
    
    
    /**
     * 启用机器
     * Enter description here ...
     * @param unknown_type $id
     */
	public function actionMachineRun($id){
    	$this->_check($this->curr_franchisee_id);
    	$model = $this->loadModel($this->curr_franchisee_id);
    	
    	$machine_model = Machine::model()->find("biz_info_id={$this->curr_franchisee_id} AND id={$id}");
    	$machine_model->status = 1;
    	$machine_model->save();
    	
    	$this->setFlash('success',Yii::t('sellerFranchisee', '设置成功'));
    	$this->redirect($_SERVER['HTTP_REFERER']);
    }
    
    
    /**
     * 客服列表
     * Enter description here ...
     */
	public function actionCustomerList(){
		$this->pageTitle = Yii::t('sellerFranchisee','修改客服 - ').$this->pageTitle;
    	$this->_check($this->curr_franchisee_id);
    	$model = $this->loadModel($this->curr_franchisee_id);
    	
    	$customer_model = new FranchiseeCustomer('search');
    	$customer_model->unsetAttributes();  // clear any default values
		$customer_model->franchisee_id = $this->curr_franchisee_id;
    	
		$customer_model->pageSize = 10;
		$lists = $customer_model->search();
        $customer_data = $lists->getData();
        $pager = $lists->pagination;

        $this->render('customerList', array(
            'model' => $model,
        	'customer_model' => $customer_model,
        	'customer_data'=>$customer_data,
        	'pager'=>$pager,
        ));
    }
    
    
	/**
     * 添加客服
	 */
	public function actionCustomerCreate()
	{
        $this->pageTitle = Yii::t('sellerFranchisee','添加客服 - ').$this->pageTitle;
		$model=new FranchiseeCustomer();
		$this->performAjaxValidation($model);
		
		$model->scenario = 'modify';

		if(isset($_POST['FranchiseeCustomer']))
		{
			$model->attributes=$_POST['FranchiseeCustomer'];
            $model->franchisee_id = $this->curr_franchisee_id;
            
			if($model->save()){
				//保存操作记录
        		$this->_saveLog(SellerLog::CAT_BIZ,SellerLog::logTypeInsert);
                $this->setFlash('success',Yii::t('sellerFranchisee', '添加客服成功'));
                $this->redirect(array('customerList'));
            }else{
                $this->setFlash('error',Yii::t('sellerFranchisee', '添加客服失败'));
            }

		}

		$this->render('customerCreate',array(
			'model'=>$model,
		));
	}
	
	
	
	
	/**
     * 修改客服
	 */
	public function actionCustomerUpdate($id)
	{
        $this->pageTitle = Yii::t('sellerFranchisee','修改客服 - ').$this->pageTitle;

		$model=FranchiseeCustomer::model()->find("franchisee_id={$this->curr_franchisee_id} AND id={$id}");
		$model->unsetAttributes(array('password'));
		
		$this->performAjaxValidation($model);
		if(isset($_POST['FranchiseeCustomer']))
		{
			$model->attributes=$_POST['FranchiseeCustomer'];
			$model->password=$_POST['FranchiseeCustomer']['password'];
            
			if($model->save()){
				//保存操作记录
        		$this->_saveLog(SellerLog::CAT_BIZ,SellerLog::logTypeUpdate,$id);
                $this->setFlash('success',Yii::t('sellerFranchisee', '修改客服成功'));
                $this->redirect(array('customerList'));
            }else{
                $this->setFlash('error',Yii::t('sellerFranchisee', '修改客服失败'));
            }
		}

		$this->render('customerUpdate',array(
			'model'=>$model,
		));
	}
    
	
	
	
	/**
     * 删除客服
	 */
	public function actionCustomerDel($id)
	{
        $id = $id*1;
        $model=FranchiseeCustomer::model()->find("franchisee_id={$this->curr_franchisee_id} AND id={$id}");
        if($model->delete()){
        	//保存操作记录
        	$this->_saveLog(SellerLog::CAT_BIZ,SellerLog::logTypeDel,$id);
        	$this->setFlash('success',Yii::t('sellerFranchisee', '删除成功'));
        }else{
        	$this->setFlash('error',Yii::t('sellerFranchisee', '删除失败'));
        }
        
        
        $this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	
    
    
    /**
     * 盖网机消费记录
     * @param unknown $mid		机器id
     * @param unknown $name		名称
     * @return boolean
     */
    public function actionMachineConsumptionRecord($mid,$mname=''){
    	$mid = $mid*1;
    	if (empty($mid))  return false;
    	if (empty($mname)) {
    		$m_info = Machine::model()->find("id={$mid}");
    		if (!empty($m_info)) $mname = $m_info->name;
    	}
    	
    	$model = new FranchiseeConsumptionRecord();
    	if (isset($_REQUEST['FranchiseeConsumptionRecord'])) $model->attributes = $_REQUEST['FranchiseeConsumptionRecord'];
    	$model->machine_id = $mid;
    	$model->franchisee_id = $this->curr_franchisee_id;
    	
    	$lists = $model->searchList();
        $lists_data = $lists->getData();
        $pager = $lists->pagination;
    	
    	$this->render('machineConsumptionRecord',array(
    			'model'=>$model,
    			'lists_data'=>$lists_data,
    			'pager'=>$pager,
    			'm_info'=>$m_info,
    	));
    }
    
    
    
    /**
     * 盖网机消费记录详细
     * @param unknown $mid		机器id
     * @param unknown $name		名称
     * @return boolean
     */
    public function actionMachineConsumptionRecordInfo($id){
    	$id = $id*1;
    	$model = FranchiseeConsumptionRecord::model()->find("id={$id} AND franchisee_id={$this->curr_franchisee_id}");
    	if (empty($model))  throw new CHttpException(404,'此页面不存在');

    	$m_info = Machine::model()->find("id={$model->machine_id}");
    	$f_info = $this->loadModel($this->curr_franchisee_id);

    	$this->renderPartial('machineConsumptionRecordInfo',array(
    			'model'=>$model,
    			'm_info'=>$m_info,
    			'f_info'=>$f_info,
    	));
    }
    
    
    /**
     * 机器签到记录
     * @param unknown $mid
     * @return boolean
     */
    public function actionMachineSigninRecord($mid){
    	$mid = $mid*1;
    	$m_info = Machine::model()->find("biz_info_id={$this->curr_franchisee_id} AND id={$mid}");
    	if (empty($mid)||empty($m_info)){
    		throw new CHttpException(404,'此页面不存在');
    		return false;
    	}
    	 
    	$model = new Signin();
    	if (isset($_REQUEST['Signin'])) $model->attributes = $_REQUEST['Signin'];
    	$model->machine_id = $mid;
    	$model->type = 2;
    	 
    	$lists = $model->search();
    	$lists_data = $lists->getData();
    	$pager = $lists->pagination;
    	 
    	$this->render('machineSigninRecord',array(
    			'model'=>$model,
    			'lists_data'=>$lists_data,
    			'pager'=>$pager,
    			'm_info'=>$m_info,
    	));
    }
    
    
    /**
     * 机器注册记录
     * @param unknown $mid
     * @return boolean
     */
    public function actionMachineRegistrationRecord($mid){
    	$mid = $mid*1;
    	$m_info = Machine::model()->find("id={$mid}");
    	if (empty($mid)||empty($m_info))  return false;
    
    	$model = new MachineRegister();
    	if (isset($_REQUEST['MachineRegister'])) $model->attributes = $_REQUEST['MachineRegister'];
    	$model->machine_id = $mid;
    
    	$lists = $model->search();
    	$lists_data = $lists->getData();
    	$pager = $lists->pagination;
    
    	$this->render('machineRegistrationRecord',array(
    			'model'=>$model,
    			'lists_data'=>$lists_data,
    			'pager'=>$pager,
    			'm_info'=>$m_info,
    	));
    }
    
    /**
     * 盖网通商城订单
     * @author LC
     */
    public function actionMachineOrderList()
    {
    	$this->_check($this->curr_franchisee_id);
    	$model = new MachineProductOrder('search');
    	if (isset($_REQUEST['MachineProductOrder']))
    	{
    		$model->attributes = $_REQUEST['MachineProductOrder'];
    	} 
    	$model->franchisee_id = $this->curr_franchisee_id;
    	$lists = $model->search();
    	$lists_data = $lists->getData();
    	$pager = $lists->pagination;
    	$this->render('machineOrderList', array(
    		'model'=>$model,
    		'lists_data'=>$lists_data,
    		'pager'=>$pager,
    	));
    }
    
    /**
     * 盖网通商城订单详情
     * @author LC
     */
    public function actionMachineOrderDetail($id)
    {
    	$this->_check($this->curr_franchisee_id);
    	$model = MachineProductOrder::model()->findByPk($id);
    	if($model->franchisee_id != $this->curr_franchisee_id)
    	{
    		throw new CHttpException(404);
    	}
    	$model->is_read = MachineProductOrder::READ_YES;
    	$model->save();
    	$this->render('machineOrderDetail', array(
    		'model' => $model
    	));
    }
    
    /**
     * 盖网通商城订单详情--重发短信
     * @author LC
     */
    public function actionResendSms($id)
    {
    	$this->_check($this->curr_franchisee_id);
    	$model = MachineProductOrderDetail::model()->findByPk($id);
    	if($model->machineProductOrder->franchisee_id != $this->curr_franchisee_id)
    	{
    		throw new CHttpException(404);
    	}
    	if($this->isAjax())
    	{
    		$smsModel = SmsLog::model()->findByPk($model->sms_id);
    		$result = Sms::send($smsModel->phone, $smsModel->msg);
    		$smsModel->unsetAttributes(array('id'));
    		$smsModel->attributes = $result;
    		$smsModel->send_count = 1;
    		$smsModel->setIsNewRecord(true);
    		$smsModel->save();
    		if($result['send_status'] == SmsLog::STATUS_SUCCESS)
    		{
    			echo 1;
    		}
    		else 
    		{
    			echo 0;
    		}
    		
    	}
    	Yii::app()->end();
    }
    
    /**
     * 盖网通商城订单详情--验证消费
     * @author LC
     */
    public function actionVerifyConsumed($id)
    {
    	if($this->isAjax())
    	{
	    	$this->_check($this->curr_franchisee_id);
	    	$model = MachineProductOrderDetail::model()->findByPk($id);
	    	if($model->machineProductOrder->franchisee_id != $this->curr_franchisee_id)
	    	{
	    		throw new CHttpException(404);
	    	}
    		$verify_code = $this->getParam('verify_code');
    		$rs = MachineOrder::distribution($id,$verify_code);
//    		if($model->is_consumed == MachineProductOrderDetail::IS_CONSUMED_NO&&$verify_code == $model->verify_code)
//    		{
//    			$model->is_consumed = MachineProductOrderDetail::IS_CONSUMED_YES;
//    			$model->consume_time = time();
//    			$model->machineProductOrder->status = MachineProductOrder::STATUS_COMPLETE;
//    			$model->machineProductOrder->is_read = MachineProductOrder::READ_YES;
//    			$model->machineProductOrder->consume_status = MachineProductOrder::CONSUME_STATUS_YES;
//    			
//    			$model->machineProductOrder->consume_time = time();
//	    		$transaction = Yii::app()->db->beginTransaction();
//	            try {
//	            	$consumer_money = IntegralOffline::machineProductOrderDetailDistribution($model);
//	            	$model->return_money = $consumer_money;
//	                $model->machineProductOrder->return_money = $consumer_money;
//	            	if($model->save() && $model->machineProductOrder->save())
//            		{
//            			$transaction->commit(); //提交事务会真正的执行数据库操作
//            		}
//            		else 
//            		{
//            			throw new ErrorException('error', 400);
//            		}
//	                $this->_saveLog(SellerLog::CAT_BIZ, SellerLog::logTypeUpdate, $model->id);
//	                //发送短信提示
//	                $machineOrderConsumeAfterVerify = $this->getConfig('smsmodel', 'machineOrderConsumeAfterVerify');
//	                $machineOrderConsumeAfterVerify = str_replace(array('{0}', '{1}', '{2}', '{3}', '{4}'), array($model->machineProductOrder->member->gai_number, IntegralOffline::conversionDate($model->machineProductOrder->pay_time), $model->machineProductOrder->franchisee->name, $model->product_name, $model->quantity),$machineOrderConsumeAfterVerify);
//	                $smsRes = Sms::send($model->machineProductOrder->phone, $machineOrderConsumeAfterVerify);
//		            if(!empty($smsRes)){
//			            $smsRes['source_id'] = SmsLog::SOURCE_MACHINE_ORDER_SUCCESS;
//			            $smsRes['msg_key'] = SmsLog::MSG_KEY_MACHINE_PRODUCT_CONSUME;
//			            Yii::app()->db->createCommand()->insert('{{sms_log}}', $smsRes);
//			        }
//	                echo 1;
//	            } catch (Exception $e) {
//	                $transaction->rollback(); //如果操作失败, 数据回滚
//	                echo 0;
//	            }
//    		}
//    		else
//    		{
//    			echo 2;
//    		}
    		if($rs === true)
			{
				$this->_saveLog(SellerLog::CAT_BIZ, SellerLog::logTypeUpdate, $model->id);
	        	//发送短信提示
                $machineOrderConsumeAfterVerify = $this->getConfig('smsmodel', 'machineOrderConsumeAfterVerify');
                $machineOrderConsumeAfterVerify = str_replace(array('{0}', '{1}', '{2}', '{3}', '{4}'), array($model->machineProductOrder->member->gai_number, IntegralOffline::conversionDate($model->machineProductOrder->pay_time), $model->machineProductOrder->franchisee->name, $model->product_name, $model->quantity),$machineOrderConsumeAfterVerify);
                $smsRes = Sms::send($model->machineProductOrder->phone, $machineOrderConsumeAfterVerify);
	            if(!empty($smsRes)){
		            $smsRes['source_id'] = SmsLog::SOURCE_MACHINE_ORDER_SUCCESS;
		            $smsRes['msg_key'] = SmsLog::MSG_KEY_MACHINE_PRODUCT_CONSUME;
		            Yii::app()->db->createCommand()->insert('{{sms_log}}', $smsRes);
		        }
				echo 1;
			}
			elseif ($rs === 102)
			{
				echo 2;
			}
			else 
			{
				echo 0;
			}
    	}
    	Yii::app()->end();
    }
    
    /**
     * 盖网机列表--产品交易记录
     * @author LC
     */
    public function actionMachineOrderRecord($mid)
    {
    	$m_info = Machine::model()->findByPk($mid);
    	if (empty($m_info)){
    		throw new CHttpException(404);
    	}
    	$model = new MachineProductOrderDetail('search');
    	if (isset($_REQUEST['MachineProductOrderDetail']))
    	{
    		$model->attributes = $_REQUEST['MachineProductOrderDetail'];
    	} 
    	$model->franchisee_id = $this->curr_franchisee_id;
    	$model->machine_id = $mid;
    	$lists = $model->search();
    	$lists_data = $lists->getData();
    	$pager = $lists->pagination;
    	$this->render('machineOrderRecord', array(
    		'model'=>$model,
    		'machine_name'=>$m_info->name,
    		'lists_data'=>$lists_data,
    		'pager'=>$pager,
    	));
    }
    
    
    /**
     * 保存操作记录
     */
    protected  function _saveLog($category_id=0,$type_id=0,$source_id=0,$title=''){
    	$log = new SellerLog();
		$log->category_id = $category_id;
     	$log->type_id = $type_id;
     	$log->create_time = time();
     	$log->source = ucwords(Yii::app()->controller->id).ucwords($this->action->id);
     	$log->source_id = $source_id;
     	$log->member_id = !empty($this->getUser()->id)?$this->getUser()->id:'';
     	$log->member_name = !empty($this->getUser()->name)?$this->getUser()->name:'';
     	$log->ip = Yii::app()->request->userHostAddress;
     	$log->is_admin = empty($this->getUser()->member_id)?0:1;

     	$user_type = Yii::app()->user->getState('assistantId') ? '店小二':'商家用户';

     	switch ($log->source){
     		case 'FranchiseeChange':
     			$log->title =  $user_type.$log->member_name. Yii::t('sellerFranchisee', '切换加盟商');
     			break;
     			
     		case 'FranchiseeUpdate':
     			$log->title = $user_type.$log->member_name. Yii::t('sellerFranchisee', '更新加盟商信息');
     			break;
     			
     		case 'FranchiseePwd':$user_type.$log->member_name. Yii::t('sellerFranchisee', '修改加盟商密码');
     			break;
     			
     		case 'FranchiseeArtileEdit':
     			$log->title = $user_type.$log->member_name. Yii::t('sellerFranchisee', '修改加盟商文章');
     			break;
     			
     		case 'FranchiseeArtileAdd':
     			$log->title = $user_type.$log->member_name. Yii::t('sellerFranchisee', '添加加盟商文章');
     			break;
     			
     		case 'FranchiseeArtileDel':
     			$log->title = $user_type.$log->member_name. Yii::t('sellerFranchisee', '删除加盟商文章');
     			break;
     			
     		case 'FranchiseeCustomerCreate':
     			$log->title = $user_type.$log->member_name. Yii::t('sellerFranchisee', '添加加盟商客服');
     			break;
     			
     		case 'FranchiseeCustomerUpdate':
     			$log->title = $user_type.$log->member_name. Yii::t('sellerFranchisee', '更新加盟商客服信息');
     			break;
     			
     		case 'FranchiseeCustomerDel':
     			$log->title = $user_type.$log->member_name. Yii::t('sellerFranchisee', '删除加盟商客服');
     			break;
     			
     		case 'FranchiseeUploadUpload':
     			$log->title = $user_type.$log->member_name. Yii::t('sellerFranchisee', '上传加盟商图片');
     			break;
     			
     		case 'FranchiseeUploadDel':
     			$log->title = $user_type.$log->member_name. Yii::t('sellerFranchisee', '删除加盟商图片');
     			break;
     			
     		case 'FranchiseeVerifyConsumed':
     			$log->title = $user_type.$log->member_name. Yii::t('sellerFranchisee', '盖网通商城订单验证');
     			break;
     			
     		default:
     			$log->title = $title;
     			
     	}
     	
     	
     	if (!empty($title)) $log->title = $title;
     	
     	
     	$log->save();
     	
    	
    }
    
    
    
    
    //售货机begin  by leo8705
    
    /**
     * 检查操作的加盟商售货机是否属于当前用户
     * @mid
     * Enter description here ...
     */
    private function _checkVendingMachine($mid){
    	$mid = $mid*1;
    	$franchisee_id = $this->getSession($this->curr_franchiess_session_key);
    	$this->_check($franchisee_id);
    
    	if(empty($mid) ||  !VendingMachine::model()->count(" id={$mid} AND franchisee_id={$franchisee_id}")){
    		$this->setFlash('error',Yii::t('sellerFranchisee', '没有权限！'));
    		$this->redirect( $this->createAbsoluteUrl('vendingMachineList',array('mid'=>$mid)));
    		exit();
    	}
    
    }
    
    
    /**
     * 检查操作的加盟商售货机是否属于当前用户
     * @mid
     * Enter description here ...
     */
    private function _checkVendingMachineGoodsNumber($mid){
    	$mid = $mid*1;
    	if( VendingMachineGoods::model()->count(" machine_id={$mid} AND status=".VendingMachineGoods::STATUS_ENABLE)>VendingMachineGoods::MAX_ENABLE_GOODS_NUMBER_PER_MACHINE){
    		$this->setFlash('error',Yii::t('sellerFranchisee', '售货机上架商品数量不能超过 ').VendingMachineGoods::MAX_ENABLE_GOODS_NUMBER_PER_MACHINE);
    		$this->redirect($_SERVER['HTTP_REFERER']);
    		exit();
    	}
    
    }
    

    /**
     * 盖网售货机管理列表
     * @author leo8705
     * Enter description here ...
     */
    public function actionVendingMachineList(){
    	$this->pageTitle = Yii::t('sellerFranchisee','盖网售货机管理列表 - ').$this->pageTitle;
    	$this->_check($this->curr_franchisee_id);
    	$model = $this->loadModel($this->curr_franchisee_id);

    	$machine_model = new VendingMachine('search');
    	$machine_model->unsetAttributes();  // clear any default values
    	$machine_model->franchisee_id = $this->curr_franchisee_id;
    	 
    
    	$lists = $machine_model->search();
    	$machine_data = $lists->getData();
    	$pager = $lists->pagination;
    
    	$this->render('vendingMachineList', array(
    			'model' => $model,
    			'machine_model' => $machine_model,
    			'machine_data'=>$machine_data,
    			'pager'=>$pager,
    	));
    }
    
    
    /**
     * 禁用Vending机器
     * @author leo8705
     * Enter description here ...
     * @param unknown_type $id
     */
    public function actionVendingMachineStop($id){
    	$this->_checkVendingMachine($id);
    	$model = $this->loadModel($this->curr_franchisee_id);
    	 
    	$machine_model = VendingMachine::model()->find("franchisee_id={$this->curr_franchisee_id} AND id={$id}");
    	$machine_model->status = VendingMachine::STATUS_DISABLE;
    	$machine_model->save();
    	 
    	$this->setFlash('success',Yii::t('sellerFranchisee', '设置成功'));
    	$this->redirect($_SERVER['HTTP_REFERER']);
    }
    
    
    /**
     * 启用Vending机器
     * @author leo8705
     * Enter description here ...
     * @param unknown_type $id
     */
    public function actionVendingMachineRun($id){
    	$this->_checkVendingMachine($id);
    	$model = $this->loadModel($this->curr_franchisee_id);
    	 
    	$machine_model = VendingMachine::model()->find("franchisee_id={$this->curr_franchisee_id} AND id={$id}");
    	$machine_model->status = VendingMachine::STATUS_ENABLE;
    	$machine_model->save();
    	 
    	$this->setFlash('success',Yii::t('sellerFranchisee', '设置成功'));
    	$this->redirect($_SERVER['HTTP_REFERER']);
    }
    
    
    
    
    /**
     * 盖网售货机商品管理列表
     * @author leo8705
     * Enter description here ...
     */
    public function actionVendingMachineGoodsList(){
    	$mid = $this->getParam('mid')*1;
    	$this->_checkVendingMachine($mid);
    	
    	$this->pageTitle = Yii::t('sellerFranchisee','盖网售货机商品列表 - ').$this->pageTitle;
    	$this->_check($this->curr_franchisee_id);
    	$model = $this->loadModel($this->curr_franchisee_id);
    	
    	$machine_model = VendingMachine::model()->findByPk( $this->getParam('mid')*1);
    
    	$machine_goods_model = new VendingMachineGoods('search');
    	$machine_goods_model->unsetAttributes();  // clear any default values
    	$machine_goods_model->machine_id = $machine_model->id;
    	
    	$lists = $machine_goods_model->searchDetailsV2();
    	$machine_goods_data = $lists->getData();
    	$pager = $lists->pagination;
    
    	$this->render('vendingMachineGoodsList', array(
    			'model' => $model,
    			'machine_model'=>$machine_model,
    			'machine_goods_model' => $machine_goods_model,
    			'machine_goods_data'=>$machine_goods_data,
    			'pager'=>$pager,
    	));
    }
    
    
    /**
     * 盖网售货机商品添加
     * @author leo8705
     * Enter description here ...
     */
    public function actionVendingMachineGoodsAdd(){
    	$mid = $this->getParam('mid')*1;
    	$this->_checkVendingMachine($mid);
    	$this->_checkVendingMachineGoodsNumber($mid);
    	
    	$this->pageTitle = Yii::t('sellerFranchisee','添加售货机商品 - ').$this->pageTitle;
        $model =  new VendingMachineGoods;
        $model->scenario = 'createV2';
        $this->performAjaxValidation($model);
       
	    	if (isset($_POST['VendingMachineGoods'])) {
	            $model->attributes = $this->getPost('VendingMachineGoods');
	            $model->machine_id = $mid;
				$model->create_time = time();
				
				
				//检查用户名
				$check_rs = Yii::app()->db->createCommand()
				->select('id')
				->from(VendingMachineGoods::tableName())
				->where('name=:name AND machine_id=:machine_id ', array(':name' => $model->name,':machine_id' => $model->machine_id))
				->queryRow();
				if (!empty($check_rs)) {
					$this->setFlash('error',Yii::t('vendingMachine', '售货机商品名已存在'));
					$this->redirect( $this->createAbsoluteUrl('vendingMachineGoodsList',array('mid'=>$model->machine_id)));
				}
				
// 				//检查是否已有同样的商品
// 				if (VendingMachineGoods::checkGoods($mid,$model->goods_id)) {
// 					$this->setFlash('error',Yii::t('sellerFranchisee', '商品重复，不允许添加相同商品！'));
// 		    		$this->redirect( $this->createAbsoluteUrl('vendingMachineGoodsList',array('mid'=>$mid)));
// 		    		exit();
// 				}
	            
	            if ($model->mySave($this->user->id)){
	            	//保存操作记录
	        		$this->_saveLog(SellerLog::CAT_BIZ,SellerLog::logTypeInsert);
	            	$this->setFlash('success',Yii::t('sellerFranchisee', '售货机商品添加成功'));
	            }
	                
	            $this->redirect( $this->createAbsoluteUrl('vendingMachineGoodsList',array('mid'=>$mid))); 
	        }

        $this->render('vendingMachineGoodsAdd', array(
            'model' => $model,
        	'mid'=>$mid,
        ));
    }
    
    /**
     * 盖网售货机商品修改
     * @author leo8705
     * Enter description here ...
     */
    public function actionVendingMachineGoodsEdit($id){
    	$this->pageTitle = Yii::t('sellerFranchisee','添加售货机商品 - ').$this->pageTitle;
    	$model =  VendingMachineGoods::model()->findByPk($id);
    	$model->scenario = 'updateV2';
    	$this->performAjaxValidation($model);
    	$this->_checkVendingMachine($model->machine_id);
    	$oldStatus = $model->status;
    	
    	if (isset($_POST['VendingMachineGoods'])) {
    		$oldThumbnail = $model->thumb;
    		$model->attributes = $this->getPost('VendingMachineGoods');
    		
    		//检查用户名
    		$check_rs = Yii::app()->db->createCommand()
    		->select('id')
    		->from(VendingMachineGoods::tableName())
    		->where('name=:name AND machine_id=:machine_id AND id!=:id', array(':name' => $model->name,':machine_id' => $model->machine_id,':id' => $model->id))
    		->queryRow();
    		if (!empty($check_rs)) {
    			$this->setFlash('error',Yii::t('vendingMachine', '售货机商品名已存在'));
    			$this->redirect( $this->createAbsoluteUrl('vendingMachineGoodsList',array('mid'=>$model->machine_id)));
    		}
    		
    		
    		//检查上架商品数
    		if ($oldStatus==VendingMachineGoods::STATUS_DISABLE && $model->status==VendingMachineGoods::STATUS_ENABLE) {
    			$this->_checkVendingMachineGoodsNumber($model->machine_id);
    		}
    		
    		//删除旧缩略图
    		if ($oldThumbnail != $model->thumb) {
    			@UploadedFile::delete(Yii::getPathOfAlias('uploads') . '/' . $oldThumbnail);
    		}

    		if ($model->save()){
    			//保存操作记录
    			$this->_saveLog(SellerLog::CAT_BIZ,SellerLog::logTypeUpdate);
    			$this->setFlash('success',Yii::t('sellerFranchisee', '售货机商品更新成功'));
    		}
    		 
    		$this->redirect( $this->createAbsoluteUrl('vendingMachineGoodsList',array('mid'=>$model->machine_id)));
    	}
    
    	$this->render('vendingMachineGoodsEdit', array(
    			'model' => $model,
    	));
    }
    
    
    /**
     * 下架售货机商品
     * @author leo8705
     * Enter description here ...
     * @param unknown_type $id
     */
    public function actionVendingMachineGoodsDisable($id){
    	$model =  VendingMachineGoods::model()->findByPk($id);
    	$this->_checkVendingMachine($model->machine_id);
    
    	$model->scenario = 'updateStatus';
    	$model->status = VendingMachineGoods::STATUS_DISABLE;
    	$model->save();
    	
    	//保存操作记录
    	$this->_saveLog(SellerLog::CAT_BIZ,SellerLog::logTypeUpdate);
    	$this->setFlash('success',Yii::t('sellerFranchisee', '设置成功'));
    	$this->redirect($_SERVER['HTTP_REFERER']);
    }
    
    
    /**
     * 启用售货机商品
     * @author leo8705
     * Enter description here ...
     * @param unknown_type $id
     */
    public function actionVendingMachineGoodsEnable($id){
    	$model =  VendingMachineGoods::model()->findByPk($id);
    	$this->_checkVendingMachine($model->machine_id);
    	$this->_checkVendingMachineGoodsNumber($model->machine_id);
    
    	$model->scenario = 'updateStatus';
    	$model->status = VendingMachineGoods::STATUS_ENABLE;
    	$model->save();
    	
    	//保存操作记录
    	$this->_saveLog(SellerLog::CAT_BIZ,SellerLog::logTypeUpdate);
    	$this->setFlash('success',Yii::t('sellerFranchisee', '设置成功'));
    	$this->redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * 售货机商品入库
     * @author leo8705
     * Enter description here ...
     * @param unknown_type $id
     */
    public function actionVendingMachineGoodsStockIn($id){
    	$this->pageTitle = Yii::t('sellerFranchisee','售货机商品入库 - ').$this->pageTitle;
    	$model =  VendingMachineGoods::findDetailById($id);
    	if (!$model) {
    		$this->setFlash('success',Yii::t('sellerFranchisee', '商品不存在！'));
    		$this->redirect($_SERVER['HTTP_REFERER']);
    		exit();
    	}
    	$model->scenario = 'stockIn';
    	$this->performAjaxValidation($model);
    	$this->_checkVendingMachine($model->machine_id);
    	
    	if (isset($_POST['VendingMachineGoods'])) {
    		$stock_num = $_POST['VendingMachineGoods']['stock_num']*1;

    		if ($model->stockIn($stock_num,$this->user->id)){
    			//保存操作记录
    			$this->_saveLog(SellerLog::CAT_BIZ,SellerLog::logTypeUpdate);
    			$this->setFlash('success',Yii::t('sellerFranchisee', '售货机商品入库成功'));
    		}
    		 
    		$this->redirect( $this->createAbsoluteUrl('vendingMachineGoodsList',array('mid'=>$model->machine_id)));
    	}
    
    	$this->render('vendingMachineGoodsStockIn', array(
    			'model' => $model,
    	));
    }
    
    /**
     * 售货机商品入库
     * @author leo8705
     * Enter description here ...
     * @param unknown_type $id
     */
    public function actionVendingMachineGoodsStockOut($id){
    	$this->pageTitle = Yii::t('sellerFranchisee','售货机商品入库 - ').$this->pageTitle;
    	$model =  VendingMachineGoods::findDetailById($id);
    	if (!$model) {
    		$this->setFlash('success',Yii::t('sellerFranchisee', '商品不存在！'));
    		$this->redirect($_SERVER['HTTP_REFERER']);
    		exit();
    	}
    	$model->scenario = 'stockOut';
    	$this->performAjaxValidation($model);
    	$this->_checkVendingMachine($model->machine_id);
    	
    	if (isset($_POST['VendingMachineGoods'])) {
    		$stock_num = $_POST['VendingMachineGoods']['stock_num']*1;
    		if ($model->stockOut($stock_num,$this->user->id)){
    			//保存操作记录
    			$this->_saveLog(SellerLog::CAT_BIZ,SellerLog::logTypeUpdate);
    			$this->setFlash('success',Yii::t('sellerFranchisee', '售货机商品出库成功'));
    		}
    		 
    		$this->redirect( $this->createAbsoluteUrl('vendingMachineGoodsList',array('mid'=>$model->machine_id)));
    	}
    
    	$this->render('vendingMachineGoodsStockOut', array(
    			'model' => $model,
    	));
    }
    
    
    /**
     * 盖网售货机商品库存流水
     * @author leo8705
     * Enter description here ...
     */
    public function actionVendingMachineGoodsStockBalance($mid,$id=0){
    	$this->pageTitle = Yii::t('sellerFranchisee','售货机商品库存流水 - ').$this->pageTitle;
    	$mid = $mid*1;
    	$this->_checkVendingMachine($mid);
    	
    	$model =  VendingMachine::model()->findByPk($mid);

    	$balance_model = new VendingMachineStockBalance('search');
    	$balance_model->unsetAttributes();  // clear any default values
    	$balance_model->machine_id = $mid;
    	$no_search = false;
    	if (!empty($id)){
    		$balance_model->goods_id = $id*1;
    		$no_search = true;
    	}

        if (isset($_GET['VendingMachineStockBalance'])) {
            $balance_model->attributes = $this->getQuery('VendingMachineStockBalance');
        }

    	$lists = $balance_model->searchBalance();
    	$lists->setPagination(array('pageSize'=>30));
    	$balance_data = $lists->getData();
    	$pager = $lists->pagination;

    	$this->render('vendingMachineGoodsStockBalance', array(
    			'model' => $model,
    			'balance_model' => $balance_model,
    			'balance_data'=>$balance_data,
    			'pager'=>$pager,
    			'no_search'=>$no_search,
    	));
    }
    /**
     * 盖网售货机商品库存流水 导出Excel
     */
    public function actionExcel($mid,$id=null){
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
//         date_default_timezone_set('Europe/London');

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');

        Yii::import('comext.PHPExcel.*');

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()
            ->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

        $model =  VendingMachine::model()->findByPk($mid);


        $criteria=new CDbCriteria;

        $criteria->compare('t.machine_id',$mid);
		if (!empty($id)) $criteria->compare('t.goods_id',$id);
		
        //具体到商品
        if(isset($_GET['VendingMachineStockBalance']) && !empty($_GET['VendingMachineStockBalance']['g_name'])){
            $criteria->compare('vg.name',$_GET['VendingMachineStockBalance']['g_name'],true);
        }

        $criteria->select = 't.*, vg.name as name, vg.price as g_price, vg.status as status';
        $criteria->join = ' LEFT JOIN  '.VendingMachineGoods::model()->tableName().' as vg ON t.goods_id=vg.id ';
        $criteria->order = 't.create_time DESC';
        $criteria->group = 't.id';



        $log = VendingMachineStockBalance::model()->findAll($criteria);

        //输出表头
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '日期')
            ->setCellValue('B1', '商品名称')
            ->setCellValue('C1', '售价')
            ->setCellValue('D1', '状态')
            ->setCellValue('E1', '节点')
            ->setCellValue('F1', '节点类型')
            ->setCellValue('G1', '数量')
            ->setCellValue('H1', '结余');

        $num = 1;
        foreach ($log as $key => $row) {
            $num++;

            if($row->status == VendingMachineGoods::STATUS_ENABLE){
                $status='上架';
            } else {
                $status='下架';
            }

            //显式指定内容类型
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $num,  date('Y-m-d G:i:s', $row->create_time))
                ->setCellValue('B' . $num, ''.$row->name)
                ->setCellValue('C' . $num, '￥'.$row->g_price)
                ->setCellValue('D' . $num, $status)
                ->setCellValue('E' . $num, VendingMachineStockBalance::getNode($row->node))
                ->setCellValue('F' . $num, VendingMachineStockBalance::getNodeType($row->node_type))
                ->setCellValue('G' . $num, $row->num)
                ->setCellValue('H' . $num, $row->balance);
        }


        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle($model->name."盖网售货机商品库存流水");

        $name = date('YmdHis' . rand(0, 99999));
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

}
