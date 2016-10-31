<?php

/**
 * 会员银行账号 修改
 *
 *  @author zhenjun_xu <412530435@qq.com>
 * Class BankAccountController
 */
class BankAccountController extends Controller
{

    public function filters()
    {
        return array(
            'rights',
        );
    }

    /**
     * 新增或者编辑 银行账号
     * @param $memberId
     */
    public function actionEdit($memberId)
	{

        $model = BankAccount::model()->findByAttributes(array('member_id' => $memberId));
        if (!$model)
            $model = new BankAccount();
        $memberModel = Member::model()->findByPk($memberId);
        if(!$memberModel) throw new CHttpException(404);
        $this->performAjaxValidation($model);
        if (isset($_POST['BankAccount'])) {
            $old_licence_image = $model->licence_image;
            $saveDir = 'enterprise/' . date('Y/n/j');
            $model->attributes = $_POST['BankAccount'];
            $model->member_id = $memberModel->id;
            $model = UploadedFile::uploadFile($model, 'licence_image', $saveDir, Yii::getPathOfAlias('att'));
            if ($model->save()) {
                UploadedFile::saveFile('licence_image', $model->licence_image,$old_licence_image,true);
            	@SystemLog::record(Yii::app()->user->name . "新增或者编辑 ".$memberModel->gai_number." 银行账号成功");
                $this->setFlash('success', Yii::t('bankAccount', '恭喜您，修改成功！'));
                $this->redirect(array('member/list'));
            } else {
            	@SystemLog::record(Yii::app()->user->name . "新增或者编辑 ".$memberModel->gai_number." 银行账号失败");
                $this->setFlash('error', Yii::t('bankAccount', '很抱歉，修改失败！'));
            }
        }
		$this->render('edit',array(
			'bankModel'=>$model,
			'memberModel'=>$memberModel,
		));
	}






}
