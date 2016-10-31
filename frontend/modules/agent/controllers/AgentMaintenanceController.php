<?php

class AgentMaintenanceController extends Controller
{
	protected function setCurMenu($name) {
		$this->curMenu = Yii::t('main', '运维人员');
	}
	/**
	 * 运维人员列表
	 */
	public function actionIndex(){
		$model = new AgentMaintenance();
		$model->parent_member_id = Yii::app()->user->id;
		if(isset($_GET['AgentMaintenance'])){
			$dataArray = $this->getQuery('AgentMaintenance');
			$model->attributes = $dataArray;
			$model->mobile = $dataArray['mobile'];
			$model->GWnumber = $dataArray['GWnumber'];
			$model->username = $dataArray['username'];
		}
		$this->breadcrumbs = array(Yii::t('AgentMaintenance',''),Yii::t('Member','会员列表'));
		$this->render('index',array(
			'model' => $model,
		));
	}

	/**
	 * ajax绑定GW号
	 */
	public function actionBindMember(){
		if ($this->isAjax() && $this->isPost()) {
			$GWNo = $this->getPost('GWNo');
			$password = $this->getPost('password');
			$result = AgentMaintenance::isGwNumber($GWNo);
			if ($result) {
				if( empty($result['username']) || empty($result['mobile']) )
					exit(json_encode(array('error' => '请完善该GW号的用户名和手机号信息！')));
				else{
					$model = new AgentMaintenance();
					$model->member_id = $result['id'];
					$model->password = md5($password);
					$model->parent_member_id = Yii::app()->user->id;
					$model->create_time = time();
					if($model->save())
						exit(json_encode(array('success' => '绑定GW号'.$GWNo.'成功')));
					else
						exit(json_encode(array('error' => '绑定失败')));
				}
			}else
				exit(json_encode(array('error' => '该GW号不存在！')));
		}
	}

	/**
	 * ajax检测GW号是否存在、绑定、可用等
	 */
	public function actionCheckGWNo(){
		if ($this->isAjax() && $this->isPost()) {
			$GWNo = $this->getPost('GWNo');
			if (empty($GWNo) || !preg_match("/^(GW|gw|Gw|gW)[0-9]{7,15}$/",$GWNo))
				exit(json_encode(array('error' => '请输入正确的GW号')));
			$result = AgentMaintenance::isBindMember($GWNo);
			if (!$result)
				exit(json_encode(array('error' => '该GW号已经被绑定，请重新绑定！')));
			$result = AgentMaintenance::isGwNumber($GWNo);
			if ($result) {
				if( empty($result['username']) || empty($result['mobile']) )
					exit(json_encode(array('error' => '请完善该GW号的用户名和手机号信息！')));
				else{
					$result['success'] = true;
					exit(json_encode($result));
				}
			}else
				exit(json_encode(array('error' => '该GW号不存在！')));
		}
	}

	/**
	 * 添加运维人员
	 */
	public function actionCreate(){
		$model = new AgentMaintenance();
		$this->performAjaxValidation($model);
		if(isset($_POST['AgentMaintenance'])){
			$model->attributes = $this->getPost('AgentMaintenance');
			$model->password = md5($model->password);
			$model->parent_member_id = Yii::app()->user->id;
			$model->create_time = time();
			if($model->save()){
				$this->redirect(array('agentMaintenance/index'));
			}
		}
		$this->breadcrumbs = array(Yii::t('AgentMaintenance','代理管理系统'),Yii::t('AgentMaintenance','添加运维人员'));
		$this->render('normal',array(
				'model'=>$model,
			)
		);
	}

	/**
	 * 重设密码
	 */
	public function actionResetPwd(){
		if ($this->isAjax() && $this->isPost()) {
			$id = $this->getPost('id');
			$password = $this->getPost('password');
			if( trim($password) == '' )
				exit(json_encode(array('error' => '密码不能为空')));
			$model = AgentMaintenance::model()->findByPk($id);
			$model->password = md5($password);
			if( $model->save() ){
				//清除token
				$tokenId = Yii::app()->db->createCommand()
					->select('token')
					->from('{{member_token}}')
					->where('target_id = :memberID and app_type = 7',array(':memberID'=>$model->member_id))
					->queryScalar();
				if(!empty($tokenId)){
					AgentMaintenance::deleteToken($tokenId);
				}
				exit(json_encode(array('success'=>true)));
			}
			else
				exit(json_encode(array('error' => '修改失败')));
		}
	}

	/**
	 * 更新运维人员
	 */
	public function actionUpdate($id){
		$model = $this->loadModel($id);
		$this->performAjaxValidation($model);
		if(isset($_POST['AgentMaintenance'])){
			$model->attributes = $this->getPost('AgentMaintenance');
			$model->password = md5($model->password);
			$model->parent_member_id = Yii::app()->user->id;
			if($model->save()){
				$this->redirect(array('agentMaintenance/index'));
			}
		}
		$model->password = '';
		$this->breadcrumbs = array(Yii::t('AgentMaintenance','代理管理系统'),Yii::t('AgentMaintenance','添加运维人员'));
		$this->render('normal',array(
				'model'=>$model,
			)
		);
	}

	/**
	 * 删除运维人员
	 */
	public function actionDelete($id){
		$model = $this->loadModel($id);
		$model->delete();
		$this->redirect(array('index'));
	}
}