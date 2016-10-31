<?php
/**
 * 秒杀活动控制器
 * 操作:{活动首页,活动的}
 * @author wenhao_li <wenhao.li@g-emall.com>
 */
class SecondKillActivityController extends Controller {
   
    public static $mime = array('image/gif', 'image/jpeg', 'image/png');
	public $maxLimit = 1000;
    
	public function filters() {
        return array(
            'rights',
        );
    }
	
	/**
	* 是否有权查看秒杀的  活动详情
	*/
	public function actionSeting(){
		//空函数,用做权限判断
	}
	
	/**
	* 是否有权查修改红包活动规则
	*/
	public function actionEdit1(){
		//空函数,用做权限判断
	}
	
	/**
	* 是否有权查修改应节性活动规则
	*/
	public function actionEdit2(){
		//空函数,用做权限判断
	}
	
	/**
	* 是否有权查修改秒杀活动规则
	*/
	public function actionEdit3(){
		//空函数,用做权限判断
	}
    
    /**
     * 创建红包活动
     * 
     */
    public function actionCreate1() {
        $model      = new SeckillRulesSeting;
        $categoryId = $this->getParam('category_id');
        $rulesId    = $this->getParam('rules_id');
        
		$model->scenario = 'rulesCreate';
        $this->performAjaxValidation($model);
		$this->checkPostRequest();
        if (isset($_POST['SeckillRulesSeting'])) {//添加活动规则

            $postArray = $_POST['SeckillRulesSeting'];
            $model->attributes = $postArray;
            
			//上传图片限制(由于规则不起作用且没找到原因,暂时这样解决)
			$m1 = 1024*1024;//1M
			$m3 = 1024*1204*3;//3M
			$att1 = CUploadedFile::getInstanceByName('SeckillRulesSeting[picture]');
			if($att1 && $att1->size > $m1 ){

				$this->setFlash('success', Yii::t('secondKillActivity','活动图片 大于1M,请重新上传.') );
				$this->redirect(array('create1', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			if($att1 && !in_array($att1->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','活动图片 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('create1', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			$att2 = CUploadedFile::getInstanceByName('SeckillRulesSeting[banner1]');
			if($att2 && $att2->size > $m3){
				$this->setFlash('success', Yii::t('secondKillActivity','主图 大于3M,请重新上传.') );  
				$this->redirect(array('create1', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			if($att2 && !in_array($att2->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','主图 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('create1', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			$att3 = CUploadedFile::getInstanceByName('SeckillRulesSeting[banner2]');
			if($att3 && $att3->size > $m3){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图1 大于3M,请重新上传.') );  
				$this->redirect(array('create1', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			if($att3 && !in_array($att3->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图1 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('create1', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			$att4 = CUploadedFile::getInstanceByName('SeckillRulesSeting[banner3]');
			if($att4 && $att4->size > $m3){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图2 大于3M,请重新上传.') );  
				$this->redirect(array('create1', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			if($att4 && !in_array($att4->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图2 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('create1', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			$att5 = CUploadedFile::getInstanceByName('SeckillRulesSeting[banner4]');
			if($att5 && $att5->size > $m3){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图3 大于3M,请重新上传.') );  
				$this->redirect(array('create1', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			if($att5 && !in_array($att5->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图3 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('create1', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			$saveDir = 'seckill/' . date('Y/n/j');
            $model   = UploadedFile::uploadFile($model, 'picture', $saveDir);
            $model   = UploadedFile::uploadFile($model, 'banner1', $saveDir);
            $model   = UploadedFile::uploadFile($model, 'banner2', $saveDir);
            $model   = UploadedFile::uploadFile($model, 'banner3', $saveDir);
            $model   = UploadedFile::uploadFile($model, 'banner4', $saveDir);
            
            $postArray['picture']     = $model->picture;
            $postArray['banner1']     = $model->banner1;
            $postArray['banner2']     = $model->banner2;
            $postArray['banner3']     = $model->banner3;
            $postArray['banner4']     = $model->banner4;
            $postArray['category_id'] = $categoryId;
            $postArray['rules_id']    = intval($rulesId);
			
			if($categoryId != SeckillRulesSeting::SECKILL_CATEGORY_THREE){
			    $postArray['sort']        = $postArray['sort']>10000 ? 10000 : $postArray['sort'];
			}

			$model->createRules($postArray);
            $model->updateCache(0);//更新前台缓存
            
            // 保存图片文件
            UploadedFile::saveFile('picture', $model->picture); 
            if($postArray['banner1']){//若有上传banner图片,则保存文件
                UploadedFile::saveFile('banner1', $model->banner1);
            }
            if($postArray['banner2']){//若有上传banner图片,则保存文件
                UploadedFile::saveFile('banner2', $model->banner2);
            }
            if($postArray['banner3']){//若有上传banner图片,则保存文件
                UploadedFile::saveFile('banner3', $model->banner3);
            }
            if($postArray['banner4']){//若有上传banner图片,则保存文件
                UploadedFile::saveFile('banner4', $model->banner4);
            }
            
            @SystemLog::record(Yii::app()->user->name . $categoryId==SeckillRulesSeting::SECKILL_CATEGORY_THREE ? "添加秒杀设置 :{$rulesId}" :"添加活动：$postArray[name]");
            $this->setFlash('success', Yii::t('secondKillActivity', $categoryId==SeckillRulesSeting::SECKILL_CATEGORY_THREE ? "秒杀设置成功" : "添加{$model->name}活动成功！"));
            
			$adminAct = $categoryId == SeckillRulesSeting::SECKILL_CATEGORY_ONE ? 'RedAdmin' : ( $categoryId == SeckillRulesSeting::SECKILL_CATEGORY_TWO ? 'FestiveAdmin' :'SeckillAdmin');
            $this->redirect(array($adminAct, 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
        }
        
        $model->rulesId    = intval($rulesId);
        $model->categoryId = intval($categoryId);
        $this->render('create', array(
            'model' => $model,
            'labels' => $model->attributeLabels(),
        ));
    }
	
	/**
     * 创建应节性活动
     * 
     */
    public function actionCreate2() {
        $model      = new SeckillRulesSeting;
        $categoryId = $this->getParam('category_id');
        $rulesId    = $this->getParam('rules_id');


		$model->scenario = 'rulesCreate';
        $this->performAjaxValidation($model);
		$this->checkPostRequest();
        if (isset($_POST['SeckillRulesSeting'])) {//添加活动规则

            $postArray = $_POST['SeckillRulesSeting'];
            $model->attributes = $postArray;
//            var_dump($postArray);exit;

			//上传图片限制(由于规则不起作用且没找到原因,暂时这样解决)
			$m1 = 1024*1024;//1M
			$m3 = 1024*1204*3;//3M
			$att1 = CUploadedFile::getInstanceByName('SeckillRulesSeting[picture]');
			if($att1 && $att1->size > $m1 ){
				$this->setFlash('success', Yii::t('secondKillActivity','活动图片 大于1M,请重新上传.') );  
				$this->redirect(array('create2', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			if($att1 && !in_array($att1->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','活动图片 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('create2', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			$att2 = CUploadedFile::getInstanceByName('SeckillRulesSeting[banner1]');
			if($att2 && $att2->size > $m3){
				$this->setFlash('success', Yii::t('secondKillActivity','主图 大于3M,请重新上传.') );  
				$this->redirect(array('create2', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			if($att2 && !in_array($att2->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','主图 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('create2', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			$att3 = CUploadedFile::getInstanceByName('SeckillRulesSeting[banner2]');
			if($att3 && $att3->size > $m3){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图1 大于3M,请重新上传.') );  
				$this->redirect(array('create2', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			if($att3 && !in_array($att3->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图1 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('create2', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			$att4 = CUploadedFile::getInstanceByName('SeckillRulesSeting[banner3]');
			if($att4 && $att4->size > $m3){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图2 大于3M,请重新上传.') );  
				$this->redirect(array('create2', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			if($att4 && !in_array($att4->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图2 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('create2', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			$att5 = CUploadedFile::getInstanceByName('SeckillRulesSeting[banner4]');
			if($att5 && $att5->size > $m3){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图3 大于3M,请重新上传.') );  
				$this->redirect(array('create2', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			if($att5 && !in_array($att5->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图3 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('create2', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			$saveDir = 'seckill/' . date('Y/n/j');
            $model   = UploadedFile::uploadFile($model, 'picture', $saveDir);
            $model   = UploadedFile::uploadFile($model, 'banner1', $saveDir);
            $model   = UploadedFile::uploadFile($model, 'banner2', $saveDir);
            $model   = UploadedFile::uploadFile($model, 'banner3', $saveDir);
            $model   = UploadedFile::uploadFile($model, 'banner4', $saveDir);
            
            $postArray['picture']     = $model->picture;
            $postArray['banner1']     = $model->banner1;
            $postArray['banner2']     = $model->banner2;
            $postArray['banner3']     = $model->banner3;
            $postArray['banner4']     = $model->banner4;
            $postArray['category_id'] = $categoryId;
            $postArray['rules_id']    = intval($rulesId);
			
			if($categoryId != SeckillRulesSeting::SECKILL_CATEGORY_THREE){
			    $postArray['sort']        = $postArray['sort']>10000 ? 10000 : $postArray['sort'];
			}

			$model->createRules($postArray);
            $model->updateCache(0);//更新前台缓存
            
            // 保存图片文件
            UploadedFile::saveFile('picture', $model->picture); 
            if($postArray['banner1']){//若有上传banner图片,则保存文件
                UploadedFile::saveFile('banner1', $model->banner1);
            }
            if($postArray['banner2']){//若有上传banner图片,则保存文件
                UploadedFile::saveFile('banner2', $model->banner2);
            }
            if($postArray['banner3']){//若有上传banner图片,则保存文件
                UploadedFile::saveFile('banner3', $model->banner3);
            }
            if($postArray['banner4']){//若有上传banner图片,则保存文件
                UploadedFile::saveFile('banner4', $model->banner4);
            }
            
            @SystemLog::record(Yii::app()->user->name . $categoryId==SeckillRulesSeting::SECKILL_CATEGORY_THREE ? "添加秒杀设置 :{$rulesId}" :"添加活动：$postArray[name]");
            $this->setFlash('success', Yii::t('secondKillActivity', $categoryId==SeckillRulesSeting::SECKILL_CATEGORY_THREE ? "秒杀设置成功" : "添加{$model->name}活动成功！"));
            
			$adminAct = $categoryId == SeckillRulesSeting::SECKILL_CATEGORY_ONE ? 'RedAdmin' : ( $categoryId == SeckillRulesSeting::SECKILL_CATEGORY_TWO ? 'FestiveAdmin' :'SeckillAdmin');
            $this->redirect(array($adminAct, 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
        }
        
        $model->rulesId    = intval($rulesId);
        $model->categoryId = intval($categoryId);
        $this->render('create', array(
            'model' => $model,
            'labels' => $model->attributeLabels(),
        ));
    }
	
	/**
     * 创建秒杀活动
     * 
     */
    public function actionCreate3() {
        $model      = new SeckillRulesSeting;
        $categoryId = $this->getParam('category_id');
        $rulesId    = $this->getParam('rules_id');
        
		$model->scenario = 'rulesSeckill';
        $this->performAjaxValidation($model);
		$this->checkPostRequest();
        if (isset($_POST['SeckillRulesSeting'])) {//添加活动规则

            $postArray = $_POST['SeckillRulesSeting'];
            $model->attributes = $postArray;
             
			//上传图片限制(由于规则不起作用且没找到原因,暂时这样解决)
			$m1 = 1024*1024;//1M
			$m3 = 1024*1204*3;//3M
			$att1 = CUploadedFile::getInstanceByName('SeckillRulesSeting[picture]');
			if($att1 && $att1->size > $m1 ){

				$this->setFlash('success', Yii::t('secondKillActivity','活动图片 大于1M,请重新上传.') );  
				$this->redirect(array('create3', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			if($att1 && !in_array($att1->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','活动图片 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('create3', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			$att2 = CUploadedFile::getInstanceByName('SeckillRulesSeting[banner1]');
			if($att2 && $att2->size > $m3){
				$this->setFlash('success', Yii::t('secondKillActivity','主图 大于3M,请重新上传.') );  
				$this->redirect(array('create3', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			if($att2 && !in_array($att2->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','主图 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('create3', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			$att3 = CUploadedFile::getInstanceByName('SeckillRulesSeting[banner2]');
			if($att3 && $att3->size > $m3){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图1 大于3M,请重新上传.') );  
				$this->redirect(array('create3', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			if($att3 && !in_array($att3->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图1 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('create3', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			$att4 = CUploadedFile::getInstanceByName('SeckillRulesSeting[banner3]');
			if($att4 && $att4->size > $m3){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图2 大于3M,请重新上传.') );  
				$this->redirect(array('create3', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			if($att4 && !in_array($att4->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图2 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('create3', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			$att5 = CUploadedFile::getInstanceByName('SeckillRulesSeting[banner4]');
			if($att5 && $att5->size > $m3){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图3 大于3M,请重新上传.') );  
				$this->redirect(array('create3', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			if($att5 && !in_array($att5->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图3 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('create3', 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
                exit;
			}
			
			$saveDir = 'seckill/' . date('Y/n/j');
            $model   = UploadedFile::uploadFile($model, 'picture', $saveDir);
            $model   = UploadedFile::uploadFile($model, 'banner1', $saveDir);
            $model   = UploadedFile::uploadFile($model, 'banner2', $saveDir);
            $model   = UploadedFile::uploadFile($model, 'banner3', $saveDir);
            $model   = UploadedFile::uploadFile($model, 'banner4', $saveDir);
            
            $postArray['picture']     = $model->picture;
            $postArray['banner1']     = $model->banner1;
            $postArray['banner2']     = $model->banner2;
            $postArray['banner3']     = $model->banner3;
            $postArray['banner4']     = $model->banner4;
            $postArray['category_id'] = $categoryId;
            $postArray['rules_id']    = intval($rulesId);
			
			if($categoryId != SeckillRulesSeting::SECKILL_CATEGORY_THREE){
			    $postArray['sort']        = $postArray['sort']>10000 ? 10000 : $postArray['sort'];
			}

			$model->createRules($postArray);
            $model->updateCache(0);//更新前台缓存
            
            // 保存图片文件
            UploadedFile::saveFile('picture', $model->picture); 
            if($postArray['banner1']){//若有上传banner图片,则保存文件
                UploadedFile::saveFile('banner1', $model->banner1);
            }
            if($postArray['banner2']){//若有上传banner图片,则保存文件
                UploadedFile::saveFile('banner2', $model->banner2);
            }
            if($postArray['banner3']){//若有上传banner图片,则保存文件
                UploadedFile::saveFile('banner3', $model->banner3);
            }
            if($postArray['banner4']){//若有上传banner图片,则保存文件
                UploadedFile::saveFile('banner4', $model->banner4);
            }
            
            @SystemLog::record(Yii::app()->user->name . $categoryId==SeckillRulesSeting::SECKILL_CATEGORY_THREE ? "添加秒杀设置 :{$rulesId}" :"添加活动：$postArray[name]");
            $this->setFlash('success', Yii::t('secondKillActivity', $categoryId==SeckillRulesSeting::SECKILL_CATEGORY_THREE ? "秒杀设置成功" : "添加{$model->name}活动成功！"));
            
			$adminAct = $categoryId == SeckillRulesSeting::SECKILL_CATEGORY_ONE ? 'RedAdmin' : ( $categoryId == SeckillRulesSeting::SECKILL_CATEGORY_TWO ? 'FestiveAdmin' :'SeckillAdmin');
            $this->redirect(array($adminAct, 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
        }
        
        $model->rulesId    = intval($rulesId);
        $model->categoryId = intval($categoryId);
        $this->render('create', array(
            'model' => $model,
            'labels' => $model->attributeLabels(),
        ));
    }
    
    /**
     * 修改红包活动
     * @param integer $categoryId 活动类型id
     * @param integer $rulesId 活动主表的id
     * @param integer $rulesSetingId 活动规则表的id
     */
    public function actionUpdate1(){
        $model         = new SeckillRulesSeting;
        $categoryId    = $this->getParam('category_id');
        $rulesId       = $this->getParam('rules_id');
        $rulesSetingId = $this->getParam('rules_seting_id');
        
		$model->scenario = 'rulesUpdate';
        $this->performAjaxValidation($model);
		$this->checkPostRequest();
        if (isset($_POST['SeckillRulesSeting'])) {//修改活动规则 
            $postArray = $_POST['SeckillRulesSeting'];
            $model->attributes = $postArray;
            
			//上传图片限制(由于规则不起作用且没找到原因,暂时这样解决)
			$m1 = 1024*1024;//1M
			$m3 = 1024*1204*3;//3M
			$att1 = CUploadedFile::getInstanceByName('SeckillRulesSeting[picture]');
			if($att1 && $att1->size > $m1){
				$this->setFlash('success', Yii::t('secondKillActivity','活动图片 大于1M,请重新上传.') );  
				$this->redirect(array('update1', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			if($att1 && !in_array($att1->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','活动图片 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('update1', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			$att2 = CUploadedFile::getInstanceByName('SeckillRulesSeting[banner1]');
			if($att2 && $att2->size > $m3){
				$this->setFlash('success', Yii::t('secondKillActivity','主图 大于3M,请重新上传.') );  
				$this->redirect(array('update1', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			if($att2 && !in_array($att2->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','主图 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('update1', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			$att3 = CUploadedFile::getInstanceByName('SeckillRulesSeting[banner2]');
			if($att3 && $att3->size > $m3){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图1 大于3M,请重新上传.') );  
				$this->redirect(array('update1', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			if($att3 && !in_array($att3->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图1 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('update1', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			$att4 = CUploadedFile::getInstanceByName('SeckillRulesSeting[banner3]');
			if($att4 && $att4->size > $m3){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图2 大于3M,请重新上传.') );  
				$this->redirect(array('update1', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			if($att4 && !in_array($att4->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图2 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('update1', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			$att5 = CUploadedFile::getInstanceByName('SeckillRulesSeting[banner4]');
			if($att5 && $att5->size > $m3){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图3 大于3M,请重新上传.') );  
				$this->redirect(array('update1', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			if($att5 && !in_array($att5->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图3 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('update1', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
            $saveDir = 'seckill/' . date('Y/n/j');
            $model   = UploadedFile::uploadFile($model, 'picture', $saveDir);
            $model   = UploadedFile::uploadFile($model, 'banner1', $saveDir);
            $model   = UploadedFile::uploadFile($model, 'banner2', $saveDir);
            $model   = UploadedFile::uploadFile($model, 'banner3', $saveDir);
            $model   = UploadedFile::uploadFile($model, 'banner4', $saveDir);
            
            $postArray['picture']     = $model->picture;
            $postArray['banner1']     = $model->banner1;
            $postArray['banner2']     = $model->banner2;
            $postArray['banner3']     = $model->banner3;
            $postArray['banner4']     = $model->banner4;
            $postArray['category_id'] = intval($categoryId);
            $postArray['rules_id']    = intval($rulesId);
            $postArray['rules_seting_id'] = intval($rulesSetingId);
            
            if($model->picture || $model->banner1 || $model->banner2 || $model->banner3 || $model->banner4){
                $picture = $model->getActivityPicture($rulesSetingId);
            }
			
			if($categoryId!=SeckillRulesSeting::SECKILL_CATEGORY_THREE){
			    $postArray['sort'] = $postArray['sort']>10000 ? 10000 : $postArray['sort'];
			}
			$model->updateRules($postArray);
            
            $model->updateCache($rulesSetingId);//更新前台缓存
            
            // 保存并删除旧文件
            if($postArray['picture']){//保存上传的图片文件
                UploadedFile::saveFile('picture', $model->picture, $picture['picture'], true); 
            }
            if($postArray['banner1']){//若有上传banner图片,则保存文件
                UploadedFile::saveFile('banner1', $model->banner1, $picture['banner1'], true);
            }
            if($postArray['banner2']){//若有上传banner图片,则保存文件
                UploadedFile::saveFile('banner2', $model->banner2, $picture['banner2'], true);
            }
            if($postArray['banner3']){//若有上传banner图片,则保存文件
                UploadedFile::saveFile('banner3', $model->banner3, $picture['banner3'], true);
            }
            if($postArray['banner4']){//若有上传banner图片,则保存文件
                UploadedFile::saveFile('banner4', $model->banner4, $picture['banner4'], true);
            }
            
            @SystemLog::record(Yii::app()->user->name . $categoryId==SeckillRulesSeting::SECKILL_CATEGORY_THREE ? "修改秒杀设置 :{$rulesId}" :"修改活动：id=$rulesId");
            $this->setFlash('success', Yii::t('secondKillActivity', "修改活动成功！"));
            
			$adminAct = $categoryId == SeckillRulesSeting::SECKILL_CATEGORY_ONE ? 'RedAdmin' : ( $categoryId == SeckillRulesSeting::SECKILL_CATEGORY_TWO ? 'FestiveAdmin' :'SeckillAdmin');
			$this->redirect(array($adminAct, 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
        }
        
        $model->rulesId       = intval($rulesId);
        $model->categoryId    = intval($categoryId);
        $model->rulesSetingId = intval($rulesSetingId);
        $this->render('update', array(
            'model' => $model,
            'dataProvider' => $model->getRulesById($rulesSetingId),
            'labels' => $model->attributeLabels(),
        ));
    }  
	
	/**
     * 修改应节性活动
     * @param integer $categoryId 活动类型id
     * @param integer $rulesId 活动主表的id
     * @param integer $rulesSetingId 活动规则表的id
     */
    public function actionUpdate2(){
        $model         = new SeckillRulesSeting;
        $categoryId    = $this->getParam('category_id');
        $rulesId       = $this->getParam('rules_id');
        $rulesSetingId = $this->getParam('rules_seting_id');
        
		$model->scenario = 'rulesUpdate';
        $this->performAjaxValidation($model);
		$this->checkPostRequest();
        if (isset($_POST['SeckillRulesSeting'])) {//修改活动规则 
            $postArray = $_POST['SeckillRulesSeting'];
//            var_dump($postArray);exit;
            $model->attributes = $postArray;

			//上传图片限制(由于规则不起作用且没找到原因,暂时这样解决)
			$m1 = 1024*1024;//1M
			$m3 = 1024*1204*3;//3M
			$att1 = CUploadedFile::getInstanceByName('SeckillRulesSeting[picture]');
			if($att1 && $att1->size > $m1){
				$this->setFlash('success', Yii::t('secondKillActivity','活动图片 大于1M,请重新上传.') );  
				$this->redirect(array('update2', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			if($att1 && !in_array($att1->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','活动图片 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('update2', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			$att2 = CUploadedFile::getInstanceByName('SeckillRulesSeting[banner1]');
			if($att2 && $att2->size > $m3){
				$this->setFlash('success', Yii::t('secondKillActivity','主图 大于3M,请重新上传.') );  
				$this->redirect(array('update2', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			if($att2 && !in_array($att2->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','主图 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('update2', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			$att3 = CUploadedFile::getInstanceByName('SeckillRulesSeting[banner2]');
			if($att3 && $att3->size > $m3){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图1 大于3M,请重新上传.') );  
				$this->redirect(array('update2', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			if($att3 && !in_array($att3->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图1 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('update2', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			$att4 = CUploadedFile::getInstanceByName('SeckillRulesSeting[banner3]');
			if($att4 && $att4->size > $m3){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图2 大于3M,请重新上传.') );  
				$this->redirect(array('update2', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			if($att4 && !in_array($att4->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图2 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('update2', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			$att5 = CUploadedFile::getInstanceByName('SeckillRulesSeting[banner4]');
			if($att5 && $att5->size > $m3){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图3 大于3M,请重新上传.') );  
				$this->redirect(array('update2', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			if($att5 && !in_array($att5->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图3 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('update2', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
            $saveDir = 'seckill/' . date('Y/n/j');
            $model   = UploadedFile::uploadFile($model, 'picture', $saveDir);
            $model   = UploadedFile::uploadFile($model, 'banner1', $saveDir);
            $model   = UploadedFile::uploadFile($model, 'banner2', $saveDir);
            $model   = UploadedFile::uploadFile($model, 'banner3', $saveDir);
            $model   = UploadedFile::uploadFile($model, 'banner4', $saveDir);
            
            $postArray['picture']     = $model->picture;
            $postArray['banner1']     = $model->banner1;
            $postArray['banner2']     = $model->banner2;
            $postArray['banner3']     = $model->banner3;
            $postArray['banner4']     = $model->banner4;
            $postArray['category_id'] = intval($categoryId);
            $postArray['rules_id']    = intval($rulesId);
            $postArray['rules_seting_id'] = intval($rulesSetingId);
            
            if($model->picture || $model->banner1 || $model->banner2 || $model->banner3 || $model->banner4){
                $picture = $model->getActivityPicture($rulesSetingId);
            }
			
			if($categoryId!=SeckillRulesSeting::SECKILL_CATEGORY_THREE){
			    $postArray['sort'] = $postArray['sort']>10000 ? 10000 : $postArray['sort'];
			}
			$model->updateRules($postArray);
            
            $model->updateCache($rulesSetingId);//更新前台缓存
            
            // 保存并删除旧文件
            if($postArray['picture']){//保存上传的图片文件
                UploadedFile::saveFile('picture', $model->picture, $picture['picture'], true); 
            }
            if($postArray['banner1']){//若有上传banner图片,则保存文件
                UploadedFile::saveFile('banner1', $model->banner1, $picture['banner1'], true);
            }
            if($postArray['banner2']){//若有上传banner图片,则保存文件
                UploadedFile::saveFile('banner2', $model->banner2, $picture['banner2'], true);
            }
            if($postArray['banner3']){//若有上传banner图片,则保存文件
                UploadedFile::saveFile('banner3', $model->banner3, $picture['banner3'], true);
            }
            if($postArray['banner4']){//若有上传banner图片,则保存文件
                UploadedFile::saveFile('banner4', $model->banner4, $picture['banner4'], true);
            }
            
            @SystemLog::record(Yii::app()->user->name . $categoryId==SeckillRulesSeting::SECKILL_CATEGORY_THREE ? "修改秒杀设置 :{$rulesId}" :"修改活动：id=$rulesId");
            $this->setFlash('success', Yii::t('secondKillActivity', "修改活动成功！"));
            
			$adminAct = $categoryId == SeckillRulesSeting::SECKILL_CATEGORY_ONE ? 'RedAdmin' : ( $categoryId == SeckillRulesSeting::SECKILL_CATEGORY_TWO ? 'FestiveAdmin' :'SeckillAdmin');
			$this->redirect(array($adminAct, 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
        }
        
        $model->rulesId       = intval($rulesId);
        $model->categoryId    = intval($categoryId);
        $model->rulesSetingId = intval($rulesSetingId);
        $this->render('update', array(
            'model' => $model,
            'dataProvider' => $model->getRulesById($rulesSetingId),
            'labels' => $model->attributeLabels(),
        ));
    }  
	
	/**
     * 修改秒杀活动
     * @param integer $categoryId 活动类型id
     * @param integer $rulesId 活动主表的id
     * @param integer $rulesSetingId 活动规则表的id
     */
    public function actionUpdate3(){
        $model         = new SeckillRulesSeting;
        $categoryId    = $this->getParam('category_id');
        $rulesId       = $this->getParam('rules_id');
        $rulesSetingId = $this->getParam('rules_seting_id');
        
        $this->performAjaxValidation($model);
		$this->checkPostRequest();
        if (isset($_POST['SeckillRulesSeting'])) {//修改活动规则 
            $postArray = $_POST['SeckillRulesSeting'];
            $model->attributes = $postArray;
            
			//上传图片限制(由于规则不起作用且没找到原因,暂时这样解决)
			$m1 = 1024*1024;//1M
			$m3 = 1024*1204*3;//3M
			$att1 = CUploadedFile::getInstanceByName('SeckillRulesSeting[picture]');
			if($att1 && $att1->size > $m1){
				$this->setFlash('success', Yii::t('secondKillActivity','活动图片 大于1M,请重新上传.') );  
				$this->redirect(array('update3', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			if($att1 && !in_array($att1->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','活动图片 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('update3', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			$att2 = CUploadedFile::getInstanceByName('SeckillRulesSeting[banner1]');
			if($att2 && $att2->size > $m3){
				$this->setFlash('success', Yii::t('secondKillActivity','主图 大于3M,请重新上传.') );  
				$this->redirect(array('update3', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			if($att2 && !in_array($att2->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','主图 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('update3', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			$att3 = CUploadedFile::getInstanceByName('SeckillRulesSeting[banner2]');
			if($att3 && $att3->size > $m3){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图1 大于3M,请重新上传.') );  
				$this->redirect(array('update3', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			if($att3 && !in_array($att3->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图1 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('update3', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			$att4 = CUploadedFile::getInstanceByName('SeckillRulesSeting[banner3]');
			if($att4 && $att4->size > $m3){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图2 大于3M,请重新上传.') );  
				$this->redirect(array('update3', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			if($att4 && !in_array($att4->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图2 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('update3', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			$att5 = CUploadedFile::getInstanceByName('SeckillRulesSeting[banner4]');
			if($att5 && $att5->size > $m3){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图3 大于3M,请重新上传.') );  
				$this->redirect(array('update3', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
			if($att5 && !in_array($att5->type, self::$mime) ){
				$this->setFlash('success', Yii::t('secondKillActivity','标题底图3 只能上传jpg、jpeg、gif、png格式.') );  
				$this->redirect(array('update3', 'category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId));
                exit;
			}
			
            $saveDir = 'seckill/' . date('Y/n/j');
            $model   = UploadedFile::uploadFile($model, 'picture', $saveDir);
            $model   = UploadedFile::uploadFile($model, 'banner1', $saveDir);
            $model   = UploadedFile::uploadFile($model, 'banner2', $saveDir);
            $model   = UploadedFile::uploadFile($model, 'banner3', $saveDir);
            $model   = UploadedFile::uploadFile($model, 'banner4', $saveDir);
            
            $postArray['picture']     = $model->picture;
            $postArray['banner1']     = $model->banner1;
            $postArray['banner2']     = $model->banner2;
            $postArray['banner3']     = $model->banner3;
            $postArray['banner4']     = $model->banner4;
            $postArray['category_id'] = intval($categoryId);
            $postArray['rules_id']    = intval($rulesId);
            $postArray['rules_seting_id'] = intval($rulesSetingId);
            
            if($model->picture || $model->banner1 || $model->banner2 || $model->banner3 || $model->banner4){
                $picture = $model->getActivityPicture($rulesSetingId);
            }
			
			if($categoryId!=SeckillRulesSeting::SECKILL_CATEGORY_THREE){
			    $postArray['sort'] = $postArray['sort']>10000 ? 10000 : $postArray['sort'];
			}
			$model->updateRules($postArray);
            
            $model->updateCache($rulesSetingId);//更新前台缓存
            
            // 保存并删除旧文件
            if($postArray['picture']){//保存上传的图片文件
                UploadedFile::saveFile('picture', $model->picture, $picture['picture'], true); 
            }
            if($postArray['banner1']){//若有上传banner图片,则保存文件
                UploadedFile::saveFile('banner1', $model->banner1, $picture['banner1'], true);
            }
            if($postArray['banner2']){//若有上传banner图片,则保存文件
                UploadedFile::saveFile('banner2', $model->banner2, $picture['banner2'], true);
            }
            if($postArray['banner3']){//若有上传banner图片,则保存文件
                UploadedFile::saveFile('banner3', $model->banner3, $picture['banner3'], true);
            }
            if($postArray['banner4']){//若有上传banner图片,则保存文件
                UploadedFile::saveFile('banner4', $model->banner4, $picture['banner4'], true);
            }
            
            @SystemLog::record(Yii::app()->user->name . $categoryId==SeckillRulesSeting::SECKILL_CATEGORY_THREE ? "修改秒杀设置 :{$rulesId}" :"修改活动：id=$rulesId");
            $this->setFlash('success', Yii::t('secondKillActivity', "修改活动成功！"));
            
			$adminAct = $categoryId == SeckillRulesSeting::SECKILL_CATEGORY_ONE ? 'RedAdmin' : ( $categoryId == SeckillRulesSeting::SECKILL_CATEGORY_TWO ? 'FestiveAdmin' :'SeckillAdmin');
			$this->redirect(array($adminAct, 'category_id'=>$categoryId, 'rules_id'=>$rulesId));
        }
        
        $model->rulesId       = intval($rulesId);
        $model->categoryId    = intval($categoryId);
        $model->rulesSetingId = intval($rulesSetingId);
        $this->render('update', array(
            'model' => $model,
            'dataProvider' => $model->getRulesById($rulesSetingId),
            'labels' => $model->attributeLabels(),
        ));
    }  

    /**
     * 创建/修改活动规则提交前的判断
     * @param array $SeckillRulesSeting 活动内容数组
     * @return json $data 返回检查信息 
     */
    public function actionCheckCreate(){
        $data = array('success'=>false, 'message'=>'信息填写有误.');

        if (isset($_POST['post'])) {
         
            $categoryId    = intval($_POST['categoryId']);
            $startTime     = strtotime($_POST['startTime']);
            $endTime       = strtotime($_POST['endTime']);
            $name          = isset($_POST['name']) ? trim($_POST['name']) : '';
            $rulesId       = isset($_POST['rulesId']) ? intval($_POST['rulesId']) : 0;
            $rulesSetingId = isset($_POST['rulesSetingId']) ? intval($_POST['rulesSetingId']) : 0;
			$limitNum      = intval($_POST['limitNum']);
			$buyLimit      = intval($_POST['buyLimit']);
            $sellerLimit = intval($_POST['sellerLimit']);
            
            if(!$name && $categoryId!=SeckillRulesSeting::SECKILL_CATEGORY_THREE){
                $data['message'] = '请输入活动名称.';
                echo json_encode($data);
                exit;                
            }
            
            if(!$startTime || !$endTime || $endTime<=$startTime){//检查时间格式
                $data['message'] = '请检查开始时间和结束时间.';
                echo json_encode($data);
                exit;
            }
			
			if($categoryId != SeckillRulesSeting::SECKILL_CATEGORY_THREE){//红包和应节的才限制报名时间
				$ssTime = strtotime($_POST['singupStart']);
                $seTime = strtotime($_POST['singupEnd']);
				if(!$ssTime || !$seTime || $ssTime>=$seTime){//检查报名时间时间格式
					$data['message'] = '请检查报名开始时间和截止时间.';
					echo json_encode($data);
					exit;
				}
				
				if($seTime >= $endTime){
					$data['message'] = '报名截止时间,只能小于活动结束时间.';
					echo json_encode($data);
					exit;
				}
			}
            
            if($categoryId == SeckillRulesSeting::SECKILL_CATEGORY_THREE){//判断时间是否重复                     
				
				if(intval($startTime)>=intval($endTime)){
					$data['message'] = '请检查开始时间和结束时间.';
                    echo json_encode ($data);
                    exit;
				}
				
				$startTime = date('H:i:s', $startTime);
                $endTime   = date('H:i:s', $endTime);
                
                if($rulesSetingId){
					
					$sql  = "SELECT id FROM {{seckill_rules_seting}} WHERE rules_id=:rules_id AND id!=:id AND start_time <= :end_time AND end_time >= :start_time ";
                    $result  = Yii::app()->db->createCommand($sql)->queryRow(true,array(':rules_id'=>$rulesId, ':start_time'=>$startTime, ':end_time'=>$endTime, ':id'=>$rulesSetingId));

                }else{
                    
					$sql = "SELECT id FROM {{seckill_rules_seting}} WHERE rules_id=:rules_id AND start_time <= :end_time AND end_time >= :start_time";
                    $result  = Yii::app()->db->createCommand($sql)->queryRow(true,array(':rules_id'=>$rulesId, ':start_time'=>$startTime, ':end_time'=>$endTime));
					
                }
               
                if($result){
                    $data['message'] = '时间已被占用，请重新选择.';
                    echo json_encode ($data);
                    exit;
                }
            }
			
			//活动商品限制参与数 不能小于当前已通过审核的数量
			if( $rulesSetingId > 0 ){
				$sql   = "SELECT COUNT(id) AS num FROM {{seckill_product_relation}} WHERE status=:status AND rules_seting_id=:rsid";
				$limit = Yii::app()->db->createCommand($sql)->queryScalar(array(':status'=>SeckillRulesSeting::RELATION_IS_PASS, ':rsid'=>$rulesSetingId));

				if($limitNum<0 || $limitNum>$this->maxLimit || $limitNum<$limit){
					$data['message'] = '活动商品限制参与数, 不能小于当前已通过审核的商品数量.';
					echo json_encode ($data);
					exit;
				}
			}

			//每ID限购,不能小于当前的设置
			if($rulesSetingId > 0){
				$sql    = "SELECT buy_limit FROM {{seckill_rules_seting}} WHERE id=:id";
				$buyNum = Yii::app()->db->createCommand($sql)->queryScalar(array(':id'=>$rulesSetingId));
				if(($buyLimit>0 && $buyNum>$buyLimit) || ($buyLimit>0 && $buyNum==0)){
					$data['message'] = 'ID限制购买数量, 不能小于当前已通过审核的限购数量.';
					echo json_encode ($data);
					exit;
				}
                                if(($limitNum < $sellerLimit && $sellerLimit > 0)){
                                    $data['message'] = "单店商品限报数不能大于活动商品限报数或不能小于当前已通过审核的限购数量";
                                    exit(json_encode ($data));
                                }
			}
            
            $sort = isset($_POST['seckillSort']) ? intval($_POST['seckillSort']) : 0; 
            if($sort && $categoryId != SeckillRulesSeting::SECKILL_CATEGORY_THREE){//秒杀活动没有排序 
                if($rulesSetingId){
                    $sql  = "SELECT rs.id FROM {{seckill_rules_seting}} rs,{{seckill_rules_main}} rm WHERE rm.id=rs.rules_id AND rm.category_id=:category_id AND rs.sort=:sort AND rs.id!=:id";
                    $result  = Yii::app()->db->createCommand($sql)->queryRow(true, array(':id'=>$rulesSetingId, ':sort'=>$sort, ':category_id'=>$categoryId));
                }else{
                    $sql  = "SELECT rs.id FROM {{seckill_rules_seting}} rs,{{seckill_rules_main}} rm WHERE rm.id=rs.rules_id AND rm.category_id=:category_id AND rs.sort=:sort";
                    $result  = Yii::app()->db->createCommand($sql)->queryRow(true, array(':category_id'=>$categoryId, ':sort'=>$sort));
                }
                
                if($result){
                    $data['message'] = '排序号已被占用,请重新输入.';
                    echo json_encode($data);
                    exit;
                }
            }

        }
        
        $data['success'] = true;
        $data['message'] = '信息填写正确.';
        echo json_encode($data);
        exit;
    }
    
    /**
     * 红包活动商品列表页
     * @param integer $rulesSetingId 活动规则表的id
     * 
     */
    public function actionProduct1(){
        $model         = new SeckillRulesSeting;
        $categoryId    = $this->getParam('category_id');
        $rulesId       = $this->getParam('rules_id');
        $rulesSetingId = $this->getParam('rules_seting_id');
        $model->product_name   = $model->product_id = $model->seller_name = '';
        
        $this->showExport = true;
        $this->exportAction = 'adminExport';
        
        if(isset($_GET['SeckillRulesSeting'])){
            $model->product_name = $_GET['SeckillRulesSeting']['product_name'];
            $model->product_id   = $_GET['SeckillRulesSeting']['product_id'];
            $model->seller_name  = $_GET['SeckillRulesSeting']['seller_name'];
        }
        
        $dataProvider = array();
        $result       = $model->getRulesProduct($categoryId, $rulesId, $rulesSetingId, $model->product_id, $model->product_name, $model->seller_name);      
        $dataProvider = $result['data'];
        $pages        = $result['pages'];
        
        $totalCount = $pages->getItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = 'secondKillActivity/adminExport';
        $exportPage->params = array_merge(array('grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;
        
        $model->rulesId       = $rulesId;
        $model->categoryId    = $categoryId;
        $model->rulesSetingId = $rulesSetingId;       
        $this->render('product', array(
            'model' => $model,
            'labels' => $model->attributeLabels(),
            'dataProvider' => $dataProvider,
            'pages' => $pages,
            'exportPage' => $exportPage,
            'totalCount' => $totalCount,
        ));
    }
	
	/**
     * 应节性活动商品列表页
     * @param integer $rulesSetingId 活动规则表的id
     * 
     */
    public function actionProduct2(){
        $model         = new SeckillRulesSeting;
        $categoryId    = $this->getParam('category_id');
        $rulesId       = $this->getParam('rules_id');
        $rulesSetingId = $this->getParam('rules_seting_id');
        $model->product_name   = $model->product_id = $model->seller_name = '';
        
        $this->showExport = true;
        $this->exportAction = 'adminExport';
        
        if(isset($_GET['SeckillRulesSeting'])){
            $model->product_name = $_GET['SeckillRulesSeting']['product_name'];
            $model->product_id   = $_GET['SeckillRulesSeting']['product_id'];
            $model->seller_name  = $_GET['SeckillRulesSeting']['seller_name'];
        }
//        CDbDataReader::s;
        $dataProvider = array();
        $result       = $model->getRulesProduct($categoryId, $rulesId, $rulesSetingId, $model->product_id, $model->product_name, $model->seller_name);      
        $dataProvider = $result['data'];
        $pages        = $result['pages'];
        $model->rulesId       = $rulesId;
        $model->categoryId    = $categoryId;
        $model->rulesSetingId = $rulesSetingId;       
        $totalCount = $pages->getItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = 'secondKillActivity/adminExport';
        $exportPage->params = array_merge(array('grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;
        
        $this->render('product', array(
            'model' => $model,
            'labels' => $model->attributeLabels(),
            'dataProvider' => $dataProvider,
            'pages' => $pages,
            'exportPage' => $exportPage,
            'totalCount' => $totalCount,
        ));
    }
	
	/**
     * 秒杀活动商品列表页
     * @param integer $rulesSetingId 活动规则表的id
     * 
     */
    public function actionProduct3(){
        $model         = new SeckillRulesSeting;
        $categoryId    = $this->getParam('category_id');
        $rulesId       = $this->getParam('rules_id');
        $rulesSetingId = $this->getParam('rules_seting_id');
        $model->product_name   = $model->product_id = $model->seller_name = '';

        $this->showExport = true;
        $this->exportAction = 'adminExport';
        
        if(isset($_GET['SeckillRulesSeting'])){
            $model->product_name = $_GET['SeckillRulesSeting']['product_name'];
            $model->product_id   = $_GET['SeckillRulesSeting']['product_id'];
            $model->seller_name  = $_GET['SeckillRulesSeting']['seller_name'];
        }
        
        $dataProvider = array();
        $result       = $model->getRulesProduct($categoryId, $rulesId, $rulesSetingId, $model->product_id, $model->product_name, $model->seller_name);      
        $dataProvider = $result['data'];
        $pages        = $result['pages'];
        
        $model->rulesId       = $rulesId;
        $model->categoryId    = $categoryId;
        $model->rulesSetingId = $rulesSetingId;       
        
        $totalCount = $pages->getItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = 'secondKillActivity/adminExport';
        $exportPage->params = array_merge(array('grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;
        
        $this->render('product', array(
            'model' => $model,
            'labels' => $model->attributeLabels(),
            'dataProvider' => $dataProvider,
            'pages' => $pages,
            'exportPage' => $exportPage,
            'totalCount' => $totalCount,
        ));
    }

    public function actionAdminExport() {
        set_time_limit(2400);
        @ini_set('memory_limit','1024M');
        $model         = new SeckillRulesSeting;
        $categoryId    = $this->getParam('category_id');
        $rulesId       = $this->getParam('rules_id');
        $rulesSetingId = $this->getParam('rules_seting_id');
        //**若有搜索**/
        if(isset($_GET['SeckillRulesSeting'])){
            $model->product_name = $_GET['SeckillRulesSeting']['product_name'];
            $model->product_id   = $_GET['SeckillRulesSeting']['product_id'];
            $model->seller_name  = $_GET['SeckillRulesSeting']['seller_name'];
        }

        $model->isExport = 1;
        $data = $model->ExportSearch($rulesSetingId);
        if(!$data) throw new CException('导出活动商品列表失败。找不到该活动!');
        
       @SystemLog::record(Yii::app()->user->name . "导出参与活动的商品列表");

        $this->render('adminExport', array(
            'model' => $data,
        ));
    }
    
	/**
	 * 更改拍卖活动的状态
	 * @param integer $id 活动的ID
	 * @return json $data 返回状态
	 */
	public function actionStart4(){
		$model = new SeckillRulesSeting();
		$data = array('success'=>false,'message'=>'操作失败');

		$id = intval($this->getParam('id'));
		$status = intval($this->getParam('status'));


	}

    /**
     * 更改红包活动的状态
     * @param integer $id 活动的ID 
     * @return json $data 返回状态
     */
    public function actionStart1(){
        $model = new SeckillRulesSeting;
        $data  = array('success'=>false, 'message'=>'操作失败');

        $id     = intval($this->getParam('id'));
        $status = intval($this->getParam('status'));

        //更改活动的状态
		$upStatus = SeckillRulesSeting::ACTIVITY_NOT_START;
		$time     = time();
		$sql      = "SELECT rm.date_start,rm.date_end,rs.status,rs.start_time,rs.end_time FROM {{seckill_rules_main}} rm, {{seckill_rules_seting}} rs WHERE rm.id=rs.rules_id AND rs.id=:id";
		$return   = Yii::app()->db->createCommand($sql)->queryRow(true, array(':id'=>$id));
		
		$startTime = strtotime($return['date_start'].' '.$return['start_time']);
		$endTime   = strtotime($return['date_end'].' '.$return['end_time']);
		if($status==SeckillRulesSeting::ACTIVITY_NOT_OPEN){	
		    $upStatus = SeckillRulesSeting::ACTIVITY_IS_OVER;		
		}else{
			$upStatus = $time > $endTime ? SeckillRulesSeting::ACTIVITY_IS_OVER : ( ($time>=$startTime && $time<=$endTime) ? SeckillRulesSeting::ACTIVITY_IS_RUNNING : SeckillRulesSeting::ACTIVITY_NOT_START ); 
		}
		
        if($upStatus<SeckillRulesSeting::ACTIVITY_IS_OVER){//开启活动

			Yii::app()->db->createCommand()->update('{{seckill_rules_seting}}', array('status'=>$upStatus), 'id=:id', array(':id' =>$id));
            @SystemLog::record(Yii::app()->user->name . "开启活动： id=" . $id);
        }else{//强制结束

			Yii::app()->db->createCommand()->update('{{seckill_rules_seting}}', array('status'=>SeckillRulesSeting::ACTIVITY_IS_OVER, 'sort'=>99999), 'id=:id', array(':id' =>$id));
			
			//清空goods表对应的seckill_seting_id
			Yii::app()->db->createCommand()->update('{{goods}}', array('seckill_seting_id'=>0), 'seckill_seting_id=:id', array(':id' =>$id));

            @SystemLog::record(Yii::app()->user->name . "结束活动： id=" . $id);
        }
		
        //更新前台缓存
        $model->updateCache($id);//更新前台缓存
        $data['success'] = true;
        echo json_encode($data);
        exit;
    }
	
	/**
     * 更改应节性活动的状态
     * @param integer $id 活动的ID 
     * @return json $data 返回状态
     */
    public function actionStart2(){
        $model = new SeckillRulesSeting;
        $data  = array('success'=>false, 'message'=>'操作失败');

        $id     = intval($this->getParam('id'));
        $status = intval($this->getParam('status'));

        //更改活动的状态
		$upStatus = SeckillRulesSeting::ACTIVITY_NOT_START;
		$time     = time();
		$sql      = "SELECT rm.date_start,rm.date_end,rs.status,rs.start_time,rs.end_time FROM {{seckill_rules_main}} rm, {{seckill_rules_seting}} rs WHERE rm.id=rs.rules_id AND rs.id=:id";
		$return   = Yii::app()->db->createCommand($sql)->queryRow(true, array(':id'=>$id));

		$startTime = strtotime($return['date_start'].' '.$return['start_time']);
		$endTime   = strtotime($return['date_end'].' '.$return['end_time']);
		if($status==SeckillRulesSeting::ACTIVITY_NOT_OPEN){	
		    $upStatus = SeckillRulesSeting::ACTIVITY_IS_OVER;		
		}else{
			$upStatus = $time > $endTime ? SeckillRulesSeting::ACTIVITY_IS_OVER : ( ($time>=$startTime && $time<=$endTime) ? SeckillRulesSeting::ACTIVITY_IS_RUNNING : SeckillRulesSeting::ACTIVITY_NOT_START ); 
		}

        if($upStatus<SeckillRulesSeting::ACTIVITY_IS_OVER){//开启活动
			Yii::app()->db->createCommand()->update('{{seckill_rules_seting}}', array('status'=>$upStatus), 'id=:id', array(':id' =>$id));

            @SystemLog::record(Yii::app()->user->name . "开启活动： id=" . $id);
        }else{//强制结束
			Yii::app()->db->createCommand()->update('{{seckill_rules_seting}}', array('status'=>SeckillRulesSeting::ACTIVITY_IS_OVER, 'sort'=>99999), 'id=:id', array(':id' =>$id));
			
			//清空goods表对应的seckill_seting_id
			Yii::app()->db->createCommand()->update('{{goods}}', array('seckill_seting_id'=>0), 'seckill_seting_id=:id', array(':id' =>$id));

            @SystemLog::record(Yii::app()->user->name . "结束活动： id=" . $id);
        }
		
        //更新前台缓存
        $model->updateCache($id);//更新前台缓存
        $data['success'] = true;
        echo json_encode($data);
        exit;
    }
	
	/**
     * 更改秒杀活动的状态
     * @param integer $id 活动的ID 
     * @return json $data 返回状态
     */
    public function actionStart3(){
        $model = new SeckillRulesSeting;
        $data  = array('success'=>false, 'message'=>'操作失败');

        $id     = intval($this->getParam('id'));
        $status = intval($this->getParam('status'));

        //更改活动的状态
		$upStatus = SeckillRulesSeting::ACTIVITY_NOT_START;
		$time     = time();
		$sql      = "SELECT rm.date_start,rm.date_end,rs.status,rs.start_time,rs.end_time FROM {{seckill_rules_main}} rm, {{seckill_rules_seting}} rs WHERE rm.id=rs.rules_id AND rs.id=:id";
		$return   = Yii::app()->db->createCommand($sql)->queryRow(true, array(':id'=>$id));
		
		$startTime = strtotime($return['date_start'].' '.$return['start_time']);
		$endTime   = strtotime($return['date_end'].' '.$return['end_time']);
		if($status==SeckillRulesSeting::ACTIVITY_NOT_OPEN){	
		    $upStatus = SeckillRulesSeting::ACTIVITY_IS_OVER;		
		}else{
			$upStatus = $time > $endTime ? SeckillRulesSeting::ACTIVITY_IS_OVER : ( ($time>=$startTime && $time<=$endTime) ? SeckillRulesSeting::ACTIVITY_IS_RUNNING : SeckillRulesSeting::ACTIVITY_NOT_START ); 
		}
		
        if($upStatus<SeckillRulesSeting::ACTIVITY_IS_OVER){//开启活动
			Yii::app()->db->createCommand()->update('{{seckill_rules_seting}}', array('status'=>$upStatus), 'id=:id', array(':id' =>$id));

            @SystemLog::record(Yii::app()->user->name . "开启活动： id=" . $id);
        }else{//强制结束
			Yii::app()->db->createCommand()->update('{{seckill_rules_seting}}', array('status'=>SeckillRulesSeting::ACTIVITY_IS_OVER, 'sort'=>99999), 'id=:id', array(':id' =>$id));
			
			//清空goods表对应的seckill_seting_id
			Yii::app()->db->createCommand()->update('{{goods}}', array('seckill_seting_id'=>0), 'seckill_seting_id=:id', array(':id' =>$id));

            @SystemLog::record(Yii::app()->user->name . "结束活动： id=" . $id);
        }
		
        //更新前台缓存
        $model->updateCache($id);//更新前台缓存
        $data['success'] = true;
        echo json_encode($data);
        exit;
    }
	
	/**
     * 更改红包活动的状态
     * @param integer $id 活动的ID 
     * @return json $data 返回状态
     */
    public function actionStop1(){
        $model = new SeckillRulesSeting;
        $data  = array('success'=>false, 'message'=>'操作失败');

        $id     = intval($this->getParam('id'));
        $status = intval($this->getParam('status'));

        //更改活动的状态
		$upStatus = SeckillRulesSeting::ACTIVITY_NOT_START;
		$time     = time();
		$sql      = "SELECT rm.date_start,rm.date_end,rs.status,rs.start_time,rs.end_time FROM {{seckill_rules_main}} rm, {{seckill_rules_seting}} rs WHERE rm.id=rs.rules_id AND rs.id=:id";
		$return   = Yii::app()->db->createCommand($sql)->queryRow(true, array(':id'=>$id));
		
		$startTime = strtotime($return['date_start'].' '.$return['start_time']);
		$endTime   = strtotime($return['date_end'].' '.$return['end_time']);
		if($status==SeckillRulesSeting::ACTIVITY_NOT_OPEN){	
		    $upStatus = SeckillRulesSeting::ACTIVITY_IS_OVER;		
		}else{
			$upStatus = $time > $endTime ? SeckillRulesSeting::ACTIVITY_IS_OVER : ( ($time>=$startTime && $time<=$endTime) ? SeckillRulesSeting::ACTIVITY_IS_RUNNING : SeckillRulesSeting::ACTIVITY_NOT_START ); 
		}
		
        if($upStatus<SeckillRulesSeting::ACTIVITY_IS_OVER){//开启活动
			Yii::app()->db->createCommand()->update('{{seckill_rules_seting}}', array('status'=>$upStatus), 'id=:id', array(':id' =>$id));

            @SystemLog::record(Yii::app()->user->name . "开启活动： id=" . $id);
        }else{//强制结束
			Yii::app()->db->createCommand()->update('{{seckill_rules_seting}}', array('status'=>SeckillRulesSeting::ACTIVITY_IS_OVER, 'sort'=>99999), 'id=:id', array(':id' =>$id));
			
			//清空goods表对应的seckill_seting_id
			Yii::app()->db->createCommand()->update('{{goods}}', array('seckill_seting_id'=>0), 'seckill_seting_id=:id', array(':id' =>$id));
			
			//清空必抢表对应的rules_id
			Yii::app()->db->createCommand()->update('{{seckill_grab}}', array('rules_id'=>0), 'rules_id=:id', array(':id' =>$id));

            @SystemLog::record(Yii::app()->user->name . "结束活动： id=" . $id);
        }
		
        //更新前台缓存
        $model->updateCache($id);//更新前台缓存
        $data['success'] = true;
        echo json_encode($data);
        exit;
    }
	
	/**
     * 更改应节性活动的状态
     * @param integer $id 活动的ID 
     * @return json $data 返回状态
     */
    public function actionStop2(){
        $model = new SeckillRulesSeting;
        $data  = array('success'=>false, 'message'=>'操作失败');

        $id     = intval($this->getParam('id'));
        $status = intval($this->getParam('status'));

        //更改活动的状态
		$upStatus = SeckillRulesSeting::ACTIVITY_NOT_START;
		$time     = time();
		$sql      = "SELECT rm.date_start,rm.date_end,rs.status,rs.start_time,rs.end_time FROM {{seckill_rules_main}} rm, {{seckill_rules_seting}} rs WHERE rm.id=rs.rules_id AND rs.id=:id";
		$return   = Yii::app()->db->createCommand($sql)->queryRow(true, array(':id'=>$id));

		$startTime = strtotime($return['date_start'].' '.$return['start_time']);
		$endTime   = strtotime($return['date_end'].' '.$return['end_time']);
		if($status==SeckillRulesSeting::ACTIVITY_NOT_OPEN){	
		    $upStatus = SeckillRulesSeting::ACTIVITY_IS_OVER;		
		}else{
			$upStatus = $time > $endTime ? SeckillRulesSeting::ACTIVITY_IS_OVER : ( ($time>=$startTime && $time<=$endTime) ? SeckillRulesSeting::ACTIVITY_IS_RUNNING : SeckillRulesSeting::ACTIVITY_NOT_START ); 
		}

        if($upStatus<SeckillRulesSeting::ACTIVITY_IS_OVER){//开启活动
			Yii::app()->db->createCommand()->update('{{seckill_rules_seting}}', array('status'=>$upStatus), 'id=:id', array(':id' =>$id));

            @SystemLog::record(Yii::app()->user->name . "开启活动： id=" . $id);
        }else{//强制结束
			Yii::app()->db->createCommand()->update('{{seckill_rules_seting}}', array('status'=>SeckillRulesSeting::ACTIVITY_IS_OVER, 'sort'=>99999), 'id=:id', array(':id' =>$id));

			//清空goods表对应的seckill_seting_id
			Yii::app()->db->createCommand()->update('{{goods}}', array('seckill_seting_id'=>0), 'seckill_seting_id=:id', array(':id' =>$id));

			//清空必抢表对应的rules_id
			Yii::app()->db->createCommand()->update('{{seckill_grab}}', array('rules_id'=>0), 'rules_id=:id', array(':id' =>$id));

            @SystemLog::record(Yii::app()->user->name . "结束活动： id=" . $id);
        }
		
        //更新前台缓存
        $model->updateCache($id);//更新前台缓存
        $data['success'] = true;
        echo json_encode($data);
        exit;
    }
	
	/**
     * 更改秒杀活动的状态
     * @param integer $id 活动的ID 
     * @return json $data 返回状态
     */
    public function actionStop3(){
        $model = new SeckillRulesSeting;
        $data  = array('success'=>false, 'message'=>'操作失败');

        $id     = intval($this->getParam('id'));
        $status = intval($this->getParam('status'));

        //更改活动的状态
		$upStatus = SeckillRulesSeting::ACTIVITY_NOT_START;
		$time     = time();
		$sql      = "SELECT rm.date_start,rm.date_end,rs.status,rs.start_time,rs.end_time FROM {{seckill_rules_main}} rm, {{seckill_rules_seting}} rs WHERE rm.id=rs.rules_id AND rs.id=:id";
		$return   = Yii::app()->db->createCommand($sql)->queryRow(true, array(':id'=>$id));
		
		$startTime = strtotime($return['date_start'].' '.$return['start_time']);
		$endTime   = strtotime($return['date_end'].' '.$return['end_time']);
		if($status==SeckillRulesSeting::ACTIVITY_NOT_OPEN){	
		    $upStatus = SeckillRulesSeting::ACTIVITY_IS_OVER;		
		}else{
			$upStatus = $time > $endTime ? SeckillRulesSeting::ACTIVITY_IS_OVER : ( ($time>=$startTime && $time<=$endTime) ? SeckillRulesSeting::ACTIVITY_IS_RUNNING : SeckillRulesSeting::ACTIVITY_NOT_START ); 
		}
		
        if($upStatus<SeckillRulesSeting::ACTIVITY_IS_OVER){//开启活动
			Yii::app()->db->createCommand()->update('{{seckill_rules_seting}}', array('status'=>$upStatus), 'id=:id', array(':id' =>$id));

            @SystemLog::record(Yii::app()->user->name . "开启活动： id=" . $id);
        }else{//强制结束
			Yii::app()->db->createCommand()->update('{{seckill_rules_seting}}', array('status'=>SeckillRulesSeting::ACTIVITY_IS_OVER, 'sort'=>99999), 'id=:id', array(':id' =>$id));
			
			//清空goods表对应的seckill_seting_id
			Yii::app()->db->createCommand()->update('{{goods}}', array('seckill_seting_id'=>0), 'seckill_seting_id=:id', array(':id' =>$id));
			
			//清空必抢表对应的rules_id
			Yii::app()->db->createCommand()->update('{{seckill_grab}}', array('rules_id'=>0), 'rules_id=:id', array(':id' =>$id));

            @SystemLog::record(Yii::app()->user->name . "结束活动： id=" . $id);
        }
		
        //更新前台缓存
        $model->updateCache($id);//更新前台缓存
        $data['success'] = true;
        echo json_encode($data);
        exit;
    }
    
    /**
     * 创建秒杀活动的日期
     * @param string $name 活动名称
     * @param string $start_time 活动开始日期
     * @param string $end_time 活动结束日期
     * @param integer $category_id 活动类型id
     * @return json 返回处理结果
     */
    public function actionCreateDate(){
        $model = new SeckillRulesSeting;
		$data  = array('success'=>false, 'message'=>'创建活动日期失败'); 
		
        $array['name']        = $this->getParam('name');
        $array['date_start']  = $this->getParam('start_time');
        $array['date_end']    = $this->getParam('end_time');
        $array['category_id'] = $this->getParam('category_id');
		$array['singup_start_time'] = $this->getParam('singup_start_time');
		$array['singup_end_time']   = $this->getParam('singup_end_time');
		
		$startTime = strtotime($array['date_start']);
		$endTime   = strtotime($array['date_end']);
		if($startTime>$endTime){
		    $data['message'] = '请检查活动日期是否合理.';
			echo json_encode($data);
			exit;
		}
		
		$ssTime = strtotime($array['singup_start_time']);
		$seTime = strtotime($array['singup_end_time']);
		if($ssTime>=$seTime){
		    $data['message'] = '请检查报名时间是否合理.';
			echo json_encode($data);
			exit;
		}
		
		if($seTime >= $endTime+86400){
			$data['message'] = '报名截止时间,只能小于活动结束时间.';
			echo json_encode($data);
			exit;
		}
        
        $return = $model->createDate($array);
        @SystemLog::record(Yii::app()->user->name ."添加秒杀日期 : $array[name]");
        
         $data['success'] = true;
		 $data['message'] = '创建活动日期成功.';
		 echo json_encode($data);
		 exit;
    }

    /**
     * 删除专题活动
     * @param integer $id  活动的ID
     */
    public function actionAdminDelete() {
        $model = new SeckillRulesSeting();
        
        $id          = intval($this->getParam('id'));
        $categoryId  = intval($this->getParam('category_id'));
        $status      = intval($this->getParam('status'));
        
        $model->deleteRules($id);
        $data = array('url'=>Yii::app()->createUrl('/SecondKillActivity/admin', array('category_id'=>$categoryId, 'status'=>$status)));
        
        echo json_encode($data);
        exit;
    }
	
    /**
     * 专题活动内容列表(红包活动)
     * @param integer category_id 活动的类型ID
     * @param integer status 活动的状态
     */
    public function actionRedAdmin() {
        $model = new SeckillRulesSeting('search');
        $dataProvider = array();
        
        //根据提交的条件查询相关活动
        $model->categoryId = isset($_GET['category_id']) ? intval($_GET['category_id']) : SeckillRulesSeting::SECKILL_CATEGORY_ONE;
        $model->status     = isset($_GET['status']) ? intval($_GET['status']) : 0;
        $model->rulesId    = isset($_GET['rules_id']) ? intval($_GET['rules_id']) : 0;
        
        //传参到页面显示
        $result       = $model->getRulesRecord($model->categoryId, $model->status, $model->rulesId);
        $dataProvider = $result['data'];
        $pages        = $result['pages'];
        
        $this->render('admin', array(
            'model' => $model,
            'labels' => $model->attributeLabels(),
            'dataProvider' => $dataProvider,
            'pages' => $pages,
        ));       
    }
	
	/**
     * 专题活动内容列表(应节活动)
     * @param integer category_id 活动的类型ID
     * @param integer status 活动的状态
     */
    public function actionFestiveAdmin() {
        $model = new SeckillRulesSeting('search');
        $dataProvider = array();

        //根据提交的条件查询相关活动
        $model->categoryId = isset($_GET['category_id']) ? intval($_GET['category_id']) : SeckillRulesSeting::SECKILL_CATEGORY_TWO;
        $model->status     = isset($_GET['status']) ? intval($_GET['status']) : 0;
        $model->rulesId    = isset($_GET['rules_id']) ? intval($_GET['rules_id']) : 0;
         
        //传参到页面显示
        $result       = $model->getRulesRecord($model->categoryId, $model->status, $model->rulesId);
        $dataProvider = $result['data'];
        $pages        = $result['pages'];
        
        $this->render('admin', array(
            'model' => $model,
            'labels' => $model->attributeLabels(),
            'dataProvider' => $dataProvider,
            'pages' => $pages,
        ));       
    }
	
	/**
     * 专题活动内容列表(秒杀活动)
     * @param integer category_id 活动的类型ID
     * @param integer status 活动的状态
     */
    public function actionSeckillAdmin() {
        $model = new SeckillRulesSeting('search');
        $dataProvider = array();
        
        //根据提交的条件查询相关活动
        $model->categoryId = isset($_GET['category_id']) ? intval($_GET['category_id']) : SeckillRulesSeting::SECKILL_CATEGORY_THREE;
        $model->status     = isset($_GET['status']) ? intval($_GET['status']) : 0;
        $model->rulesId    = isset($_GET['rules_id']) ? intval($_GET['rules_id']) : 0;
         
        //传参到页面显示
        $result       = $model->getRulesRecord($model->categoryId, $model->status, $model->rulesId);
        $dataProvider = $result['data'];
        $pages        = $result['pages'];
        
        $this->render('admin', array(
            'model' => $model,
            'labels' => $model->attributeLabels(),
            'dataProvider' => $dataProvider,
            'pages' => $pages,
        ));       
    }

	/**
	 * 活动产品类别选择
	 */
	public function actionActiveCategory(){
        $model = new ActiveCategoryForm();
		$post  = $this->getParam('category');

		$this->performAjaxValidation($model);
		$this->checkPostRequest();
		if (isset($post) && !empty($post)) {
            $model->updateCategory($post);

			@SystemLog::record(Yii::app()->user->name." 修改参加活动的商品类别");
			$this->setFlash('success', Yii::t('secondKillActivity', "修改成功!"));
			$this->redirect(array('activeCategory'));
		}

		$this->render('activeCategory',array(
            'model' => $model
		));
	}

}
