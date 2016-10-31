<?php
class MemberController extends Controller{
	/**
     * 和页面显示有关
     * Enter description here ...
     * @param unknown_type $name
     */
    protected function setCurMenu($name) {
        $this->curMenu = Yii::t('main','会员管理');
    }
    
	/**
	 * 会员管理-会员列表
	 */
	public function actionIndex()
	{
                $model = new MemberAgent();
                
                if(isset($_GET['MemberAgent'])){
                    $dataArray = $this->getQuery('MemberAgent');
                    $model->username = $dataArray['username'];
                    $model->gai_number = $dataArray['gai_number'];
                    $model->mobile = $dataArray['mobile'];
                }
                
//                $agent_region = $this->getSession('agent_region');
                
                $this->breadcrumbs = array(Yii::t('Member','会员管理'),Yii::t('Member','会员列表'));
                
                $this->render('index',array(
                        'model' => $model,
                ));
	}
        
        /**
         * 添加普通会员
         */
        public function actionMemberEdit(){
        	die;	//张楚斌说去掉
            if(isset($_GET['id'])){
                $model = MemberAgent::model()->findByAttributes(array('id'=>$_GET['id'],'referrals_id'=>Yii::app()->user->id,'is_enterprise'=>MemberAgent::NOENTERPRISE));
            	if(!$model)
            	{
            		throw new CHttpException(404,'此页面不存在');
            	}
            }else{
                $model = new MemberAgent;
            }
            $model->setScenario(MemberAgent::MEMBER_USER);
            $this->performAjaxValidation($model);
            
            if(isset($_POST['MemberAgent'])){
                $model->attributes = $this->getPost('MemberAgent');
                $password = mt_rand(100000,999999);
                $model->password = $password;
                $model->register_time = strtotime($model->register_time);
                if($model->save()){
                    if($model->isNewRecord){
                        $smscontent = $this->getConfig('smsmodelconfig','phonePasswordContent');
                        $memberType = MemberAgent::_getMemberType($model->type_id);            //会员类型
                        $memberName = $model->username;
                        $memberCode = $model->gai_number;
                        $smscontent = str_replace("{0}", $memberType, $smscontent);
                        $smscontent = str_replace("{1}",$memberName, $smscontent);
                        $smscontent = str_replace("{2}",$memberCode, $smscontent);
                        $smscontent = str_replace("{3}",$password, $smscontent);
                        SmsLog::addSmsLog($model->mobile, $smscontent, $model->id, SmsLog::TYPE_OTHER);
                    }
                    $this->redirect(array('member/index'));
                }
            }
            
            $this->breadcrumbs = array(Yii::t('Member','代理管理系统'),Yii::t('Member','添加会员'));
            $this->render('normal',array(
                'model'=>$model,
                )
            );
        }
        
