<?php

/**
 * 导入商城用户到盖讯通
 *
 * @author csj leo8705
 */
class GaixuntongUserCommand extends CConsoleCommand {

public function actionIndex($max_id=0) {
        @ini_set('memory_limit','1280M');
        set_time_limit(3600);
        
        $passwordKey='JHTeQEQveBx1isY2';			//api openfire密码加密串
        $apikey = '!@*^juyou#i@*%$';

        $max_id = $max_id*1;
        
        $user_cri = new CDbCriteria();
        $user_cri->select = 'gai_number,username,password,salt,sex,mobile,email,register_time,head_portrait,nickname';
        if ($max_id>0)  $user_cri->addCondition(" id<{$max_id} ");
//        $user_cri->limit=10;
        
        $members = Member::model()->findAll($user_cri);
        
        $transaction1 = Yii::app()->gxt_api->beginTransaction();
        $transaction2 = Yii::app()->gxt_xmpp->beginTransaction();
        
        //主逻辑
        $file_data = '';
        $file_data2 = '';
        $c = 0;
 		$ic = 0;
 		$max_c = 1000;
 		
 		
 		
 		try {
		
		foreach ($members as $value){
			$rand = rand(1000, 1000000);
			$user_id = md5(time().$rand.$c);
			$c++;
			$nickname = empty($value['nickname'])?$value['username']:$value['nickname'];
			$value['username'] = empty($value['username'])?$value['gai_number']:$value['username'];
			$value['register_time'] = empty($value['register_time'])?time():$value['register_time'];
			
			//$password = rand(1000000, 9999999);
			$password = 'gatewang2014';
			$password_hash = md5($password);
			
			$file_data .= '("' . $user_id . '","' . $value['gai_number'] . '","' . $value['password'] . '","' . $value['username'] . '","' . date('Y-m-d G:i:s',$value['register_time']) . '","' . $value['sex'] . '","' . 1 . '","' . $value['gai_number'] . '","' . $value['mobile'] . '","' . $value['salt'] . '","' . $value['email'] . '","' . $nickname . '","' . $apikey . '","0"),';
			$file_data2 .= '("' . $user_id . '","' . $password . '","' . $password_hash . '","' . $value['username'] . '","' . $value['email'] . '","'. '00'.$value['register_time'].'000' . '","' . '00'.$value['register_time'].'000' . '"),';
			
		
			
			if ($c>=$max_c){
				$file_data = rtrim($file_data,',');
				$file_data2 = rtrim($file_data2,',');
				$rs = $this->insert($file_data,$file_data2);
				
				if (!$rs){
					$transaction1->rollback();
					$transaction2->rollback();
				}
				
				$file_data='';
				$file_data2='';
				$ic=0;
			}
			
			$ic++;
		
		}
		
		if (!empty($file_data) || !empty($file_data2)){
			$file_data = rtrim($file_data,',');
			$file_data2 = rtrim($file_data2,',');
			$rs = $this->insert($file_data, $file_data2);
			
			if (!$rs){
				$transaction1->rollback();
				$transaction2->rollback();
			}
		}
		
 		}
 		catch (Exception $e){
 			throw $e;
 			$transaction1->rollback();
			$transaction2->rollback();
 		}
        
		$transaction1->commit();
		$transaction2->commit();
		echo  '导入完成';
        
        
    }
    
    protected function insert($file_data,$file_data2){
    	
//    	var_dump($file_data);exit();
    	
    	$sql = 'INSERT INTO `tbuser` (`userId`, `userName`, `userPassword`, `signName`, `registerDate`, `userSex`, `userState`, `gaiNumber`, `mobile`, `salt`, `email`,`userNickname`,`apiKey`,`is_login_check`) VALUES '.$file_data;
		$sql2 = 'INSERT INTO `ofuser` (`username`, `plainPassword`, `encryptedPassword`, `name`, `email`, `creationDate`,`modificationDate`) VALUES '.$file_data2;
		
		$rs1 = Yii::app()->gxt_api->createCommand($sql)->execute();
		$rs2 = Yii::app()->gxt_xmpp->createCommand($sql2)->execute();
		$rs2 = Yii::app()->gxt_api->createCommand($sql2)->execute();
		
		return ($rs1 && $rs2)?true:false;
		
    }
	

}
