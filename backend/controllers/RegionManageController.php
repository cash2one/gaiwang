<?php

use OAuth2\Util\RedirectUri;
class RegionManageController extends Controller
{
	public function filters() {
		return array(
				'rights',
		);
	}
	
	
	public function actionIndex()
	{
		$model = New RegionManage();
		if(isset($_GET['RegionManage'])){
			$model->name = $_GET['RegionManage']["name"];
		}
		$this->render('index',array(
				'model'=>$model,
		));
	}

	
	public function actionCreateRegion(){
		$model = New RegionManage();
		if(isset($_POST['RegionManage'])){
			$model->member_gw = $_POST['RegionManage']['member_gw'];
			$model->name = $_POST['RegionManage']['name'];
			if(empty($_POST['RegionManage']['city_id'])){
				$this->setFlash('error', "请选择大区所属城市！");
				$this->render('create',array(
						'model'=>$model,
				));
				exit;
			}
			//判断是否存在同名大区
			$daqu = $data = Yii::app()->db->createCommand()
			->select('id')
			->from(RegionManage::model()->tablename())
			->where("name = '".$_POST['RegionManage']['name']."'")
			->queryAll();
			if(count($daqu) >= 1){
				$this->setFlash('error', "已存在此大区！");
				$model->city_id = $_POST['RegionManage']['city_id'];
				$this->render('create',array(
						'model'=>$model,
				));
				exit;
			}
			//判断代理人是否存在
			if(empty($_POST['RegionManage']['member_gw'])){
				$model->member_id = 0;
				$result = false;
			}else{
				$data = Yii::app()->db->createCommand()
				->select('id')
				->from(Member::model()->tablename())
				->where("gai_number = '".$_POST['RegionManage']['member_gw']."'")
				->queryScalar();
				$model->member_id = $data == false ? 0 : $data;
				$result = empty($data);
			}
			if(!$result){
				$model->name = $_POST['RegionManage']['name'];
				if($model->save()){
					$id = $_POST['RegionManage']['city_id'];
					if(is_array($id)){
						$id = implode(',', $id);
						$RegionManageId =  Yii::app()->db->getLastInsertID();
					    $sql = "update ".Region::model()->tablename()." set manage_id = ".$RegionManageId." where id in(".$id.")";
					    Yii::app()->db->createCommand($sql)->execute();
					}
					$this->redirect(array('index'));
				}else{
					$this->render('create',array(
							'model'=>$model,
					));
				}
			}else{
				$this->setFlash('error', "盖网号错误或不存在此盖网号！你可以将GW号设置为空！");
				$this->render('create',array(
						'model'=>$model,
				));
			}
		}else{
			$this->render('create',array(
					'model'=>$model,
			));
		}
		
	}
	
	public function actionUpdate($id){
		$model = new RegionManage();
		$sql = "select id from ".Region::model()->tablename()." where manage_id = '".$id."'";
		$SelectRegiondata = YII::app()->db->createCommand($sql)->querycolumn();
		$modelSql = "SELECT r.*,m.gai_number FROM gw_region_manage as r LEFT JOIN gw_member as m ON r.member_id = m.id
where r.id = '".$id."'";
		$data = YII::app()->db->createCommand($modelSql)->queryRow();
		$model->member_gw = $data["gai_number"];
		$model->name = $data["name"];
		$model->city_id = $SelectRegiondata;
		$model->id = $id;
		$this->render('create',array(
				'model'=>$model,
				'type'=>'update',
		));
	}
	
