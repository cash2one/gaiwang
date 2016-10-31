<?php
/*
 * 臻致生活，话题列表
 * */
class AppTopicLifeController extends Controller{
    protected function setCurMenu($name) {
        $this->curMenu = Yii::t('main', '盖象APP');
    }
    
    public function actionAdmin()
	{
		$model=new AppTopicLife('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AppTopicLife']))
			$model->attributes=$_GET['AppTopicLife'];
		$this->render('admin',array(
			'model'=>$model,
		));
	}
    /*
     * 添加专题
     * */
    function actionCreate(){
        $model = new AppTopicLife();
        $this->performAjaxValidation($model);
        $model->setScenario('create');
        if (!empty($_POST)) {
            $LifeData = $this->getParam('AppTopicLife');
            $model->attributes = $this->getParam('AppTopicLife');
            $model->online_time = strtotime($LifeData['online_time']);
            $model->profess_proof = $LifeData['profess_proof'];
            $model->admin_id = Yii::app()->user->id;
            $model->create_time = time();
            $saveDir = 'AppTopicLife';
            if($LifeData['rele_status'] == AppTopicLife::RELE_STATUS_YES){
                $model->audit_status = AppTopicLife::AUDIT_STATUS_NOW;
                $model->rele_time = time();
            }else{
                $model->audit_status = AppTopicLife::AUDIT_STATUS_NOW;
                $model->rele_time = '';
            }
            if (!empty($_FILES['AppTopicLife']['tmp_name']['comHeadUrl'])) {
                foreach ($_FILES['AppTopicLife']['tmp_name'] as $k => $val) {
                    if (file_exists($val) && getimagesize($val)) {
                        $fileName = Tool::generateSalt() . '.' . pathinfo($_FILES['AppTopicLife']['name'][$k], PATHINFO_EXTENSION);
                        $filePath = $saveDir . DS . $fileName;
                        if (UploadedFile::upload_file($val, $filePath, '', 'att'))
                            $model->$k = $filePath;
                    }
                }
            }
            $goodsData = array();
            $Test = true;
            //处理商品信息
            if (!empty($_POST['goodsIds'])) {

                $goodsIds = $_POST['goodsIds'];
                //$goodCategoryName = $_POST['goodCategoryName'];
                //$goodCode = $_POST['goodCode'];
                //$goodPrice = $_POST['goodPrice'];
                //$goodPrice = $_POST['goodPrice'];
                $goodsImgs = $_FILES['goodsImgs'];
                $goodOrder = $_POST['goodOrder'];

                foreach ($_POST['goodsIds'] as $key => $val) {
                    $tmepgoodsdata = array();
                    $tmepgoodsdata['goodsIds'] = $val;
                    //$tmepgoodsdata['goodCategoryName'] = $goodCategoryName[$key];
                    //$tmepgoodsdata['goodCode'] = $goodCode[$key];
                    //$tmepgoodsdata['goodPrice'] = $goodPrice[$key];
                    $tmepgoodsdata['goodOrder'] = $goodOrder[$key];
                    //$tmepgoodsdata['goodsImgs'] = $goodsImgs[$key];
                    $fileName = Tool::generateSalt() . '.' . pathinfo($goodsImgs['name'][$key], PATHINFO_EXTENSION);
                    $filePath = $saveDir . DS . $fileName;
                    if (UploadedFile::upload_file($goodsImgs['tmp_name'][$key], $filePath, '', 'att')) {
                        $tmepgoodsdata['goodsImgs'] = $filePath;
                    }
                    array_push($goodsData, $tmepgoodsdata);
                }

                $model->goods_list = json_encode($goodsData);
            }
            if ($model->save()) {
                $this->setFlash('success', Yii::t('AppTopicLife', '添加成功'));
                $this->redirect(array('AppTopicLife/admin'));
            }
        }
        $this->render('create',array(
            'model'=>$model,
            'subcontent'=>'',
        ));
    }
