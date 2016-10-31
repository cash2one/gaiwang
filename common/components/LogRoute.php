<?php
/**
 * LogRoute class file.
 *
 * @author qinghao.ye <qinghaoye@sina.com>
 */

class LogRoute extends CLogRoute
{

    public $connectionID;

    public $logTableName='YiiLog';

    public $autoCreateLogTable=true;

    private $_db;

    /**
     * Initializes the route.
     * This method is invoked after the route is created by the route manager.
     */
    public function init()
    {
        parent::init();

        if($this->autoCreateLogTable)
        {
            $db=$this->getDbConnection();
            try
            {
                $db->createCommand()->delete($this->logTableName,'0=1');
            }
            catch(Exception $e)
            {
                $this->createLogTable($db,$this->logTableName);
            }
        }
    }

    /**
     * Creates the DB table for storing log messages.
     * @param CDbConnection $db the database connection
     * @param string $tableName the name of the table to be created
     */
    protected function createLogTable($db,$tableName)
    {
        $db->createCommand()->createTable($tableName, array(
            'id'=>'pk',
            'level'=>'varchar(128)',
            'category'=>'varchar(128)',
            'logtime'=>'integer',
            'message'=>'text',
        ),'DEFAULT CHARSET=utf8');
    }

    /**
     * @return CDbConnection the DB connection instance
     * @throws CException if {@link connectionID} does not point to a valid application component.
     */
    protected function getDbConnection()
    {
        if($this->_db!==null)
            return $this->_db;
        elseif(($id=$this->connectionID)!==null)
        {
            if(($this->_db=Yii::app()->getComponent($id)) instanceof CDbConnection)
                return $this->_db;
            else
                throw new CException(Yii::t('yii','CDbLogRoute.connectionID "{id}" does not point to a valid CDbConnection application component.',
                    array('{id}'=>$id)));
        }
        else
        {
            $dbFile=Yii::app()->getRuntimePath().DIRECTORY_SEPARATOR.'log-'.Yii::getVersion().'.db';
            return $this->_db=new CDbConnection('sqlite:'.$dbFile);
        }
    }

    /**
     * Stores log messages into database.
     * @param array $logs list of log messages
     */
    protected function processLogs($logs)
    {
        $command=$this->getDbConnection()->createCommand();
        foreach($logs as $log)
        {
            if(strpos($log[0],'thumb_cache') !== false
                || strpos($log[0],'mfavicon.ico') !== false
                || strpos($log[0],'favicon.ico') !== false
                || strpos($log[0],'alicdn.com') !== false
                || strpos($log[0],'search/view') !== false
                || strpos($log[0],'没有找到相关商品') !== false
                || strpos($log[0],'robots.txt') !== false
                || strpos($log[0],'商品不存在') !== false
                || strpos($log[0],'系统无法找到请求的') !== false
                || strpos($log[0],'无法解析请求') !== false
            ){
                continue;
            }
            $command->insert($this->logTableName,array(
                'level'=>$log[1],
                'category'=>$log[2],
                'logtime'=>(int)$log[3],
                'message'=>$log[0],
            ));
        }
    }
}
