<?php
/**
 * 对面网页授权认证类
 * */ 
class duimian_oauth{
	public $client_id;
	public $client_key;
	public $access_token;
	public $refresh_token;
	public $http_code;
	public $url;
	public $host = "https://api.duimian.cn/";
	public $timeout = 30;
	public $connecttimeout = 30;
	public $ssl_verifypeer = FALSE;
	public $format = 'json';
	public $decode_json = TRUE;
	public $http_info;
	public $useragent = 'duimian OAuth2 v0.1';
	public $debug = FALSE;
	public static $boundary = '';
	
	// 取得access_token地址
	function accessTokenURL(){ 
		return 'http://openapi.duimian.cn/oauth/access_token'; 
	}
	
	// 授权页面地址
	function authorizeURL(){ 
		return 'http://openapi.duimian.cn/oauth/authorize'; 
	}
	
	// 取得用户信息页面
	function user_info_url(){
		return 'http://openapi.duimian.cn/oauth/get_user_info';
	}
	
	function __construct($client_id, $client_key, $access_token = NULL, $refresh_token = NULL) {
		$this->client_id 		= $client_id;
		$this->client_key 		= $client_key;
		$this->access_token 	= $access_token;
		$this->refresh_token 	= $refresh_token;
	}
	
	/**
	 * authorize接口
	 *
	 * @param string $url 授权后的回调地址,站外应用需与回调地址一致,站内应用需要填写canvas page的地址
	 * @param string $response_type 支持的值包括 code 和token 默认值为code
	 * @param string $state 用于保持请求和回调的状态。在回调时,会在Query Parameter中回传该参数
	 * @param string $display 授权页面类型 可选范围:
	 *  - default		默认授权页面
	 *  - mobile		支持html5的手机
	 *  - popup			弹窗授权页
	 *  - wap1.2		wap1.2页面
	 *  - wap2.0		wap2.0页面
	 *  - js			js-sdk 专用 授权页面是弹窗，返回结果为js-sdk回掉函数
	 *  - apponweibo	站内应用专用,站内应用不传display参数,并且response_type为token时,默认使用改display.授权后不会返回access_token，只是输出js刷新站内应用父框架
	 * @return array
	 */
	function getAuthorizeURL( $url, $response_type = 'code', $state = NULL, $display = NULL ) {
		$params = array();
		$params['client_id'] 		= $this->client_id;
		$params['redirect_uri'] 	= $url;
		$params['response_type'] 	= $response_type;
		$params['state'] 			= $state;
		$params['display'] 			= $display;
		return $this->authorizeURL() . "?" . http_build_query($params);
	}
	
	/**
	 * access_token接口
	 *
	 * @param string $type 请求的类型,可以为:code, password, token
	 * @param array $keys 其他参数：
	 *  - 当$type为code时： array('code'=>..., 'redirect_uri'=>...)
	 *  - 当$type为password时： array('username'=>..., 'password'=>...)
	 *  - 当$type为token时： array('refresh_token'=>...)
	 * @return array
	 */
	function getAccessToken($keys,$type='code'){
		$params = array();
		$params['client_id'] 	= $this->client_id;
		$params['client_key'] 	= $this->client_key;
		
		if ( $type === 'code' ) {
			$params['code'] 		= $keys['code'];
			$params['redirect_uri'] = $keys['redirect_uri'];
		}else {
			die('wrong auth type');
		}
		
		$response = $this->post($this->accessTokenURL(), $params);
		$res 	  = json_decode($response, true);
		return $res;
	}
	
	
	/**
	 * 根据token取得用户信息
	 * @param	$token	token信息
	 * */
	function get_user_info($token){
		$params = array();
		$params['client_id'] 	= $this->client_id;
		$params['client_key'] 	= $this->client_key;
		$params['token'] 		= $token;
		$res = $this->post($this->user_info_url(), $params);
		$res = json_decode($res,true);
		return $res;
	}
	
	
	/**
	 * GET请求
	 * @param	$sUrl		请求url
	 * @param	$aGetParam	请求参数
	 */
	function get($sUrl,$aGetParam){
		$oCurl = curl_init();
		if(stripos($sUrl,"https://")!==FALSE){
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
		}
		$aGet = array();
		foreach($aGetParam as $key=>$val){
			$aGet[] = $key."=".urlencode($val);
		}
		curl_setopt($oCurl, CURLOPT_URL, $sUrl."?".join("&",$aGet));
		curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
		$sContent = curl_exec($oCurl);
		$aStatus = curl_getinfo($oCurl);
		curl_close($oCurl);
		if($this->debug){
			echo "<tr><td class='narrow-label'>请求地址:</td><td><pre>".$sUrl."</pre></td></tr>";
			echo "<tr><td class='narrow-label'>GET参数:</td><td><pre>".var_export($aGetParam,true)."</pre></td></tr>";
			echo "<tr><td class='narrow-label'>请求信息:</td><td><pre>".var_export($aStatus,true)."</pre></td></tr>";
			if(intval($aStatus["http_code"])==200){
				echo "<tr><td class='narrow-label'>返回结果:</td><td><pre>".$sContent."</pre></td></tr>";
				if((@$aResult = json_decode($sContent,true))){
					echo "<tr><td class='narrow-label'>结果集合解析:</td><td><pre>".var_export($aResult,true)."</pre></td></tr>";
				}
			}
		}
		if(intval($aStatus["http_code"])==200){
			return $sContent;
		}else{
			echo "<tr><td class='narrow-label'>返回出错:</td><td><pre>".$aStatus["http_code"].",请检查参数或者确实是对面服务器出错咯。</pre></td></tr>";
			return FALSE;
		}
	}
	
	/**
	 * POST 请求
	 * @param	$sUrl			请求url
	 * @param	$aPOSTParam		请求参数
	 */
	function post($sUrl,$aPOSTParam){
		global $aConfig;
		$oCurl = curl_init();
		if(stripos($sUrl,"https://")!==FALSE){
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
		}
		$aPOST = array();
		foreach($aPOSTParam as $key=>$val){
			$aPOST[] = $key."=".urlencode($val);
		}
		curl_setopt($oCurl, CURLOPT_URL, $sUrl);
		curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($oCurl, CURLOPT_POST,true);
		curl_setopt($oCurl, CURLOPT_POSTFIELDS, join("&", $aPOST));
		$sContent = curl_exec($oCurl);
		$aStatus = curl_getinfo($oCurl);
		curl_close($oCurl);
		if($this->debug){
			echo "<tr><td class='narrow-label'>请求地址:</td><td><pre>".$sUrl."</pre></td></tr>";
			echo "<tr><td class='narrow-label'>POST参数:</td><td><pre>".var_export($aPOSTParam,true)."</pre></td></tr>";
			echo "<tr><td class='narrow-label'>请求信息:</td><td><pre>".var_export($aStatus,true)."</pre></td></tr>";
			if(intval($aStatus["http_code"])==200){
				echo "<tr><td class='narrow-label'>返回结果:</td><td><pre>".$sContent."</pre></td></tr>";
				if((@$aResult = json_decode($sContent,true))){
					echo "<tr><td class='narrow-label'>结果集合解析:</td><td><pre>".var_export($aResult,true)."</pre></td></tr>";
				}
			}
		}
		if(intval($aStatus["http_code"])==200){
			return $sContent;
		}else{
			echo "<tr><td class='narrow-label'>返回出错:</td><td><pre>".$aStatus["http_code"].",请检查参数或者确实是对面服务器出错咯。</pre></td></tr>";
			return FALSE;
		}
	}
	
	
	
	
}
?>