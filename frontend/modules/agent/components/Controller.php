<?php

/**
 * 后台控制器父类
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class Controller extends CController {

    public $layout = 'main';
    public $menu = array();
    public $breadcrumbs = array();
    public $curMenu;

    /**
     * 设置当前所在的menu
     */
    protected function setCurMenu($name) {
        $this->curMenu = $name;
    }

    public function init() {
        $this->setCurMenu(Yii::t('main', '会员管理'));    //默认进入后台管理
        $uri = Yii::app()->request->requestUri;
        if (strpos($uri, 'favicon'))
            Yii::app()->end();
    }

    protected function beforeAction($action) {
        $this->_checkLogin($action);
        return parent::beforeAction($action);
    }

    /**
     * 验证是否登录
     * @return boolean
     */
    private function _checkLogin($action) {
        if (!Yii::app()->user->isGuest) {
            $agent_region = $this->getSession('agent_region');
            if ($agent_region) {
                return true;
            } else {
                $user = Member::model()->findByPk(Yii::app()->user->getId());
                $agent_region = array();
                foreach ($user->region as $region) {
                    $agent_region[] = array(
                        'id' => $region->id,
                        'name' => $region->name,
                        'depth' => $region->depth,
                        'tree' => $region->tree,
                    );
                }
                $this->setSession('agent_region', $agent_region); //保存用户数据 到 Yii::app()->user
                if ($agent_region) {
                    return true;
                } else {
                    Yii::app()->user->logout();
                }
            }
        }
        return true;
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
        if (!$filter)
            return Yii::app()->request->getPost($name, $defaultValue);
        $param = Yii::app()->request->getPost($name, $defaultValue);
        return $this->magicQuotes($param);
    }

    /**
     * 获取get提交参数
     * @param string $name
     * @param string $defaultValue
     * @param boolean $filter
     * @return string|array
     */
    public function getQuery($name, $defaultValue = null, $filter = true) {
        if (!$filter)
            return Yii::app()->request->getQuery($name, $defaultValue);
        $param = Yii::app()->request->getQuery($name, $defaultValue);
        return $this->magicQuotes($param);
    }

    /**
     * 获取post,get提交参数
     * @param string $name
     * @param string $defaultValue
     * @param boolea  $filter
     * @return string|array
     */
    public function getParam($name, $defaultValue = null, $filter = true) {
        if (!$filter)
            return Yii::app()->request->getParam($name, $defaultValue);
        $param = Yii::app()->request->getParam($name, $defaultValue);
        return $this->magicQuotes($param);
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
    protected function performAjaxValidation($model) {
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
        return Tool::getConfig($name, $key);
//        $file = Yii::getPathOfAlias('common') . DS . 'webConfig' . DS . $name . '.config.inc';
//        if (!file_exists($file)) {
//            return array();
//        }
//        $content = file_get_contents($file);
//        $array = unserialize(base64_decode($content));
//        return $key ? (isset($array[$key]) ? $array[$key] : '') : $array;
    }

    /**
     * 获取左边导航数据
     * @return array
     */
    public function getMenu() {
        $mens = include(Yii::getPathOfAlias('application.modules.agent') . DS . 'config' . DS . 'menu.php');
        return $mens;
    }

    /**
     * @return CFormatter  数据格式化
     */
    public function format() {
        return Yii::app()->format;
    }

    /**
     * 将代理商所拥有的区域合并整理
     * @param $area			是否与选择区域进行查询
     */
    public function getPowerAear($area = true) {
        $agent_region = $this->getSession('agent_region');   //获取权限区域
        //循环拥有的区域得到所有的区域编号以及级别
        $provinceArr = array();
        $cityArr = array();
        $districtArr = array();
        foreach ($agent_region as $key => $val) {
            switch ($val['depth']) {
                case 1:
                    $provinceArr[] = $val['id'];
                    break;
                case 2:
                    $cityArr[] = $val['id'];
                    break;
                case 3:
                    $districtArr[] = $val['id'];
                    break;
            }
        }
        if ($area) {  //如果有，那么要做的操作就是判断选择的区域是否在符合的区域之内
            return array(
                'provinceArr' => $provinceArr,
                'cityArr' => $cityArr,
                'districtArr' => $districtArr,
            );
        } else {
            //去掉重复的区域编号并转换成字符串以","隔开
            $provinceId = implode(",", array_unique($provinceArr));
            $cityId = implode(",", array_unique($cityArr));
            $districtId = implode(",", array_unique($districtArr));

            return array(
                'provinceId' => $provinceId,
                'cityId' => $cityId,
                'districtId' => $districtId,
            );
        }
    }

    /**
     * 重写生成url的方法
     */
    public function createUrl($route, $params = array(), $ampersand = '&') {
        if (isset($params['ajax'])) {  //解决分页跳转（去到某一页）没有条件的问题
            $endPage_key = null;
            foreach ($params as $key => $item) {
                if (strstr($key, 'page')) {
                    $endPage_key[$key] = $item;
                    unset($params[$key]);
                    break;
                }
            }
            if ($endPage_key !== null) {
                $params = CMap::mergeArray($params, $endPage_key);
            }
        }
        return parent::createUrl($route, $params, $ampersand);
    }

    /**
     * 访问接口,以post方式传递参数
     * @param $type			string		类型			insert/update/delete		或者1,2,3
     * @param $data			array		数据
     * @param $systemlog	string		日志类型
     * return boolean
     */
    public function visitHttp($type, $data, $systemlog) {
        if ($type == "") {
            return false;
            Yii::app()->end();
        }

        $systemlog['user_id'] = Yii::app()->user->id;
        $systemlog['user_name'] = Yii::app()->user->name;
        $systemlog['user_ip'] = Tool::getClientIP();

        $postArr = array(
            'systemlog' => CJSON::encode($systemlog),
            'data' => CJSON::encode($data),
        );

        switch ($type) {
            case 1:
                $action = '/insert';
                break;
            case 'insert':
                $action = '/insert';
                break;
            case 2:
                $action = '/update';
                break;
            case 'update':
                $action = '/update';
                break;
            case 3:
                $action = '/delete';
                break;
            case 'delete':
                $action = '/delete';
                break;
        }
        $http = new HttpClient(GT_DOMAIN);
        return $http::quickPost(GT_DOMAIN . "/api/agent" . $action, $postArr);
    }

    /**
     * 检测是否有地区权限
     * @author lc
     */
    public function checkAreaAuth($province_id, $city_id, $district_id) {
        $power = $this->getPowerAear(true);

        if (in_array($district_id, $power['districtArr']) || in_array($city_id, $power['cityArr']) || in_array($province_id, $power['provinceArr'])) {
            return true;
        } else {
            throw new CHttpException(404, Yii::t('Public', '您没有访问权限'));
        }
    }

    /**
     * 存储或还原临时数据
     * 
     * @param  string  $action 动作类型
     * @param  mixed   $data   要暂存的数据
     * @return mixed
     */
    protected function _syncTmpData($key,$data=null){

        if($data!==null){
            return $this->setSession($key,$data);
        }else{
            $data = $this->getSession($key,null);
            $this->setSession($key); //注销session
            return $data;
        }
    }

}
