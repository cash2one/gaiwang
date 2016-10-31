<?php

class SeckillAuctionActivityController extends Controller
{
    public static $mime = array('image/gif', 'image/jpeg', 'image/png');
    public $maxLimit = 1000;

    public function filters() {
           return array(
               'rights',
           );
       }
      public function allowedActions()
       {
           return 'checkCreate';
       }

    /**
     * 专题活动内容列表(拍卖活动)
     * @param integer category_id 活动的类型ID
     * @param integer status 活动的状态
     */
    public function actionSeckillAuctionAdmin()
    {

        $model = new SeckillRulesSeting('search');
        $dataProvider = array();

        $model->categoryId = isset($_GET['category_id']) ? intval($_GET['category_id']) : SeckillRulesSeting::SECKILL_CATEGORY_FOUR;
        $model->status = isset($_GET['status']) ? intval($_GET['status']) : 0;
        $model->rulesId = isset($_GET['rules_id']) ? intval($_GET['rules_id']) : 0;


        $data = $model->getAuctionRulesRecord($model->categoryId, $model->status, $model->rulesId);
        $dataProvider = $data['data'];
        $pages = $data['pages'];

        $this->render('list', array(
            'model' => $model,
            'labels' => $model->attributeLabels(),
            'dataProvider' => $dataProvider,
            'pages' => $pages,
        ));
    }

    /**
     * 创建拍卖活动
     *
     */
    public function actionSeckillAuctionCreate()
    {
        $model = new SeckillRulesSeting;
        $categoryId = $this->getParam('category_id');
        $rulesId = $this->getParam('rules_id');

        $model->scenario = 'auctionCreate';
        $this->performAjaxValidation($model);
        $this->checkPostRequest();

        if (isset($_POST['SeckillRulesSeting'])) {

            $postArray = $_POST['SeckillRulesSeting'];
            $model->attributes = $postArray;

            //上传图片限制(由于规则不起作用且没找到原因,暂时这样解决)
            $m1 = 1024 * 1024;//1M
            $att1 = CUploadedFile::getInstanceByName('SeckillRulesSeting[picture]');
       /*     if ($att1 && $att1->error ==1) {
                //$size=ini_get("upload_max_filesize");
                // $this->setFlash('success', Yii::t('secondKillActivity',"活动图片 大于配置最大值{$size},请重新上传."));
                $this->setFlash('success', Yii::t('secondKillActivity', '活动图片 大于1M,请重新上传.'));
                $this->redirect(array('SeckillAuctionCreate', 'category_id' => $categoryId, 'rules_id' => $rulesId, 'rules_seting_id' => $rulesSetingId));
                exit;
            }*/
         /*   if (($att1 && $att1->size > $m1) || ($att1 && $att1->error ==1)) {
                $this->setFlash('success', Yii::t('secondKillActivity', '活动图片 大于1M,请重新上传.'));
                $this->redirect(array('SeckillAuctionCreate', 'category_id' => $categoryId, 'rules_id' => $rulesId));
                exit;
            }

            if ($att1 && !in_array($att1->type, self::$mime)) {
                $this->setFlash('success', Yii::t('secondKillActivity', '活动图片 只能上传jpg、jpeg、gif、png格式.'));
                $this->redirect(array('SeckillAuctionCreate', 'category_id' => $categoryId, 'rules_id' => $rulesId));
                exit;
            }*/
            $saveDir = 'seckill/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'picture', $saveDir);

            if ($model->validate()) {

                $postArray['picture'] = $model->picture;
                $postArray['category_id'] = $categoryId;
                $postArray['rules_id'] = intval($rulesId);
                $postArray['sort'] = $postArray['sort'] > 10000 ? 10000 : $postArray['sort'];
                $postArray['allow_singup'] = 0;

                $rulesSetingId = $model->createAuctionRules($postArray);

                AuctionData::updateActivityAuction($rulesSetingId);
                $model->updateCache(0);//更新前台缓存

                @SystemLog::record(Yii::app()->user->name . "添加拍卖活动：$postArray[name]");
                $this->setFlash('success', Yii::t('AuctionActivity', "添加{$model->name}活动成功！"));


                // 保存图片文件
                UploadedFile::saveFile('picture', $model->picture);

                $adminAct = 'SeckillAuctionAdmin';
                $this->redirect(array($adminAct, 'category_id' => $categoryId, 'rules_id' => $rulesId));
            }
        }
        $model->rulesId = intval($rulesId);
        $model->categoryId = intval($categoryId);
        $this->render('create', array(
            'model' => $model,
            'labels' => $model->attributeLabels(),
        ));
    }

