<?php

/**
 * excel 导入会员
 *
 * @author zhenjun_xu <412530435@qq.com>
 */
class ImportMemberController extends Controller
{

    /**
     * 获取excel数据，先写import_member_log，再member开户，再 import_member_cash 充值
     */
    public function actionIndex()
    {
        @ini_set('memory_limit', '2048M');
        set_time_limit(0);
        $this->breadcrumbs = array(Yii::t('member', '会员管理 '), Yii::t('member', '导入会员'));
        $model = new UploadForm('excel');
        $this->performAjaxValidation($model);
        $result = array(); //import_member_log excel 数据插入结果
        if (isset($_POST['UploadForm'])) {
            $model->attributes = $_POST['UploadForm'];
            $dir = dirname(Yii::getPathOfAlias('cache'));
            $fileName = $_FILES['UploadForm']['name']['file'];
            if(!preg_match('/^\d{4}-\d{2}-\d{2}-\d{2}$/',pathinfo($fileName,PATHINFO_FILENAME)) || substr($fileName,0,10)!=date('Y-m-d')){
                $this->setFlash('error', '该文件格式不正确，请重命名！，例如：2014-05-11-04');
                $this->refresh();
            }
            if(file_exists($dir.'/import_member/'.$fileName)){
                $this->setFlash('error', '该文件已经被上传过了，请重命名！');
                $this->refresh();
            }

            $model = UploadedFile::uploadFile($model, 'file', 'import_member',$dir, pathinfo($fileName,PATHINFO_FILENAME));
            if ($model->validate()) {
                UploadedFile::saveFile('file', $model->file);
                //引入phpExcel
                require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel/Shared/String.php';
                require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel.php';
                Yii::registerAutoloader(array('PHPExcel_Autoloader', 'Register'), true);
                $excel = PHPExcel_IOFactory::load($dir . '/' . $model->file);
                $excel->setActiveSheetIndex(0);
                $objWorksheet = $excel->getActiveSheet();
                $highestRow = $objWorksheet->getHighestRow(); // 取得总行数
                $highestColumn = array('gai_number', 'username', 'password', 'cash', 'mobile', 'type');
                $excelData = array(); //excel 数据
                for ($row = 2; $row <= $highestRow; $row++) {
                    foreach ($highestColumn as $k => $v) {
                        $value = $objWorksheet->getCellByColumnAndRow($k, $row)->getValue();
                        $excelData[$row - 2][$v] = is_object($value) ? $value->getPlainText() : $value;
                    }
                }
                $importLog = 'INSERT INTO `{{import_member_log}}` (`user_id`, `type`, `file`, `status`, `data`,`create_time`,`mark`) VALUES ';
                foreach ($excelData as $v) {
                    $flag = false;
                    foreach ($v as $v2) {
                        if (!empty($v2)) $flag = true;
                    }
                    //整条数据不是所有都为空，则插入,默认插入状态为成功，后面如果有操作失败，则更新之
                    if ($flag) {
                        $importLog .= "('{$this->getUser()->id}', '{$v['type']}', '{$model->file}', '0', '" . json_encode($v) . "',UNIX_TIMESTAMP(),''),";
                    }
                }
                $importLog = substr($importLog, 0, strlen($importLog) - 1) . ';';
                try {
                    Yii::app()->db->createCommand($importLog)->execute();
                } catch (Exception $e) {
                    $this->setFlash('error', 'excel数据格式错误');
                }
                $sql = 'select id,data from {{import_member_log}} where file=:file';
                $importData = Yii::app()->db->createCommand($sql)->bindValue(':file', $model->file)->queryAll();
                if ($importData) {
                    foreach ($importData as $v) {
                        $memberData = json_decode($v['data'], true);
                        $this->_insertMember($memberData, $v['id']);
                    }
                    $result = Yii::app()->db->createCommand()->from('{{import_member_log}}')->where('file=:file', array(':file' => $model->file))->queryAll();
                }
                @SystemLog::record(Yii::app()->user->name . "导入会员 成功");
            } else {
            	@SystemLog::record(Yii::app()->user->name . "导入会员上传文件失败");
                $this->setFlash('error', '上传文件失败');
            }
        }

        $this->render('index', array('model' => $model, 'result' => $result));
    }

