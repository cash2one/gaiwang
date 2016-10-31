<?php

/**
 * 前台控制器父类
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class Controller extends CController {

    public $layout = 'main';
    public $menu = array();
    public $breadcrumbs = array();
    // meta
    public $keywords;
    public $description;
    public $title;
    public $globalkeywords;  //全局搜索变量
    public $theme; //主题对象

    /**
     * 在 filters 中指定postRequest 用于避免重复提交
     * @param  CFilterChain $filterChain
     * @throws CHttpException
     */

    public function filterPostRequest($filterChain) {
        if ($this->isPost()) {
            $session = Yii::app()->session;
            $sessionKey = 'is_sending'; //action的路径
            //第一次点击确认按钮时执行
            if (!isset($session[$sessionKey])) {
                $session[$sessionKey] = time();
            } else {
                $first_submit_time = $session[$sessionKey];
                $current_time = time();
                $session[$sessionKey] = $current_time;
                if ($current_time - $first_submit_time < 5) {
                    throw new CHttpException(400, '请不要频繁提交数据！');
                }
            }
        }
        $filterChain->run();
    }

    public function beforeAction($action) {
        $globalkeyword = $this->getConfig('globalkeyword');
        $this->globalkeywords = explode('|', $globalkeyword['hotSearchKeyword']);
        $this->theme = Yii::app()->getTheme();
        return parent::beforeAction($action);
    }

    /**
     * 检测重复提交
     * @param string $url 跳转地址
     * @param int $limitTime 限制时间 秒
     * @throws CHttpException
     */
    public function checkPostRequest($url = null,$limitTime=5) {
        if (!$this->isPost() && !$this->isAjax()) {
            $session = Yii::app()->session;
            $sessionKey = 'is_sending'; //action的路径
            //第一次点击确认按钮时执行
            if (!isset($session[$sessionKey])) {
                $session[$sessionKey] = time();
            } else {
                $first_submit_time = $session[$sessionKey];
                $current_time = time();
                $session[$sessionKey] = $current_time;
                if ($current_time - $first_submit_time < $limitTime) {
                    if ($url) {
                        $this->redirect($url);
                    } else {
                        throw new CHttpException(400, '请不要频繁提交数据！');
                    }
                }
            }
        }
    }

    /**
     * 设置cookie值
     * @param string $name
     * @param string $value
     * @param int $life
     */
    public function setCookie($name, $value = null, $life = 0) {
        $cookie = new CHttpCookie($name, $value);
        $cookie->expire = $life ? time() + $life : 0;
        Yii::app()->request->cookies[$name] = $cookie;
    }

    /**
     * 读取cookie值
     * @param string $name
     * @return boolean|string
     */
    public function getCookie($name) {
        $cookie = Yii::app()->request->cookies[$name];
        if (empty($cookie))
            return false;
        return $cookie->value;
    }

    /**
     * 设置session值
     * @param string $key
     * @param string|array $value 如果$value为null表示注销session
     */
    public function setSession($key, $value = null) {
        Yii::app()->user->setState($key, $value, null);
    }

    /**
     * 获取session值
     * @param string $key
     * @param string|array $defaultValue
     * @return string|array
     */
    public function getSession($key, $defaultValue = null) {
        return Yii::app()->user->getState($key, $defaultValue);
    }

    /**
     * 获取flash值
     * @param string $key
     * @param string|array $defaultValue
     * @return string|array
     */
    public function getFlash($key, $defaultValue = null, $delete = true) {
        return Yii::app()->user->getFlash($key, $defaultValue, $delete);
    }

    /**
     * 设置flash值
     * @param string $key
     * @param string|array $value
     */
    public function setFlash($key, $value = null) {
        Yii::app()->user->setFlash($key, $value, null);
    }

    /**
     * 获取post提交参数
     * @param string $name
     * @param string $defaultValue
     * @param boolean $filter
     * @return string|array
     */
    public function getPost($name, $defaultValue = null, $filter = true) {
        $data = Yii::app()->request->getPost($name, $defaultValue);
        if (!$filter)
            return $data;
        return $this->magicQuotes($data);
    }

    /**
     * 获取get提交参数
     * @param string $name
     * @param string $defaultValue
     * @param boolean $filter
     * @return string|array
     */
    public function getQuery($name, $defaultValue = null, $filter = true) {
        $data = Yii::app()->request->getQuery($name, $defaultValue);
        if (!$filter)
            return $data;
        return $this->magicQuotes($data);
    }

    /**
     * 获取post,get提交参数
     * @param string $name
     * @param string $defaultValue
     * @param boolea  $filter
     * @return string|array
     */
    public function getParam($name, $defaultValue = null, $filter = true) {
        $params = Yii::app()->request->getParam($name, $defaultValue);
        if (!$filter)
            return $params;
        return $this->magicQuotes($params);
    }

    /**
     * 转义数据
     * @param string|array $var
     * @return string|array
     */
    public function magicQuotes(&$var) {
        if (!get_magic_quotes_gpc()) {
            if (is_array($var)) {
                foreach ($var as $k => $v)
                    $var[$k] = $this->magicQuotes($v);
            }
            else
                $var = addslashes($var);
        }
        return $var;
    }

    /**
     * 反转义数据
     * @param $var
     * @return array|string
     */
    public function delSlashes(&$var) {
        if (is_array($var)) {
            foreach ($var as $k => $v) {
                $var[$k] = $this->delSlashes($v);
            }
        } else {
            $var = stripslashes($var);
        }
        return $var;
    }

    /**
     * 判断是否post请求
     * @return boolean
     */
    public function isPost() {
        return Yii::app()->request->isPostRequest;
    }

    /**
     * 判断是否ajax请求
     * @return boolean
     */
    public function isAjax() {
        return Yii::app()->request->isAjaxRequest;
    }

    /**
     * 获取应用用户实例
     * @return CWebUser
     */
    public function getUser() {
        return Yii::app()->user;
    }

    /**
     * 获取配置文件下的参数
     * @param string $field1
     * @param string $field2
     * @return string|array
     */
    public function params($field1, $field2 = null) {
        return $field2 ? Yii::app()->params[$field1][$field2] : Yii::app()->params[$field1];
    }

    /**
     * 获取当前访问者的ip
     * @return string
     */
    public function clientIp() {
        return Yii::app()->request->userHostAddress;
    }

    /**
     * 通用产生模型实例
     * @param int $id
     * @throws CHttpException
     * @return CModel
     */
    public function loadModel($id) {
        $object = ucfirst($this->id);
        $object = '$model=' . $object . '::model()->findByPk((int)' . $id . ');';
        eval($object);
        if ($model === null)
            throw new CHttpException(404, '请求的页面不存在.');
        return $model;
    }

    /**
     * 通用的ajax表单验证
     * @param CModel $model
     * @return void
     */
    public function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === $this->id . '-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * 获取后台配置的常用参数数据
     * @param string $name  文件名称，例如site.config.inc,$name = 'site'
     * @param string $key 该配置项的键名
     * @return string
     */
    public function getConfig($name, $key = null) {
        $val = Tool::cache($name . 'config')->get($name);
        if ($val) {
            $array = unserialize($val);
        } else {
            $value = WebConfig::model()->findByAttributes(array('name' => $name));
            if ($value) {
                Tool::cache($name . 'config')->add($name, $value->value);
                $array = unserialize($value->value);
            } else {
                $file = Yii::getPathOfAlias('common') . DS . 'webConfig' . DS . $name . '.config.inc';
                if (!file_exists($file)) {
                    return array();
                }
                $content = file_get_contents($file);
                $array = unserialize(base64_decode($content));
            }
        }

        return $key ? (isset($array[$key]) ? $array[$key] : '') : $array;
    }

    /**
     * 获取公共缓存目录的缓存文件
     * @return CFileCache
     */
    public function cache($dir) {
        return Tool::cache($dir);
    }

    /**
     * @return CFormatter  数据格式化
     */
    public function format() {
        return Yii::app()->format;
    }

    /**
     * 会员中心，获取左边导航数据
     * @param string $type
     * @return array
     */
    public function getMenu($type) {
        $menu = include(Yii::getPathOfAlias('application') . DS . 'config' . DS . 'menu.php');
        return $menu[$type];
    }

    /**
     * 卖家平台，根据当前控制器，判断右侧菜单的显示与隐藏
     * @param $menuArr
     * @return string
     */
    public function showMenu($menuArr) {
        foreach ($menuArr as $v) {
            $actionArr = explode('/', is_array($v) ? $v['value'] : $v);
            if (isset($actionArr[2]) && $actionArr[2] == $this->id)
                return true;
            if (isset($v['actions']) && is_array($v['actions'])) {
                foreach ($v['actions'] as $k => $action) {
                    $actionArr = explode('/', $k);
                    if ($this->id == $actionArr[0])
                        return true;
                }
            }
        }
        return false;
    }

    public function getQQConfig() {
        $site_config = $this->getConfig('site');
        $QQConfigs = explode(',', $site_config['qq']);

        foreach ($QQConfigs as $key => $val) {
            $temp_arr = explode(':', $val);
            $QQConfigs[$key] = array('name' => $temp_arr[0], 'code' => $temp_arr[1]);
        }

        return $QQConfigs;
    }

    /**
     * 跳转操作
     * request 参数
     * turnback = 1 || turnbackUrl = 1时执行跳转
     * croute 为urlencode后的路由
     * Enter description here ...
     */
    public function turnback() {
        if (!empty($_REQUEST['turnback'])) {
            $this->redirect($this->createUrl(urldecode($_REQUEST['croute'])));
        }

        //根据url跳转
        if (!empty($_REQUEST['turnbackByUrl'])) {
            $this->redirect(urldecode($_REQUEST['turnbackUrl']));
        }
    }

    /**
     * 设置回跳 跳转
     * Enter description here ...
     * @param unknown_type $to_route  跳转目标 路由
     * @param unknown_type $back_route  回跳目标路由
     *
     * 设置后需在目标操作中添加turnback() 方法。
     *
     */
    public function turnbackRedirect($to_route, $back_route = '') {
        if (empty($back_route))
            $back_route = '/' . $this->getRoute();
        $this->redirect($this->createUrl($to_route, array('turnback' => 1, 'croute' => urlencode($back_route))));
    }

    /**
     * 添加卖家平台操作记录
     * @param int $category_id
     * @param int $type_id
     * @param int $source_id
     * @param string $sub_title
     */
    protected function _saveSellerLog($category_id = 0, $type_id = 0, $source_id = 0, $sub_title = '') {
        SellerLog::create($category_id, $type_id, $source_id, $sub_title);
//        $assistantId = $this->getSession('assistantId'); //店小二id
//    	//添加操作日志
//        $log = new SellerLog();
//		$log->category_id = $category_id;
//     	$log->type_id = $type_id;
//     	$log->create_time = time();
//     	$log->source = ucwords(Yii::app()->controller->id).ucwords($this->action->id);
//     	$log->source_id = $source_id;
//     	$log->member_id = empty($assistantId)?$this->getUser()->id:$assistantId;
//     	$log->member_name = !empty($this->getUser()->name)?$this->getUser()->name:'';
//     	$log->ip = Yii::app()->request->userHostAddress;
//     	$log->is_admin = empty($assistantId)?1:0;
//     	$user_type = empty($assistantId)?'商家用户':'店小二';
//     	$log->title = $user_type.$log->member_name.$sub_title;
//     	$log->save();
    }
    
    /**
     * 重写创建url类，适用于生成商品详情页的链接。将正则匹配去掉。暂时注释，发现不兼容Yii::app()->createUrl的方法。
     * @author LC
     */