    /**
     * 修改应节性活动
     * @param integer $categoryId 活动类型id
     * @param integer $rulesId 活动主表的id
     * @param integer $rulesSetingId 活动规则表的id
     */
    public function actionSeckillAuctionUpdate()
    {
        $model = new SeckillRulesSeting;
        $categoryId = $this->getParam('category_id');
        $rulesId = $this->getParam('rules_id');
        $rulesSetingId = $this->getParam('rules_seting_id');

        $model->scenario = 'auctionUpdate';
        $this->performAjaxValidation($model);
        $this->checkPostRequest();

        if (isset($_POST['SeckillRulesSeting'])) {
            $postArray = $_POST['SeckillRulesSeting'];

            $model->attributes = $postArray;

            //上传图片限制(由于规则不起作用且没找到原因,暂时这样解决)
            $m1 = 1024 * 1024;//1M
            $att1 = CUploadedFile::getInstanceByName('SeckillRulesSeting[picture]');
         /*   if ($att1 && $att1->error ==1) {
                //$size=ini_get("upload_max_filesize");
               // $this->setFlash('success', Yii::t('secondKillActivity',"活动图片 大于配置最大值{$size},请重新上传."));
                $this->setFlash('success', Yii::t('secondKillActivity', '活动图片 大于1M,请重新上传.'));
                $this->redirect(array('SeckillAuctionUpdate', 'category_id' => $categoryId, 'rules_id' => $rulesId, 'rules_seting_id' => $rulesSetingId));
                exit;
            }
            if ($att1 && $att1->size > $m1) {
                $this->setFlash('success', Yii::t('secondKillActivity', '活动图片 大于1M,请重新上传.'));
                $this->redirect(array('SeckillAuctionUpdate', 'category_id' => $categoryId, 'rules_id' => $rulesId, 'rules_seting_id' => $rulesSetingId));
                exit;
            }

            if ($att1 && !in_array($att1->type, self::$mime)) {
                $this->setFlash('success', Yii::t('secondKillActivity', '活动图片 只能上传jpg、jpeg、gif、png格式.'));
                $this->redirect(array('SeckillAuctionUpdate', 'category_id' => $categoryId, 'rules_id' => $rulesId, 'rules_seting_id' => $rulesSetingId));
                exit;
            }*/
            $saveDir = 'seckill/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'picture', $saveDir);

            if ($model->validate()) {
                $postArray['picture'] = $model->picture;

                $postArray['category_id'] = intval($categoryId);
                $postArray['rules_id'] = intval($rulesId);
                $postArray['rules_seting_id'] = intval($rulesSetingId);
                $postArray['sort'] = $postArray['sort'] > 10000 ? 10000 : $postArray['sort'];

                if ($model->picture) {
                    $picture = $model->getActivityPicture2($rulesSetingId);
                }



                $model->updateAuctionRules($postArray);
                AuctionData::updateActivityAuction($rulesSetingId);
                $model->updateCache($rulesSetingId);//更新前台缓存

                //更新结束前提醒表的时间
                Yii::app()->db->createCommand()->update('{{seckill_auction_remind}}', array('rules_end_time' => strtotime($postArray['end_time'])), 'rules_setting_id=:id', array(':id' => $rulesSetingId));

                // 保存并删除旧文件
                if ($postArray['picture']) {//保存上传的图片文件
                    UploadedFile::saveFile('picture', $model->picture, $picture['picture'], true);
                }

                @SystemLog::record(Yii::app()->user->name . "修改活动：id=$rulesId");
                $this->setFlash('success', Yii::t('actionActivity', "修改活动成功！"));


                $adminAct = 'SeckillAuctionAdmin';
                $this->redirect(array($adminAct, 'category_id' => $categoryId, 'rules_id' => $rulesId));
            }
        }
        $model->rulesId = intval($rulesId);
        $model->categoryId = intval($categoryId);
        $model->rulesSetingId = intval($rulesSetingId);
        $this->render('update', array(
            'model' => $model,
            'dataProvider' => $model->getRulesById($rulesSetingId),
            'labels' => $model->attributeLabels(),
        ));
    }

