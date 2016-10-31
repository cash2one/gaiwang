<?php

/**
 * 测试用脚本文件
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class TestCommand extends CConsoleCommand
{

    public function actionIndex()
    {
        GWRedisList::sendSmsGT(array(
            'mobile' => 18825129873, 'content' => '这是短信内容', 'id' => 1
        ));
//        $sql = 'SELECT * FROM {{user}}';
//        $models = Yii::app()->db->createCommand($sql)->queryAll();
//
//        foreach ($models as $model)
//            echo $model['username'] . "\n";

//        echo 'root : ' . Yii::getPathOfAlias('root') . "\n";
//        echo 'common : ' . Yii::getPathOfAlias('common') . "\n";
//        echo 'comext : ' . Yii::getPathOfAlias('comext') . "\n";
//        echo 'uploads : ' . Yii::getPathOfAlias('uploads') . "\n";
    }

    /**
     * 统计更新商品评分平均分和评论数
     */
//    public function actionUpdateGoodsAvgScore(){
//        $s_time = time(); //开始时间
//        $goods = array();
//        $command = Yii::app()->db->createCommand("select id,goods_id,score from {{comment}}");
//        $command->execute();
//        $reader = $command->query();
//        foreach($reader as $row){
//            @$goods[$row['goods_id']]['score'] += $row['score'];
//            @$goods[$row['goods_id']]['num'] += 1;
//        }
//        $i = 1;
//        foreach ($goods as $gid => $val){
//            $avgScore = bcdiv($val['score'] ,$val['num'], 1);
//            $i++;
//            echo $gid.' - '.$avgScore.' '.$val['num']."\r\n";
//            Yii::app()->db->createCommand()->update('{{goods}}',array('avg_score'=>$avgScore,'comments'=>$val['num']),'id="'.$gid.'"');
//        }
//        echo 'update '.$i.', use '.(time() - $s_time);
//    }


    /**
     * 统计更新酒店评分平均分和评论数
     */
//    public function actionUpdateHotelAvgScore(){
//        $s_time = time(); //开始时间
//        $hotel = array();
//        // 完成 且 已评论
//        $command = Yii::app()->db->createCommand("select id,hotel_id,score from {{hotel_order}} where `status`=3 and comment_time>0 and comment<>''");
//        $command->execute();
//        $reader = $command->query();
//        foreach($reader as $row){
//            @$hotel[$row['hotel_id']]['score'] += $row['score'];
//            @$hotel[$row['hotel_id']]['num'] += 1;
//        }
//        $i = 1;
//        foreach ($hotel as $hid => $val){
//            $avgScore = bcdiv($val['score'] ,$val['num'], 1);
//            $i++;
//            echo $hid.' - '.$avgScore.' '.$val['num']."\r\n";
//            Yii::app()->db->createCommand()->update('{{hotel}}',array('avg_score'=>$avgScore,'comments'=>$val['num']),'id="'.$hid.'"');
//        }
//        echo 'update '.$i.', use '.(time() - $s_time);
//    }
    /**
     * 更新省市坐标
     */
    public function actionUpdateRegion()
    {
        $s_time = time(); //开始时间
        $i = 0;
        $file = dirname(dirname(__FILE__)) . DS . 'extensions' . DS . 'zuobiao.php';
        $arr = @include_once $file;
        echo $file . "\r\n";
        if ($arr) {
            echo "include file.\r\n";
            foreach ($arr as $k => $v) {
                if ($v['name'] && $v['lng'] && $v['lat']) {
                    Yii::app()->db->createCommand()->update('{{region}}', array('lng' => $v['lng'], 'lat' => $v['lat']), 'name="' . $v['name'] . '" and (lng < 1 or lat < 1)');
                    $i++;
                    echo $v['lng'] . ', ' . $v['lat'] . "\r\n";
                }
            }
        }
        echo 'update ' . $i . ', use ' . (time() - $s_time);
    }


    public function actionTest()
    {
        $dir = dirname(dirname(__FILE__)) . DS . 'extensions';
        $file = $dir.DS.'province-city.csv';
        $c = file_get_contents($file);
        $co = explode("\n", $c);
        foreach ($co as $v) {
            $str = explode(',', $v);
//            echo $str[2]."<br/>";die;
            if (count($str) > 4) {
                //查询自身数据
                $se = Yii::app()->db->createCommand()
                    ->select('a.name,a.parent_id,a.id,b.name AS pname,a.lng,a.lat')
                    ->from('{{region}} a')
                    ->leftJoin('{{region}} b', 'b.id = a.parent_id')
                    ->where('a.name=:name', array(':name' => $str[2]))->queryAll();
                foreach ($se as $va) {
                    if (($str[0] == $va['pname'] && $str[2] == $va['name'] && $va['lng']=='0.0000000000' && $va['lat'] == '0.0000000000') || ($str[1] == $va['pname'] && $str[2] == $va['name'] && $va['lng']=='0.0000000000' && $va['lat'] == '0.0000000000')) {
                        //更新数据
                        Yii::app()->db->createCommand()
                            ->update('{{region}}', array('lng' => $str[3], 'lat' => $str[4]), 'id=:id', array(':id' => $va['id']));

                    }
                }
            }
        }
        echo "Import ok<\n>";
    }
}