<?php
/**
 * 补充协议合同 控制器
 * @author xuegang.liu <wanyun_liu@163.com>
 */
class ContractController extends Controller
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
        return 'admin';
    }

    /**
     * 商户合同补充协议（代理版）
     */
    public function actionAgency() {
        $this->breadcrumbs = array(Yii::t('contract', '商户合作合同补充协议管理'), Yii::t('contract', '商户合同补充协议(代理版)'));
        $this->_listAllByType(Contract::CONTRACT_TYPE_AGENCY);
    }

    /**
     * 创建商户合同补充协议（代理版）
     */
    public function actionCreateAgency() {
        $this->breadcrumbs = array(Yii::t('contract', '商户合作合同补充协议管理'), Yii::t('contract', '创建商户合同补充协议(代理版)'));
        $this->actionCreate(Contract::CONTRACT_TYPE_AGENCY);
    }

    /**
     * 编辑商户合同补充协议（代理版）
     */
    public function actionUpdateAgency($id) {
        $this->breadcrumbs = array(Yii::t('contract', '商户合作合同补充协议管理'), Yii::t('contract', '编辑商户合同补充协议(代理版)'));
        $this->actionUpdate($id,Contract::CONTRACT_TYPE_AGENCY);
    }

    /**
     * 删除商户合同补充协议（代理版）
     */
    public function actionDelAgency($id) {
        
        $this->actionDelete($id);
    }

    /**
     * 商户合同补充协议（直营版）
     */
    public function actionRegularChain() {
        $this->breadcrumbs = array(Yii::t('contract', '商户合作合同补充协议管理'), Yii::t('contract', '商户合同补充协议(直营版)'));
        $this->_listAllByType(Contract::CONTRACT_TYPE_REGULAR_CHAIN);
    }

    /**
     * 创建商户合同补充协议（直营版）
     */
    public function actionCreateRegularChain() {
        $this->breadcrumbs = array(Yii::t('contract', '商户合作合同补充协议管理'), Yii::t('contract', '创建商户合同补充协议(直营版)'));
        $this->actionCreate(Contract::CONTRACT_TYPE_REGULAR_CHAIN);
    }

    /**
     * 编辑商户合同补充协议（直营版）
     */
    public function actionUpdateRegularChain($id) {
        $this->breadcrumbs = array(Yii::t('contract', '商户合作合同补充协议管理'), Yii::t('contract', '编辑商户合同补充协议(直营版)'));
        $this->actionUpdate($id,Contract::CONTRACT_TYPE_REGULAR_CHAIN);
    }

    /**
     * 删除商户合同补充协议（直营版）
     */
    public function actionDelRegularChain($id) {
        
        $this->actionDelete($id);
    }

    /**
	 * 根据合同类型 展示所有版本补充协议模板
	 *
	 * @param string $type 
	 */
	private function _listAllByType($type){

		$model=new Contract('search');
		$model->unsetAttributes();
		$model->type = $type;
		$this->render('list',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($type){
		$model=new Contract;
		$this->performAjaxValidation($model);

		if(isset($_POST['Contract'])){
			$data = $this->getPost('Contract');
			$model->attributes=$data;
			$model->version = Contract::getMaxVersionByType($type);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if(!$model->save()) {
                    $errors = (array)$model->getErrors();
                    throw new Exception(implode(',',array_pop($errors)));
                }
                if($model->is_current==Contract::CONTRACT_IS_CURRENT){
                    if(!Contract::setCurrentByType($model->type,$model->id)){
                        $errors = (array)$model->getErrors();
                        throw new Exception(implode(',',array_pop($errors)));       
                    }
                }  
                SystemLog::record($this->getUser()->name . "创建补充协议模板：" );
                $this->setFlash('success', Yii::t('contract', '添加补充协议模板') .Yii::t('contract', '成功'));
                $transaction->commit();
                $this->redirect(array($type==Contract::CONTRACT_TYPE_AGENCY ? 'agency' : 'regular-chain'));
            } catch (Exception $e) {
                $this->setFlash('error', $e->getMessage());
            }
		}

		$model->type = $type;
		$model->is_current = Contract::CONTRACT_NO_CURRENT;
		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id,$type){

		$model=$this->loadModel($id);
		$this->performAjaxValidation($model);

		if(isset($_POST['Contract'])){
			$data = $this->getPost('Contract');
			$model->attributes=$data;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if(!$model->save()) {
                    $errors = (array)$model->getErrors();
                    throw new Exception(implode(',',array_pop($errors)));
                }
                if($model->is_current==Contract::CONTRACT_IS_CURRENT){
                	if(!Contract::setCurrentByType($model->type,$model->id)){
                        $errors = (array)$model->getErrors();
                        throw new Exception(implode(',',array_pop($errors)));       
                    }
                }  
                SystemLog::record($this->getUser()->name . "编辑补充协议模板：" );
                $this->setFlash('success', Yii::t('contract', '编辑补充协议模板') .Yii::t('contract', '成功'));
                $transaction->commit();
                $this->redirect(array($type==Contract::CONTRACT_TYPE_AGENCY ? 'agency' : 'regular-chain'));
            } catch (Exception $e) {
                $this->setFlash('error', $e->getMessage());
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id){

		Contract::model()->del($id);
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
}

