<?php

/**
 * 向表region插入alias数据
 * @author ling.wu <ling.wu@gatewang.com>
 */
class InsertRegionAliasCommand extends CConsoleCommand {

    /**
     * 向表region插入alias数据     
     */
    public function actionInsert() {
        $dataDir = getcwd() . DS . "console" . DS . "data" . DS;
        $file = $dataDir . 'gw_region.csv';
        if (!file_exists($file)) {
            echo 'The file does not exist';
            die();
        }
        $arr = array();
        try {
            $arr = file($file);
        } catch (Exception $e) {
            echo 'Failed to read file';
            die();
        }

        //获取数据到数组
        $alias = array();
        foreach ($arr as $k => $v) {
            $tmp = explode(',', $v);
            if (isset($tmp[0]) && preg_match('/\d+/', $tmp[0]) && isset($tmp[3])) {
                $alias[$tmp[0]] = trim($tmp[3]);
            } else {
                continue;
            }
        }

        //检查是否存在，并插入
        $model = Region::model()->findAllByPk(array_keys($alias));
        $sql = "update {{region}} set alias =(case id  ";
        $rid = array();
        foreach ($model as $v) {
            $sql.=" when $v->id then '" . $alias[$v->id] . "'";
            $rid[] = $v->id;
        }
        $sql.=" end) where id in(" . implode(',', $rid) . ')';
        $n = Yii::app()->db->createCommand($sql)->execute();

        echo "$n update  success";
    }

}
