<?php

/**
 * 网签控制器
 * @author zhenjun_xu <412530435@qq.com>
 */
class EnterpriseLogController extends MController {

    /**
     * 公用方法查询最后一条审核进度信息
     * @author zhangshengjie
     */
    private function _lastOne() {
        $c = new CDbCriteria();
        $c->select = 'id,content,status,create_time,progress';
        $c->condition = 'enterprise_id=' . $this->getSession('enterpriseId') . ' AND is_remarts=0';
        $enterpriseLog = EnterpriseLog::model()->findAll($c);

        //最后一条审核记录，非开店记录
        $enterprise = Enterprise::model()->find(array(
            'select' => 'last_log_id,service_id',
            'condition' => 'id=' . $this->getSession('enterpriseId'),
        ));
        $lastOne = array();
        foreach ($enterpriseLog as $v) {
            if ($v['id'] == $enterprise['last_log_id']) {
                $lastOne = $v;
                break;
            }
        }
        return $lastOne;
    }

    public function actionProcess() {
        $c = new CDbCriteria();
        $c->select = 'id,content,status,create_time,progress';
        $c->condition = 'enterprise_id=' . $this->getSession('enterpriseId') . ' AND is_remarts=0';
        $enterpriseLog = EnterpriseLog::model()->findAll($c);

        //最后一条审核记录，非开店记录
        $enterprise = Enterprise::model()->find(array(
            'select' => 'last_log_id,service_id,enterprise_type',
            'condition' => 'id=' . $this->getSession('enterpriseId'),
        ));
        $lastOne = array();
        foreach ($enterpriseLog as $v) {
            if ($v['id'] == $enterprise['last_log_id']) {
                $lastOne = $v;
                break;
            }
        }
        //如果还未有记录，则调整到网签页面
        if (!$enterpriseLog)
            $this->redirect(array('enterpriseLog/enterprise'));
        $this->pageTitle = Yii::t('member', '网签进度_') . $this->pageTitle;
        $keyreturn = EnterpriseLog::model()->findAllByAttributes(array('enterprise_id' => $this->getSession('enterpriseId'), 'is_key_return' => EnterpriseLog::IS_KEY_RETURN));

//        Tool::p($keyreturn[0]);exit;
        if (is_array($keyreturn) && !empty($keyreturn)) {
            $keyreturn = $keyreturn[0];
        } else {
            $keyreturn = FALSE;
        }
        $this->render('process', array(
            'enterpriseLog' => $enterpriseLog,
            'lastOne' => $lastOne,
            'enterprise' => $enterprise,
            'keyreturn' => $keyreturn,
        ));
    }

