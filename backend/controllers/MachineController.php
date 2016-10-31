<?php

/**
 * 盖网机控制器 
 * 操作 (添加)
 * @author  wencong.lin <183482670@qq.com>
 */
class MachineController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    public function actionAdmin() {
        $model = new Machine('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Machine']))
            $model->attributes = $_GET['Machine'];
            
        $this->showExport = true;
        $this->exportAction = 'adminExport';

        $totalCount = $model->search()->getTotalItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = 'machine/adminExport';
        $exportPage->params = array_merge(array('grid_mode' => 'export'),$_GET);
        $exportPage->pageSize = $model->exportLimit;
        

        $this->render('admin', array(
            'model' => $model,
        	'exportPage' => $exportPage,
        	'totalCount'=>$totalCount,
        ));
    }
    
	public function actionAdminExport() {
        $model = new Machine('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Machine']))
            $model->attributes = $_GET['Machine'];
            
        @SystemLog::record(Yii::app()->user->name."导出盖机列表");
            
        $model->isExport = 1;
        $this->render('adminExport', array(
            'model' => $model,
        ));
    }
    
    /**
     * 编辑盖机
     * @param unknown $id
     */
    public function actionCreateOld($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        $offRoleRe = OfflineRoleRelation::model()->tableName();
        $offRole = OfflineRole::model()->tableName();
        if (isset($_POST['Machine'])) {
        	$postArr = $_POST['Machine'];
        	$roleArr = OfflineRole::getId2Name();
        	foreach ($postArr as $key => $value){
        		$memberData = OfflineRoleRelation::isMember($value);
        		if(empty($memberData)){
        			$this->setFlash('error', Yii::t('machine', '找不到会员:' . $value));
        			continue;
        		}else {
        			//保存盖机推荐人
        			if($key == OfflineRole::ROLE_MACHINE_REFEREES){
        				$oldMember = Member::model()->findByPk($model->intro_member_id);
        				$model->intro_member_id = $memberData['id'];
        				if ($model->save('create')){
        					if (empty($oldMember))
        						$machineLogContent = Yii::app()->user->name."于".date('Y-m-d H:i:s')."将盖机：".$model->name."[".$model->machine_code."]"."的推荐人设定为".$memberData['id'];
        					else
        						$machineLogContent = Yii::app()->user->name."于".date('Y-m-d H:i:s')."将盖机：".$model->name."[".$model->machine_code."]"."的推荐人从".$oldMember->id."换成".$memberData['id'];
        					@SystemLog::record($machineLogContent);
        				}
        			}
        			
        			//保存线下机器roleRelation
        			$offRoleReData = OfflineRoleRelation::createOrUpdateInfo('role_id = ' .$key. ' and machine_id = ' .$id. ' and record_type = ' .FranchiseeConsumptionRecord::RECORD_TYPE_POINT);
        			if(empty($offRoleReData)){
        				$res = Yii::app()->db->createCommand()->insert($offRoleRe,array('member_id'=>$memberData['id'],'role_id'=>$key,'machine_id'=>$id,'admin_id'=>Yii::app()->user->id,'update_time'=>time(),'record_type'=>FranchiseeConsumptionRecord::RECORD_TYPE_POINT));
        				if($res)
        					$sysLogContent = Yii::app()->user->name."于".date('Y-m-d H:i:s')."将盖机：".$model->name."[".$model->machine_code."]"."的【".$roleArr[$key]."】设定为".$memberData['id'];
        			}
        			else {
        				$res = Yii::app()->db->createCommand()->update($offRoleRe, array('member_id'=>$memberData['id'],'update_time'=>time(),'admin_id'=>Yii::app()->user->id),'id=:id',array(':id'=>$offRoleReData['id']));
        				if($res)
        					$sysLogContent = Yii::app()->user->name."于".date('Y-m-d H:i:s')."将盖机：".$model->name."[".$model->machine_code."]"."的【".$roleArr[$key]."】从".$offRoleReData['member_id']."换成".$memberData['id'];
        			}
        			@SystemLog::record($sysLogContent);
        		}
        	}
        	$this->redirect(array('admin'));
        }
		$roles = Yii::app()->db->createCommand()
						->select("or.role_id,or.role_name,m.gai_number value")
						->from($offRole .' as or')
						->leftJoin($offRoleRe.' as orr', 'orr.role_id = or.role_id')
						->leftJoin(Member::model()->tableName().' as m','m.id = orr.member_id')
						->where('or.role_id not in(1,2,3,4,5,6) and orr.machine_id = '.$id. ' and orr.record_type = ' .FranchiseeConsumptionRecord::RECORD_TYPE_POINT)
						->queryAll();
		$role = Yii::app()->db->createCommand()->select('role_id ,role_name')->from($offRole)->where('role_id not in (1,2,3,4,5,6)')->queryAll();
		foreach ($role as $key => $value){
			foreach ($roles as  $val){
				if ($value['role_id'] == $val['role_id'] && $value['role_name']==$val['role_name']){
					$role[$key] = $val;
				}
			}
		}
        $this->render('create', array(
            'model' => $model,
        	'role' => $role
        ));
    }

    public function actionCreate($id) {
    	$model = $this->loadModel($id);
    	$arr = array('推荐人'=>'intro_member_id','铺机人'=>'install_member_id','运维人'=>'operate_member_id');
    	if (isset($_POST['Machine'])) {
    		$set = "";
    		$message = "";
    		$result = false;
    		foreach ($arr as $key=>$val){
    			if(!Empty($_POST['Machine'][$val])){
    				$memberData = OfflineRoleRelation::isMember($_POST['Machine'][$val]);
    				if(empty($memberData)){
    					$result = true;
    					$message .= $key.",";
    				}
    				$model->$val = empty($memberData) ? "" : $memberData['id'];
    				$set .= $val." = ".$model->$val.",";
    			}else{
    				$set .= $val." = '',";
    			}
    		}
    		if($result){
    			foreach ($arr as $val){
    				$model->$val = $_POST['Machine'][$val];
    			}
    			$message = substr($message, 0,-1);
    			$message .= "输入非法盖网号！请重新输入或设置为空！";
    			$this->setFlash('error', $message);
    			$this->render('create', array(
    			     'model' => $model,
    	        ));
    			exit;
    		}
    		$set =substr($set,0,-1);
    		$sql = "update ".Machine::model()->tablename()." set ".$set." where id = ".$id;
    		Yii::app()->gt->createCommand($sql)->execute();
    		$this->redirect(array('admin'));
    	}
    	foreach ($arr as $val){
    		$Member = Member::model()->findByPk($model->$val);
    		$model->$val = empty($Member) ? '' : $Member['gai_number'];
    	}
    	$this->render('create', array(
    			'model' => $model,
    	));
    }
    
    /**
     * 删除
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        $oldMember = Member::model()->findByPk($model->intro_member_id);
        $model->intro_member_id = '';
        $model->save();
        
        @SystemLog::record(Yii::app()->user->name."移除盖机：".$model->name."[".$model->machine_code."]的推荐人：".$oldMember->gai_number);

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
    
    /**
     * 收益分配
     * @param machineID $id
     */
    public function actionDistribution($id){
    	$sql = "select * from ".OfflineDistribution::model()->tableName()." where machine_id = ".$id;
    	$model = OfflineDistribution::model ()->findBySql ($sql);
    	
     	if(empty($model)){
     		
    		if(isset($_POST['OfflineDistribution'])){
    			$model = new OfflineDistribution();
    			$model->machine_id = $id;
    			$model->record_type = 1;
    			$data = $_POST['OfflineDistribution'];
    		}else{
    			$model = new OfflineDistribution();
    			$data = $this->getConfig("allocation");
    		}
    		
    	}else{
    		if(!(isset($_POST['OfflineDistribution']))){  
    			$data = unserialize($model->distribution);
    		}else{
    			$data = $_POST['OfflineDistribution'];
    		}
    	} 
    	
    	$model->offRegion = $data["offRegion"];
    	$model->offProvince = $data["offProvince"];
    	$model->offCity = $data["offCity"];
    	$model->offDistrict = $data["offDistrict"];
    	$model->offMachineLine = $data["offMachineLine"];
    	$model->offMachineOperation = $data["offMachineOperation"];
    	$model->gateMachineRef = $data["gateMachineRef"];
    	$model->offManeuver = $data["offManeuver"];
    	$model->offConsumeNew = $data["offConsumeNew"];
    	$model->offRefNew = $data["offRefNew"];

    	if(isset($_POST['OfflineDistribution'])){
    		$string = serialize($data);
    		$model->distribution = $string;
    		if($model->save()){
    			$url = $this->createUrl('Machine/Admin');
    		    $this->redirect($url);
    		}
    		
    	}
    	$this->render('distribution', array(
    			'model' => $model,
    	));
    	
    }
    
    /**
     * 导入盖机的推荐人，运维人，铺机者
     */
    public function actionImport(){
    try {
			@ini_set('memory_limit', '2048M');
			@set_time_limit (0);
			$model = new Machine();
			$file = CUploadedFile::getInstance($model, 'file');
			
			if(!$file){
				$this->setFlash('error', "请选择文件！");
				$this->redirect(array('admin'));
			}
			if (pathinfo ( $file->name, PATHINFO_EXTENSION ) != 'xls' && pathinfo ( $file->name, PATHINFO_EXTENSION ) != 'xlsx') {
				$this->setFlash('error', "文件格式不正确，请上传xls或xlsx格式文件!");
				$this->redirect(array('admin'));
			}
			
			//引入phpExcel
			require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel/Shared/String.php';
			require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel.php';
			Yii::import('comext.phpexcel.*');
			Yii::registerAutoloader(array('PHPExcel_Autoloader', 'Register'), true);

			//读取Excel数据
			$filePath = $file->tempName;
			$excel = PHPExcel_IOFactory::load($filePath);
		    //操作第一个工作表
			$excel->setActiveSheetIndex(0);
			$objWorksheet = $excel->getActiveSheet();
			$highestRow = $objWorksheet->getHighestRow(); // 取得总行数

			if($highestRow <= 1) {
				$this->setFlash('error', '导入的数据不能为空白，请重新导入');
				$this->refresh();
				exit();
			}

			$sql = "update ".Machine::model()->tablename()." set intro_member_id = case machine_code %s end,install_member_id = case machine_code %s end,
					operate_member_id = case machine_code %s end where machine_code in(%s)";
            $sqlArr = array();
            
            //Excel表格数据列
			$highestColumn = array('machine_code','intro_member_id', 'install_member_id','operate_member_id');
			$introStr = '';
			$installStr = '';
			$operateStr = '';
			$whereStr = '';
			
			//从excel表第四行开始获取数据
			for ($row = 2; $row <= $highestRow; $row++) {
				$MemberId = array();
				foreach ($highestColumn as $k => $v) {
					$value = $objWorksheet->getCellByColumnAndRow($k, $row)->getValue();
					$value = is_object($value) ? $value->getPlainText() : $value;
					$value = mb_convert_encoding($value, "UTF-8",array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
					if($v != 'machine_code'){
						$select = "select id from {{member}} WHERE gai_number = '{$value}'";
						$id = Yii::app()->db->createCommand($select)->queryScalar();
						$id = $id != false ? $id : "0";
						$MemberId[$v] = $id;
					}else{
						$MemberId[$v] = $value;
					}
				}
				$introStr .= " when {$MemberId["machine_code"]} then {$MemberId["intro_member_id"]} ";
				$installStr .= " when {$MemberId["machine_code"]} then {$MemberId["install_member_id"]} ";
				$operateStr .= " when {$MemberId["machine_code"]} then {$MemberId["operate_member_id"]} ";
				$whereStr .= $MemberId["machine_code"].",";
				if(($row % 3000) == 0){//3000条数据一条sql语句
					$whereStr=substr($whereStr,0,-1);
					$sql = sprintf($sql,$introStr,$installStr,$operateStr,$whereStr);
					array_push($sqlArr, $sql);
					$sql = "update ".Machine::model()->tablename()." set intro_member_id = case machine_code %s end,install_member_id = case machine_code %s end,
					operate_member_id = case machine_code %s end where machine_code in(%s)";
					$introStr = '';
					$installStr = '';
					$operateStr = '';
					$whereStr = '';
				}	
			}
			
			$whereStr=substr($whereStr,0,-1);
			$sql = sprintf($sql,$introStr,$installStr,$operateStr,$whereStr);
			array_push($sqlArr, $sql);

			$connection=Yii::app()->gt;

			$transaction = $connection->beginTransaction();
			foreach ($sqlArr as $val){
				$connection->createCommand($val)->execute();
			}
			$transaction->commit();
			$this->setFlash('success',"导入成功！");
			$this->redirect(array('admin'));
		} catch (Exception $e) {
			$transaction->rollBack();
			$this->setFlash('error', $e->getMessage());
			$this->redirect(array('admin'));
		}
    }

}