//AJAX验证商品ID是否是上架产品
    public function actionchechkGoods() {
        if ($this->isAjax() && $this->isPost()) {
            $id = $this->getPost('id');
            if(!is_numeric($id)){
                exit(json_encode(array('error' => '商品ID只能填写数字！')));
            }
            if (empty($id)) {
                exit(json_encode(array('error' => '商品ID不能为空！')));
            }

            $goods =Yii::app()->db->createCommand()
                ->select('g.id,g.is_publish,g.status,g.price,g.code,c.name')
                ->from('{{goods}} as g')
                ->leftjoin('{{category}} as c','c.id = g.category_id')
                ->where('g.id = :id',array(":id"=>$id))
                ->queryRow();

            if (empty($goods)) {
                exit(json_encode(array('error' => '该商品不存在，请重新选择商品！')));
            }
            if ($goods['is_publish'] == Goods::PUBLISH_NO || $goods['status'] != Goods::STATUS_PASS) {
                exit(json_encode(array('error' => '该商品未上架或未通过审核，请重新选择商品！')));
            }
            if ($goods['is_publish'] == Goods::PUBLISH_YES) {
                exit(json_encode($goods));
            }
        }
    }
    /*
     * 删除专题
     * */
    function actionDelete(){
        $lifeId = $this->getParam('id');
        $model = AppTopicLife::model()->findByPk($lifeId);
        if($model->delete()){
            exit(json_encode(array('success' => '删除成功！')));
        }

    }
    public function actionUpdate()
    {
        $lifeId = $this->getParam('id');
        $model = AppTopicLife::model()->findByPk($lifeId);
        //初始化赋值
        $model->online_time =date('Y-m-d H:i:s',$model->online_time);
        $subcontent = json_decode($model->goods_list,TRUE);
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        $model->setScenario('update');
        if(isset($_POST['AppTopicLife']))
        {
            $LifeData = $this->getPost('AppTopicLife');
            $model->attributes = $LifeData;
            $model->online_time = strtotime($LifeData['online_time']);
            $model->profess_proof = $LifeData['profess_proof'];
            $model->create_time = time();
            if($LifeData['rele_status'] == AppTopicLife::RELE_STATUS_YES){
                $model->audit_status = AppTopicLife::AUDIT_STATUS_NOW;
                $model->rele_time = time();
            }else{
                $model->audit_status = AppTopicLife::AUDIT_STATUS;
                $model->rele_time = '';
            }
            $saveDir = 'AppTopicLife';
            if (!empty($_FILES['AppTopicLife']['tmp_name']['comHeadUrl']) || !empty($_FILES['AppTopicLife']['tmp_name']['pictureUrl'])) {
                foreach ($_FILES['AppTopicLife']['tmp_name'] as $k => $val) {
                    if (file_exists($val) && getimagesize($val)) {
                        $fileName = Tool::generateSalt() . '.' . pathinfo($_FILES['AppTopicLife']['name'][$k], PATHINFO_EXTENSION);
                        $filePath = $saveDir . DS . $fileName;
                        if (UploadedFile::upload_file($val, $filePath, '', 'att'))
                            $model->$k = $filePath;
                    }
                }
            }
            $goodsData = array();
            //商品信息
            if(!empty($_POST['goodsIds'])){
                $goodsIds = $_POST['goodsIds'];
                //$goodCategoryName = $_POST['goodCategoryName'];
                //$goodCode = $_POST['goodCode'];
                //$goodPrice = $_POST['goodPrice'];
                //$goodPrice = $_POST['goodPrice'];
                $goodsImgs = $_FILES['goodsImgs'];
                $goodOrder = $_POST['goodOrder'];
                if(isset($_POST['goodsImgsold'])){
                    $goodsImgsold = $_POST['goodsImgsold'];
                }

                foreach ($_POST['goodsIds'] as $key=>$val){
                    $tmepgoodsdata = array();
                    $tmepgoodsdata['goodsIds'] = $val;
                    //$tmepgoodsdata['goodCategoryName'] = $goodCategoryName[$key];
                    //$tmepgoodsdata['goodCode'] = $goodCode[$key];
                    //$tmepgoodsdata['goodPrice'] = $goodPrice[$key];
                    $tmepgoodsdata['goodOrder'] = $goodOrder[$key];
                    //$tmepgoodsdata['goodsImgs'] = $goodsImgs[$key];
                    if($goodsImgs['name'][$key] == ''){
                        $tmepgoodsdata['goodsImgs'] = $goodsImgsold[$key];
                    }else{
                        $fileName = Tool::generateSalt(). '.'.pathinfo($goodsImgs['name'][$key],PATHINFO_EXTENSION);
                        $filePath = $saveDir.DS.$fileName;
                        if(UploadedFile::upload_file($goodsImgs['tmp_name'][$key],$filePath,'','att')){
                            $tmepgoodsdata['goodsImgs'] = $filePath;
                        }
                    }
                    array_push($goodsData, $tmepgoodsdata);
                }
                $model->goods_list = json_encode($goodsData);
            }
            if($model->save()){
                $this->setFlash('success', Yii::t('AppTopicCar', '修改成功'));
                $this->redirect(array('AppTopicLife/admin'));
            }
        }

        $this->render('update',array(
            'model'=>$model,
            'subcontent'=>$subcontent
        ));
    }
    /*
     * 删除专题商品
     * */
    function actionDeleteGoods(){
        $lifeId = $this->getParam('id');
        $key = $this->getParam('key');
        $model = AppTopicLife::model()->findByPk($lifeId);
        $subcontent = json_decode($model->goods_list,TRUE);
        //echo "<pre>";
        //var_dump($subcontent);
        //var_dump($key);
        if(!array_key_exists($key, $subcontent)){
                exit;
        }
        $keys = array_keys($subcontent);
        $index = array_search($key, $keys);
        if($index !== FALSE){
            array_splice($subcontent, $index, 1);
        }
        //var_dump($subcontent);
        $model->goods_list = json_encode($subcontent);
        $model->save(false);
    }
    /*
     * 开启/停用 专题
     * */
    function actionUseStatus(){
        if ($this->isAjax() && $this->isPost()) {
            $lifeId = $this->getParam('id');
            $model = AppTopicLife::model()->findByPk($lifeId);
            $model->disable = empty($model->disable) ? 1 : 0;
            if ($model->save(false)) {
                exit(json_encode(array('success' => '修改成功！','useStatus'=>AppTopicLife::getDisable($model->disable))));
            }else{
                exit(json_encode(array('error' => '修改失败！')));
            }
        }
    }
    /*
   * 获取不通过原因
   * */
    function actionCanNotPass(){
        if ($this->isAjax() && $this->isPost()) {
            $lifeId = $this->getParam('id');
            $model = AppTopicLife::model()->findByPk($lifeId);
           echo json_encode($model->error_field);
        }
    }
    /*
     * 查看话题
     * */
    function actionLookProblem(){
        $lifeId = $this->getParam('id');
        $model = new AppTopicProblem();
        $create_time_max = '';
        $create_time_min = '';
        $nickname = '';
        $status = '';
        
        if(isset($_GET['AppTopicProblem'])){
            $lifeData = $this->getParam('AppTopicProblem');
            if(!empty($lifeData['create_time'])){
                $create_time_max = strtotime($lifeData['create_time'].' '.'23:59:59');
                $create_time_min = strtotime($lifeData['create_time'].' '.'00:00:00');
            }
            $nickname = !empty($lifeData['nickname'])?$lifeData['nickname']:'';
            $status = $lifeData['status']!=''?$lifeData['status']:'';
        }
        $Data = AppTopicProblem::getLifeData($lifeId,$create_time_max,$create_time_min,$nickname,$status);
        //var_dump($Data);exit;
        $ChildList = array();
        if(!empty($Data)){
            $user_id = Yii::app()->user->id;
            foreach($Data as $val){
                $ChildList[$val['id']] = AppTopicProblem::getLifeChildListData($lifeId, $val['id']);
                $getLifeAgen[$val['id']] = AppTopicProblem::getLifeAgen($lifeId, $val['id']);
            }
        }
        $this->render('problemview',array(
            'model'=>$model,
            'lifeId'=>$lifeId,
            'lifeData'=>isset($Data)?$Data:'',
            'ChildList'=>isset($ChildList)?$ChildList:'',
            'getLifeAgen'=>isset($getLifeAgen)?$getLifeAgen:'',
        ));
    }
    /*
     * 代理商回复/修改话题
     * */
    function actionAgentReply(){
        $user_id = Yii::app()->user->id;
        if ($this->isAjax() && $this->isPost()) {
            $id = $this->getPost('id');
            $remark = $this->getPost('remark');
            $LifeModel = AppTopicProblem::model()->find(array(
                'condition' =>'parent_id=:parent_id AND admin_id=:admin_id',
                'params' => array(':parent_id'=>$id,':admin_id' => $user_id),
                ));
            if(!empty($LifeModel)) {
                if ($remark == 'data') {
                    echo json_encode($LifeModel->problem);
                    exit;
                } else {
                    $LifeModel->problem = addslashes($remark);
                    if ($LifeModel->save(false)) {
                        exit(json_encode(array('success' => '添加成功')));
                    } else
                        exit(json_encode(array('error' => '添加失败')));
                }
            }else{
                if ($remark == 'data') {
                    exit;
                } else {
                    $model = AppTopicProblem::model()->findByPk($id);
                    $LifeModel = new AppTopicProblem();
                    $LifeModel->problem = $remark;
                    $LifeModel->admin_id = Yii::app()->user->id;
                    $LifeModel->status = AppTopicProblem::REPLY_YES;
                    $LifeModel->type = AppTopicProblem::TYPE_REPLY;
                    $LifeModel->member_id = Yii::app()->user->id;
                    $LifeModel->life_topic_id = $model->life_topic_id;
                    $LifeModel->parent_id = $model->id;
                    $LifeModel->create_time = time();
                    $LifeModel->name = Yii::app()->user->name;
                    if ($LifeModel->save(false)) {
                        exit(json_encode(array('success' => '添加成功')));
                    } else{
                        exit(json_encode(array('error' => '添加失败')));
                    }
                }
            }
        }
    }
    function actionReleStatus(){
        $user_id = Yii::app()->user->id;
        if ($this->isAjax() && $this->isPost()) {
            $lifeSum = Yii::app()->db->createCommand()
                ->select('count(*)')
                ->from('{{app_topic_life}}')
                ->where('rele_status = :rele_status and admin_id = :user_id' , array(':user_id'=>$user_id,':rele_status'=>AppTopicLife::RELE_STATUS_YES))
                ->queryScalar();
            if(!empty($lifeSum)){
                if($lifeSum == 10)
                    exit(json_encode(array('success' =>'已发布状态的专题已有10个，不能再添加已发布状态')));
                else
                    exit(json_encode(array('success'=>AppTopicLife::RELE_STATUS_YES)));
            }else{
                exit(json_encode(array('success'=>AppTopicLife::RELE_STATUS_YES)));
            }
        }
    }
}
