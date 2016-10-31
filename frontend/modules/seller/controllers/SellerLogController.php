<?php
/**
 * 操作日志
 * Class SellerLogController
 */
class SellerLogController extends SController{

    /**
     * 日志列表
     */
    public function actionIndex(){
        $this->pageTitle = Yii::t('sellerLog','操作日志').'_'.$this->pageTitle;
        $model = new SellerLog('search');
        $model->unsetAttributes();
        if(isset($_GET['SellerLog'])){
            $model->attributes = $this->getQuery('SellerLog');    
        }
        $this->render('index',array('model'=>$model));
    }
} 