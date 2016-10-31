<?php

class FranchiseeContractController extends Controller
{

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'rights',
		);
	}

	/**
     * 不作权限控制的action  
     * @return string
     */
    public function allowedActions() {
        return 'admin,checkGwNumber,getContractVersion';
    }

	 /**
     * 协议相关商户列表
     */
    public function actionListAgreement() {
        $model = new FranchiseeContract('search');
        $model->unsetAttributes();
        if (isset($_GET['FranchiseeContract']))
            $model->attributes = $this->getParam('FranchiseeContract');
        $this->showExport = true;
        $this->exportAction = 'adminExport';
        // $res = $model->search();
        $totalCount = $model->search()->getTotalItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = 'franchisee-contract/admin-export';
        $exportPage->params = array_merge(array('grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;
        $this->render('list', array(
            'model' => $model,
            'exportPage' => $exportPage,
            'totalCount' => $totalCount,
        ));
    }

    /**
     * 补充协议导出操作
     */
    public function actionAdminExport() {
        $model = new FranchiseeContract('search');
        $model->unsetAttributes();
        if (isset($_GET['FranchiseeContract']))
            $model->attributes = $this->getParam('FranchiseeContract');
        SystemLog::record($this->getUser()->name . "导出补充协议相关用户列表");
        $model->isExport = 1;
        $this->render('adminexport', array(
            'model' => $model,
        ));
    }

    /**
     * 验证gw号是否存在
     */
    public function actionCheckGwNumber(){
    	$gwNumber = $this->getParam('gwNumber');
    	$gwNumber = trim($gwNumber);
    	if(!$gwNumber)  return $this->returnJson(101,'gwNumber错误');

    	$member = Member::model()->find("gai_number = :gai_number ",array(":gai_number"=>$gwNumber));
    	if($member){
    		$data = $member->getAttributes(array('username','gai_number','id'));
    		return $this->returnJson(200,'ok',  $data);
    	} 
    	return $this->returnJson(102,'不存在');
    }


	public function returnJson($status,$msg='',$data=array()){
		echo json_encode(array('status'=>$status,'msg'=>$msg,'data'=>$data) );
		die;
	}

    /**
     * 二级级联动之获取补充协议版本号 
     */
    public function actionGetContractVersion() {
        if ($this->isAjax()) {
            $type = $_GET['type'];
            $versions = Contract::model()->findAll(array(
                'select' => 'id, version',
                'condition' => 'type=:type AND status=:status AND is_current=:is_current ',
                'params' => array(
                	':type'   => $type,
                	':status' => Contract::CONTRACT_STATUS_OK,
                	':is_current' => Contract::CONTRACT_IS_CURRENT,
                	)
                ));
            $versions = CHtml::listData($versions, 'id', 'version');
            $dropDownVersions = "<option value=''>" . Yii::t('Franchiseecontract', '选择版本') . "</option>";
            if (!empty($versions)) {
                foreach ($versions as $id => $version)
                    $dropDownVersions .= CHtml::tag('option', array('value' => $version,'data-contract-id'=>$id), $version, true);
            }
            echo CJSON::encode(array(
                'dropDownVersions' => $dropDownVersions,
            ));
        }
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id){
		
		$model=$this->loadModel($id);
		$this->_appendInfos($model);
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate(){

		$model=new FranchiseeContract;
		$this->performAjaxValidation($model);
		
		if(isset($_POST['FranchiseeContract'])){
			$model->attributes=$_POST['FranchiseeContract'];
			try{
				if(!$model->save()) {
					$errors = (array)$model->getErrors();
					throw new Exception(implode(',',array_pop($errors)));
				}
				SystemLog::record($this->getUser()->name . "添加协议用户：" );
				$this->setFlash('success',Yii::t('Franchiseecontract','添加协议用户成功'));
				$this->redirect(array('List-agreement','id'=>$model->id));
			}catch(Exception $e){
				$model->original_contract_time = is_numeric($model->original_contract_time) ? date('Y-m-d',$model->original_contract_time) : $model->original_contract_time;
				$this->setFlash('error',$e->getMessage());
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id){

		$model=$this->loadModel($id);
		$this->_appendInfos($model);
		$this->performAjaxValidation($model);

		if(isset($_POST['FranchiseeContract'])){
			$model->attributes=$_POST['FranchiseeContract'];
			try{
				if(!$model->save()) {
					$errors = (array)$model->getErrors();
					throw new Exception(implode(',',array_pop($errors)));
				}
				SystemLog::record($this->getUser()->name . "修改协议用户：" );
				$this->setFlash('success',Yii::t('Franchiseecontract','修改协议用户成功'));
				$this->redirect(array('List-agreement','id'=>$model->id));
			}catch(Exception $e){
				$model->original_contract_time = is_numeric($model->original_contract_time) ? date('Y-m-d',$model->original_contract_time) : $model->original_contract_time;
				$this->setFlash('error',$e->getMessage());
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	private function _appendInfos(&$model){
		$memberInfos = Member::model()->findByPk($model->member_id);
		$model->member_name = isset($memberInfos->username) ? $memberInfos->username : '';
		$model->gai_number = isset($memberInfos->gai_number) ? $memberInfos->gai_number : '';
		$contractInfos = Contract::model()->findByPk($model->contract_id);
		$model->contract_type = isset($contractInfos->type) ? $contractInfos->type : '';
		$model->contract_version = isset($contractInfos->version) ? $contractInfos->version : '';
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id){

		FranchiseeContract::model()->del($id);
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('FranchiseeContract');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new FranchiseeContract('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FranchiseeContract']))
			$model->attributes=$_GET['FranchiseeContract'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	
}
