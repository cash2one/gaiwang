<?php

class FranchiseeAgentController extends Controller
{
	/**
     * 设置当前所在的menu
     */
   protected function setCurMenu($name)
   {
   		$this->curMenu = Yii::t('main', '加盟商管理');
   } 

	/**
	 * 入口文件
	 */
	public function actionAdmin()
	{
		$this->pageTitle = Yii::t('franchisee', '加盟商列表');
		$model=new FranchiseeAgent('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FranchiseeAgent']))
			$model->attributes=  $this->getQuery('FranchiseeAgent');

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/**
	 * 加盟商列表查看
	 * 这个貌似是没有使用到了
	 */
	public function actionUpdateConfirm(){
		die;
//		$model = $this->loadModel($_GET['id']);
		$sql = "select t.*,m.gai_number from ".FranchiseeAgent::model()->tableName()." t 
		left join ".Member::model()->tableName()." m on m.id = t.member_id
		where t.id = ".$_GET['id']." and m.referrals_id = ".Yii::app()->user->id;
		$model = FranchiseeAgent::model()->findBySql($sql);
		
		if (!$model){
			throw new CHttpException(404,"没有找到指定加盟商或你没有权限");
		}
       
		//获取图片信息
		$franchiseePicTableName = FranchiseePicture::model()->tableName();
		$sql = "select group_concat(path separator '|') as path from $franchiseePicTableName where franchisee_id = '".$model->id."'";
		$pathArr = Yii::app()->db->createCommand($sql)->queryRow();
		$model->path = $pathArr['path'];
		$member_id = $model->member_id;					//先保存，后面重新赋值
        $model->member_id = $model->gai_number;			//这里直接改变值是为了显示和验证，在保存的时候会进行转化成id
		
		//所属会员盖网编号
//		$sql = "select gai_number from ".Member::model()->tableName()." where id = ".$model->member_id." limit 1";
//        $member = Yii::app()->db->createCommand($sql)->queryRow();
//        $model->gai_number = $member['gai_number'];
//        $model->member_id = $member['gai_number'];
		
        $selfTable = FranchiseeAgent::model()->tableName();
        $sqlF = "select name from $selfTable where id = " . $model->parent_id . " limit 1";
        $parentArr = Yii::app()->db->createCommand($sqlF)->queryRow();
        $model->parentname = $parentArr['name'];
		 
		$this->performAjaxValidation($model);

		if(isset($_POST['FranchiseeAgent'])){
			$isBase = false;			//基本
			$isKey = false;				//关键
			$keyArr = array('name','alias_name','parent_id','max_machine','gai_discount','member_discount');		//关键信息
			foreach ($_POST['FranchiseeAgent'] as $key=>$val){			//判断是更改了基本信息还是关键信息
				if($model->$key!=$val){
					if (in_array($key, $keyArr)){
						$isKey = true;
					}else{
						$isBase = true;
					}
				}
			}
			
			$model->attributes=$_POST['FranchiseeAgent'];
			if($model->validate()){		//如果验证通过了
				$staus = isset($_POST['wait'])?Auditing::STATUS_WAIT:Auditing::STATUS_APPLY;		//状态不是"审核"就是"暂存"
				$id = $model->id;
				$name = $model->name;
				$dataArr = array();
				$unsetArr = array('id','create_time','update_time','password','salt','author_id','author_name','create_ip','update_ip','status','background','banner','country_id','code');
				foreach ($model->attributes as $key=>$val){		//这里面没有图片信息
					if (in_array($key, $unsetArr))continue;					//如果是不保存的字段就直接进行下一次循环
					$dataArr[$key] = $val;
				}
				$dataArr['member_id'] = $member_id;
				$dataArr['gai_number'] = $model->gai_number;
				
				$dataArr['path'] = $_POST['FranchiseeAgent']['path'];
				if ($isBase){		//新增基本的信息
					$baseModel = new Auditing();
					$baseModel->apply_id = $id;
					$baseModel->apply_name = $name;
					$baseModel->apply_type = Auditing::APPLY_TYPE_BIZ_BASE;	
		            $baseModel->author_type = Auditing::AUTHOR_TYPE_AGENT;
					$baseModel->apply_content = CJSON::encode($dataArr);
					$baseModel->status = $staus;
					$baseModel->save(false);
				}
				
				if ($isKey){		//新增关键的信息
					$keyModel = new Auditing();
					$keyModel->apply_id = $id;
					$keyModel->apply_name = $name;
					$keyModel->apply_type = Auditing::APPLY_TYPE_BIZ_GUANJIAN;					
		            $keyModel->author_type = Auditing::AUTHOR_TYPE_AGENT;
					$keyModel->apply_content = CJSON::encode($dataArr);
					$keyModel->status = $staus;		
					$keyModel->save(false);
				}
				
				if($staus==Auditing::STATUS_WAIT){
					$this->redirect(array('applyList'));
				}else{
					$this->redirect(array('auditList'));
				}
			}
		}
		
		$this->breadcrumbs = array('代理管理系统','申请添加加盟商');
		
		$this->render('updateconfirm',array(
				'model' => $model,
			)
		);
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * 申请添加加盟商
	 */
	public function actionCreate()
	{
		die;
		$model = new Auditing('create');
		$model->unsetAttributes();
		$this->performAjaxValidation($model);
		if(isset($_POST['Auditing']))
		{
			$model->attributes=$_POST['Auditing'];
			$dataArr = array(
				'password' => $_POST['Auditing']['password'],
				'password2' => $_POST['Auditing']['password2'],
				'alias_name' => $_POST['Auditing']['alias_name'],
				'parent_id' => $_POST['Auditing']['parent_id'],
				'max_machine' => $_POST['Auditing']['max_machine'],
				'gai_discount' => $_POST['Auditing']['gai_discount'],
				'member_discount' => $_POST['Auditing']['member_discount'],
				'province_id' => $_POST['Auditing']['province_id'],
				'city_id' => $_POST['Auditing']['city_id'],
				'district_id' => $_POST['Auditing']['district_id'],
				'street' => $_POST['Auditing']['street'],
				'lat' => $_POST['Auditing']['lat'],
				'lng' => $_POST['Auditing']['lng'],
				'summary' => $_POST['Auditing']['summary'],
				'main_course' => $_POST['Auditing']['main_course'],
				'category_id' => $_POST['Auditing']['category_id'],
				'logo' => $_POST['Auditing']['logo'],
				'path' => $_POST['Auditing']['path'],
				'mobile' => $_POST['Auditing']['mobile'],
				'qq' => $_POST['Auditing']['qq'],
				'url' => $_POST['Auditing']['url'],
				'keywords' => $_POST['Auditing']['keywords'],
				'fax' => $_POST['Auditing']['fax'],
				'zip_code' => $_POST['Auditing']['zip_code'],
				'notice' => $_POST['Auditing']['notice'],
				'description' => $_POST['Auditing']['description'],
				'parentname' => $_POST['Auditing']['parentname'],
				'gai_number' => $_POST['Auditing']['member_id'],
			);
			$sql = "select id from ".Member::model()->tableName()." where gai_number = '".$_POST['Auditing']['member_id']."' limit 1";
            $member = Yii::app()->db->createCommand($sql)->queryRow();
            $dataArr['member_id'] = $member['id'];
            $model->apply_id = 0;		//申请加盟商的时候为0
	            
			$model->apply_content = CJSON::encode($dataArr);
			$model->status = isset($_POST['wait'])?Auditing::STATUS_WAIT:Auditing::STATUS_APPLY;		//状态不是"审核"就是"暂存"
			$model->apply_type = Auditing::APPLY_TYPE_BIZ_ADD;				//申请类型为		"添加加盟商"
            $model->author_type = Auditing::AUTHOR_TYPE_AGENT;				//添加加盟商申请的人类型		"加盟商"
            $model->author_id = Yii::app()->user->id;
			if($model->save()){
				if ($model->status == Auditing::STATUS_WAIT){
					$this->redirect(array('applyList'));
				}else if ($model->status == Auditing::STATUS_APPLY){
					$this->redirect(array('auditList'));
				}else{
					$this->redirect(array('admin'));
				}
			}
		}
		
		$this->breadcrumbs = array(Yii::t('Franchisee','代理管理系统'),Yii::t('Franchisee','申请添加加盟商'));

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	/**
	 * 重新编辑
	 * 在申请列表里面查询出来审核为通过的信息如果要重新编辑，先将状态改变然后再编辑
	 */
	public function actionReUpdate(){
		die;
		Auditing::model()->updateByPk($_GET['id'], array("status"=>Auditing::STATUS_WAIT));
		
		$url = Yii::app()->createUrl('franchiseeAgent/update',array('id'=>$_GET['id']));
		$this->redirect($url);
	}
	
	/**
	 * 申请状态列表里面查看加盟商(也有审核不通过查看加盟商)
	 */
	public function actionUpdate(){
		die;
		$model = Auditing::model()->findByAttributes(array('id'=>$_GET['id'],'author_id'=>Yii::app()->user->id));
		
		if ($model){
			if ($model->status != Auditing::STATUS_WAIT)// && $model->status != Auditing::STATUS_NOPASS
			throw new CHttpException(404,"没有找到指定加盟商或你没有权限");
		}else 
			throw new CHttpException(404,"没有找到指定加盟商或你没有权限");
		
		if ($model->apply_type==Auditing::APPLY_TYPE_BIZ_BASE){				//基本信息
			$this->breadcrumbs = array('代理管理系统','加盟商基本信息');
			$dataArr = CJSON::decode($model->apply_content);
			$model->attributes = $dataArr;
			$model->path = $dataArr['path'];
			$model->setScenario('base');
			$this->performAjaxValidation($model);
			
			if(isset($_POST['Auditing'])){
				$isSave = false;
				foreach ($_POST['Auditing'] as $key=>$val){
					if($model->$key!=$val){
						$isSave = true;
						break;
					}
				}
				if ($isSave|isset($_POST['apply'])){		//如果有数据改变或者是状态改为申请，因为只有暂存状态才能进入这里
					$model->attributes=$_POST['Auditing'];
					$dataArr['province_id'] = isset($_POST['Auditing']['province_id'])?$_POST['Auditing']['province_id']:$dataArr['province_id'];
					$dataArr['city_id'] = isset($_POST['Auditing']['city_id'])?$_POST['Auditing']['city_id']:$dataArr['city_id'];
					$dataArr['district_id'] = isset($_POST['Auditing']['district_id'])?$_POST['Auditing']['district_id']:$dataArr['district_id'];
					$dataArr['street'] = isset($_POST['Auditing']['street'])?$_POST['Auditing']['street']:$dataArr['street'];
					$dataArr['lat'] = isset($_POST['Auditing']['lat'])?$_POST['Auditing']['lat']:$dataArr['lat'];
					$dataArr['lng'] = isset($_POST['Auditing']['lng'])?$_POST['Auditing']['lng']:$dataArr['lng'];
					$dataArr['summary'] = isset($_POST['Auditing']['summary'])?$_POST['Auditing']['summary']:$dataArr['summary'];
					$dataArr['main_course'] = isset($_POST['Auditing']['main_course'])?$_POST['Auditing']['main_course']:$dataArr['main_course'];
					$dataArr['category_id'] = isset($_POST['Auditing']['category_id'])?$_POST['Auditing']['category_id']:$dataArr['category_id'];
					$dataArr['logo'] = isset($_POST['Auditing']['logo'])?$_POST['Auditing']['logo']:$dataArr['logo'];
					$dataArr['path'] = isset($_POST['Auditing']['path'])?$_POST['Auditing']['path']:$dataArr['path'];
					$dataArr['mobile'] = isset($_POST['Auditing']['mobile'])?$_POST['Auditing']['mobile']:$dataArr['mobile'];
					$dataArr['qq'] = isset($_POST['Auditing']['qq'])?$_POST['Auditing']['qq']:$dataArr['qq'];
					$dataArr['url'] = isset($_POST['Auditing']['url'])?$_POST['Auditing']['url']:$dataArr['url'];
					$dataArr['keywords'] = isset($_POST['Auditing']['keywords'])?$_POST['Auditing']['keywords']:$dataArr['keywords'];
					$dataArr['fax'] = isset($_POST['Auditing']['fax'])?$_POST['Auditing']['fax']:$dataArr['fax'];
					$dataArr['zip_code'] = isset($_POST['Auditing']['zip_code'])?$_POST['Auditing']['zip_code']:$dataArr['zip_code'];
					$dataArr['notice'] = isset($_POST['Auditing']['notice'])?$_POST['Auditing']['notice']:$dataArr['notice'];
					$dataArr['description'] = isset($_POST['Auditing']['description'])?$_POST['Auditing']['description']:$dataArr['description'];
	            
					$model->apply_content = CJSON::encode($dataArr);
					$model->status = isset($_POST['wait'])?Auditing::STATUS_WAIT:Auditing::STATUS_APPLY;				//状态不是"申请"就是"暂存"
					if($model->save()){
						$this->redirect(array('applyList'));
					}
				}else{
					$this->redirect(array('applyList'));
				}
			}
		}else if($model->apply_type==Auditing::APPLY_TYPE_BIZ_GUANJIAN){	//关键信息
			$this->breadcrumbs = array(Yii::t('Franchisee','代理管理系统'),Yii::t('Franchisee','加盟商关键信息'));
			$dataArr = CJSON::decode($model->apply_content);
			$model->attributes = $dataArr;
			$model->parentname = $dataArr['parentname'];
			$model->setScenario('key');
			
			$this->performAjaxValidation($model);
			
			if(isset($_POST['Auditing'])){
				$isSave = false;
				foreach ($_POST['Auditing'] as $key=>$val){
					if($model->$key!=$val){
						$isSave = true;
						break;
					}
				}
				if ($isSave|isset($_POST['apply'])){		//如果有数据改变或者是状态改为申请，因为只有暂存状态才能进入这里
					$sql = "select id from ".Member::model()->tableName()." where gai_number = '".$_POST['Auditing']['member_id']."' limit 1";
		            $member = Yii::app()->db->createCommand($sql)->queryRow();
//		            $model->apply_id = $member['id'];
		            
					$model->attributes=$_POST['Auditing'];
//					$dataArr['name'] = isset($_POST['Auditing']['name'])?$_POST['Auditing']['name']:$dataArr['name'];
					$dataArr['alias_name'] = isset($_POST['Auditing']['alias_name'])?$_POST['Auditing']['alias_name']:$dataArr['alias_name'];
					$dataArr['parent_id'] = isset($_POST['Auditing']['parent_id'])?$_POST['Auditing']['parent_id']:$dataArr['parent_id'];
					$dataArr['parentname'] = isset($_POST['Auditing']['parentname'])?$_POST['Auditing']['parentname']:$dataArr['parentname'];
					$dataArr['max_machine'] = isset($_POST['Auditing']['max_machine'])?$_POST['Auditing']['max_machine']:$dataArr['max_machine'];
					$dataArr['gai_discount'] = isset($_POST['Auditing']['gai_discount'])?$_POST['Auditing']['gai_discount']:$dataArr['gai_discount'];
					$dataArr['member_discount'] = isset($_POST['Auditing']['member_discount'])?$_POST['Auditing']['member_discount']:$dataArr['member_discount'];
					$dataArr['gai_number'] =  isset($_POST['Auditing']['member_id'])?$_POST['Auditing']['member_id']:$dataArr['gai_number'];
					$dataArr['member_id'] = $member['id'];
					
					$model->apply_content = CJSON::encode($dataArr);
					$model->status = isset($_POST['wait'])?Auditing::STATUS_WAIT:Auditing::STATUS_APPLY;				//状态不是"申请"就是"暂存"
					if($model->save()){
						if ($model->status==Auditing::STATUS_WAIT){
							Yii::app()->user->setState($this->params('msgSessionKey'),array('img'=>'succeed','content'=>'暂存数据成功!'));
						}else{
							Yii::app()->user->setState($this->params('msgSessionKey'),array('img'=>'succeed','content'=>'提交数据成功!'));
						}
						$this->redirect(array('applyList'));
					}
				}else{
					$this->redirect(array('applyList'));
				}
			}
		}else{																//添加加盟商
			$model->setScenario('create');
			$memberTableName = Member::model()->tableName();	
			$sql = "select gai_number from $memberTableName where id = ".$model->apply_id;
			$memberArr = Yii::app()->db->createCommand($sql)->queryRow();
			
			$dataArr = CJSON::decode($model->apply_content); 			//将JSON数据转化
			$model->attributes = $dataArr;
			$model->password2 = $dataArr['password2'];
			$model->parentname = $dataArr['parentname'];
			$model->path = $dataArr['path'];
			
			$this->performAjaxValidation($model);
			
			if(isset($_POST['Auditing'])){
				$isSave = false;
				foreach ($_POST['Auditing'] as $key=>$val){
					if($model->$key!=$val){
						$isSave = true;
						break;
					}
				}
				if ($isSave|isset($_POST['apply'])){		//如果有数据改变或者是状态改为申请，因为只有暂存状态才能进入这里
					$model->attributes=$_POST['Auditing'];
					$dataArr = array(
						'password' => $_POST['Auditing']['password'],
						'password2' => $_POST['Auditing']['password2'],
						'alias_name' => $_POST['Auditing']['alias_name'],
						'parent_id' => $_POST['Auditing']['parent_id'],
						'max_machine' => $_POST['Auditing']['max_machine'],
						'gai_discount' => $_POST['Auditing']['gai_discount'],
						'member_discount' => $_POST['Auditing']['member_discount'],
						'province_id' => $_POST['Auditing']['province_id'],
						'city_id' => $_POST['Auditing']['city_id'],
						'district_id' => $_POST['Auditing']['district_id'],
						'street' => $_POST['Auditing']['street'],
						'lat' => $_POST['Auditing']['lat'],
						'lng' => $_POST['Auditing']['lng'],
						'summary' => $_POST['Auditing']['summary'],
						'main_course' => $_POST['Auditing']['main_course'],
						'category_id' => $_POST['Auditing']['category_id'],
						'logo' => $_POST['Auditing']['logo'],
						'path' => $_POST['Auditing']['path'],
						'mobile' => $_POST['Auditing']['mobile'],
						'qq' => $_POST['Auditing']['qq'],
						'url' => $_POST['Auditing']['url'],
						'keywords' => $_POST['Auditing']['keywords'],
						'fax' => $_POST['Auditing']['fax'],
						'zip_code' => $_POST['Auditing']['zip_code'],
						'notice' => $_POST['Auditing']['notice'],
						'description' => $_POST['Auditing']['description'],
						'parentname' => $_POST['Auditing']['parentname'],
					);
					
					//将盖网编号转化成盖网id
					$sql = "select id from ".Member::model()->tableName()." where gai_number = '".$_POST['Auditing']['member_id']."' limit 1";
		            $member = Yii::app()->db->createCommand($sql)->queryRow();
		            $model->apply_id = 0;
	            	$dataArr['gai_number'] = $_POST['Auditing']['member_id'];
	            	$dataArr['member_id'] = $member['id'];
					$model->apply_content = CJSON::encode($dataArr);
					$model->status = isset($_POST['wait'])?Auditing::STATUS_WAIT:Auditing::STATUS_APPLY;		//状态不是"申请"就是"暂存"
					if($model->save()){
						$this->redirect(array('applyList'));
					}
				}else{
					$this->redirect(array('applyList'));
				}
			}
		}
		$model->member_id = strpos($model->member_id, 'GW') === false?Auditing::findGWNoById($model->member_id):$model->member_id;
		$this->render('update',array(
			'model' => $model,
		));
	}
	
	/**
	 * 申请列表
	 */
	public function actionApplyList()
	{
		die;
		$model = new Auditing();
		$model->status = Auditing::STATUS_WAIT;
		
		if (isset($_GET['Auditing'])){
			$model->apply_name =$_GET['Auditing']['apply_name'];
		}
		
		$this->render('applyList',array('model'=>$model));
	}
	
	/**
	 * 审核列表
	 */
	public function actionAuditList()
	{
		die;
		$model = new Auditing();
		$model->status = Auditing::STATUS_APPLY;
		
		if (isset($_GET['Auditing'])){
			$model->apply_name =$_GET['Auditing']['apply_name'];
		}
		$this->render('auditList',array('model'=>$model));
	}

	/**
	 * 审核列表取消申请
	 */
	public function actionCancel(){
		die;
		Auditing::model()->updateAll(array('status'=>Auditing::STATUS_WAIT),"id = :id",array(":id"=>$_GET['id']));
		$this->redirect(array('applyList'));
	}
	
	/**
	 * 查看(审核列表，状态为申请)
	 */
	public function actionLook(){
		die;
		$model = Auditing::model()->findByAttributes(array('id'=>$_GET['id'],'author_id'=>Yii::app()->user->id));
		if ($model){
			if ($model->status!=Auditing::STATUS_APPLY&&$model->status!=Auditing::STATUS_NOPASS)
				throw new CHttpException(404,"没有找到指定加盟商或你没有权限");
		}else{
			throw new CHttpException(404,"没有找到指定加盟商或你没有权限");
		}
		
		$dataArr = CJSON::decode($model->apply_content);
		
		//赋值所属会员			apply_id是加盟商id
		if (isset($dataArr['gai_number'])){
			if (!empty($dataArr['gai_number'])){
				$model->gai_number = $dataArr['gai_number'];
        		$model->member_id = $dataArr['gai_number'];
			}else if (isset($dataArr['member_id'])){
				if (!empty($dataArr['member_id'])){
					$sql = "select gai_number from ".Member::model()->tableName()." where id = ".$dataArr['member_id']." limit 1";
			        $member = Yii::app()->db->createCommand($sql)->queryRow();
			        $model->gai_number = $member['gai_number'];
			        $model->member_id = $member['gai_number'];
				}
			}
		}
		
		$model->alias_name = isset($dataArr['alias_name'])?$dataArr['alias_name']:"";
		$model->parent_id = isset($dataArr['parent_id'])?$dataArr['parent_id']:"";
		$model->max_machine = isset($dataArr['max_machine'])?$dataArr['max_machine']:"";
		$model->gai_discount = isset($dataArr['gai_discount'])?$dataArr['gai_discount']:"";
		$model->member_discount = isset($dataArr['member_discount'])?$dataArr['member_discount']:"";
		$model->province_id = isset($dataArr['province_id'])?$dataArr['province_id']:"";
		$model->city_id = isset($dataArr['city_id'])?$dataArr['city_id']:"";
		$model->district_id = isset($dataArr['district_id'])?$dataArr['district_id']:"";
		$model->street = isset($dataArr['street'])?$dataArr['street']:"";
		$model->lat = isset($dataArr['lat'])?$dataArr['lat']:"";
		$model->lng = isset($dataArr['lng'])?$dataArr['lng']:"";
		$model->summary = isset($dataArr['summary'])?$dataArr['summary']:"";
		$model->main_course = isset($dataArr['main_course'])?$dataArr['main_course']:"";
		$model->category_id = isset($dataArr['category_id'])?$dataArr['category_id']:"";
		$model->logo = isset($dataArr['logo'])?$dataArr['logo']:"";
		$model->path = isset($dataArr['path'])?$dataArr['path']:"";
		$model->mobile = isset($dataArr['mobile'])?$dataArr['mobile']:"";
		$model->qq = isset($dataArr['qq'])?$dataArr['qq']:"";
		$model->url = isset($dataArr['url'])?$dataArr['url']:"";
		$model->keywords = isset($dataArr['keywords'])?$dataArr['keywords']:"";
		$model->fax = isset($dataArr['fax'])?$dataArr['fax']:"";
		$model->zip_code = isset($dataArr['zip_code'])?$dataArr['zip_code']:"";
		$model->notice = isset($dataArr['notice'])?$dataArr['notice']:"";
		$model->description = isset($dataArr['description'])?$dataArr['description']:"";
		$model->parentname = isset($dataArr['parentname'])?$dataArr['parentname']:"";
		
		if ($model->apply_type==Auditing::APPLY_TYPE_BIZ_ADD|$model->apply_type==Auditing::APPLY_TYPE_BIZ_BASE){		//显示省市区
			$provinceid = $model->province_id;
			$cityid = $model->city_id;
			$districtid = $model->district_id;
			$id = $model->province_id==""?"":$model->province_id;
			if ($id!=""){
				$id.= $model->city_id==""?"":",".$model->city_id;
			}
			if ($id!=""){
				$id.= $model->district_id==""?"":",".$model->district_id;
			}
			if ($id!=""){
				$regionTable = Region::model()->tableName();
				$sql = "select depth,name from $regionTable where id in ($id)";
				$regionArr = Yii::app()->db->createCommand($sql)->queryAll();
				foreach ($regionArr as $row){
					if ($row['depth']=='1')$model->province_id = $row['name'];
					if ($row['depth']=='2')$model->city_id = $row['name'];
					if ($row['depth']=='3')$model->district_id = $row['name'];
				}
			}
		}
		
		if ($model->apply_type==Auditing::APPLY_TYPE_BIZ_ADD|$model->apply_type==Auditing::APPLY_TYPE_BIZ_GUANJIAN){			//根据类型显示加盟商父节点名称
			if ($model->parentname==""&&$model->parent_id!=""){
				$franchiseeTable = Franchisee::model()->tableName();
				$sql = "select name from $franchiseeTable where id = ".$model->parent_id." limit 1";
				$res1 = Yii::app()->db->createCommand($sql)->queryRow();
				$model->parentname = $res1['name'];
			}
		}
		
		$this->render('look',array('model'=>$model));
	}
	
	/**
	 * 加盟商列表里面->基本信息
	 */
	public function actionListUpdateBase(){
		die;
//		$model = $this->loadModel($_GET['id']);
//		
//		//获取会员编号
//		$memberTable = Member::model()->tableName();
//		$sqlmember = "select gai_number from $memberTable where id = " . $model->member_id;
//		$memberArr = Yii::app()->db->createCommand($sqlmember)->queryRow();
////		$member_id = $model->member_id;					//中间暂存变量
//		$model->member_id = $memberArr['gai_number'];
		
		$sql = "select t.*,m.gai_number from ".FranchiseeAgent::model()->tableName()." t 
		left join ".Member::model()->tableName()." m on m.id = t.member_id
		where t.id = ".$_GET['id']." and m.referrals_id = ".Yii::app()->user->id;
		$model = FranchiseeAgent::model()->findBySql($sql);
		
		if (!$model){
			throw new CHttpException(404,"没有找到指定加盟商或你没有权限");
		}
		
		$model->member_id = $model->gai_number;
		
		//获取图片信息
		$franchiseePicTableName = FranchiseePicture::model()->tableName();
		$sqlpath = "select group_concat(path separator '|') as path from $franchiseePicTableName where franchisee_id = '".$model->id."'";
		$pathArr = Yii::app()->db->createCommand($sqlpath)->queryRow();
		$model->path = $pathArr['path'];
		
		$this->performAjaxValidation($model);
		
		if (isset($_POST['FranchiseeAgent'])){	//如果是表单提交
			$isSave = false;
			foreach ($_POST['FranchiseeAgent'] as $key=>$val){
				if($model->$key!=$val){
					$isSave = true;
					break;
				}
			}
			if ($isSave){		//如果有数据改变或者是状态改为申请，因为只有暂存状态才能进入这里
//				$model->member_id = $member_id;				//有一个beforesave事件里面讲这个数据进行了转化
				$isimg = false;	
				$isimg = $model->path != $_POST['FranchiseeAgent']['path'];
				$model->attributes=$_POST['FranchiseeAgent'];
				
				if($model->save()){
					if ($isimg){		//如果修改了图片，那么就先将加盟商的图片给删除，然后再添加
						FranchiseePicture::model()->deleteAll("franchisee_id = ".$model->id);
						$sql = "insert into ".FranchiseePicture::model()->tableName()."(franchisee_id,path) values";
						$sqlVal = "";
						$pathArr = explode("|", $_POST['FranchiseeAgent']['path']);
						foreach ($pathArr as $row){
							$sqlVal.= $sqlVal==""?"(".$model->id.",'".$row."')":",(".$model->id.",'".$row."')";
						}
						if ($sqlVal!=""){
							$sql.= $sqlVal;
							Yii::app()->db->createCommand($sql)->execute();
						}
					}
					
					Yii::app()->user->setState($this->params('msgSessionKey'),array('img'=>'succeed','content'=>'提交加盟商基本信息成功!'));
					$this->redirect(array('admin'));
				}
			}else{
				Yii::app()->user->setState($this->params('msgSessionKey'),array('img'=>'succeed','content'=>'没有数据变更!'));
				$this->redirect(array('admin'));
			}
		}
		
		$this->render('listupdatebase',array(
			'model' => $model,
		));
	}
	
	/**
	 * 加盟商列表里面->关键信息
	 */
	public function actionListUpdateKey(){
		die;
//		$model = $this->loadModel($_GET['id']);
//		
//		//获取会员编号
//		$memberTable = Member::model()->tableName();
//		$sqlmember = "select gai_number from $memberTable where id = " . $model->member_id;
//		$memberArr = Yii::app()->db->createCommand($sqlmember)->queryRow();
//		$member_id = $model->member_id;					//中间暂存变量
//		$gai_number = $memberArr['gai_number'];			//中间变量，用于保存的时候判断是否减少SQL语句查询
//		$model->member_id = $memberArr['gai_number'];
		
		$sql = "select t.*,m.gai_number from ".FranchiseeAgent::model()->tableName()." t 
		left join ".Member::model()->tableName()." m on m.id = t.member_id
		where t.id = ".$_GET['id']." and m.referrals_id = ".Yii::app()->user->id;
		$model = FranchiseeAgent::model()->findBySql($sql);
		
		if (!$model){
			throw new CHttpException(404,"没有找到指定加盟商或你没有权限");
		}
		
		$member_id = $model->member_id;					//中间暂存变量
		$gai_number = $model->gai_number;				//中间变量，用于保存的时候判断是否减少SQL语句查询
		$model->member_id = $model->gai_number;

		//获取父加盟商
		$selfTable = FranchiseeAgent::model()->tableName();
        $sqlF = "select name from $selfTable where id = " . $model->parent_id . " limit 1";
        $parentArr = Yii::app()->db->createCommand($sqlF)->queryRow();
        $model->parentname = $parentArr['name'];
        
        //获取图片信息
		$franchiseePicTableName = FranchiseePicture::model()->tableName();
		$sqlpath = "select group_concat(path separator '|') as path from $franchiseePicTableName where franchisee_id = '".$model->id."'";
		$pathArr = Yii::app()->db->createCommand($sqlpath)->queryRow();
		$model->path = $pathArr['path'];
		
		$this->performAjaxValidation($model);
		
		if (isset($_POST['FranchiseeAgent'])){	//如果是表单提交
			if($model->validate()){
				$model->attributes = $this->getPost('FranchiseeAgent');
				$dataArr = array();
				$unsetArr = array('id','create_time','update_time','password','salt','author_id','author_name','create_ip','update_ip','status','background','banner','country_id','code');
				foreach ($model->attributes as $key=>$val){		//这里面没有图片信息
					if (in_array($key, $unsetArr))continue;					//如果是不保存的字段就直接进行下一次循环
					$dataArr[$key] = $val;
				}
				//如果填写的盖网编号不等于之前就存在的盖网编号，那么就需要进行转化
				if ($gai_number != $_POST['FranchiseeAgent']['member_id']){
					$sql = "select id from ".Member::model()->tableName()." where gai_number = '".$_POST['FranchiseeAgent']['member_id']."' limit 1";
		            $member = Yii::app()->db->createCommand($sql)->queryRow();
		            	
					$dataArr['member_id'] = $member['id'];
					$dataArr['gai_number'] = $_POST['FranchiseeAgent']['member_id'];
				}else{
					$dataArr['member_id'] = $member_id;
					$dataArr['gai_number'] = $gai_number;
				}
				
				$dataArr['parentname'] = $_POST['FranchiseeAgent']['parentname'];
				
				$auditingModel = new Auditing();
				$auditingModel->apply_type = Auditing::APPLY_TYPE_BIZ_GUANJIAN;
				$auditingModel->apply_id = $model->id;
				$auditingModel->apply_name = $_POST['FranchiseeAgent']['name'];
				$auditingModel->apply_content = CJSON::encode($dataArr);
				$auditingModel->author_type = Auditing::AUTHOR_TYPE_AGENT;
				$auditingModel->status = isset($_POST['wait'])?Auditing::STATUS_WAIT:Auditing::STATUS_APPLY;
				
				if($auditingModel->save(false)){
					if ($auditingModel->status==Auditing::STATUS_WAIT){
						Yii::app()->user->setState($this->params('msgSessionKey'),array('img'=>'succeed','content'=>'暂存加盟商关键数据成功!'));
					}else{
						Yii::app()->user->setState($this->params('msgSessionKey'),array('img'=>'succeed','content'=>'提交加盟商关键数据成功!'));
					}
					$this->redirect(array('admin'));
				}else{
					Yii::app()->user->setState($this->params('msgSessionKey'),array('img'=>'error','content'=>'保存失败'));
					$this->redirect(array('admin'));
				}
			}
			Tool::pr($model);
		}
		
		$this->render('listupdatekey',array(
			'model' => $model,
		));
	}
	
	/**
	 * 加盟商管理->加盟商列表->查看
	 */
	public function actionListLook(){
                $id = $this->getQuery('id');
                $referrals_id = Yii::app()->user->id;
		$sql = "select t.*,m.gai_number from ".FranchiseeAgent::model()->tableName()." t 
		left join ".Member::model()->tableName()." m on m.id = t.member_id
		where t.id = :id and m.referrals_id = :referrals_id";
		$model = FranchiseeAgent::model()->findBySql($sql,array(':id'=>$id,':referrals_id'=>$referrals_id));
		
		if (!$model){
			throw new CHttpException(404,"没有找到指定加盟商或你没有权限");
		}
       
		//获取图片信息
		$franchiseePicTableName = FranchiseePicture::model()->tableName();
		$sql = "select group_concat(path separator '|') as path from $franchiseePicTableName where franchisee_id = :franchisee_id";
		$pathArr = Yii::app()->db->createCommand($sql)->bindValue(':franchisee_id', $model->id)->queryRow();
		$model->path = $pathArr['path'];
        $model->member_id = $model->gai_number;			//这里直接改变值是为了显示和验证，在保存的时候会进行转化成id
		
        $selfTable = FranchiseeAgent::model()->tableName();
        $sqlF = "select name from $selfTable where id = :id limit 1";
        $parentArr = Yii::app()->db->createCommand($sqlF)->bindValue(':id', $model->parent_id)->queryRow();
        $model->parentname = $parentArr['name'];
        
		$this->render('listlook',array(
			'model' => $model,
		));
	}
	
	/**
	 * 加盟商管理->审核列表->查看
	 * 进入之后能对之进行审核		现在认为apply_id 使加盟商的id
	 */
	public function actionConfirmBase(){
		die;
		$sql = "select t.* from ".Auditing::model()->tableName()." t  
		where t.id = ".$_GET['id']." 
		and t.status = ".Auditing::STATUS_APPLY." 
		and t.apply_type = ".Auditing::APPLY_TYPE_BIZ_BASE." limit 1";
		$model = Auditing::model()->findBySql($sql);
		
		if (!$model){
			throw new CHttpException(404,"没有找到指定加盟商或你没有权限");
		}
		
		$dataArr = CJSON::decode($model->apply_content);
		$model->attributes = $dataArr;
		$model->path = $dataArr['path'];
		
		$model->setScenario('base');
		
		$this->performAjaxValidation($model);
		if (isset($_POST['Auditing'])){
			$model->auditor_id = Yii::app()->user->id;
				
			$memberTable = Member::model()->tableName();
            $sql = "select gai_number from $memberTable where id = ".Yii::app()->user->id;
            $memberArr = Yii::app()->db->createCommand($sql)->queryRow();
			$model->auditor_name = $memberArr['gai_number'];
				
			$model->audit_time = time();
				
			if ($_POST['status']==Auditing::STATUS_NOPASS){			//如果点击的是不通过，改变状态为不通过，同时记录审核意见
				$model->status = Auditing::STATUS_NOPASS;
				$model->audit_opinion = $_POST['Auditing']['audit_opinion'];
				$model->save();
				Yii::app()->user->setState($this->params('msgSessionKey'),array('img'=>'succeed','content'=>'加盟商基本信息不通过成功!'));
				$this->redirect(array('auditList'));
			}else{
                                $model->attributes = $this->getPost('Auditing');
				$model->status = $_POST['status'];
				
				$dataArr['province_id'] = $_POST['Auditing']['province_id'];
				$dataArr['city_id'] = $_POST['Auditing']['city_id'];
				$dataArr['district_id'] = $_POST['Auditing']['district_id'];
				$dataArr['street'] = $_POST['Auditing']['street'];
				$dataArr['lng'] = $_POST['Auditing']['lng'];
				$dataArr['lat'] = $_POST['Auditing']['lat'];
				$dataArr['summary'] = $_POST['Auditing']['summary'];
				$dataArr['main_course'] = $_POST['Auditing']['main_course'];
				$dataArr['category_id'] = $_POST['Auditing']['category_id'];
				$dataArr['logo'] = $_POST['Auditing']['logo'];
				$dataArr['path'] = $_POST['Auditing']['path'];
				$dataArr['mobile'] = $_POST['Auditing']['mobile'];
				$dataArr['qq'] = $_POST['Auditing']['qq'];
				$dataArr['url'] = $_POST['Auditing']['url'];
				$dataArr['keywords'] = $_POST['Auditing']['keywords'];
				$dataArr['fax'] = $_POST['Auditing']['fax'];
				$dataArr['zip_code'] = $_POST['Auditing']['zip_code'];
				$dataArr['notice'] = $_POST['Auditing']['notice'];
				$dataArr['description'] = $_POST['Auditing']['description'];
				$model->apply_content = CJSON::encode($dataArr);
				if ($model->save()){
					$franchiseeModel = Franchisee::model()->findByPk($model->apply_id);			//修改的对应加盟商的信息
					if (!$franchiseeModel){
						throw new CHttpException(404,"数据错误");
					}
					$franchiseeModel->attributes = $_POST['Auditing'];
					$franchiseeModel->save(false);
					
					if ($model->path!=$_POST['Auditing']['path']){			//修改图片
						FranchiseePicture::model()->deleteAll("franchisee_id = ".$model->apply_id);
						$sqlimg = "insert into ".FranchiseePicture::model()->tableName()."(franchisee_id,path) values";
						$sqlVal = "";
						$pathArr = explode("|", $_POST['Auditing']['path']);
						foreach ($pathArr as $row){
							$sqlVal.= $sqlVal==""?"(".$model->apply_id.",'".$row."')":",(".$model->id.",'".$row."')";
						}
						if ($sqlVal!=""){
							$sqlimg.= $sqlVal;
							Yii::app()->db->createCommand($sqlimg)->execute();
						}
					}
					Yii::app()->user->setState($this->params('msgSessionKey'),array('img'=>'succeed','content'=>'加盟商基本信息修改后通过成功!'));
					$this->redirect(array('auditList'));
				}
			}
		}
		
		$this->render('confirmbase',array(
			'model' => $model
		));
		
	}
}
