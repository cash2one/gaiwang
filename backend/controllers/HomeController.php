<?php

/**
 * 网站相关配置控制器
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class HomeController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 修改配置文件
     * 文件名规则：控制器+Config 后缀，模型+ConfigForm后缀
     *
     * @param string $actionId   $this->action->id  控制器名称
     */
    private function _settingConfig($actionId) {
        $modelForm = ucfirst($actionId) . 'Form';
        $name = substr($actionId, 0, -6);
        $viewFileName = strtolower($name);
//        Tool::pr($viewFileName);
        $model = new $modelForm;
        if($actionId === 'CashHistoryConfig'){
        	$model->setAttributes(Tool::getConfig($viewFileName));
        }else{
            $model->setAttributes($this->getConfig($viewFileName));
        }

        if ($actionId === 'allocationConfig') {
            //酒店旧消费者返还比率
            $oldHotelOnConsume = $model->hotelOnConsume;
        }
        //ajax表单验证
        $this->performAjaxValidation($model);

        if (isset($_POST[$modelForm])) {
            $model->attributes = $_POST[$modelForm];
            if ($model->validate()) {
                $string = serialize($model->attributes);
                $value = WebConfig::model()->findByAttributes(array('name' => $viewFileName));
                if ($value) {
                    $webConfig = WebConfig::model();
                    $webConfig->id = $value->id;
                } else {
                    $webConfig = new WebConfig();
                }
                $webConfig->name = $viewFileName;
                $webConfig->value = $string;
//                $file = Yii::getPathOfAlias('common') . DS . 'webConfig' . DS . $viewFileName . '.config.inc';
                if ($webConfig->save()) { //向得到的文件路劲指定的文件里面插入数据
                    //更新酒店所有room预估返还积分
                    if ($actionId === 'allocationConfig' && $oldHotelOnConsume !== $model->hotelOnConsume) {
                        $model->updateRoomCredits();
                    }
                    if (Tool::cache($viewFileName . 'config')->get($viewFileName)) {
                        Tool::cache($viewFileName . 'config')->set($viewFileName, $string);
                    } else {
                        Tool::cache($viewFileName . 'config')->add($viewFileName, $string);
                    }
                    //更新orderapi项目redis网站配置缓存@author xiaoyan.luo
                    Tool::orderApiPost('config/updateCache',array('configName' => $viewFileName . 'config', 'value' => $string));
                    $this->setFlash('success', Yii::t('home', '数据保存成功'));
                    @SystemLog::record(Yii::app()->user->name . "修改配置文件：" . $this->action->id);
                } else {
                    $this->setFlash('error', Yii::t('home', '数据保存失败，请检查相关目录权限'));
                }
            }
        }
        //CActiveForm widget 参数
        $formConfig = array(
            'id' => $this->id . '-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        );
        $this->render(strtolower($actionId), array('model' => $model, 'formConfig' => $formConfig));
    }

    /**
     * 网站配置
     */
    public function actionSiteConfig() {
        $this->breadcrumbs = array(Yii::t('home', '网站配置管理'), Yii::t('home', '网站配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 游戏开关配置
     */
    public function actionGameConfig() {
        $this->breadcrumbs = array(Yii::t('home', '网站配置管理'), Yii::t('home', '游戏开关配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * SEO配置
     */
    public function actionSeoConfig() {
        $this->breadcrumbs = array(Yii::t('home', '网站配置管理'), Yii::t('home', 'SEO配置')); //导航设置
        $this->_settingConfig($this->action->id);
    }

    /**
     * 积分分配配置
     */
    public function actionAllocationConfig() {
        $this->breadcrumbs = array(Yii::t('home', '积分配置管理'), Yii::t('home', '积分分配配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 积分兑现配置
     */
    public function actionCreditsConfig() {
        $this->breadcrumbs = array(Yii::t('home', '积分配置管理'), Yii::t('home', '积分兑现配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 企业会员提现配置
     */
    public function actionShopCashConfig() {
        $this->breadcrumbs = array(Yii::t('home', '积分配置管理'), Yii::t('home', '企业会员提现配置'));
        $this->_settingConfig($this->action->id);
    }

     /**
     * 普通会员提现配置
     */
    public function actionMemberCashConfig() {
        $this->breadcrumbs = array(Yii::t('home', '积分配置管理'), Yii::t('home', '普通会员提现配置'));
        $this->_settingConfig($this->action->id);
    }
    
    /**
     * 推荐商家会员配置
     */
    public function actionRefConfig() {
        $this->breadcrumbs = array(Yii::t('home', '积分配置管理'), Yii::t('home', '推荐商家会员配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 代理分配比率设置
     */
    public function actionAgentDistConfig() {
        $this->breadcrumbs = array(Yii::t('home', '积分配置管理'), Yii::t('home', '代理分配比率设置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 支付接口配置
     */
    public function actionPayAPIConfig() {
        $this->breadcrumbs = array(Yii::t('home', '积分配置管理'), Yii::t('home', '支付接口配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 短信接口配置
     */
    public function actionSmsApiConfig() {
        $this->breadcrumbs = array(Yii::t('home', '网站配置管理'), Yii::t('home', '短信接口配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 短信模板配置
     */
    public function actionSmsModelConfig() {
        $this->breadcrumbs = array(Yii::t('home', '网站配置管理'),
            Yii::t('home', '短信模板配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 文件上传配置
     */
    public function actionUploadConfig() {
        $this->breadcrumbs = array(Yii::t('home', '网站配置管理'), Yii::t('home', '文件上传配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 系统信息
     */
    public function actionMain() {
        $this->breadcrumbs = array(Yii::t('home', '网站配置管理'), Yii::t('home', '系统信息'));
        $os = explode(" ", php_uname());
        $model = array();
        $model['webname'] = $this->getConfig('site', 'name');             //网站名称
        $model['serverip'] = $_SERVER['SERVER_NAME'] . "(" . $_SERVER['SERVER_ADDR'] . ")";       //服务器主机名称(服务器IP)
        $model['servernote'] = @php_uname();                             //服务器标示
        $model['serversys'] = $os[0];                                    //服务器操作系统
        $model['serveryq'] = $_SERVER['SERVER_SOFTWARE'];                //服务器引擎
        $model['serverlanguage'] = getenv("HTTP_ACCEPT_LANGUAGE");       //服务器语言
        $model['dotime'] = get_cfg_var("max_execution_time");            //脚本超时时间

        $this->render('sysmain', array('model' => $model));
    }

    /**
     * 文章配置
     */
    public function actionArticleConfig() {
        $this->breadcrumbs = array(Yii::t('home', '网站配置管理'), Yii::t('home', '文章配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 敏感词设置
     */
    public function actionFilterWorldConfig() {
        $this->breadcrumbs = array(Yii::t('home', '网站配置管理'), Yii::t('home', '敏感词设置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 会员升级配置
     */
    public function actionScheduleConfig() {
        $this->breadcrumbs = array(Yii::t('home', '网站配置管理'), Yii::t('home', '会员升级配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 系统任务管理
     */
    public function actionTaskConfig() {
        $this->breadcrumbs = array(Yii::t('home', '网站配置管理'), Yii::t('home', '系统任务管理'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 运费修改客服设置
     */
    public function actionFreightLinkConfig() {
        $this->breadcrumbs = array(Yii::t('home', '网站配置管理'), Yii::t('home', '运费修改客服设置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 汇率设置
     */
    public function actionRateConfig() {
        $this->breadcrumbs = array(Yii::t('home', '网站配置管理'), Yii::t('home', '汇率设置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 全局搜索热门词设置
     */
    public function actionGlobalKeyWordConfig() {
        $this->breadcrumbs = array(Yii::t('home', '网站配置管理'), Yii::t('home', '全局搜索热门词设置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 发送邮件设置
     */
    public function actionEmailConfig() {
        $this->breadcrumbs = array(Yii::t('home', '网站配置管理'), Yii::t('home', '发送邮件设置'));
        $this->_settingConfig($this->action->id);
    }
        /**
     * 发送邮件模板设置
     */
    public function actionEmailModelConfig() {
        $this->breadcrumbs = array(Yii::t('home', '网站配置管理'), Yii::t('home', '邮件模板配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 后台语言包管理
     */
    public function actionLanguageBackend() {
        $this->_ajaxLanguageChange();
        $this->breadcrumbs = array(Yii::t('home', '网站数据管理'), Yii::t('home', '多语言-后台'));
        $messagesPath = Yii::app()->basePath . '/messages/';
        @SystemLog::record(Yii::app()->user->name . "配置后台语言包：" . $messagesPath);
        $this->_manageLanguage($messagesPath);
    }

    /**
     * 前台语言包管理
     */
    public function actionLanguageFrontend() {
        $this->_ajaxLanguageChange();
        $this->breadcrumbs = array(Yii::t('home', '网站数据管理'), Yii::t('home', '多语言-前台'));
        $messagesPath = dirname(Yii::app()->basePath) . '/frontend/messages/';
        @SystemLog::record(Yii::app()->user->name . "配置前台语言包：" . $messagesPath);
        $this->_manageLanguage($messagesPath);
    }

    /**
     * api语言包管理
     */
    public function actionLanguageApi() {
        $this->_ajaxLanguageChange();
        $this->breadcrumbs = array(Yii::t('home', '网站数据管理'), Yii::t('home', '多语言-API'));
        $messagesPath = dirname(Yii::app()->basePath) . '/api/messages/';
        @SystemLog::record(Yii::app()->user->name . "配置API语言包：" . $messagesPath);
        $this->_manageLanguage($messagesPath);
    }

    /**
     * 语言包管理
     * @param string  $messagesPath 语言包的路径
     */
    private function _manageLanguage($messagesPath) {
        $messagesConfig = include $messagesPath . 'config.php';
        $languageFiles = array(); //语言包文件数组
        $result = array(); //搜索结果
        $languageDir = Tool::authcode($this->getQuery('languageList'), 'DECODE'); //语言包文件目录
        if ($languageDir && isset($_GET['keyword'])) {
            $keyword = $this->getQuery('keyword');
            //如果输入为空，则列出语言包目录文件
            foreach (scandir($languageDir) as $v) {
                if (substr($v, -3) !== 'php')
                    continue;
                $realPath = $languageDir . DS . $v;
                $languageFiles[$realPath] = $v;
                if (!empty($keyword)) {
                    $tmp = include $realPath;
                    $find = $this->_array_search($tmp, $keyword);
                    if (!empty($find)) {
                        $result[] = array('file' => Tool::authcode($realPath), 'result' => $find);
                    }
                }
            }

            //empty by condition
            if (!empty($keyword)) {
                if (empty($result))
                    $this->setFlash('error', Yii::t('home', '搜索结果为空'));
                $languageFiles = array();
            }else {
                $result = array();
            }
        }
        //语言包内容显示
        $languageArr = array(); //语言包数组
        $languageName = '';
        $file = Tool::authcode($this->getParam('languageFile'), 'DECODE');
        if (!empty($file) && !$this->isPost()) {
            $languageName = $messagesConfig['languageName'][basename(dirname($file))];
            if (!file_exists($file)) {
                Yii::app()->user->setFlash('error', Yii::t('home', '您访问的语言包文件不存在！:') . $file);
            } else {
                $languageArr = include $file;
            }
        }

        $dir = array(); //语言包目录数组
        //目录选择
        foreach (scandir($messagesPath) as $v) {
            $realPath = $messagesPath . $v;
            if (is_dir($realPath) && $v[0] != '.') {
                $dir[Tool::authcode($realPath)] = $messagesConfig['languageName'][$v];
            }
        }

        $this->render('languagemanage', array(
            'dir' => $dir,
            'result' => $result,
            'languageDir' => $languageDir,
            'languageFiles' => $languageFiles,
            'languageArr' => $languageArr,
            'languageName' => $languageName,
            'messagesConfig' => $messagesConfig,
        ));
    }

    /**
     * ajax 修改或者删除语言包文件
     */
    private function _ajaxLanguageChange() {
        if ($this->isAjax()) {
            $do = $this->getPost('do');
            $languageFile = Tool::authcode($this->getPost('languageFile'), 'DECODE');
            if ($do == 'delFile') {
                UploadedFile::delete($languageFile);
                @SystemLog::record(Yii::app()->user->name . "删除语言包：" . $languageFile);
            } else {
                $key = $this->getPost('key');
                $value = $this->getPost('value');
                if (!file_exists($languageFile))
                    return false;
                $language = include $languageFile;
                if ($do == 'update') {
                    $language[$key] = $value;
                    $languageStr = "<?php \r\n //语言包文件 \r\n";
                    $languageStr .= 'return ' . var_export($language, TRUE) . ';';
                    if (file_put_contents($languageFile, $languageStr)) {
                        @SystemLog::record(Yii::app()->user->name . "修改语言包：" . $languageFile);
                        echo Yii::t('home', '修改语言包成功');
                    } else {
                        echo Yii::t('home', '修改语言包失败');
                    }
                }
                if ($do == 'del') {
                    unset($language[$key]);
                    $languageStr = "<?php \r\n //语言包文件 \r\n";
                    $languageStr .= 'return ' . var_export($language, TRUE) . ';';
                    if (!file_put_contents($languageFile, $languageStr))
                        echo Yii::t('home', '删除语言包失败');

                    @SystemLog::record(Yii::app()->user->name . "删除语言包：" . $languageFile);
                }
            }
            exit;
        }
    }

    /**
     * 搜索数组中的键值
     * @param array $arr
     * @param string $needle
     * @return array
     */
    private function _array_search(Array $arr, $needle) {
        $result = array();
        foreach ($arr as $k => $v) {
            if (stripos($k, $needle) !== false || stripos($v, $needle) !== false) {
                $result[$k] = $v;
            }
        }
        return $result;
    }

    /**
     * 前台语言包管理
     */
    public function actionCreateFrontPackFromDb() {
        $this->createEnglishPackage(0);
    }

    /**
     * 后台语言包管理
     */
    public function actionCreateBackPackFromDb() {
        $this->createEnglishPackage(1);
    }

    /**
     * api语言包管理
     */
    public function actionCreateApiPackFromDb() {
        $this->createEnglishPackage(3);
//        $this->createEnglish(0);
//        $this->createEnglish(1);
//        $this->createEnglish(3);
//        $this->createEnglish(9);
    }

    /**
     * 生成语言包
     * @param bool $isBackend 后台
     */
    public function createEnglishPackage($isBackend = 0) {
        $return = '';
//        $dir = $isBackend ? 'backend' : 'frontend';
        switch ($isBackend) {
            case 0: $dir = 'frontend';
                break;
            case 1: $dir = 'backend';
                break;
            case 3: $dir = 'api';
                break;
            default : $dir = 'backend';
                break;
        }
        $path = Yii::getPathOfAlias('root') . DS . $dir . DS . 'messages' . DS . 'en' . DS;
        $dirDetail = scandir($path);
        $category = Yii::app()->db->createCommand()
                ->select('DISTINCT(category)')->from('{{translate}}')->where("`en` is not null or `en` <> '' and is_backend=0")
                ->queryColumn();
        if (!empty($category)) {
            foreach ($category as $cat) {
                if ($cat == false)
                    continue;
                $reader = $packet = $packetTemp = array();
                $packString = '';
                if (in_array($cat . '.php', $dirDetail)) {
                    $packetTemp = require $path . $cat . '.php';
                    if (!empty($packetTemp))
                        $packet = $packetTemp;
                }
                unset($packetTemp, $packString);
                $sqlFind = "select * from {{translate}} where category='{$cat}' and (`en` is not null or `en` <> '') and is_backend={$isBackend} order by category ASC";
                $command = Yii::app()->db->createCommand($sqlFind);
                $command->execute();
                $reader = $command->query();
                $finished = 0;
                foreach ($reader as $key => $row) {
                    if (!empty($row)) {
                        if (!isset($packet[$row['cn']]))
                            $packet[$row['cn']] = $row['en'];
                    }
                }
                if (!empty($packet)) {
                    $languageFile = $path . $cat . '.php';
                    $languageStr = "<?php \r\n //语言包文件 \r\n";
                    $languageStr .= 'return ' . var_export($packet, TRUE) . ';';
                    if (file_put_contents($languageFile, $languageStr)) {
                        @SystemLog::record(Yii::app()->user->name . "生成语言包：" . $languageFile);
                        $return .= "生成语言包" . $cat . "成功.\r\n";
                    } else {
                        $return .= "生成语言包" . $cat . "失败.\r\n";
                    }
                }
            }
        } else {
            $return = '暂无数据可供生成!';
        }
        echo json_encode($return);
    }

    public function createEnglish($isBackend = 0) {
        $return = '';
        switch ($isBackend) {
            case 0: $dir = 'frontend';
                break;
            case 1: $dir = 'backend';
                break;
            case 3: $dir = 'api';
                break;
            default : $dir = 'backend';
                break;
        }

        /**
         * 
         */
        $reader = $packet = array();
//                $sqlFind = "select * from {{translate}} where category='{$cat}' and (`en` is not null or `en` <> '') and is_backend={$isBackend} order by category ASC";
        $sqlFind = "SELECT DISTINCT cn,en FROM gw_translate WHERE is_backend={$isBackend} and cn<>'' and cn is NOT NULL AND category<>'region' ORDER BY cn ASC";
        if ($isBackend == 9) {
            $sqlFind = "SELECT DISTINCT cn,en FROM gw_translate WHERE cn<>'' and cn is NOT NULL AND category='region' ORDER BY cn ASC";
        }
        $command = Yii::app()->db->createCommand($sqlFind);
        $command->execute();
        $reader = $command->query();
        foreach ($reader as $key => $row) {
            if (!empty($row)) {
                if ($row['en'] == null)
                    $row['en'] = '';
                $packet[$row['cn']] = $row['en'];
            }
        }
        if (!empty($packet)) {
            $languageFile = Yii::getPathOfAlias('root') . DS . 'package' . $isBackend . '.php';
            $languageStr = "<?php \r\n //语言包文件 \r\n";
            $languageStr .= 'return ' . var_export($packet, TRUE) . ';';
            if (file_put_contents($languageFile, $languageStr)) {
//                            @SystemLog::record(Yii::app()->user->name."生成语言包：".$languageFile);
                $return .= "生成语言包" . "成功.\r\n";
            } else {
                $return .= "生成语言包" . "失败.\r\n";
            }
        }
//        echo json_encode($return);
    }

    /**
     * 线下自动对账配置
     */
    public function actionCheckConfig() {
        $this->breadcrumbs = array(Yii::t('home', '积分配置管理'), Yii::t('home', '线下自动对账配置 '));
        $this->_settingConfig($this->action->id);
    }

    /**
     * Order配置
     */
    public function actionOrderConfig() {
        $this->breadcrumbs = array(Yii::t('home', '网站配置管理'), Yii::t('home', '订单配置')); //订单设置
        $this->_settingConfig($this->action->id);
    }

    /**
     * 是否开启调用google翻译
     * @return boolean
     */
    public function actionLanguageConfig() {
        if ($_POST['tran'] == 'on') {
            $config = array('tran' => 'on');
        } elseif ($_POST['tran'] == 'off') {
            $config = array('tran' => 'off');
        } else {
            return false;
        }
        $string = serialize($config);
        $name = 'languageTranslate';
        $value = WebConfig::model()->findByAttributes(array('name' => $name));
        if ($value) {
            $webConfig = WebConfig::model();
            $webConfig->id = $value->id;
        } else {
            $webConfig = new WebConfig();
        }

        $webConfig->name = $name;
        $webConfig->value = $string;
//        $file = Yii::getPathOfAlias('common') . DS . 'webConfig' . DS . 'languageTranslate.config.inc';
        if ($webConfig->save()) {
            echo $config['tran'];
            @SystemLog::record(Yii::app()->user->name . "修改配置文件：" . $this->action->id);
        } else {
            return false;
        }
    }

    /**
     * 合约机商品id配置
     * @author binbin.liao
     * 2014-9-26
     */
    public function actionHeyuejiConfig() {
        $this->breadcrumbs = array(Yii::t('home', '合约机商品id配置'), Yii::t('home', '合约机商品id配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 代扣设置
     * @author zhenjun.xu
     */
    public function actionHistoryBalanceConfig() {
        $this->breadcrumbs = array(Yii::t('home', '积分配置管理'), Yii::t('home', '代扣设置')); //订单设置
        $this->_settingConfig($this->action->id);
    }

    /**
     * 网签合同 修改配置文件
     * 文件名规则：控制器+Config 后缀，模型+ConfigForm后缀
     *
     * @param string $actionId   $this->action->id  控制器名称
     */
    private function _settingContractConfig($actionId) {
        $modelForm = 'ContractConfigForm';
        $viewFileName = strtolower($actionId);
        $model = new $modelForm;
        $model->file = $this->getConfig($viewFileName, 'file');
        //ajax表单验证
        $this->performAjaxValidation($model);
        $oldPic = $model->file;
        if (isset($_POST[$modelForm])) {

            $model->attributes = $_POST[$modelForm];
            $saveDir = 'contract/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'file', $saveDir, Yii::getPathOfAlias('att'));
            if ($model->validate()) {
                UploadedFile::saveFile('file', $model->file, $oldPic, true);
                $string = serialize($model->attributes);
                $value = WebConfig::model()->findByAttributes(array('name' => $viewFileName));
                if ($value) {
                    $webConfig = WebConfig::model();
                    $webConfig->id = $value->id;
                } else {
                    $webConfig = new WebConfig();
                }

                $webConfig->name = $viewFileName;
                $webConfig->value = $string;
//                $file = Yii::getPathOfAlias('common') . DS . 'webConfig' . DS . $viewFileName . '.config.inc';
                if ($webConfig->save()) { //向得到的文件路劲指定的文件里面插入数据
                    if (Tool::cache($viewFileName . 'config')->get($viewFileName)) {
                        Tool::cache($viewFileName . 'config')->set($viewFileName, $string);
                    } else {
                        Tool::cache($viewFileName . 'config')->add($viewFileName, $string);
                    }
                    $this->setFlash('success', Yii::t('home', '数据保存成功'));
                    @SystemLog::record(Yii::app()->user->name . "修改配置文件：" . $this->action->id);
                } else {
                    $this->setFlash('error', Yii::t('home', '数据保存失败，请检查相关目录权限'));
                }
            }
        }
        //CActiveForm widget 参数
        $formConfig = array(
            'id' => $this->id . '-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
            'htmlOptions' => array(
                'enctype' => 'multipart/form-data'
            ),
        );

        $this->render('contractconfig', array('model' => $model, 'formConfig' => $formConfig));
    }

    /**
     * 盖网通及网店合同(收费)
     */
    public function actionContractStore() {
        $this->breadcrumbs = array(Yii::t('home', '网签合同管理'), Yii::t('home', '盖网通及网店合同'));
        $this->_settingContractConfig($this->action->id);
    }

    /**
     * 盖网通及网店合同(免费)
     */
    /** public function actionContractStore2() {
      $this->breadcrumbs = array(Yii::t('home', '网签合同管理'), Yii::t('home', '盖网通及网店合同(免费)'));
      $this->_settingContractConfig($this->action->id);
      } */

    /**
     * 网店管理规范
     */
    public function actionManagement() {
        $this->breadcrumbs = array(Yii::t('home', '网签合同管理'), Yii::t('home', '网店管理规范及合作结算流程'));
        $this->_settingContractConfig($this->action->id);
    }

    /**
     * 合作及结算流程
     */
    /** public function actionSettlement() {
      $this->breadcrumbs = array(Yii::t('home', '网签合同管理'), Yii::t('home', '合作及结算流程'));
      $this->_settingContractConfig($this->action->id);
      } */
    /**
     * 承诺书
     */
    /**   public function actionCommitment() {
      $this->breadcrumbs = array(Yii::t('home', '网签合同管理'), Yii::t('home', '承诺书'));
      $this->_settingContractConfig($this->action->id);
      } */
    /**
     * 自有品牌承诺书
     */

    /** public function actionCommitment2() {
      $this->breadcrumbs = array(Yii::t('home', '网签合同管理'), Yii::t('home', '自有品牌承诺书'));
      $this->_settingContractConfig($this->action->id);
      } */

    /**
     * 电子化签约合同模板
     * @throws Exception
     */
    public function actionOfflineSignContractConfig(){
        $this->breadcrumbs = array(Yii::t('home','电子化合同签约管理'),Yii::t('home','电子化合同签约模板'));
        $this->_settingConfig($this->action->id);

    }

    /**
     * 电子化签约 上传图片示例配置
     */
    public function actionOfflineSignDemoImgsConfig(){

        $this->breadcrumbs = array(Yii::t('home','电子化合同签约管理'),Yii::t('home','电子化合同签约上传图片示例配置'));
        
        $model = new OfflineSignDemoImgsConfigForm();
        $this->performAjaxValidation($model); //ajax表单验证
        $viewFileName = strtolower(substr($this->action->id, 0, -6));
        $model->setAttributes($this->getConfig($viewFileName),false);

        if ($this->isPost() && $model->validate()){

            //上传文件
            $saveDir =  'offline/' . date('Y/n/j');
            foreach ($model->attributes as  $field=>$v ) {
                $oldImg = $model->$field;
                $model = UploadedFile::uploadFile($model, $field, $saveDir,Yii::getPathOfAlias('uploads'));
                UploadedFile::saveFile($field, $model->$field, $oldImg, true);
            }

            //保存配置，并写入缓存
            $string = serialize($model->attributes);
            if(WebConfig::saveConfig($viewFileName,$string)){
                //向得到的文件路劲指定的文件里面插入数据
                if (Tool::cache($viewFileName . 'config')->get($viewFileName)) {
                    Tool::cache($viewFileName . 'config')->set($viewFileName, $string);
                } else {
                    Tool::cache($viewFileName . 'config')->add($viewFileName, $string);
                }
                $this->setFlash('success', Yii::t('home', '数据保存成功'));
                @SystemLog::record(Yii::app()->user->name . "修改配置文件：" . $this->action->id);
            }else {
                $this->setFlash('error', Yii::t('home', '数据保存失败，请检查相关目录权限'));
            }
        }
        $this->render(strtolower($this->action->id), array('model' => $model));
    }

    /*
     * 红包配置管理,因为接口那边需要用到二维数组的数据结构所以不使用通用的方法
     */

    public function actionHongbaoConfig() {
        $this->breadcrumbs = array(Yii::t('home', '网站数据管理'), Yii::t('home', '红包配置管理')); //红包配置
        $name = 'hongbao';
        $model = new HongbaoConfigForm;
        $allData = $this->getConfig('hongbao');


        if ($allData) {
            foreach ($allData['items'] as $key => $v) {
                $money = "money" . $v['id'];
                $ratio = "ratio" . $v['id'];
                $model->$money = $v['money'];
                $model->$ratio = $v['ratio'];
            }
            $model->rules = $allData['rules'];
        }
        //ajax表单验证
        $this->performAjaxValidation($model);

        if (isset($_POST['HongbaoConfigForm'])) {
            $data = $this->getPost('HongbaoConfigForm');
            $model->attributes = $data;

            if ($model->validate()) {
                $tmpArray = array();
                foreach ($data as $key => $v) {
                    switch ($key) {
                        case 'money1':
                            $tmpArray[1]['id'] = 1;
                            $tmpArray[1]['money'] = $v;
                            break;
                        case 'money2':
                            $tmpArray[2]['id'] = 2;
                            $tmpArray[2]['money'] = $v;
                            break;
                        case 'money3':
                            $tmpArray[3]['id'] = 3;
                            $tmpArray[3]['money'] = $v;
                            break;
                        case 'money4':
                            $tmpArray[4]['id'] = 4;
                            $tmpArray[4]['money'] = $v;
                            break;
                        case 'money5':
                            $tmpArray[5]['id'] = 5;
                            $tmpArray[5]['money'] = $v;
                            break;
                        case 'money6':
                            $tmpArray[6]['id'] = 6;
                            $tmpArray[6]['money'] = $v;
                            break;
                        case 'ratio1':
                            $tmpArray[1]['ratio'] = $v;
                            break;
                        case 'ratio2':
                            $tmpArray[2]['ratio'] = $v;
                            break;
                        case 'ratio3':
                            $tmpArray[3]['ratio'] = $v;
                            break;
                        case 'ratio4':
                            $tmpArray[4]['ratio'] = $v;
                            break;
                        case 'ratio5':
                            $tmpArray[5]['ratio'] = $v;
                            break;
                        case 'ratio6':
                            $tmpArray[6]['ratio'] = $v;
                            break;
                    }
                }
                $saveArray = array('items' => $tmpArray, 'rules' => preg_replace('/<|>|\//', '', $data['rules']));
                $string = serialize($saveArray);

                $value = WebConfig::model()->findByAttributes(array('name' => $name));
                if ($value) {
                    $webConfig = WebConfig::model();
                    $webConfig->id = $value->id;
                } else {
                    $webConfig = new WebConfig();
                }

                $webConfig->name = $name;
                $webConfig->value = $string;

//                $file = Yii::getPathOfAlias('common') . DS . 'webConfig' . DS . 'hongbao' . '.config.inc';
//                Tool::p($file);exit;
                if ($webConfig->save()) { //向得到的文件路劲指定的文件里面插入数据                   
                    if (Tool::cache($name . 'config')->get($name)) {
                        Tool::cache($name . 'config')->set($name, $string);
                    } else {
                        Tool::cache($name . 'config')->add($name, $string);
                    }
                     RedEnvelopeTool::createCacheLottery(); //更新缓存
                    $this->setFlash('success', Yii::t('home', '数据保存成功'));
                    @SystemLog::record(Yii::app()->user->name . "修改配置文件：" . $this->action->id);
                } else {
                    $this->setFlash('error', Yii::t('home', '数据保存失败，请检查相关目录权限'));
                }
            }
        }

        //CActiveForm widget 参数
        $formConfig = array(
            'id' => 'home-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        );
        $this->render('hongbaoconfig', array('model' => $model, 'formConfig' => $formConfig));
    }


    /*
     * 商城首页顶部导航设置
     * author qinbao.deng
     */
    public function actionNavigationConfig() {
        $this->breadcrumbs = array(Yii::t('home', '广告管理'), Yii::t('home', '导航')); //红包配置
        $key = 'navigation';
        $allData = $this->getConfig('navigation');

        if (!empty($_POST)) {
            $name = $this->getPost('Name');
            $title = $this->getPost('Title');
            $link = $this->getPost('Link');
            $treeData = array();

            if(!empty($name)){
                for($i = 0; $i < count($name); $i++){
                    $treeData[$i]['name'] = $name[$i];
                    $treeData[$i]['title'] = $title[$i];
                    $treeData[$i]['link'] = $link[$i];
                }
            }

            $strData = serialize($treeData);

                $value = WebConfig::model()->findByAttributes(array('name' => $key));
                if ($value) {
                    $webConfig = WebConfig::model();
                    $webConfig->id = $value->id;
                } else {
                    $webConfig = new WebConfig();
                }

                $webConfig->name = $key;
                $webConfig->value = $strData;

                if ($webConfig->save()) { //向得到的文件路劲指定的文件里面插入数据
                    if (Tool::cache($key . 'config')->get($key)) {
                        Tool::cache($key . 'config')->set($key, $strData);
                    } else {
                        Tool::cache($key . 'config')->add($key, $strData);
                    }
//                    RedEnvelopeTool::createCacheLottery(); //更新缓存
                    $this->setFlash('success', Yii::t('home', '数据保存成功'));
                    @SystemLog::record(Yii::app()->user->name . "修改配置文件：" . $this->action->id);
                } else {
                    $this->setFlash('error', Yii::t('home', '数据保存失败，请检查相关目录权限'));
                }
            $allData = $treeData;
        }

        $this->render('navigationconfig', array('allData' => $allData));
    }


    /**
     * 首页楼层设置
     */
    public function actionFloorConfig() {
        $this->breadcrumbs = array(Yii::t('home', '网站配置管理'), Yii::t('home', '首页楼层设置'));
        $this->_settingConfig($this->action->id);
    }

    /*
     * 盖付通-银行卡支付方式设置
     */

    public function actionPayMentlistConfig()
    {
        $this->breadcrumbs = array(Yii::t('home', '盖付通配置管理'), Yii::t('home', '银行卡支付设置'));
        $this->_settingConfig($this->action->id);
    }

    /*
     * 盖付通-是否开启菜单选项设置
     */
    public function actionGftMenuConfig()
    {
        $this->breadcrumbs = array(Yii::t('home', '盖付通配置管理'), Yii::t('home', '是否开启菜单选项'));
        $this->_settingConfig($this->action->id);
    }

    /*
     * 该掌柜-银行卡支付方式设置
     */
    public function actionGzgPayMentlistConfig()
    {
        $this->breadcrumbs = array(Yii::t('home', '该掌柜配置管理'), Yii::t('home', '银行卡支付设置'));
        $this->_settingConfig($this->action->id);
    }
    
    
    /**
     * 企业会员提现白名单
     * @author wyee
     */
    public function actionCashHistoryConfig() {
    	$this->breadcrumbs = array(Yii::t('home', '积分配置管理'), Yii::t('home', '提现白名单')); //订单设置
    	$this->_settingConfig($this->action->id);
    }
    

}
