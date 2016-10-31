<?php

/**
 * 主数据库 写 从数据库（可多个）读
 * 实现主从数据库 读写分离 主服务器无法连接 从服务器可切换写功能
 * 从务器无法连接 主服务器可切换读功
 * by lmt
 * */
class DbConnection extends CDbConnection {

    public $timeout = 10; //连接超时时间
    public $markDeadSeconds = 600; //如果从数据库连接失败 600秒内不再连接 
    //用 cache 作为缓存全局标记
    public $cacheID = 'sessionCache';
    public $trySeconds = 2;

    /**
     * @var array $slaves.Slave database connection(Read) config array.
     * 配置符合 CDbConnection.
     * @example
     * 'components'=>array(
     * 		'db'=>array(
     * 			'connectionString'=>'mysql://<master>',
     * 			'slaves'=>array(
     * 				array('connectionString'=>'mysql://<slave01>'),
     * 				array('connectionString'=>'mysql://<slave02>'),
     * 			)
     * 		)
     * )
     * */
    public $slaves = array();

    /**
     * 
     * 从数据库状态 false 则只用主数据库
     * @var bool $enableSlave
     * */
    public $enableSlave = true;

    /**
     * @var bool 紧急情况主数据库无法连接 切换从服务器（读写）.
     */
    public $slavesWrite = false;

    /**
     * @var bool 紧急情况从主数据库无法连接 切换从主服务器（读写）.
     */
    public $masterRead = false;

    /**
     * @var CDbCommand
     */
    private $_slave;

    /**
     * @var bool 从服务器（只读）.
     */
    public $disableWrite = true;

    /**
     * 重写 createCommand 方法,1.开启从库 2.存在从库 3.当前不处于一个事务中 4.从库读数据
     * @param string|array $sql
     * @return CDbCommand|DbCommand
     * @throws CDbException
     */
    public function createCommand($sql = null) {
        if ($this->enableSlave && !empty($this->slaves) && is_string($sql) && !$this->getCurrentTransaction() && self::isReadOperation($sql) && ($slave = $this->getSlave())) {
            return $slave->createCommand($sql);
        } else if ($sql == null || is_array($sql)) {
            return new DbCommand($this, $sql);
        } else {
            if (!$this->masterRead) {
                if ($this->disableWrite && !self::isReadOperation($sql)) {
                    throw new CDbException("Master db server is not available now!Disallow write operation on slave server!");
                }
            }
            return parent::createCommand($sql);
        }
    }

    /**
     * 获得从服务器连接资源
     * @return CDbConnection
     * */
    public function getSlave() {
        if (!isset($this->_slave)) {
            shuffle($this->slaves);
            foreach ($this->slaves as $slaveConfig) {
                if ($this->_isDeadServer($slaveConfig['connectionString'])) {
                    continue;
                }
                if (!isset($slaveConfig['class']))
                    $slaveConfig['class'] = 'CDbConnection';

                $slaveConfig['autoConnect'] = false;
                try {
                    if ($slave = Yii::createComponent($slaveConfig)) {
                        Yii::app()->setComponent('dbslave', $slave);
                        $slave->setAttribute(PDO::ATTR_TIMEOUT, $this->timeout);
                        $slave->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
                        $slave->setActive(true);
                        $this->_slave = $slave;
                        break;
                    }
                } catch (Exception $e) {
                    $this->_markDeadServer($slaveConfig['connectionString']);
                    Yii::log("Slave database connection failed!\n\tConnection string:{$slaveConfig['connectionString']}", 'warning');
                    continue;
                }
            }
            if (!isset($this->_slave)) {
                $this->_slave = null;
                $this->enableSlave = false;
            }
        }
        return $this->_slave;
    }

    public function setActive($value) {
        if ($value != $this->getActive()) {
            if ($value) {
                try {
                    if ($this->_isDeadServer($this->connectionString)) {
                        throw new CDbException('Master db server is already dead!');
                    }
                    //PDO::ATTR_TIMEOUT must set before pdo instance create
                    $this->setAttribute(PDO::ATTR_TIMEOUT, $this->timeout);
                    $this->open();
                } catch (Exception $e) {
                    $this->_markDeadServer($this->connectionString);
                    $slave = $this->getSlave();
                    if($this->filterDeadLog($e->getMessage())){
                        Yii::log($e->getMessage(), CLogger::LEVEL_ERROR, 'exception.CDbException');
                    }
                    if ($slave) {
                        $this->connectionString = $slave->connectionString;
                        $this->username = $slave->username;
                        $this->password = $slave->password;
                        if ($this->slavesWrite) {
                            $this->disableWrite = false;
                        }
                        $this->open();
                    } else { //Slave also unavailable
                        if ($this->masterRead) {
                            $this->connectionString = $this->connectionString;
                            $this->username = $this->username;
                            $this->password = $this->password;
                            $this->open();
                        } else {
                            throw new CDbException(Yii::t('yii', 'CDbConnection failed to open the DB connection.'), (int) $e->getCode(), $e->errorInfo);
                        }
                    }
                }
            } else {
                $this->close();
            }
        }
    }

    /**
     * 检测读操作 sql 语句
     * 
     * 关键字： SELECT,DECRIBE,SHOW ...
     * 写操作:UPDATE,INSERT,DELETE ...
     * */
    public static function isReadOperation($sql) {
        $sql = substr(ltrim($sql), 0, 10);
        $sql = str_ireplace(array('SELECT', 'SHOW', 'DESCRIBE', 'PRAGMA'), '^O^', $sql); //^O^,magic smile
        return strpos($sql, '^O^') === 0;
    }

    /**
     * 检测从服务器是否被标记 失败.
     */
    private function _isDeadServer($c) {
        $cache = Yii::app()->{$this->cacheID};
        if ($cache && $cache->get('gxDeadServer::' . $c) > 1) {
            //如果缓存超时返回false,不提示错误
			if((time() - $cache->get('gxDeadServer::' . $c)) > $this->markDeadSeconds){
				return false;
			}
            return true;
        }
        return false;
    }

    /**
     * 标记失败的slaves.
     */
    private function _markDeadServer($c) {
        $cache = Yii::app()->{$this->cacheID};
        if ($cache) {
            // 缓存超时1秒后重新标记,另一层含义是重新尝试1秒
            $err_time = $cache->get('gxDeadServer::' . $c);
            if((time() - $err_time) > ($this->markDeadSeconds + $this->trySeconds))
                $cache->set('gxDeadServer::' . $c, time(), $this->markDeadSeconds);
        }
    }

    /**
     * 过滤限制db dead提示频率
     * @param $message
     * @return bool
     */
    private function filterDeadLog($message){
        $c = $this->connectionString;
        $cache = Yii::app()->{$this->cacheID};
        $err_time = $cache->get('gxDeadServer::' . $c);
        //只记录1秒内的提示
        if('Master db server is already dead!' == $message && time()-$err_time >= 1){
            return false;
        }
        return true;
    }
}
