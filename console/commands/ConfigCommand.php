<?php

/**
 * @author lhao
 * 
 */
class ConfigCommand extends CConsoleCommand {

    public function actionUpdateData()
    {
        try {
            $hostdir = dirname(__FILE__);
            $configdir = $hostdir.DS.'..'.DS.'..'.DS.'common'.DS.'webConfig';
            $configFiles = scandir($configdir);
            $db = Yii::app()->db;
            if(empty($configFiles)) die('配置文件不能存在');
            $tableName = WebConfig::tableName();
            foreach ($configFiles as $fileName)
            {
                if(!preg_match('/config/', $fileName)) continue;
                $key = strstr($fileName, '.', true);
                $content =  file_get_contents($configdir.DS.$fileName);
                $content = base64_decode($content);
                
                $sql = 'select id from '.$tableName.' where name = "'.$key.'"';
                $id = $db->createCommand($sql)->queryScalar();
                if(!empty($id))
                {
                    continue;
                }
                $sql = "insert into ".$tableName." (`name`,`value`) value ('{$key}','{$content}')";
                $db->createCommand($sql)->execute();
            }
        echo '完成';
        }catch(Exception $e){
            echo $e->getMessage();
        }
        
    }
    
    


}