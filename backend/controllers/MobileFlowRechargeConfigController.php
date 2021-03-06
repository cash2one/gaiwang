<?php
class MobileFlowRechargeConfigController extends Controller{
	public function filters() {
		return array(
				'rights',
		);
	}
	
	public function actionIndex(){
		$model = new MobileFlowRechargeConfig();
		if(isset($_GET['MobileFlowRechargeConfig'])){
			$model->amount = $_GET['MobileFlowRechargeConfig']['amount'];
			$model->operator = $_GET['MobileFlowRechargeConfig']['operator'];
		}
		$this->render('index',array(
				'model'=>$model,
		));
	}
	
	public function actionImport(){
		try {
			@ini_set('memory_limit', '2048M');
			@set_time_limit (0);
			$model = new MobileFlowRechargeConfig();
			$file = CUploadedFile::getInstance($model, 'file');
			if(!$file){
				$this->setFlash('error', "请选择文件！");
				$this->redirect(array('index'));
			}
			if (pathinfo ( $file->name, PATHINFO_EXTENSION ) != 'xls' && pathinfo ( $file->name, PATHINFO_EXTENSION ) != 'xlsx') {
				$this->setFlash('error', "文件格式不正确，请上传xls或xlsx格式文件!");
				$this->redirect(array('index'));
			}

			//引入phpExcel
			require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel/Shared/String.php';
			require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel.php';
			Yii::import('comext.phpexcel.*');
			Yii::registerAutoloader(array('PHPExcel_Autoloader', 'Register'), true);

			//读取Excel数据
			$filePath = $file->tempName;
			$excel = PHPExcel_IOFactory::load($filePath);
			if($excel->getSheetCount() != 4){
				$this->setFlash('error', "xls或xlsx文件模板不正确，请选择正确的文件模板并确保需要导入的流量信息保存在第三个工作表!");
				$this->redirect(array('index'));
			}
		    //操作第三个工作表
			$excel->setActiveSheetIndex(2);
			$objWorksheet = $excel->getActiveSheet();
			$highestRow = $objWorksheet->getHighestRow(); // 取得总行数

			if($highestRow <= 1) {
				$this->setFlash('error', '导入的数据不能为空白，请重新导入');
				$this->refresh();
				exit();
			}
			$sql = 'insert into '.MobileFlowRechargeConfig::model()->tablename().' (province_id,operator,price,amount,pay_percent,update_time,un_province_id,use_target,un_percent) values';
			//运营商信息0未知,1移动,2联通,3电信
			$OperatorsArr = array("移动"=>1,"联通"=>2,"电信"=>3);
			//省份信息
			$ProvinceArr = array("北京"=>"1","上海"=>"2","天津"=>"3","重庆"=>"4","四川"=>"5","广东"=>"6","浙江"=>"7","福建"=>"8","湖南"=>"9","湖北"=>"10",
					"山东"=>"11","山西"=>"12","河南"=>"13","河北"=>"14","吉林"=>"15","辽宁"=>"16","黑龙江"=>"17","安徽"=>"18","江苏"=>"19","江西"=>"20",
					"海南"=>"21","陕西"=>"22","云南"=>"23");
			//获取平台的省份ID
			$data = Yii::app()->db->Createcommand()
			->select("id,name")
			->from(Region::model()->tablename())
			->where("depth = 1")
			->queryAll();
	
			$ProvinceDataArr = array();
			foreach ($data as $key=>$val){
				$val["name"] = substr($val["name"], 0,6);
				$ProvinceDataArr[$val["name"]] = $val["id"];
			}
			$ProvinceDataArr["全国"] = "1";
			 
			$highestColumn = array('id','un_province_id', 'operator','price','amount','use_target','pay_percent');
			$temp = array();
			foreach ($highestColumn as $k => $v) {
				$value = $objWorksheet->getCellByColumnAndRow($k, 5)->getValue();
				$value = is_object($value) ? $value->getPlainText() : $value;
				$value = mb_convert_encoding($value, "UTF-8",array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
				$temp[$v] = str_replace("（", "(", str_replace("）", ")",$value));
			}
			//var_dump($temp);die();
			if($temp["id"] != "序号" || $temp["un_province_id"] != "充值省份" || $temp["operator"] != "运营商" || $temp["price"] != "面值" || $temp["amount"] != "流量值(MB)" || $temp["use_target"] != "使用范围" || $temp["pay_percent"] != "统一销售政策"){
				$this->setFlash('error', "导入流量价格信息工作表内容格式不正确!");
				$this->redirect(array('index'));
			}
			$Lastdata = array();
			$excelData = array(); //excel 数据
			$excelData["update_time"] = time();
			//从excel表第四行开始获取数据
			for ($row = 6; $row <= $highestRow; $row++) {
				foreach ($highestColumn as $k => $v) {
					$value = $objWorksheet->getCellByColumnAndRow($k, $row)->getValue();
					$value = is_object($value) ? $value->getPlainText() : $value;
					$value = mb_convert_encoding($value, "UTF-8",array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));

					if($value == ""){
						$value = $Lastdata[$k];
					}
					$Lastdata[$k] = $value;
					//运营商处理
					if($value == '交通罚款代缴业务'){
						break 2;
					}
					if($k == '2'){
						$value = empty($OperatorsArr[$value]) ? 0 : $OperatorsArr[$value];
					}
					//省份ID处理
					if($k == '1'){
						$excelData["province_id"] = empty($ProvinceArr[$value]) ? 0 : $ProvinceArr[$value];
						$value = substr($value, 0,6);
						$value = empty($ProvinceDataArr[$value]) ? 0 : $ProvinceDataArr[$value];
					}
					//省份ID处理
					if($k == '5'){
						$value = substr($value, 0,6);
						$value = empty($ProvinceDataArr[$value]) ? 0 : $ProvinceDataArr[$value];
					}
					$excelData[$v] = $value;
					//折扣处理
					if($k == '6'){
						$value = $value*100;
						$excelData['un_percent'] = $value;
						$excelData['pay_percent'] = $value + 0.1;
					}
					
				}
				$temp = '("'.$excelData['un_province_id'].'","'.$excelData['operator'].'","'.$excelData['price'].'","'.$excelData['amount'].'","'.$excelData['pay_percent'].'","'.$excelData['update_time'].'","'.$excelData['province_id'].'","'.$excelData['use_target'].'","'.$excelData['un_percent'].'")';
				if(!(strstr($sql,$temp))){
					$sql .= $temp.",";
				}
				
			}
			
			$sql=substr($sql,0,-1);
			$connection=Yii::app()->db;

			$transaction = $connection->beginTransaction();
			//每次插入前先删除
			$DeleteSql = "DELETE FROM ".MobileFlowRechargeConfig::model()->tablename();
			$connection->createCommand($DeleteSql)->execute();
			$connection->createCommand($sql)->execute();
			$transaction->commit();
			$this->setFlash('success',"导入成功！");
			$this->redirect(array('index'));
		} catch (Exception $e) {
			$transaction->rollBack();
			$this->setFlash('error', $e->getMessage());
			$this->redirect(array('index'));
		}
	}
}