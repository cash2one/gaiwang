<?php

/**
 * 运费模板
 *
 * 操作(查增改)
 * @author zhenjun_xu <412530435@qq.com>
 */
class FreightTemplateController extends SController {

    /**
     * 添加运费模板
     */
    public function actionCreate() {
        $model = new FreightTemplate;
        $this->performAjaxValidation($model);

        if (isset($_POST['FreightTemplate'])) {
            $model->attributes = $this->getPost('FreightTemplate');
            $model->store_id = $this->storeId;
            if ($model->save()) {
                //运费类型
                if(isset($_POST['mode']) && !empty($_POST['mode'])){
                    $typeMode = new FreightType();
                    $typeMode->mode = $_POST['mode'];
                    $typeMode->freight_template_id = $model->id;
                    $typeMode->default = $typeMode::PARAM_DEFAULT;
                    $typeMode->default_freight = $typeMode::PARAM_DEFAULT_FREIGHT;
                    $typeMode->added = $typeMode::PARAM_ADDED;
                    $typeMode->added_freight = $typeMode::PARAM_ADDED_FREIGHT;
                    if ($typeMode->save()) {
                    	//添加操作日志
		    			@$this->_saveSellerLog(SellerLog::CAT_COMPANY,SellerLog::logTypeInsert,0,'添加运费模板');
                        $this->redirect(array('freightType/view','id'=>$typeMode->id));
                    }else{
                        $this->setFlash('error','添加运费模板失败');
                    }
                }else{
                    $this->setFlash('success','添加运费模板成功，请设置运费详情');
                    $this->redirect(array('freightTemplate/update','id'=>$model->id));
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
            'modeArray' => array(),
        ));
    }

    /**
     * 修改运费模板
     * @param $id
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if (isset($_POST['FreightTemplate'])) {
            $model->attributes = $this->getPost('FreightTemplate');
            if ($model->save()) {
                if(isset($_POST['mode']) && !empty($_POST['mode'])){
                    $typeModel = FreightType::model()->findByAttributes(array('mode' => $_POST['mode'], 'freight_template_id' => $id));
                    if (!$typeModel) {
                        //运费类型
                        $typeModel = new FreightType();
                        $typeModel->mode = $_POST['mode'];
                        $typeModel->freight_template_id = $model->id;
                        $typeModel->default = $typeModel::PARAM_DEFAULT;
                        $typeModel->default_freight = $typeModel::PARAM_DEFAULT_FREIGHT;
                        $typeModel->added = $typeModel::PARAM_ADDED;
                        $typeModel->added_freight = $typeModel::PARAM_ADDED_FREIGHT;
                        $typeModel->save();
                        
                        //添加操作日志
		    			@$this->_saveSellerLog(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,$id,'修改运费模板');
                    }
                    $this->redirect(array('freightType/view/', 'id' => $typeModel->id));
                }else{
                    $this->setFlash('success',Yii::t('sellerFreightTemplate','修改成功'));
                    $this->redirect(array('index'));
                }

            }
        }

        $typeModel = FreightType::model()->findAllByAttributes(array('freight_template_id' => $id));
        $modeArray = array();
        foreach ($typeModel as $v) {
            $modeArray[] = $v->mode;
        }

        $this->render('update', array(
            'model' => $model,
            'modeArray' => $modeArray,
        ));
    }

    /**
     * 运费模板列表
     */
    public function actionIndex() {
        $c = new CDbCriteria();
        $c->condition = 'store_id=:store_id';
        $c->params = array(':store_id' => $this->storeId);
        $count = FreightTemplate::model()->count($c);
        //分页
        $pages = new CPagination($count);
        $pages->applyLimit($c);
        $model = FreightTemplate::model()->findAll($c);
        $this->render('index', array(
            'model' => $model,
            'pages' => $pages,
        ));
    }

    /**
     * 删除运费模板
     */
    public function actionDelete(){
        if($this->isAjax()){
            /** @var $model FreightTemplate */
            $model = $this->loadModel($this->getPost('id'));

            $goods = Goods::model()->findByAttributes(array('freight_template_id'=>$model->id,'life'=>Goods::LIFE_NO));
            if($goods){
                $msg = array('status'=>'error','msg'=>'已有商品使用该运费模板，不能删除');
            }else{
                $freightTypes = FreightType::model()->findAllByAttributes(array('freight_template_id'=>$model->id));
                foreach($freightTypes as $v){
                    FreightArea::model()->deleteAllByAttributes(array('freight_type_id'=>$v->id));
                }
                FreightType::model()->deleteAllByAttributes(array('freight_template_id'=>$model->id));
                $model->delete();
                $msg = array('status'=>'success','msg'=>Yii::t('sellerFreightTemplate','删除成功'));
                
                //添加操作日志
		    	@$this->_saveSellerLog(SellerLog::CAT_COMPANY,SellerLog::logTypeDel,$model->id,'删除运费模板');
                
            }
            echo json_encode($msg);
        }
    }

}
