<?php

/*
 * 活动专题--后台统计任务脚本
 */

class SeckillCommand extends CConsoleCommand{

    //每小时运行一次  改变活动的状态
    public function actionUpdateStatus(){
		$time = time();
        //读取要更新的内容
		$sql = "SELECT rm.date_start,rm.date_end,rs.status,rs.start_time,rs.end_time,rs.id "
			   ."FROM {{seckill_rules_main}} rm, {{seckill_rules_seting}} rs "
			   ."WHERE rm.id=rs.rules_id";
		$command = Yii::app()->db->createCommand($sql);
		$result  = $command->queryAll();
//        $this->addLog('setting','running',$result);

		//生成sql更新状态 将状态2改为3/4  将状态3改为4
		$arr3 = $arr4 = array();
		if(!empty($result)){
		    foreach($result as $v){
				$start = strtotime($v['date_start'].' '.$v['start_time']);
				$end   = strtotime($v['date_end'].' '.$v['end_time']);
				if($v['status'] == 2 && $time >= $start && $time <= $end){//正在进行
					$arr3[] = $v['id'];
				}
                                //过期
                                if($v['status'] == 1 && $time > $end){
                                    $arr4[] = $v['id'];
                                }
                                
				//已过期
				if($v['status'] == 2 && $time > $end){
					$arr4[] = $v['id'];
				}
                                if($v['status'] == 4) {
                                    $arr4[] = $v['id']; 
                                }
				if($v['status'] == 3 && $time > $end){
					$arr4[] = $v['id'];
				}
			}
		}//end if
//        $this->addLog('setting','stopId',$arr4);

		if(!empty($arr3)){//将状态改为正在进行
		    $sql = "UPDATE {{seckill_rules_seting}} SET `status`=3 WHERE id IN(".implode(',', $arr3).")";
			$command = Yii::app()->db->createCommand($sql);
            $command->execute();
			Tool::cache(ActivityData::CACHE_ACTIVITY_CONFIG)->delete(ActivityData::CACHE_ACTIVITY_CONFIG);
		}

		if(!empty($arr4)){//将状态改为已结束
		    $sql = "UPDATE {{seckill_rules_seting}} SET `status`=4,`sort`=99999 WHERE id IN(".implode(',', $arr4).")";
			$command = Yii::app()->db->createCommand($sql);
            $command->execute();
			//清空商品表的参加活动字段
			$sql = "UPDATE {{goods}} SET `seckill_seting_id`=0 WHERE seckill_seting_id IN(".implode(',', $arr4).")";
			$command = Yii::app()->db->createCommand($sql);
            $command->execute();
			//清空必抢表对应的rules_id
			$sql = "UPDATE {{seckill_grab}} SET rules_id=0 WHERE rules_id IN (".implode(',', $arr4).")";
            $command = Yii::app()->db->createCommand($sql); 
            $command->execute();

            //清空秒杀纪录表
            Yii::app()->db->createCommand()->delete('{{seckill_order_cache}}',array('in','setting_id',$arr4));
            foreach($arr4 as $setting_id){
                ActivityData::cleanCache($setting_id);
            }

			Tool::cache(ActivityData::CACHE_ACTIVITY_EXPIRE_CONFIG)->delete(ActivityData::CACHE_ACTIVITY_EXPIRE_CONFIG);
//            $this->addLog('setting','creanSetting',$arr4);
		}
    }

    /**
     *
     */
    public function actionUpdateStatusExpire(){
        $this->addLog('expire','run-'.time(),date('Y-m-d H:i:s'));
        $time = time();
        //读取要更新的内容
        $sql = "SELECT * FROM {{seckill_order_cache}}";
        $command = Yii::app()->db->createCommand($sql);
        $command->execute();
        $reader = $command->query();
        foreach($reader as $row){
            $this->addLog('expire','check',$row);
            // 未下单,已超时,删除order_cache和缓存
            if($row['is_process'] < SeckillRedis::IS_PROCESS_ORDER){
                if(($row['create_time'] + SeckillRedis::TIME_INTERVAL_CONFIRM) < $time){
                    $this->addLog('expire','list',$row);
                    ActivityData::deleteOrderCache($row['user_id'], $row['goods_id']);
                }
            }
            // 未支付,已超时,删除order_cache和缓存,关闭订单,返回库存
            elseif($row['is_process'] == SeckillRedis::IS_PROCESS_ORDER){
                // 验证订单真实状态
                $noPay = Yii::app()->db->createCommand()
                    ->select('id,pay_status')->from('{{order}}')
                    ->where('code=:code and status<=:status', array(':code' => $row['order_code'],':status' => Order::STATUS_NEW))
                    ->queryRow();
                if($noPay['pay_status'] <= Order::PAY_STATUS_NO){
                    //  关闭订单
                    if(($row['create_time'] + SeckillRedis::TIME_INTERVAL_ORDER) < $time){
                        $this->addLog('expire','order',$row);
                        ActivityData::deleteOrderCache($row['user_id'], $row['goods_id']);//删除秒杀流程缓存
                        ActivityData::closeOrder($row['order_code']);//关闭订单
                        ActivityData::delGoodsCache($row['goods_id']);//删除商品缓存
                        ActivityData::deleteActivityGoodsStock($row['goods_id']);//删除库存缓存
                    }
                }else{
                    //update
                    $name = $row['user_id'] . '-' . $row['goods_id'];
                    Tool::cache(ActivityData::CACHE_ACTIVITY_ORDER)->delete($name);
                    Yii::app()->db->createCommand()->update('{{seckill_order_cache}}',array('is_process' => 3),'order_code=:order_code',array('order_code'=>$row['order_code']));
                }

            }
//            // 已支付,保留order_cache,删除缓存
//            elseif($row['is_process'] > SeckillRedis::IS_PROCESS_ORDER){
//                SeckillRedis::delCacheDefault($row['user_id'], $row['goods_id']);
//            }
//            OnlinePayment::_delCache();//支付的时候已经处理
        }
    }

    public function actionFlush($code=null){
        //读取要更新的内容
        $sql = "SELECT * FROM {{seckill_order_cache}}";
        if($code){
            $sql .= " where order_code='{$code}'";
        }
        $command = Yii::app()->db->createCommand($sql);
        $command->execute();
        $reader = $command->query();
        foreach($reader as $row){
            ActivityData::deleteOrderCache($row['user_id'], $row['goods_id']);
            ActivityData::closeOrder($row['order_code']);
            ActivityData::delGoodsCache($row['goods_id']);//删除商品缓存
            ActivityData::deleteActivityGoodsStock($row['goods_id']);//删除库存缓存
        }
        $setting = ActivityData::getActivityRulesSeting();
        foreach($setting as $val){
            ActivityData::cleanCache($val['id']);
        }

    }

    public function addLog($fileName,$content='',$array=array()){
        $root = Yii::getPathOfAlias('root');
        //        $num = date("Ym").(date("W")-date("W",strtotime(date("Y-m-01"))));
        $num = date("mda");
        $path = $root.DS. 'console' . DS . 'data' . DS . $fileName.'-'.$num;
        $str = PHP_EOL."------------------------------------------" .PHP_EOL.
            "time: " . date("m-d H:i:s") .
            PHP_EOL . $content;
        if(!empty($array)){
            $str .= PHP_EOL;
            $str .= var_export($array, TRUE);
        }
        $str .= PHP_EOL;

        file_put_contents($path, $str, FILE_APPEND);
    }
}
?>
