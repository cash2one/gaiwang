<?php
/**
 * 根据GW号返回会员会员手机号--紧急使用
 * @author LC
 *
 */
class MemberController extends Controller {
	private $secret = 'gweegrwew%#8745poufds%sdassda';
	
	/**
	 * 计算key的方式
	 * @param array $params
	 * @return string
	 */
	function calKey(array $params) {
		$url = '';
		if (!empty($params)) {
			$url = '?'.http_build_query($params);
			$url .= "&secret=" . $this->secret;
		} else {
			$url = 'secret=' . $this->secret;
		}
		return md5($url);
	}
	
	/**
	 * 接口参数的验证
	 * @param array $requireParams 参数
	 */
	public function getValidateData(array $params)
	{
		$key = $this->getQuery('key');
		if($key == null) {
			$this->_error('参数缺失');
		}
		$postData = array();
		foreach ($params as $param)
		{
			$postData[$param] = $this->getQuery($param,'');
		}
		$calKey = $this->calKey($postData);
		if($key !== $calKey)
		{
			$this->_error('验证失败');
		}
		return $postData;
	}
	
	public function actionIndex()
	{
		$params = array('gaiNo');
		$data= $this->getValidateData($params);
		$gaiNo = $data['gaiNo'];
		$member = Member::model()->findByAttributes(array('gai_number' => $gaiNo));
		if($member)
		{
			$cache = Tool::cache('vCode');
			$key = $gaiNo.'apiMember';
			$data = $cache->get($key);
			if($data == false)
			{
				$vCode = mt_rand(100000, 999990);
				$data = time().'-'.$vCode;
				$cache->set($key,$data,86400);		//设置60s无效，原因不清楚
			}
			else 
			{
				$dataArr = explode('-', $data);
				if(time()-$dataArr[0]<=60)
				{
					$this->_error('请求太频繁，请1分钟后再获取');
				}
				else 
				{
					//超过1分钟则重新获取验证码
					$vCode = mt_rand(100000, 999990);
					$data = time().'-'.$vCode;
					$cache->set($key,$data,86400);		//设置60s无效，原因不清楚
				}
			}
			$content = '您的验证码是：'.$vCode;
                                                    $datas = array($vCode);
                                                    $smsConfig = $this->getConfig('smsmodel');
                                                    $tmpId = $smsConfig['gaiVerifyContentId'];
			SmsLog::addSmsLog($member->mobile, $content, 0,  SmsLog::TYPE_CAPTCHA,null,true,$datas,  $tmpId);
			$this->_success($gaiNo, $member->mobile,$vCode);
		}
		else
		{
			$this->_error('GW号不存在');
		}
	}
	
	public function actionTest()
	{
		/**
		$gaiNo = 'GW60000001';
		$params = array(
				'gaiNo' => $gaiNo
		);
		if (!empty($params)) {
			$url = "http://api.gaiwang.com/member?" . http_build_query($params)
			. "&key=" . $this->calKey($params);
		} else {
			$url = "http://api.g-emall.com/member?key=" . $this->calKey($params);
		}
		$cli = new HttpClient('api.g-emall.com');
		$data = $cli->quickGet($url);
		$data = json_decode($data,true);
		var_dump($data);
		**/
	}
	
	private function _error($msg)
	{
		header("Content-type:text/html;charset=utf-8");
		$response = array(
				'resultCode' => 0,
				'msg' => $msg,
		);
		exit(json_encode($response));
	}
	
	private function _success($gaiNo,$mobile,$vCode)
	{
		header("Content-type:text/html;charset=utf-8");
		$response = array(
				'resultCode' => 1,
				'gaiNo' => $gaiNo,
				'mobile' => $mobile,
				'VCode' => $vCode,
		);
		exit(json_encode($response));
	}
}