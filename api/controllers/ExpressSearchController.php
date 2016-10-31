<?php
/**
 * 快递查询API接口
 * Enter description here ...
 * @author leo8705
 *
 */
class ExpressSearchController extends Controller {

	
	/**
	 * 根据快递公司代码查询
	 * store_code
	 * code
	 */
    public function actionSearchByCode() {
    	Yii::import ( 'common.vendor.ExpressSearch' );    
        
        $kd_store_code = $this->getParam('store_code');				//快递公司代码
        $kd_code = $this->getParam('code');								//快递单号
        
    	if (empty($kd_store_code)) {
    		throw new CHttpException(403,'快递公司不存在');
    	}elseif (empty($kd_code)){
    		throw new CHttpException(403,'订单号不能为空');
    	}
        
        $exp = new ExpressSearch(Yii::app()->params['ExpressApiKey'],Yii::app()->params['ExpressApiHost']);
    	$rs = $exp->search($kd_store_code,$kd_code);
    	echo $rs;
        
    }
    
    
    /**
     * 根据快递公司名字查询
     * store_name
     * code
     */
    public function actionSearchByName() {
    	Yii::import ( 'common.vendor.ExpressSearch' );
    
    	$kd_store_name = $this->getParam('store_name');				//快递公司名称
    	$kd_code = $this->getParam('code');								//快递单号
    	$kd_store_code = ExpressSearch::getStoreCodeByName($kd_store_name);
    	
    	if (empty($kd_store_code)) {
    		$this->_error('快递公司不存在');
    	}elseif (empty($kd_code)){
    		$this->_error('运单号不能为空');
    	}
    
    	$exp = new ExpressSearch(Yii::app()->params['ExpressApiKey'],Yii::app()->params['ExpressApiHost']);
    	$rs = $exp->search($kd_store_code,$kd_code);
    	echo $rs;
    
    }
    
    private function _error($msg=''){
    	echo json_encode(array('message'=>$msg));
    	exit();
    }
    
    
    /**
     * 
     * @param unknown $kd_store_code  快递公司代码
     * @param unknown $kd_code			快递单号
     */
//    private function _search($kd_store_code,$kd_code){
//    	//缓存处理
//    	$cache_key = "{$kd_store_code}_{$kd_code}";
//    	$cache_time = 3600*2;		//缓存时间2小时
//    	
//    	$rs = Yii::app()->fileCache->get($cache_key);
//    	if (empty($rs)) {
//    		$exp = new ExpressSearch(Yii::app()->params['ExpressApiKey'],Yii::app()->params['ExpressApiHost']);
//    		$rs = $exp->search($kd_store_code,$kd_code);
//    		Yii::app()->fileCache->set($cache_key,$rs,$cache_time);
//    	}
//    	
//    	return $rs;
//
//    	
//    }

    

}

