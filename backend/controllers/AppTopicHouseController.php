<?php

/**
 * 盖象APP主题控制器
 * @author shengjie.zhang
 */
class AppTopicHouseController extends Controller
{
    public function actionAdminHouse()
    {
        $model = new AppTopicHouse();
        $model->unsetAttributes();  // clear any default values
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /*
     * 添加馆
     * */
    public function actionCreate()
    {
        $model = new AppTopicHouse();
        $model->setScenario('create');
        $this->performAjaxValidation($model);
        $upload = false;
        $comHeadUrlSize = false;
        $pictureUrlSize = false;
        if (isset($_POST['AppTopicHouse'])) {
            $model->attributes = $_POST['AppTopicHouse'];
            $model->link = $_POST['AppTopicHouse']['link'];
            $saveDir = 'AppTopicHouse';
            if (!empty($_FILES['AppTopicHouse']['tmp_name']['comHeadUrl'])) {
                foreach ($_FILES['AppTopicHouse']['tmp_name'] as $k => $val) {
                    if(file_exists($val)) {
                        if($k == 'comHeadUrl') {
                            $pictureSize = false;
                            $ImageSize = getimagesize($val);
                            if(($ImageSize[0] == 500) && ($ImageSize[1] == 500)){
                                $pictureSize = true;
                            }else{
                            	$model->addError("comHeadUrl","请上传500*500的图片");
                            	$upload = true;
                                $comHeadUrlSize = true;
                            }
                        }else{
                            $pictureSize = false;
                            $ImageSize = getimagesize($val);
                            if(($ImageSize[0] == 1242) && ($ImageSize[1] == 350)){
                                $pictureSize = true;
                            }else{
                            	
                            	$model->addError("pictureUrl","请上传1242*350的图片");
                            	$upload = true;
                                $pictureUrlSize = true;
                            }
                        }
                    }
                    if($upload){
                    	$model->pictureUrl = "";
                    	$model->comHeadUrl = "";
                    	$this->render('create', array(
                    			'model' => $model,
                    	));
                    	exit;
                    }
                    if (file_exists($val) && getimagesize($val) && ($pictureSize)) {
                        $fileName = Tool::generateSalt() . '.' . pathinfo($_FILES['AppTopicHouse']['name'][$k], PATHINFO_EXTENSION);
                        $filePath = $saveDir . DS . $fileName;
                        if (UploadedFile::upload_file($val, $filePath, '', 'att'))
                            $model->$k = $filePath;
                    }
                }
                if ($model->save()) {
                    $this->setFlash('success', Yii::t('appTopicHouse', '添加成功'));
                    $this->redirect(array('appTopicHouse/adminHouse'));
                }
            }
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /*
     * 删除馆
     * */
    public function actionDelete()
    {
        $id = $this->getParam('id');
        $model = AppTopicHouse::model()->findByPk($id);
        if (!empty($model->comHeadUrl))
            @unlink(ATTR_DOMAIN . DS . $model->comHeadUrl); // 删除旧文件
        if (!empty($model->pictureUrl))
            @unlink(ATTR_DOMAIN . DS . $model->pictureUrl); // 删除旧文件
        if ($model->delete()) {
            $count = AppTopicHouseGoods::model()->deleteAll('house_id=:house_id',array(':house_id'=>$id));
            if($count) {
                $this->setFlash('success', Yii::t('appTopicHouse', '删除成功'));
                $this->redirect(array('appTopicHouse/adminHouse'));
            }
        }
    }

    /*
     * 更新馆
     * */
    public function actionUpdate()
    {
        $id = $this->getParam('id');
        $model = AppTopicHouse::model()->findByPk($id);
        $model->setScenario('update');
        $saveDir = 'AppTopicHouse';
        $upload = false;
        $comHeadUrlSize = false;
        $pictureUrlSize = false;
        if (isset($_FILES['AppTopicHouse']) || isset($_POST['AppTopicHouse'])) {
            if (isset($_POST['AppTopicHouse'])) {
                $model->attributes = $_POST['AppTopicHouse'];
                $model->link = $_POST['AppTopicHouse']['link'];
            }
            if (!empty($_FILES['AppTopicHouse']['tmp_name']['comHeadUrl']) || !empty($_FILES['AppTopicHouse']['tmp_name']['pictureUrl'])) {
                foreach ($_FILES['AppTopicHouse']['tmp_name'] as $k => $val) {
                    if(file_exists($val)) {
                        if($k == 'comHeadUrl') {
                            $pictureSize = false;
                            $ImageSize = getimagesize($val);
                            if(($ImageSize[0] == 500) && ($ImageSize[1] == 500)){
                                $pictureSize = true;
                            }else{
                            	$model->addError("comHeadUrl","请上传500*500的图片");
                            	$upload = true;
                                $comHeadUrlSize = true;
                            }
                        }else{
                            $pictureSize = false;
                            $ImageSize = getimagesize($val);
                            if(($ImageSize[0] == 1242) && ($ImageSize[1] == 350)){
                                $pictureSize = true;
                            }else{
                            	$model->addError("pictureUrl","请上传500*500的图片");
                            	$upload = true;
                                $pictureUrlSize = true;
                            }
                        }
                    }
                    if($upload){
                    	$this->render('update', array(
                    			'model' => $model,
                    	));
                    	exit;
                    }
                    if (file_exists($val) && getimagesize($val) && ($pictureSize)) {
                        $fileName = Tool::generateSalt() . '.' . pathinfo($_FILES['AppTopicHouse']['name'][$k], PATHINFO_EXTENSION);
                        $filePath = $saveDir . DS . $fileName;
                        if (UploadedFile::upload_file($val, $filePath, '', 'att'))
                            $model->$k = $filePath;
                    }
                }


                        if ($comHeadUrlSize && $pictureUrlSize) {
                            $this->setFlash('error', Yii::t('appTopicHouse', '头像图片尺寸 1:1，馆内专题图尺寸 1242*350 '));
                        }elseif($comHeadUrlSize){
                            $this->setFlash('error', Yii::t('appTopicHouse', '头像图片尺寸 1:1'));
                        }elseif($pictureUrlSize){
                            $this->setFlash('error', Yii::t('appTopicHouse', '馆内专题图尺寸 1242*350'));
                        }
            }
            if ($model->save()) {
                $this->setFlash('success', Yii::t('appTopicHouse', '添加成功'));
                $this->redirect(array('appTopicHouse/adminHouse'));
            }
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /*
     * 添加商品
     * */
    public function actionAddGoods()
    {
        $id = $this->getParam('id');
        $model = new Goods();
        $AppHouseModel = new AppTopicHouse();
        $Appmodel = AppTopicHouse::model()->findByPk($id);
        if(isset($_GET['AppTopicHouse'])){
            if($_GET['AppTopicHouse']['enTer'] == AppTopicHouse::ENTER_ID){
                $model->store_id = $_GET['AppTopicHouse']['enTerTit'];
            }else{
                $memberId = Member::getUserInfoByGw($_GET['AppTopicHouse']['enTerTit'],'id');
                if(!empty($memberId)) {
                    $storeId = Yii::app()->db->createCommand()
                        ->select('id')
                        ->from(Store::model()->tableName())
                        ->where('member_id = :member_id', array(':member_id' => $memberId['id']))
                        ->queryScalar();
                    if(!empty($storeId)){
                        $model->store_id = $storeId;
                    }
                }
            }
            $model->enTerTit = $_GET['AppTopicHouse']['enTerTit'];
            if($_GET['AppTopicHouse']['goods'] == AppTopicHouse::GOODS_ID){
                $model->id = $_GET['AppTopicHouse']['goodsTit'];
            }else{
                $model->name = $_GET['AppTopicHouse']['goodsTit'];
            }
        }
        $this->render('addgoods', array(
            'model' => $model,
            'AppHouseModel' => $AppHouseModel,
            'Appmodel' => $Appmodel
        ));
    }

    /*
 * 添加商品列表
 * */
    public function actionAddGoodsView()
    {
        $id = $this->getParam('id');
        $model =new AppTopicHouseGoods();
        $model->house_id = $id;
        $this->render('addgoodsview', array(
            'model' => $model,
            'Hid' => $id
        ));
    }

    /*
     * ajax添加商品
     * */
    public function actionAjaxAddGoods()
    {
        $report = 0;
        $active = false;
        $activeId = "";
        if ($this->isPost()) {
            $house_Posid = $_POST['houseId'];
            foreach ($_POST['ids'] as $v) {
            	//检查商品是否有参加活动
            	if(AppTopicHouseGoods::checkBindActive($v)){
            		$active = true;
            		$activeId = $activeId.$v." ";
            		continue;
            	}
                if (!AppTopicHouseGoods::checkBondGoods($house_Posid, $v)) {
                    $Appmodel = new AppTopicHouseGoods();
                    $Appmodel->house_id = $house_Posid;
                    $Appmodel->goods_id = $v;
                    $Appmodel->sequence = 1;
                    $Appmodel->save();
                } else {
                    $report = 1;
                }
            }
            AppTopicHouse::UdateGoodsNum($house_Posid);
        }
        if($active){
        	echo $activeId;
        }else{
        	echo $report;
        }
        
    }

    /*
     * 修改商品排序
     * */
    public function actionAddSequence()
    {
        if ($this->isAjax() && $this->isPost()) {
            $Hid = $this->getPost('Hid');
            $Gid = $this->getPost('Gid');
            $sequence = $this->getPost('sequence');
            $HGid = AppTopicHouseGoods::checkBondGoods($Hid, $Gid);
            $model = AppTopicHouseGoods::model()->findByPk($HGid);
            $model->sequence = $sequence;
            if ($model->save(false)) {
                exit(json_encode(array('success' => '添加备注成功')));
            } else
                exit(json_encode(array('error' => '添加备注失败')));
        }
    }

    /*
     * 删除馆与商品关联
     * */
    public function actionDeleteGoods()
    {
        $Hid = $this->getParam('Hid');
        $Gid = $this->getParam('Gid');
        $HGid = AppTopicHouseGoods::checkBondGoods($Hid, $Gid);
        if (!empty($HGid)) {
            $model = AppTopicHouseGoods::model()->findByPk($HGid);
            if ($model->delete()) {
                $this->setFlash('success', Yii::t('appTopicHouse', '删除成功'));
            } else
                $this->setFlash('success', Yii::t('appTopicHouse', '删除失败'));
        } else {
            $this->setFlash('success', Yii::t('appTopicHouse', '删除失败'));
        }
        AppTopicHouse::UdateGoodsNum($Hid);
        $this->redirect(array('appTopicHouse/addGoodsView','id'=>$Hid));
    }
    /*
     * 添加商品详情
     * */
    public function actionAddGoodsDateils(){
        $Gid = $this->getParam('Gid');
        if(empty($Gid)){
            $this->setFlash('error','参数错误');
            $this->redirect(array('AdminHouse'));
        }
        $model = AppTopicGoodsDetails::checkGodos($Gid);
        if(isset($_POST['AppTopicGoodsDetails'])){
            $model->dateils = $_POST['AppTopicGoodsDetails']['dateils'];
            $model->label = $_POST['AppTopicGoodsDetails']['label'];
            if($model->save()) {
                $this->setFlash('success', Yii::t('home', '数据保存成功'));
            }
        }
        $this->render('houseconfig', array(
            'model' => $model,
        ));
    }
    /*
     * 上传标题图片
     * */
    public function actionTitlePic(){
        $filePath = Yii::app()->db->createCommand()
            ->select('titlePicture,id')
            ->from(AppTopicHousePicture::model()->tableName())
            ->order('id DESC')
            ->queryRow();
        if(!empty($filePath)){
            $model = AppTopicHousePicture::model()->findByPk($filePath['id']);
        }else{
            $model = new AppTopicHousePicture();
        }
        if (isset($_FILES['AppTopicHousePicture'])) {
            $saveDir = 'AppTopicHousePic';
            if (!empty($_FILES['AppTopicHousePicture']['tmp_name']['titlePicture'])) {
                $val = $_FILES['AppTopicHousePicture']['tmp_name']['titlePicture'];
                $ImageSize = getimagesize($val);
                if(($ImageSize[0] != 1242) || ($ImageSize[1] != 160)){
                	$model->addError("titlePicture","请上传1242*160的图片");
                	$this->render('housepic', array(
			            'model' => $model,
			            'filePath'=>$model->titlePicture,
			        ));
                	exit;
                }
                    if (file_exists($val) && getimagesize($val)) {
                        $fileName = Tool::generateSalt() . '.' . pathinfo($_FILES['AppTopicHousePicture']['name']['titlePicture'], PATHINFO_EXTENSION);
                        $filePath = $saveDir . DS . $fileName;
                        if (UploadedFile::upload_file($val, $filePath, '', 'att'))
                            $model->titlePicture = $filePath;
                    }
            }
            if($model->save()){
                $this->setFlash('success', Yii::t('home', '数据保存成功'));
            }
        }
        $this->render('housepic', array(
            'model' => $model,
            'filePath'=>$model->titlePicture,
        ));
    }
}