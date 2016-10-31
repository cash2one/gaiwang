<?php

/**
 * 会员红包账户超过有效期30天,就归零
 * User: binbin.liao
 * Date: 2015/1/5
 * Time: 18:02
 */
class RedExpireCommand extends CConsoleCommand
{

    /**
     * 会员红包账户有效期到,清0操作
     * 任务执行时间:每分钟执行一次
     */
    public function actionRun()
    {
        $nowTime = time();
//        echo $nowTime;
        Yii::app()->db->createCommand()->update('{{member_account}}', array('money' => 0), 'valid_end <=:time AND money <> 0', array(':time' => $nowTime));
    }

    /**
     * 到了红包派发截止时间就把活动停止
     * 执行时间每天凌晨1点钟
     * @author binbin.liao
     */
    public function actionStopActivity()
    {
        $nowTime = strtotime(date("Y-m-d", time()));
        Yii::app()->db->createCommand()->update('{{activity}}', array('status' => Activity::STATUS_OFF), 'mode=:mode and valid_end <= :time', array(':mode'=>Activity::ACTIVITY_MODE_RED,':time' => $nowTime));
    }
}