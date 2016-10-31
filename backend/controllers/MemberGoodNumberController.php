<?php

class MemberGoodNumberController extends Controller
{
	public function actionIndex()
	{
		$model = new MemberGoodNumber();
		if(isset($_GET['MemberGoodNumber'])){
			$model->number = $_GET['MemberGoodNumber']['number'];
		}
		$this->render('index',array(
				'model'=>$model,
		));
	}
	
	//删除
	public function actionDelete($number){
		$sql = "Delete from ".MemberGoodNumber::model()->tablename()." where number = '".$number."'";
		Yii::app()->db->createCommand($sql)->execute();
		$this->redirect(array('index'));
	}
	
	public function actionCreate($type){
		@set_time_limit (0);
		//$type = mt_rand(2, 4);
		self::CreateGoodNumber($type);
	}
	
	public static function CreateGoodNumber($numbertype){
		$sqlarr = array();
		try {
			$sql = "INSERT IGNORE INTO ".MemberGoodNumber::model()->tableName()." (number,type) VALUES";
			$number = 1;
			do{
				$numberarr = array();
				$number++;
				$init = mt_rand(1, 2);
				switch($numbertype){
					case '2':
						$type = $init == 1 ? "AAAA" : "ABAB";
						$result = self::GoodNumberTwo($init);
						break;
					case '3':
						$type = $init == 1 ? "AAA" : "ABC";
						$result = self::GoodNumberThree($init);
						break;
					case '4':
						$type = "ABCD";
						$result = self::GoodNumberFour($init);
						break;
				}
				array_push($numberarr, $result);
				
				for($i = strlen($result); $i < 8;$i++){
					array_push($numberarr, mt_rand(0, 9));
				}
				shuffle($numberarr);
				$resultnum = implode('', $numberarr);
				$year = substr($resultnum, 0,4);
				$month = substr($resultnum, 4,2);
				$day = substr($resultnum, 6,2);
                $result = self::Rules($year, $month, $day,$type);
                if($result){
                	$sql .= "('".$resultnum."','".$result."'),";
                	if($number % 500000 == 0){
                		//var_dump($number);//die();
                		$sql=substr($sql,0,-1);
                		array_push($sqlarr, $sql);
                		unset($sql);
                		$sql = "INSERT IGNORE INTO ".MemberGoodNumber::model()->tableName()." (number,type) VALUES";
                	}
                }
				
			}while($number < 2499999);
			$sql = substr($sql,0,-1);
// 			if($sql != "INSERT IGNORE INTO {{member_good_number}} (number,type) VALUE"){
// 				Yii::app()->db->createCommand($sql)->execute();
// 			}
			array_push($sqlarr, $sql);
			foreach ($sqlarr as $sqlkey=>$sqlval){
				Yii::app()->db->createCommand($sqlval)->execute();
			}
			
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
	/**
	 * 生成两位数相连的靓号[AA AA],[AB AB]
	 */
	public static function GoodNumberTwo($init){
		switch($init){
			//AAAA模式
			case '1':
				$number = mt_rand(0, 9);
				$number = $number.$number.$number.$number;
				break;
		    //ABAB模式
			case '2':
				do {
					$number = mt_rand(0, 9);
				}while($number > 8);
				$number2 = $number+1;
				$number = $number.$number2.$number.$number2;
				break;
		}
		return $number;
	} 
	
	/**
	 * 生成三位数的靓号[AAA],[ABC]
	 */
	private static function GoodNumberThree($init){
		switch($init){
			//AAA模式
			case '1':
				$number = mt_rand(0, 9);
				$number = $number.$number.$number;
				break;
			//ABC模式
			case '2':
				do {
					$number = mt_rand(0, 9);
				}while($number > 7);
				$number2 = $number+1;
				$number3 = $number+2;
				$number = $number.$number2.$number3;
				break;
		}
		return $number;
	}
	
	/**
	 * 
	 * 生成四位数的靓号[ABCD]
	 */
	public static function GoodNumberFour($init){
		do {
			$number = mt_rand(0, 9);
		}while($number > 6);
		$number2 = $number+1;
		$number3 = $number+2;
		$number4 = $number+3;
		$number = $number.$number2.$number3.$number4;
		return $number;
	}
	
	public static function Rules($year,$month,$day,$type){
		if(($year >= 1950 && $year <= 2010) &&  ($month >= 01 && $month <= 12) &&  ($day >= 01 && $day <= 31)){
			$type = "YYYYMMDD";
			return $type;
		}else{
			return $type;
		}
		
	}
}