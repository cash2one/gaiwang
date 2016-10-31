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

        $this->breadcrumbs = array('债权转移确认函', '列表');
        $this->render('index', array('model' => $model));
    }

    //新建债权转移确认函
    public function actionCreate() {
    	die;
        $model = new Creditor;
        $model->unsetAttributes();
        $submit = true;
        $check = true;                 //true表示已签约false表示未签约
        $gw = Yii::app()->User->gw;

        //查询乙方公司名称
        $sql = "select m.name from {{member}} t left join {{enterprise}} m on t.id=m.member_id where t.gai_number='$gw'";
        $dataStore = Yii::app()->db->createCommand($sql)->queryAll();
        if (!empty($dataStore)) {
            $model->creditor_tran = $dataStore[0]['name'];
        }

        //检查是否已签约
        $dataCreditor = Creditor::model()->findByAttributes(array('gai_number' => $gw));
        if (!empty($dataCreditor)) {
            $tmpArray = CJSON::decode($dataCreditor['cont']);
            $model->creditor_tran = $dataCreditor['creditor_tran'];
            $model->tranYuan = $tmpArray['tranYuan'];
            $model->create_time = $dataCreditor['create_time'];
            $submit = false;
        } else {
            $sql3 = "select * from {{account_flow}} where gai_number = '$gw' order by create_time desc limit 1";
            $data3 = Yii::app()->db->createCommand($sql3)->queryRow();

            $sql4 = "select * from {{account_flow_201404}} where gai_number = '$gw' order by create_time desc limit 1";
            $data4 = Yii::app()->db->createCommand($sql4)->queryRow();

            $data3['create_time'] = $data3['create_time'] == "" ? 0 : $data3['create_time'];
            $data4['create_time'] = $data4['create_time'] == "" ? 0 : $data4['create_time'];
            
            if(!isset($data4['credit_current_amount']) && !isset($data3['credit_current_amount'])){
                $data3['credit_current_amount']="0.00";
                $data4['credit_current_amount']="0.00";
            }

            $model->tranYuan = $data4['create_time'] > $data3['create_time'] ? $data4['credit_current_amount'] : $data3['credit_current_amount'];
            //$model->tranYuan = $model->tranYuan == "" ? 0.00 : $model->tranYuan;
            $check = false;
        }
        //ajax表单验证
        $this->performAjaxValidation($model);
        if (isset($_POST['Creditor'])) {
            $model->creditor_tran = $_POST['Creditor']['creditor_tran'];
            $model->tranYuan = $_POST['Creditor']['tranYuan'];
            $tmpArray = array();
            //$tmpArray['creditor_tran'] = $_POST['Creditor']['creditor_tran'];
            $tmpArray['tranYuan'] = $_POST['Creditor']['tranYuan'];
            $model->cont = CJSON::encode($tmpArray);
            if ($model->save()) {
                //$this->setFlash('success', Yii::t('home', '数据保存成功'));
                $submit = false;
                $check = true;
                //判断该用户是否存在加盟商
                $sql = "select f.* from {{franchisee}} f left join {{member}} cm on cm.id=f.member_id left join {{member}} pm on pm.id=cm.pid where pm.gai_number='$gw'";
                $data5 = Yii::app()->db->createCommand($sql)->queryAll();
                if (!empty($data5)) {
                    $this->redirect(array('business/create'));
                    Yii::app()->end();
                }
            }
        }

        $this->renderPartial('_create', array('model' => $model, 'submit' => $submit, 'check' => $check));
    }

    //编辑联盟商户结算关系确认函
    public function actionUpdate() {
        if (isset($_GET['id'])) {
            $model = $this->loadModel($_GET['id']);
            //Tool::p($model);
            $array = CJSON::decode($model->cont);
            $model->attributes = $array;
            $model->creditor_tran = $array['creditor_tran'];
            $model->creditorTranAgent = $array['creditorTranAgent'];
            $model->creditor = $array['creditor'];
            $model->creditorAgent = $array['creditorAgent'];
            $model->OriginalObligor = $array['OriginalObligor'];
            $model->OriginalAgent = $array['OriginalAgent'];
            $model->tranYuan = $array['tranYuan'];
            $model->creditorYuan = $array['creditorYuan'];
            $model->OriginalYuan = $array['OriginalYuan'];
            //Tool::pr($array);
        } else {
            $this->redirect(array('index'));
        }

        //ajax表单验证
        $this->performAjaxValidation($model);
        //Tool::pr($_POST['Creditor']);
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
                $model->creditorTranAgent = $_POST['Creditor']['creditorTranAgent'];
                $model->creditor = $_POST['Creditor']['creditor'];
                $model->creditorAgent = $_POST['Creditor']['creditorAgent'];
                $model->OriginalObligor = $_POST['Creditor']['OriginalObligor'];
                $model->OriginalAgent = $_POST['Creditor']['OriginalAgent'];
                $model->tranYuan = $_POST['Creditor']['tranYuan'];
                $model->creditorYuan = $_POST['Creditor']['creditorYuan'];
                $model->OriginalYuan = $_POST['Creditor']['OriginalYuan'];
                $tmpArray = array();
                $tmpArray['creditor_tran'] = $_POST['Creditor']['creditor_tran'];
                $tmpArray['creditorTranAgent'] = $_POST['Creditor']['creditorTranAgent'];
                $tmpArray['creditor'] = $_POST['Creditor']['creditor'];
                $tmpArray['creditorAgent'] = $_POST['Creditor']['creditorAgent'];
                $tmpArray['OriginalObligor'] = $_POST['Creditor']['OriginalObligor'];
                $tmpArray['OriginalAgent'] = $_POST['Creditor']['OriginalAgent'];
                $tmpArray['tranYuan'] = $_POST['Creditor']['tranYuan'];
                $tmpArray['creditorYuan'] = $_POST['Creditor']['creditorYuan'];
                $tmpArray['OriginalYuan'] = $_POST['Creditor']['OriginalYuan'];
                $model->cont = CJSON::encode($tmpArray);
                //Tool::pr($model->attributes);
                if ($model->save()) {
                    $this->setFlash('success', Yii::t('home', '数据保存成功'));
                    $this->redirect(array('index'));
                }
            } else {
                $this->setFlash('error', Yii::t('home', '数据没有变更!'));
                $this->redirect(array('index'));
            }
        }

        $this->render('_update', array('model' => $model));
    }

    //查看联盟商户结算关系确认函
    public function actionCheck() {
        if (isset($_GET['id'])) {
            $model = $this->loadModel($_GET['id']);
            $array = CJSON::decode($model->cont);
            $model->attributes = $array;
            $model->attributes = $array;
            $model->creditor_tran = $array['creditor_tran'];
            $model->creditorTranAgent = $array['creditorTranAgent'];
            $model->creditor = $array['creditor'];
            $model->creditorAgent = $array['creditorAgent'];
            $model->OriginalObligor = $array['OriginalObligor'];
            $model->OriginalAgent = $array['OriginalAgent'];
            $model->tranYuan = $array['tranYuan'];
            $model->creditorYuan = $array['creditorYuan'];
            $model->OriginalYuan = $array['OriginalYuan'];
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
            $this->setFlash('error', Yii::t('home', '成功删除数据!'));
        } else {
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
            $model->attributes = $tmpArray;
            header("Content-Type:application/msword");
            header("Content-Disposition:attachment;filename=债权转移确认函_$model->creditor_tran.doc"); //指定文件名称   
            header("Pragma:no-cache");
            header("Expires:0");
            $this->renderPartial('creditor_export', array('model' => $model));
        } else {
            $this->redirect(array('index'));
        }
    }

}
