<?php

class BusinessController extends Controller {

//	public function beforeAction($action)
//	{
//		//先不发布
//		die;
//	}
    public function actionIndex() {
        $model = new Business;
        $model->unsetAttributes();

        $this->breadcrumbs = array('联盟商户关系结算确认函', '列表');
        $this->render('index', array('model' => $model));
    }

    //新建联盟商户结算关系确认函
    public function actionCreate() {
        $model = new Business;
        $model->unsetAttributes();
        $submit = true;
        $check = true;                //true表示已签约false表示未签约
        $gw = Yii::app()->User->gw;

        //公司名称
        $sql2 = "select m.name from {{member}} t left join {{enterprise}} m on t.id=m.member_id where t.gai_number='$gw'";
        $dataStore = Yii::app()->db->createCommand($sql2)->queryAll();

        $dataBusiness = Business::model()->findByAttributes(array('gai_number' => $gw));
        if (!empty($dataBusiness)) {
            $tmpArray = CJSON::decode($dataBusiness['cont']);
            $data = $tmpArray['branch'];
            $model->store = $dataBusiness['store'];
            $model->create_time = $dataBusiness['create_time'];
            $submit = false;
        } else {
            $sql = "select f.* from {{franchisee}} f left join {{member}} cm on cm.id=f.member_id left join {{member}} pm on pm.id=cm.pid where pm.gai_number='$gw'";
            $dataAll = Yii::app()->db->createCommand($sql)->queryAll();
            $data = array();
            if (!empty($dataAll)) {
                foreach ($dataAll as $key => $value) {
                    $data[] = $value['name'];
                }
            }
            $model->store = $dataStore[0]['name'];
            $check = false;
        }

        //ajax表单验证
        $this->performAjaxValidation($model);
        if (isset($_POST['Business'])) {
            $model->store = $_POST['Business']['store'];
            $tmpArray = array();
            if (isset($_POST['branch'])) {
                $tmpArray['branch'] = $_POST['branch'];
                $model->cont = CJSON::encode($tmpArray);
                $data=$_POST['branch'];
            }
            if ($model->save()) {
                //$this->setFlash('success', Yii::t('home', '数据保存成功'));
                $submit = false;
                $check = true;
                //$this->redirect('create');
            }
        }

        $this->renderPartial('_create', array('model' => $model, 'data' => $data, 'submit' => $submit, 'check' => $check));
    }

    //编辑联盟商户结算关系确认函
    public function actionUpdate() {
        if (isset($_GET['id'])) {
            $model = $this->loadModel($_GET['id']);
            $array = CJSON::decode($model->cont);
            $model->attributes = $array;
        } else {
            $this->redirect(array('index'));
        }

        //ajax表单验证
        $this->performAjaxValidation($model);

        if (isset($_POST['Business'])) {
            //验证数据是否有编辑数据
            $edit = false;
            foreach ($_POST['Business'] as $key => $value) {
                if ($model->$key != $value) {
                    $edit = true;
                }
            }
            if ($edit) {
                $model->store = $_POST['Business']['store'];
                $model->branch = $_POST['Business']['branch'];
                $model->storeAgent = $_POST['Business']['storeAgent'];
                $model->branchAgent = $_POST['Business']['branchAgent'];
                $tmpArray = array();
                $tmpArray['store'] = $_POST['Business']['store'];
                $tmpArray['branch'] = $_POST['Business']['branch'];
                $tmpArray['storeAgent'] = $_POST['Business']['storeAgent'];
                $tmpArray['branchAgent'] = $_POST['Business']['branchAgent'];
                $model->cont = CJSON::encode($tmpArray);
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
        } else {
            $this->redirect(array('index'));
        }

        $this->render('view', array('model' => $model));
    }

    //删除联盟商户结算关系确认函
    public function actionDelete() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            Business::model()->deleteAll("id = $id");
            $this->setFlash('error', Yii::t('home', '成功删除数据!'));
        } else {
            $this->redirect(array('index'));
        }

        $this->redirect(array('index'));
    }

    //到处world文件
    public function actionExport() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $model = $this->loadModel($id);
            $tmpArray = CJSON::decode($model->cont);
            $model->attributes = $tmpArray;
            header("Content-Type:application/msword");
            header("Content-Disposition:attachment;filename=联盟商户结算关系确认函_$model->store.doc"); //指定文件名称
            header("Pragma:no-cache");
            header("Expires:0");
            $this->renderPartial('store_export', array('model' => $model));
        } else {
            $this->redirect(array('index'));
        }
    }

}