    public function actionStart()
    {
        $model = new SeckillRulesSeting;
        $data = array('success' => false, 'message' => '操作失败');

        $id = intval($this->getParam('id'));
        $status = intval($this->getParam('status'));

        //更改活动的状态
        $upStatus = SeckillRulesSeting::ACTIVITY_NOT_START;
        $time = time();
        $sql = "SELECT rm.name, rm.date_start,rm.date_end,rs.status,rs.start_time,rs.end_time FROM {{seckill_rules_main}} rm, {{seckill_rules_seting}} rs WHERE rm.id=rs.rules_id AND rs.id=:id";
        $return = Yii::app()->db->createCommand($sql)->queryRow(true, array(':id' => $id));
        $name=$return['name'];
        $startTime = strtotime($return['date_start'] . ' ' . $return['start_time']);
        $endTime = strtotime($return['date_end'] . ' ' . $return['end_time']);
        if ($status == SeckillRulesSeting::ACTIVITY_NOT_OPEN) {
            $upStatus = SeckillRulesSeting::ACTIVITY_IS_OVER;
        } else {
            $upStatus = $time > $endTime ? SeckillRulesSeting::ACTIVITY_IS_OVER : (($time >= $startTime && $time <= $endTime) ? SeckillRulesSeting::ACTIVITY_IS_RUNNING : SeckillRulesSeting::ACTIVITY_NOT_START);
        }

        if ($upStatus < SeckillRulesSeting::ACTIVITY_IS_OVER) {//开启活动
            Yii::app()->db->createCommand()->update('{{seckill_rules_seting}}', array('status' => $upStatus), 'id=:id', array(':id' => $id));

            @SystemLog::record(Yii::app()->user->name . "开启活动： id=" . $id);
        } else {//强制结束
            Yii::app()->db->createCommand()->update('{{seckill_rules_seting}}', array('status' => SeckillRulesSeting::ACTIVITY_IS_OVER,'sort' => 99999,'is_force'=>SeckillRulesSeting::IS_FORCE_YES), 'id=:id', array(':id' => $id));

            //清空goods表对应的seckill_seting_id
            Yii::app()->db->createCommand()->update('{{goods}}', array('seckill_seting_id' => 0), 'seckill_seting_id=:id', array(':id' => $id));

            //恢复商品原结束时间
            Yii::app()->db->createCommand()->update('{{seckill_auction_price}}', array('auction_end_time' => $endTime), 'rules_setting_id=:rules_setting_id', array(':rules_setting_id' => $id));

            $sql="select distinct member_id from {{seckill_auction_record}} where rules_setting_id={$id}";
            $command= Yii::app()->db->createCommand($sql);
            $memberids=$command->queryAll();
            if($memberids){
                foreach($memberids as $v){
                    Yii::app()->db->createCommand()->insert('{{message}}', array(
                        'title' => "通知",
                        'content' => $name."活动因特殊情况本次竞拍需终止，不便之处敬请谅解",
                        'create_time' => time(),
                        'sender_id' => $this->getUser()->id,
                        'sender' => 'GW',
                        'receipt_time' => time()
                    ));
                    $message_id=Yii::app()->db->getLastInsertID();
                    Yii::app()->db->createCommand()->insert('{{mailbox}}', array(
                        'status'=>0,
                        'message_id' =>$message_id,
                        'member_id' =>$v['member_id']
                    ));
                }
            }

            @SystemLog::record(Yii::app()->user->name . "结束活动： id=" . $id);
        }

        //更新前台缓存
        $model->updateCache($id);//更新前台缓存
        AuctionData::updateActivityAuction($id);

        $data['success'] = true;
        echo json_encode($data);
        exit;
    }

