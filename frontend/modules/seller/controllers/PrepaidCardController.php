<?php

/**
 * 充值卡控制器
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class PrepaidCardController extends SController {

    public $layout = 'seller';

    private $_storeId;

    public function beforeAction($action) {
        $this->_storeId = $this->getSession('storeId');
        return parent::beforeAction($action);
    }

    //充值卡详情
    public function actionView($id) {
        $model = $this->_loadModel($id);
        $model->setScenario('sale');
        if (isset($_POST['PrepaidCard'])) {
            $model->attributes = $this->getPost('PrepaidCard');
            if ($model->save())
                $this->redirect(array('index'));
        }
        $this->render('view', array(
            'model' => $model
        ));
    }
    
    //充值卡列表
    public function actionindex() {
        $model = new PrepaidCard('searchList');
        $model->unsetAttributes();
        $model->owner_id = $this->getUser()->id;
        if (isset($_GET['PrepaidCard']))
            $model->attributes = $this->getQuery('PrepaidCard');
        $cards = $model->searchList();       
        $totalCounts = $model->searchList()->getTotalItemCount();
        $exportPages = new CPagination($totalCounts);
        $exportPages->route = '/prepaidCard/prepaidExport';
        $exportPages->params = array_merge(array('exportType' => 'Excel5', 'grid_mode' => 'export'), $_GET);
        $exportPages->pageSize = $model->exportLimit;
        $this->render('index', array(
            'model' => $model,
            'cards' => $cards,
            'exportPages' => $exportPages,
            'totalCounts' => $totalCounts
        ));
    }
    
    // 充值卡列表导出excel
    public function actionPrepaidExport() {
        $model = new PrepaidCard('searchList');        
        $model->unsetAttributes();
        $model->owner_id = $this->getUser()->id;
        if (isset($_GET['PrepaidCard']))
            $model->attributes = $this->getQuery('PrepaidCard');
        
        $model->isExport = 1;
        $this->render('prepaidexport', array(
            'model' => $model,
        ));
    }
    
    //商家后台充值
    public function actionViewRechange($id) {
        $model = $this->_loadModel($id);        
        if(!empty($_POST['mobile'])) {
            $this->checkPostRequest();//检测重复提交
            $memberType = MemberType::fileCache();//会员类型
            $gaiNum = !empty($_POST['sel']) ? $_POST['sel'] : $_POST['num'];//GW账号
            $mobile = $this->getPost('mobile');//手机号码
            //会员信息
            $member = Yii::app()->db->createCommand()
                    ->select('id,gai_number,mobile,type_id')
                    ->from('{{member}}')
                    ->where('gai_number=:m', array(':m' => $gaiNum))
                    ->queryRow();
            
            //添加充值记录
            Yii::app()->db->createCommand()->insert('{{import_recharge_record}}', array(
                'gai_number' => $gaiNum, //GW号码
                'mobile' => $mobile, //手机号码
                'code' => 0, //加密串
                'money' => sprintf("%.2f", $model->value * $memberType['official']), //转换积分为金额
                'money_before' => AccountBalance::getAccountAllBalance($gaiNum, AccountBalance::TYPE_CONSUME),
                'money_after' => AccountBalance::getAccountAllBalance($gaiNum, AccountBalance::TYPE_CONSUME) + sprintf("%.2f", $model->value * $memberType['official']),
                'status' => ImportRechargeRecord::STATUS,
                'detail' => '',
                'create_time' => time(),
                'member_id' => $member['id'],
            ));
            
            //充值卡信息
            $card_info = array(
                'id' => $model->id,
                'number' => $model->number,
                'value' => $model->value,
                'type' => $model->type
            );                        
            
            //充值成功后发送短信
            PrepaidCardUse::recharge($card_info, $member, $memberType, true, true, null, false);
            
            //更新充值导入记录
            Yii::app()->db->createCommand()->update('{{import_recharge_record}}', array('status' => 1, 'detail' => '充值成功'), 'gai_number=:m', array(':m' => $gaiNum));

            $this->setFlash('success', Yii::t('prepaidCard', '充值成功'));
            $this->redirect(array('index'));
        } else {
            $this->redirect(array('index'));
        }
    }

    private function _loadModel($id) {
        $model = PrepaidCard::model()->findByPk(intval($id), 'owner_id=:ownerId', array(
            ':ownerId' => $this->getUser()->id
        ));
        if ($model === null)
            throw new CHttpException('404', '请求的页页面不存在');
        return $model;
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
}
