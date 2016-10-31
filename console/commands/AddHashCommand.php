<?php

/**
 *
 *  添加金额hash
 * @author zhenjun.xu
 */
class AddHashCommand extends CConsoleCommand
{


    public function actionIndex()
    {
        set_time_limit(0);

        //old
        $dataReader = Yii::app()->db->createCommand('SELECT * FROM ' . ACCOUNT . '.gw_account_balance_history')->query();
        // 重复调用 read() 直到它返回 false
        while (($account = $dataReader->read()) !== false) {
            $salt = md5(uniqid());
            $data = array($account['gai_number'], $account['account_id'], $account['today_amount'], $salt, AMOUNT_SIGN_KEY);
            $hash = sha1(implode('', $data));
            $sql = 'UPDATE ' . ACCOUNT . '.' . "{{account_balance_history}}" . ' SET amount_salt="' . $salt . '",amount_hash="' . $hash . '" WHERE id =' . $account['id'];
            Yii::app()->db->createCommand($sql)->execute();
            echo $account['id'], "\r\n";
        }

        //new
        $dataReader = Yii::app()->db->createCommand('SELECT * FROM ' . ACCOUNT . '.gw_account_balance')->query();
        // 重复调用 read() 直到它返回 false
        while (($account = $dataReader->read()) !== false) {
            $salt = md5(uniqid());
            $data = array($account['gai_number'], $account['account_id'], $account['today_amount'], $salt, AMOUNT_SIGN_KEY);
            $hash = sha1(implode('', $data));
            $sql = 'UPDATE ' . ACCOUNT . '.' . "{{account_balance}}" . ' SET amount_salt="' . $salt . '",amount_hash="' . $hash . '" WHERE id =' . $account['id'];
            Yii::app()->db->createCommand($sql)->execute();
            echo $account['id'], "\r\n";
        }
    }


    /**
     * 检查是否有异常账户
     */
    public function actionCheck()
    {
        set_time_limit(0);

        //old
        $dataReader = Yii::app()->db->createCommand('SELECT * FROM ' . ACCOUNT . '.gw_account_balance_history')->query();
        // 重复调用 read() 直到它返回 false
        while (($account = $dataReader->read()) !== false) {
            $data = array($account['gai_number'], $account['account_id'], $account['today_amount'], $account['amount_salt'], AMOUNT_SIGN_KEY);
            $hash = sha1(implode('', $data));
            if ($hash != $account['amount_hash']) {
                echo $account['id'], ',', $account['gai_number'], ",old error\r\n";
            }
        }

        //new
        $dataReader = Yii::app()->db->createCommand('SELECT * FROM ' . ACCOUNT . '.gw_account_balance')->query();
        // 重复调用 read() 直到它返回 false
        while (($account = $dataReader->read()) !== false) {
            $data = array($account['gai_number'], $account['account_id'], $account['today_amount'], $account['amount_salt'], AMOUNT_SIGN_KEY);
            $hash = sha1(implode('', $data));
            if ($hash != $account['amount_hash']) {
                echo $account['id'], ',', $account['gai_number'], ",new error\r\n";
            }
        }
    }


}

?>
