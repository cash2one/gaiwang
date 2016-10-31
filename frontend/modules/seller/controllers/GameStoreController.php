<?php
/**
 * @author: xiaoyan.luo
 * @mail: xiaoyan.luo@g-emall.com
 * Date: 2015/11/20 13:53
 */
class GameStoreController extends SController {
    /**
     * 查看游戏店铺
     */
    public function actionView() {
        $this->layout = 'seller';
        $model = GameStore::model()->findByPk($this->gameStoreId);
        if(!$model){
            $this->redirect(array('/seller/GameStore/invalid'));
        }
        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * 编辑游戏店铺
     */
    public function actionUpdate($id) {
        $this->gameStoreCheck($id);//检查权限
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        $model->setScenario('updateGameStore');
        $this->performAjaxValidation($model);
        if (isset($_POST['GameStore'])) {
            $_POST['GameStore']['update_time'] = time();
            $model->attributes = $this->getPost('GameStore');

            if ($model->save()) {
                //添加操作日志
                @$this->_saveSellerLog(SellerLog::CAT_COMPANY, SellerLog::logTypeUpdate, $id, '更新游戏店铺');
                $this->setFlash('success', Yii::t('store', '操作成功'));
                $this->redirect(array('view'));
            } else {
                $this->setFlash('error', Yii::t('store', '操作失败'));
                $this->redirect(array('view'));
            }
        }
        $this->render('update', array('model' => $model));
    }

    public function actionInvalid(){
        $this->render('invalid');
    }

    /**
     * 游戏公告
     */
    public function actionGameNotice(){
        $gameStore = GameStore::model()->findByPk($this->gameStoreId);
        if(!$gameStore){
            throw new CHttpException(403,'您还没有创建游戏店铺！');
        }
        if($gameStore->franchise_stores <> GameStore::FRANCHISE_STORES_IS){
            throw new CHttpException(403,'您没有权限操作！');
        }
        $model  = GameNotice::model()->findByAttributes(array('game_store_id'=>$this->gameStoreId));
        if(!$model){
            $model = new GameNotice;
        }
        $this->performAjaxValidation($model);

        if(isset($_POST['GameNotice'])){
            $model->attributes = $this->getParam('GameNotice');
            $model->game_store_id = $this->gameStoreId;
            if($model->isNewRecord){
                $model->create_time = time();
                $model->update_time = time();
            }else{
                $model->update_time = time();
            }
            if($model->save()){
                $this->setFlash('success', Yii::t('store', '操作成功'));
            }else{
                $this->setFlash('error', Yii::t('store', '操作失败'));
            }
        }
        $this->render('noticeform',array(
            'model'=>$model
        ));
    }

    /**
     * 游戏反馈
     */
    public function actionFeedback(){
        $condition = isset($_POST['contact']) ? " AND contact LIKE '%".preg_replace("/\s|　/","",$_POST['contact'])."%'" : "";
        $pageSize = 13;//每页显示个数
        $start = 0;
        if(isset($_GET['page']) && $_GET['page'] <> 1){
            $start = ($_GET['page'] - 1) * $pageSize - 1;
        }
        $limit = " LIMIT " . $start ."," . $pageSize;
        $sql = "SELECT name,contact,content FROM " . GAME . ".`gw_game_feedback` WHERE type = " . AppVersion::APP_TYPE_GAME_PANZHIHUA . $condition . $limit;
        $data = Yii::app()->db->createCommand($sql)->queryAll();

        //分页
        $sqlCount = "SELECT name,contact,content FROM " . GAME . ".`gw_game_feedback` WHERE type = " . AppVersion::APP_TYPE_GAME_PANZHIHUA . $condition;
        $dataCount = Yii::app()->db->createCommand($sqlCount)->queryAll();
        $pager = new CPagination(count($dataCount));
        $pager->pageSize = $pageSize;
        $this->render('feedback',array(
            'data' => $data,
            'pages' => $pager,
            'contact' => isset($_POST['contact'])?preg_replace("/\s|　/","",$_POST['contact']):"",
            'pageSize' => $pageSize
        ));

    }

    /**
     * 店铺流水列表
     */
    public function actionShopflow(){
        if(isset($_GET['time']) && !empty($_GET['time'])){
            $starTime = strtotime($_GET['time']);
            $endTime = $starTime + 86400;
            $timeStr = date('Y-m-01',strtotime($_GET['time']));
            $monthStart = strtotime($timeStr);
            $monthEnd = strtotime("$timeStr +1 month");
            $whereToday = " AND e.create_time >=" . $starTime . " AND e.create_time <" . $endTime;
            $whereTodayFlow = " AND create_time >=" . $starTime . " AND create_time <" . $endTime;
            $whereMonthFlow = " AND create_time >=" . $monthStart . " AND create_time <" . $monthEnd;
        }else{
            $starTime = strtotime(date('Y-m-d',time()));
            $endTime = $starTime + 86400;
            $timeStr = date('Y-m-01',time());
            $monthStart = strtotime($timeStr);
            $monthEnd = strtotime("$timeStr +1 month");
            $whereToday = " AND e.create_time >=" . $starTime . " AND e.create_time <" . $endTime;
            $whereTodayFlow = " AND create_time >=" . $starTime . " AND create_time <" . $endTime;
            $whereMonthFlow = " AND create_time >=" . $monthStart . " AND create_time <" . $monthEnd;
        }
        $pageSize = 13;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $star = isset($_GET['page']) ? ($page -1) * $pageSize : 0;
        $limitSql = " LIMIT " . $star . "," . $pageSize;
        $sql = "SELECT e.expenditure,e.create_time,m.gai_number FROM ".GAME.".`gw_game_expend` AS e
                LEFT JOIN ".GAME.".`gw_game_member` AS m ON e.member_id=m.member_id WHERE e.game_type = "
                .AppVersion::APP_TYPE_GAME_PANZHIHUA." AND e.result_code = 1".$whereToday.$limitSql;
        $sqlCount = "SELECT e.id FROM ".GAME.".`gw_game_expend` AS e WHERE e.game_type = "
            .AppVersion::APP_TYPE_GAME_PANZHIHUA." AND e.result_code = 1".$whereToday;
        $sqlToday = "SELECT sum(expenditure) AS todayFlow FROM ".GAME.".`gw_game_expend` WHERE
                    game_type = ".AppVersion::APP_TYPE_GAME_PANZHIHUA." AND result_code = 1".$whereTodayFlow;
        $sqlMonth = "SELECT sum(expenditure) AS monthFlow FROM ".GAME.".`gw_game_expend` WHERE
                    game_type = ".AppVersion::APP_TYPE_GAME_PANZHIHUA." AND result_code = 1".$whereMonthFlow;
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $dataCount = Yii::app()->db->createCommand($sqlCount)->queryAll();
        $todayFlow = Yii::app()->db->createCommand($sqlToday)->queryScalar();
        $monthFlow = Yii::app()->db->createCommand($sqlMonth)->queryScalar();

        $pager = new CPagination(count($dataCount));
        $pager->pageSize = $pageSize;

        $this->render('storeflow',array(
            'todayFlow' => $todayFlow,
            'monthFlow' => $monthFlow,
            'data' => $data,
            'todayFlow' => $todayFlow,
            'monthFlow' => $monthFlow,
            'time' => isset($_GET['time']) ? $_GET['time'] : "",
            'searchTime' => isset($_GET['time']) && !empty($_GET['time']) ? $_GET['time'] : date('Y-m-d',time()),
            'pages' => $pager
        ));
    }

    /**
     * 查看评论
     */
    public function actionCommentList(){
        $model = new GameOrderDetail;
        $model->unsetAttributes();

        $criteria = new CDbCriteria;
        if(isset($_POST['GameOrderDetail'])){
            $model->attributes = $this->getParam('GameOrderDetail');
            $criteria->compare('t.mobile', $model->mobile, true);
        }
        $criteria->select = "t.real_name,t.mobile,s.store_name,t.comment";
        $criteria->join = "LEFT JOIN {{game_store}} AS s ON t.store_id = s.id";
        $criteria->compare('t.comment_status', GameOrderDetail::COMMENT_IS);
        $criteria->order = "t.comment_time DESC";

        //分页
        $count = $model->count($criteria);
        $page = new CPagination($count);
        $page->pageSize = 13;
        $page->applyLimit($criteria);
        $comment = $model->findAll($criteria);

        $this->render('commentlist', array(
            'model' => $model,
            'comment' => $comment,
            'pages' => $page
        ));
    }
}