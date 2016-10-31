<?php
/**
 * 测试控制器
 * 专用
 */
class TestController extends Controller{
    
    public function actionIndex(){
//        $str = 'PayNo=600012&RespCode=00&CurrCode=CNY&OrderNo=82015120410560106887&SignMsg=4b2f9a4759434f25c3a04b33a6b51653&Reserved01=1XXX20151204105541416884XXX2130706433XXXGW62650788&PayAmount=1.00&SystemSSN=002652002652&SettDate=1204&Reserved02=';
//        parse_str($str,$arr);
//        echo '<pre>';
//        print_r($arr);
//        echo '<pre/>';
//        $http = new HttpClient('');
//        print_r($http->quickPost('http://www.newgatewang.com/result/unionpay', $arr));
//        echo $this->createAbsoluteUrl('member/quickPay/sendMsg').'<br/>';
//        echo $this->createUrl('/member/quickPay/sendMsg');
    }
    
    
    public function actionLog(){
        $post = $_POST;
        if(empty($post)) exit('bad request');
        $post = serialize($post);
        $time = time();
        $sql = "INSERT INTO gw_ght_data (`post_data`,`time`) VALUES ('{$post}',{$time})";
        Yii::app()->db->createCommand($sql)->execute();
    }
    
    public function actionList(){
        $sql = 'select * from gw_ght_data ORDER BY id desc LIMIT 10';
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        if(is_array($result)){
            $table = '<table><thead><tr><td>值</td><td>时间</td></tr></thead><tbody>';
            foreach($result as $s){
                $post = unserialize($s['post_data']);
                $post = var_export($post,true);
                $table = $table . "<tr><td>{$post}</td><td>{$s['time']}</td></tr>";
            }
            $table = $table . '</tbody></table>';
        }
        echo $table; 
    }
}