//     public function createUrl($route,$params=array(),$ampersand='&')
//     {
//     	$url = parent::createUrl($route,$params,$ampersand);
//     	if(strpos($url, '(_en|_tw){0,1}'))
//     	{
//     		$url = str_replace('(_en|_tw){0,1}', '', $url);
//     	}
//     	return $url;
//     }
    /**
     * 需要做https的模块和链接
     * @return [type] [description]
     */
    public static function getHttpsModule(){
        return array(
            'noModule'=>array(
                's4.cnzz.com',
                'www.' .SHORT_DOMAIN .'/site/Select.html',
                'www.' .SHORT_DOMAIN .'/cart/loadCart.html',
                'www.' .SHORT_DOMAIN .'/order/payv2.html',
                'www.' .SHORT_DOMAIN .'/order/payShowv2.html',
                'www.' .SHORT_DOMAIN .'/orderFlow/verify',
                'www.' .SHORT_DOMAIN .'/orderFlow/changeAddress',
				'hotel.'.SHORT_DOMAIN.'/order/pay',
				//'hotel.gaiwang.com/order/payShow',
				//'hotel.'.SHORT_DOMAIN.'/order/payShow',
			    //'hotel.'.SHORT_DOMAIN.'/order/checkingInDetail'

            ),
            'member'=>array(                    //需要做https的模块
                '.' .SHORT_DOMAIN .'/js',
                '.' .SHORT_DOMAIN .'/themes/v2.0/js',
                '.' .SHORT_DOMAIN .'/themes/v2.0/styles',
            ),
        );
    }
	
	
	public function createAbsoluteUrl($route,$params=array(),$schema='',$ampersand='&')
    {
        $url=$this->createUrl($route,$params,$ampersand);
        if(strpos($url,'http')!==0){
            $url = Yii::app()->getRequest()->getHostInfo($schema).$url;
        }
        if(defined('IS_HTTPS') && IS_HTTPS){
            $moduleArr = self::getHttpsModule();
            foreach($moduleArr as $key => $value){
                //需要做https的模块,尝试替换成 http://member => https://member
                if($key != 'noModule'){
                    $url = str_replace('http://'.$key,'https://'.$key,$url);
                }else{
                    //非https模块，也需要https的，替换
                    foreach($value as $v){
                        $url = str_replace('http://'.$v,'https://'.$v,$url);
                    }
                }
            }
        }
        return $url;
    }

    /**
     * !CodeTemplates.overridecomment.nonjd!
     * @see CController::render()
     */
    public function render($view,$data=null,$return=false){
        $output = parent::render($view,$data,true);
        if(defined('IS_HTTPS') && IS_HTTPS){
            $moduleArr = self::getHttpsModule();
            foreach ($moduleArr as $key => $value) {
                foreach ($value as $k => $v) {
                    if($key != 'noModule' && isset($this->module->id) && $this->module->id == $key){
                        $output = str_replace('www'.$v,$key.$v,$output);
                        $v = $key.$v;
                    }
                    $output = str_replace('http://'.$v,'https://'.$v,$output);
                }
                $output = str_replace('http://'.$key,'https://'.$key,$output);
            }
        }
        if($return){
            return $output;
        }
        else{
            echo $output;
        }
    }
    
    public function redirect($url,$terminate=true,$statusCode=302)
    {
        if(is_array($url))
        {
            $route=isset($url[0]) ? $url[0] : '';
            $url=$this->createUrl($route,array_splice($url,1));
        }
        if(defined('IS_HTTPS') && IS_HTTPS){
			$is_write = false;
            $moduleArr = self::getHttpsModule();
			if(strpos($url,'http')!==0){
				$url = Yii::app()->getRequest()->getHostInfo().$url;
			}
            foreach ($moduleArr as $key => $value) {
                if( $key != 'noModule' ){
                    if($_SERVER['SERVER_NAME'] == ($key.'.'.SHORT_DOMAIN)){
                        $url = str_replace('http://','https://',$url);
						$is_write = true;
						break;
                    }

                    if($url == '/'){
                        $url = "https://" . $key . "." .SHORT_DOMAIN;
						$is_write = true;
						break;
					}
					
                    if(isset($this->module->id) && $this->module->id == $key){
                        $url = str_replace('http://','https://',$url);
						$is_write = true;
						break;
					}
					
                }elseif ($key == 'noModule'){
                    foreach ($value as $k => $v) {
						
						$star = strpos($url,'://') + 3;
						$end = strpos($url,'?');
						$leng = $end ? ($end - $star) : (strlen($url) - $star);
						$host = substr($url,$star,$leng);
						if($host==$v) {
                            $url = str_replace('http://','https://',$url);
							$is_write = true;
							break;
                        }
						
                    } 		
				}
            }
			if(!$is_write){
                $isMySite = true; //不是本站的网址，不做处理
                if((substr($url,0,7)=='http://' || substr($url,0,8)=='https://') && strpos($url,SHORT_DOMAIN)===false){
                    $isMySite = false;
                }
				if($this->id!='confirm' && !$isMySite)
				{
					$url = str_replace('https://','http://',$url);
				}
			}
		}
        Yii::app()->getRequest()->redirect($url,$terminate,$statusCode);
    }
    /**
     * 记录访问日志
     * @param $fileName
     * @param string $content
     * @param array $array
     */
    public function addLog($fileName,$content='',$array=array()){
        $root = Yii::getPathOfAlias('root');
        //        $num = date("Ym").(date("W")-date("W",strtotime(date("Y-m-01"))));
        $num = date("mda");
        $path = $root.DS. 'frontend' . DS . 'runtime' . DS . $fileName.'-'.$num;
        $str = PHP_EOL."------------------------------------------" .PHP_EOL.
        "ctr: " . $this->getId() . ", act: " . $this->getAction()->getId() . ", time: " . date("m-d H:i:s") .
        PHP_EOL . $content;
        if(!empty($array)){
            $str .= PHP_EOL;
            $str .= var_export($array, TRUE);
        }
        $str .= PHP_EOL;
        
        file_put_contents($path, $str, FILE_APPEND);
    }
}