	public function actionSaveRegion($id){
		$sql = "select * from ".RegionManage::model()->tableName()." where id = '".$id."'";
		$model = RegionManage::model()->findBysql($sql);
		$model->member_gw = $_POST['RegionManage']['member_gw'];
		$model->name = $_POST['RegionManage']['name'];
		if(empty($_POST['RegionManage']['city_id'])){
			$this->setFlash('error', "请选择大区所属城市！");
			$this->render('create',array(
					'model'=>$model,
					'type'=>'update',
			));
			exit;
		}
		//判断是否存在同名大区
		$daqu = $data = Yii::app()->db->createCommand()
		->select('id')
		->from(RegionManage::model()->tablename())
		->where("name = '".$_POST['RegionManage']['name']."'")
		->queryAll();
		if(count($daqu) >= 1){
			if($id != $daqu[0]['id']){
				$this->setFlash('error', "已存在此大区！");
				$model->member_gw = $_POST['RegionManage']['member_gw'];
				$model->city_id = $_POST['RegionManage']['city_id'];
				$this->render('create',array(
						'model'=>$model,
						'type'=>'update',
				));
				exit;
			}
		}
	    //判断代理人是否存在
		if(empty($_POST['RegionManage']['member_gw'])){
			$model->member_id = 0;
			$result = false;
		}else{
			$data = Yii::app()->db->createCommand()
			->select('id')
			->from(Member::model()->tablename())
			->where("gai_number = '".$_POST['RegionManage']['member_gw']."'")
			->queryScalar();
			$result = empty($data);
			$model->member_id = $data == false ? 0 : $data;
		}
		if(!$result){
			$model->name = $_POST['RegionManage']['name'];
			if($model->save()){
				//数据库原有的大区所属
				$sql = "select id from ".Region::model()->tablename()." where manage_id = '".$id."'";
				$SelectRegiondata = YII::app()->db->createCommand($sql)->querycolumn();
				$city_id = $_POST['RegionManage']['city_id']; //更改后的所属大区
				if(!is_array($city_id)){
					$city_id = array();
				}
				$arr = array_diff($SelectRegiondata, $city_id); // $arr 要删除的元素数组
				$arr1 = array_diff($city_id, $SelectRegiondata); //$arr1 要添加的元素数组
				if(!empty($arr)){
					$arr  = implode(',', $arr);
					$sql = "update ".Region::model()->tablename()." set manage_id = '' where id in(".$arr.")";
					Yii::app()->db->createCommand($sql)->execute();
				} 
				if(!empty($arr1)){
					$arr1  = implode(',', $arr1);
					$sql1 = "update ".Region::model()->tablename()." set manage_id = ".$id." where id in(".$arr1.")";
					Yii::app()->db->createCommand($sql1)->execute();
				}
				$this->redirect(array('index'));
			}else{
				$this->render('create',array(
						'model'=>$model,
						'type'=>'update'
				));
			}
		}else{
			$this->setFlash('error', "盖网号错误或不存在此盖网号！你可以将GW号设置为空！");
			$model->member_gw = $_POST['RegionManage']['member_gw'];
			$model->name =$_POST['RegionManage']["name"];
			$model->city_id = $_POST['RegionManage']['city_id'];
			$model->id = $id;
			$this->render('create',array(
					'model'=>$model,
					'type'=>'update',
			));
			exit;
		}
	}

	public function actionDelete($id){
		//数据库原有的大区所属
		$sql = "select id from ".Region::model()->tablename()." where manage_id = '".$id."'";
		$SelectRegiondata = YII::app()->db->createCommand($sql)->querycolumn();
		if(!empty($SelectRegiondata)){
			$arr  = implode(',', $SelectRegiondata);
			$sql = "update ".Region::model()->tablename()." set manage_id = '' where id in(".$arr.")";
			Yii::app()->db->createCommand($sql)->execute();
		}
		$deletesql = "delete from ".RegionManage::model()->tablename()." where id = '".$id."'";
		Yii::app()->db->createCommand($deletesql)->execute();
		$this->redirect(array('index'));
	}
	
	public function actionSaveGW($id){
		$model = New RegionManageRelation();
		$model->region_manage_id = $id;
		if(isset($_GET['RegionManageRelation'])){
			$model->username = $_GET['RegionManageRelation']["username"];
		}
		$this->render('relation',array(
				'model'=>$model,
				'id'=>$id,
		));
	}
	
	public function actionRelationCreate($id){
		$model = new RegionManageRelation();
		if(isset($_POST['RegionManageRelation'])){
			$model->username = $_POST['RegionManageRelation']["username"];
			$sql = "SELECT id FROM ".User::model()->tablename()." where username ='".$model->username."'";
			$data = Yii::app()->db->createCommand($sql)->queryScalar();
			if(!empty($data)){
				$model->user_id = $data;
				$sql = "SELECT id FROM ".RegionManageRelation::model()->tableName()." where user_id ='".$data."' and region_manage_id = '".$id."'";
				$data = Yii::app()->db->createCommand($sql)->queryScalar();
				if(empty($data)){
					$model->region_manage_id = $id;
					if($model->save()){
						$this->redirect(array('SaveGW','id'=>$id));
					}
				}else{
					$this->setFlash('error', "同一个大区不能重复添加相同账号！");
					$this->render('relationcreate',array(
							'model'=>$model,
							'id'=>$id,
					));
					exit;
				}
				
			}else{
				$this->setFlash('error', "会员账号不存在！请重新输入！");
				$this->render('relationcreate',array(
						'model'=>$model,
						'id'=>$id,
				));
				exit;
			}
		}
		$this->render('relationcreate',array(
				'model'=>$model,
				'id'=>$id,
		));
	}
	
	public function actionRelationDelete($id){
		$deletesql = "delete from ".RegionManageRelation::model()->tablename()." where id = '".$id."'";
		Yii::app()->db->createCommand($deletesql)->execute();
		$this->redirect(array('SaveGW','id'=>$id));
	}
}