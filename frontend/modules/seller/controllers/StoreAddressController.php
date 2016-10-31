<?php

/**
 * 商家地址库控制器 
 * 操作 (添加,修改,删除)
 * @author  wencong.lin <183482670@qq.com>
 */
class StoreAddressController extends SController {

    /**
     * 添加商家地址库
     */
    public function actionCreate() {
        $model = new StoreAddress;
        $this->performAjaxValidation($model);
        if (isset($_POST['StoreAddress'])) {
            $model->attributes = $this->getPost('StoreAddress');
            $model->store_id = $this->storeId;
            if ($model->save()){
		     	//添加操作日志
		     	@$this->_saveSellerLog(SellerLog::CAT_LOGIN,SellerLog::logTypeUpdate,0,'添加商家地址库');
		     	
		     	$this->redirect(array('index'));
            }
                
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 修改商家地址库
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if (isset($_POST['StoreAddress'])) {
            $model->attributes = $this->getPost('StoreAddress');
            if ($model->save()){
            	//添加操作日志
		     	@$this->_saveSellerLog(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,$id,'修改商家地址库');
		     	$this->redirect(array('index'));
            }
                
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 删除商家地址库
     */
    public function actionDelete($id) {
        $model =  $this->loadModel($id);
        $msg = '';
        if(!$model->FreightTemplate){
            $model->delete();
            //添加操作日志
		    @$this->_saveSellerLog(SellerLog::CAT_COMPANY,SellerLog::logTypeDel,$id,'删除商家地址库');
        }else{
            $msg =  '改地址已经在运费模板中使用，不能删除';
        }
        echo $msg;

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * 商家地址库管理
     */
    public function actionIndex() {
        $model = new StoreAddress('search');
        $model->unsetAttributes();
        $model->store_id = $this->storeId;
        if (isset($_GET['StoreAddress']))
            $model->attributes = $this->getQuery('StoreAddress');
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * 商家设置默认地址
     */
    public function actionSet($id) {
        $model = $this->loadModel($id);
        $model->default = StoreAddress::DEFAULT_YES;
        $model->updateAll(array('default' => '0'), 'store_id = :storeId AND `default` = ' . StoreAddress::DEFAULT_YES, array(
            ':storeId' => $this->storeId
        ));
        if ($model->save()){
        	//添加操作日志
		    @$this->_saveSellerLog(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,$id,'设置默认地址');
		    $this->redirect(array('index'));
        }
            
    }

    public function loadModel($id) {
        $model = StoreAddress::model()->findByPk(intval($id), 'store_id=:storeId', array(
            ':storeId' => $this->storeId
        ));
        if ($model === null)
            throw new CHttpException(404, '请求的页面不存在');
        return $model;
    }

}
