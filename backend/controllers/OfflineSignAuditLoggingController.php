<?php

class OfflineSignAuditLoggingController extends Controller
{
	/**
	 * 显示所有备注
	 */
	public function actionShowRemarks(){
		$id = $this->getParam('id');
		$model = new OfflineSignAuditLogging();
		$this->render('showRemarks',array('model'=>$model,'id'=>$id));
	}

	/**
	 * ajax添加备注
	 */
	public function actionAddRemarks(){
		if ($this->isAjax() && $this->isPost()) {
			$id = $this->getPost('id');
			$role = $this->getPost('role');
			$remark = $this->getPost('remark');

			$model = new OfflineSignAuditLogging();
			$model->extend_id = $id;
			$model->audit_role = $role;
			$model->remark = addslashes($remark);
			$model->behavior = 2002;
			if($model->save(false)){
				SystemLog::record($this->getUser()->name . "电子化签约添加备注：" . $model->remark);
				exit(json_encode(array('success' => '添加备注成功')));
			}else
				exit(json_encode(array('error' => '添加备注失败')));
		}
	}

	/**
	 * 审核进度
	 */
	public function actionAuditSchedule(){
        $id = $this->getParam('id');
        $model = new OfflineSignAuditLogging();
        $this->render('auditSchedule',array('model'=>$model,'id'=>$id));
	}
}