<?php
/**
 * 
 * @author pc
 *
 */
class OfflineRoleRelationController extends Controller
{
	/**
	 * (non-PHPdoc)
	 * @see CController::filters()
	 */
	public function filters() {
		return array('rights');
	}
	
	/**
	 * 代理列表
	 */
	public function actionAgentList(){
		$model = new Region('search');
		$model->unsetAttributes();
		if (isset($_GET['Region']))
			$model->attributes = $this->getParam('Region');
		$this->render('agentList', array(
			'model' => $model,
		));
	}
	
	public function actionIndex()
	{
		$this->render('index');
	}
	
    
    /**
     * 代理管理-代理列表-ajax更新代理
     */
    public function actionAjaxUpdateAgent() {
    	if ($this->isAjax()) {
    		$id = $this->getQuery('id');
    		$gai_number = $this->getQuery('gai_number');
    		$offRoleRe = OfflineRoleRelation::model()->tableName();
    		$member = Member::model()->findByAttributes(array('gai_number' => $gai_number));
    		$region = Region::model()->findByPk($id);
    		$result = array(
    				'error' => 1,
    				'content' => Yii::t('offlineRoleRelation', '绑定失败'),
    		);
    		if($region && $member && $member->enterprise_id > 0){
//     			$offRoleReData = Yii::app()->db->createCommand()->select('id')->from($offRoleRe)->where('region_id = ' .$id)->queryScalar();
				$offRoleReData = OfflineRoleRelation::createOrUpdateInfo('region_id = ' .$id);
    			if(empty($offRoleReData))
    				$res = Yii::app()->db->createCommand()->insert($offRoleRe, array('member_id'=>$member->id,'role_id'=>$region->depth,'region_id'=>$id,'admin_id'=>Yii::app()->user->id,'update_time'=>time()));
    			else 
    				$res = Yii::app()->db->createCommand()->update($offRoleRe, array('member_id'=>$member->id,'admin_id'=>Yii::app()->user->id,'update_time'=>time()),'id=:id',array(':id'=>$offRoleReData['id']));

    			if($res){
    				@SystemLog::record(Yii::app()->user->name . "更新代理：" . $id . '|' . $gai_number);
    				$result['error'] = 0;
    				$result['content'] = $region->name . ' ' . Yii::t('offlineRoleRelation', '绑定代理会员') . '：' . $gai_number . ' ' . Yii::t('offlineRoleRelation', '成功！');
    				$result['username'] = $member->username;
    				$result['mobile'] = $member->mobile;
    			}else{
    				$result['error'] = 1;
    				$result['content'] = Yii::t('offlineRoleRelation', '更新代理失败') . '：' . $gai_number;
    			}
    		}else{
    			$result['error'] = 1;
    			$result['content'] = Yii::t('offlineRoleRelation', '找不到企业会员') . '：' . $gai_number;
    		}
    		echo CJSON::encode($result);
    	}
    	Yii::app()->end();
    }
    
    /**
     * 代理管理-代理列表-ajax移除代理
     */
    public function actionRemoveAgent() {
    	if ($this->isAjax()) {
    		$id = $this->getQuery('id');
    		$result = array(
    				'error' => 1,
    				'content' => Yii::t('offlineRoleRelation', ''),
    		);
    		$res = Yii::app()->db->createCommand()->update(OfflineRoleRelation::model()->tableName(), 
    				array('member_id'=>'0','update_time'=>time()),
    				'region_id=:regionId',array(':regionId'=>$id));
    		if ($res) {
    				@SystemLog::record(Yii::app()->user->name . "移除代理：" . $id);
    				$result['error'] = 0;
    				$result['content'] = '移除成功';
    			} else {
	    			$result['error'] = 1;
	    			$result['content'] = '移除失败';
    			}
    		echo CJSON::encode($result);
    	}
    	Yii::app()->end();
    }
}