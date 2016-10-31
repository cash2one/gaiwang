<?php

/**
 * 自动检测网签状态、超过37天没有对纸质资质合同审核完毕的，自动关闭店铺
 * @author zhenjun.xu
 */
class CheckStoreCommand extends CConsoleCommand {


    public function actionDo() {
        $db = Yii::app()->db;
        //查找正在试用中的网店
        $sql = 'SELECT
                s.id,
                s.name,
                member_id,
                m.enterprise_id
            FROM
                gw_store AS s
            LEFT JOIN gw_member AS m ON m.id = s.member_id
            LEFT JOIN gw_enterprise as e ON e.id=m.enterprise_id
            WHERE
                s.status =:status and e.signing_type=:st and s.update_time < :time';
        $params = array(
            ':status'=>Store::STATUS_ON_TRIAL,
            ':st'=>Enterprise::SIGNING_TYPE_SERVICE_FEE,//服务费形式签约的商户
            ':time'=>time()-3600*24*37,//超过37天没有对纸质资质合同审核完毕的，自动关闭店铺
        );
        $data = $db->createCommand($sql)->bindValues($params)->queryAll();
        if(!empty($data)){
            //关闭店铺
            foreach($data as $v){
                $trans = $db->beginTransaction();
                try{
                    $sql = 'UPDATE gw_store SET status=:status WHERE id=:id';
                    $db->createCommand($sql)->bindValues(array(':status' => Store::STATUS_CLOSE, ':id' => $v['id']))->execute();
                    //保存当前记录
                    $ent_log = new EnterpriseLog();
                    $ent_log->status = EnterpriseLog::STATUS_NOT_PASS;
                    $ent_log->progress = EnterpriseLog::PROCESS_CLOSE_STORE;
                    $ent_log->content = EnterpriseLog::getProcess($ent_log->progress);
                    $ent_log->auditor = '系统';
                    $ent_log->enterprise_id = $v['enterprise_id'];
                    $ent_log->create_time = time();
                    $ent_log->save(false);
                    //商品下架
                    Goods::model()->updateAll(array('is_publish'=>Goods::PUBLISH_NO),'store_id=:id',array(':id'=>$v['id']));
                    $trans->commit();
                    echo 'close  store ok';
                }catch (Exception $e){
                    $trans->rollback();
                    echo 'close store error';
                }
            }
        }else{
            echo 'store null';
        }

    }



}

?>