    /**
     * 网签公共操作部分
     * @param $enterprise
     * @param $enterpriseData
     * @param $store
     * @param $bankAccount
     * @throws CDbException
     */
    private function _publicDo($enterprise, $enterpriseData, $store, $bankAccount) {
        $enterpriseData->rules = array(
            array('cosmetics_image,food_image,jewelry_image,declaration_image,report_image', 'required'),
        );
        if (isset($_POST['ajax']) && $_POST['ajax'] == 'member-form') {
            $validate = json_decode(CActiveForm::validate($enterprise), true);
            $validate2 = json_decode(CActiveForm::validate($enterpriseData), true);
            $validate3 = json_decode(CActiveForm::validate($store), true);
            $validateAll = array_merge($validate, $validate2, $validate3);
            echo json_encode($validateAll);
            Yii::app()->end();
        }
        if (isset($_POST['Enterprise'])) {

            $trans = Yii::app()->db->beginTransaction();
            try {
                $enterpriseData->rules = array(); //清空前面添加的验证规则
                $enterprise->attributes = $this->getPost('Enterprise');
                $enterpriseData->attributes = $this->getPost('EnterpriseData');
                $bankAccount->attributes = $this->getPost('BankAccount');
                $bankAccount->member_id = $this->model->id;
                $enterpriseData->license_start_time = strtotime($enterpriseData->license_start_time);
                $enterpriseData->license_end_time = strtotime($enterpriseData->license_end_time);

                $store->attributes = $this->getPost('Store');
                $store->member_id = $this->model->id;
                if ($store->isNewRecord)
                    $store->mode = Store::MODE_NOT;

                if (!$bankAccount->save(false)) {
                    throw new Exception("update bankAccout error");
                }

                //保存店铺信息
                if (!$store->save()) {
                    Tool::pr($store->getErrors());
                    throw new Exception("save store error");
                }


                $this->model->username = $enterprise->name;
                if (!$this->model->save(false)) {
                    throw new Exception("update member error");
                }
                //进度记录
                Yii::app()->db->createCommand()->insert('{{enterprise_log}}', array(
                    'status' => EnterpriseLog::STATUS_PASS,
                    'content' => EnterpriseLog::getProcess(EnterpriseLog::PROCESS_ADD),
                    'auditor' => $enterprise->name,
                    'enterprise_id' => $enterprise->id,
                    'progress' => EnterpriseLog::PROCESS_ADD,
                    'create_time' => time(),
                ));

                //进度记录2
                Yii::app()->db->createCommand()->insert('{{enterprise_log}}', array(
                    'status' => EnterpriseLog::STATUS_NO,
                    'content' => EnterpriseLog::getProcess(EnterpriseLog::PROCESS_CHECK_INFO_ZHAOSHANG),
                    'auditor' => $enterprise->name,
                    'enterprise_id' => $enterprise->id,
                    'progress' => EnterpriseLog::PROCESS_CHECK_INFO_ZHAOSHANG,
                    'create_time' => time() + 1,
                ));


                $enterprise->last_log_id = Yii::app()->db->lastInsertID;
                if (!$enterprise->save()) {
                    throw new Exception("update enterprise error");
                }
                $enterpriseData->enterprise_id = $enterprise->id;
                if (!$enterpriseData->save()) {
                    throw new Exception("update enterpriseData error");
                }

                $trans->commit();
                $this->setFlash('success', Yii::t('member', '网签信息提交成功，请等待审核'));
                $this->redirect(array('enterpriseLog/process'));
            } catch (Exception $e) {
                $trans->rollback();
                $this->setFlash('error', Yii::t('member', '网签信息提交失败') . $e->getMessage());
            }
        }
    }

    /**
     * 企业会员网签
     */
    public function actionEnterprise() {
        $c = new CDbCriteria();
        $c->select = 'progress';
        $c->condition = 'enterprise_id=' . $this->getSession('enterpriseId');
        $c->order = 'create_time DESC';
        $enterpriseLog = EnterpriseLog::model()->find($c);
        //如果已经审核，则跳转到 网签进度页面
        if ($enterpriseLog && $enterpriseLog->progress >= EnterpriseLog::PROCESS_LAST_OK)
            $this->redirect(array('enterpriseLog/process'));
        $this->pageTitle = Yii::t('member', '企业网签_') . $this->pageTitle;
        $this->model->scenario = 'enterpriseLog';
        $enterpriseId = $this->getSession('enterpriseId');
        /** @var Enterprise $enterprise */
        $enterprise = Enterprise::model()->findByPk($enterpriseId);
        if (empty($enterprise)) {
            $enterprise = new Enterprise();
        }
        $enterprise->enterprise_type = Enterprise::TYPE_ENTERPRISE;
        $enterpriseData = $enterprise->enterpriseData;
        if (empty($enterpriseData))
            $enterpriseData = new EnterpriseData();
        $enterpriseData->scenario = 'enterpriseLog';
        $bankAccount = BankAccount::model()->findByAttributes(array('member_id' => $this->model->id));
        if (!$bankAccount)
            $bankAccount = new BankAccount();

        $store = Store::model()->findByAttributes(array('member_id' => $this->model->id));
        if (!$store)
            $store = new Store();
        $store->scenario = 'enterpriseLog';
        $store->status = Store::STATUS_APPLYING;
        $enterprise->scenario = 'enterpriseLog';

        $this->_publicDo($enterprise, $enterpriseData, $store, $bankAccount);
        $lastOne = $this->_lastOne();
        $this->render('enterprise', array(
            'lastOne' => $lastOne,
            'enterprise' => $enterprise,
            'enterpriseData' => $enterpriseData,
            'bankAccount' => $bankAccount,
            'store' => $store,
        ));
    }

