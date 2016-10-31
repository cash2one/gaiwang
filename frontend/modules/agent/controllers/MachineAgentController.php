<?php

class MachineAgentController extends Controller {

    /**
     * 设置当前所在的menu
     */
    protected function setCurMenu($name) {
        $this->curMenu = Yii::t('main', '盖机管理');
    }

    /**
     * 盖机列表
     */
    public function actionIndex() {
        $model = new MachineAgent();

        $model->unsetAttributes();  // clear any default values
        $agent_region = $this->getPowerAear(false);
        $model->agent_ss = $agent_region;

        if (isset($_GET['MachineAgent'])) {
            $dataArray = $this->getQuery('MachineAgent');
            $model->attributes = $dataArray;
            if (isset($dataArray['biz_name'])) {
                $model->biz_name = $dataArray['biz_name'];
            }
        }

        $criteria = $model->searchControll();
        $count = $model->count($criteria);   //获取有多少条记录
        //配置分页
        $pages = new CPagination($count);
        $pages->pageSize = 12;
        $pages->applyLimit($criteria);

        $data = $model->findAll($criteria);
        //处理省市区
        $region = array();
        $machine = array();
        if (!empty($data)) {
            $regionid = array();
            $machineid = array();
            foreach ($data as $row) {
                $regionid[] = $row['province_id'];
                $regionid[] = $row['city_id'];
                $regionid[] = $row['district_id'];
                $machineid[] = $row['id'];
                $machineMonitorId[] = empty($row['machine_monitor_id']) ? 0 : $row['machine_monitor_id'];
            }

            //查询要显示的盖机的省市区
            $regionid = array_unique($regionid);
            $regionidstr = implode($regionid, ",");
            $sqlRegion = "select id,name from " . Region::model()->tableName() . " where id in ($regionidstr)";
            $res = Yii::app()->db->createCommand($sqlRegion)->queryAll();

            foreach ($res as $row) {
                $region[$row['id']] = $row['name'];
            }
        }

        $this->render('index', array(
            'model' => $model,
            'data' => $data,
            'region' => $region,
            'machine' => $machine,
            'pages' => $pages,
        ));
    }

    /*
     * 盖网通控制界面
     */

    public function actionControl($id) {
        $model = $this->loadModel($id);

        //检查权限
        $this->checkAreaAuth($model->province_id, $model->city_id, $model->district_id);

        $model->scenario = 'control';
        $model->api = MachineForbbidenAgent::getNoForbbidenApi($id);
        $this->performAjaxValidation($model);
        if (isset($_POST['MachineAgent'])) {
            $isSave = false;
            $oldModel_attrs = array();
            foreach ($this->getPost('MachineAgent') as $key => $val) {
                if ($model->$key != $val) {
                    $isSave = true;
                    $oldModel_attrs[$key] = $model->$key;
                }
            }

            $dataArray = $this->getPost('MachineAgent');
            $model->attributes = $dataArray;

            $diff_api = MachineForbbidenAgent::getForbbidenApi($dataArray['api']);

            //先删除所有绑定的API接口功能
            MachineForbbidenAgent::model()->deleteAll("machine_id = :id",array(':id'=>$id));
            if (!empty($diff_api)) { //如果接口不为空
                //添加绑定的API数据
                $ApiModel = new MachineForbbidenAgent();
                $forbbidenApi = "";
                foreach ($diff_api as $row) {
                    $ApiModel->machine_id = $id;
                    $ApiModel->action_type = $row;
                    $ApiModel->isNewRecord = true;
                    $ApiModel->save(false);
                    $forbbidenApi.= $forbbidenApi == "" ? MachineForbbidenAgent::getApi($row) : "," . MachineForbbidenAgent::getApi($row);
                }
                $log_title = "盖机$id,禁用接口:$forbbidenApi";
                @SystemLogAgent::saveSystemLog(SystemLogAgent::Machine, $log_title, SystemLogAgent::DO_UPDATE, $ApiModel);
            }

            if ($isSave) {
                if ($model->save()) {
                    @SystemLogAgent::saveSystemLogInfo(SystemLogAgent::Machine, '{username}{type}{table}{key}', SystemLogAgent::DO_UPDATE, $model, $oldModel_attrs);
                    Yii::app()->user->setState($this->params('msgSessionKey'), array('img' => 'succeed', 'content' => Yii::t('Public', '修改成功!')));
                    $this->redirect(array('index'));
                }
            } else {
                Yii::app()->user->setState($this->params('msgSessionKey'), array('img' => 'succeed', 'content' => Yii::t('Public', '没有数据变更!')));
                $this->redirect(array('index'));
            }
        }
        $franchisee_model = Franchisee::model()->findByPk($model->biz_info_id);
        $model->biz_name = $franchisee_model->name;
        $this->render('control', array(
            'model' => $model,
        ));
    }

    /*
     * ajax卸载和恢复盖机
     */

    public function actionAjaxcontrol() {
//        if ($this->isAjax()) {
//            $id = $this->getPost('id');
//            $model = $this->loadModel($id);
//            //检查是否有权限
//            $this->checkAreaAuth($model->province_id, $model->city_id, $model->district_id);
//
//            if ($model->run_status == MachineAgent::RUN_STATUS_UNINSTALL) {
//                $model->run_status = MachineAgent::RUN_STATUS_STOP;
//                $log_title = "盖机<" . $model->id . "{" . $model->name . "}>运行状态被改为卸载";
//                $rt = CJSON::encode(array('run_button' => '卸载', 'run_text' => MachineAgent::getRunStatus(MachineAgent::RUN_STATUS_STOP)));
//            } else {
//                $model->run_status = MachineAgent::RUN_STATUS_UNINSTALL;
//                $log_title = "盖机<" . $model->id . "{" . $model->name . "}>运行状态被改为恢复";
//                $rt = CJSON::encode(array('run_button' => '恢复', 'run_text' => MachineAgent::getRunStatus(MachineAgent::RUN_STATUS_UNINSTALL)));
//            }
//            if ($model->update()) {
//                @SystemLogAgent::saveSystemLog(SystemLogAgent::Machine, $log_title, SystemLogAgent::DO_UPDATE, $model);
//                echo $rt;
//            }
//        }
        Yii::app()->end();
    }

    /*
     * 获取指定id的盖机上面所绑定的数据
     */

    public function actionAdvertList() {
        $machine_id = $this->getQuery('id');     //盖机编号
        $adtype = isset($_GET['adtype']) ? $this->getQuery('adtype') : MachineAdvertAgent::ADVERT_TYPE_COUPON; //广告类型,默认为优惠劵

        $model = $this->loadModel($machine_id);

        //检查是否有权限
        $this->checkAreaAuth($model->province_id, $model->city_id, $model->district_id);

        $adModel = new MachineAdvertAgent();           //实例化广告对象
//               $productModel = new ProductAgent();

        $adModel->setScenario($adtype);

        $adModel->unsetAttributes();
        $adModel->advert_type = $adtype;
        $adModel->machine_id = $machine_id;

        $typeData = array();
        $typeChild = array();
        if ($adtype == MachineAdvertAgent::ADVERT_TYPE_COUPON) {      //只有优惠劵使用
            //获取全部的广告大类型数据
            $sql = "select distinct c.id,c.name,c.pid,d.name as pname from " . MachineAdvertAgent::model()->tableName() . " a left join " .
                    Machine2AdvertAgent::model()->tableName() . " b on b.advert_id=a.id left join " .
                    CategoryAgent::model()->tableName() . " c on c.id=a.category_id left join " .
                    CategoryAgent::model()->tableName() . " d on d.id=c.pid " .
                    "where b.machine_id=:machine_id and a.advert_type=:advert_type and a.status=:status";
            $categoryData = Yii::app()->gt->createCommand($sql)->bindValues(array(
                ':machine_id'=>$machine_id,
                ':advert_type'=>$adtype,
                ':status'=>MachineAdvertAgent::ADVERT_STATUS
            ))->queryAll();

            $categoryPid = array();
            $categoryId = array();

            $showPid = isset($_GET['category_pid']) ? $this->getQuery('category_pid') : '';

            foreach ($categoryData as $row) {
                if (!in_array($row['pid'], $categoryPid)) {
                    $categoryPid[] = $row['pid'];
                    $typeData[] = array(
                        'id' => $row['pid'],
                        'name' => $row['pname']
                    );
                }
                if ($showPid != '') {
                    if ($row['pid'] == $showPid) {
                        $categoryId = $row['id'];
                        $typeChild[] = array(
                            'id' => $row['id'],
                            'name' => $row['name'],
                            'pid' => $row['pid']
                        );
                    }
                }
            }

            $adModel->category_pid = isset($_GET['category_pid']) ? $this->getQuery('category_pid') : '';
            $adModel->category_id = isset($_GET['category_id']) ? $this->getQuery('category_id') : '';
        }

        if ($adtype == MachineAdvertAgent::ADVERT_TYPE_PRODUCT) {
            $typeData = CategoryAgent::model()->findAll("pid = 0 and type=2 and is_visible = " . CategoryAgent::IS_VISIBLE);
        }

        /**
         * 查询所用
         */
        if (isset($_GET['MachineAdvertAgent'])) {
            $dataArray = $this->getQuery('MachineAdvertAgent');
            $adModel->attributes = $dataArray;
            $adModel->category_pid = $dataArray['category_pid'];
        }

        $tableName = MachineAdvertAgent::model()->tableName();
        $tableName2 = Machine2AdvertAgent::model()->tableName();
        $tableName3 = Machine2ProductAgent::model()->tableName();
        $productTable = ProductAgent::model()->tableName();
        $sqlCoupon = "select count(1) from " . $tableName . " a," . $tableName2 . " b where a.id = b.advert_id and b.machine_id = :machine_id and a.advert_type = :advert_type and a.status = :status";
        $sqlSign = "select count(1) from " . $tableName . " a," . $tableName2 . " b where a.id = b.advert_id and b.machine_id = :machine_id and a.advert_type = :advert_type and a.status = :status";
//               $sqlVedio = "select count(1) from " . $tableName . " a," . Machine2AdvertVideoAgent::model()->tableName() . " b where a.id = b.advert_id and b.machine_id = $machine_id and a.advert_type = " . MachineAdvertAgent::ADVERT_TYPE_VEDIO . " and a.status = " . MachineAdvertAgent::ADVERT_STATUS;
        $sqlVedio = "select count(1) from " . $tableName . " a," . Machine2AdvertVideoAgent::model()->tableName() . " b where a.id = b.advert_id and b.machine_id = :machine_id and a.advert_type in (" . MachineAdvertAgent::ADVERT_TYPE_VEDIO . "," . MachineAdvertAgent::ADVERT_TYPE_LOCALVEDIO . ") and a.status = " . MachineAdvertAgent::ADVERT_STATUS;
        $sqlProduct = "select count(1) from " . $productTable . " a," . $tableName3 . " b where a.id=b.product_id and b.machine_id=:machine_id AND a.status <> :status";
        $listCounts = array();

        $listCounts['Coupon'] = MachineAdvertAgent::model()->countBySql($sqlCoupon,array(':machine_id'=>$machine_id,':advert_type'=>MachineAdvertAgent::ADVERT_TYPE_COUPON ,':status'=>MachineAdvertAgent::ADVERT_STATUS));
        $listCounts['Sign'] = MachineAdvertAgent::model()->countBySql($sqlSign,array(':machine_id'=>$machine_id,':advert_type'=>MachineAdvertAgent::ADVERT_TYPE_SIGN,':status'=>MachineAdvertAgent::ADVERT_STATUS));
        $listCounts['Vedio'] = MachineAdvertAgent::model()->countBySql($sqlVedio,array(':machine_id'=>$machine_id));
        $listCounts['Product'] = MachineAdvertAgent::model()->countBySql($sqlProduct,array(':machine_id'=>$machine_id,':status'=>ProductAgent::STATUS_DEL));
        $this->breadcrumbs = array(Yii::t('Machine', '盖网代理管理'), $model->name, Yii::t('Machine', '投放广告'));

        $this->render('advertlist', array(
            'model' => $model,
            'adModel' => $adModel,
            'listCounts' => $listCounts,
            'typeData' => $typeData,
            'typeChild' => $typeChild,
            'adtype' => $adtype,
        ));
    }

