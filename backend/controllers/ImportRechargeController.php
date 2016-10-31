<?php

/**
 * excel 充值会员余额
 *
 * @author csj
 */
class ImportRechargeController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 不作权限控制的action
     * @author LC
     * @return string
     */
    public function allowedActions() {
        return 'findGW';
    }

    /**
     * 批量充值
     */
    public function actionIndex() {
        @ini_set('memory_limit', '2048M');
        set_time_limit(0);

        $model = new ImportRechargeRecord('required');
        $modelArr = array();
        $data = array();

        for ($i = 0; $i < 19; $i++) {
            $modelArr[$i] = new ImportRechargeRecord('notrequired');
        }

        $this->performAjaxValidationTabular($model, $modelArr, array('money', 'mobile'));
        $memberType = MemberType::fileCache();

        $success_count = 0;
        $total_money = 0;
        if (isset($_POST['ImportRechargeRecord']['arr'])) {

            $this->checkPostRequest();  //检查重复提交
            $rechargePost = $this->getPost('ImportRechargeRecord');

            //存储表单数据
            $rechargeArr = array();
            $rechargeArr[] = array(
                'money' => $rechargePost['money'],
                'mobile' => $rechargePost['mobile'],
                'gai_number' => !empty($_POST['sel']) ? $_POST['sel'] : $rechargePost['gai_number'],
            );

            foreach ($rechargePost['arr'] as $k => $v) {
                if (!empty($v['money']) && !empty($v['mobile'])) {
                    $rechargeArr[] = array(
                        'money' => $v['money'],
                        'mobile' => $v['mobile'],
                        'gai_number' => !empty($v['num']) ? $v['num'] : $rechargePost['gaiNumber']
                    );
                } else if (empty($v['money']) && !empty($v['mobile'])) {
                    $rechargeArr[] = array(
                        'money' => '',
                        'mobile' => $v['mobile'],
                        'gai_number' => !empty($v['num']) ? $v['num'] : $rechargePost['gaiNumber']
                    );
                } else if (!empty($v['money']) && empty($v['mobile'])) {
                    $rechargeArr[] = array(
                        'money' => $v['money'],
                        'mobile' => '',
                        'gai_number' => '',
                    );
                }
            }
//            Tool::pr($rechargeArr);

            $sendsArr = array();
            foreach ($rechargeArr as $k => $v) {
                $mobile = Member::model()->exists('mobile=:m', array(':m' => $v['mobile']));
                if ($mobile) {
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        if (!empty($v['money']) && !empty($v['mobile'])) {
                            $member = Yii::app()->db->createCommand()
                                    ->select('id,gai_number,mobile,type_id')
                                    ->from('{{member}}')
                                    ->where('gai_number=:m', array(':m' => $v['gai_number']))
                                    ->queryRow();

                            Yii::app()->db->createCommand()->insert('{{import_recharge_record}}', array(
                                'gai_number' => $v['gai_number'], //GW号码
                                'mobile' => $v['mobile'], //手机号码
                                'code' => 0, //加密串
                                'money' => sprintf("%.2f", $v['money'] * $memberType['official']), //转换积分为金额
                                'money_before' => AccountBalance::getAccountAllBalance($v['gai_number'], AccountBalance::TYPE_CONSUME),
                                'money_after' => AccountBalance::getAccountAllBalance($v['gai_number'], AccountBalance::TYPE_CONSUME) + sprintf("%.2f", $v['money'] * $memberType['official']),
                                'status' => ImportRechargeRecord::STATUS,
                                'detail' => '',
                                'create_time' => time(),
                                'member_id' => $member['id'],
                            ));

                            //生成充值卡
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
                                    ->select('id,number,value,type')
                                    ->from('{{prepaid_card}}')
                                    ->where('id=:id', array(":id" => Yii::app()->db->lastInsertID))
                                    ->queryRow();
                            if (empty($card_info)) {
                                throw new Exception('create prepaied card error');
                            }

                            //存储短信数据
                            $sendsArr[] = array(
                                'card_info' => $card_info,
                                'member' => $member,
                                'memberType' => $memberType,
                            );

                            //总充值账号和积分
                            $success_count++;
                            $total_money = $total_money + $v['money'];

                            $data[$k] = $v;
                            $data[$k]['gaiNumber'] = $v['gai_number'];
                            $data[$k]['error'] = '成功';

                            //更新充值导入记录
                            Yii::app()->db->createCommand()->update('{{import_recharge_record}}', array('status' => 1, 'detail' => '充值成功'), 'gai_number=:m', array(':m' => $v['gai_number']));
                        } else if (empty($v['money'])) {
                            $data[$k] = $v;
                            $data[$k]['gaiNumber'] = $v['gai_number'];
                            $data[$k]['error'] = '失败：积分不能为空';
                        } else if (empty($v['mobile'])) {
                            $data[$k] = $v;
                            $data[$k]['gaiNumber'] = '';
                            $data[$k]['error'] = '失败：手机号码和GW号码不能为空';
                        }
                        $transaction->commit();
                    } catch (Exception $e) {
                        $transaction->rollback();
                        $this->setFlash('error', '充值失败！');
                    }
                } else {
                    $data[$k] = $v;
                    $data[$k]['gaiNumber'] = '';
                    $data[$k]['error'] = '失败：手机号码不存在';
                }
            }
            //发送短信
            foreach ($sendsArr as $arr) {
                PrepaidCardUse::recharge($arr['card_info'], $arr['member'], $arr['memberType'], true, true, null, true);
            }

            @SystemLog::record(Yii::app()->user->name . "批量导入充值，共充值{$success_count}个 账号，总充值积分：{$total_money}");
            $this->render('createresult', array('data' => $data));
            exit();
        }
        $this->render('createtxt', array(
            'model' => $model,
            'modelArr' => $modelArr,
        ));
    }

    //导入充值
    public function actionImportRecharge() {
        @ini_set('memory_limit', '2048M');
        set_time_limit(0);
        $max_number = 501;
        $this->breadcrumbs = array(Yii::t('importReache', '充值兑换管理 '), Yii::t('importReache', '导入充值'));
        $model = new UploadForm('excel');
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

                //设置是否发送短信
                $smg = $this->getPost('smg');
                $smg = $smg == 1 ? true : false;
                //编辑短信
                $sms = $this->getPost('sms');

                //存贮execl数据为一个数组
                $list_arr = array();
                foreach ($excelData as $v) {
                    $list_arr[] = trim($v['mobile']);
                }

                //查询出手机号对应的数据
                $list_cri = new CDbCriteria();
                $list_cri->select = 'id,gai_number,mobile,type_id';
                $list_cri->addInCondition('mobile', $list_arr);
                $members = Member::model()->findAll($list_cri);

                $member_format = array();
                foreach ($members as $m) {
                    $member_format[$m['mobile']] = $m;
                }

                //会员类型
                $memberType = MemberType::fileCache();
                if ($memberType === null) {
                    throw new Exception('memberType error');
                }


                $data = array(); //存贮结果数据
                $success_count = 0; //成功笔数
                $fail_count = 0; //失败笔数
                $total_money = 0; //成功总积分
                $num = 0; //序号

                $transaction = Yii::app()->db->beginTransaction();
                try {
                	//增加最大id判断，同一批次可以导入相同的手机号 @authot lc
                	$maxId = Yii::app()->db->createCommand()->select('MAX(id) AS `maxId`')->from('{{import_recharge_record}}')->queryScalar();
                    foreach ($excelData as $k => $v) {
                        $v['mobile'] = trim($v['mobile']);
                        $v['money'] = trim($v['money']) * 1;
                        $v['lot_num'] = trim($v['lot_num']);
//                    var_dump(is_numeric((int)$v['money']));die;
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

                        //验证手机号码是否存在
                        $mobile = Member::model()->exists('mobile=:m', array(':m' => $v['mobile']));
                        //查询GW账号总数
                        $m = Yii::app()->db->createCommand()
                                ->select('gai_number')
                                ->from('{{member}}')
                                ->where('mobile=:m', array(':m' => $v['mobile']))
                                ->queryAll();

                        if ($mobile) {
                            //验证批号是否已经使用过
                        	//增加最大id判断，同一批次可以导入相同的手机号 @authot lc
                            $datas = Yii::app()->db->createCommand()->select('batch_number')->from('{{import_recharge_record}}')->where('id<=:maxId AND batch_number=:num', array(':num' => $v['lot_num'], ':maxId'=>$maxId))->queryRow();

                            if ($datas['batch_number']) {
                                $this->setFlash('error', '请不要重复进行充值，该批号已经导入，如有未充值的，请下载该批次的充值记录进行查看!');
                                $this->refresh();
                                continue;
                            }
                            //当手机号有多个GW号码时，不进行处理显示充值失败
                            else if (count($m) > 1) {
                                $fail_count++;
                                $num++;
                                $data[$k] = $v;
                                $data[$k]['num'] = $num;
                                $data[$k]['card_num'] = '';
                                $data[$k]['time'] = date('Y-m-d H:i:s', time());
                                $data[$k]['gw_num'] = '';
                                $data[$k]['error'] = '失败';
                            } else if ($v['money'] < 0) {
                                $fail_count++;
                                $num++;
                                $data[$k] = $v;
                                $data[$k]['num'] = $num;
                                $data[$k]['card_num'] = '';
                                $data[$k]['time'] = date('Y-m-d H:i:s', time());
                                $data[$k]['gw_num'] = $member_format[$v['mobile']]['gai_number'];
                                $data[$k]['error'] = '失败：积分为负数,无法充值';
                            } else if (!is_numeric((int) $v['money'])) {
                                $fail_count++;
                                $num++;
                                $data[$k] = $v;
                                $data[$k]['num'] = $num;
                                $data[$k]['card_num'] = '';
                                $data[$k]['time'] = date('Y-m-d H:i:s', time());
                                $data[$k]['gw_num'] = $member_format[$v['mobile']]['gai_number'];
                                $data[$k]['error'] = '失败：积分不是数值，无法充值';
                            } else if (empty($v['money'])) {
                                $fail_count++;
                                $num++;
                                $data[$k] = $v;
                                $data[$k]['money'] = '';
                                $data[$k]['num'] = $num;
                                $data[$k]['card_num'] = '';
                                $data[$k]['time'] = date('Y-m-d H:i:s', time());
                                $data[$k]['gw_num'] = $member_format[$v['mobile']]['gai_number'];
                                $data[$k]['error'] = '失败：积分为空';
                            } else {

                                //生成充值卡
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

                                $card_cri = new CDbCriteria();
                                $card_cri->select = 'id,number,value,type';
                                $card_cri->compare('id', Yii::app()->db->lastInsertID);
                                $card_info = PrepaidCard::model()->find($card_cri);
                                if (empty($card_info)) {
                                    throw new Exception('create prepaied card error');
                                }

                                Yii::app()->db->createCommand()->insert('{{import_recharge_record}}', array(
                                    'gai_number' => $member_format[$v['mobile']]['gai_number'], //GW号码
                                    'mobile' => $v['mobile'], //手机号码
                                    'code' => 0, //加密串
                                    'money' => sprintf("%.2f", $v['money'] * $memberType['official']), //转换积分为金额
                                    'money_before' => AccountBalance::getAccountAllBalance($member_format[$v['mobile']]['gai_number'], AccountBalance::TYPE_CONSUME),
                                    'money_after' => AccountBalance::getAccountAllBalance($member_format[$v['mobile']]['gai_number'], AccountBalance::TYPE_CONSUME) + sprintf("%.2f", $v['money'] * $memberType['official']),
                                    'status' => ImportRechargeRecord::STATUS,
                                    'detail' => '',
                                    'create_time' => time(),
                                    'member_id' => $member_format[$v['mobile']]['id'],
                                    'batch_number' => $v['lot_num'],
                                    'record_status' => ImportRechargeRecord::RECORD_STATUS_NO,
                                    'card_number' => $card_info['number'],
                                    'send_sms' => $smg,
                                    'free_sms' => $sms
                                ));

                                $success_count++;
                                $total_money += $v['money'];

                                $num++;
                                $data[$k] = $v;
                                $data[$k]['num'] = $num;
                                $data[$k]['card_num'] = $card_info['number'];
                                $data[$k]['time'] = date('Y-m-d H:i:s', time());
                                $data[$k]['gw_num'] = $member_format[$v['mobile']]['gai_number'];
                                $data[$k]['error'] = '成功';
                            }
                        } else {
                            $fail_count++;
                            $num++;
                            $data[$k] = $v;
                            $data[$k]['num'] = $num;
                            $data[$k]['card_num'] = '';
                            $data[$k]['time'] = date('Y-m-d H:i:s', time());
                            $data[$k]['gw_num'] = '';
                            $data[$k]['error'] = '失败：手机号码不存在';
                        }
                    }
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    $this->setFlash('error', '充值失败！');
                }

                @SystemLog::record(Yii::app()->user->name . "批量导入充值，共充值{$success_count}个 账号，失败{$fail_count}个账号，总充值积分：{$total_money}");
                $this->render('importresult', array('data' => $data, 'total_money' => $total_money, 'success_count' => $success_count, 'fail_count' => $fail_count));
                exit();
            }
        }

        $this->render('import', array('model' => $model, 'result' => $result));
    }

    //导出数据结果
    public function actionImportExport() {
        if (isset($_POST['data'])) {
            $data = unserialize($_POST['data']);
            $date = date('YmdHms', time());
//            $file_name = urlencode($date . '-导出充值结果');
            //引入phpExcel
            require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel/Shared/String.php';
            require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel.php';
            Yii::registerAutoloader(array('PHPExcel_Autoloader', 'Register'), true);
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', '序号')
                    ->setCellValue('B1', '充值卡卡号')
                    ->setCellValue('C1', '充值金额')
                    ->setCellValue('D1', '充值电话号码')
                    ->setCellValue('E1', '充值时间')
                    ->setCellValue('F1', '充值人GW号码')
                    ->setCellValue('G1', '充值结果');
            $i = 2;
            foreach ($data as $k => $v) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $i, $k + 1)
                        ->setCellValue('B' . $i, $v['card_num'])
                        ->setCellValue('C' . $i, $v['money'])
                        ->setCellValue('D' . $i, $v['mobile'])
                        ->setCellValue('E' . $i, $v['time'])
                        ->setCellValue('F' . $i, $v['gw_num'])
                        ->setCellValue('G' . $i, $v['error']);
                $i++;
            }
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $ua = $_SERVER["HTTP_USER_AGENT"];
            $filename = $date . '-导出充值结果.xls';
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
            @SystemLog::record(Yii::app()->user->name . "导出充值数据结果");
            unset($data, $objPHPExcel, $objWriter);
        }
    }

    //下载execl
    public function actionDownLoadExecl() {
        $date = date('YmdHms', time());
//        $file_name = urlencode($date . '-充值数据');
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
        $filename = $date . '-充值数据.xls';
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
        @SystemLog::record(Yii::app()->user->name . "下载充值数据");
        unset($objPHPExcel, $objWriter);
    }

    //获取相关联GW号码
    public function actionFindGW($mobile) {
        if ($this->isAjax()) {
            //查询数据
            $data = Yii::app()->db->createCommand()
                    ->select('gai_number,id')
                    ->from('{{member}}')
                    ->where('mobile = :m', array(':m' => $mobile))
                    ->queryAll();
            exit(CJSON::encode($data));
        }
    }

    //充值记录数据
    public function actionHistoryRechange() {
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        $criteria->group = 'batch_number';
        if($this->getQuery('bnum') || $this->getQuery('bnum') == '0')
            $criteria->addCondition('batch_number = '.$this->getQuery('bnum').'');
        $count = ImportRechargeRecord::model()->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 10; //条数
        $pager->applyLimit($criteria);
        $exchangeInfo = ImportRechargeRecord::model()->findAll($criteria);
        $this->render('historyimport', array('pages' => $pager, 'data' => $exchangeInfo));
    }

    //下载充值记录
    public function actionHistoryDownLoad($num) {
        $memberType = MemberType::fileCache();
        $data = Yii::app()->db->createCommand()
                ->select('*')->from('{{import_recharge_record}}')
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
                    ->setCellValue('B1', '充值卡卡号')
                    ->setCellValue('C1', '充值金额')
                    ->setCellValue('D1', '充值电话号码')
                    ->setCellValue('E1', '充值时间')
                    ->setCellValue('F1', '充值人GW号码')
                    ->setCellValue('G1', '充值结果')
                    ->setCellValue('H1', '批号');
            $i = 2;
            foreach ($data as $k => $v) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $i, $k + 1)
                        ->setCellValue('B' . $i, $v['card_number'])
                        ->setCellValue('C' . $i, Common::convertSingle($v['money'], 2))
                        ->setCellValue('D' . $i, $v['mobile'])
                        ->setCellValue('E' . $i, date('Y-m-d H:i:s', $v['create_time']))
                        ->setCellValue('F' . $i, $v['gai_number'])
                        ->setCellValue('G' . $i, $v['record_status'] == ImportRechargeRecord::RECORD_STATUS_YES ? '已充值' : '未充值')
                        ->setCellValue('H' . $i, $v['batch_number']);
                $i++;
            }
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $ua = $_SERVER["HTTP_USER_AGENT"];
            $filename = '充值记录_'.$data[0]['batch_number'].'.xls';
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
            @SystemLog::record(Yii::app()->user->name . "下载充值记录");
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
                $modelName = CHtml::modelName(ImportRechargeRecord::model());
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

}
