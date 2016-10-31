<?php

/**
 * 商品，酒店评分统计脚本
 * @author huabin_hong <huabin.hong@gwitdepartment.com>
 */
class ScoreCommand extends CConsoleCommand {

    public function actionExecute() {
        $this->goodsAvgScore();
        $this->hotelAvgScore();
    }

    /**
     * 统计更新商品评分平均分和评论数
     */
    public function goodsAvgScore() {
        $s_time = time(); //开始时间
        $goods = array();
        $command = Yii::app()->db->createCommand("select id,goods_id,score from {{comment}}");
        $command->execute();
        $reader = $command->query();
        foreach ($reader as $row) {
            @$goods[$row['goods_id']]['score'] += $row['score'];
            @$goods[$row['goods_id']]['num'] += 1;
        }
        $i = 1;
        foreach ($goods as $gid => $val) {
            $avgScore = bcdiv($val['score'], $val['num'], 1);
            $i++;
            echo $gid . ' - ' . $avgScore . ' ' . $val['num'] . "\r\n";
            Yii::app()->db->createCommand()->update('{{goods}}', array('avg_score' => $avgScore, 'comments' => $val['num']), 'id="' . $gid . '"');
        }
        echo 'update ' . $i . ', use ' . (time() - $s_time);
    }

    /**
     * 统计更新酒店评分平均分和评论数
     */
    public function hotelAvgScore() {
        $s_time = time(); //开始时间
        $hotel = array();
        // 完成 且 已评论
        $command = Yii::app()->db->createCommand("select id,hotel_id,score from {{hotel_order}} where `status`=3 and comment_time>0 and comment<>''");
        $command->execute();
        $reader = $command->query();
        foreach ($reader as $row) {
            @$hotel[$row['hotel_id']]['score'] += $row['score'];
            @$hotel[$row['hotel_id']]['num'] += 1;
        }
        $i = 1;
        foreach ($hotel as $hid => $val) {
            $avgScore = bcdiv($val['score'], $val['num'], 1);
            $i++;
            echo $hid . ' - ' . $avgScore . ' ' . $val['num'] . "\r\n";
            Yii::app()->db->createCommand()->update('{{hotel}}', array('avg_score' => $avgScore, 'comments' => $val['num']), 'id="' . $hid . '"');
        }
        echo 'update ' . $i . ', use ' . (time() - $s_time);
    }

}
