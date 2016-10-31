<?php

class OfflineSignContractController extends Controller
{
	/**
	 * 添加新客户
	 */
	public function actionNewFranchisee(){
		$model = new OfflineSignContract();
		$model->number = OfflineSignContract::createContractNumber();
		$tempName = OfflineSignContract::getEnterpriseName();
		$model->a_name = $tempName;
        $this->performAjaxValidation($model);
		if(isset($_POST['OfflineSignContract'])){
			$dataArr = $this->getPost('OfflineSignContract');
			$model->attributes = $dataArr;
            $model->machine_developer = $dataArr['machine_developer'];
            $model->sign_time = strtotime($dataArr['sign_time']);
			OfflineSignContract::setContractAdExpires($model,$dataArr);//设置广告起止时间
			if($model->save()){
				//生成资质表信息id
				$extendId = OfflineSignStoreExtend::createExtend($model->id);
				//生成审核进度
				$auditModel = new OfflineSignAuditLogging($extendId,'1101');
				$auditModel->save(false);
				$this->setFlash('success', '添加成功');
				if($dataArr['step'] == OfflineSignContract::LAST_STEP){
					//跳转到打印页面
					$this->redirect(array('offlineSignContract/printView','contractId'=>$model->id,'name'=>$model->b_name));
				}
				if($dataArr['step'] == OfflineSignContract::NEXT_STEP){
					$this->redirect(array('offlineSignEnterprise/create','storeExtendId'=>$extendId));
				}
			}else{
                $model->sign_time = empty($model->sign_time) ? '' : date('Y-m-d',$model->sign_time);
            }
		}
		$this->render('newFranchisee',array(
			'model'=>$model,
		));
	}


	/**
	 * ajax实现自动回填合同结束时间
	 */
	public function actionReturnEndTime(){
		if ($this->isAjax() && $this->isPost()) {
			$benginTime = $this->getPost('benginTime');
			$contractTerm = $this->getPost('contractTerm');
			$endTiem = strtotime($benginTime .' +'.$contractTerm.' months');		//加上合作期限
			$endTiem = $endTiem - 24*60*60;											//减去一天
			$endTiem = date('Y-m-d',$endTiem);										//格式化时间
			exit(json_encode(array('endTiem' => $endTiem)));
		}
	}

	/**
	 * 新入驻商家 编辑电签
	 */
	public function actionNewFranchiseeUpdate($id){
        $extendModel = OfflineSignStoreExtend::model()->findByPk($id);
		$storeExtendId = $extendModel->id;
		$enterpriseId = $extendModel->offline_sign_enterprise_id;
        $model = OfflineSignContract::getOfflineSiginInfos($extendModel->offline_sign_contract_id);
        $this->performAjaxValidation($model);
		if($this->isPost()){
            $model = OfflineSignContract::model()->findByPk($extendModel->offline_sign_contract_id);
			$postData = $this->getPost('OfflineSignContract');
            $model->attributes = $postData;
            $model->sign_time = strtotime($postData['sign_time']);
            $model->machine_developer = $postData['machine_developer'];
			OfflineSignContract::setContractAdExpires($model,$postData);//设置广告起止时间
			if($model->save()){
				//生成审核进度
				$auditModel = new OfflineSignAuditLogging();
				$auditModel->extend_id = $storeExtendId;
				$auditModel->audit_role = OfflineSignAuditLogging::ROLE_AGENT;
				$auditModel->behavior = '1104';
				$auditModel->save(false);
				$this->setFlash('success', '修改成功');
				if($postData['step'] == OfflineSignContract::LAST_STEP){
					$this->redirect(array('offlineSignContract/printView','contractId'=>$model->id,'name'=>$model->b_name));
				}else if($postData['step'] == OfflineSignContract::NEXT_STEP){
					$this->redirect(array('offlineSignEnterprise/update','enterpriseId'=>$enterpriseId,'storeExtendId'=>$storeExtendId));
				}
			}else{
                $model->sign_time = empty($model->sign_time) ? '' : date('Y-m-d',$model->sign_time);
            }
		}
		//根据广告合约类型 格式化指定合约类型广告起止时间
		OfflineSignContract::formatContractAdExpires($model);
		$this->render('update',array('model'=>$model,));
	}

	/**
	 * 打印合同视图
	 */
	public function actionPrintView(){
		$id = $this->getParam('contractId');
		$name = $this->getParam('name');
		$this->render('printView',array('contractId'=>$id,'name'=>$name));
	}

