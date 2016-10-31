<?php
/**
 * 加盟商控制器基类
 * @author csj
 */
class SFController extends SController {

	protected $curr_franchiess_session_key = 'curr_franchisee_id';
	public $curr_franchisee_id;
	
	
	function beforeAction($action){

		$this->curr_franchisee_id = $this->getSession($this->curr_franchiess_session_key);
		if (empty($this->curr_franchisee_id) && $this->action->id!='change'){
			
			$franchisee = Franchisee::getAllFranchiseeByMemberId(Yii::app()->user->id);
			if (empty($franchisee)) throw new CHttpException(404,Yii::t('sellerFranchisee','加盟商不存在'));
			
			if (!empty($franchisee)){
				$temp_franchisee = $franchisee[0];
				if (empty($this->curr_franchisee_id)) $this->_setFranchiess($temp_franchisee->id);
			}
			
		}
		return parent::beforeAction($action);
	}
	
	
	/**
	 * 设置当前加盟商
	 * @param unknown $id
	 */
	protected function _setFranchiess($id){
		$this->_check($id);
		$this->setSession($this->curr_franchiess_session_key,$id);
		$this->curr_franchisee_id = $this->getSession($this->curr_franchiess_session_key);
	}

	
	
	/**
	 * 检查操作的加盟商是否属于当前用户
	 * Enter description here ...
	 */
	protected function _check($franchisee_id){
		if (empty($franchisee_id)) return false;
		 
		$members = Member::getAllMembers($this->user->id);
		$instr = ' member_id IN (0';
		foreach ($members as $m){
			$instr .= ','.$m->id;
		}
		 
		$instr .= ') ';
	
		if( !Franchisee::model()->count(" {$instr} AND id={$franchisee_id}")){
			$this->setFlash('success',Yii::t('sellerFranchisee', '没有权限！'));
			exit();
		}
		 
	}
	
	/**
	 * 加盟商页面渲染方法
	 * @param unknown $dispalyName
	 * @param unknown $pramas
	 */
	protected function FRender($dispalyName,$pramas=array()){
		$apend_arr = array('franchisee_id'=>$this->curr_franchisee_id);
		$pramas = array_merge($pramas,$apend_arr);
		
		$this->render($dispalyName,$pramas);
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
    
	
    
}