    /**
     *
     * @param array $data
     * @param $id
     */
    private function _insertMember(Array $data, $id)
    {
        $check = $this->_checkMember($data);
        if (!empty($check)) {
            Yii::app()->db->createCommand()->update('{{import_member_log}}', array('status' => 1, 'mark' => $check),
                'id=:id', array(':id' => $id));
        } else {
            if ($data['type'] != self::TYPE_CASH) {
                //开户
                $salt = Tool::generateSalt();
                $defaultVal = MemberType::fileCache();
                $trans = Yii::app()->db->beginTransaction();
                try {
                	$psw = CPasswordHelper::hashPassword($data['password'] . $salt);
                    Yii::app()->db->createCommand()->insert('{{member}}', array(
                        'gai_number' => $data['gai_number'],
                        'username' => $data['username'],
                        'password' => $psw,
                        'salt' => $salt,
                        'mobile' => $data['mobile'],
                        'type_id' => $defaultVal['defaultType'],
                        'register_time' => time(),
                        'role'=>Member::ROLE_KW,
                    ));
                    
                    $cash = $data['type'] == self::TYPE_REGISTER_CASH ? $data['cash'] : 0.00;
                    $lastInsertId = Yii::app()->db->lastInsertID;
                    //充值
                    Yii::app()->db->createCommand()->insert('{{import_member}}', array(
                        'gai_number' => $data['gai_number'],
                        'member_id' => $lastInsertId,
                        'cash' => $cash,
                        'update_time' => time(),
                    ));
                    
                    
                	//加入短信队列
                    if (!empty($data['mobile']) && !empty($_POST['smg'])){
                    	$msg_content = "欢迎您成为盖网通的会员，您的用户名是：{$data['username']}，会员编码是：{$data['gai_number']}，密码是：{$data['password']}，派发红包余额是{$cash}元";
                                    $datas = array($data['username'],$data['gai_number'],$data['password'],$cash);
                                    $tmpId = $this->getConfig('smsmodel','machineRedMoneyId');
                        SmsLog::addSmsLog($data['mobile'],$msg_content,0,  SmsLog::TYPE_OTHER,null,true,$datas , $tmpId);
                    }
                    
                    $trans->commit();
                } catch (Exception $e) {
                    $trans->rollback();
                    Yii::app()->db->createCommand()->update('{{import_member_log}}', array('status' => 1, 'mark' => $e->getMessage()),
                        'id=:id', array(':id' => $id));
                }
            } else {
                //充值
                $trans = Yii::app()->db->beginTransaction();
                try {
                    $sql = "UPDATE `{{import_member}}` SET `cash`= `cash`+ :cash WHERE (`gai_number`=:gw)";
                    Yii::app()->db->createCommand($sql)->bindValues(array(':cash' => $data['cash'], ':gw' => $data['gai_number']))->execute();
                    $trans->commit();
                } catch (Exception $e) {
                    $trans->rollback();
                    Yii::app()->db->createCommand()->update('{{import_member_log}}', array('status' => 1, 'mark' => $e->getMessage()),
                        'id=:id', array(':id' => $id));
                }
            }
        }
    }

    /**
     * 操作类型
     */
    const TYPE_REGISTER = 1; //开户
    const TYPE_CASH = 2; //充值
    const TYPE_REGISTER_CASH = 3; //开户并充值

    /**
     * 检查数据的合法性
     * @param array $data
     * @return string
     */
    private function _checkMember(array $data)
    {
        $msg = '';
        if (!preg_match('/^GW03\d{8}$/', $data['gai_number'])) {
            $msg = '盖网通编号格式不正确';
        }
        if (empty($msg) && $data['type'] != self::TYPE_CASH && Member::model()->exists('gai_number=:gw', array(':gw' => $data['gai_number']))) {
            $msg = '盖网通编号已经存在';
        }
        if (empty($msg) && $data['type'] == self::TYPE_CASH && !Member::model()->exists('gai_number=:gw', array(':gw' => $data['gai_number']))) {
            $msg = '盖网通编号不存在';
        }
        if (empty($msg) && !preg_match('/^[\x{4e00}-\x{9fa5}A-Za-z0-9_\(\)（）]+$/u', $data['username'])) {
            $msg = '用户名格式不正确';
        }
        if (empty($msg) && $data['type'] != self::TYPE_CASH && (strlen($data['username']) < 3 || strlen($data['username']) > 128)) {
            $msg = '用户名长度不正确';
        }
        if (empty($msg) && $data['type'] != self::TYPE_CASH && Member::model()->exists('username=:username', array(':username' => $data['username']))) {
            $msg = '用户名已经存在';
        }
        if (empty($msg) && $data['type'] != self::TYPE_CASH && (strlen($data['password']) < 3 || strlen($data['password']) > 128)) {
            $msg = '密码长度不正确';
        }
        if (empty($msg) && $data['type'] != self::TYPE_REGISTER && !preg_match('/^\d+(\.\d{2})$/', $data['cash'])) {
            $msg = '金额格式不正确';
        }
        if (empty($msg) && $data['type'] != self::TYPE_CASH && !preg_match('/(^\d{11}$)|(^852\d{8}$)/', $data['mobile'])) {
            $msg = '手机号码格式不正确';
        }
        if (empty($msg) && $data['type'] != self::TYPE_CASH && Member::model()->exists('mobile=:m', array(':m' => $data['mobile']))) {
            $msg = '手机号码已经存在';
        }
        if (empty($msg) && !in_array($data['type'], array(self::TYPE_CASH, self::TYPE_REGISTER, self::TYPE_REGISTER_CASH))) {
            $msg = '操作类型不正确';
        }
        return $msg;
    }

    /**
     * 导出excel
     * @param string $file
     */
    public function actionExport($file)
    {
        $data = Yii::app()->db->createCommand()->from('{{import_member_log}}')->where('file=:file', array(':file' => $file))->queryAll();
        //引入phpExcel
        require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel/Shared/String.php';
        require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel.php';
        Yii::registerAutoloader(array('PHPExcel_Autoloader', 'Register'), true);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '序号')
            ->setCellValue('B1', '盖网通编号')
            ->setCellValue('C1', '用户名')
            ->setCellValue('D1', '密码')
            ->setCellValue('E1', '金额')
            ->setCellValue('F1', '手机号')
            ->setCellValue('G1', '操作类型')
            ->setCellValue('H1', '状态')
            ->setCellValue('I1', '备注');
        $i = 2;
        foreach ($data as $k => $v) {
            $member = json_decode($v['data'], true);
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $k + 1)
                ->setCellValue('B' . $i, $member['gai_number'])
                ->setCellValue('C' . $i, $member['username'])
                ->setCellValue('D' . $i, $member['password'])
                ->setCellValue('E' . $i, $member['cash'])
                ->setCellValue('F' . $i, $member['mobile'])
                ->setCellValue('G' . $i, $member['type'])
                ->setCellValue('H' . $i, $v['status'] == 0 ? '成功' : '失败')
                ->setCellValue('I' . $i, $v['mark']);
            $i++;
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="excel导入执行结果.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        @SystemLog::record(Yii::app()->user->name . "导出会员成功");
        unset($data, $objPHPExcel, $objWriter);


    }

} 