    /*
     * 获取指定id的盖机上面所绑定的产品product
     */

    public function actionProductList() {
        $machine_id = $_GET['id'];     //盖机编号
        $adtype = isset($_GET['adtype']) ? $_GET['adtype'] : MachineAdvertAgent::ADVERT_TYPE_PRODUCT; //广告类型,默认为优惠劵

        $model = $this->loadModel($machine_id);

        //检查是否有权限
        $this->checkAreaAuth($model->province_id, $model->city_id, $model->district_id);

        $adModel = new MachineAdvertAgent();           //实例化广告对象
        $productModel = new ProductAgent();
        $productModel->machine_id = $machine_id;
        $adModel->setScenario($adtype);

        $adModel->unsetAttributes();
        $adModel->advert_type = $adtype;
        $adModel->machine_id = $machine_id;


        //获取全部的广告大类型数据
        $sql = "select distinct c.id,c.name,c.pid,d.name as pname from " . ProductAgent::model()->tableName() . " a 
	        left join " . Machine2ProductAgent::model()->tableName() . " b on b.product_id = a.id 
	        left join " . CategoryAgent::model()->tableName() . " c on c.id = a.category_id 
	        left join " . CategoryAgent::model()->tableName() . " d on d.id = c.pid
	        where b.machine_id = $machine_id and a.status <> " . ProductAgent::STATUS_DEL;

        $categoryData = Yii::app()->gt->createCommand($sql)->queryAll();

        $categorypid = array();     //初始化临时变量类型	
        $categoryid = array();     //初始化临时变量类型
        $typeData = array();
        $typeChild = array();
        $showPId = isset($_GET['category_pid']) ? $_GET['category_pid'] : "";  //指定要显示的子类型
        foreach ($categoryData as $row) {
            if (!in_array($row['pid'], $categorypid)) {
                $categorypid[] = $row['pid'];
                $typeData[] = array(
                    'id' => $row['pid'],
                    'name' => $row['pname'],
                );
            }
            if ($showPId != "") {            //默认显示所有，也就是说是没有子类型的，如果有子类型就是选择了一个父类型
                if ($row['pid'] == $showPId) {
                    $categoryid[] = $row['id'];
                    $typeChild[] = array(
                        'id' => $row['id'],
                        'name' => $row['name'],
                        'pid' => $row['pid'],
                    );
                }
            }
        }

        //指定当前要显示的大类型
        $productModel->category_pid = isset($_GET['category_pid']) ? $_GET['category_pid'] : "";

        //指定当前要显示的小类型
        $productModel->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : "";



//               
//               if ($adtype == MachineAdvertAgent::ADVERT_TYPE_COUPON) {      //只有优惠劵使用
//                   $typeData = CategoryAgent::model()->findAll("pid = 0 and is_visible = " . CategoryAgent::IS_VISIBLE);
//               }
//               
//               if($adtype == MachineAdvertAgent::ADVERT_TYPE_PRODUCT){
//                   $typeData = CategoryAgent::model()->findAll("pid = 0 and type=2 and is_visible = " . CategoryAgent::IS_VISIBLE);
//               }

        /**
         * 查询所用
         */
        if (isset($_GET['ProductAgent'])) {
            $productModel->attributes = $_GET['ProductAgent'];
            $productModel->category_pid = $_GET['ProductAgent']['category_pid'];
        }

        $tableName = MachineAdvertAgent::model()->tableName();
        $tableName2 = Machine2AdvertAgent::model()->tableName();
        $tableName3 = Machine2ProductAgent::model()->tableName();
        $productTable = ProductAgent::model()->tableName();
        $sqlCoupon = "select count(1) from " . $tableName . " a," . $tableName2 . " b where a.id = b.advert_id and b.machine_id = $machine_id and a.advert_type = " . MachineAdvertAgent::ADVERT_TYPE_COUPON;
        $sqlSign = "select count(1) from " . $tableName . " a," . $tableName2 . " b where a.id = b.advert_id and b.machine_id = $machine_id and a.advert_type = " . MachineAdvertAgent::ADVERT_TYPE_SIGN;
//               $sqlVedio = "select count(1) from " . $tableName . " a," . Machine2AdvertVideoAgent::model()->tableName() . " b where a.id = b.advert_id and b.machine_id = $machine_id and a.advert_type = " . MachineAdvertAgent::ADVERT_TYPE_VEDIO;
        $sqlVedio = "select count(1) from " . $tableName . " a," . Machine2AdvertVideoAgent::model()->tableName() . " b where a.id = b.advert_id and b.machine_id = $machine_id and a.advert_type in (" . MachineAdvertAgent::ADVERT_TYPE_VEDIO . "," . MachineAdvertAgent::ADVERT_TYPE_LOCALVEDIO . ") and a.status = " . MachineAdvertAgent::ADVERT_STATUS;
        $sqlProduct = "select count(1) from " . $productTable . " a," . $tableName3 . " b where a.id=b.product_id and b.machine_id=$machine_id AND a.status <> " . ProductAgent::STATUS_DEL;

        $listCounts = array();
        $listCounts['Coupon'] = MachineAdvertAgent::model()->countBySql($sqlCoupon);
        $listCounts['Sign'] = MachineAdvertAgent::model()->countBySql($sqlSign);
        $listCounts['Vedio'] = MachineAdvertAgent::model()->countBySql($sqlVedio);
        $listCounts['Product'] = ProductAgent::model()->countBySql($sqlProduct);

        $this->breadcrumbs = array(Yii::t('Machine', '盖网代理管理'), $model->name, Yii::t('Machine', '投放广告'));

        $this->render('productlist', array(
            'model' => $model,
            'adModel' => $adModel,
            'listCounts' => $listCounts,
            'typeData' => $typeData,
            'adtype' => $adtype,
            'productModel' => $productModel,
            'typeChild' => $typeChild,
        ));
    }

    /*
     * 解除指定广告对盖机的绑定
     */