	/**
	 * 打印合同
	 * @throws CException
	 */
	public function actionPrintContract(){
		$criteria=new CDbCriteria;
		$criteria->select = 'id,title,content';
		$criteria->order = ' id desc';
		$criteria->limit = 1;
		$contractModel = OfflineSignContract::model()->findByPk($this->getParam('contractId'));
        $extendModel = OfflineSignStoreExtend::model()->findByPk($this->getParam('extendId'));
		$data = $contractModel->attributes;

		//查询加盟商的区域
        $enterprise_id = Yii::app()->db->createCommand()
            ->select('enterprise_id')
            ->from(Member::model()->tableName())
            ->where('id=:id',array(':id'=>Yii::app()->user->id))
            ->queryScalar();
        if(!empty($enterprise_id)) {
            $area = Yii::app()->db->createCommand()
                ->select('province_id,city_id,district_id,street')
                ->from(Enterprise::model()->tableName())
                ->where('id=:id', array(':id' => $enterprise_id))
                ->queryRow();
        }
        $data['a_area'] = '';
        if(!empty($area)){
            $areaIds = $area['province_id'] . "," . $area['city_id'] . "," . $area['district_id'];
            $areastr = implode('',Region::getNameArray($areaIds));
            $data['a_area']= $areastr . $area['street'];
        }
        $Ptree = Yii::app()->db->createCommand()
            ->select('name,tree,parent_id')
            ->from(Region::model()->tableName())
            ->where('member_id=:id',array(':id'=>Yii::app()->user->id))
            ->queryRow();
        $data['p_area'] = '';
        if(!empty($Ptree)){
            if($Ptree['parent_id'] <= 1) {
                $data['p_area'] = $Ptree['name'];
            }else{
                $PareaArr = explode('|',$Ptree['tree']);
                $areaId = '(';
                if(is_array($PareaArr)){
                    foreach($PareaArr as $key=>$val){
                        if($key != 0)
                            $areaId .= $val.',';
                    }
                    $areaId = rtrim($areaId,',');
                }
                $areaId .= ')';
            }
        }
        if(empty($data['p_area'])){
            $Ptree = Yii::app()->db->createCommand()
                ->select('name')
                ->from(Region::model()->tableName())
                ->where('id in '.$areaId)
                ->order('id asc')
                ->queryAll();
            if(!empty($Ptree)){
                foreach($Ptree as $val){
                    $data['p_area'] .= $val['name'];
                }
            }
        }

		$regionIds = $contractModel->province_id . "," . $contractModel->city_id . ',' . $contractModel->district_id;
		$data['b_area']= implode('',Region::getNameArray($regionIds)) . $contractModel->address;				//乙方地址

		$data['contract_term']= OfflineSignContract::getContractTerm($contractModel->contract_term); 											//合作期限
		$data['beginYear']= date('Y',$contractModel->begin_time);
		$data['beginMonth']= date('m',$contractModel->begin_time);
		$data['beginDay']= date('d',$contractModel->begin_time);
		$data['endYear']= date('Y',$contractModel->end_time);
		$data['endMonth']= date('m',$contractModel->end_time);
		$data['endDay']= date('d',$contractModel->end_time);
		//方式一二三
		switch ($contractModel->operation_type) {
			case OfflineSignContract::OPERATION_TYPE_ONE:
				$data['ad_begin_time_hour_one']= $contractModel->ad_begin_time_hour;
				$data['ad_begin_time_minute_one']= $contractModel->ad_begin_time_minute;
				$data['ad_end_time_hour_one']= $contractModel->ad_end_time_hour;
				$data['ad_end_time_minute_one']= $contractModel->ad_end_time_minute;
				$data['operaOneNum'] = '详见附件';
				break;
			case OfflineSignContract::OPERATION_TYPE_TWO:
				$data['ad_begin_time_hour_two']= $contractModel->ad_begin_time_hour;
				$data['ad_begin_time_minute_two']= $contractModel->ad_begin_time_minute;
				$data['ad_end_time_hour_two']= $contractModel->ad_end_time_hour;
				$data['ad_end_time_minute_two']= $contractModel->ad_end_time_minute;
				$data['operaTwoNum'] = '详见附件';
				$data['payNum'] = 25000;
				break;
			case OfflineSignContract::OPERATION_TYPE_THREE:
				$data['ad_begin_time_hour_three']= $contractModel->ad_begin_time_hour;
				$data['ad_begin_time_minute_three']= $contractModel->ad_begin_time_minute;
				$data['ad_end_time_hour_three']= $contractModel->ad_end_time_hour;
				$data['ad_end_time_minute_three']= $contractModel->ad_end_time_minute;
				$data['operaThrNum'] = '详见附件';
				$data['payNum'] = 10000;
				break;
		}
		//甲方银行卡信息
		$aBank = Yii::app()->db->createCommand()
							->select('bank_name as aBankName,account_name as aAccountName,account as aAccount')
							->from(BankAccount::model()->tableName())
							->where('member_id=:id',array(':id'=>Yii::app()->user->id))
							->queryRow();
        if(!$aBank)
            $aBank = array('aBankName' => '', 'aAccountName' => '', 'aAccount' => '');
		$data = array_merge($data,$aBank);
		$regionIds = $contractModel->p_province_id . "," . $contractModel->p_city_id . ',' . $contractModel->p_district_id;
		$data['installarea']= implode('',Region::getNameArray($regionIds));					//盖网通铺设地址
		$data['machine_style'] = '详见附件';
        $data['franchisee_name'] = '详见附件';
        $data['machine_administrator'] = '详见附件';
        $data['machine_administrator_mobile'] = '详见附件';
        $data['member_discount'] = '详见附件';
        $data['discount'] = '详见附件';
        $data['machine_number'] = '详见附件';
		$contractContent = Tool::getConfig('offlinesigncontract','file');
		//替换内容
		foreach($data as $key => $value){
			$contractContent = str_replace('{{'.$key.'}}', $value, $contractContent);
		}
		//空白内容替换为 /
		$contractContent = preg_replace('/\{\{[a-z_A-Z]+\}\}/','/',$contractContent);
		$contractContent = stripcslashes($contractContent);
		$this->renderPartial('printContract',array('content'=>$contractContent));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return OfflineSignContract the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=OfflineSignContract::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param OfflineSignContract $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']))
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
