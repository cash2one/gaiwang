<?php

/**
 * 充值卡控制器
 * 操作（添加充值卡，添加积分返还充值卡，修改，删除，充值卡列表，积分返还充值卡列表，使用记录列表）
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class PrepaidCardController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 不作权限控制的action
     * @return string
     */
    public function allowedActions() {
        return 'getScore, getMoney, convert';
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * 删除充值卡
     * 只能删除未使用的充值卡
     * @param type $id
     */
    public function actionDelete($id) {
        $model = PrepaidCard::model()->findByPk($id, 'status=:status', array(':status' => PrepaidCard::STATUS_UNUSED));
        if ($model === null)
            throw new CHttpException(404, '你请求的页面不存在');
        $model->delete();
        @SystemLog::record(Yii::app()->user->name . "删除充值卡：" . $id);
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * 添加积分返还充值卡
     * 积分返还充值卡，会员使用后，不会转为正式会员
     */
    public function actionCreateGeneral() {
        $model = new PrepaidCard('general');
        $this->performAjaxValidation($model);
        if (isset($_POST['PrepaidCard'])) {
            $model->attributes = $_POST['PrepaidCard'];
            if ($model->save()) {
                @SystemLog::record(Yii::app()->user->name . "添加积分返还充值卡：" . 'value->' . $model->value);
                $this->setFlash('sucess', Yii::t('prepaidCard', '添加积分返还充值卡成功'));
                $this->redirect(array('index'));
            }
        }
        $this->render('creategeneral', array('model' => $model));
    }

    /**
     * 添加充值卡
     * 此充值卡，会员使用后，会转为正式会员
     */
    public function actionCreate() {
        $model = new PrepaidCard('special');
        $this->performAjaxValidation($model);
        if (isset($_POST['PrepaidCard'])) {
            $model->attributes = $this->magicQuotes($_POST['PrepaidCard']);
            if ($model->validate()) {
                for ($i = 1; $i <= $model->num; $i++) {
                    $card = PrepaidCard::generateCardInfo();
                    Yii::app()->db->createCommand()->insert('{{prepaid_card}}', array(
                        'status' => PrepaidCard::STATUS_UNUSED,
                        'create_time' => time(),
                        'author_id' => $this->getUser()->id,
                        'author_name' => $this->getUser()->name,
                        'author_ip' => Tool::ip2int($this->clientIp()),
                        'value' => $model->unit == PrepaidCard::UNIT_THOUSAND ? $model->value * 1000 : $model->value,
                        'number' => $card['number'],
                        'password' => $card['password'],
                        'type' => PrepaidCard::TYPE_SPECIAL,
                        'money' => $model->money,
                        'is_recon' => PrepaidCard::RECON_NO,
                        'owner_id' => $model->owner_id ? $model->owner_id : '',
                        'version' => $model->version
                    ));
                }

                @SystemLog::record(Yii::app()->user->name . "添加充值卡：" . 'money->' . $model->money);
                $this->setFlash('success', Yii::t('prepaidCard', '添加充值卡成功'));
                $this->redirect(array('admin'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 充值卡列表
     */
    public function actionAdmin() {
        $this->showExport = true;
        $this->exportAction = 'adminExport';
        $model = new PrepaidCard('search');
        $model->unsetAttributes();
        $model->flag = PrepaidCard::TYPE_SPECIAL;
        if (isset($_GET['PrepaidCard']))
            $model->attributes = $_GET['PrepaidCard'];

        $totalCount = $model->search()->getTotalItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = '/prepaidCard/adminExport';
        $exportPage->params = array_merge(array('exportType' => 'Excel5', 'grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;

        $this->render('admin', compact('model', 'exportPage', 'totalCount'));
    }

    // 充值卡列表导出excel
    public function actionAdminExport() {
        $model = new PrepaidCard('search');
        $model->unsetAttributes();
        $model->flag = PrepaidCard::TYPE_SPECIAL;
        if (isset($_GET['PrepaidCard']))
            $model->attributes = $_GET['PrepaidCard'];

        @SystemLog::record(Yii::app()->user->name . "导出充值卡列表");

        $model->isExport = 1;
        $this->render('adminexport', array(
            'model' => $model,
        ));
    }

    /**
     * 充值卡使用记录
     */
    public function actionList() {
        $this->showExport = true;
        $this->exportAction = 'listExport';
        $model = new PrepaidCard('search');
        $model->unsetAttributes();
        $model->used = true;
        $model->flag = PrepaidCard::TYPE_SPECIAL;
        if (isset($_GET['PrepaidCard']))
            $model->attributes = $_GET['PrepaidCard'];

        $totalCount = $model->search()->getTotalItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = '/prepaidCard/listExport';
        $exportPage->params = array_merge(array('exportType' => 'Excel5', 'grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;

        $this->render('list', compact('model', 'exportPage', 'totalCount'));
    }

    // 充值卡使用记录导出excel
    public function actionListExport() {
        $model = new PrepaidCard('search');
        $model->unsetAttributes();
        $model->used = true;
        $model->flag = PrepaidCard::TYPE_SPECIAL;
        if (isset($_GET['PrepaidCard']))
            $model->attributes = $_GET['PrepaidCard'];

        @SystemLog::record(Yii::app()->user->name . "导出充值卡使用记录列表");

        $model->isExport = 1;
        $this->render('listexport', array(
            'model' => $model,
        ));
    }

    /**
     * 积分返还充值卡列表
     */
    public function actionIndex() {
        $model = new PrepaidCard('search');
        $model->unsetAttributes();
        $model->flag = PrepaidCard::TYPE_GENERAL;
        if (isset($_GET['PrepaidCard']))
            $model->attributes = $_GET['PrepaidCard'];
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * 批量对账
     */
    public function actionRecon() {
        if ($this->isAjax()) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $_POST['selectRec']);
            PrepaidCard::model()->updateAll(array('is_recon' => PrepaidCard::RECON_YES), $criteria);
            @SystemLog::record(Yii::app()->user->name . "充值卡批量对账：id|" . implode(',', $_POST['selectRec']));
            echo CJSON::encode(array('success' => true));
        } else
            throw new CHttpException(400, Yii::t('prepaidCard', '无效的操作，请不要重复操作！'));
    }

    /**
     * 积分返还充值卡使用记录
     */
    public function actionDetail() {
        $this->showExport = true;
        $this->exportAction = 'detailExport';
        $model = new PrepaidCard('search');
        $model->unsetAttributes();
        $model->flag = PrepaidCard::TYPE_GENERAL;
        $model->used = true;
        if (isset($_GET['PrepaidCard']))
            $model->attributes = $_GET['PrepaidCard'];

        $totalCount = $model->search()->getTotalItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = '/prepaidCard/detailExport';
        $exportPage->params = array_merge(array('exportType' => 'Excel5', 'grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;

        $this->render('detail', compact('model', 'exportPage', 'totalCount'));
    }

    // 积分返还充值卡导出excel
    public function actionDetailExport() {
        $model = new PrepaidCard('search');
        $model->unsetAttributes();
        $model->flag = PrepaidCard::TYPE_GENERAL;
        $model->used = true;
        if (isset($_GET['PrepaidCard']))
            $model->attributes = $_GET['PrepaidCard'];

        @SystemLog::record(Yii::app()->user->name . "导出积分返还充值卡列表");

        $model->isExport = 1;
        $this->render('detailexport', array(
            'model' => $model,
        ));
    }

    /**
     * 异步计算积分及金额
     */
    public function actionConvert() {
        if ($this->isAjax()) {
            $unit = $this->getPost('unit');
            $value = $this->getPost('value');
            $money = $this->getPost('money');
            if (is_numeric($value) || is_numeric($money)) {
                $result = array();
                $type = MemberType::fileCache();
                if ($unit == PrepaidCard::UNIT_THOUSAND) {
                    $result['unit'] = PrepaidCard::UNIT_THOUSAND;
                    $result['value'] = $value;
                    $res = sprintf("%.2f", $value * 1000 * $type['official']);
                } elseif ($unit == PrepaidCard::UNIT_ONE) {
                    $result['unit'] = PrepaidCard::UNIT_ONE;
                    $result['value'] = $value;
                    $res = sprintf("%.2f", $value * $type['official']);
                }
                $result['money'] = strpos($res, '.00') ? intval($res) : $res;
                echo CJSON::encode($result);
            }
        }
    }

    /**
     * 异步计算积分
     */
    public function actionGetScore() {
        if ($this->isAjax() && is_numeric($this->getPost('money'))) {
            $money = $this->getPost('money');
            $type = MemberType::fileCache();
            echo sprintf("%.2f", $money / $type['official']);
        }
    }

    /**
     * 异步计算金额
     */
    public function actionGetMoney() {
        if ($this->isAjax()) {
            $value = $this->getPost('value');
            $unit = $this->getPost('unit');
            $type = MemberType::fileCache();
            if (is_numeric($unit)) {
                if ($unit == PrepaidCard::UNIT_ONE)
                    $money = sprintf("%.2f", $value * $type['official']);
                elseif ($unit == PrepaidCard::UNIT_THOUSAND)
                    $money = sprintf("%.2f", $value * 1000 * $type['official']);
            } else
                $money = sprintf("%.2f", $value * $type['official']);
            $money = strpos($money, '.00') ? intval($money) : $money;
            echo $money;
        }
    }

    /**
     * 批发充值卡
     */
    public function actionBatch() {
        @ini_set('memory_limit', '2048M');
        set_time_limit(0);
        $max_number = 501;
        $this->breadcrumbs = array(Yii::t('importReache', '充值兑换管理 '), Yii::t('importReache', '批量生成充值卡'));
        $model = new UploadForm('batch');
        $this->performAjaxValidation($model);
        $result = array();
        if (isset($_POST['UploadForm'])) {
            $this->checkPostRequest(); //检查重复提交
            $model->attributes = $_POST['UploadForm'];
            //获取文件名称
            $fileName = $_FILES['UploadForm']['name']['file'];
            $model->file = $fileName;

            if ($model->validate()) {
                //获取文件临时地址
                $filePath = $_FILES['UploadForm']['tmp_name']['file'];

                //引入phpExcel
                require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel/Shared/String.php';
                require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel.php';
                Yii::import('comext.phpexcel.*');
                Yii::registerAutoloader(array('PHPExcel_Autoloader', 'Register'), true);

                $excel = PHPExcel_IOFactory::load($filePath);
                $excel->setActiveSheetIndex(0);
                $objWorksheet = $excel->getActiveSheet();
                $highestRow = $objWorksheet->getHighestRow(); // 取得总行数

                if ($highestRow <= 1) {
                    $this->setFlash('error', '导入的数据不能为空白，请重新导入');
                    $this->refresh();
                    exit();
                } else if ($highestRow > $max_number) {
                    $this->setFlash('error', '每次导入不能超过500条！');
                    $this->refresh();
                    exit();
                }

                $highestColumn1 = array('mobile', 'money', 'lot_num');
                $excelData1 = array(); //excel 数据
                for ($row1 = 1; $row1 <= $highestRow; $row1++) {
                    foreach ($highestColumn1 as $k => $v) {
                        $value1 = $objWorksheet->getCellByColumnAndRow($k, $row1)->getValue();
                        $excelData1[$row1 - 1][$v] = is_object($value1) ? $value1->getPlainText() : $value1;
                    }
                }

                //判断第一行的列名是否为指定的列名，不是则提示错误
                if ($excelData1[0]['mobile'] !== '手机号码' && $excelData1[0]['money'] !== '积分' && $excelData1[0]['lot_num'] !== '批号') {
                    $this->setFlash('error', '导入的数据有误，请重新导入');
                    $this->refresh();
                    exit();
                }
                

                //获取execl表数据,从第二行开始获取，第一行为列名不进行获取
                $highestColumn = array('mobile', 'money', 'lot_num');
                $excelData = array(); //excel 数据
                for ($row = 2; $row <= $highestRow; $row++) {
                    foreach ($highestColumn as $k => $v) {
                        $value = $objWorksheet->getCellByColumnAndRow($k, $row)->getValue();
                        $excelData[$row - 2][$v] = is_object($value) ? $value->getPlainText() : $value;
                    }
                }             
                

                $data = array(); //存贮结果数据
                $success_count = 0; //成功笔数
                $fail_count = 0; //失败笔数
                $total_money = 0; //成功总积分
                $num = 0; //序号
                $memberType = MemberType::fileCache();
                $smsData = array();  //存贮需要发送的短信数据

                $transaction = Yii::app()->db->beginTransaction();
                try {
                    //增加最大id判断，同一批次可以导入相同的手机号
                    $maxId = Yii::app()->db->createCommand()->select('MAX(id) AS `maxId`')->from('{{prepaid_card_batch_record}}')->queryScalar();
                    foreach ($excelData as $k => $v) {
                        $v['mobile'] = trim($v['mobile']);
                        $v['money'] = trim($v['money']);
                        $v['lot_num'] = trim($v['lot_num']);

                        //当手机号码和积分为空的时候，跳过
                        if (empty($v['mobile']) && empty($v['money']) && empty($v['lot_num'])) {
                            continue;
                        }       
                        
                        //判断批号是否为正整数
                        if(!is_numeric($v['lot_num']) || $v['lot_num'] < 0) {
                            $this->setFlash('error', '导入的批号数据有非正整数，请修改为正整数再进行导入！');
                            $this->refresh();
                            continue;
                        }
                        
                        //判断手机号码格式是否正确
                        if (preg_match('/(^1[34578]{1}\d{9}$)|(^852\d{8}$)/', $v['mobile'])) {                                                    
                            
                            //增加最大id判断，同一批次可以导入相同的手机号
                            $datas = Yii::app()->db->createCommand()->select('batch_number')->from('{{prepaid_card_batch_record}}')->where('id<=:maxId AND batch_number=:num', array(':num' => $v['lot_num'], ':maxId' => $maxId))->queryRow();

                            if ($datas['batch_number']) {
                                $this->setFlash('error', '请不要重复进行导入，该批号已经导入，如有未生成的，请下载该批次的生成记录进行查看!');
                                $this->refresh();
                                continue;
                            }

                            if ($v['money'] < 0) {
                                $fail_count++;
                                $num++;
                                $data[$k] = $v;
                                $data[$k]['num'] = $num;
                                $data[$k]['card_num'] = '';
                                $data[$k]['time'] = $model->apply_time;
                                $data[$k]['error'] = '失败：积分为负数,无法生成';
                            } else if (!is_numeric((int) $v['money'])) {
                                $fail_count++;
                                $num++;
                                $data[$k] = $v;
                                $data[$k]['num'] = $num;
                                $data[$k]['card_num'] = '';
                                $data[$k]['time'] = $model->apply_time;
                                $data[$k]['error'] = '失败：积分不是数值，无法生成';
                            } else if (empty($v['money'])) {
                                $fail_count++;
                                $num++;
                                $data[$k] = $v;
                                $data[$k]['money'] = '';
                                $data[$k]['num'] = $num;
                                $data[$k]['card_num'] = '';
                                $data[$k]['time'] = $model->apply_time;
                                $data[$k]['error'] = '失败：积分为空';
                            } else if (strlen(intval($v['money'])) > 8) {
                                $fail_count++;
                                $num++;
                                $data[$k] = $v;
                                $data[$k]['money'] = '';
                                $data[$k]['num'] = $num;
                                $data[$k]['card_num'] = '';
                                $data[$k]['time'] = $model->apply_time;
                                $data[$k]['error'] = '失败：积分超出限定';
                            } else {
                                
                                //添加充值卡
                                $card = PrepaidCard::generateCardInfo();                                
                                Yii::app()->db->createCommand()->insert('{{prepaid_card}}', array(
                                    'status' => PrepaidCard::STATUS_UNUSED,
                                    'create_time' => time(),
                                    'author_id' => $this->getUser()->id,
                                    'author_name' => $this->getUser()->name,
                                    'author_ip' => Tool::ip2int($this->clientIp()),
                                    'value' => $v['money'],
                                    'number' => $card['number'],
                                    'password' => $card['password'],
                                    'type' => PrepaidCard::TYPE_SPECIAL,
                                    'money' => sprintf("%.2f", $v['money'] * $memberType['official']),
                                    'is_recon' => PrepaidCard::RECON_NO,
                                    'owner_id' => 0,
                                    'version' => 1.0,
                                ));
                                //检查充值卡是否生成成功
                                $card_info = Yii::app()->db->createCommand()
                                        ->select('id,number,password,value,type,create_time')
                                        ->from('{{prepaid_card}}')
                                        ->where('id=:id', array(":id" => Yii::app()->db->lastInsertID))
                                        ->queryRow();
                                if (empty($card_info)) {
                                    throw new Exception('create prepaied card error');
                                }
                                
                                //添加批量生成记录
                                Yii::app()->db->createCommand()->insert('{{prepaid_card_batch_record}}', array(
                                    'mobile' => $v['mobile'], //手机号码
                                    'money' => $v['money'],
                                    'apply_time' => strtotime($model->apply_time),
                                    'batch_number' => $v['lot_num'],
                                    'card_number' => $card['number'],
                                    'author_id' => $this->getUser()->id,
                                    'author_name' => $this->getUser()->name,
                                    'author_ip' => Tool::ip2int($this->clientIp()),
                                    'create_time' => time()
                                ));

                                $success_count++;
                                $total_money += $v['money'];
                                
                                $smsData[] = array(
                                    'card_info' => $card_info,
                                    'mobile' => $v['mobile'],
                                    'apply_time' => strtotime($model->apply_time)
                                );

                                $num++;
                                $data[$k] = $v;
                                $data[$k]['num'] = $num;
                                $data[$k]['card_num'] = $card['number'];
                                $data[$k]['time'] = $model->apply_time;
                                $data[$k]['error'] = '成功';
                            }
                        } else {
                            $fail_count++;
                            $num++;
                            $data[$k] = $v;
                            $data[$k]['num'] = $num;
                            $data[$k]['card_num'] = '';
                            $data[$k]['time'] = $model->apply_time;
                            $data[$k]['error'] = '失败：手机号码格式不正确';
                        }
                    }

                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    $this->setFlash('error', '生成失败！');
                }
                
                //发送短信
                foreach($smsData as $arr) {
                    PrepaidCardUse::createPrepaidCard($arr['card_info'], $arr['mobile'],$arr['apply_time'], true);
                }
                
                $total_money = sprintf('%.2f', $total_money);
                @SystemLog::record(Yii::app()->user->name . "批量导入生成充值卡，成功{$success_count}个，失败{$fail_count}个，总生成积分：{$total_money}");
                $this->render('batchresult', array('data' => $data, 'total_money' => $total_money, 'success_count' => $success_count, 'fail_count' => $fail_count));
                exit();
            }
        }
        $this->render('batchlist', array('model' => $model));
    }

    /**
     * 批发充值卡记录
     */
    public function actionHistoryBatch()
    {
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        $criteria->group = 'batch_number';
        if($this->getQuery('bnum') || $this->getQuery('bnum') == '0')
            $criteria->addCondition('batch_number = '.$this->getQuery('bnum').'');
        $count = PrepaidCardBatchRecord::model()->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 10; //条数
        $pager->applyLimit($criteria);
        $exchangeInfo = PrepaidCardBatchRecord::model()->findAll($criteria);
        $this->render('historybatch', array('pages' => $pager, 'data' => $exchangeInfo));
    }
    
    //下载生成记录
    public function actionHistoryDownLoad($num) {

        $data = Yii::app()->db->createCommand()
                ->select('*')->from('{{prepaid_card_batch_record}}')
                ->where('batch_number=:num', array(':num' => $num))
                ->queryAll();
        if ($data) {
            //引入phpExcel
            require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel/Shared/String.php';
            require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel.php';
            Yii::registerAutoloader(array('PHPExcel_Autoloader', 'Register'), true);
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', '序号')
                    ->setCellValue('B1', '手机号码')
                    ->setCellValue('C1', '积分')
                    ->setCellValue('D1', '充值卡号码')
                    ->setCellValue('E1', '申请时间')
                    ->setCellValue('F1', '批号');
                    
 
            $i = 2;
            foreach ($data as $k => $v) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $i, $k + 1)
                        ->setCellValue('B' . $i, $v['mobile'])
                        ->setCellValue('C' . $i, $v['money'])
                        ->setCellValue('D' . $i, $v['card_number'])
                        ->setCellValue('E' . $i, date('Y-m-d', $v['apply_time']))
                        ->setCellValue('F' . $i, $v['batch_number']);
                $i++;
            }
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $ua = $_SERVER["HTTP_USER_AGENT"];
            $filename = '批发充值卡记录_'.$data[0]['batch_number'].'.xls';
            $encoded_filename = urlencode($filename);
            $encoded_filename = str_replace("+", "%20", $encoded_filename);
            header('Content-Type: application/octet-stream');
            if (preg_match("/MSIE/", $ua)) {  
            header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
            } else if (preg_match("/Firefox/", $ua)) {  
            header('Content-Disposition: attachment; filename*="utf8\'\'' . $filename . '"');
            } else {  
            header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
            }
            $objWriter->save('php://output');
            @SystemLog::record(Yii::app()->user->name . "下载批发充值卡记录");
            unset($data, $objPHPExcel, $objWriter);
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
                $modelName = CHtml::modelName(PrepaidCard::model());
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

    /**
     * 导出批发充值卡的结果
     */
    public function actionPrepaidCardExport() {
        if (isset($_POST['data'])) {
            $data = unserialize($_POST['data']);
            $date = date('YmdHms', time());
//            $file_name = urlencode($date . '-批发充值卡结果');
            //引入phpExcel
            require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel/Shared/String.php';
            require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel.php';
            Yii::registerAutoloader(array('PHPExcel_Autoloader', 'Register'), true);
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', '序号')
                    ->setCellValue('B1', '手机号码')
                    ->setCellValue('C1', '积分')
                    ->setCellValue('D1', '充值卡号码')
                    ->setCellValue('E1', '申请时间')
                    ->setCellValue('F1', '结果');
            $i = 2;
            foreach ($data as $k => $v) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $i, $k + 1)
                        ->setCellValue('B' . $i, $v['mobile'])
                        ->setCellValue('C' . $i, $v['money'])
                        ->setCellValue('D' . $i, $v['card_num'])
                        ->setCellValue('E' . $i, $v['time'])
                        ->setCellValue('F' . $i, $v['error']);
                $i++;
            }
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $ua = $_SERVER["HTTP_USER_AGENT"];
            $filename = $date . '-批发充值卡结果.xls';
            $encoded_filename = urlencode($filename);
            $encoded_filename = str_replace("+", "%20", $encoded_filename);
            header('Content-Type: application/octet-stream');
            if (preg_match("/MSIE/", $ua)) {  
            header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
            } else if (preg_match("/Firefox/", $ua)) {  
            header('Content-Disposition: attachment; filename*="utf8\'\'' . $filename . '"');
            } else {  
            header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
            }
            $objWriter->save('php://output');
            @SystemLog::record(Yii::app()->user->name . "导出批发充值卡结果");
            unset($data, $objPHPExcel, $objWriter);
        }
    }

    //下载execl
    public function actionDownLoadExecl() {
        $date = date('YmdHms', time());
//        $file_name = urlencode($date . '-生成充值卡数据');
        //引入phpExcel
        require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel/Shared/String.php';
        require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel.php';
        Yii::registerAutoloader(array('PHPExcel_Autoloader', 'Register'), true);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->createSheet();
        $objPHPExcel->getActiveSheet()
                ->setCellValue('A1', '手机号码')
                ->setCellValue('B1', '积分')
                ->setCellValue('C1', '批号');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $ua = $_SERVER["HTTP_USER_AGENT"];
        $filename = $date . '-生成充值卡数据.xls';
        $encoded_filename = urlencode($filename);
        $encoded_filename = str_replace("+", "%20", $encoded_filename);
        header('Content-Type: application/octet-stream');
        if (preg_match("/MSIE/", $ua)) {  
        header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
        } else if (preg_match("/Firefox/", $ua)) {  
        header('Content-Disposition: attachment; filename*="utf8\'\'' . $filename . '"');
        } else {  
        header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
        }
        $objWriter->save('php://output');
        @SystemLog::record(Yii::app()->user->name . "下载充值卡生成数据");
        unset($objPHPExcel, $objWriter);
    }   
}