    public function actionAdvertRemove() {
        $machine_id = $this->getQuery('id');
        $advert_id = $this->getQuery('advert_id');
        $adtype = $this->getQuery('adtype');

        //检查是否有权限
        $model = MachineAgent::model()->findByPk($machine_id);
        $this->checkAreaAuth($model->province_id, $model->city_id, $model->district_id);

        //检查是否有该优惠券权限
        if ($adtype != MachineAdvertAgent::ADVERT_TYPE_VEDIO) {
            $advertid = explode(",", $advert_id);
            foreach ($advertid as $value) {
                $model = MachineAdvertAgent::model()->findByPk($value);
                $this->checkAreaAuth($model->province_id, $model->city_id, $model->district_id);
            }
        }


        if ($adtype != MachineAdvertAgent::ADVERT_TYPE_VEDIO) {
            $adModel = Machine2AdvertAgent::model();
        } else {
            $adModel = Machine2AdvertVideoAgent::model();
        }
        $operateModels = $adModel->findAll("advert_id in (" . $advert_id . ") and machine_id = :machine_id",array(':machine_id'=>$machine_id));
        foreach ($operateModels as $operateModel) {
            $operateModel->log_source_id = $operateModel->advert_id;
        }

        $adModel->deleteAll("advert_id in (" . $advert_id . ") and machine_id = :machine_id",array(':machine_id'=>$machine_id));

        $log_title = '解除绑定的广告：盖机编号' . $machine_id;
        @SystemLogAgent::saveSystemLog(SystemLogAgent::Machine, $log_title, SystemLogAgent::DO_DELETE, $operateModels);

//        $url = Yii::app()->createUrl('machineAgent/advertList', array('id' => $machine_id, 'adtype' => $adtype));
        $url=$this->createUrl('machineAgent/advertList',array('id' => $machine_id, 'adtype' => $adtype));
        
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            //			Yii::app()->user->setState($this->params('msgSessionKey'),array('img'=>'succeed','content'=>'删除成功!'));
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : $url);
        }
    }

    /*
     * 解除指定广告对盖机的绑定  产品管理
     */

    public function actionProductRemove() {
        $machine_id = $_GET['id'];
        $product_id = $_GET['product_id'];

        //检查是否有权限
        $model = MachineAgent::model()->findByPk($machine_id);
        $this->checkAreaAuth($model->province_id, $model->city_id, $model->district_id);

        //检查是否有该优惠券权限
        $productId = explode(",", $product_id);
        foreach ($productId as $value) {
            $model = ProductAgent::model()->findByPk($value);
            $this->checkAreaAuth($model->province_id, $model->city_id, $model->district_id);
        }

        $adModel = new Machine2ProductAgent;
        $adModel->deleteAll("product_id in (" . $product_id . ") and machine_id = " . $machine_id);

        $sysmodel = new Machine2ProductAgent();
        $log_title = "解除商品编号为<" . $product_id . ">编号的商品在盖机编号为<" . $machine_id . ">的盖机中的绑定";
        $sysmodel->log_source_id = $machine_id;
        @SystemLogAgent::saveSystemLog(SystemLogAgent::Machine, $log_title, SystemLogAgent::DO_DELETE, $sysmodel);

        $url = Yii::app()->createUrl('machineAgent/productList', array('id' => $machine_id));


        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : $url);
        }
    }

    /**
     * 盖机广告添加事件  添加优惠券，首页轮播 视频
     */
    public function actionAdvertCreate() {
        $machine_id = $this->getQuery('id');

        //检查是否有权限
        $model = MachineAgent::model()->findByPk($machine_id);
        $this->checkAreaAuth($model->province_id, $model->city_id, $model->district_id);

        $advart_id = $this->getQuery('advertid');
        $adtype = $this->getQuery('adtype');

        if ($adtype != MachineAdvertAgent::ADVERT_TYPE_VEDIO) {
            $machineModel = new Machine2AdvertAgent();
            $tableName = Machine2AdvertAgent::model()->tableName();
            $sql = "select advert_id from $tableName where machine_id=:machine_id";
            $row = Yii::app()->gt->createCommand($sql)->bindValue(':machine_id',$machine_id)->queryColumn();
        } else {
            $machineModel = new Machine2AdvertVideoAgent();
            $tableName = Machine2AdvertVideoAgent::model()->tableName();
            $sql = "select advert_id from $tableName where machine_id=:machine_id";
            $row = Yii::app()->gt->createCommand($sql)->bindValue(':machine_id',$machine_id)->queryColumn();
        }
        $userip = Tool::ip2int(self::clientIP());
        $userid = Yii::app()->User->id;
        $advertid = explode(",", $advart_id);

        //检查是否有该优惠券权限
        if ($adtype != MachineAdvertAgent::ADVERT_TYPE_VEDIO) {
            foreach ($advertid as $value) {
                $model = MachineAdvertAgent::model()->findByPk($value);
                $this->checkAreaAuth($model->province_id, $model->city_id, $model->district_id);
            }
        }


        $arr = array_intersect($row, $advertid);  //比较2个数组的交集
        if (count($arr) == 0) {
            foreach ($advertid as $key => $val) {
                $machineModel->machine_id = $machine_id;
                $machineModel->advert_id = $val;
                $machineModel->user_ip = $userip;
                $machineModel->user_id = $userid;
                $machineModel->create_time = time();
                $machineModel->isNewRecord = true;
                $machineModel->save();
            }
            $operateModels = $machineModel;
            $operateModels->log_source_id = $advart_id;
            $log_title = '绑定广告：盖机编号' . $machine_id;
            @SystemLogAgent::saveSystemLog(SystemLogAgent::Machine, $log_title, SystemLogAgent::DO_INSERT, $operateModels);
        }
        $this->redirect($this->createUrl('machineAgent/advertList', array('id' => $machine_id, 'adtype' => $adtype)));
    }

    /**
     * 盖机广告添加事件  产品管理
     */
    public function actionProductCreate() {
        $machine_id = $_GET['id'];

        //检查是否有权限
        $model = MachineAgent::model()->findByPk($machine_id);
        $this->checkAreaAuth($model->province_id, $model->city_id, $model->district_id);

        $product_id = $_GET['product_id'];
        $machineModel = new Machine2ProductAgent;

        $productID = explode(",", $product_id);

        //检查是否有该优惠券权限
        foreach ($productID as $value) {
            $model = ProductAgent::model()->findByPk($value);
            $this->checkAreaAuth($model->province_id, $model->city_id, $model->district_id);
        }

        $userip = Tool::ip2int(self::clientIP());
        $userid = Yii::app()->User->id;
        foreach ($productID as $key => $val) {
            $machineModel->machine_id = $machine_id;
            $machineModel->product_id = $val;
            $machineModel->user_ip = $userip;
            $machineModel->user_id = $userid;
            $machineModel->create_time = time();
            $machineModel->isNewRecord = true;
            $machineModel->save();
        }

        $log_title = "向编号为<" . $machine_id . ">的盖机中绑定编号为<" . $product_id . ">的商品";
        $machineModel->log_source_id = $product_id;
        @SystemLogAgent::saveSystemLog(SystemLogAgent::Machine, $log_title, SystemLogAgent::DO_INSERT, $machineModel);

        $this->redirect(Yii::app()->createUrl('machineAgent/productList', array('id' => $machine_id)));
    }

    /**
     * 单个盖机广告更新事件
     */
    public function actionAdvertUpdate() {

        $machine_id = $this->getQuery('id');
        $advert_id = $this->getQuery('advert_id');
        $adtype = $this->getQuery('adtype');

        //检查是否有该优惠券权限
        if ($adtype != MachineAdvertAgent::ADVERT_TYPE_VEDIO) {
            $model = MachineAdvertAgent::model()->findByPk($advert_id);
            $this->checkAreaAuth($model->province_id, $model->city_id, $model->district_id);
            if($model->is_line != 0){  //防止非法访问
                $this->redirect(array('MachineAgent/advertList','id'=>$machine_id));
            }
        }

        if ($adtype == MachineAdvertAgent::ADVERT_TYPE_VEDIO) {
            $sql = "select a.*,CONCAT_WS('.',b.filename,b.suffix) as vedioname from " . MachineAdvertAgent::model()->tablename() . " a," . FileManageAgent::model()->tablename() . " b where a.file_id = b.id and a.id = :id";
            $adModel = MachineAdvertAgent::model()->findBySql($sql,array(':id'=>$advert_id));
        } else {
            $adModel = MachineAdvertAgent::model()->findByPk($advert_id);
        }

        $adModel->setScenario($adtype);

        //ajax验证，因为创建的不是本控制器的model，所以自己在写
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'machineAdvertAgent-form') {
            echo CActiveForm::validate($adModel);
            Yii::app()->end();
        }


        switch ($adtype) {
            case MachineAdvertAgent::ADVERT_TYPE_COUPON:
                $this->breadcrumbs = array(Yii::t('Machine', '广告管理'), Yii::t('Machine', '编辑格子铺'));
                $name = "格子铺";
                break;
            case MachineAdvertAgent::ADVERT_TYPE_SIGN:
                $this->breadcrumbs = array(Yii::t('Machine', '广告管理'), Yii::t('Machine', '编辑首页轮播广告'));
                $name = "首页轮播";
                break;
            case MachineAdvertAgent::ADVERT_TYPE_VEDIO:
                $this->breadcrumbs = array(Yii::t('Machine', '广告管理'), Yii::t('Machine', '编辑视频广告'));
                $name = "视频";
                break;
        }

        if (isset($_POST['MachineAdvertAgent'])) {
            $isSave = false;
            $oldModel_attrs = array();
            foreach ($this->getPost('MachineAdvertAgent') as $key => $val) {
                if ($adModel->$key != $val) {
                    $isSave = true;
                    $oldModel_attrs[$key] = $adModel->$key;
//                           break;
                }
            }

            $url = $this->createUrl('machineAgent/advertList', array('id' => $machine_id, 'adtype' => $adtype));

            $oldVedioName = $adModel->vedioname;

            $adModel->attributes = $this->getPost('MachineAdvertAgent');
            $adModel->advert_type = $adtype;
            if ($isSave) {
                if ($adModel->save()) {
                    if ($adtype == MachineAdvertAgent::ADVERT_TYPE_VEDIO) {
                        if ($oldVedioName != $adModel->vedioname) {
                            $arr = explode(".", $adModel->vedioname);
                            $filesuffix = $arr[count($arr) - 1];   //后缀名
                            unset($arr[count($arr) - 1]);
                            $filename = implode("", $arr);   //名称

                            $fileModel = new FileManageAgent();
                            $fileModel->suffix = $filesuffix;   //后缀名
                            $fileModel->filename = $filename;   //名称
                            $fileModel->classify = FileManageAgent::FILETYPE_VEDIO; //类型
                            $fileModel->save();

                            $adModel->file_id = $fileModel->id;     //将对应的文件id传递过来
                            $adModel->svc_start_time = date('Y-m-d H:i:s', $adModel->svc_start_time);
                            $adModel->svc_end_time = date('Y-m-d H:i:s', $adModel->svc_end_time);
                            $adModel->save();

//                                   FileManageAgent::model()->updateAll(array('filename' => $filename, 'suffix' => $filesuffix), "id = " . $adModel->file_id);
                        }
                    }

                    $log_title = "盖网通商城-盖网通商城：修改编号为<" . $machine_id . ">的盖机所绑定的编号为<" . $advert_id . ">标题为<" . $adModel->title . ">的" . $name . "广告";
                    if ($oldVedioName != $adModel->vedioname)
                        $log_title.= "，并将视频名称从<" . $oldVedioName . ">改为<" . $adModel->vedioname . ">";
                    $adModel->log_source_id = $advert_id;

                    @SystemLogAgent::saveSystemLogInfo(SystemLogAgent::Machine, $log_title, SystemLogAgent::DO_UPDATE, $adModel, $oldModel_attrs);

                    //Yii::app()->user->setState($this->params('msgSessionKey'), array('img' => 'succeed', 'content' => '保存成功!'));
                    $this->redirect($url);
                }
            } else {
                //Yii::app()->user->setState($this->params('msgSessionKey'), array('img' => 'succeed', 'content' => '没有数据变更!'));
                $this->redirect($url);
            }
        }

        $jsonData = self::getAdvertData();

        $this->render('advertform', array(
            'model' => $adModel,
            'advertTypeData' => $jsonData,
            'adtype' => $adtype,
            'machine_id' => $machine_id,
        ));
    }

    /**
     * 单个盖机广告更新事件  产品管理
     */
    public function actionProductUpdate() {

        $machine_id = $this->getParam('id');
        $product_id = $this->getParam('product_id');

        //检查是否有权限
        $model = ProductAgent::model()->findByPk($product_id);
        $this->checkAreaAuth($model->province_id, $model->city_id, $model->district_id);


        $productModel = ProductAgent::model()->findByPk($product_id);

        //ajax验证，因为创建的不是本控制器的model，所以自己在写
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'productAgent-form') {
            echo CActiveForm::validate($productModel);
            Yii::app()->end();
        }


        $this->breadcrumbs = array('广告管理', '编辑产品');



        if (isset($_POST['ProductAgent'])) {
            $isSave = false;
            $oldModel_attrs = array();
            foreach ($_POST['ProductAgent'] as $key => $val) {
                if ($productModel->$key != $val) {
                    $isSave = true;
                    $oldModel_attrs[$key] = $productModel->$key;
//                           break;
                }
            }
            $url = Yii::app()->createUrl('machineAgent/productList', array('id' => $machine_id));

            //$oldVedioName = $adModel->vedioname;

            $productModel->attributes = $_POST['ProductAgent'];

            if ($isSave) {
                if ($productModel->save()) {

                    $log_title = "盖网通商城-盖网通商城：更新名称为<" . $productModel->name . ">编号为<" . $product_id . ">的商品的信息";

                    @SystemLogAgent::saveSystemLogInfo(SystemLogAgent::Machine, $log_title, SystemLogAgent::DO_UPDATE, $productModel, $oldModel_attrs);

                    //Yii::app()->user->setState($this->params('msgSessionKey'), array('img' => 'succeed', 'content' => '保存成功!'));
                    $this->redirect($url);
                }
            } else {
                //Yii::app()->user->setState($this->params('msgSessionKey'), array('img' => 'succeed', 'content' => '没有数据变更!'));
                $this->redirect($url);
            }
        }

        $jsonData = self::getProductData();

        $this->render('productform', array(
            'model' => $productModel,
            'adTypeData' => $jsonData,
            'machine_id' => $machine_id,
            'product_id' => $product_id
        ));
    }

    /**
     * 更新本地视频信息
     */
    public function actionAdvertUpdateLocal() {
        $machine_id = $_GET['id'];
        $advert_id = $_GET['advert_id'];

        $adModel = MachineAdvertAgent::model()->findByPk($advert_id);

        $adModel->setScenario(MachineAdvertAgent::ADVERT_TYPE_LOCALVEDIO);

        //ajax验证，因为创建的不是本控制器的model，所以自己在写
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'machineAdvertAgent-form') {
            echo CActiveForm::validate($adModel);
            Yii::app()->end();
        }

        $this->breadcrumbs = array(Yii::t('MachineAdvertAgent', '广告管理'), Yii::t('MachineAdvertAgent', '编辑盖机本地视频'));
        $name = Yii::t('MachineAdvertAgent', '盖机本地视频');

        if (isset($_POST['MachineAdvertAgent'])) {
            $isSave = false;
            $oldModel_attrs = array();
            foreach ($_POST['MachineAdvertAgent'] as $key => $val) {
                if ($adModel->$key != $val) {
                    $isSave = true;
                    $oldModel_attrs[$key] = $adModel->$key;
//                    break;
                }
            }
            $url = Yii::app()->createUrl('machineAgent/advertList', array('id' => $machine_id, 'adtype' => MachineAdvertAgent::ADVERT_TYPE_VEDIO));

            $adModel->attributes = $_POST['MachineAdvertAgent'];
            if ($isSave) {
                if ($adModel->save()) {

                    $log_title = "盖网通商城-盖网通商城：修改编号为<" . $machine_id . ">的盖机所绑定的编号为<" . $advert_id . ">标题为<" . $adModel->title . ">的" . $name . "广告";
                    $adModel->log_source_id = $advert_id;

                    @SystemLogAgent::saveSystemLogInfo(SystemLogAgent::Machine, $log_title, SystemLogAgent::DO_UPDATE, $adModel, $oldModel_attrs);

                    Yii::app()->user->setState($this->params('msgSessionKey'), array('img' => 'succeed', 'content' => '保存成功!'));
                    $this->redirect($url);
                }
            } else {
//                Yii::app()->user->setState($this->params('msgSessionKey'), array('img' => 'succeed', 'content' => Yii::t('Public','没有数据变更').'!'));
                $this->redirect($url);
            }
        }

        $this->render('advertlocalform', array(
            'model' => $adModel,
            'machine_id' => $machine_id,
        ));
    }

    /**
     * 删除本地视频
     */
    public function actionAdvertRemoveLocal() {
        $machine_id = $_GET['id'];
        $advert_id = $_GET['advert_id'];

        $adModel = Machine2AdvertVideoAgent::model();
        $operateModels = $adModel->findAll("advert_id in (" . $advert_id . ") and machine_id = " . $machine_id);
        foreach ($operateModels as $operateModel) {
            $operateModel->log_source_id = $operateModel->advert_id;
        }
        MachineAdvertAgent::model()->updateAll(array('status' => MachineAdvertAgent::ADVERT_STATUS_DEL), "id in ($advert_id)");
        $adModel->deleteAll("advert_id in (" . $advert_id . ") and machine_id = " . $machine_id);

        $log_title = '删除盖机编号为：' . $advert_id . '的本地视频：盖机编号' . $machine_id;
        @SystemLogAgent::saveSystemLog(SystemLogAgent::Machine, $log_title, SystemLogAgent::DO_DELETE, $operateModels);

        $url = Yii::app()->createUrl('machineAgent/advertList', array('id' => $machine_id, 'adtype' => MachineAdvertAgent::ADVERT_TYPE_VEDIO));

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
//			Yii::app()->user->setState($this->params('msgSessionKey'),array('img'=>'succeed','content'=>  Yii::t('Public','删除成功').'!'));
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : $url);
        }
    }

    /**
     * 关联的盖机
     */
    public function actionAdvertMachine() {
        $machine_id = $this->getQuery('id');     //机器编号
        $advert_id = $this->getQuery('advert_id');   //广告编号
        $adtype = $this->getQuery('adtype');     //获取广告类型，区分是视频广告还是其它广告
        //检查是否有该优惠券权限
        if ($adtype != MachineAdvertAgent::ADVERT_TYPE_VEDIO) {
            $model = MachineAdvertAgent::model()->findByPk($advert_id);
            $this->checkAreaAuth($model->province_id, $model->city_id, $model->district_id);
        }

        switch ($adtype) {
            case MachineAdvertAgent::ADVERT_TYPE_SIGN:
                $machineModel = new Machine2AdvertAgent();
                $name = Yii::t('Machine', '广告');
                break;
            case MachineAdvertAgent::ADVERT_TYPE_COUPON:
                $machineModel = new Machine2AdvertAgent();
                $name = Yii::t('Machine', '格子铺');
                break;
            case MachineAdvertAgent::ADVERT_TYPE_VEDIO:
                $machineModel = new Machine2AdvertVideoAgent();
                $name = Yii::t('Machine', '视频');
                break;
        }

        $machineModel->advert_id = $advert_id;

        //代理地区session
        $agent_region = $this->getPowerAear(false);
        $machineModel->agent_ss = $agent_region;

        $this->breadcrumbs = array(Yii::t('Machine', '广告管理'), $name, Yii::t('Machine', '绑定盖机'));

        if (isset($_GET['addid'])) {   //如果是表单提交
            $deleteid = isset($_GET['delid']) ? $this->getQuery('delid') : "";  //删除数据
            //检查是否有权限解除盖机绑定
            if (!empty($deleteid)) {
                foreach ($deleteid as $value) {
                    $data = MachineAgent::model()->findByPk($value);
                    $this->checkAreaAuth($data->province_id, $data->city_id, $data->district_id);
                }
            }

            $addid = $this->getQuery('addid');  //添加数据

            if (!empty($addid)) {    //如果有添加盖机
                $idArr = explode(",", $addid);

                //检查是否有权限添加该盖机
                foreach ($idArr as $value) {
                    $data = MachineAgent::model()->findByPk($value);
                    $this->checkAreaAuth($data->province_id, $data->city_id, $data->district_id);
                }

                $userip = Tool::ip2int(self::clientIP());
                $userid = Yii::app()->User->id;
                foreach ($idArr as $key => $val) {
                    $machineModel->machine_id = $val;
                    $machineModel->user_ip = $userip;
                    $machineModel->user_id = $userid;
                    $machineModel->create_time = time();
                    $machineModel->isNewRecord = true;
                    $machineModel->save();
                }

                $log_title = "将编号为<" . $advert_id . ">的" . $name . "广告绑定到盖机编号为<" . $addid . ">的盖机中";
                $machineModel->log_source_id = $addid;
                @SystemLogAgent::saveSystemLog(SystemLogAgent::Machine, $log_title, SystemLogAgent::DO_INSERT, $machineModel);
            }

            if (!empty($deleteid)) {   //如果有删除盖机
                $delete_id = "";
                if ($adtype == MachineAdvertAgent::ADVERT_TYPE_VEDIO) {
                    foreach ($deleteid as $keyDel => $valDel) {
                        Machine2AdvertVideoAgent::model()->deleteAll("machine_id = :machine_id and advert_id = :advert_id",array(':machine_id'=>$valDel,':advert_id'=>$advert_id));
                        $delete_id.= $delete_id == "" ? $valDel : "," . $valDel;
                    }
                    $sysmodel = new Machine2AdvertVideoAgent();
                } else {
                    foreach ($deleteid as $keyDel => $valDel) {
                        Machine2AdvertAgent::model()->deleteAll("machine_id = :machine_id and advert_id = :advert_id",array(':machine_id'=>$valDel,':advert_id'=>$advert_id));
                        $delete_id.= $delete_id == "" ? $valDel : "," . $valDel;
                    }
                    $sysmodel = new Machine2AdvertAgent();
                }
                $sysmodel->log_source_id = $delete_id;
                $log_title = "移除编号为<" . $advert_id . ">的" . $name . "广告所绑定的编号为<" . $delete_id . ">的盖机";
                @SystemLogAgent::saveSystemLog(SystemLogAgent::Machine, $log_title, SystemLogAgent::DO_DELETE, $sysmodel);
            }
            $this->redirect($this->createURL('machineAgent/advertMachine', array('id' => $machine_id, 'advert_id' => $advert_id, 'adtype' => $adtype)));
        }
        $this->render('advertmachine', array(
            'model' => $machineModel,
            'dataProvider' => $machineModel->search(),
            'adtype' => $adtype,
            'machine_id' => $machine_id,
        ));
    }

    /**
     * 关联的盖机  产品管理里面的
     */
    public function actionProductMachine() {
        $machine_id = $_GET['id'];     //机器编号
        $product_id = $_GET['product_id'];
        $machineModel = new Machine2ProductAgent();
        $name = Yii::t('Machine', '商品管理');

        //检查是否有权限
        $model = ProductAgent::model()->findByPk($product_id);
        $this->checkAreaAuth($model->province_id, $model->city_id, $model->district_id);

        $machineModel->product_id = $product_id;

        //代理地区session
        $agent_region = $this->getPowerAear(false);
        $machineModel->agent_ss = $agent_region;

        $this->breadcrumbs = array(Yii::t('Machine', '广告管理'), $name, Yii::t('Machine', '绑定盖机'));

        if (isset($_GET['addid'])) {   //如果是表单提交
            $deleteid = isset($_GET['delid']) ? $_GET['delid'] : "";  //删除数据
            //检查是否有权限解除盖机绑定
            if (!empty($deleteid)) {
                foreach ($deleteid as $value) {
                    $data = MachineAgent::model()->findByPk($value);
                    $this->checkAreaAuth($data->province_id, $data->city_id, $data->district_id);
                }
            }

            $addid = $_GET['addid'];  //添加数据

            if (!empty($addid)) {    //如果有添加盖机
                $idArr = explode(",", $addid);

                //检查是否有权限添加该盖机
                foreach ($idArr as $value) {
                    $data = MachineAgent::model()->findByPk($value);
                    $this->checkAreaAuth($data->province_id, $data->city_id, $data->district_id);
                }

                $userip = Tool::ip2int(self::clientIP());
                $userid = Yii::app()->User->id;
                foreach ($idArr as $key => $val) {
                    $machineModel->machine_id = $val;
                    $machineModel->user_ip = $userip;
                    $machineModel->user_id = $userid;
                    $machineModel->create_time = time();
                    $machineModel->isNewRecord = true;
                    $machineModel->save();
                }
                $log_title = "将编号为<" . $product_id . ">的商品绑定到盖机编号为<" . $addid . ">的盖机中";
                $machineModel->log_source_id = $addid;
                @SystemLogAgent::saveSystemLog(SystemLogAgent::Machine, $log_title, SystemLogAgent::DO_INSERT, $machineModel);
            }

            if (!empty($deleteid)) {   //如果有删除盖机
                $delete_id = "";
                foreach ($deleteid as $keyDel => $valDel) {
                    Machine2ProductAgent::model()->deleteAll("machine_id = $valDel and product_id=$product_id");
                    $delete_id.= $delete_id == "" ? $valDel : "," . $valDel;
                }

                $sysmodel = new Machine2ProductAgent();
                $log_title = "解除编号为<" . $product_id . ">的商品在盖机编号为<" . $delete_id . ">的盖机中的绑定";
                $sysmodel->log_source_id = $delete_id;
                @SystemLogAgent::saveSystemLog(SystemLogAgent::Machine, $log_title, SystemLogAgent::DO_DELETE, $sysmodel);
            }
            $this->redirect(Yii::app()->createURL('machineAgent/productMachine', array('id' => $machine_id, 'product_id' => $product_id)));
        }
        $this->render('productmachine', array(
            'model' => $machineModel,
            'dataProvider' => $machineModel->search(),
            'machine_id' => $machine_id,
        ));
    }

    /**
     * 添加盖机广告（弹出查询显示盖机）
     */
    public function actionAdvertAdd() {
        $this->layout = 'left';
        $adtype = $this->getQuery('adtype');
        $machine_id = $this->getQuery('id');
        $adModel = new MachineAdvertAgent();

        //检查是否有权限
        $model = MachineAgent::model()->findByPk($machine_id);
        $this->checkAreaAuth($model->province_id, $model->city_id, $model->district_id);

        $power = $this->getPowerAear(false);
        $adModel->provinceStr = $power['provinceId'];
        $adModel->cityStr = $power['cityId'];
        $adModel->districtStr = $power['districtId'];

        $adModel->unsetAttributes();
        $adModel->advert_type = $adtype;
        $adModel->machine_id = $machine_id;
        $adModel->setScenario($adtype); //根据传递过来的类型来进行场景的设定

        $typeData = '';
        if ($adtype == MachineAdvertAgent::ADVERT_TYPE_COUPON) {
            $typeData = CategoryAgent::model()->findAll("pid = 0 and type=1 and is_visible = " . CategoryAgent::IS_VISIBLE);
        }

        /**
         * 查询所用
         */
        if (isset($_GET['MachineAdvertAgent'])) {
            $dataArray = $this->getQuery('MachineAdvertAgent');
            $adModel->attributes = $dataArray;
            $adModel->category_pid = $dataArray['category_pid'];
        }

        $this->breadcrumbs = array(Yii::t('Machine', '广告管理'), Yii::t('Machine', '盖机添加广告'));

        $this->render('advertadd', array(
            'model' => $adModel,
            'typeData' => $typeData,
            'adtype' => $adtype,
        ));
    }

    /*
     * 盖机添加商品 author r
     */

    public function actionProductAdd() {
        $this->layout = 'left';
        $machine_id = $_GET['id'];
        $productModel = new ProductAgent();
        $machineModel = $this->loadModel($machine_id);
        $productModel->unsetAttributes();
        $productModel->machine_id = $machine_id;

        //检查是否有权限
        $model = MachineAgent::model()->findByPk($machine_id);
        $this->checkAreaAuth($model->province_id, $model->city_id, $model->district_id);

        $power = $this->getPowerAear(false);
        $productModel->provinceStr = $power['provinceId'];
        $productModel->cityStr = $power['cityId'];
        $productModel->districtStr = $power['districtId'];


        $typeData = CategoryAgent::model()->findAll("pid = 0 and type=2 and is_visible = " . CategoryAgent::IS_VISIBLE);

        /**
         * 查询所用
         */
        if (isset($_GET['ProductAgent'])) {
            $productModel->attributes = $_GET['ProductAgent'];
            $productModel->category_pid = $_GET['ProductAgent']['category_pid'];
        }

        $this->breadcrumbs = array('广告管理', '盖机添加产品');

        $this->render('productadd', array(
            'model' => $productModel,
            'machineModel' => $machineModel,
            'typeData' => $typeData,
        ));
    }

    /**
     * 盖机广告排序
     */
    public function actionAdvertSort() {
        $machine_id = $this->getQuery('id');        //盖机编号
        $adtype = $this->getQuery('adtype');        //广告类型

        $model = $this->loadModel($machine_id);     //盖机
        //检查是否有权限
        $this->checkAreaAuth($model->province_id, $model->city_id, $model->district_id);

        $adModel = new MachineAdvertAgent();       //实例化广告对象
        $adModel->setScenario($adtype);       //场景

        $adModel->unsetAttributes();
        $adModel->advert_type = $adtype;
        $adModel->machine_id = $machine_id;

        if ($adtype == MachineAdvertAgent::ADVERT_TYPE_COUPON) {      //只有优惠劵使用,主要是获取选中的父节点和子节点
            //获取全部的广告大类型数据
            $sql = "select distinct c.id,c.name,c.pid,d.name as pname from " . MachineAdvertAgent::model()->tableName() . " a 
                        left join " . Machine2AdvertAgent::model()->tableName() . " b on b.advert_id = a.id 
                        left join " . CategoryAgent::model()->tableName() . " c on c.id = a.category_id 
                        left join " . CategoryAgent::model()->tableName() . " d on d.id = c.pid
                        where b.machine_id = :machine_id and a.advert_type = :advert_type and a.status = :status";

            $categoryData = Yii::app()->gt->createCommand($sql)->bindValues(array(
                ':machine_id'=>$machine_id,
                ':advert_type'=>$adtype,
                ':status'=>MachineAdvertAgent::ADVERT_STATUS
            ))->queryAll();

            $categorypid = array();     //初始化临时变量类型	
            $categoryid = array();     //初始化临时变量类型
            $typeData = array();              //初始化父节点
            $typeChild = array();             //初始化子节点
            $showPId = isset($_GET['category_pid']) ? $this->getQuery('category_pid') : "";  //指定要显示的子类型
            foreach ($categoryData as $row) {
                if (!in_array($row['pid'], $categorypid)) {
                    $categorypid[] = $row['pid'];
                    $typeData[] = array(
                        'id' => $row['pid'],
                        'name' => $row['pname'],
                    );
                }
                if ($showPId == "") {            //如果没有选中某一个大类型进行显示
                    if ($row['pid'] == $categorypid[0]) {       //保存默认要显示的大类型的所有子类型
                        $categoryid[] = $row['id'];
                        $typeChild[] = array(
                            'id' => $row['id'],
                            'name' => $row['name'],
                            'pid' => $row['pid'],
                        );
                    }
                } else {
                    if ($row['pid'] == $showPId) {         //保存当前指定要显示的大类型的所有子类型
                        $categoryid[] = $row['id'];
                        $typeChild[] = array(
                            'id' => $row['id'],
                            'name' => $row['name'],
                            'pid' => $row['pid'],
                        );
                    }
                }
            }

            //指定当前要显示的大类型
            if (isset($_GET['category_pid'])) {
                $adModel->category_pid = $this->getQuery('category_pid');
            } else {
                $adModel->category_pid = empty($typeData) ? "" : $typeData[0]['id'];
            }

            //指定当前要显示的小类型
            if (isset($_GET['category_id'])) {
                $adModel->category_id = $this->getQuery('category_id');    //默认显示大类型的第一个子类型数据			
            } else {
                $adModel->category_id = empty($typeChild) ? "" : $typeChild[0]['id'];
            }

            //关联获取相应的子类型以及对应的数据，并且指定子类型
            $data = $adModel->findAll($adModel->searchSort());

            $this->render('advertsort', array(
                'model' => $model, //盖机
                'adtype' => $adtype, //广告类型
                'adModel' => $adModel, //广告
                'data' => $data,
                'typeData' => $typeData, //广告类型父节点
                'typeChild' => $typeChild, //广告类型子节点
                    )
            );
        } else {
            $this->render('advertsort', array(
                'model' => $model, //盖机
                'adtype' => $adtype, //广告类型
                'adModel' => $adModel, //广告
                    )
            );
        }
    }

    /**
     * 盖机广告排序  用于产品管理
     */
    public function actionProductSort() {
        $machine_id = $_GET['id'];        //盖机编号
        $adtype = MachineAdvertAgent::ADVERT_TYPE_PRODUCT;
        $model = $this->loadModel($machine_id);     //盖机
        //检查是否有权限
        $this->checkAreaAuth($model->province_id, $model->city_id, $model->district_id);

        $productModel = new ProductAgent();       //实例化广告对象
        $productModel->setScenario($adtype);       //场景

        $productModel->unsetAttributes();
        $productModel->machine_id = $machine_id;


        //获取全部的商品大类型数据
        $sql = "select distinct c.id,c.name,c.pid,d.name as pname from " . ProductAgent::model()->tableName() . " a 
                left join " . Machine2ProductAgent::model()->tableName() . " b on b.product_id = a.id 
                left join " . CategoryAgent::model()->tableName() . " c on c.id = a.category_id 
                left join " . CategoryAgent::model()->tableName() . " d on d.id = c.pid
                where b.machine_id = $machine_id and a.status <> " . ProductAgent::STATUS_DEL;

        $categoryData = Yii::app()->gt->createCommand($sql)->queryAll();

        $categorypid = array();     //初始化临时变量类型	
        $categoryid = array();     //初始化临时变量类型
        $typeData = array();              //初始化父节点
        $typeChild = array();             //初始化子节点
        $showPId = isset($_GET['category_pid']) ? $_GET['category_pid'] : "";  //指定要显示的子类型
        foreach ($categoryData as $row) {
            if (!in_array($row['pid'], $categorypid)) {
                $categorypid[] = $row['pid'];
                $typeData[] = array(
                    'id' => $row['pid'],
                    'name' => $row['pname'],
                );
            }
            if ($showPId == "") {            //如果没有选中某一个大类型进行显示
                if ($row['pid'] == $categorypid[0]) {       //保存默认要显示的大类型的所有子类型
                    $categoryid[] = $row['id'];
                    $typeChild[] = array(
                        'id' => $row['id'],
                        'name' => $row['name'],
                        'pid' => $row['pid'],
                    );
                }
            } else {
                if ($row['pid'] == $showPId) {         //保存当前指定要显示的大类型的所有子类型
                    $categoryid[] = $row['id'];
                    $typeChild[] = array(
                        'id' => $row['id'],
                        'name' => $row['name'],
                        'pid' => $row['pid'],
                    );
                }
            }
        }

        //指定当前要显示的大类型
        if (isset($_GET['category_pid'])) {
            $productModel->category_pid = $_GET['category_pid'];
        } else {
            $productModel->category_pid = empty($typeData) ? "" : $typeData[0]['id'];
        }

        //指定当前要显示的小类型
        if (isset($_GET['category_id'])) {
            $productModel->category_id = $_GET['category_id'];    //默认显示大类型的第一个子类型数据			
        } else {
            $productModel->category_id = empty($typeChild) ? "" : $typeChild[0]['id'];
        }


        //关联获取相应的子类型以及对应的数据，并且指定子类型
        $data = $productModel->findAll($productModel->searchSort());

        $this->render('productsort', array(
            'model' => $model, //盖机
            'adtype' => $adtype, //广告类型
            'adModel' => $productModel, //广告
            'typeData' => $typeData, //广告类型父节点
            'typeChild' => $typeChild, //广告类型子节点
            'data' => $data
                )
        );
    }

    /**
     * 保存广告排序
     */
    public function actionAdvertUpdateSort() {
        $advert_id = $this->getPost('advert_id');
        $machine_id = $this->getQuery('id');
        $adtype = $this->getQuery('adtype');

        //检查是否有权限
        $data = MachineAgent::model()->findByPk($machine_id);
        $this->checkAreaAuth($data->province_id, $data->city_id, $data->district_id);

        $len = count($advert_id);
        $sql = "";
        if ($adtype != MachineAdvertAgent::ADVERT_TYPE_VEDIO) {
            $tableName = MachineAdvertAgent::model()->tableName();
            $model = new MachineAdvertAgent();
        } else {
            $tableName = MachineAdvertVideoAgent::model()->tableName();
            $model = new MachineAdvertVideoAgent();
        }
        foreach ($advert_id as $key => $val) {
            //检查是否有该优惠券权限
            $data = MachineAdvertAgent::model()->findByPk($val);
            $this->checkAreaAuth($data->province_id, $data->city_id, $data->district_id);
            $sql.= "update " . $tableName . " set sort = " . $len . " where id = " . $val . ";";
            $len--;
        }
        Yii::app()->gt->createCommand($sql)->execute();

        switch ($adtype) {
            case MachineAdvertAgent::ADVERT_TYPE_COUPON:
                $name = "优惠劵";
                break;
            case MachineAdvertAgent::ADVERT_TYPE_SIGN:
                $name = "首页轮播";
                break;
            case MachineAdvertAgent::ADVERT_TYPE_VEDIO:
                $name = "视频";
                break;
        }

        $log_title = "对编号为<" . $machine_id . ">的盖机中编号为<" . implode(",", $advert_id) . ">的" . $name . "广告进行排序";
        @SystemLogAgent::saveSystemLog(SystemLogAgent::Machine, $log_title, SystemLogAgent::DO_UPDATE, $model);

        //Yii::app()->user->setState($this->params('msgSessionKey'), array('img' => 'succeed', 'content' => '排序成功'));
        $this->redirect($this->createURL('machineAgent/advertList', array('id' => $machine_id, 'adtype' => $adtype)));
    }

    /**
     * 保存广告排序 产品管理
     */
    public function actionProductUpdateSort() {
        $product_id = $_POST['product_id'];
        $machine_id = $_GET['id'];
        $adtype = $_GET['adtype'];

        //检查是否有权限
        $model = MachineAgent::model()->findByPk($machine_id);
        $this->checkAreaAuth($model->province_id, $model->city_id, $model->district_id);

        $len = count($product_id);
        $sql = "";

        $tableName = ProductAgent::model()->tableName();

        foreach ($product_id as $key => $val) {
            //检查是否有该产品权限
            $data = ProductAgent::model()->findByPk($val);
            $this->checkAreaAuth($data->province_id, $data->city_id, $data->district_id);
            $sql.= "update " . $tableName . " set sort = " . $len . " where id = " . $val . ";";
            $len--;
        }
        Yii::app()->gt->createCommand($sql)->execute();

        $sysmodel = new ProductAgent();
        $log_title = "对盖机编号为<" . $machine_id . ">的盖机中绑定的商品进行排序";
        @SystemLogAgent::saveSystemLog(SystemLogAgent::Machine, $log_title, SystemLogAgent::DO_UPDATE, $sysmodel);

        //Yii::app()->user->setState($this->params('msgSessionKey'), array('img' => 'succeed', 'content' => '排序成功'));
        $this->redirect(Yii::app()->createURL('machineAgent/productList', array('id' => $machine_id, 'adtype' => $adtype)));
    }

    /**
     * 获取json格式的广告数据
     */
    public static function getAdvertData() {
        $sql = "select id,pid,name from " . CategoryAgent::model()->tableName() . " where type=1 and id <> 1 and id <> 2 and pid <>1 and is_visible = " . CategoryAgent::IS_VISIBLE . " order by tree_path";
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
     * 获取json格式的广告数据
     */
    public static function getProductData() {
        $sql = "select id,pid,name from " . CategoryAgent::model()->tableName() . " where type=2 and is_visible = " . CategoryAgent::IS_VISIBLE . " order by tree_path";
        $parentData = Yii::app()->gt->createCommand($sql)->query();
        $jsonData = "[";
        foreach ($parentData as $key => $val) {
            $nocheck = $val['pid'] == 0 ? ", nocheck:true" : "";
            $jsonData.= "{ id:" . $val['id'] . ", pId:" . $val['pid'] . ", name:'" . $val['name'] . "'$nocheck},";
        }
        $jsonData = substr($jsonData, 0, -1) . "]";
        return $jsonData;
    }

    /*
     * 单个盖机运行情况统计
     */

    public function actionStaticCount() {
        $onlineTable = "{{machine_online}}";
        $id = $this->getQuery('id');

        //检查是否有权限
        $model = MachineAgent::model()->findByPk($id);
        $this->checkAreaAuth($model->province_id, $model->city_id, $model->district_id);

        $sqlMachineName = "select name from {{machine}} where id=:id";
        $machineName = Yii::app()->gt->createCommand($sqlMachineName)->bindValue(':id',$id)->queryScalar();

        $pageSql = "select DISTINCT FROM_UNIXTIME(time_online,'%Y-%m-%d') as `date` 
                            from gt_machine_online 
                            where machine_id = :id order by `date` desc";

        $resultMachine = Yii::app()->gt->createCommand($pageSql)->bindValue(':id',$id)->query();
        //Tool::p($resultMachine);die;
        $criteria = new CDbCriteria();
        //配置分页
        $pages = new CPagination($resultMachine->rowCount);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);

        $resultMachine = Yii::app()->gt->createCommand($pageSql . " LIMIT :offset ,:limit");
        $resultMachine->bindValue(':id', $id);
        $resultMachine->bindValue(':offset', $pages->currentPage * $pages->pageSize);
        $resultMachine->bindValue(':limit', $pages->pageSize);

        $machineData = $resultMachine->queryAll();
        // Tool::p($machineData);die;
        $dateFrom = "";
        $dateEnd = "";
        if (count($machineData) > 0) {
            $dateFrom = strtotime($machineData[count($machineData) - 1]['date']);
            $dateEnd = (int) strtotime($machineData['0']['date']) + 86399;
        } else {
            $dataStr = '[{"name":"没有数据","intervals":[
                    {"from":"2013-12-13 17:22","to":"2013-12-13 17:49"}]}]';
            $this->render('staticcount', array('machineName' => $machineName, 'pages' => $pages, 'data' => $dataStr));
            exit;
        }


        $sqlData = "select FROM_UNIXTIME(time_online,'%Y-%m-%d %H:%i') as onlinetime,
                            FROM_UNIXTIME(time_online,'%Y-%m-%d') as dateonline,
                            FROM_UNIXTIME(time_online,'%m-%d') as refonline,
                            FROM_UNIXTIME(time_offline,'%Y-%m-%d %H:%i') as offlinetime
                            from gt_machine_online where machine_id = :machine_id and time_online >= :time_online and time_offline <= :time_offline  order by refonline desc";

        $data = Yii::app()->gt->createCommand($sqlData)->bindValues(array(
            ':machine_id'=>$id,
            ':time_online'=>$dateFrom,
            ':time_offline'=>$dateEnd
        ))->queryAll();


        //Tool::p($data);die;
        $tmpdate = "";
        $arr = array();
        $dataStr = "[";
        foreach ($data as $key => $val) {
            if ($tmpdate != $val['dateonline']) {
                $tmpdate = $val['dateonline'];

                if (!empty($arr))
                    $dataStr.= json_encode($arr) . ",";

                $arr = array();
                $arr['name'] = $val['refonline'];
            }
            $arr['intervals'][] = array(
                'from' => $val['onlinetime'],
                'to' => $val['offlinetime'],
            );
        }

        if (!empty($arr))
            $dataStr.= json_encode($arr) . ",";
        $dataStr = substr($dataStr, 0, -1) . "]";


        $this->render('staticcount', array('machineName' => $machineName, 'pages' => $pages, 'data' => $dataStr));
    }

    /**
     * 盖机注册会员和消费统计
     */
    public function actionRcCount() {
        $model = new MachineAgent;
        if ($this->getQuery('machine_id')) {
            $machineId = $this->getQuery('machine_id');
        } else {
            $getDate = $this->getQuery('MachineAgent');
            $machineId = $getDate['id'];
        }
        $model->id = $machineId;
        $getDate2 = $this->getQuery('MachineAgent');
        if ($getDate2) {
            $createTime = $getDate2['create_time'];
            $createTimes = str_replace('-', '', $createTime);
            $rStartTime = $createTime != "" ? " AND FROM_UNIXTIME(register_time,'%Y%m') = :rStartTime " : "";
            $fStartTime = $createTime != "" ? " AND FROM_UNIXTIME(create_time,'%Y%m') = :rStartTime " : "";
            $model->create_time = $createTime != "" ? $createTime : "";
        } else {
            $rStartTime = "";
            $fStartTime = "";
        }


        $sql = "SELECT time,SUM(num) AS num,SUM(mony) AS mony FROM (
SELECT register_time AS time,0 as mony,COUNT(*) AS num FROM gaitong.gt_machine_register WHERE machine_id = :machineId " . $rStartTime . " GROUP BY FROM_UNIXTIME(register_time,'%Y%m') 
UNION ALL
SELECT create_time AS time,SUM(spend_money) AS mony,0 as num FROM gw_franchisee_consumption_record WHERE machine_id = :machineId " . $fStartTime . " GROUP BY FROM_UNIXTIME(create_time,'%Y%m')
) a  GROUP BY FROM_UNIXTIME(time,'%Y%m') ORDER BY time desc ";
        if ($getDate2) {
            if ($getDate2['create_time'] != "") {
                $rs = Yii::app()->db->createCommand($sql)->bindValues(array(
                            ':machineId' => $machineId,
                            ':rStartTime' => $createTimes,
                            ':fStartTime' => $createTimes,
                        ))->query();
            } else {
                $rs = Yii::app()->db->createCommand($sql)->bindValues(array(
                            ':machineId' => $machineId,
                        ))->query();
            }
        } else {
            $rs = Yii::app()->db->createCommand($sql)->bindValues(array(
                        ':machineId' => $machineId,
                    ))->query();
        }
        $criteria = new CDbCriteria();

        //配置分页
        $pages = new CPagination($rs->rowCount);
        $pages->pageSize = 8;
        $pages->applyLimit($criteria);

        $rsData = Yii::app()->db->createCommand($sql . " LIMIT :offset ,:limit");
        $rsData->bindValue(':offset', $pages->currentPage * $pages->pageSize);
        $rsData->bindValue(':limit', $pages->pageSize);
        $rsData->bindValue(':machineId', $machineId);

        if ($getDate2) {
            if ($getDate2['create_time'] != "") {
                $rsData->bindValue(':rStartTime', $createTimes);
                $rsData->bindValue(':fStartTime', $createTimes);
            }
        }


        $allData = $rsData->queryAll();

        //统计盖机注册、消费总数
        $reCount = MachineRegister::model()->count("machine_id = :machine_id", array(':machine_id' => $machineId));
        $sql = "select sum(spend_money) as mony from gw_franchisee_consumption_record where machine_id = :machine_id";
        $coCount = Yii::app()->db->createCommand($sql)->bindValues(array(':machine_id' => $machineId))->queryScalar();

        $this->render('consumption', array('allData' => $allData, 'pages' => $pages, 'model' => $model, 'reCount' => $reCount, 'coCount' => $coCount));
    }

    /*
     * 盖机运营数据查看
     */

    public function actionOperateData() {
        $model = new MachineAgent();

        $model->unsetAttributes();  // clear any default values
        $searchTime = time();   //默认查询当月时间
        $model->create_time = date('Y-m', $searchTime);

        if ($getDate = $this->getQuery('MachineAgent')) {
            $searchTime = $getDate['create_time'] == "" ? $searchTime : strtotime($getDate['create_time']);
            $model->create_time = $getDate['create_time'];
        }

        $time = date('Ym', $searchTime);


        //查找所属代理盖机
        $agent_region = $this->getPowerAear(false);
        $model->agent_ss = $agent_region;
        $criteria = $model->searchControll();
        $data = $model->findAll($criteria);
        if ($data) {
            foreach ($data as $v) {
                $machineId[] = $v['id'];
            }
            $machineId = array_unique($machineId);   //筛选重复盖机
            $machineIdStr = implode(",", $machineId);
            $machineIdStr = "(" . $machineIdStr . ")";
        } else {
            $machineIdStr = "(0)";
        }


        //查找符合条件数据集
        $sql = "SELECT machine_id,:searchTime AS time,m.name,SUM(num) AS num,SUM(money) AS money,SUM(history_num) AS history_num,SUM(history_money) AS history_money FROM(
SELECT machine_id,register_time AS time,COUNT(*) AS num,0 AS money,0 AS history_num,0 AS history_money FROM gaitong.gt_machine_register WHERE FROM_UNIXTIME(register_time,'%Y%m') = :time AND machine_id IN" . $machineIdStr . " GROUP BY machine_id
UNION ALL
SELECT machine_id,create_time AS time,0 AS num,SUM(spend_money) AS money,0 AS history_num,0 AS history_money FROM gw_franchisee_consumption_record WHERE FROM_UNIXTIME(create_time,'%Y%m') = :time AND machine_id IN" . $machineIdStr . " GROUP BY machine_id
UNION ALL
SELECT machine_id,register_time AS time,0 AS num,0 AS money,COUNT(*) AS history_num,0 AS history_money FROM gaitong.gt_machine_register WHERE machine_id IN" . $machineIdStr . " GROUP BY machine_id
UNION ALL
SELECT machine_id,create_time AS time,0 AS num,0 AS money,0 AS history_num,SUM(spend_money) AS history_money FROM gw_franchisee_consumption_record WHERE machine_id IN" . $machineIdStr . " GROUP BY machine_id
) a LEFT JOIN gaitong.gt_machine m ON a.machine_id=m.id GROUP BY machine_id";

        $rs = Yii::app()->db->createCommand($sql)->bindValues(array(
                    ':time' => $time,
                    ':searchTime' => $searchTime,
                ))->query();
        $criteria = new CDbCriteria();

        //配置分页
        $pages = new CPagination($rs->rowCount);
        $pages->pageSize = 8;
        $pages->applyLimit($criteria);

        $rsData = Yii::app()->db->createCommand($sql . " LIMIT :offset ,:limit");
        $rsData->bindValue(':searchTime', $searchTime);
        $rsData->bindValue(':time', $time);
        $rsData->bindValue(':offset', $pages->currentPage * $pages->pageSize);
        $rsData->bindValue(':limit', $pages->pageSize);

        $allData = $rsData->queryAll();


        //每列统计
        $sqlCount = "SELECT machine_id,time,m.name,SUM(num) AS num,SUM(money) AS money,SUM(history_num) AS history_num,SUM(history_money) AS history_money FROM(
