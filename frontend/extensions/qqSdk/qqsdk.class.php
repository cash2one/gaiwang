<?php 
     
/**
 * QQ第三方 登陆插件 认证类(OAuth2)
 * 
 * API接口网址：https://graph.qq.com/oauth2.0/
 */

class qqSdk{
    
    public $app_id ;
    public $app_secret;
    public $access_token;
    public $refresh_token;
    public $host="https://graph.qq.com/oauth2.0/";
    public $timeout = 30;
    public $connecttimeout = 30;
    public $format = 'json';
    public $decode_json = TRUE;
    
public  function __construct($client_id, $client_secret, $access_token = NULL, $refresh_token = NULL)
    {
          $this->app_id= $client_id;
          $this->app_secret= $client_secret;
          $this->access_token= $access_token;
          $this->refresh_token= $refresh_token;
    }
    
// 取得access_token地址
	public function accessTokenURL(){ 
		return 'https://graph.qq.com/oauth2.0/token'; 
	}
	
// 授权页面地址
	public function authorizeURL(){ 
		return 'https://graph.qq.com/oauth2.0/authorize'; 
	}
	
// 取得用户信息页面
	public function user_info_url(){
		return 'https://graph.qq.com/user/get_user_info';
	}
	
/**
 * authorize接口
 * @param $url  授权后的回调地址,站外应用需与回调地址一致,站内应用需要填写canvas page的地址
 * @param string $response_type  支持的默认值为code
 * @param string $state 用于保持请求和回调的状态。在回调时,会在Query Parameter中回传该参数
 * @param string $display
 * @return string
 */
	public  function getAuthorizeURL($url,$keys){ 
	    $params = array();
	    $params['response_type'] = $keys['response_type'];
	    $params['client_id'] = $this->app_id;
	    $params['redirect_uri'] = $url; 
	    $params['state'] = $keys['state'];
	    $params['display'] = $keys['display'];
	    return $this->authorizeURL() . "?" . http_build_query($params);
	    
	}
/**
 * 获取access_token
 * [get_access_token]
 * @param [string] $code [登陆后返回的$_GET['code']]
 * @return [array] [expires_in 为有效时间 , access_token 为授权码 ; 失败返回 error , error_description ]
 */
   public function getAccessToken($keys)
    {
        $params = array();
        $token=array();
        $params['grant_type'] = "authorization_code";
        $params['client_id'] = $this->app_id;
        $params['redirect_uri'] =  $keys['redirect_uri'];
        $params['client_secret'] = $this->app_secret;
        $params['code'] =$keys['code'];
        $token_url=$this->accessTokenURL(). "?" . http_build_query($params);
        $response = $this->get_contents($token_url);
        if (strpos($response, "callback") !== false)
        {
            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
            $msg = json_decode($response);
            if (isset($msg->error))
            {
                echo "<h3>error:</h3>" . $msg->error;
                echo "<h3>msg  :</h3>" . $msg->error_description;
                exit;
            }
        }
        parse_str($response, $token);
        return $token;
    }
    
/**
* 获取用户唯一ID，openid
* [get_open_id]
* @param [string] $token [授权码]
* @return [array] [成功返回client_id 和 openid ;失败返回error 和 error_msg]
*/
     public function get_open_id($token){
             $str = $this->get_contents("https://graph.qq.com/oauth2.0/me?access_token=" . $token);
                 if (strpos($str, "callback") !== false)
                {
                    $lpos = strpos($str, "(");
                    $rpos = strrpos($str, ")");
                    $str  = substr($str, $lpos + 1, $rpos - $lpos -1);
                }
                    $user = json_decode($str, TRUE);
                    return $user;
                }

/**
* [get_user_info 获取用户信息]
* @param [string] $token [授权码]
* @param [string] $open_id [用户唯一ID]
* @return [array] [ret：返回码，为0时成功。msg为错误信息,正确返回时为空。...params]
*/
   public function get_user_info($token, $open_id){
        $params = array();
        $params['access_token'] = $token;
        $params['oauth_consumer_key'] = $this->app_id;
        $params['openid'] = $open_id;
        $params['format'] = $this->format;
        $user_info_url = $this->user_info_url(). "?" . http_build_query($params);
        $info = json_decode($this->_curl_get_content($user_info_url), TRUE);
         return $info;
    }
      
  /**
   * get_contents
   * 服务器通过get请求获得内容
   * @param string $url       请求的url,拼接后的
   * @return string           请求返回的内容
   */
  public function get_contents($url){
      if (ini_get("allow_url_fopen") == "1") {
          $response = file_get_contents($url);
      }else{
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
          curl_setopt($ch, CURLOPT_URL, $url);
          $response =  curl_exec($ch);
          curl_close($ch);
      }

      return $response;
  }

  /**
   * post
   * post方式请求资源
   * @param string $url       基于的baseUrl
   * @param array $keysArr    请求的参数列表
   * @param int $flag         标志位
   * @return string           返回的资源内容
   */
  public function post($url, $keysArr, $flag = 0){
      $ch = curl_init();
      if(! $flag) curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_POST, TRUE);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $keysArr);
      curl_setopt($ch, CURLOPT_URL, $url);
      $ret = curl_exec($ch);
      curl_close($ch);
      return $ret;
  }
    
}


?>