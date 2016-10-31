<?php

/**
 * 售货机控制器
 * 添加、删除、更新
 * @author csj
 */
class VendingMachineController extends SController {

	/**
     * 售货机添加
     */
    public function actionAdd() {
    	$this->pageTitle = Yii::t('sellerVendingMachine','添加售货机 - ').$this->pageTitle;
        $model = new VendingMachine('search');
        $model->unsetAttributes();
        $model->franchisee_id = $this->curr_franchisee_id;
        
        if (isset($_GET['VendingMachine']))
            $model->attributes = $this->getQuery('VendingMachine');
            
            
        $lists = $model->search();
        $lists_data = $lists->getData();
        $pager = $lists->pagination;
            
            
        $this->render('artile', array(
            'model' => $model,
        	'lists_data'=>$lists_data,
        	'pager'=>$pager,
        ));
    }
    
    
    
	/**
     * 修改售货机
     */
    public function actionEdit($id) {
    	$this->pageTitle = Yii::t('sellerVendingMachine','修改售货机文章 - ').$this->pageTitle;
        $model = VendingMachine::model()->find("id={$id}");
//        $this->performAjaxValidation($model);
    	if (isset($_POST['VendingMachine'])) {
            $model->attributes = $this->getPost('VendingMachine');
//            var_dump($model,$_POST['VendingMachine']);exit();
            $oldImg = $this->getParam('oldImg');  // 旧图
            $saveDir = 'franchiseeArtile/' . date('Y/n/j');
            if (!empty($_FILES['VendingMachine']['name']['thumbnail'])){
            	$model = UploadedFile::uploadFile($model, 'thumbnail', $saveDir, Yii::getPathOfAlias('att'));  // 上传图片
            }else{
            	$model->thumbnail = $oldImg;
            }
            if ($model->save()){
            	//保存操作记录
        		$this->_saveLog(SellerLog::CAT_BIZ,SellerLog::logTypeUpdate,$id);
            	if (!empty($_FILES['VendingMachine']['name']['thumbnail'])) UploadedFile::saveFile('thumbnail', $model->thumbnail, $oldImg, true); // 更新图片
            	$this->setFlash('success',Yii::t('sellerVendingMachine', '文章更新成功'));
            }
                
                $this->redirect(array('artile')); 
        }

        $this->render('artile_edit', array(
            'model' => $model,
        ));
    }
    
    
    
    
	/**
     * 售货机更新
     */
    public function actionUpdate() {
    	$this->pageTitle = Yii::t('sellerVendingMachine','添加售货机文章 - ').$this->pageTitle;
        $model =  new VendingMachine;
//        $this->performAjaxValidation($model);
    	if (isset($_POST['VendingMachine'])) {
            $model->attributes = $this->getPost('VendingMachine');
            $saveDir = 'franchiseeArtile/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'thumbnail', $saveDir, Yii::getPathOfAlias('att'));  // 上传图片
            $model->franchisee_id = $this->curr_franchisee_id;
            $model->author_id = $this->user->id;
			$model->create_time = time();
            
            if ($model->save()){
            	//保存操作记录
        		$this->_saveLog(SellerLog::CAT_BIZ,SellerLog::logTypeInsert);
            	UploadedFile::saveFile('thumbnail', $model->thumbnail, '', true); // 更新图片
            	$this->setFlash('success',Yii::t('sellerVendingMachine', '文章添加成功'));
            }
                
            $this->redirect(array('artile')); 
        }

        $this->render('artile_add', array(
            'model' => $model,
        ));
    }
    
    
    
	/**
     * 售货机文章管理
     */
    public function actionArtileDel($id) {
    	$id = $id*1;
        $rs = VendingMachine::model()->deleteAllByAttributes(array('id'=>$id,'franchisee_id'=>$this->curr_franchisee_id));
        //保存操作记录
        $this->_saveLog(SellerLog::CAT_BIZ,SellerLog::logTypeDel,$id);
        $this->setFlash('success',Yii::t('sellerVendingMachine', '删除成功'));
        $this->redirect($_SERVER['HTTP_REFERER']);
    }
    
    
    
    

}
