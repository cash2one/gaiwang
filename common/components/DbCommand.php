<?php

/**
 * 读写分离，Query Builder
 * @author zhenjun_xu <412530435@qq.com>
 */
class DbCommand extends CDbCommand {
    /**
     * 手动设置从库
     */
    const DB = 'gaiwang_slave';

    /** @var  DbConnection  */
    public $connection;

    public function __construct(CDbConnection $connection, $query = null) {
        $this->connection = $connection;
        parent::__construct($connection, $query);
    }

    public function getConnection() {
        $sql = parent::getText();
        if ($this->connection->enableSlave && !empty($this->connection->slaves) && is_string($sql) && !$this->connection->getCurrentTransaction() && DbConnection::isReadOperation($sql) && ($slave = $this->connection->getSlave())) {
            $this->connection = $slave;
        } else {
            if (!$this->connection->masterRead) {
                if ($this->connection->disableWrite && !DbConnection::isReadOperation($sql)) {
                    throw new CDbException("Master db server is not available now!Disallow write operation on slave server!");
                }
            }
        }
        return $this->connection;
    }

}
