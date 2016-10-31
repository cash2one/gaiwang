<?php
/**
 * Created by PhpStorm.
 * User: Gatewang
 * Date: 2015/9/21
 * Time: 16:32
 */


class BulkAddCommand extends CConsoleCommand
{

//    批量添加手机话费流量消费功能权限方法
    public function  actionAdd()
    {
        set_time_limit(0);
        $sql = "SELECT id FROM gaitong.gt_machine";
        $ids = Yii::app()->db->createCommand($sql)->queryAll();
        $i = 0;
        $count = count ( $ids);

        // 先清空特约商户绑定的优惠券
        $db = Yii::app ()->db;
        $actionType = 'convenientService/mobileAdd';
        // 开启事务
        $transaction = $db->beginTransaction ();
        $sql = "INSERT INTO gaitong.gt_machine_forbbiden (machine_id,action_type) VALUES ";
        $size = 1000;// 每size条数据拼接一条sql
        $resultdb = 0;// 受影响的行数
        foreach ( $ids as $k => $v ) {

            if ($i < $size) {
                $sql .= "(" . $v['id'] . ",'" . $actionType."'),";
            } elseif ($i == $size) {
                $sql .= "(" . $v['id'] . ",'"  . $actionType ."')";
                $resultdb += $db->createCommand ( $sql )->execute ();
            } else {
                $i = 0;
                $sql = "INSERT INTO gaitong.gt_machine_forbbiden (machine_id,action_type) VALUES (" . $v['id'] . ",'" . $actionType ."'),";
            }
            // 最后不足size条的数据
            if ($k == $count - 1) {
                $sql = substr ( $sql, 0, strlen ( $sql ) - 1 );
                $resultdb += $db->createCommand ( $sql )->execute ();
            }
            $i ++;
        }
        $transaction = $transaction->commit ();
    }
    //    批量删除手机话费流量消费功能权限方法
    public  function  actionDel(){
        set_time_limit(0);
        $actionType = 'convenientService/mobileAdd';
        $sql ="DELETE FROM gaitong.gt_machine_forbbiden WHERE action_type = '".$actionType."'";

        $db = Yii::app ()->db;
        $db->createCommand ( $sql )->execute ();
    }
}