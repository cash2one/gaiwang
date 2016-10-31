<?php

/**
 * 店铺管理
 * 操作(查看，店铺申请，修改)
 * @author zhenjun_xu <412530435@qq.com>
 */
class StoreController extends SController {

    /**
     * 申请
     */
    public function actionApply() {
        $model = new Store();
        /** @var Member $member */
        $enterprise = Yii::app()->db->createCommand('select last_log_id,flag from {{enterprise}} where id=:id')
                        ->bindValue(':id', $this->getSession('enterpriseId'))->queryRow();
        if ($enterprise['flag'] == Enterprise::FLAG_ONLINE && $enterprise['last_log_id'] == 0)
            throw new CHttpException(404, '请先完成网络店铺签约流程');

        $member = Member::model()->findByPk($this->getUser()->id);
        $store = Store::model()->findByAttributes(array('member_id' => $member->id));
        $this->performAjaxValidation($model);
        if (isset($_POST['Store'])) {
            $model->attributes = $this->getPost('Store');
            $model->member_id = $this->getUser()->id;
            $model->status = $model::STATUS_APPLYING;
            if (!empty($model->referrals_id)) {
                $member = Member::model()->find('gai_number=:gn', array(':gn' => $model->referrals_id));
                if ($member)
                    $model->referrals_id = $member->id;
            }
            if (isset($_POST['not_notice']))
                $model->order_reminder = null;
            if ($model->save()) {
                //添加操作日志
                @$this->_saveSellerLog(SellerLog::CAT_BIZ, SellerLog::logTypeInsert, 0, '申请店铺');
//                Member::model()->updateByPk($model->member_id, array('store_id' => $model->id));
                $this->redirect(array('view'));
            }
        }
        $this->render('apply', array('model' => $model, 'store' => $store));
    }

    /**
     * 查看
     */
    public function actionView() {
        /** @var $model Store */
        $this->layout = 'seller';
        $model = Store::model()->findByPk($this->storeId);
        if (!$model) {
            $this->redirect(array('store/apply'));
        }

        $this->render('view', array(
                'model' => $model,
        ));
    }

    /**
     * 更新
     */
    public function actionUpdate() {
          $model = Store::model()->findByPk($this->storeId);
          $model->setScenario('updateImport');
          $this->performAjaxValidation($model);
        if (isset($_POST['Store'])) {
            unset($model->attributes);
            $model->attributes = $this->getPost('Store');
            $oldFile    = $model->thumbnail;  // 旧文件
			$logoFile   = $model->logo;  // 旧logo文件
			$sloganFile = $model->slogan;  // 旧slogan文件
            $saveDir    = 'store' . '/' . date('Y/n/j');
            $model      = UploadedFile::uploadFile($model, 'thumbnail', $saveDir);  // 上传图片
			$model      = UploadedFile::uploadFile($model, 'logo', $saveDir);  // 上传logo图片
			$model      = UploadedFile::uploadFile($model, 'slogan', $saveDir);  // 上传slogan图片
            if (!empty($model->referrals_id)) {
                $member = Member::model()->find('gai_number = :gn', array(':gn' => $model->referrals_id));
                if ($member)
                    $model->referrals_id = $member->id;
              }
            if (isset($_POST['not_notice']))
                $model->order_reminder = null;
            if ($model->save(false)) {
                UploadedFile::saveFile('thumbnail', $model->thumbnail, $oldFile, true); // 更新图片
				UploadedFile::saveFile('logo', $model->logo, $logoFile, true); // 更新logo图片
				UploadedFile::saveFile('slogan', $model->slogan, $sloganFile, true); // 更新slogan图片
                
				//添加操作日志
                @$this->_saveSellerLog(SellerLog::CAT_BIZ, SellerLog::logTypeUpdate, $this->storeId, '更新店铺');
                $this->setFlash('success', Yii::t('store', '操作成功'));
                $this->redirect(array('view'));
            } else {               
                $this->setFlash('error', Yii::t('store', '操作失败'));
                $this->redirect(array('view'));
            }
        }

        if (!empty($model->referrals_id))
            $model->referrals_id = $model->referrals->gai_number; 
            $this->render('update', array('model' => $model));
    }
    
        /**
         * 删除图片
         */
      public function actionDeleteImg()
         {
           if($this->isAjax()){
            $storeId=$this->getParam('stord_id');
            $imgsrc=$this->getParam('imgsrc');
            $imgType=$this->getParam('deData');
            $res=Store::model()->updateByPk($storeId,array($imgType=>''));
            if($res){
                $src = str_replace(IMG_DOMAIN, Yii::getPathOfAlias('uploads'),$imgsrc);
                $result = UploadedFile::delete($src);
                echo '成功删除图片';exit;
             }else{
                 echo '图片不可删除';exit;
             }
    }
         }    
    

}