    /**
     * 个体工商户网签
     * @throws CDbException
     */
    public function actionEnterprise2() {
        $c = new CDbCriteria();
        $c->select = 'progress';
        $c->condition = 'enterprise_id=' . $this->getSession('enterpriseId');
        $c->order = 'create_time DESC';
        $enterpriseLog = EnterpriseLog::model()->find($c);
        //如果已经审核，则跳转到 网签进度页面
        if ($enterpriseLog && $enterpriseLog->progress >= EnterpriseLog::PROCESS_LAST_OK)
            $this->redirect(array('enterpriseLog/process'));
        $this->pageTitle = Yii::t('member', '个体工商户网签_') . $this->pageTitle;
        $this->model->scenario = 'enterpriseLog';
        $enterpriseId = $this->getSession('enterpriseId');
        /** @var Enterprise $enterprise */
        $enterprise = Enterprise::model()->findByPk($enterpriseId);
        if (empty($enterprise))
            $enterprise = new Enterprise();
        $enterprise->enterprise_type = Enterprise::TYPE_INDIVIDUAL;
        $enterpriseData = $enterprise->enterpriseData;
        if (empty($enterpriseData))
            $enterpriseData = new EnterpriseData();
        $enterpriseData->scenario = 'enterpriseLog2';
        $bankAccount = BankAccount::model()->findByAttributes(array('member_id' => $this->model->id));
        if (!$bankAccount)
            $bankAccount = new BankAccount();
        $bankAccount->scenario = 'enterpriseLog2';

        $store = Store::model()->findByAttributes(array('member_id' => $this->model->id));
        if (!$store)
            $store = new Store();
        $store->scenario = 'enterpriseLog';
        $store->status = Store::STATUS_APPLYING;
        $enterprise->scenario = 'enterpriseLog';

        $this->_publicDo($enterprise, $enterpriseData, $store, $bankAccount);
        $lastOne = $this->_lastOne();

        $this->render('enterprise2', array(
            'enterprise' => $enterprise,
            'enterpriseData' => $enterpriseData,
            'bankAccount' => $bankAccount,
            'store' => $store,
            'lastOne' => $lastOne,
        ));
    }

    /**
     * 查看网签
     */
    public function actionView() {
        $this->pageTitle = Yii::t('member', '个体工商户网签_') . $this->pageTitle;
        $enterpriseId = $this->getSession('enterpriseId');
        $store = Store::model()->findByAttributes(array('member_id' => $this->model->id));
        $cat_cri = new CDbCriteria();
        $cat_cri->select = 'name';
        $cat_cri->addCondition("id=" . $store->category_id * 1);
        $cat = Category::model()->find($cat_cri);
        $enterprise = Enterprise::model()->findByPk($enterpriseId);
        $bankAccount = BankAccount::model()->findByAttributes(array('member_id' => $this->model->id));
        $this->renderPartial('view', array(
            'enterprise' => $enterprise,
            'bankAccount' => $bankAccount,
            'store' => $store,
            'cat' => $cat,
                ), false, true);
    }

    /**
     * 打印合同
     */
    public function actionPrint() {
        $this->pageTitle = Yii::t('member', '打印合同_') . $this->pageTitle;
        $store = Store::model()->findByAttributes(array('member_id' => $this->model->id));
        $this->render('print', array('store' => $store));
    }

