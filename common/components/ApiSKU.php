<?php

/**
 * SKU项目api使用类
 * 
 * @author leo8705
 */
class ApiSKU {

	
	const CODE_SUCCESS = 1;
	
	/**
	 * 生成加密串
	 *
	 * 检验规则是data参数值连成json字符串，加上密文私钥，生成md5
	 *
	 */
	private static function _createEncryption($json_data){
		return md5($json_data.SKU_API_SIGN_KEY);
	}
	
	/**
	 * 处理返回
	 * @param unknown $data
	 * @return multitype:boolean unknown Ambigous <string, unknown>
	 */
	private static function _deal($data){
		$rs = array();
		if (isset($data['resultCode']) && $data['resultCode']==self::CODE_SUCCESS) {
			$rs['result'] = true;
			$rs['data'] = isset($data['result'])?$data['result']:'';
		}else{
			$rs['result'] = false;
			$rs['errorCode'] = isset($data['resultCode'])?$data['resultCode']:'';
			$rs['msg'] = isset($data['resultDesc'])?$data['resultDesc']:'';
		}
		
		return $rs;
	}
	
	/**
	 * 更新用户信息
	 */
	public static function updateInfo($gai_number,$project=SKU_API_PROJECT_ID){
		$url = SKU_API_URL.'/sToken/updateInfo/';
		$post_data = array();
		$post_data['project'] = $project;
		$post_data['data']['gaiNumber'] = $gai_number;
		$post_data['data'] = CJSON::encode($post_data['data']);
		$encryptCode = self::_createEncryption($post_data['data']);
		$post_data['encryptCode'] = $encryptCode;
		
		$rs_data = Tool::post($url, $post_data);
		$data = CJSON::decode($rs_data);

		if (isset($_REQUEST['onlyTest']) && $_REQUEST['onlyTest']==1) {
			var_dump($url, $post_data,$data);
		}
		
		return  self::_deal($data);
	}
	

	
}
