<?php

class CreditorController extends Controller {

//	public function beforeAction($action)
//	{
//		//先不发布
//		die;
//	}
    public function actionIndex() {
        $model = new Creditor;
        $model->unsetAttributes();

        if (isset($_GET['Creditor'])) {
            $model->creditor_tran = $_GET['Creditor']['creditor_tran'];
        }

        $this->breadcrumbs = array('积分分配确认函', '列表');
        $this->render('index', array('model' => $model));
    }

    //新建债权转移确认函
    public function actionCreate() {
        $model = new Creditor;
        $model->unsetAttributes();
        $check = false;
        //ajax表单验证
        $this->performAjaxValidation($model);
        if (isset($_POST['Creditor'])) {
            $model->creditor_tran = $_POST['Creditor']['creditor_tran'];
            $model->tranYuan = $_POST['Creditor']['tranYuan'];
            $tmpArray = array();
            $tmpArray['tranYuan'] = $_POST['Creditor']['tranYuan'];
            $model->cont = CJSON::encode($tmpArray);
            $storeName = $_POST['Creditor']['creditor_tran'];

            //判断该公司是否已签约
            $rsStore = Creditor::model()->findByAttributes(array('creditor_tran' => $storeName));
            if (empty($rsStore)) {
                $sqlGw = "select m.gai_number from {{enterprise}} t left join {{member}} m on m.id=t.member_id where t.name='$storeName'";
                $rs = Yii::app()->db->createCommand($sqlGw)->queryRow();
                if (isset($rs)) {//获取该公司GW号
                    $model->gai_number = $rs['gai_number'];
                }
                if ($model->save()) {
                	@SystemLog::record(Yii::app()->user->name."新建'{$storeName}' 债权转移确认函成功");
                    $this->setFlash('success', Yii::t('home', '数据保存成功'));
                    $this->redirect(array('index'));
                }else{
                	@SystemLog::record(Yii::app()->user->name."新建'{$storeName}' 债权转移确认函失败");
                }
            } else {
                $check = true;
            }
        }

        $this->render('_create', array('model' => $model, 'check' => $check));
    }

    //编辑联盟商户结算关系确认函
    public function actionUpdate() {
        if (isset($_GET['id'])) {
            $model = $this->loadModel($_GET['id']);
            $array = CJSON::decode($model->cont);
            $model->tranYuan = $array['tranYuan'];
        } else {
            $this->redirect(array('index'));
        }

        $check=true;
        //ajax表单验证
        $this->performAjaxValidation($model);
        if (isset($_POST['Creditor'])) {
            //验证数据是否有编辑数据
            $edit = false;
            foreach ($_POST['Creditor'] as $key => $value) {
                if ($model->$key != $value) {
                    $edit = true;
                }
            }
            if ($edit) {
                $model->creditor_tran = $_POST['Creditor']['creditor_tran'];
                $model->tranYuan = $_POST['Creditor']['tranYuan'];
                $tmpArray = array();
                $tmpArray['tranYuan'] = $_POST['Creditor']['tranYuan'];
                $model->cont = CJSON::encode($tmpArray);
                if ($model->save()) {
                	@SystemLog::record(Yii::app()->user->name."编辑'{$model->creditor_tran}' 债权转移确认函成功");
                    $this->setFlash('success', Yii::t('home', '数据保存成功'));
                    $this->redirect(array('index'));
                }else{
                	@SystemLog::record(Yii::app()->user->name."编辑'{$model->creditor_tran}' 债权转移确认函失败");
                }                
            } else {
            	@SystemLog::record(Yii::app()->user->name."编辑'{$model->creditor_tran}' 债权转移确认函 ，数据没有变更");
                $this->setFlash('error', Yii::t('home', '数据没有变更!'));
                $this->redirect(array('index'));
            }
        }

        $this->render('_update', array('model' => $model,'check'=>$check));
    }

    //查看联盟商户结算关系确认函
    public function actionCheck() {
        if (isset($_GET['id'])) {
            $model = $this->loadModel($_GET['id']);
            $array = CJSON::decode($model->cont);
            $model->tranYuan = $array['tranYuan'];
        } else {
            $this->redirect(array('index'));
        }

        $this->render('view', array('model' => $model));
    }

    //删除联盟商户结算关系确认函
    public function actionDelete() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            Creditor::model()->deleteAll("id = $id");
            @SystemLog::record(Yii::app()->user->name."删除联盟商户结算关系确认函id:{$id} 成功");
            //$this->setFlash('success', Yii::t('home', '成功删除数据!'));
        } else {
        	@SystemLog::record(Yii::app()->user->name."删除联盟商户结算关系确认函id:{$_GET['id']} 失败");
            $this->setFlash('error', Yii::t('home', '删除数据失败!'));
            $this->redirect(array('index'));
        }

        $this->redirect(array('index'));
    }

    //导出world文件
    public function actionExport() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $model = $this->loadModel($id);
            $tmpArray = CJSON::decode($model->cont);
            $model->tranYuan = $tmpArray['tranYuan'];
            header("Content-Type:application/msword");
            header("Content-Disposition:attachment;filename=积分分配确认函_$model->creditor_tran.doc"); //指定文件名称   
            header("Pragma:no-cache");
            header("Expires:0");
            @SystemLog::record(Yii::app()->user->name."导出 '{$model->creditor_tran}' 联盟商户结算关系确认函成功");
            $this->renderPartial('creditor_export', array('model' => $model));
        } else {
        	@SystemLog::record(Yii::app()->user->name."导出联盟商户结算关系确认函id:{$_GET['id']} 失败");
            $this->setFlash('error', Yii::t('home', '导出失败!'));
            $this->redirect(array('index'));
        }
    }

}