    /**
     * 预览打印文件
     * @param $file
     * @throws CHttpException
     */
    public function actionPrintView($file) {
        if ($file != 'pic') {
            $content = Tool::getConfig($file, 'file');
        } else {
            $content = 'pic';
        }
        $pic = false;
        if (empty($content))
            throw new CHttpException(404);
        if (in_array($file, array('contractstore', 'contractstore2', 'pic'))) {
            $enterpriseId = $this->getSession('enterpriseId');
            /** @var Enterprise $enterprise */
            $enterprise = Enterprise::model()->findByPk($enterpriseId);
            $store = Store::model()->findByAttributes(array('member_id' => $this->getUser()->id));
            /** @var BankAccount $bankAccount */
            $bankAccount = BankAccount::model()->findByAttributes(array('member_id' => $this->model->id));
//            Tool::p($bankAccount);exit;
            /** @var EnterpriseData $enterpriseData */
            $enterpriseData = $enterprise->enterpriseData;
            if ($file != 'pic') {
                $content = strtr($content, array(
                    '{enterpriseName}' => $enterprise->name,
                    '{enterpriseType}' => Enterprise::getEnterpriseType($enterprise->enterprise_type),
                    '{linkMan}' => $enterprise->link_man,
                    '{mobile}' => $enterprise->mobile,
                    '{category}' => Category::getCategoryName($store->category_id),
                    'account' => $bankAccount->account_name,
                    'bankName' => $bankAccount->bank_name,
                    'bankAccount' => $bankAccount->account,
                    'provinceId' =>  Region::getName($bankAccount->province_id),
                    'cityId' => Region::getName($bankAccount->city_id),
                    'district' => Region::getName($bankAccount->district_id),
                ));
            } else {
                $content = '';
                $bankAccount->licence_image && $content .= CHtml::image(ATTR_DOMAIN . '/' . $bankAccount->licence_image);
                $enterpriseData->license_photo && $content .= CHtml::image(ATTR_DOMAIN . '/' . $enterpriseData->license_photo);
                $enterpriseData->cosmetics_image && $content .= CHtml::image(ATTR_DOMAIN . '/' . $enterpriseData->cosmetics_image);
                $enterpriseData->food_image && $content .= CHtml::image(ATTR_DOMAIN . '/' . $enterpriseData->food_image);
                $enterpriseData->jewelry_image && $content .= CHtml::image(ATTR_DOMAIN . '/' . $enterpriseData->jewelry_image);
                $enterpriseData->threec_image && $content .= CHtml::image(ATTR_DOMAIN . '/' . $enterpriseData->threec_image);
                $enterpriseData->brand_image && $content .= CHtml::image(ATTR_DOMAIN . '/' . $enterpriseData->brand_image);
                $enterpriseData->report_image && $content .= CHtml::image(ATTR_DOMAIN . '/' . $enterpriseData->report_image);
                $enterpriseData->declaration_image && $content .= CHtml::image(ATTR_DOMAIN . '/' . $enterpriseData->declaration_image);
                $enterpriseData->organization_image && $content .= CHtml::image(ATTR_DOMAIN . '/' . $enterpriseData->organization_image);
                $enterpriseData->identity_image && $content .= CHtml::image(ATTR_DOMAIN . '/' . $enterpriseData->identity_image);
                $enterpriseData->identity_image2 && $content .= CHtml::image(ATTR_DOMAIN . '/' . $enterpriseData->identity_image2);
                $enterpriseData->debit_card_image && $content .= CHtml::image(ATTR_DOMAIN . '/' . $enterpriseData->debit_card_image);
                $enterpriseData->debit_card_image2 && $content .= CHtml::image(ATTR_DOMAIN . '/' . $enterpriseData->debit_card_image2);
                $enterpriseData->tax_image && $content .= CHtml::image(ATTR_DOMAIN . '/' . $enterpriseData->tax_image);
                $pic = true;
            }
        }
        if (!$pic) {
            $content = str_replace('_baidu_page_break_tag_', '<div class="pageBreak"></div>', $content);
        }


        $this->renderPartial('_printView', array('content' => $content, 'pic' => $pic));
    }

}

