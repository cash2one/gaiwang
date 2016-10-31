<?php

/**
 * 居间商控制器
 * 操作(列表、新增)
 */
class MiddleAgentController extends Controller
{

    public function filters()
    {
        return array(
            'rights',
        );
    }
    public function allowedActions(){
        return 'search,check,getTreeGridData';
    }

    /**
     * 居间商列表
     */
    public function actionAdmin()
    {
        $this->breadcrumbs = array(Yii::t('store', '居间商 ') => array('middleAgent/admin'), Yii::t('store', '居间商列表'));
        $model = new MiddleAgent('search');
        $model->unsetAttributes();
        if(isset($_GET['MiddleAgent'])){
            $model->attributes = $_GET['MiddleAgent'];
        }
        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    /**
     * 添加居间商
     */
    public function actionCreate(){
        $model = new MiddleAgent();
        if($this->getParam('parentId')){
            $model->parent_id = $this->getParam('parentId');
        }
        if(isset($_POST['MiddleAgent'])){
            $model->attributes = $this->getPost('MiddleAgent');
            $trans = Yii::app()->db->beginTransaction();
            try{
                /**
                 * @var MiddleAgent $middleAgent
                 */
                $middleAgent = MiddleAgent::model()->findByAttributes(array('member_id'=>$model->member_id));
                if($middleAgent){
                    if($middleAgent->level==MiddleAgent::LEVEL_PARTNER){
                        $model = $middleAgent;
                        $model->parent_id = 0;
                        $model->level = $_POST['MiddleAgent']['level'];
                    }else{
                        throw new Exception($model->gai_number."已经是居间商");
                    }
                }
                $model->create_time = time();

                if(!$model->save(false)){
                    throw new Exception('保存数据失败');
                }
                //修改店铺相关
                if($model->store_id){
                    Yii::app()->db->createCommand()->update('gw_store',array(
                        'is_middleman'=>Store::STORE_ISMIDDLEMAN_YES,
                    ),'id='.$model->store_id);
                }
                $this->setFlash('success','添加居间商成功');
                $trans->commit();
                @SystemLog::record($this->getUser()->name . "添加居间商：" . $model->username) ;
                $this->redirect(array('middleAgent/admin'));
            }catch (Exception $e){
                $trans->rollback();
                $this->setFlash('error','添加居间商失败:'.$e->getMessage());
            }
        }
        $this->render('create',array('model'=>$model));
    }

    /**
     * ajax添加居间商验证商户
     * @throws CHttpException 不是ajax提交
     */
    public function actionCheck()
    {
        if(!Yii::app()->request->isAjaxRequest){
            throw new CHttpException('404', Yii::t('middleAgent','找不到页面'));
        }
        $gai_number = Yii::app()->request->getParam('gai_number');
        $error = true;
        if(!is_null($gai_number) && !is_numeric($gai_number)){
            $sql = 'SELECT
                    t.id,
                    s.is_middleman,
                    s.id AS store_id,
                    t.gai_number,
                    t.mobile,
                    t.username
                FROM
                gw_member as t
                LEFT JOIN gw_store as s on s.member_id=t.id
                where t.gai_number=:gai_number';
            $member = Yii::app()->db->createCommand($sql)->bindValue(':gai_number',$gai_number)->queryRow();
            if(is_null($member)){
                exit(json_encode(array('error'=>$error,'msg'=>  Yii::t('middleAgent','该会员不存在或者未通过审核'))));
            }
            if($member['is_middleman'] == Store::STORE_ISMIDDLEMAN_YES){
                exit(json_encode(array('error'=>$error,'msg'=>  Yii::t('middleAgent','该居间商已存在，不能再添加'))));
            }
            $error = false;
            exit(json_encode(array(
                'error'=>$error,
                'username'=>$member['username'],
                'mobile'=>$member['mobile'],
                'store_id'=>$member['store_id'],
                'member_id'=>$member['id'],
            )));
        }
        exit(json_encode(array('error'=>$error,'msg'=>  Yii::t('middleAgent','输出账号格式有误'))));
    }

    /**
     * 获取表格分类树数据
     */
    public function actionGetTreeGridData(){
        $id = $this->getParam('id');
        $data = array();
        if (is_numeric($id)) {
            $model = new MiddleAgent();
            $data = $model->getTreeData($id);
            if($id==0){
                $total = Yii::app()->db->createCommand('select count(*) from gw_middle_agent where level>0 and parent_id=0')->queryScalar();
                $data = array('rows'=>$data,'total'=>$total);
            }
        }
        echo CJSON::encode($data);
    }

    /**
     * ajax 搜索
     */
    public function actionSearch(){
        $model = new MiddleAgent();
        $model->attributes = $this->getPost('MiddleAgent');
        $data = $model->search();
        if(!empty($data)){
            foreach ($data as &$v){
                $v = $model->getAllTreeByChild($v);
            }
        }
       echo json_encode(array('rows'=>$data,'total'=>count($data)));

    }

    /**
     * 居间商直属商家页面
     * @param $pid
     */
    public function actionPartner($pid){
        $model = new MiddleAgent();
       $this->render('partner',array('pid'=>$pid,'model'=>$model));
    }

    /**
     * 查看商家销售记录
     */
    public function actionViewPay()
    {
        $sid = $this->getParam('store_id');
        $criteria = new CDbCriteria;
        $criteria->compare('status', Order::STATUS_COMPLETE);
        $criteria->compare('store_id', $sid);
        // 只统计今天以前的数据 昨天的
        $time = strtotime(date('Y-m-d',strtotime('now'))) - 1;
        $criteria->compare('create_time', '<=' . $time);
        $criteria->select = " FROM_UNIXTIME(create_time,'%Y%m') AS `months`,COUNT(id) AS `orderCount`,SUM(real_price) AS `account`,store_id";
        $criteria->group = 'months';
        $criteria->order = 'months DESC';
        $order = new Order('search');
        //定义三个order临时属性
        $order->attributes = array(
            'months' => 0,
            'orderCount' => 0,
            'account' => 0
        );
        //定义三个order临时属性
        // 计算当前月份和店铺创建月份差
        $create_time = strtotime(date("Y-m", Store::model()->findByPk($sid)->create_time));
        // 商城迁移，流水20150101开始计算，所以以前的流水看不到了
        $create_time = $create_time > strtotime('20150101') ? $create_time : strtotime('20150101');
        $month = abs(date("Y", time()) - date("Y", $create_time)) * 12 + date("m", time()) - date("m", $create_time);
        $dataProvider = new CActiveDataProvider($order, array(
            'criteria' => $criteria,
            'pagination'=>array(
                'pageSize'=>20
            )
        ));
        $data = $dataProvider->getData();
        //获取存在数据的月份
        $months = array();
        foreach ($data as $store) {
            $months[] = $store->months;
        }
        //构造没有销量的月份数据
        $sales = array();
        $count = count($data); $j=1;
        for ($i = 0; $i <= $month; $i++) {
            $time = date('Ym', strtotime("+$i month", $create_time));
            if (!in_array($time, $months)) {
                $o = new Order();
                $o->months = $time;
                $o->store_id = $sid;
                array_unshift($sales, $o);
            } else {
                array_unshift($sales, $data[$count-$j]);
                $j++;
            }
        }
        $dataProvider->setData($sales);
        $dataProvider->setTotalItemCount($month+1);
        $this->render('viewpay', array(
                'dataProvider' => $dataProvider,
                'id' => $sid,
            )
        );
    }

    /**
     * 查看商家信息详情
     */
    public function actionViewStore()
    {
        $store_id = Yii::app()->request->getParam('store_id');
        if ($store_id && $store_id > 0) {
            $model = new Store();
            $model->id = $store_id;
            $store = $model->viewStore();
            if(!$store) throw  new Exception("找不到商家信息");
        }
        $this->render('viewstore', array('model' => $store));
    }

    /*
 * 查看某月的销售明细
 */
    public function actionViewMonth(){
        $sid = $this->getParam('store_id');
        $month = $this->getParam('months');
        $date = $month . '01'; // 组合成每个月的第一天 如: 20150401

        $criteria = new CDbCriteria;
        $criteria->select = " FROM_UNIXTIME(create_time,'%Y-%m-%d') AS `months`,COUNT(id) AS `orderCount`,SUM(real_price) AS `account`,store_id";
        $criteria->condition = 'status = '.Order::STATUS_COMPLETE .
            ' AND store_id = ' . $sid .
            ' AND create_time >' . strtotime($date) .
            ' AND create_time < UNIX_TIMESTAMP(DATE_ADD('.$date .',INTERVAL +1 MONTH))';
        $criteria->group = 'months';
        $criteria->order = 'months ASC';
        $order = new Order('search');
        //定义三个order临时属性
        $order->attributes = array(
            'orderCount' => 0,
            'account' => 0,
            'months' => 0
        );
        //定义三个order临时属性
        // 计算每月 天数
        $day = $this->_dayNum(date('m', strtotime($date)), date('Y', strtotime($date)));
        $dataProvider = new CActiveDataProvider($order, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => $day
            )
        ));
        $data = $dataProvider->getData();

