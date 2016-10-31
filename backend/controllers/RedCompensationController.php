<?php

/**
 *  红包补偿
 * @author ling.wu
 */
class RedCompensationController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 红包活动商品标签列表
     */
    public function actionAdmin() {
        $model = new Coupon('search');
        $model->unsetAttributes();
        if (isset($_GET['Coupon'])) {
            $model->attributes = $this->getParam('Coupon');
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 添加红包补偿
     * @author ling.wu
     */
    public function actionCreate() {
        $model = new Coupon();
        $model->setScenario('compensation');
        $this->performAjaxValidation($model);
        if (isset($_POST['Coupon'])) {
            $model->attributes = $this->getPost('Coupon');
            if ($model->validate(array('type,gai_number,sms_content'))) {
                $member_id = Coupon::getGaiNumber($model->gai_number);
                if ($member_id) {
                    $sms_content = '';
                    if ($model->choice_sms) {
                        $sms_content = $model->sms_content;
                    }
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        RedEnvelopeTool::createRedisActivity($member_id, Coupon::SOURCE_GAIWANG, $model->type, Coupon::COMPENSATE_YES, $sms_content);
                        $transaction->commit();
                        @SystemLog::record(Yii::app()->user->name . "添加红包补偿ID：{$member_id}");
                        $this->setFlash('success', Yii::t('Activity', "添加红包补偿成功！"));
                        $this->redirect(array('admin'));
                    } catch (Exception $e) {
                        $transaction->rollback();
                        $this->setFlash('error', Yii::t('Activity', "添加红包补偿失败！") . $e->getMessage());
                    }
                }
            } else {
                $this->setFlash('error', CHtml::errorSummary($model));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 批量红包补偿
     * @throws CDbException
     */
    public function actionBatchCreate() {
        $model = new Coupon('compensation');
        $modelArr = array();
        for ($i = 0; $i < 10; $i++) {
            $modelArr[$i] = new Coupon('batchCompensation');
        }
        if (isset($_POST['Coupon']['arr'])) {
            foreach ($_POST['Coupon']['arr'] as $k => $v) {
                $modelArr[$k]->attributes = $v;
            }
        }

        $this->performAjaxValidationTabular($model, $modelArr, array('gai_number'));
        if (isset($_POST['Coupon'])) {
            $model->attributes = $this->getPost('Coupon');
            if ($model->validate(array('type,gai_number,sms_content'))) {
                $member_id = Coupon::getGaiNumber($model->gai_number);
                if ($member_id) {
                    $sms_content = '';
                    if ($model->choice_sms) {
                        $sms_content = $model->sms_content;
                    }
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        RedEnvelopeTool::createRedisActivity($member_id, Coupon::SOURCE_GAIWANG, $model->type, Coupon::COMPENSATE_YES, $sms_content);
                        foreach ($modelArr as $k => $v) {
                            if (!$v->gai_number)
                                continue;
                            if ($v->validate(array('gai_number'))) {
                                RedEnvelopeTool::createRedisActivity($v->member_id, Coupon::SOURCE_GAIWANG, $model->type, Coupon::COMPENSATE_YES, $sms_content);
                                @SystemLog::record(Yii::app()->user->name . "添加红包补偿ID：{$v->member_id}");
                            }
                        }
                        $transaction->commit();
                        @SystemLog::record(Yii::app()->user->name . "添加红包补偿ID：{$member_id}");
                        $this->setFlash('success', Yii::t('Activity', "添加红包补偿成功！"));
                        $this->redirect(array('admin'));
                    } catch (Exception $e) {
                        $transaction->rollback();
                        $this->setFlash('error', Yii::t('Activity', "添加红包补偿失败！") . $e->getMessage());
                    }
                }
            } else {
                $this->setFlash('error', CHtml::errorSummary($model));
            }
        }
        $this->render('batchCreate', array(
            'model' => $model,
            'modelArr' => $modelArr,
        ));
    }

//    使用兑换码进行红包充值
    public function actionExchangeCode() {
        $model = new ExchangeCode();
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ExchangeCode']))
            $model->attributes = $_GET['ExchangeCode'];
//        $modelArr = 10;
        $this->render('exchangeCode', array(
            'model' => $model,
        ));
    }

//录入红包兑换码方法
    public function actionEntryPage() {
        $model = new ExchangeCode('required');
        $modelArr = array();
        $data = array();
        
        for ($i = 0; $i < 9; $i++) {
            $modelArr[$i] = new ExchangeCode('norequired');
        }
         if (isset($_POST['ExchangeCode']['arr'])) {
            foreach ($_POST['ExchangeCode']['arr'] as $k => $v) {
                $modelArr[$k]->attributes = $v;
            }
        }

        $this->performAjaxValidationTabular($model, $modelArr, array('gai_number'));
        //   $modelArr[0]->setScenario('insert');

//        $this->performAjaxValidation($model);
        if (isset($_POST['ExchangeCode']['arr'])) {
            $name = ExchangeCode::model()->exists('name=:m', array(':m' => $_POST['ExchangeCode']['name']));
            if (!$name) {
                $model->money = $_POST['ExchangeCode']['money'];
                $model->type = Activity::TYPE_RECHARGE;
                $model->name = $_POST['ExchangeCode']['name'];
                $model->save(FALSE);
                $data[9]['name'] = $_POST['ExchangeCode']['name'];
                $data[9]['money'] = $_POST['ExchangeCode']['money'];
                $data[9]['error'] = '成功';
            } else {
                $data[9]['name'] = $_POST['ExchangeCode']['name'];
                $data[9]['money'] = $_POST['ExchangeCode']['money'];
                $data[9]['error'] = '失败：该兑换券已经生成';
            }
//            Tool::p($_POST['ExchangeCode']);
            foreach ($_POST['ExchangeCode']['arr'] as $k => $v) {
                $modelArr[$k]->attributes = $v;
                $modelArr[$k]->money = $_POST['ExchangeCode']['money'];
                $modelArr[$k]->type = Activity::TYPE_RECHARGE;
                if (!empty($v['name'])) {
                    $reg = '/[0-9]{12}/';
                    if (preg_match($reg, $v['name'])) {
                        $name = ExchangeCode::model()->exists('name=:m', array(':m' => $v['name']));
                        if (!$name) {
                            $modelArr[$k]->save(FALSE);
                            $data[$k] = $v;
                            $data[$k]['money'] = $_POST['ExchangeCode']['money'];
                            $data[$k]['error'] = '成功';
                        } else {
                            $data[$k] = $v;
                            $data[$k]['money'] = $_POST['ExchangeCode']['money'];
                            $data[$k]['error'] = '失败：该兑换券已经生成';
                        }
                    } else {
                        $data[$k] = $v;
                        $data[$k]['money'] = $_POST['ExchangeCode']['money'];
                        $data[$k]['error'] = '失败：兑换码格式不正确（须由12位纯数字）';
                    }

//                    Tool::p($name);
                }
            }
            @SystemLog::record($this->getUser()->name . "批量生成红包兑换码");
//            $this->setFlash('success', Yii::t('member', '生成兑换码成功！'));
            $this->render('displayPage', array('data' => $data));
            exit;

//          
        }


        $this->render('entryPage', array(
            'model' => $model,
            'modelArr' => $modelArr,
        ));
    }

    /**
     * 导出录入兑换码的结果
     */
    public function actionExchangeCodeExport() {
        if (isset($_POST['data'])) {
            $data = unserialize($_POST['data']);
            //引入phpExcel
            require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel/Shared/String.php';
            require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel.php';
            Yii::registerAutoloader(array('PHPExcel_Autoloader', 'Register'), true);
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', '序号')
                    ->setCellValue('B1', '兑换码')
                    ->setCellValue('C1', '面值')
                    ->setCellValue('D1', '结果');
            $i = 2;
            foreach ($data as $k => $v) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $i, $k + 1)
                        ->setCellValue('B' . $i, $v['name'])
                        ->setCellValue('C' . $i, $v['money'])
                        ->setCellValue('D' . $i, $v['error']);
                $i++;
            }
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="批量生成兑换码结果.xls"');
            header('Cache-Control: max-age=0');
            $objWriter->save('php://output');
            @SystemLog::record(Yii::app()->user->name . "导出兑换码数据成功");
            unset($data, $objPHPExcel, $objWriter);
        }
    }

    /**
     * ajax取得活动面额
     * @param $type
     */
    public function actionGetActivityMoney($type) {
        if ($this->isAjax()) {
            $money = Yii::app()->db->createCommand()
                    ->select('money')
                    ->from('{{activity}} as a')
                    ->where('mode=:mode and status=:status and type=:type', array(':mode' => Activity::ACTIVITY_MODE_RED, ':status' => Activity::STATUS_ON, ':type' => $type))
                    ->queryScalar();
            echo $money ? $money : 0;
        }
    }

    /**
     * ajax验证
     * @param $model
     * @param $models
     * @param $validateAttribitus
     */
    protected function performAjaxValidationTabular($model, $models, $validateAttribitus) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === $this->id . '-form') {
            $error = CActiveForm::validate($model);
            if (!empty($models)) {
                $tErr = CActiveForm::validateTabular($models, $validateAttribitus, false);
                $tArr = CJSON::decode($tErr, true);
                $modelName = CHtml::modelName(Coupon::model());
                foreach ($validateAttribitus as $attribute) {
                    foreach ($tArr as $eid => $err) {
                        if (strpos($eid, $attribute) !== false) {
                            $id = str_replace($modelName, "{$modelName}_arr", $eid);
                            $tArr[$id] = $err;
                            unset($tArr[$eid]);
                        }
                    }
                }
                $merge = array_merge(CJSON::decode($error, true), $tArr);
                $error = CJSON::encode($merge);
            }
            echo $error;
            Yii::app()->end();
        }
    }

    /*
     * 军旅专题投票红包奖励
     */
    public function actionVoteRed(){

        if(isset($_GET['Vote'])){
            $sql = 'select distinct member_id from {{vote}}';
            $members = Yii::app()->db->createCommand($sql)->queryColumn();

            if(!empty($members)){
                $transaction = Yii::app()->db->beginTransaction();
                try{
                    $sms_content = '';
                    foreach($members as $v){
                        $memberId = Member::model()->findByPk($v);
                        if($memberId){
                            RedEnvelopeTool::createRedisActivity($v, Coupon::SOURCE_GAIWANG, Activity::TYPE_VOTE, Coupon::COMPENSATE_YES, $sms_content);
                            @SystemLog::record(Yii::app()->user->name . "添加红包补偿ID: {$v}");
                        }
                    }
                    $transaction->commit();
                    $this->setFlash('success', Yii::t('Activity',"红包奖励成功！"));
                    $this->redirect(array('votered'));
                }catch (Exception $e){
                    $transaction->rollback();
                    $this->setFlash('error', Yii::t('Activity', "红包奖励失败！") . $e->getMessage());
                }
            }else{
                $this->setFlash('error',Yii::t('Activity','不存在符合奖励的会员！'));
            }

        }

        $this->render('votered');
    }

}
