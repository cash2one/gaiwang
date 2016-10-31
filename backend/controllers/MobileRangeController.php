<?php
class MobileRangeController extends Controller{
	
	public function filters() {
		return array(
				'rights',
		);
	}

	/**
	 * 导入号码信息
	 */
	public function actionImport(){
		@ini_set('memory_limit', '2048M');
		@set_time_limit (0);
		$model = new MobileRange();
		$file = CUploadedFile::getInstance($model, 'file');
		if(!$file){
			$this->setFlash('error', "请选择文件！");
			$this->redirect(array('index'));
		}
		if(self::Decide($file->type)){
			$this->setFlash('error', "不支持此文件格式导入！最好请使用TXT文件，且内容格式为：运营商|省份|城市区号|城市名称|手机号前N位");
			$this->redirect(array('index'));
		}
		$str = file_get_contents($file->tempName);
		$str = str_replace("\n", "<br />",str_replace("\r", "<br />",str_replace("\r\n", "<br />",$str)));
		$str = @mb_convert_encoding($str, "UTF-8","ASCII,UTF-8,GB2312,GBK,BIG5");
		$strArr = explode("<br />", $str);
		if($strArr[count($strArr)-1] == "")array_pop($strArr);
		//运营商信息0未知,1移动,2联通,3电信
		$OperatorsArr = array("air"=>1,"unicom"=>2,"telecom"=>3);
		//省份信息
		$ProvinceArr = array("1"=>"北京","2"=>"上海","3"=>"天津","4"=>"重庆","5"=>"四川省","6"=>"广东省","7"=>"浙江省","8"=>"福建省","9"=>"湖南省","10"=>"湖北省",
				"11"=>"山东省","12"=>"山西省","13"=>"河南省","14"=>"河北省","15"=>"吉林省","16"=>"辽宁省","17"=>"黑龙江省","18"=>"安徽省","19"=>"江苏省","20"=>"江西省",
				"21"=>"海南省","22"=>"陕西省","23"=>"云南省");
		//获取平台的省份ID
		$data = Yii::app()->db->Createcommand()
		        ->select("id,name")
		        ->from(Region::model()->tablename())
		        ->where("depth = 1")
		        ->queryAll();
		$ProvinceDataArr = array();
		foreach ($data as $datakey=>$dataval){
			$ProvinceDataArr[$dataval["name"]] = $dataval["id"];
		}
		$sql = "INSERT INTO ".MobileRange::model()->tablename()." (operator,un_province_id,un_city_number,un_city_name,number_prefix,un_province_name,update_time,province_id) VALUES";
		$DeleteSql = "DELETE FROM ".MobileRange::model()->tablename();
		$result = true;
		$tempresult = false;
		$i = 1; //控制SQL语句分批执行
		$sqlArr = array();
		$date = time();
		foreach($strArr as $key=>$val){
			if($i<= 25000){
				//数据格式  operator|un_province_id|un_city_number|un_city_name|number_prefix
				//        运营商|省份ID|区号|城市名称|号码段
				$tempArr = explode("|", $val);
				if(!(isset($tempArr[0])&&isset($tempArr[1])&&isset($tempArr[2])&&isset($tempArr[3])&&isset($tempArr[4])))
				{
					$result = false;
					$error = $val;
					break;
				}
				//operator运营商
				$tempArr[0] = empty($OperatorsArr[$tempArr[0]]) ? 0 : $OperatorsArr[$tempArr[0]];
				//省份信息
				$ProvinceTemp = empty($ProvinceArr[$tempArr[1]]) ? "未知" : $ProvinceArr[$tempArr[1]];
				//数据库省份ID
				$ProvinceDataTemp = empty($ProvinceDataArr[$ProvinceTemp]) ? "未知" : $ProvinceDataArr[$ProvinceTemp];
			    
				$sql .= "(\"$tempArr[0]\",\"$tempArr[1]\",\"$tempArr[2]\",\"$tempArr[3]\",\"$tempArr[4]\",\"$ProvinceTemp\",\"$date\",\"$ProvinceDataTemp\"),";
				$i++;
			}else{
				$sql=substr($sql,0,-1);//去掉最后一个逗号
				array_push($sqlArr, $sql);
				$sql = "INSERT INTO gw_eptok_mobile_range (operator,un_province_id,un_city_number,un_city_name,number_prefix,un_province_name,update_time,province_id) VALUES";
				$i = 1;
			}
		}
		$sql=substr($sql,0,-1);//去掉最后一个逗号
		array_push($sqlArr, $sql);

		//插入数据库
		if($result){
			$connection=Yii::app()->db;
			$transaction = $connection->beginTransaction();
			//每次插入前先删除
			$connection->createCommand($DeleteSql)->execute();
			try {
				foreach ($sqlArr as $sqlKey=>$sqlVal){
					$connection->createCommand($sqlVal)->execute();
				}
				$transaction->commit();
				$this->setFlash('success',"导入成功！");
				$this->redirect(array('index'));
			} catch (Exception $e) {
				$transaction->rollBack();
				$this->setFlash('error', "数据库错误，请重新导入！");
			   $this->redirect(array('index'));
			} 
		}else{
			$this->setFlash('error', "文件的数据格式不符合规范！请修改为如下格式：运营商|省份|城市区号|城市名称|手机号前N位，最好请使用TXT文件格式");
			$this->redirect(array('index'));
		}

		
	}
	
    public function actionIndex(){
    	$model = new MobileRange();
    	if(isset($_GET['MobileRange'])){
    		$model->province_id = $_GET['MobileRange']["province_id"];
    		$model->un_city_name = $_GET['MobileRange']["un_city_name"];
    		$model->number_prefix = $_GET['MobileRange']["number_prefix"];
    		$model->operator = $_GET['MobileRange']["operator"];
    	}
    	$this->render('index',array(
    			'model'=>$model
    	));
    }
    
    //判断上传的文件类型
    public static function Decide($Type){
    	$uptypes=array(
    			'image/jpg',
    			'image/jpeg',
    			'image/png',
    			'image/pjpeg',
    			'image/gif',
    			'image/bmp',
    			'image/x-png',
    			'application/vnd.ms-excel',
    			'application/x-excel',
    			'application/msword',
    			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    	);
    	return in_array($Type, $uptypes);
    
    }
    
}