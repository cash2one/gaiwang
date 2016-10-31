<?php

/**
 * 广告管理
 * @author huabin_hong <huabin.hong@gwitdepartment.com>
 */
class MachineAdvertAgentController extends Controller {

    protected function setCurMenu($name) {
        $this->curMenu = Yii::t('main', '广告管理');
    }

    /**
     * 添加操作
     */
    public function actionCreate() {
        $adtype = $this->getQuery('adtype');  //广告类型
        $model = new MachineAdvertAgent();
        $model->setScenario($adtype); //根据传递过来的类型来进行场景的设定

        switch ($adtype) {
            case MachineAdvertAgent::ADVERT_TYPE_COUPON:
                $url = $this->createUrl('machineAdvertAgent/coupon', array('advert' => $adtype));
                break;
            case MachineAdvertAgent::ADVERT_TYPE_SIGN:
                $url = $this->createUrl('machineAdvertAgent/sign', array('advert' => $adtype));
                break;
        }
        $this->performAjaxValidation($model);

        if (isset($_POST['MachineAdvertAgent'])) {
            $model->attributes = $this->getPost('MachineAdvertAgent');
            $model->advert_type = $adtype;
            $model->user_ip = Tool::ip2int(self::clientIP());
            if ($model->save()) {
                @SystemLogAgent::saveSystemLogInfo(SystemLogAgent::Advert, '{username}{type}{table}{key}', SystemLogAgent::DO_INSERT, $model);

                $this->breadcrumbs = array(Yii::t('Public', '广告管理'), Yii::t('MachineAdvert', '广告列表'));
                Yii::app()->user->setState($this->params('msgSessionKey'), array('img' => 'succeed', 'content' => Yii::t('Public', '添加成功')));
                $this->redirect($url);
            }
        }

        $jsonData = self::getAdvertData();

        $this->render('create', array(
            'model' => $model,
            'advertTypeData' => $jsonData,
            'adtype' => $adtype,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate() {
        $id = $this->getQuery('id');
        $adtype = $this->getQuery('adtype');
        $model = $this->loadModel($id);
        $this->checkAreaAuth($model->province_id,$model->city_id,$model->district_id);
        
        if($model->is_line != 0){  //防止非法进入
            $this->redirect(array('MachineAdvertAgent/coupon'));
        }
        switch ($adtype) {
            case MachineAdvertAgent::ADVERT_TYPE_COUPON:
                $url = $this->createUrl('machineAdvertAgent/coupon', array('advert' => $adtype));
                break;
            case MachineAdvertAgent::ADVERT_TYPE_SIGN:
                $url = $this->createUrl('machineAdvertAgent/sign', array('advert' => $adtype));
                break;
        }
        $model->setScenario($adtype);
        $this->performAjaxValidation($model);

        if (isset($_POST['MachineAdvertAgent'])) {
            $isSave = false;
            $oldModel_attrs = array();
            foreach ($this->getPost('MachineAdvertAgent') as $key => $val) {
                if ($model->$key != $val) {
                    $isSave = true;
                    $oldModel_attrs[$key] = $model->$key;
                }
            }

//			foreach ($_POST['MachineAdvertAgent'] as $key=>$val){
//				if($model->$key!=$val){
//					$isSave = true;
//					break;
//				}
//			}

            $oldVedioname = $model->vedioname;   //获取旧的视频名称

            $model->attributes = $this->getPost('MachineAdvertAgent');
            $model->advert_type = $adtype;

            if ($isSave) {
                if ($model->save()) {
                    @SystemLogAgent::saveSystemLogInfo(SystemLogAgent::Advert, '{username}{type}{table}{key}', SystemLogAgent::DO_UPDATE, $model, $oldModel_attrs);
//					Yii::app()->user->setState($this->params('msgSessionKey'),array('img'=>'succeed','content'=>Yii::t('Public','保存成功!')));
                    $this->redirect($url);
                }
            } else {
//				Yii::app()->user->setState($this->params('msgSessionKey'),array('img'=>'succeed','content'=>Yii::t('Public','没有数据变更!')));
                $this->redirect($url);
            }
        }

        $jsonData = self::getAdvertData();
        $this->render('update', array(
            'model' => $model,
            'advertTypeData' => $jsonData,
            'adtype' => $adtype,
        ));
    }

    /**
     * 删除操作
     */
    public function actionDelete() {
        $id = $this->getQuery('id');
        $adtype = $this->getQuery('adtype');
//                echo $id."<br>".$adtype;die;
        $operateModels = MachineAdvertAgent::model()->findAll("id in ($id)");
        foreach ($operateModels as $model)
        {
                $this->checkAreaAuth($model->province_id,$model->city_id,$model->district_id);			
        }
        MachineAdvertAgent::model()->updateAll(array('status' => MachineAdvertAgent::ADVERT_STATUS_DEL), "id in ($id)");
        @SystemLogAgent::saveSystemLog(SystemLogAgent::Advert, '{username}{type}{table}{key}', SystemLogAgent::DO_DELETE, $operateModels);
        switch ($adtype) {
            case MachineAdvertAgent::ADVERT_TYPE_COUPON:
                $url = $this->createUrl('machineAdvertAgent/coupon', array('advert' => $adtype));
                break;
            case MachineAdvertAgent::ADVERT_TYPE_SIGN:
                $url = $this->createUrl('machineAdvertAgent/sign', array('advert' => $adtype));
                break;
        }


        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setState($this->params('msgSessionKey'), array('img' => 'succeed', 'content' => Yii::t('Public', '删除成功!')));
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : $url);
        }
    }

    /**
     * 优惠劵广告管理
     */
    public function actionCoupon() {
        self::actionIndex(MachineAdvertAgent::ADVERT_TYPE_COUPON);
    }

    /**
     * 首页轮播广告管理
     */
    public function actionSign() {
        self::actionIndex(MachineAdvertAgent::ADVERT_TYPE_SIGN);
    }

    /**
     * 视频管理
     */
    public function actionVedio() {
        self::actionIndex(MachineAdvertAgent::ADVERT_TYPE_VEDIO);
    }

    /**
     * 投票系统首页轮播广告
     */
    public function actionVote() {
        self::actionIndex(MachineAdvertAgent::ADVERT_TYPE_VOTE);
    }

    /**
     * 公用方法
     * @param int $type		广告类型
     */
    public function actionIndex($adtype) {
        $model = new MachineAdvertAgent();

        $power = $this->getPowerAear(false);

        $model->unsetAttributes();
        $model->advert_type = $adtype;
        $model->setScenario($adtype); //根据传递过来的类型来进行场景的设定

        $typeData = $adtype == MachineAdvertAgent::ADVERT_TYPE_COUPON ? CategoryAgent::model()->findAll("pid = 0 and is_visible = " . CategoryAgent::IS_VISIBLE . " and type = " . CategoryAgent::TYPE_ADVERT) : "";

        /**
         * 查询所用
         */
        if (isset($_GET['MachineAdvertAgent'])) {
            $dataArray = $this->getQuery('MachineAdvertAgent');
            $model->attributes = $dataArray;
            $model->category_pid = $dataArray['category_pid'];
        }

        //$this->breadcrumbs = array(Yii::t('Public','广告管理'),Yii::t('MachineAdvertAgent','广告列表'));

        $model->provinceStr = $power['provinceId'];
        $model->cityStr = $power['cityId'];
        $model->districtStr = $power['districtId'];

        $this->render('index', array(
            'model' => $model,
            'typeData' => $typeData,
            'adtype' => $adtype,
        ));
    }

    /**
     * 获取json格式的广告数据,餐厅、广告、旅游等
     */
    public static function getAdvertData() {
        $sql = "select id,pid,name from " . CategoryAgent::model()->tableName() . " where is_visible = " . CategoryAgent::IS_VISIBLE . " and type = " . CategoryAgent::TYPE_ADVERT . " and id not in(1,2,3) and pid not in(1,3) order by tree_path";
        $parentData = Yii::app()->gt->createCommand($sql)->query();
        $jsonData = "[";
        foreach ($parentData as $key => $val) {
            $nocheck = $val['pid'] == 0 ? ", nocheck:true" : "";
            $jsonData.= "{ id:" . $val['id'] . ", pId:" . $val['pid'] . ", name:'" . $val['name'] . "'$nocheck},";
        }
        $jsonData = substr($jsonData, 0, -1) . "]";
        return $jsonData;
    }

    /**
     * 获取广告子类型
     */
    public function actionGetChildType() {
        $pid = $this->getQuery('pid');  //父节点id
        $fileTable = FileManageAgent::model()->tableName();
        //,(select a.path from $fileTable a where a.id = b.icon_normal_file_id) as normalimgpath,(select a.path from $fileTable a where a.id = b.icon_selected_file_id) as selectedimgpath
        $sql = "select id,name,pid" .
                " from " . CategoryAgent::model()->tableName() . " where is_visible = :is_visible and type = :type  and pid = :pid order by id";
        $result = Yii::app()->gt->createCommand($sql)->bindValues(array(
            ':is_visible'=>CategoryAgent::IS_VISIBLE,
            ':type'=>CategoryAgent::TYPE_ADVERT,
            ':pid'=>$pid
        ))->query();
        $data = array();
        foreach ($result as $key => $val) {
            $data[] = $val;
        }
        echo CJSON::encode($data);
    }

    /**
     * 添加盖机
     */
    public function actionAddMachine() {
        $this->layout = 'left';
        $machineModel = new MachineAgent();
        $id = $this->getQuery('id');
        $machineModel->advertid = $id;
        $machineModel->adtype = $this->getQuery('adtype');
        
        if($_GET['adtype'] != MachineAdvertAgent::ADVERT_TYPE_VEDIO){
            $model = $this->loadModel($id);
            $this->checkAreaAuth($model->province_id, $model->city_id, $model->district_id);
        }
        
        $this->breadcrumbs = array(Yii::t('Machine', '盖机管理'), Yii::t('Machine', '添加盖机'));

        $agent_region = $this->getPowerAear(false);
        $machineModel->agent_ss = $agent_region;
        if (isset($_GET['MachineAgent'])) {
            $dataArray = $this->getQuery('MachineAgent');
            $machineModel->attributes = $dataArray;
            $machineModel->biz_name = $dataArray['biz_name'];
        }

        $this->render('addmachine', array(
            'model' => $machineModel,
                )
        );
    }

    /**
     * 绑定盖机
     */
    public function actionBindMachine() {
        $id = $this->getQuery('id');   //广告编号
        $adtype = $this->getQuery('adtype'); //获取广告类型，区分是视频广告还是其它广告
        
        $model2 = $this->loadModel($id);
        $this->checkAreaAuth($model2->province_id, $model2->city_id, $model2->district_id);
        
        switch ($adtype) {
            case MachineAdvertAgent::ADVERT_TYPE_SIGN:
                $machineModel = new Machine2AdvertAgent();
                $name = Yii::t('MachineAdvertAgent', '广告');
                break;
            case MachineAdvertAgent::ADVERT_TYPE_COUPON:
                $machineModel = new Machine2AdvertAgent();
                $name = Yii::t('MachineAdvertAgent', '优惠劵');
                break;
            case MachineAdvertAgent::ADVERT_TYPE_VEDIO:
                $machineModel = new Machine2AdvertVideoAgent();
                $name = Yii::t('MachineAdvertAgent', '视频');
                break;
        }
        
        $machineModel->advert_id = $id;
        $agent_region = $this->getPowerAear(false);
        $machineModel->agent_ss = $agent_region;

        //$this->breadcrumbs = array(Yii::t('Public','广告管理'),$name,Yii::t('Public','绑定盖机'));

        if (isset($_GET['addid'])) {   //如果是表单提交
            $deleteid = isset($_GET['delid']) ? $this->getQuery('delid') : "";  //删除数据

            $addid = $this->getQuery('addid');  //添加数据

            if (!empty($addid)) {    //如果有添加盖机
                $idArr = explode(",", $addid);

                $userip = Tool::ip2int(self::clientIP());
                $userid = Yii::app()->User->id;
                $operateModels = array();
                foreach ($idArr as $key => $val) {
                    $machineModel->machine_id = $val;
                    $machineModel->user_ip = $userip;
                    $machineModel->user_id = $userid;
                    $machineModel->create_time = time();
                    $machineModel->isNewRecord = true;
                    $machineModel->save();
                    $machineModel->log_source_id = $val;
                    $operateModels[] = $machineModel;
                }
                $log_title = '广告编号为' . $id . '的广告绑定上了编号为' . $addid . "的盖机";
                @SystemLogAgent::saveSystemLog(SystemLogAgent::Advert, $log_title, SystemLogAgent::DO_INSERT, $operateModels);
            }

            if (!empty($deleteid)) {   //如果有删除盖机
                if ($adtype == MachineAdvertAgent::ADVERT_TYPE_VEDIO) {
                    foreach ($deleteid as $keyDel => $valDel) {
                        $operateModel = Machine2AdvertVideoAgent::model()->findByAttributes(array(
                            'machine_id' => $valDel, 'advert_id' => $id
                        ));

                        Machine2AdvertVideoAgent::model()->deleteAll("machine_id = :machine_id and advert_id = :advert_id",array(':machine_id'=>$valDel,':advert_id'=>$id));

                        $operateModel->log_source_id = $valDel;
                        $operateModels[] = $operateModel;
                    }
                } else {
                    foreach ($deleteid as $keyDel => $valDel) {
                        $operateModel = Machine2AdvertAgent::model()->findByAttributes(array(
                            'machine_id' => $valDel, 'advert_id' => $id
                        ));
                        Machine2AdvertAgent::model()->deleteAll("machine_id = :machine_id and advert_id = :advert_id",array(':machine_id'=>$valDel,':advert_id'=>$id));
                        $operateModel->log_source_id = $valDel;
                        $operateModels[] = $operateModel;
                    }
//				}
                    $log_title = '广告编号' . $id . "的广告解除了在编号为" . implode(",", $deleteid) . "上的盖机的绑定";
                    @SystemLogAgent::saveSystemLog(SystemLogAgent::Advert, $log_title, SystemLogAgent::DO_DELETE, $operateModels);
                }
                $this->redirect($this->createURL('machineAdvertAgent/bindMachine', array('id' => $id, 'adtype' => $adtype)));
            }
        }
        
            $this->render('machine', array(
                'model' => $machineModel,
                'dataProvider' => $machineModel->search(),
                'adtype' => $adtype,
            ));
        
    }

}