        //获取存在数据的月份
        $days = array();
        foreach ($data as $store) {
            $days[] = $store->months;
        }
        //构造没有销量的日期数据
        $sales = array();

        // 是否是当前月，是统计到昨天
        if($month == date('Ym')){
            $day = date('d') - 1;
        }
        $count = count($data);
        $j = 0;
        for ($i = 0; $i < $day; $i++) {
            $time = date('Y-m-d', strtotime("+$i day", strtotime($date)));
            if (!in_array($time, $days)) {
                $o = new Order();
                $o->months = $time;
                $o->store_id = $sid;
                array_unshift($sales, $o);
            } else {
                array_unshift($sales, $data[$j]);
                $j++;
            }
        }
        $dataProvider->setData($sales);
        $dataProvider->setTotalItemCount($day);
        $this->render('viewmonth',
            array(
                'dataProvider' => $dataProvider,
                'id' => $sid,
                'month'=>$date
            )
        );
    }
    /**
     * 返回某年某月的月份总日数
     */
    protected function _dayNum($month,$year)
    {
        return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
    }

    /**
     *  删除居间商
     * @param int $id
     */
    public function actionDelete($id)
    {
        /**
         * @var $model MiddleAgent
         */
        $model = $this->loadModel($id);
        $db = Yii::app()->db;
        $trans = $db->beginTransaction();
        try{
            //更新店铺
            if($model->store_id){
                $db->createCommand()->update('gw_store',array('is_middleman'=>Store::STORE_ISMIDDLEMAN_NO),'id='.$model->store_id);
            }
            //删除直招商户
            $partner = $db->createCommand('select id,store_id from gw_middle_agent where parent_id and level=:l and parent_id=:pid')
                ->bindValues(array(':l'=>MiddleAgent::LEVEL_PARTNER,':pid'=>$id))->queryAll();
            if($partner){
                foreach ($partner as $v){
                    $db->createCommand()->delete('gw_middle_agent','id='.$v['id']);
                }
            }
            //更新与子类的关系
            $db->createCommand()->update('gw_middle_agent',array('parent_id'=>0),'parent_id='.$id);
            $model->delete();
            $trans->commit();
            @SystemLog::record($this->getUser()->name . "删除居间商：" . $model->username) ;
            $this->setFlash('success','操作成功');
        }catch (Exception $e){
            $trans->rollback();
            $this->setFlash('error','操作失败:'.$e->getMessage());
        }
        $this->redirect(array('middleAgent/admin'));
    }

    /**
     * 更新居间商
     * @param $id
     */
    public function actionUpdate($id){
        /**
         * @var $model MiddleAgent
         */
        $model = $this->loadModel($id);
        $oldLevel = $model->level;
        if(isset($_POST['MiddleAgent'])){
            $model->attributes = $this->getPost('MiddleAgent');
            $trans = Yii::app()->db->beginTransaction();
            try{
                if($model->level < $oldLevel){
                    $model->parent_id = 0; //切断跟父类的关系
                }else{
                    //降级 切断跟子类的关系
                    Yii::app()->db->createCommand()->update('gw_middle_agent',array('parent_id'=>0),
                        'parent_id=:pid and level<>:l',array(':pid'=>$id,':l'=>MiddleAgent::LEVEL_PARTNER));
                }
                if(!$model->save(false)){
                    throw new Exception("更新居间商错误");
                }
                $trans->commit();
                @SystemLog::record($this->getUser()->name . "修改居间商：" . $model->username) ;
                $this->setFlash('success','操作成功');
                $this->redirect(array('middleAgent/admin'));
            }catch (Exception $e){
                $trans->rollback();
                $this->setFlash('error','操作失败：'.$e->getMessage());
            }
        }

        $this->render('update',array('model'=>$model));
    }

    /**
     * 添加直招商户
     * @param int $parentId
     */
    public function actionCreatePartner($parentId){
        /**
         * @var $model MiddleAgent
         */
        $model = $this->loadModel($parentId);
        if(isset($_POST['MiddleAgent'])){
            $newModel = new MiddleAgent();
            $newModel->attributes = $this->getPost('MiddleAgent');
            $trans = Yii::app()->db->beginTransaction();
            try{
                /**
                 * @var MiddleAgent $middleAgent
                 */
                $middleAgent = MiddleAgent::model()->findByAttributes(array('member_id'=>$newModel->member_id));
                if($middleAgent){
                    if($middleAgent->level==MiddleAgent::LEVEL_PARTNER){
                        throw new Exception($model->gai_number."已经是直招商户");
                    }else{
                        throw new Exception($model->gai_number."已经是居间商");
                    }
                }
                $newModel->create_time = time();
                $newModel->parent_id = $model->id;
                $newModel->level = MiddleAgent::LEVEL_PARTNER;

                if(!$newModel->save(false)){
                    throw new Exception('保存数据失败');
                }
                $this->setFlash('success','操作成功');
                $trans->commit();
                @SystemLog::record($this->getUser()->name . "添加直招商户：" . $newModel->username) ;
                $this->redirect(array('middleAgent/admin'));
            }catch (Exception $e){
                $trans->rollback();
                $this->setFlash('error','操作失败:'.$e->getMessage());
            }
        }
        $this->render('create',array('model'=>$model));
    }


}
