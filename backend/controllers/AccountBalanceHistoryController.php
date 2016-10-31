<?php

/**
 * 历史余额控制器 
 * 操作 (列表)
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class AccountBalanceHistoryController extends Controller {

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
        return 'admin,checkHash,resetHash';
    }

    public function actionAdmin() {
        $model = new AccountBalanceHistory('search');
        $model->unsetAttributes();
        if (isset($_GET['AccountBalanceHistory']))
            $model->attributes = $this->getParam('AccountBalanceHistory');

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 检查hash是否正确
     * @param $id
     */
    public function actionCheckHash($id){

        $account = $this->loadModel($id);
        $data = array($account['gai_number'], $account['account_id'], $account['today_amount'], $account['amount_salt'], AMOUNT_SIGN_KEY);
        $hash = sha1(implode('', $data));
        if ($hash != $account['amount_hash']) {
            $msg = array('icon'=>'error','content'=>'校验失败','lock'=>true);
        }else{
            $msg = array('icon'=>'succeed','content'=>'校验成功','lock'=>true);
        }
        echo json_encode($msg);
    }

    /**
     * 重置hash
     */
    public function actionResetHash(){
        $account = $this->loadModel($this->getPost('id'));
        $salt = md5(uniqid());
        $data = array($account['gai_number'], $account['account_id'], $account['today_amount'], $salt, AMOUNT_SIGN_KEY);
        $hash = sha1(implode('', $data));
        $sql = 'UPDATE ' . ACCOUNT . '.' . "{{account_balance_history}}" . ' SET amount_salt="' . $salt . '",amount_hash="' . $hash . '" WHERE id =' . $account['id'];
        Yii::app()->db->createCommand($sql)->execute();
        @SystemLog::record($this->getUser()->name . "重设hash old：" . $account['id']);
        $msg = array('icon'=>'succeed','content'=>'重置成功','lock'=>true);
        echo json_encode($msg);
    }

}