    /**
     * 创建/修改活动规则提交前的判断
     * @param array $SeckillRulesSeting 活动内容数组
     * @return json $data 返回检查信息
     */
    public function actionCheckCreate()
    {
        $data = array('success' => false, 'message' => '信息填写有误.');

        if (isset($_POST['post'])) {

            $categoryId = intval($_POST['categoryId']);
            $startTime = strtotime($_POST['startTime']);
            $endTime = strtotime($_POST['endTime']);
            $name = isset($_POST['name']) ? trim($_POST['name']) : '';
            $rulesId = isset($_POST['rulesId']) ? intval($_POST['rulesId']) : 0;
            $rulesSetingId = isset($_POST['rulesSetingId']) ? intval($_POST['rulesSetingId']) : 0;

            if (!$startTime || !$endTime || $endTime <= $startTime) {//检查时间格式
                $data['message'] = '请检查开始时间和结束时间.';
                echo json_encode($data);
                exit;
            }
/*
            if($categoryId == SeckillRulesSeting::SECKILL_CATEGORY_FOUR){//判断时间是否重复

                if(intval($startTime)>=intval($endTime)){
                    $data['message'] = '请检查开始时间和结束时间.';
                    echo json_encode ($data);
                    exit;
                }

                $startTime = date('H:i:s', $startTime);
                $endTime   = date('H:i:s', $endTime);

                if($rulesSetingId){

                    $sql  = "SELECT id FROM {{seckill_rules_seting}} WHERE rules_id=:rules_id AND id!=:id AND start_time <= :end_time AND end_time >= :start_time ";
                    $result  = Yii::app()->db->createCommand($sql)->queryRow(true,array(':rules_id'=>$rulesId, ':start_time'=>$startTime, ':end_time'=>$endTime, ':id'=>$rulesSetingId));

                }else{

                    $sql = "SELECT id FROM {{seckill_rules_seting}} WHERE rules_id=:rules_id AND start_time <= :end_time AND end_time >= :start_time";
                    $result  = Yii::app()->db->createCommand($sql)->queryRow(true,array(':rules_id'=>$rulesId, ':start_time'=>$startTime, ':end_time'=>$endTime));

                }

                if($result){
                    $data['message'] = '时间已被占用，请重新选择.';
                    echo json_encode ($data);
                    exit;
                }
            }
*/
            $sort = isset($_POST['seckillSort']) ? intval($_POST['seckillSort']) : 0;
            if ($sort && $categoryId == SeckillRulesSeting::SECKILL_CATEGORY_FOUR) {//秒杀活动没有排序
                if ($rulesSetingId) {
                    $sql = "SELECT rs.id FROM {{seckill_rules_seting}} rs,{{seckill_rules_main}} rm WHERE rm.id=rs.rules_id AND rm.category_id=:category_id AND rs.sort=:sort AND rs.id!=:id";
                    $result = Yii::app()->db->createCommand($sql)->queryRow(true, array(':id' => $rulesSetingId, ':sort' => $sort, ':category_id' => $categoryId));
                } else {
                    $sql = "SELECT rs.id FROM {{seckill_rules_seting}} rs,{{seckill_rules_main}} rm WHERE rm.id=rs.rules_id AND rm.category_id=:category_id AND rs.sort=:sort";
                    $result = Yii::app()->db->createCommand($sql)->queryRow(true, array(':category_id' => $categoryId, ':sort' => $sort));
                }

                if ($result) {
                    $data['message'] = '排序号已被占用,请重新输入.';
                    echo json_encode($data);
                    exit;
                }
            }

        }

        $data['success'] = true;
        $data['message'] = '信息填写正确.';
        echo json_encode($data);
        exit;
    }

