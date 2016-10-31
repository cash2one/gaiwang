<?php

class OfflineSignAuditLoggingController extends Controller
{
    protected function setCurMenu($name) {
        $this->curMenu = Yii::t('main', '电子化签约管理');
    }
	/**
	 * 查看审核记录
	 */
	public function actionSeeAudit(){
		$extendId = $this->getParam('storeExtendId');
		$model = OfflineSignStoreExtend::model()->findByPk($extendId);
		$modelAudit = new OfflineSignAuditLogging();
		$criteria = $modelAudit->searchStore($extendId);
		$data = $modelAudit->findAll($criteria);
		$this->render('seeAudit',array('model'=>$model,'data'=>$data));
	}

	/**
	 * 审核记录
	 */

	/*public function actionSeeAudit(){
		$extendId = $this->getParam('extendId');
		$model = OfflineSignStoreExtend::model()->findByPk($extendId);
		$modelAudit = new OfflineSignAuditLogging();
		$criteria = $modelAudit->searchStore($extendId);
		$data = $modelAudit->findAll($criteria);
		switch($model->apply_type){
			case OfflineSignStoreExtend::APPLY_TYPE_NEW_FRANCHIESE;
				$storeInfo = Yii::app()->db->createCommand()
					->select('c.id as cid , s.id as sid,c.b_name,s.apply_type,c.b_name,e.name,s.audit_status,s.upload_contract')
					->from(OfflineSignStoreExtend::model()->tableName() . ' as s')
					->leftJoin(OfflineSignEnterprise::model()->tableName() . ' as e' ,'s.offline_sign_enterprise_id = e.id')
					->leftJoin(OfflineSignContract::model()->tableName() . ' as c','s.offline_sign_contract_id = c.id')
					->where('s.id=:id',array(':id'=>$extendId))
					->queryRow();
				$this->render('seeAudit',array('storeInfo'=>$storeInfo,'data'=>$data,'model'=>$model));
				break;
			case OfflineSignStoreExtend::APPLY_TYPE_OLD_FRANCHIESE;
				$name = Yii::app()->db->createCommand()
					->select('name')
					->from(Enterprise::model()->tableName())
					->where('id=:id',array(':id'=>$model->old_member_franchisee_id))
					->queryScalar();
				$this->render('seeAuditOld',array('name'=>$name,'data'=>$data,'model'=>$model));
				break;
		}
	}
	*/
}
