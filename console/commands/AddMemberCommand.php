<?php
/**
 * 导入对面会员
 * @author zhenjun_xu <412530435@qq.com>
 * Date: 2015/4/23 0023
 * Time: 10:02
 */

class AddMemberCommand extends CConsoleCommand {
    /**
     * 生成唯一的会员编号 GW+8位数字
     * @return string
     */
    public static function generateGaiNumber()
    {
        $number = str_pad(mt_rand('1', '99999999'), 8, mt_rand(99999, 999999));
        return 'GW' . $number;
    }
    /**
     * 生成唯一的会员编号 GW+8位数字
     * @return string
     */
    public static function getGW()
    {
        $number = str_pad(mt_rand('1', '99999999'), 8, mt_rand(99999, 999999));
        if (Member::model()->exists('gai_number="GW' . $number . '"')) {
            return self::getGW();
        }
        return 'GW' . $number;
    }

    /**
     * 找出重复的gw，重新生成
     */
    public function actionGw(){
        $sql = 'SELECT
	`t1`.*
FROM
	`gw_member` AS t1,
	(
		SELECT
			id,
			`gai_number`
		FROM
			`gw_member`
		GROUP BY
			`gai_number`
		HAVING
			COUNT(1) > 1
	) AS `t2`
WHERE
	`t1`.`gai_number` = `t2`.`gai_number`
AND register_type = 6
AND salt=\'123456b874ea6eae443cb81e9e654321\'
ORDER BY id';
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        foreach($data as $k=>$v){
            Yii::app()->db->createCommand()->update('gw_member',array('gai_number'=>self::getGW()),'id='.$v['id']);
            echo $k,"\n\r";
        }
    }

    public function actionIndex()
    {
//        @ini_set('memory_limit', '1280M');
        set_time_limit(0);
        $db = Yii::app()->db;
        $sql = 'select * from tbl_member_test';
        $command = $db->createCommand($sql);
        $dataReader = $command->query();
        // 重复调用 read() 直到它返回 false
        $i=0;
        while (($data = $dataReader->read()) !== false) {
            $result = $db->createCommand("select id from gw_member where mobile='".$data['mobile']."'")->queryRow();
            if($result) continue;
            $gw = self::generateGaiNumber();
            $reg_time = rand(1425168001,1426950001);
            $salt = '701df7b874ea6eae443cb81e9e069735';
            $password = '$2a$13$8NkAZfvTKzZnRjOyYEvE4OC0lwPI3n3o.ARnZL2.9aLMqbbXGLUVW';
            $sex = $data['sex']=='female'?2:1;
            $birthday = strtotime(str_replace(' ','-',trim(mb_substr($data['birthday'],0,-4,'utf-8'))));
            $sql = "INSERT INTO `gw_member` (
	`logins`,
	`signins`,
	`grade_points`,
	`gai_number`,
	`referrals_id`,
	`username`,
	`password`,
	`salt`,
	`sex`,
	`real_name`,
	`type_id`,
	`grade_id`,
	`password2`,
	`password3`,
	`birthday`,
	`email`,
	`mobile`,
	`country_id`,
	`province_id`,
	`city_id`,
	`district_id`,
	`street`,
	`register_time`,
	`register_type`,
	`head_portrait`,
	`status`,
	`is_internal`,
	`is_master_account`,
	`identity_type`,
	`identity_number`,
	`last_login_time`,
	`current_login_time`,
	`nickname`,
	`member_type`,
	`card_num`,
	`area_code`,
	`role`,
	`enterprise_id`,
	`referrals_time`,
	`flag`,
	`activation_time`
)
VALUES
	(
		'".rand(1,30)."',
		'0',
		'0',
		'".$gw."',
		'0',
		'',
		'".$password."',
		'".$salt."',
		'".$sex."',
		'',
		'1',
		'0',
		'".$password."',
		'".$password."',
		'".$birthday."',
		'',
		'".$data['mobile']."',
		'0',
		'0',
		'0',
		'0',
		'',
		'".$reg_time."',
		'6',
		'',
		'0',
		'0',
		'0',
		'0',
		'',
		'0',
		'".($reg_time+3600*24*20)."',
		'',
		'0',
		'',
		'0',
		'0',
		'0',
		'0',
		'1',
		'0'
	);
";
            $db->createCommand($sql)->execute();
            $memberId = $db->getLastInsertID();
            $sql2 = "INSERT INTO `gw_third_login` (`member_id`, `third_id`, `type`, `create_time`) VALUES ('".$memberId."', '".$data['openid']."', '0', '".time()."');";
            $db->createCommand($sql2)->execute();
            $i++;
            echo $data['mobile'],"-".$i, "\n\r";
        }
    }

    /**
     * 第二次导入会员
     */
    public function actionIndex2(){
        @ini_set('memory_limit', '1280M');
        set_time_limit(0);
        $handle = fopen(Yii::app()->basePath.'/data/addMember.csv',"r");
        $db = Yii::app()->db;
        $i=0;
        while ($data = fgetcsv($handle, 1000, ",")) {
            $result = $db->createCommand("select id from gw_member where mobile='".$data[0]."'")->queryRow();
            if($result){
                echo $data[0] ,"-error \r\n";
                continue;
            }
            $gw = self::getGW();
            $reg_time = strtotime($data[2]);
            $salt = '123456b874ea6eae443cb81e9e654321';
            $password = '';
            $sex = $data['1']=='female'?2:1;
            $birthday = '';
            $sql = "INSERT INTO `gw_member` (
	`logins`,
	`signins`,
	`grade_points`,
	`gai_number`,
	`referrals_id`,
	`username`,
	`password`,
	`salt`,
	`sex`,
	`real_name`,
	`type_id`,
	`grade_id`,
	`password2`,
	`password3`,
	`birthday`,
	`email`,
	`mobile`,
	`country_id`,
	`province_id`,
	`city_id`,
	`district_id`,
	`street`,
	`register_time`,
	`register_type`,
	`head_portrait`,
	`status`,
	`is_internal`,
	`is_master_account`,
	`identity_type`,
	`identity_number`,
	`last_login_time`,
	`current_login_time`,
	`nickname`,
	`member_type`,
	`card_num`,
	`area_code`,
	`role`,
	`enterprise_id`,
	`referrals_time`,
	`flag`,
	`activation_time`
)
VALUES
	(
		'".rand(1,30)."',
		'0',
		'0',
		'".$gw."',
		'0',
		'',
		'".$password."',
		'".$salt."',
		'".$sex."',
		'',
		'1',
		'0',
		'".$password."',
		'".$password."',
		'".$birthday."',
		'',
		'".$data[0]."',
		'0',
		'0',
		'0',
		'0',
		'',
		'".$reg_time."',
		'6',
		'',
		'0',
		'0',
		'0',
		'0',
		'',
		'0',
		'".($reg_time+3600*24*20)."',
		'',
		'0',
		'',
		'0',
		'0',
		'0',
		'0',
		'1',
		'0'
	);
";
            $db->createCommand($sql)->execute();
            $i++;
            echo $data[0],"-".$i, "\n\r";
        }
        fclose($handle);
    }

}