SELECT machine_id,register_time AS time,COUNT(*) AS num,0 AS money,0 AS history_num,0 AS history_money FROM gaitong.gt_machine_register WHERE FROM_UNIXTIME(register_time,'%Y%m') = :time AND machine_id IN" . $machineIdStr . " GROUP BY machine_id
UNION ALL
SELECT machine_id,create_time AS time,0 AS num,SUM(spend_money) AS money,0 AS history_num,0 AS history_money FROM gw_franchisee_consumption_record WHERE FROM_UNIXTIME(create_time,'%Y%m') = :time AND machine_id IN" . $machineIdStr . " GROUP BY machine_id
UNION ALL
SELECT machine_id,register_time AS time,0 AS num,0 AS money,COUNT(*) AS history_num,0 AS history_money FROM gaitong.gt_machine_register WHERE machine_id IN" . $machineIdStr . " GROUP BY machine_id
UNION ALL
SELECT machine_id,create_time AS time,0 AS num,0 AS money,0 AS history_num,SUM(spend_money) AS history_money FROM gw_franchisee_consumption_record WHERE machine_id IN" . $machineIdStr . " GROUP BY machine_id
) a LEFT JOIN gaitong.gt_machine m ON a.machine_id=m.id";

        $rsCount = Yii::app()->db->createCommand($sqlCount)->bindValues(array(':time' => $time))->queryRow();


        $this->render('operate', array('allData' => $allData, 'model' => $model, 'pages' => $pages, 'rsCount' => $rsCount));
    }

    /*
     * 盖机运营数据导出
     */

    public function actionExportExcel() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        // date_default_timezone_set('Europe/London');

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');

        Yii::import('comext.PHPExcel.*');


        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()
                ->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");

        $model = new MachineAgent;
        $model->unsetAttributes();  // clear any default values

        if ($this->getQuery('create_time') != "") {
            $time = $this->getQuery('create_time') . "-01";
            $searchTime = strtotime($time);
        } else {
            $searchTime = time();   //默认查询当月时间
        }
        $time = date('Ym', $searchTime);

        //查找所属代理盖机
        $agent_region = $this->getPowerAear(false);
        $model->agent_ss = $agent_region;
        $criteria = $model->searchControll();
        $data = $model->findAll($criteria);
        if ($data) {
            foreach ($data as $v) {
                $machineId[] = $v['id'];
            }
            $machineId = array_unique($machineId);   //筛选重复盖机
            $machineIdStr = implode(",", $machineId);
            $machineIdStr = "(" . $machineIdStr . ")";
        } else {
            $machineIdStr = "(0)";
        }

        //查找符合条件数据集
        $sql = "SELECT machine_id,:searchTime AS time,m.name,SUM(num) AS num,SUM(money) AS money,SUM(history_num) AS history_num,SUM(history_money) AS history_money FROM(