    public function actionStop()
    {
        $model = new SeckillRulesSeting;
        $data = array('success' => false, 'message' => '操作失败');

        $id = intval($this->getParam('id'));
        $status = intval($this->getParam('status'));

        //更改活动的状态
        $upStatus = SeckillRulesSeting::ACTIVITY_NOT_START;
        $time = time();
        $sql = "SELECT rm.name,rm.date_start,rm.date_end,rs.status,rs.start_time,rs.end_time FROM {{seckill_rules_main}} rm, {{seckill_rules_seting}} rs WHERE rm.id=rs.rules_id AND rs.id=:id";
        $return = Yii::app()->db->createCommand($sql)->queryRow(true, array(':id' => $id));
        $name=$return['name'];
        $startTime = strtotime($return['date_start'] . ' ' . $return['start_time']);
        $endTime = strtotime($return['date_end'] . ' ' . $return['end_time']);
        if ($status == SeckillRulesSeting::ACTIVITY_NOT_OPEN) {
            $upStatus = SeckillRulesSeting::ACTIVITY_IS_OVER;
        } else {
            $upStatus = $time > $endTime ? SeckillRulesSeting::ACTIVITY_IS_OVER : (($time >= $startTime && $time <= $endTime) ? SeckillRulesSeting::ACTIVITY_IS_RUNNING : SeckillRulesSeting::ACTIVITY_NOT_START);
        }

        if ($upStatus < SeckillRulesSeting::ACTIVITY_IS_OVER) {//开启活动
            Yii::app()->db->createCommand()->update('{{seckill_rules_seting}}', array('status' => $upStatus), 'id=:id', array(':id' => $id));

            @SystemLog::record(Yii::app()->user->name . "开启活动： id=" . $id);
        } else {//强制结束
            Yii::app()->db->createCommand()->update('{{seckill_rules_seting}}', array('status' => SeckillRulesSeting::ACTIVITY_IS_OVER, 'sort' => 99999,'is_force'=>SeckillRulesSeting::IS_FORCE_YES), 'id=:id', array(':id' => $id));

            //清空goods表对应的seckill_seting_id
            Yii::app()->db->createCommand()->update('{{goods}}', array('seckill_seting_id' => 0), 'seckill_seting_id=:id', array(':id' => $id));

            //清空必抢表对应的rules_id
            Yii::app()->db->createCommand()->update('{{seckill_grab}}', array('rules_id' => 0), 'rules_id=:id', array(':id' => $id));

            //恢复商品原结束时间
            Yii::app()->db->createCommand()->update('{{seckill_auction_price}}', array('auction_end_time' => $endTime), 'rules_setting_id=:rules_setting_id', array(':rules_setting_id' => $id));

            $sql="select distinct member_id from {{seckill_auction_record}} where rules_setting_id={$id}";
            $command= Yii::app()->db->createCommand($sql);
            $memberids=$command->queryAll();
            if($memberids){
                foreach($memberids as $v){
                    Yii::app()->db->createCommand()->insert('{{message}}', array(
                        'title' => "通知",
                        'content' => $name."活动因特殊情况本次竞拍需终止，不便之处敬请谅解",
                        'create_time' => time(),
                        'sender_id' => $this->getUser()->id,
                        'sender' => 'GW',
                        'receipt_time' => time()
                    ));
                    $message_id=Yii::app()->db->getLastInsertID();
                    Yii::app()->db->createCommand()->insert('{{mailbox}}', array(
                        'status'=>0,
                        'message_id' =>$message_id,
                        'member_id' =>$v['member_id']
                    ));
                  }
            }


            @SystemLog::record(Yii::app()->user->name . "结束活动： id=" . $id);
        }

        //更新前台缓存
        $model->updateCache($id);//更新前台缓存
        AuctionData::updateActivityAuction($id);
        $data['success'] = true;
        echo json_encode($data);
        exit;
    }


}