<?php
/**
 * 游戏配置控制器
 * @author: xiaoyan.luo
 * @mail: xiaoyan.luo@g-emall.com
 * Date: 2015/9/18 9:58
 */
class GameConfigController extends Controller{
    public $result; //判断是否执行成功
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
        $viewFileName = strtolower($actionId);
        $name = substr($viewFileName, 0, -6);
        $formName = ucfirst($this->id);
        $model = GameConfig::model()->findByAttributes(array('config_name' => $name));
        if(empty($model))$model = new GameConfig();

        //ajax表单验证
        $this->performAjaxValidation($model);

        if (isset($_POST[$formName])) {
            $model->attributes = $_POST[$formName];
            if ($model->validate()) {
                $value = $_POST[$formName]['value'];
                $value = str_replace(" ", "", strip_tags(html_entity_decode($value)));
                $model = GameConfig::model()->findByAttributes(array('config_name' => $name,'app_type' => $_POST[$formName]['app_type']));
                if ($model) {
                    $gameConfig = GameConfig::model();
                    $gameConfig->id = $model->id;
                } else {
                    $gameConfig = new GameConfig();
                }
                $gameConfig->app_type = $_POST[$formName]['app_type'];
                $gameConfig->config_name = $_POST[$formName]['config_name'];
                $gameConfig->value = $value;

//                $file = Yii::getPathOfAlias('common') . DS . 'webConfig' . DS . $viewFileName . '.config.inc';
                if ($gameConfig->save()) { //向得到的文件路劲指定的文件里面插入数据
                    if (Tool::cache($viewFileName . 'config')->get($viewFileName)) {
                        Tool::cache($viewFileName . 'config')->set($viewFileName, $value, 86400);
                    } else {
                        Tool::cache($viewFileName . 'config')->add($viewFileName, $value, 86400);
                    }
                    $json = htmlspecialchars_decode(strip_tags(str_replace('&nbsp;','',$value)));
                    //更新orderapi项目redis网站配置缓存@author xiaoyan.luo
                    Tool::orderApiPost('config/updateCache',array('configName' => $viewFileName, 'value' => $json));
                    $this->setFlash('success', Yii::t('home', '数据保存成功'));
                    $model = $gameConfig;//显示保存后的数据
		            $this->result = true;//保卫师傅游戏用
                    //@SystemLog::record(Yii::app()->user->name . "修改游戏配置文件：" . $this->action->id);
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
     * 积分兑换金币开关用
     * 修改配置文件，
     * 文件名规则：控制器+Config 后缀，模型+ConfigForm后缀
     *
     * @param string $actionId   $this->action->id  控制器名称
     */
    private function _gameConfig($actionId) {
        $viewFileName = strtolower($actionId);
        $name = substr($viewFileName, 0, -6);
        $formName = ucfirst($this->id);
        //对app_type作判断，因为之前已有三国跑跑记录，现改为通用
        $model = GameConfig::model()->findByAttributes(array('config_name' => $name),
            "app_type=:app_type OR app_type=:app_type2",array('app_type'=>AppVersion::APP_TYPE_GAME_SANGUORUN,'app_type2'=>AppVersion::APP_TYPE_GAME_SWITCH));
        if(empty($model)){
            $model = new GameConfig();
            $switch = "";
        }else{
            $switch = $model->value===0 ? "" : json_decode($model->value,true);
        }

        //ajax表单验证
        $this->performAjaxValidation($model);

        if (isset($_POST[$formName])) {
            $model->attributes = $_POST[$formName];
            if ($model->validate()) {
                $value = isset($_POST['Switch'])?json_encode($_POST['Switch']):0;
                $model->app_type = $_POST[$formName]['app_type'];
                $model->config_name = $_POST[$formName]['config_name'];
                $model->value = $value;

//                $file = Yii::getPathOfAlias('common') . DS . 'webConfig' . DS . $viewFileName . '.config.inc';
                if ($model->save()) { //向得到的文件路劲指定的文件里面插入数据
                    if (Tool::cache($viewFileName . 'config')->get($viewFileName)) {
                        Tool::cache($viewFileName . 'config')->set($viewFileName, $value, 86400);
                    } else {
                        Tool::cache($viewFileName . 'config')->add($viewFileName, $value, 86400);
                    }
                    //更新orderapi项目redis网站配置缓存@author xiaoyan.luo
                    Tool::orderApiPost('config/updateCache',array('configName' => $viewFileName, 'value' => $value));
                    $this->setFlash('success', Yii::t('home', '数据保存成功'));
                    $switch = isset($_POST['Switch']) ? $_POST['Switch'] : "";
                    //@SystemLog::record(Yii::app()->user->name . "修改游戏配置文件：" . $this->action->id);
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
        $this->render(strtolower($actionId), array('switch'=>$switch,'model' => $model, 'formConfig' => $formConfig));
    }

    /**
     * 三国跑跑概率表配置
     */
    public function actionMultipleConfig() {
        $this->breadcrumbs = array(Yii::t('home', '游戏配置管理'), Yii::t('home', '三国跑跑概率表配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 三国跑跑房间表配置
     */
    public function actionRoomConfig() {
        $this->breadcrumbs = array(Yii::t('home', '游戏配置管理'), Yii::t('home', '三国跑跑房间表配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 三国跑跑积分兑金币开关
     */
    public function actionSwitchConfig(){
        $this->breadcrumbs =  array(Yii::t('home', '游戏配置管理'), Yii::t('home', '三国跑跑积分兑换金币开关'));
        $this->_gameConfig($this->action->id);
    }

    /**
     * 啪啪萌僵尸游戏配置
     */
    public function actionPaipaimengConfig() {
        $this->breadcrumbs = array(Yii::t('home', '游戏配置管理'), Yii::t('home', '啪啪萌僵尸游戏配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 盖付通黄金矿工游戏配置(物品装备及价格)
     */
    public function actionMinerConfig() {
        $this->breadcrumbs = array(Yii::t('home', '游戏配置管理'), Yii::t('home', '黄金矿工游戏配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 盖付通黄金矿工游戏配置(物品装备及价格)
     */
    public function actionGoldenConfig() {
        $this->breadcrumbs = array(Yii::t('home', '游戏配置管理'), Yii::t('home', '黄金矿工游戏配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 神偷莉莉游戏配置
     */
    public function actionShentouliliConfig() {
        $this->breadcrumbs = array(Yii::t('home', '游戏配置管理'), Yii::t('home', '神偷莉莉游戏配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 弹跳公主游戏配置
     */
    public function actionTantiaogongzhuConfig() {
        $this->breadcrumbs = array(Yii::t('home', '游戏配置管理'), Yii::t('home', '弹跳公主游戏配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 美女走钢丝游戏配置
     */
    public function actionZougangsiConfig() {
        $this->breadcrumbs = array(Yii::t('home', '游戏配置管理'), Yii::t('home', '美女走钢丝游戏配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 撤销兑换的金币
     */
    public function actionRevokeGold(){
        $model = new GameExpend;
        //ajax表单验证
        $this->performAjaxValidation($model);

        if(isset($_POST['GameExpend'])){
            $model->attributes = $this->getParam('GameExpend');
            if($model->validate()){
                $sql = "SELECT id,member_id,gai_number,gold_num FROM game.gw_game_member WHERE gai_number ='" . $model->member_id . "'";
                $member = Yii::app()->db->createCommand($sql)->queryRow();

                if(!empty($member)){
                    if($member['gold_num'] >= $model->expenditure){
                        //插入流水
                        $time = time();
                        $request = json_encode('撤销金币:'.$model->expenditure.',执行者ID:'.Yii::app()->user->id);
                        $expendData = array(
                            'member_id'=>$member['member_id'],
                            'game_type'=>'0',
                            'expenditure'=>$model->expenditure,
                            'gold_num'=>$member['gold_num'],
                            'request'=>$request,
                            'result'=>$this->getUser()->id,
                            'result_code'=>'0',
                            'create_time'=>$time,
                            'update_time'=>$time,
                        );
                        $id = GameExpend::insert($expendData,'gw_game_expend');

                        //扣除金币
                        $goldNum = $member['gold_num'] - $model->expenditure;
                        $memberData = array(
                            'gold_num'=>$goldNum
                        );
                        $condition = array(
                            'member_id'=>$member['member_id']
                        );
                        GameExpend::update('gw_game_member', $memberData, $condition);

                        //验证
                        $sql2 = "SELECT gold_num FROM game.gw_game_member WHERE gai_number = '" . $model->member_id . "'";
                        $goldNum2 = Yii::app()->db->createCommand($sql2)->queryScalar();
                        if($goldNum == $goldNum2){
                            $upData = array(
                                'gold_num'=>$goldNum,
                                'result_code'=>1,
                                'update_time'=>time()
                            );
                            $upCondition = array(
                                'id'=> $id
                            );
                            GameExpend::update('gw_game_expend', $upData, $upCondition);
                            $this->setFlash('success', Yii::t('home', '操作成功'));

                        }else{
                            $this->setFlash('error', Yii::t('home', '操作失败'));
                        }

                    }else{
                        $this->setFlash('error', Yii::t('home', '金币不足'));
                    }
                }else{
                    $this->setFlash('error', Yii::t('home', '不存在该会员'));
                }
            }
        }

        $this->render('_form', array('model'=>$model));
    }

    /**
     * 撤销兑换金币列表
     */
    public function actionRevokeGoldList(){
        $model = new GameExpend;
        $model->unsetAttributes();
        $condition = '';//条件
        $pageSize = 13;//每页显示最大个数
        $limit = "LIMIT 0," . $pageSize;
        if(isset($_GET['page']) && $_GET['page'] <> 1){
            $start = ($_GET['page'] -1) * $pageSize;
            $limit = "LIMIT " . $start . "," . $pageSize;
        }
        if(isset($_POST['GameExpend']) && $_POST['GameExpend']['member_id'] <> ''){
            $model->attributes = $this->getParam('GameExpend');
            $condition = "AND m.gai_number LIKE '%" . $model->member_id . "%' ";
        }
        $sql= "SELECT e.member_id,e.expenditure,e.gold_num,e.result_code,e.create_time,m.gai_number,u.username
              FROM game.gw_game_expend AS e LEFT JOIN game.gw_game_member AS m ON e.member_id=m.member_id LEFT JOIN gw_user u ON e.result = u.id WHERE e.game_type = 0 " .$condition . " ORDER BY e.create_time DESC " . $limit;
        $data = Yii::app()->db->createCommand($sql)->queryAll();

        // 分页
        $sqlCount= "SELECT e.id FROM game.gw_game_expend AS e LEFT JOIN game.gw_game_member AS m ON e.member_id=m.member_id WHERE e.game_type = 0 " .$condition;
        $dataCount = Yii::app()->db->createCommand($sqlCount)->queryAll();
        $count = count($dataCount);
        $pager = new CPagination($count);
        $pager->pageSize = 13;
//        $pager->applyLimit();

        $this->render('index', array('model'=>$model, 'data'=>$data, 'pages'=>$pager));
    }

    
    /**
     * 绿光配置
     */
    public function actionLvguangConfig() {
        $this->breadcrumbs = array(Yii::t('home', '游戏配置管理'), Yii::t('home', '绿光游戏配置'));
        $this->_settingConfig($this->action->id);
    }
    
    /**
     * 猴犀利配置
     */
    public function actionHousaileiConfig() {
        $this->breadcrumbs = array(Yii::t('home', '游戏配置管理'), Yii::t('home', '猴犀利游戏配置'));
        $this->_settingConfig($this->action->id);
    }
    
    /**
     * 熊孩子逃学记配置
     */
    public function actionXionghaiziConfig() {
        $this->breadcrumbs = array(Yii::t('home', '游戏配置管理'), Yii::t('home', '熊孩子逃学记配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 超神特工配置
     */
    public function actionJumpConfig() {
        $this->breadcrumbs = array(Yii::t('home', '游戏配置管理'), Yii::t('home', '超神特工配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 保卫师傅配置
     */
    public function actionSkillConfig(){
        $this->breadcrumbs = array(Yii::t('home', '游戏配置管理'), Yii::t('home', '保卫师傅技能配置'));
        $this->_settingConfig($this->action->id);

        if($this->result){
            $skillArr = array();
            if(Tool::cache('skillconfigconfig')->get('skillconfig')){//从缓存取数据

                $skillArr = json_decode(Tool::cache('skillconfigconfig')->get('skillconfig') ,true);
                if(!empty($skillArr)){
                    foreach($skillArr as $v){
                        $skillId = Yii::app()->db->createCommand()->select('id')->from(GAME . '.gw_game_skill')->where('skill_id=:skill_id',                                    array('skill_id'=>$v['id']))->queryScalar();

                        if($skillId){
                            Yii::app()->db->createCommand()->update(GAME . '.gw_game_skill',array('type'=>$v['type'],                                                    'value_type'=>$v['valueType'],'value'=>$v['value'],'content'=>$v['type']==2 ? json_encode($v['content']) : $v['content']),                            "id='{$skillId}'");
                        }else{
                            Yii::app()->db->createCommand()->insert(GAME . '.gw_game_skill', array(
                                'skill_id' => $v['id'],
                                'type' => $v['type'],
                                'value_type' => $v['valueType'],
                                'value' =>$v['value'],
                                'content'=>$v['type']==2 ? json_encode($v['content']) : $v['content']
                            ));
                        }
                    }
                }

            }else{//从数据库取数据

                $rs = GameConfig::model()->findByAttributes(array('app_type'=>AppVersion::APP_TYPE_GAME_BAOWEISHIFU,                                                 'config_name'=>'skill'));
                $skillArr = json_decode($rs->value, true);
                if(!empty($skillArr)){
                    foreach($skillArr as $v){
                        $skillId = Yii::app()->db->createCommand()->select('id')->from(GAME . '.gw_game_skill')->where('skill_id=:skill_id',                                   array('skill_id'=>$v['id']))->queryScalar();
                        if($skillId){
                            Yii::app()->db->createCommand()->update(GAME . '.gw_game_skill',array('type'=>$v['type'],                                                               'value_type'=>$v['valueType'],'value'=>$v['value'],'content'=>$v['type']==2 ? json_encode($v['content']) : $v['content']),                            "id='{$skillId}'");
                        }else{
                            Yii::app()->db->createCommand()->insert(GAME . '.gw_game_skill', array(
                                'skill_id' => $v['id'],
                                'type' => $v['type'],
                                'value_type' => $v['valueType'],
                                'value' =>$v['value'],
                                'content'=>$v['type']==2 ? json_encode($v['content']) : $v['content']
                            ));
                        }
                    }
                }
            }
            $this->result = false;

        }
    }
    /**
     * 兽人来了配置
     */
    public function actionShourenlaileConfig() {
        $this->breadcrumbs = array(Yii::t('home', '游戏配置管理'), Yii::t('home', '兽人来了配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 大冒险配置
     */
    public function actionDamaoxianConfig() {
        $this->breadcrumbs = array(Yii::t('home', '游戏配置管理'), Yii::t('home', '大冒险配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 狗狗别作死配置
     */
    public function actionGougouConfig() {
        $this->breadcrumbs = array(Yii::t('home', '游戏配置管理'), Yii::t('home', '狗狗别作死配置'));
        $this->_settingConfig($this->action->id);
    }
    /**
     * 保卫师傅配置
     */
    public function actionBaoweishifuConfig() {
        $this->breadcrumbs = array(Yii::t('home', '游戏配置管理'), Yii::t('home', '保卫师傅配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 深入敌后配置
     */
    public function actionShenrudihouConfig() {
        $this->breadcrumbs = array(Yii::t('home', '游戏配置管理'), Yii::t('home', '深入敌后配置'));
        $this->_settingConfig($this->action->id);
    }
    /**
     * 进击魔王配置
     */
    public function actionJinjimowangConfig() {
        $this->breadcrumbs = array(Yii::t('home', '游戏配置管理'), Yii::t('home', '进击魔王配置'));
        $this->_settingConfig($this->action->id);
    }


    /**
     * 大鱼吃小鱼配置
     */
    public function actionDayuchixiaoyuConfig() {
        $this->breadcrumbs = array(Yii::t('home', '游戏配置管理'), Yii::t('home', '大鱼吃小鱼配置'));
        $this->_settingConfig($this->action->id);
    }

    /**
     * 盖付通大乱斗配置
     */

    public function actionDaluandouConfig(){
        $this->breadcrumbs = array(Yii::t('home', '游戏配置管理'), Yii::t('home', '盖付通大乱斗配置'));
        $this->_settingConfig($this->action->id);
    }
    
    
    /**
     * 宅男与女仆配置
     */
    public function actionZhainanyunvpuConfig(){
        $this->breadcrumbs = array(Yii::t('home','游戏配置管理'),Yii::t('home','宅男与女仆配置'));
        $this->_settingConfig($this->action->id);
    }
    
    /**
     * 逃出动物园配置
     */
      public function actionTaochudongwuyuanConfig(){
          $this->breadcrumbs = array(Yii::t('home','游戏配置管理'),Yii::t('home','逃出动物园配置'));
          $this->_settingConfig($this->action->id);
      }
}