SELECT machine_id,register_time AS time,COUNT(*) AS num,0 AS money,0 AS history_num,0 AS history_money FROM gaitong.gt_machine_register WHERE FROM_UNIXTIME(register_time,'%Y%m') = :time AND machine_id IN" . $machineIdStr . " GROUP BY machine_id
UNION ALL
SELECT machine_id,create_time AS time,0 AS num,SUM(spend_money) AS money,0 AS history_num,0 AS history_money FROM gw_franchisee_consumption_record WHERE FROM_UNIXTIME(create_time,'%Y%m') = :time AND machine_id IN" . $machineIdStr . " GROUP BY machine_id
UNION ALL
SELECT machine_id,register_time AS time,0 AS num,0 AS money,COUNT(*) AS history_num,0 AS history_money FROM gaitong.gt_machine_register WHERE machine_id IN" . $machineIdStr . " GROUP BY machine_id
UNION ALL
SELECT machine_id,create_time AS time,0 AS num,0 AS money,0 AS history_num,SUM(spend_money) AS history_money FROM gw_franchisee_consumption_record WHERE machine_id IN" . $machineIdStr . " GROUP BY machine_id
) a LEFT JOIN gaitong.gt_machine m ON a.machine_id=m.id GROUP BY machine_id";

        $allData = Yii::app()->db->createCommand($sql)->bindValues(array(
                    ':time' => $time,
                    ':searchTime' => $searchTime,
                ))->queryAll();
        //每列统计
        $sqlCount = "SELECT machine_id,time,m.name,SUM(num) AS num,SUM(money) AS money,SUM(history_num) AS history_num,SUM(history_money) AS history_money FROM(
