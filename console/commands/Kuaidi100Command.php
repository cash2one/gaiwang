<?php

/**
 * 快递100推送消息入库进程 
 * @author wyee<yanjie.wang@g-emall.com>
 * @date 20160705
 */
class Kuaidi100Command extends CConsoleCommand {
    
	/**
	 * 快递100推送消息入库进程
	 */
    public function actionInfoUpdate()
    {
    	$list = new ARedisList('kuaidi100_list');
    	$redisData=$list->getData(true);
    	foreach ($redisData as $val){
    	   if ($val !== false) { 
    	    	$cacheData=Tool::cache('kuaidi100_list')->get($val);
    	    	$code=$val;
    	    	$data = json_decode($cacheData, true);
    	    	if(!empty($data)){
	    	    	$insert = array();
	    	    	$insert['state'] = $data['lastResult']['state'];
	    	    	$insert['status'] = OrderExpress::toStatus($data['status']);
	    	    	$insert['message'] = $data['message'];
	    	    	$insert['data'] = json_encode($data['lastResult']);
	    	    	$insert['update_time'] = time();
	    	    	//保存推送数据
	    	    	$result = Yii::app()->db->createCommand()->update('gw_order_express', $insert, 'order_code=' . $code);
	    	        if($result){
	    	            echo "更新数据成功！";
	    	            $list->remove($val);
	    	            Tool::cache('kuaidi100_list')->delete($val);
	    	        }else{
	    	            echo "更新数据失败".$code; 
	    	        }
    	       }
    	   } 
        }
    }
    
    
    
}
