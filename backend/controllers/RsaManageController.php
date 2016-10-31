<?php

class RsaManageController extends Controller
{
	public function actionIndex()
	{
	    $model = new RsaManage();
		$this->render('index',array(
				'model'=>$model
		));
	}
	
	/*
	 * 创建商户号秘钥
	 */
	public function actionCreate(){
		try {
			$id = $_POST['id'];
			$model = RsaManage::model()->findByPk($id);
			$keyArr = RsaManage::createRsaKey();
			$model->update = time();
			$model->user_id = Yii::app()->user->id;
			$model->public_key = $keyArr['publicKey'];
			$model->private_key = $keyArr['privateKey'];
			if($model->save()){
				exit (json_encode("成功生成秘钥！"));
			}else{
				exit (json_encode("生成秘钥失败！请重新生成！"));
			}
		} catch (Exception $e) {
			exit (json_encode($e->getMessage()));
		}
	}
	
	/*
	 * 创建商户号
	 */
	public function actionCreateMerchant(){
		$model = new RsaManage();
		//获取最新的商户号
		$Merchant = Yii::app()->db->createCommand()
		            ->select("merchant_num")
		            ->from(RsaManage::model()->tableName())
		            ->order("id desc")
		            ->limit("1")
		            ->queryScalar();
		$Merchant = (!$Merchant) ? "10000001" : (int)$Merchant ;
		$Merchant ++ ;
        $time = time();
        $model->user_id = Yii::app()->user->id;
        $model->merchant_num = $Merchant;
        $model->status = RsaManage::Status_NO;
        $model->create_time = $time;
        $model->update = $time;
        if($model->save()){
        	$this->setFlash('success', "成功创建商户号！");
        }else{
        	$this->setFlash('error', "创建商户号失败！");
        }
        $this->redirect(array('/RsaManage/Index'));
	}
	
	
	public function actionDelete($id){
		$model = new RsaManage();
		$DelSql = "delete from ".RsaManage::model()->tableName()." where id = '".$id."'";
		YII::app()->db->createCommand($DelSql)->execute();
		$this->redirect(array('/RsaManage/Index'));
	}

	public function actionView($id){
		$model = RsaManage::model()->findByPk($id);
		//修改秘钥状态
		if(isset($_POST["RsaManage"])){
			$model->status = $_POST['RsaManage']['status'];
			$model->update = time();
			$model->user_id = Yii::app()->user->id;
			if($model->save()){
				$this->setFlash('success', "保存成功！");
			}else{
				$this->setFlash('error', "保存失败！");
			}
			$this->redirect(array('/RsaManage/Index'));
		}
		$this->render('view',array(
				'model'=>$model,
		));
		
	}
	
	/*
	 * 导出秘钥
	 */
	public function actionExport($id){
		$key = Yii::app()->db->createCommand()
		       ->select("public_key")
		       ->from(RsaManage::model()->tableName())
		       ->where("id = '".$id."'")
		       ->queryScalar();
		$cerpath = "credentials.cer"; //生成证书路径
		//生成证书文件
		file_put_contents($cerpath,$key);
		header('Content-type: application/x-x509-ca-cert');//输出的类型
		header('Content-Disposition: attachment; filename="credentials.cer"'); //下载显示的名字,注意格式
		readfile("credentials.cer");
		unlink("credentials.cer");
	}
}