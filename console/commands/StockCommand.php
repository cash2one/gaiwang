<?php

/**
 * 库存还原脚本
 *
 * 只查找未支付的订单，已支付的订单支付时自动减库存
 *
 * @author csj leo8705
 */
class StockCommand extends CConsoleCommand {

    public function actionReturnStock() {
        @ini_set('memory_limit','1280M');

        //查找最新的一条stock_log
        $criteria=new CDbCriteria;
        $criteria->select = 'order_id,code,status,create_time';
        $criteria->compare('status', 1);
        $criteria->order = 'create_time DESC';
        $newest_stock_log = StockLog::model()->find($criteria);
        //如果没有数据，则使用前十天的时间
        $start_time = empty($newest_stock_log) ? time()-3600*24*10 : $newest_stock_log->create_time;

        //只查找未支付的订单，已支付的订单自动减库存
        $order_config = Tool::getConfig('order');
        $return_time = time()-$order_config['stock_time'];
        
        $sql = 'SELECT
                    og.goods_id,
                    og.spec_id,
                    og.quantity,
                    o.id,
                    o.code,
                    o.create_time
                FROM
                    gw_order_goods AS og
                LEFT JOIN gw_order AS o ON og.order_id = o.id
                WHERE
                 o.status=:status
                 AND o.pay_status=:pay_status
                 AND o.create_time >=:start_time
                 AND o.create_time <=:end_time';
        $bindValues = array(
            ':status'=>Order::STATUS_NEW,
            ':pay_status'=>Order::PAY_STATUS_NO,
            ':start_time'=>$start_time,
            ':end_time'=>$return_time,
        );
        $orders = Yii::app()->db->createCommand($sql)->bindValues($bindValues)->queryAll();

        if (empty($orders)) exit(date('Y-m-d H:i:s').' No unReturn Stock Order'."\n");

        //不确定根据时间判断是否一定准确，再做一次查询判断
        $order_ids = array();
        $codes = array();
        foreach ($orders as $order){
            $order_ids[] = $order['id'];
            $codes[] = $order['code'];
        }
        $check_log = StockLog::model()->findAll(array(
            'select'=>'order_id',
            'condition'=>'order_id IN ('.implode(',', $order_ids).')',
        ));
        $check_log_arr = array();
        if (!empty($check_log)){
            foreach ($check_log as $log){
                $check_log_arr[] = $log->order_id;
            }
        }
        //归还库存逻辑
        $sql = '';
        $stock_log = array();
        foreach($orders as $v){
            if(in_array($v['id'],$check_log_arr)) continue; //已处理过的跳出
            //增加库存sql
            $sql .= "UPDATE gw_goods SET stock=stock+{$v['quantity']} WHERE id={$v['goods_id']};";
            $sql .= "UPDATE gw_goods_spec SET stock=stock+{$v['quantity']} WHERE id={$v['spec_id']};";
            $stock_log[$v['id']] = array(
                'order_id'=>$v['id'],
                'code'=>$v['code'],
                'create_time'=>time(),
                'status'=>1,
                'details'=>'',
            );
            echo date('Y-m-d H:i:s').' update order:'.$v['code']."\n";
        }

        if(!empty($sql)){
            $trans = Yii::app()->db->beginTransaction();
            try{
                foreach($stock_log as $k => $v){
                    Yii::app()->db->createCommand()->insert('{{stock_log}}', $v);
                }
                Yii::app()->db->createCommand($sql)->execute();
                $trans->commit();
            }catch (Exception $e){
                $trans->rollback();
            }
        }else{
            exit(date('Y-m-d H:i:s').' update sql null'."\n");
        }
        exit(date('Y-m-d H:i:s').' finish'."\n");
    }

    /**
     * 获取后台配置的常用参数数据
     * @param string $name  文件名称，例如site.config.inc,$name = 'site'
     * @param string $key 该配置项的键名
     * @return string
     */
    public function getConfig($name, $key = null) {        
        return Tool::getConfig($name,$key = null);
//        $file = Yii::getPathOfAlias('common') . DS . 'webConfig' . DS . $name . '.config.inc';
//        if (!file_exists($file)) {
//            return array();
//        }
//        $content = file_get_contents($file);
//        $array = unserialize(base64_decode($content));
//        return $key ? (isset($array[$key]) ? $array[$key] : '') : $array;
    }


}
