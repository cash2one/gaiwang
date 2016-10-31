<?php

class BusinessController extends Controller {

//	public function beforeAction($action)
//	{
//		//先不发布
//		die;
//	}
    public function actionIndex() {
        $model = new Business('search');
        $model->unsetAttributes();

        if (isset($_GET['Business'])) {
            $model->store = $_GET['Business']['store'];
        }

        $this->breadcrumbs = array('联盟商户关系结算确认函', '列表');
        $this->render('index', array('model' => $model));
    }

    //新建联盟商户结算关系确认函
    public function actionCreate() {
        $model = new Business;
        $model->unsetAttributes();
        $check = false;
        $data = array();
        //ajax表单验证
        $this->performAjaxValidation($model);
        if (isset($_POST['Business'])) {
            $model->store = $_POST['Business']['store'];
            $storeName = $_POST['Business']['store'];
            if (isset($_POST['branch'])) {
                $tmpArray = array();
                $data = $_POST['branch'];
                $tmpArray['branch'] = $_POST['branch'];
                $model->cont = CJSON::encode($tmpArray);
            }
            //判断改公司是否已签约
            $rsComapny = Business::model()->findByAttributes(array('store' => $storeName));
            if (empty($rsComapny)) {
                $sqlGw = "select m.gai_number from {{enterprise}} t left join {{member}} m on m.id=t.member_id where t.name='$storeName'";
                $rs = Yii::app()->db->createCommand($sqlGw)->queryRow();
                if (isset($rs)) {//获取该公司GW号
                    $model->gai_number = $rs['gai_number'];
                }
                if ($model->save()) {
                	@SystemLog::record(Yii::app()->user->name."新建  {$model->gai_number} 联盟商户结算关系确认函成功");
                    $this->setFlash('success', Yii::t('home', '数据保存成功'));
                    $this->redirect(array('index'));
                }else{
                	@SystemLog::record(Yii::app()->user->name."新建  {$model->gai_number} 联盟商户结算关系确认函失败");
                }
            } else {
                $check = true;
            }
        }

        $this->render('_create', array('model' => $model, 'data' => $data, 'check' => $check));
    }

    //编辑联盟商户结算关系确认函
    public function actionUpdate() {
        if (isset($_GET['id'])) {
            $data = array();
            $model = $this->loadModel($_GET['id']);
            $array = CJSON::decode($model->cont);
            if (!empty($array)) {
                $data = $array['branch'];
            }
        } else {
            $this->redirect(array('index'));
        }

        $check=true;
        //ajax表单验证
        $this->performAjaxValidation($model);

        if (isset($_POST['Business'])) {
            $model->store = $_POST['Business']['store'];
            if (isset($_POST['branch'])) {
                $tmpArray = array();
                $tmpArray['branch'] = $_POST['branch'];
                $model->cont = CJSON::encode($tmpArray);
            }
            if ($model->save()) {
            	@SystemLog::record(Yii::app()->user->name."编辑  {$model->gai_number} 联盟商户结算关系确认函成功");
                $this->setFlash('success', Yii::t('home', '数据保存成功'));
                $this->redirect(array('index'));
            }else{
            	@SystemLog::record(Yii::app()->user->name."编辑  {$model->gai_number} 联盟商户结算关系确认函失败");
            }
        }

        $this->render('_update', array('model' => $model, 'data' => $data,'check'=>$check));
    }

    //查看联盟商户结算关系确认函
    public function actionCheck() {
        if (isset($_GET['id'])) {
            $data = array();
            $model = $this->loadModel($_GET['id']);
            $array = CJSON::decode($model->cont);
            if (!empty($array)) {
                $data = $array['branch'];
            }
        } else {
            $this->redirect(array('index'));
        }

        $this->render('view', array('model' => $model, 'data' => $data));
    }

    //删除联盟商户结算关系确认函
    public function actionDelete() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            Business::model()->deleteAll("id = $id");
            @SystemLog::record(Yii::app()->user->name."删除  联盟商户结算关系确认函id:{$id} 成功");
            //$this->setFlash('error', Yii::t('home', '成功删除数据!'));
        } else {
            $this->redirect(array('index'));
        }

        $this->redirect(array('index'));
    }

    //到处world文件
    public function actionExport() {
        if (isset($_GET['id'])) {
            $data = array();
            $id = $_GET['id'];
            $model = $this->loadModel($id);
            $tmpArray = CJSON::decode($model->cont);
            $data = $tmpArray['branch'];            
            header("Content-Type:application/msword");
            header("Content-Disposition:attachment;filename=联盟商户结算关系确认函_$model->store.doc"); //指定文件名称
            header("Pragma:no-cache");
            header("Expires:0");
            @SystemLog::record(Yii::app()->user->name."导出  联盟商户结算关系确认函 id:{$id} 成功");
            $this->renderPartial('store_export', array('model' => $model, 'data' => $data));
        } else {
        	@SystemLog::record(Yii::app()->user->name."导出  联盟商户结算关系确认函 id:{$id} 失败");
            $this->setFlash('error', Yii::t('home', '导出失败!'));
            $this->redirect(array('index'));
        }
    }

}