SELECT machine_id,register_time AS time,COUNT(*) AS num,0 AS money,0 AS history_num,0 AS history_money FROM gaitong.gt_machine_register WHERE FROM_UNIXTIME(register_time,'%Y%m') = :time AND machine_id IN" . $machineIdStr . " GROUP BY machine_id
UNION ALL
SELECT machine_id,create_time AS time,0 AS num,SUM(spend_money) AS money,0 AS history_num,0 AS history_money FROM gw_franchisee_consumption_record WHERE FROM_UNIXTIME(create_time,'%Y%m') = :time AND machine_id IN" . $machineIdStr . " GROUP BY machine_id
UNION ALL
SELECT machine_id,register_time AS time,0 AS num,0 AS money,COUNT(*) AS history_num,0 AS history_money FROM gaitong.gt_machine_register WHERE machine_id IN" . $machineIdStr . " GROUP BY machine_id
UNION ALL
SELECT machine_id,create_time AS time,0 AS num,0 AS money,0 AS history_num,SUM(spend_money) AS history_money FROM gw_franchisee_consumption_record WHERE machine_id IN" . $machineIdStr . " GROUP BY machine_id
) a LEFT JOIN gaitong.gt_machine m ON a.machine_id=m.id";

        $rsCount = Yii::app()->db->createCommand($sqlCount)->bindValues(array(':time' => $time))->queryRow();

        //输出表头
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', '时间')
                ->setCellValue('B1', '盖机名称')
                ->setCellValue('C1', '新增会员数')
                ->setCellValue('D1', '新增消费金额')
                ->setCellValue('E1', '历史新增会员数')
                ->setCellValue('F1', '历史消费总金额');

        $num = 1;
        foreach ($allData as $key => $row) {
            $num++;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $num, date('Y年m月', $row['time']))
                    ->setCellValue('B' . $num, " " . $row['name'])     //加空格避免纯数字类型名称导出时把前面的0去掉如001
                    ->setCellValue('C' . $num, $row['num'])
                    ->setCellValue('D' . $num, $row['money'])
                    ->setCellValue('E' . $num, $row['history_num'])
                    ->setCellValue('F' . $num, $row['history_money']);
        }
        $num++;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $num, "总计")
                ->setCellValue('B' . $num, "")
                ->setCellValue('C' . $num, $rsCount['num'])
                ->setCellValue('D' . $num, $rsCount['money'])
                ->setCellValue('E' . $num, $rsCount['history_num'])
                ->setCellValue('F' . $num, $rsCount['history_money']);

        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle("盖机运营数据");

        $name = "盖机运营数据";
        $name = iconv('UTF-8', 'GB2312', $name);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

}
