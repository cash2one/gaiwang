<?php

/**
 * 首次上线，将店铺推荐改为三级居间商
 * @author zhenjun_xu <412530435@qq.com>
 * Date: 2016/4/5
 * Time: 13:26
 */
class AddMiddleAgentCommand extends CConsoleCommand
{
    public function actionIndex()
    {
        $db = Yii::app()->db;
        $data = $db->createCommand("SELECT
                            id,
                            referrals_id,
                            member_id,
                            create_time
                        FROM
                            gw_store
                        WHERE
                            referrals_id > 0 AND (status=:p OR status=:t)")
            ->bindValues(array(':p' => Store::STATUS_PASS, ':t' => Store::STATUS_ON_TRIAL))->queryAll();

        foreach ($data as $v) {
            //直招商户
            $db->createCommand()->insert('gw_middle_agent', array(
                'parent_id' => 0, //未知
                'store_id' => $v['id'],
                'member_id' => $v['member_id'],
                'level' => MiddleAgent::LEVEL_PARTNER,
                'create_time' => $v['create_time']
            ));
            echo '0:',$v['id'],"\n\r";
        }
        //三级居间商
        $ref = Yii::app()->db->createCommand('
               SELECT DISTINCT
                    s.referrals_id,
                    s2.id,
                    s2.create_time
                FROM
                    gw_store AS s
                LEFT JOIN gw_store AS s2 ON s.referrals_id = s2.member_id
                WHERE
                    (s.`status` = :p OR s.`status` = :t)
                AND s.referrals_id > 0
                ')->bindValues(array(':p' => Store::STATUS_PASS, ':t' => Store::STATUS_ON_TRIAL))->queryAll();
        foreach ($ref as $v) {
            $db->createCommand()->insert('gw_middle_agent', array(
                'parent_id' => 0,
                'store_id' => $v['id'] > 0 ? $v['id'] : 0, //可能没有店铺
                'member_id' => $v['referrals_id'],
                'level' => MiddleAgent::LEVEL_THREE,
                'create_time' => $v['create_time'] ? $v['create_time'] : 0,
            ));
            //更新店铺状态
            if($v['id']){
                Yii::app()->db->createCommand()->update('gw_store',array('is_middleman'=>Store::STORE_ISMIDDLEMAN_YES,),'id='.$v['id']);
            }
            echo '2:',$v['id'],"\n\r";
        }
        //设置居间关系
        $relation = $db->createCommand(
            'SELECT
                m.id,
                a.id as pid
            FROM
                gw_middle_agent AS m
            LEFT JOIN gw_store AS s ON s.id = m.store_id
            LEFT JOIN gw_middle_agent AS a ON a.member_id = s.referrals_id
            WHERE
                m.`level` = 0'
        )->queryAll();
        foreach ($relation as $v){
            $db->createCommand()->update('gw_middle_agent',array('parent_id'=>$v['pid']),'id='.$v['id']);
            echo '3:',$v['id'],"\n\r";
        }
        //去掉推荐链、自己推荐自己、互为推荐
        exit('done');
        $group = $db->createCommand('
                        SELECT
                            *, count(member_id) AS c
                        FROM
                            gw_middle_agent
                        GROUP BY
                            member_id
                        HAVING
                            c > 1
                        ORDER BY
                            c DESC;
        ')->queryAll();
        foreach ($group as $v){
            $db->createCommand()->delete('gw_middle_agent','member_id=:mid and level=:l',
                array(':mid'=>$v['member_id'],':l'=>MiddleAgent::LEVEL_PARTNER));
            echo '4:',$v['id'],"\n\r";
        }
        echo 'done';
    }

}