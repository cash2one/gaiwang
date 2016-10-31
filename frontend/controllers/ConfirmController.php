<?php

/**
 * 补充协议确认
 * @author xuegang.liu@g-emall.com
 */
class ConfirmController extends Controller {

	public $showTitle;
    private $prevois = false;

	public function beforeAction($currentAction){
        $allowAction = array('index');
		parent::beforeAction($currentAction);
        if(in_array($currentAction->id,$allowAction)) return true;  
		if (Yii::app()->user->isGuest){
			$this->redirect('/');
			return false;	
		} 
		return true;
	}

    public function actionConfirm(){

        $id = Yii::app()->request->getParam('id');
        $res = FranchiseeContract::model()->confirm($id);
        $returnUrl = isset(Yii::app()->session['login_redirect']) ?  Yii::app()->session['login_redirect'] : '/';
        unset(Yii::app()->session['login_redirect']);
        if($res === true){
            Yii::app()->session['login_redirect_confirm'] = false;
            $this->redirect($returnUrl);
        }else{
            $this->redirect('/');
        }
    }

    public function actionReject(){

        $returnUrl = isset(Yii::app()->session['login_redirect']) ?  Yii::app()->session['login_redirect'] : '/';
        unset(Yii::app()->session['login_redirect']);
        Yii::app()->session['login_redirect_confirm'] = false;
        $this->redirect($returnUrl);
    }

    public function actionIndex(){

        $returnUrl = isset(Yii::app()->session['login_redirect']) ?  Yii::app()->session['login_redirect'] : '/';
        $labels = array(
            '{{number}}'        => 'number',
            '{{a_name}}'        => 'a_name',
            '{{a_address}}'     => 'a_address',
            '{{b_name}}'        => 'b_name',
            '{{b_address}}'     => 'b_address',
            '{{original_contract_time}}' => 'original_contract_time',
        );

        $model = null;
        if(Yii::app()->request->getParam('code')){
            if(!$this->securityCheck()) return $this->redirect('/');  //安全检测
            $this->prevois = true;
            $model = FranchiseeContract::model()->findByMemberId(Yii::app()->request->getParam('id'),true);
        }else if(isset(Yii::app()->user->id)){
            $model = FranchiseeContract::model()->findByMemberId(Yii::app()->user->id);
        }

        if(!$model) return $this->redirect($returnUrl);
        $extendsLabels = array(
            '{{year}}'  => substr($model->original_contract_time,0,4),
            '{{month}}' => substr($model->original_contract_time,5,2),
            '{{day}}'   => substr($model->original_contract_time,8,2),
        );
        $content = Contract::model()->findByPk($model->contract_id);
        if(!$content) return $this->redirect($returnUrl);

        if($this->prevois===false)
            Yii::app()->session['login_redirect_confirm'] = true;
        $this->pageTitle = Yii::t('confirm','补充协议').$this->pageTitle;
        $this->showTitle = Yii::t('confirm','补充协议');
        $this->layout = 'member.views.layouts.reg';
        $this->render('view',array(
            'model'=>$model,
            'content'=> $content->content,
            'search' => array_merge(array_keys($labels),array_keys($extendsLabels)),
            'replace'=> array_merge($model->getAttributes(array_values($labels)),array_values($extendsLabels)),
            'prevois' => $this->prevois,
        ));
    }

    private function securityCheck(){
        $safeCode = '619497a5b67ad588307333ade6a882c7';
        $code = Yii::app()->request->getParam('code');
        $firstCode = substr($code,0,4);
        $secodeCode = substr($code,2);
        $subCode = 'lixuegang ):';
        $resCode = md5($firstCode.$secodeCode.$subCode);
        if($safeCode!=$resCode) return false;
        return true; 
    }

}