        /**
         * 添加企业会员
         */
        public function actionStoreEdit(){
        	die;
        	$model = new MemberAgent();
            $infoModel = new EnterpriseAgent();
            if(isset($_GET['id'])){
            	$auditTable = Auditing::model()->tableName();
            	$sql = "select * from $auditTable where id =".$_GET['id']." and author_id = ".Yii::app()->user->id." and `status`<>".Auditing::STATUS_PASS;
            	$new_model = Auditing::model()->findBySql($sql);
            	if(!$new_model)
            	{
            		throw new CHttpException(404,'此页面不存在');
            	}
            	$totelArray = CJSON::decode($new_model->apply_content);
            	foreach ($totelArray['member'] as $attribute=>$value)
            	{
            		$model->$attribute = $value;
            	}
            	foreach ($totelArray['enterprise'] as $attribute=>$value)
            	{
            		$infoModel->$attribute = $value;
            	}
                
            	if ($new_model->status == Auditing::STATUS_APPLY){
            		$this->render('applystore',array(
	            		'model' => $model,
		                'infoModel' => $infoModel,
		            	'new_model' => $new_model
            		));
            		Yii::app()->end();
            	}
                
            }else{
            	$new_model = new Auditing();
                
            }
            if(isset($_GET['memberid']))
            {
            	$model = MemberAgent::model()->findByPk($_GET['memberid']);
            	$infoModel = EnterpriseAgent::model()->findByAttributes(array(
            		'member_id'=>$model->id
            	));
            	$new_model = new Auditing();
            	if($model->referrals_id != $this->getUser()->getId() && $model->is_enterprise != MemberAgent::ISENTERPRISE)
            	{
            		throw new CHttpException(404,'此页面不存在');
            	}
            }
            $model->setScenario(MemberAgent::MEMBER_COMPANY);
            $this->performAjaxValidation($model);
            $this->performAjaxValidation($infoModel);
            
            if (isset($_POST['MemberAgent'])) {
                $model->attributes = $this->getPost('MemberAgent');
                $model->is_internal = 1;
                $password = mt_rand(100000,999999);
                $model->password = $password;
                $model->is_enterprise = MemberAgent::ISENTERPRISE;
                if ($model->validate()){
                    //添加商家信息
                    if(isset($_POST['EnterpriseAgent'])){
                        $infoModel->attributes = $_POST['EnterpriseAgent'];
                        $infoModel->member_id = $model->id;
                        $infoModel->name = $model->username;
                        $infoModel->mobile = $model->mobile;
                        $infoModel->license_photo = $_POST['EnterpriseAgent']['license_photo'];
//                        Tool::pr($infoModel);
                        if($infoModel->validate()){
                            if($new_model->isNewRecord){
                                //发送短信
//                                $smsConfig = $this->getConfig('smsmodel');
//                                $msg = str_replace('{0}', '企业会员', $smsConfig['addMemberContent']);
//                                $msg = str_replace('{1}', $model->username, $msg);
//                                $msg = str_replace('{2}', $model->gai_number, $msg);
//                                $msg = Yii::t('home', str_replace('{3}', $password, $msg));
//                                Sms::send($model->mobile, $msg);
								  if(isset($_GET['memberid']))
								  {
								  		$new_model->apply_id = $_GET['memberid'];
								  		$new_model->apply_type = Auditing::APPLY_TYPE_COMPANY_UPDATE;
								  }
								  else
								  {
								  		$new_model->apply_id = 0;
								  		$new_model->apply_type = Auditing::APPLY_TYPE_COMPANY;
								  }
								  
								  
								  $new_model->create_time = time();
                            }
                            else 
                            {
								  $new_model->apply_id = $model->id;
                            }
                            $new_model->status = $_POST['Auditing']['status'];
                            $new_model->apply_name = $model->username;
							$new_model->author_type = Auditing::AUTHOR_TYPE_AGENT;
							$new_model->author_id = $this->getUser()->getId();
							$new_model->author_name = $this->getUser()->getName();
                            
                            $memberArray = array();
                            foreach ($model->attributes as $attribute=>$value)
                            {
                            	if($value)
                            	{
                            		$memberArray[$attribute] = $value;
                            	}
                            }
                            $infoArray = array();
                            foreach ($infoModel->attributes as $attribute=>$value)
                            {
                            	if($value)
                            	{
                            		$infoArray[$attribute] = $value;
                            	}
                            }
                            $totelArray = array(
                            	'member'=>$memberArray,
                            	'enterprise'=>$infoArray,
                            );
                            $new_model->apply_content = CJSON::encode($totelArray);
                            $new_model->submit_time = time();
                            
                            $new_model->save(false);
                            $this->redirect(array('member/applyList'));
                        }
                    }
                }
            }
            
            $this->breadcrumbs = array(Yii::t('Member','代理管理系统'),Yii::t('Member','申请添加企业会员'));
            $this->render('store',array(
                'model' => $model,
                'infoModel' => $infoModel,
            	'new_model' => $new_model
                )
            );
        }
        
        /**
         * 取消申请
         */
        public function actionCancelApply($id){
        	die;
        	Auditing::model()->updateByPk($id, array('status'=>  Auditing::STATUS_WAIT));
        	$this->redirect(Yii::app()->createUrl('member/storeEdit',array('id'=>$id)));
        } 
        
        /**
         * 申请列表
         */
        public function actionApplyList(){
        	die;
            $model = new Auditing();
            
            $this->breadcrumbs = array(Yii::t('Member','会员管理'),Yii::t('Member','申请列表'));
            
            if(isset($_GET['Auditing'])){
                $model->attributes = $this->getQuery('Auditing');
            }
            $this->render('applylist',array(
                'model' => $model,
            ));
        }
        
        
        
        /**
         * 审核通过
         * @param type $id
         * @return type
         */
        public function actionPassConfirm($id){
        	die;
            EnterpriseAgent::model()->updateByPk($id, array('auditing'=>  EnterpriseAgent::AUDITING_YES));
            if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('applyList'));
        }
        
        /**
         * 审核不通过
         * @param type $id
         * @return type
         */
        public function actionFailConfirm($id){
        	die;
            EnterpriseAgent::model()->updateByPk($id, array('auditing'=>  EnterpriseAgent::AUDITING_NO_PASS));
            if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('applyList'));
        }
}